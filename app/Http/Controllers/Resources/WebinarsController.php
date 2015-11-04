<?php

namespace App\Http\Controllers\Resources;

use App\Panelist;
use App\Setting;
use App\StreamingServer;
use App\User;
use App\SubscribersList;
use App\Smtp;
use App\EmailNotification;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\WebinarStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

use \App\Webinar;

class WebinarsController extends ResourceController
{
    public function __construct() {
        $this->middleware('user.customer');
        parent::__construct([]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $user = User::find($userId);
        $upcoming_webinars = $user->webinars()
            ->where('starts_on', '>', date("Y-m-d H:i:s"))
            ->orderBy('starts_on', 'desc')->paginate(10);
        $past_webinars =$user->webinars()
            ->where('starts_on', '<', date("Y-m-d H:i:s"))
            ->orderBy('starts_on', 'desc')->paginate(10);

        $timezone = $user->settings()->whereName('timezone')->first();
        if(!$timezone){
            $timezone = new Setting();
            $timezone->name = 'timezone';
            $timezone->value = '';
            $user->settings()->save($timezone);
        }
        $timezone = $timezone->value;

        return $this->view('partials.webinars.index', compact('upcoming_webinars','past_webinars', 'timezone'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view('partials.webinars.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WebinarStoreRequest $request,$userId)
    {
        $user_id = Auth::user()->id;
        $input = $request->input();


        $starts = trim(explode(',',$input['date_starts_on'])[1]) . ' ' . $input['time_starts_on'];
        $starts = Carbon::createFromFormat('d F Y h:i A', $starts)->toDateTimeString();
        $input['starts_on'] = $starts;

        $input['share'] = '';
        $input['streaming_server_code'] = '';

        $webinar = Webinar::create($input);
        $webinar->uuid = hashWebinar($webinar->id);

        foreach ($input['subscribers_lists'] as $listId) {
            $webinar->subscribers_lists()->attach($listId);
        }

        if(isset($input['excluded_subscribers_lists'])){
            foreach ($input['excluded_subscribers_lists'] as $listId) {
                $webinar->excluded_subscribers_lists()->attach($listId);
            }
        }

        if(isset($input['panelists'])){
            foreach ($input['panelists'] as $panelist) {
                $webinar->panelists()->attach($panelist);
            }
        }

        $webinar->save();
        if(isset($input["webinar_subscriber_list_name"])){
            $webinar_subscriber = [
                "name" => $input["webinar_subscriber_list_name"],
                "description" => $input["webinar_subscriber_list_description"],
                "user_id" => $user_id,
                "webinar_id" => $webinar->id
            ];

            $list = SubscribersList::create($webinar_subscriber);
            $webinar->signup_subscribers_lists()->attach($list->id);
        }
        \Auth::user()->webinars()->save($webinar);
        return redirect()->back()->with("status", "Webinar has been created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($uId,$webinarUUID)
    {
        $webinar = Webinar::where('uuid','=',$webinarUUID)->with('subscribers_lists')->first();
        return $this->view('partials.webinars.show', compact('webinar'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId,$webinarUUID)
    {
        $user = Auth::user();
        $webinar = Webinar::where('uuid','=',$webinarUUID)->with('subscribers_lists')->with('panelists')->first();
        $enabled_streaming_servers = StreamingServer::where('enabled', '=', 1)->get();
        $subscribersLists = $user->subscribers_lists()->where("webinar_id", "=", NULL)->get();
        $webinar_list = $webinar->webinar_subscriber_list()->first();
        $panelists = $webinar->panelists;
        $smtpList = Smtp::whereEnabled(1)->get();
        $emailNotifications = EmailNotification::all();
        return $this->view('partials.webinars.edit', compact('webinar', 'enabled_streaming_servers', 'panelists', 'webinar_list', 'smtpList', 'emailNotifications'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WebinarStoreRequest $request, $userId, $webinarId)
    {
        $webinar = Webinar::findOrFail($webinarId);

        $input = $request->input();

        if($input['streaming_server_id'] != 'custom'){
            $input['streaming_server_code'] = get_server_embed_code($input['streaming_server_id'], $webinar);
        }

        $webinar->fill($input);

        $starts = trim(explode(',',$input['date_starts_on'])[1]) . ' ' . $input['time_starts_on'];
        $starts = Carbon::createFromFormat('d F Y h:i A', $starts)->toDateTimeString();
        $webinar->starts_on = $starts;

        $webinar->subscribers_lists()->detach();

        foreach ($request->input('subscribers_lists') as $listId) {
            $webinar->subscribers_lists()->attach($listId);
        }

        $webinar->panelists()->detach();

        if(isset($input['panelists'])) {
            foreach ($input['panelists'] as $panelist) {
                $webinar->panelists()->attach($panelist);
            }
        }

        $webinar->excluded_subscribers_lists()->detach();

        if(isset($input['excluded_subscribers_lists'] )){
            foreach ($input['excluded_subscribers_lists'] as $listId) {
                $webinar->excluded_subscribers_lists()->attach($listId);
            }
        }

        $webinar->signup_subscribers_lists()->detach();
        if(isset($input['signup_subscribers'])){
            foreach($input['signup_subscribers'] as $listId){
                $webinar->signup_subscribers_lists()->attach($listId);
            }
        }

        $webinar->save();

        return redirect()->back()->with('status', "Webinar was updated successfully");
    }

    public function getClone($user_id, $webinar_id) {

        $user = User::find($user_id);
        $webinar = Webinar::where('uuid', '=', $webinar_id)->first();
        $enabled_streaming_servers = StreamingServer::where('enabled', '=', 1)->get();
        $subscribersLists = $user->subscribers_lists()->where("webinar_id", "=", NULL)->get();
        $webinar_list = $webinar->webinar_subscriber_list()->first();

        return $this->view('partials.webinars.clone', compact('webinar', 'enabled_streaming_servers',
            'subscribersLists', 'webinar_list','panelists'));

    }

    public function postClone(WebinarStoreRequest $request, $user_id, $webinar_id) {

        $sourceWebinar = Webinar::where('uuid', '=', $webinar_id)->first();
        $user = User::find($user_id);

        $input = $request->input();

        $starts = trim(explode(',',$input['date_starts_on'])[1]) . ' ' . $input['time_starts_on'];
        $starts = Carbon::createFromFormat('d F Y h:i A', $starts)->toDateTimeString();

        $input['starts_on'] = $starts;

        $cloneWebinar = Webinar::create($input);
        $cloneWebinar->uuid = hashWebinar($cloneWebinar->id);

        foreach ($input['subscribers_lists'] as $listId) {
            $cloneWebinar->subscribers_lists()->attach($listId);
        }

        if(isset($input['excluded_subscribers_lists'])){
            foreach ($input['excluded_subscribers_lists'] as $listId) {
                $cloneWebinar->excluded_subscribers_lists()->attach($listId);
            }
        }

        if(isset($input['panelists'])){
            foreach ($input['panelists'] as $panelist) {
                $cloneWebinar->panelists()->attach($panelist);
            }
        }

        if(isset($input['signup_subscribers'])){
            foreach($input['signup_subscribers'] as $listId){
                $cloneWebinar->signup_subscribers_lists()->attach($listId);
            }
        }

        $cloneWebinar->save();

        return redirect()->route('users.webinars.edit', [$user_id, $cloneWebinar->uuid]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function postEmailNotification(Request $request, $userId, $webinarUUId) {
        ini_set("max_execution_time", 0);

        $input = $request->all();
        $webinar = Webinar::whereId($webinarUUId)->first();
        $webinar_uuid = $webinar->uuid;
        $subscribers_lists = $webinar->subscribers_lists()->get();
        $webinar_signup_subscribers_lists = $webinar->signup_subscribers_lists()->get();
        $setting = Setting::whereName('custom_domain')->where('customer_id', '=', $userId)->first();
        if (!$setting) {
            return redirect()->back()->with("error", "Custom Domain is not Set.");
        }
        $custom_domain = $setting->value;
        $rules = [
            "subject" => "required",
            "content" => "required",
            "smtp_method" => "required",
            "send_type" => "required"
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->passes()) {
            $send_type = $input["send_type"];
            $input['customer_id'] = $userId;
            $input['smtp_setting_id'] = $input['smtp_method'];
            $smtp = Smtp::find($input['smtp_method']);
            if (!$smtp) {
                return redirect()->back()->with("error", "No SMTP Method Found");
            }
            unset($input['smtp_method']);
            if ($send_type == "now") {
                $input['send_date'] = Carbon::now();
                $input['minutes_before_webinar'] = NULL;
            } else if ($send_type == "minutes_before") {
                $minutes_before_webinar = $input['minutes_before_webinar'];
                $input['send_date'] = Carbon::parse($webinar->starts_on)->subMinutes($minutes_before_webinar);
                $input['minutes_before_webinar'] = $minutes_before_webinar;
            }
            $count_subscribers = 0;
            $input['webinar_id'] = $webinar->id;
            $email_notification = EmailNotification::create($input);
            $email_notification->uuid = hashCampaignEmail($email_notification->id);
            $email_notification->save();

            $subject = $input['subject'];
            $body = $input['content'];
            if ($send_type == "now") {
                // Send Instant Email
                config([
                    "mail.driver" => "smtp",
                    "mail.host" => $smtp->host,
                    "mail.port" => $smtp->port,
                    "mail.from.address" => $smtp->from_email,
                    "mail.from.name" => $smtp->from_name,
                    "mail.encryption" => $smtp->protocol,
                    "mail.username" => $smtp->username,
                    "mail.password" => $smtp->password
                ]);

                try {
                    // General Subscribers List
                    if ($subscribers_lists) {
                        foreach ($subscribers_lists as $subscriber_list) {
                            $subscribers = $subscriber_list->activeSubscribers()->get();
                            if (count($subscribers) > 0) {
                                $count_subscribers += count($subscribers); 
                                foreach ($subscribers as $subscriber) {
                                    $subscriber_hash = $subscriber->uuid;
                                    $subscriber_name = $subscriber->first_name . ' ' . $subscriber->last_name;
                                    $to_email = $subscriber->email;
                                    $webinar_url = "http://" . $custom_domain . "/webinar/" . $webinar_uuid . "/" . $subscriber_hash;
                                    $emailData = [
                                        'body' => $body,
                                        'subscriber_name' => $subscriber_name,
                                        'webinar_url' => $webinar_url
                                    ];

                                    //pr($emailData); die;
                                    Mail::send('emails.webinar_invite_email', $emailData, function ($message) use($subject, $to_email, $subscriber_name) {
                                        $message->subject($subject);
                                        $message->from('admin@example.com', 'Webinar Admin');
                                        $message->to($to_email, $subscriber_name);
                                    });
                                }
                            }
                        }
                    }

                    // Send Email to Webinar Specific Subscribers
                    if ($webinar_signup_subscribers_lists) {
                        foreach ($webinar_signup_subscribers_lists as $subscriber_list) {
                            $subscribers = $subscriber_list->activeSubscribers()->get();
                            if (count($subscribers) > 0) {
                                $count_subscribers += count($subscribers);
                                foreach ($subscribers as $subscriber) {
                                    $subscriber_hash = $subscriber->uuid;
                                    $subscriber_name = $subscriber->first_name . ' ' . $subscriber->last_name;
                                    $to_email = $subscriber->email;
                                    $webinar_url = "http://" . $custom_domain . "/webinar/" . $webinar_uuid . "/" . $subscriber_hash;
                                    $emailData = [
                                        'body' => $body,
                                        'subscriber_name' => $subscriber_name,
                                        'webinar_url' => $webinar_url
                                    ];

                                    Mail::send('emails.webinar_invite_email', $emailData, function ($message) use($subject, $to_email, $subscriber_name) {
                                        $message->subject($subject);
                                        $message->to($to_email, $subscriber_name);
                                    });
                                }
                            }
                        }
                    }

                    // Mail Sent Successfully
                    $email_notification->count_subscribers = $count_subscribers;
                    $email_notification->status = 1;
                    $email_notification->save();
                } catch (\Exception $e) {
                    // Error in Sending Mail
                    $email_notification->status = -1;
                    $email_notification->save();
                }
            }

            return redirect()->back()->with('status', "Email Notification updated successfully");
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

}

<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Webinar;
use App\Setting;
use App\Smtp;
use Auth;
use Illuminate\Support\Facades\Mail;
class EmailsController extends ResourceController
{
    function __construct() {
        $this->middleware('user.customer');
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($webinar_uuid)
    {
        $smtpList = Smtp::whereEnabled(1)->get();
        $webinar = decodeWebinar($webinar_uuid);
        $data = ['webinar' => $webinar, 'smtpList' => $smtpList];
        return $this->view('partials.emails.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $webinarId) {
        ini_set("max_execution_time", 0);
        try {
            $webinar = Webinar::find($webinarId);
            $webinar_uuid = hashWebinar($webinarId);
            $user_id = Auth::user()->id;
            $subscribers_lists = $webinar->subscribers_lists()->get();
            $webinar_signup_subscribers_lists = $webinar->signup_subscribers_lists()->get();
            $input = $request->all();
            if (count($subscribers_lists) > 0) {
                $subject = $input['subject'];
                $body = $input['content'];
                $smtp_method = $input['smtp_method'][0];
                $setting = Setting::whereName('custom_domain')->where('customer_id', '=', $user_id)->first();
                if(!$setting){
                    return redirect()->back()->with("error", "Custom Domain is not Set.");
                }
                $smtp = Smtp::find($smtp_method);
                if (!$smtp) {
                    return redirect()->back()->with("error", "No SMTP Method Found");
                }
                $custom_domain = $setting->value;
                
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

                // General Subscribers List 
                if ($subscribers_lists) {
                    foreach ($subscribers_lists as $subscriber_list) {
                        $subscribers = $subscriber_list->activeSubscribers()->get();
                        if (count($subscribers) > 0) {
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
                            foreach ($subscribers as $subscriber) {
                                echo $subscriber->id."<br/>";
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
            }
            return redirect()->back()->with("status", "Mail Sent Succesfully");
        } catch (\Exception $e) {
            
        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}

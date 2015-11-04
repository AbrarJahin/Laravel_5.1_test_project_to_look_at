<?php

namespace App\Http\Controllers\Resources;

use App\EmailNotification;
use App\NotificationTemplate;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Smtp;

class NotificationTemplatesController extends ResourceController {

    function __construct() {
        $this->middleware('user.customer');
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId) {
        $user = User::find($userId);
        $defaults = NotificationTemplate::whereUserId(0)->get();

        foreach ($defaults as $default) {

            $clone = $user->notificationTemplates()->whereDefaultId($default->id)->first();
            if(!$clone) {

                NotificationTemplate::create([
                    'subject' => $default->subject,
                    'content' => $default->content,
                    'default_id' => $default->id,
                    'user_id' => $user->id
                ]);

            }

        }

        $notifications = User::find($userId)->notificationTemplates()->paginate(10);

        return $this->view("partials.notification_templates.index", ['notifications' => $notifications, 'userId' => $userId]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userId) {

        return $this->view("partials.notification_templates.create", ['userId' => $userId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user_id = Auth::user()->id;
        $input = $request->all();

        NotificationTemplate::create([
            'subject' => $input['subject'],
            'content' =>$input['content'],
            'user_id' => $user_id
        ]);

        return redirect()->route('users.notification-templates.index',$user_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId, $templateId) {
        $template = NotificationTemplate::find($templateId);
        return $this->view("partials.notification_templates.edit", ['template' => $template]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId, $templateId) {
        $input = $request->all();

        $template = NotificationTemplate::find($templateId);

        $template->fill($input);
        $template->save();

        return redirect()->back()->with('status', 'Updated successfully!');

    }

    public function restoreDefaults($userId, $templateId) {

        $template = NotificationTemplate::find($templateId);

        $default = NotificationTemplate::find($template->default_id);

        $template->subject = $default->subject;
        $template->content = $default->content;

        $template->save();

        return redirect()->back()->with('status', 'Updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $templateId) {
        $not = NotificationTemplate::find($templateId);
        if ($not) {
            $not->delete();
        }
    }
}

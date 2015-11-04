<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Smtp;

class SmtpController extends ResourceController {

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
        $smtpList = Smtp::whereCustomerId($userId)->paginate(10);
        return $this->view("partials.smtp.index", ['smtpList' => $smtpList, 'userId' => $userId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($userId) {
        return $this->view("partials.smtp.create", ['userId' => $userId]);
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
        $rules = [
            "name" => "required",
            "host" => "required",
            "username" => "required",
            "password" => "required",
            "port" => "required",
            "protocol" => "required",
            "from_email" => "required|email",
            "from_name" => "required",
            "reply_email" => "required|email"
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->passes()) {
            $input['customer_id'] = $user_id;
            $enabled = 1;
            if(!isset($input['enabled'])){
                $enabled = 0;
            }
            $input['enabled'] = $enabled;
            Smtp::create($input);
            return redirect()->route('users.smtp.index', [$user_id])->with("status", "SMTP Server Updated successfully");
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
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
    public function edit($userId, $smtpId) {
        $smtp = Smtp::whereCustomerId($userId)->whereId($smtpId)->first();
        return $this->view("partials.smtp.edit", ['smtp' => $smtp]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userId, $smtpId) {
        $input = $request->all();
        $rules = [
            "name" => "required",
            "host" => "required",
            "username" => "required",
            "password" => "required",
            "port" => "required",
            "protocol" => "required",
            "from_email" => "required|email",
            "from_name" => "required",
            "reply_email" => "required|email"
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->passes()) {
            $smtp = Smtp::whereCustomerId($userId)->whereId($smtpId)->first();
            if ($smtp) {
                $smtp->name = $input["name"];
                $smtp->host = $input["host"];
                $smtp->username = $input["username"];
                $smtp->port = $input["port"];
                $smtp->protocol = $input["protocol"];
                $smtp->from_email = $input["from_email"];
                $smtp->from_name = $input["from_name"];
                $smtp->reply_email = $input["reply_email"];
                if(isset($input["enabled"])){
                    $smtp->enabled = 1;
                } else {
                    $smtp->enabled = 0;
                }
                
                $smtp->save();
            }
            return redirect()->route('users.smtp.index', [$userId])->with("status", "SMTP Server Updated successfully");
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $smtpId) {
        $smtp = Smtp::whereCustomerId($userId)->whereId($smtpId)->first();
        if ($smtp) {
            $smtp->delete();
        }
    }

    public function validateSmtp(Request $request) {
        if ($request->ajax()) {
            $user = Auth::user();
            $name = $user->name;
            $email = $user->email;
            $input = $request->all();
            $text_message = $input["message"];
            $host = $input["host"];
            $username = $input["username"];
            $password = $input["password"];
            $port = $input["port"];
            $protocol = $input["protocol"];
            $from_email = $input["from_email"];
            $from_name = $input["from_name"];
            $reply_email = $input["reply_email"];

            try {
                config([
                    "mail.driver" => "smtp",
                    "mail.host" => $host,
                    "mail.port" => $port,
                    "mail.from.address" => $from_email,
                    "mail.from.name" => $from_name,
                    "mail.encryption" => $protocol,
                    "mail.username" => $username,
                    "mail.password" => $password
                ]);
                
                Mail::raw($text_message, function($message)use($email, $name, $reply_email){
                    $message->subject("Test SMTP Email");
                    $message->replyTo($reply_email);
                    $message->to($email, $name);
                });
                $response = array("success" => true);
            } catch (\Exception $ex) {
                // Indicates Error in SMTP Config
                $response = array("success" => false);
            }
            
            echo json_encode($response);
        }
    }

}

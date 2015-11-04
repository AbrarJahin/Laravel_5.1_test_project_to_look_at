<?php

namespace App\Http\Controllers;
use App\Setting;
use App\User;
use App\Webinar;
use Auth;
use \Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MembersController extends CustomerLayoutController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        return $this->view('layouts.member.dashboard', []);
    }
    
    public function getWebinar($webinar_uuid)
    {
        $webinar = Webinar::where('uuid', '=', $webinar_uuid)->first();
        $streamingServer = $webinar->streaming_server;
        return $this->view('layouts.member.webinar', compact('webinar', 'streamingServer'));
    }

    public function add_question()
    {
        $current_time = Carbon::now();
        DB::table('qustions')->insert(
            [
                'webinar_id' => Request::input('webinar_id'),
                'email_id' => Request::input('email_id'),
                'question' => Request::input('question'),
                'answer' => Request::input('answer'),
                'panelist_id' => Request::input('panelist_id'),
                'public' => Request::input('public'),
                'created_at' => $current_time,
                'updated_at' => $current_time
            ]
        );
        return Request::input('question');
    }

    public function getSettings(Request $request)
    {
        $user = Auth::user();
        $custom_domain = $user->settings()->whereName('custom_domain')->first();
        $timezone = $user->settings()->whereName('timezone')->first();
        if(!$timezone){
            $timezone = new Setting();
            $timezone->name = 'timezone';
            $timezone->value = '';
            $user->settings()->save($timezone);
        }
        $timezone = $timezone->value;
        return $this->view('layouts.member.settings', compact('custom_domain', 'old_input', 'timezone'));
    }

    public function postSettings(Request $request) {
        $user = Auth::user();
        $input = $request->all();
        $validator = Validator::make($input, [
//            'custom_domain' => 'required'
        ]);
        
        if($validator->passes()){
            if(isset($input['custom_domain'])){
                $setting = $user->settings()->whereName('custom_domain')->first();
                if(!$setting){
                    $setting = new Setting();
                    $setting->name = 'custom_domain';
                    $setting->value = removeSchemaUrl($input['custom_domain']);
                    $user->settings()->save($setting);
                } else {
                    $setting->value = removeSchemaUrl($input['custom_domain']);
                    $setting->save();
                }
            }

            if(isset($input['timezone'])){
                $setting = $user->settings()->whereName('timezone')->first();
                if(!$setting){
                    $setting = new Setting();
                    $setting->name = 'timezone';
                    $setting->value = $input['timezone'];
                    $user->settings()->save($setting);
                } else {
                    $setting->value = $input['timezone'];
                    $setting->save();
                }
            }

            return redirect()->back()->with("status", "Settings updated successfully");
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }   
    }

    public function getUpdateProfile(){
        $user = Auth::user();
        return $this->view('layouts.member.update_profile', compact('user'));
    }
    
    public function postUpdateProfile(Request $request) {
        $user_id = Auth::user()->id;
        $input = $request->all();
        $validator = Validator::make($input, [
                    "name" => "required",
                    "email" => "required|email|unique:users,email," . $user_id,
                    'password' => "required|confirmed"

        ]);

        if($validator->passes()){
            // Update Profile
            $user = User::find($user_id);
            if($user){
                $user->fill($input);
                $user->password = bcrypt($input['password']);
                $user->save();
                
                Auth::setUser(Auth::user()->first());
                return redirect()->back()->with("status", "Profile updated successfully");
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    
    function postValidateWebinarDomain(Request $request){
        if($request->ajax()){
            $custom_domain = $request->input('custom_domain');
            $host = removeSchemaUrl($custom_domain);
            $ip_map = config('gtw.ip_map'); // This should be Ip address of members.gtwhero.kvdev.kvsocial.com
            $dns_config = config('gtw.dns_config');
            $google_dns_check = false;
            $level3_dns_check = false;
            $open_dns_check = false;
            
            foreach ($dns_config as $index => $dns_ip) {
                try {
                    $nslookup = 'nslookup ' . $host . ' ' . $dns_ip;
                    exec($nslookup, $output);
                    if (isset($output[3]) && isset($output[4])) {
                        $domain = trim(str_replace('Name:', '', $output[4]));
                        $ip = trim(str_replace('Address:', '', $output[5]));
                        if ($domain == $host && $ip == $ip_map) {
                            if ($index == 0) {
                                $google_dns_check = true;
                            } else if ($index == 1) {
                                $level3_dns_check = true;
                            } else if ($index == 2) {
                                $open_dns_check = true;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    
                }
            }

            echo json_encode(array('google_dns_check' => $google_dns_check, 'level3_dns_check' => $level3_dns_check, 'open_dns_check' => $open_dns_check));
        }
        
    }
}

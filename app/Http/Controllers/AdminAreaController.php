<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAreaController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDashboard()
    {
        return $this->view('layouts.admin.dashboard');
    }
    

    public function getSettings(Request $request){
        $user_id = Auth::user()->id;
        $custom_domain = Setting::whereName('custom_domain')->where('customer_id', '=', $user_id)->first();
        return $this->view('layouts.member.settings', compact('custom_domain', 'old_input'));
    }

    public function postSettings(Request $request) {
        $user_id = Auth::user()->id;
        $input = $request->all();
        $validator = Validator::make($input, [
            'custom_domain' => 'required'
        ]);

        if($validator->passes()){
            $data['customer_id'] = $user_id;
            $data['name'] = 'custom_domain';
            $data['value'] = removeSchemaUrl($input['custom_domain']);
            $setting = Setting::whereName('custom_domain')->where('customer_id', '=', $user_id)->first();
            if(!$setting){
                Setting::create($data);
            } else {
                $setting->value = $data['value'];
                $setting->save();
            }
            return redirect()->back()->with("status", "Settings updated successfully");
        } else {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function getUpdateProfile(){
        $customerDetails = Auth::user();
        return $this->view('layouts.member.update_profile', compact('customerDetails'));
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
                $user->name = $input['name'];
                $user->email = $input['email'];
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
                        $domain = trim(str_replace('Name:', '', $output[3]));
                        $ip = trim(str_replace('Address:', '', $output[4]));
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

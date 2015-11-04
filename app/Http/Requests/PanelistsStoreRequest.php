<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use \App\Panelist;

class PanelistsStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(\Illuminate\Http\Request $req)
    {
        
        $passwordRule = 'required|confirmed';
        if(\Route::currentRouteName() == "users.panelists.update" && 
                ((int)$req->input("password")) == 0 ) {
            $passwordRule = "";
        }

        $email = "required|email|unique:users";
        if(\Route::currentRouteName() == "users.panelists.update") {
            $panelist = Panelist::findOrFail($this->route('panelists'));
            $email = "required|email|unique:users,email,".$panelist->user_id;
        }

        return [
            'name' => 'required',
            'email' => $email,
            'password' => $passwordRule
        ];
    }
}

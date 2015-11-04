<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubscriberStoreRequest extends Request
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
    public function rules(\Illuminate\Http\Request $request)
    {

        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'status' => 'required',
            'email' => "required|email|unique_subscribers_list_email:".$request->route('subscribers_lists').",".$request->input('email').",".$request->route('subscribers'),
        ];
    }
}

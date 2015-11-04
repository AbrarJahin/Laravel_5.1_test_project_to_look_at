<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreUsersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => "required|email|unique:users,email,".$this->route('users'),
            'role_id' => 'required'
        ];
    }
}

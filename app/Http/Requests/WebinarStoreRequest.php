<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class WebinarStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(\Illuminate\Http\Request $request)
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'starts_on' => 'date',
            'ends_on' => 'date',
            'timezone' => 'required',
            'duration' => 'required',
            'subscribers_lists' => 'required'
        ];
    }
}

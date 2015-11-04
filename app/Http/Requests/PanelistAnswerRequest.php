<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PanelistAnswerRequest extends Request
{
    /**
     * If the panelist is a panelist for the webinar owner and the panelist is
     * authenticated only then approve.
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
    public function rules()
    {
        return [
            //
        ];
    }
}
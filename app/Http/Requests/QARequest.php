<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QARequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(\Illuminate\Http\Request $request)
    {
        $subscriber = decodeSubscriber($request->input('subscribers_hash'));
        $webinar = decodeWebinar($request->input('webinars_hash'));
        
        if($webinar == null || $subscriber == null) {
            return false;
        }

        foreach ($webinar->subscribers_lists()->get() as $subscriberList) {
            if($subscriberList->subscribers->contains($subscriber->id)) {
                return true;
            }
        }

        return false;
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

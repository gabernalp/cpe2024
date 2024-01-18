<?php

namespace App\Http\Requests;

use App\Models\UserAlert;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserAlertRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_alert_create');
    }

    public function rules()
    {
        return [
            'alert_text' => [
                'string',
                'required',
                'max:255',
            ],
            'alert_link' => [
                'string',
                'nullable',
                'max:191',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
        ];
    }
}

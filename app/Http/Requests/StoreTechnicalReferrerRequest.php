<?php

namespace App\Http\Requests;

use App\Models\TechnicalReferrer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTechnicalReferrerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('technical_referrer_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'link' => [
                'string',
                'nullable',
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-]*$/',
                'max:255',
            ],
        ];
    }
}

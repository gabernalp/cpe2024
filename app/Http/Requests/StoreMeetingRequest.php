<?php

namespace App\Http\Requests;

use App\Models\Meeting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMeetingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'description' => [
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
            ],
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'time' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'technical_referrers.*' => [
                'integer',
            ],
            'technical_referrers' => [
                'array',
            ],
            'otro_referente' => [
                'string',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'link' => [
                'string',
                'nullable',
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-\?]*$/',
                'max:191',
            ],
        ];
    }
}

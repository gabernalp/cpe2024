<?php

namespace App\Http\Requests;

use App\Models\BackgroundProcess;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBackgroundProcessRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('background_process_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:191',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
            ],
            'description' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
            ],
            'file' => [
                'array',
            ],
            'images' => [
                'array',
            ],
            'link' => [
                'string',
                'max:191',
                'nullable',
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-\?]*$/',
            ],
            'descripcion_especial' => [
                'string',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
                'nullable',
            ],
            'comments' => [
                'string',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
                'nullable',
            ],
        ];
    }
}

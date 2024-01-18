<?php

namespace App\Http\Requests;

use App\Models\Banner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBannerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('banner_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'max:191',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
            ],
            'image' => [
                'required',
            ],
            'link' => [
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-\?]*$/',
                'nullable',
                'max:191',
            ],        
        ];
    }
}

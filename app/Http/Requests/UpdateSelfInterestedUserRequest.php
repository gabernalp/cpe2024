<?php

namespace App\Http\Requests;

use App\Models\SelfInterestedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSelfInterestedUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
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
            'lastname' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'email' => [
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s\@]*$/',
                'max:191',

            ],
            'documenttype_id' => [
                'required',
                'integer',
            ],
            'document' => [
                'required',
                'min:1',
            ],
            'document_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'phone' => [
                'string',
                'nullable',
                'max:191',
            ],
            'education_background' => [
                'required',
            ],
            'modality' => [
                'required',
            ],
            'living_zone' => [
                'required',
            ],
            'courseshooks.*' => [
                'integer',
            ],
            'courseshooks' => [
                'array',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\SelfInterestedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSelfInterestedUserRequest extends FormRequest
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
                'max:255',

            ],
            'documenttype_id' => [
                'required',
                'integer',
            ],
            'document' => [
                'required',
                'min:1',
                'max:2147483647',
                'max:191',
            ],
            'document_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'phone' => [
                'string',
                'nullable',
                'max:13',
                'min:7',
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

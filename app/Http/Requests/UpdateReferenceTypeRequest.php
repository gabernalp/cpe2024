<?php

namespace App\Http\Requests;

use App\Models\ReferenceType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReferenceTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('reference_type_create');
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
            'code' => [
                'string',
                'nullable',
                'alpha_num',
                'max:191',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\Entity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEntityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('entity_create');
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
            'initials' => [
                'string',
                'required',
                'alpha_num',
                'max:191',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\ResourcesSubcategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateResourcesSubcategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('resources_subcategory_edit');
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
        ];
    }
}

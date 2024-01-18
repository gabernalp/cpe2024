<?php

namespace App\Http\Requests;

use App\Models\ResourcesCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreResourcesCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('resources_category_create');
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

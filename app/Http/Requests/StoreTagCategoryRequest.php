<?php

namespace App\Http\Requests;

use App\Models\TagCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTagCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tag_category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\TagCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateTagCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('tag_category_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
                'max:191',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
            ],
        ];
    }
}

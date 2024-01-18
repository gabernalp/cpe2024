<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreResourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('resource_create');
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
            'resourcescategory_id' => [
                'required',
                'integer',
            ],
            'resource_subcategories.*' => [
                'integer',
            ],
            'resource_subcategories' => [
                'array',
            ],
            'link' => [
                'string',
                'nullable',
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-]*$/',
                'max:255',
            ],
            'tag_categories.*' => [
                'integer',
            ],
            'tag_categories' => [
                'array',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
        ];
    }
}

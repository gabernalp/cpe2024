<?php

namespace App\Http\Requests;

use App\Models\Search;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSearchRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('search_edit');
    }

    public function rules()
    {
        return [
            'search_item' => [
                'string',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'resources.*' => [
                'integer',
            ],
            'resources' => [
                'array',
            ],
        ];
    }
}

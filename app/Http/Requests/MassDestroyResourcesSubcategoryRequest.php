<?php

namespace App\Http\Requests;

use App\Models\ResourcesSubcategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyResourcesSubcategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('resources_subcategory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:resources_subcategories,id',
        ];
    }
}

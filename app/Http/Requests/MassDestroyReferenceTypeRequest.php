<?php

namespace App\Http\Requests;

use App\Models\ReferenceType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReferenceTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reference_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:reference_types,id',
        ];
    }
}

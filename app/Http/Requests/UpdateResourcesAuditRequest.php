<?php

namespace App\Http\Requests;

use App\Models\ResourcesAudit;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateResourcesAuditRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('resources_audit_edit');
    }

    public function rules()
    {
        return [
            'ip' => [
                'string',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
        ];
    }
}

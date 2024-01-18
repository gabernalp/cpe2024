<?php

namespace App\Http\Requests;

use App\Models\TechnicalReferrer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTechnicalReferrerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('technical_referrer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:technical_referrers,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\SelfInterestedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySelfInterestedUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('self_interested_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:self_interested_users,id',
        ];
    }
}

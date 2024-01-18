<?php

namespace App\Http\Requests;

use App\Models\CoursesUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCoursesUserRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('courses_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:courses_users,id',
        ];
    }
}

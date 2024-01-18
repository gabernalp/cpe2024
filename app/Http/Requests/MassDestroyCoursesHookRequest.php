<?php

namespace App\Http\Requests;

use App\Models\CoursesHook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCoursesHookRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('courses_hook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:courses_hooks,id',
        ];
    }
}

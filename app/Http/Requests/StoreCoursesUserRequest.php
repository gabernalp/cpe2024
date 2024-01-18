<?php

namespace App\Http\Requests;

use App\Models\CoursesUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCoursesUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('courses_user_create');
    }

    public function rules()
    {
        return [
            'additional_link' => [
                'string',
                'nullable',
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-\?]*$/',
                'max:255',
            ],
        ];
    }
}

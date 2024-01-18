<?php

namespace App\Http\Requests;

use App\Models\Course;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'goal' => [
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
            ],
            'mensaje_cierre' => [
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
            ],     
            'additional_comments' => [
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
            ],              
        ];
    }
}

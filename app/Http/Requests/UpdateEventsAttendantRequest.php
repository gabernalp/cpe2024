<?php

namespace App\Http\Requests;

use App\Models\EventsAttendant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEventsAttendantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('events_attendant_create');
    }

    public function rules()
    {
        return [
            'event_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'last_name' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'documenttype' => [
                'string',
                'required',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'document' => [
                'string',
                'required',
                'alpha_num',
                'max:191',
            ],
            'department_id' => [
                'required',
                'integer',
            ],
            'phone' => [
                'string',
                'nullable',
                'alpha_num',
                'max:191',
            ],
            'email' => [
                'string',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s\@]*$/',
                'max:191',
            ],
        ];
    }
}

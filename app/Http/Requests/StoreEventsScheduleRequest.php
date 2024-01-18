<?php

namespace App\Http\Requests;

use App\Models\EventsSchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEventsScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('events_schedule_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',
                'max:191',
            ],
            'description' => [
                'required',
            ],
            'date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'link' => [
                'string',
                'nullable',
                'regex:/^[a-zA-Z0-9,\.\:\%\s\&\=\/\_\-\?]*$/',
                'max:191',
            ],
        ];
    }
}

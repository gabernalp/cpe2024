<?php

namespace App\Http\Requests;

use App\Models\EventsSchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEventsScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('events_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:events_schedules,id',
        ];
    }
}

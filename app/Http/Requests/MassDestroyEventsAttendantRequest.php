<?php

namespace App\Http\Requests;

use App\Models\EventsAttendant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEventsAttendantRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('events_attendant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:events_attendants,id',
        ];
    }
}

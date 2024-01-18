<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeetingAttendantRequest;
use App\Http\Requests\UpdateMeetingAttendantRequest;
use App\Http\Resources\Admin\MeetingAttendantResource;
use App\Models\MeetingAttendant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingAttendantsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('meeting_attendant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MeetingAttendantResource(MeetingAttendant::with(['meeting', 'user'])->get());
    }

    public function store(StoreMeetingAttendantRequest $request)
    {
        $meetingAttendant = MeetingAttendant::create($request->all());

        return (new MeetingAttendantResource($meetingAttendant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MeetingAttendantResource($meetingAttendant->load(['meeting', 'user']));
    }

    public function update(UpdateMeetingAttendantRequest $request, MeetingAttendant $meetingAttendant)
    {
        $meetingAttendant->update($request->all());

        return (new MeetingAttendantResource($meetingAttendant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingAttendant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

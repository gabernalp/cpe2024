<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventsAttendantRequest;
use App\Http\Requests\UpdateEventsAttendantRequest;
use App\Http\Resources\Admin\EventsAttendantResource;
use App\Models\EventsAttendant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsAttendantsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('events_attendant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventsAttendantResource(EventsAttendant::with(['event', 'department', 'city'])->get());
    }

    public function store(StoreEventsAttendantRequest $request)
    {
        $eventsAttendant = EventsAttendant::create($request->all());

        return (new EventsAttendantResource($eventsAttendant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventsAttendant $eventsAttendant)
    {
        abort_if(Gate::denies('events_attendant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventsAttendantResource($eventsAttendant->load(['event', 'department', 'city']));
    }

    public function update(UpdateEventsAttendantRequest $request, EventsAttendant $eventsAttendant)
    {
        $eventsAttendant->update($request->all());

        return (new EventsAttendantResource($eventsAttendant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventsAttendant $eventsAttendant)
    {
        abort_if(Gate::denies('events_attendant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsAttendant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

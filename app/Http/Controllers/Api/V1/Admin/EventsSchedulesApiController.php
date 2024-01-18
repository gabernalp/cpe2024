<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEventsScheduleRequest;
use App\Http\Requests\UpdateEventsScheduleRequest;
use App\Http\Resources\Admin\EventsScheduleResource;
use App\Models\EventsSchedule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsSchedulesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('events_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventsScheduleResource(EventsSchedule::all());
    }

    public function store(StoreEventsScheduleRequest $request)
    {
        $eventsSchedule = EventsSchedule::create($request->all());

        if ($request->input('image', false)) {
            $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($request->input('podcast', false)) {
            $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('podcast'))))->toMediaCollection('podcast');
        }

        return (new EventsScheduleResource($eventsSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EventsSchedule $eventsSchedule)
    {
        abort_if(Gate::denies('events_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventsScheduleResource($eventsSchedule);
    }

    public function update(UpdateEventsScheduleRequest $request, EventsSchedule $eventsSchedule)
    {
        $eventsSchedule->update($request->all());

        if ($request->input('image', false)) {
            if (!$eventsSchedule->image || $request->input('image') !== $eventsSchedule->image->file_name) {
                if ($eventsSchedule->image) {
                    $eventsSchedule->image->delete();
                }
                $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($eventsSchedule->image) {
            $eventsSchedule->image->delete();
        }

        if ($request->input('podcast', false)) {
            if (!$eventsSchedule->podcast || $request->input('podcast') !== $eventsSchedule->podcast->file_name) {
                if ($eventsSchedule->podcast) {
                    $eventsSchedule->podcast->delete();
                }
                $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('podcast'))))->toMediaCollection('podcast');
            }
        } elseif ($eventsSchedule->podcast) {
            $eventsSchedule->podcast->delete();
        }

        return (new EventsScheduleResource($eventsSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EventsSchedule $eventsSchedule)
    {
        abort_if(Gate::denies('events_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsSchedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

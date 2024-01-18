<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Http\Resources\Admin\MeetingResource;
use App\Models\Meeting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('meeting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MeetingResource(Meeting::with(['user', 'technical_referrers'])->get());
    }

    public function store(StoreMeetingRequest $request)
    {
        $meeting = Meeting::create($request->all());
        $meeting->technical_referrers()->sync($request->input('technical_referrers', []));
        if ($request->input('file', false)) {
            $meeting->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new MeetingResource($meeting))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Meeting $meeting)
    {
        abort_if(Gate::denies('meeting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MeetingResource($meeting->load(['user', 'technical_referrers']));
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        $meeting->update($request->all());
        $meeting->technical_referrers()->sync($request->input('technical_referrers', []));
        if ($request->input('file', false)) {
            if (!$meeting->file || $request->input('file') !== $meeting->file->file_name) {
                if ($meeting->file) {
                    $meeting->file->delete();
                }
                $meeting->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($meeting->file) {
            $meeting->file->delete();
        }

        return (new MeetingResource($meeting))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Meeting $meeting)
    {
        abort_if(Gate::denies('meeting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meeting->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

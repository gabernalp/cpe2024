<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCoursesHookRequest;
use App\Http\Requests\UpdateCoursesHookRequest;
use App\Http\Resources\Admin\CoursesHookResource;
use App\Models\CoursesHook;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesHooksApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('courses_hook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoursesHookResource(CoursesHook::with(['entidad'])->get());
    }

    public function store(StoreCoursesHookRequest $request)
    {
        $coursesHook = CoursesHook::create($request->all());

        if ($request->input('file', false)) {
            $coursesHook->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new CoursesHookResource($coursesHook))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoursesHookResource($coursesHook->load(['entidad']));
    }

    public function update(UpdateCoursesHookRequest $request, CoursesHook $coursesHook)
    {
        $coursesHook->update($request->all());

        if ($request->input('file', false)) {
            if (!$coursesHook->file || $request->input('file') !== $coursesHook->file->file_name) {
                if ($coursesHook->file) {
                    $coursesHook->file->delete();
                }
                $coursesHook->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($coursesHook->file) {
            $coursesHook->file->delete();
        }

        return (new CoursesHookResource($coursesHook))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

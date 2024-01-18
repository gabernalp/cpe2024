<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCoursesUserRequest;
use App\Http\Requests\UpdateCoursesUserRequest;
use App\Http\Resources\Admin\CoursesUserResource;
use App\Models\CoursesUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesUsersApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('courses_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoursesUserResource(CoursesUser::with(['user', 'course_schedule'])->get());
    }

    public function store(StoreCoursesUserRequest $request)
    {
        $coursesUser = CoursesUser::create($request->all());

        if ($request->input('file', false)) {
            $coursesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new CoursesUserResource($coursesUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoursesUserResource($coursesUser->load(['user', 'course_schedule']));
    }

    public function update(UpdateCoursesUserRequest $request, CoursesUser $coursesUser)
    {
        $coursesUser->update($request->all());

        if ($request->input('file', false)) {
            if (!$coursesUser->file || $request->input('file') !== $coursesUser->file->file_name) {
                if ($coursesUser->file) {
                    $coursesUser->file->delete();
                }
                $coursesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($coursesUser->file) {
            $coursesUser->file->delete();
        }

        return (new CoursesUserResource($coursesUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesUser->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

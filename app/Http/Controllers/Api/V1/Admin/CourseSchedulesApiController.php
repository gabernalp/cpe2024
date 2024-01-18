<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseScheduleRequest;
use App\Http\Requests\UpdateCourseScheduleRequest;
use App\Http\Resources\Admin\CourseScheduleResource;
use App\Models\CourseSchedule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseSchedulesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('course_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseScheduleResource(CourseSchedule::with(['course', 'user'])->get());
    }

    public function store(StoreCourseScheduleRequest $request)
    {
        $courseSchedule = CourseSchedule::create($request->all());

        return (new CourseScheduleResource($courseSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CourseSchedule $courseSchedule)
    {
        abort_if(Gate::denies('course_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseScheduleResource($courseSchedule->load(['course', 'user']));
    }

    public function update(UpdateCourseScheduleRequest $request, CourseSchedule $courseSchedule)
    {
        $courseSchedule->update($request->all());

        return (new CourseScheduleResource($courseSchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CourseSchedule $courseSchedule)
    {
        abort_if(Gate::denies('course_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseSchedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

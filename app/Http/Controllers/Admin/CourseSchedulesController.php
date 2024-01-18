<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCourseScheduleRequest;
use App\Http\Requests\StoreCourseScheduleRequest;
use App\Http\Requests\UpdateCourseScheduleRequest;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CourseSchedulesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('course_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CourseSchedule::with(['course', 'user'])->select(sprintf('%s.*', (new CourseSchedule())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_schedule_show';
                $editGate = 'course_schedule_edit';
                $deleteGate = 'course_schedule_delete';
                $crudRoutePart = 'course-schedules';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('course_name', function ($row) {
                return $row->course ? $row->course->name : '';
            });

            $table->editColumn('revisa_tutor', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->revisa_tutor ? 'checked' : null) . '>';
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'revisa_tutor', 'user']);

            return $table->make(true);
        }

        return view('admin.courseSchedules.index');
    }

    public function create()
    {
        abort_if(Gate::denies('course_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courseSchedules.create', compact('courses', 'users'));
    }

    public function store(StoreCourseScheduleRequest $request)
    {
        $courseSchedule = CourseSchedule::create($request->all());

        return redirect()->route('admin.course-schedules.index');
    }

    public function edit(CourseSchedule $courseSchedule)
    {
        abort_if(Gate::denies('course_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $courseSchedule->load('course', 'user');

        return view('admin.courseSchedules.edit', compact('courseSchedule', 'courses', 'users'));
    }

    public function update(UpdateCourseScheduleRequest $request, CourseSchedule $courseSchedule)
    {
        $courseSchedule->update($request->all());

        return redirect()->route('admin.course-schedules.index');
    }

    public function show(CourseSchedule $courseSchedule)
    {
        abort_if(Gate::denies('course_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseSchedule->load('course', 'user', 'courseScheduleCoursesUsers');

        return view('admin.courseSchedules.show', compact('courseSchedule'));
    }

    public function destroy(CourseSchedule $courseSchedule)
    {
        abort_if(Gate::denies('course_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseSchedule->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseScheduleRequest $request)
    {
        CourseSchedule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
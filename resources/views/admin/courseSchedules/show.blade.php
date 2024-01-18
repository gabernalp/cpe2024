@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.courseSchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.course-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $courseSchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.course') }}
                        </th>
                        <td>
                            {{ $courseSchedule->course->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.start_date') }}
                        </th>
                        <td>
                            {{ $courseSchedule->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.revisa_tutor') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $courseSchedule->revisa_tutor ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.user') }}
                        </th>
                        <td>
                            {{ $courseSchedule->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.course-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!--<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#course_schedule_courses_users" role="tab" data-toggle="tab">
                {{ trans('cruds.coursesUser.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="course_schedule_courses_users">
            @includeIf('admin.courseSchedules.relationships.courseScheduleCoursesUsers', ['coursesUsers' => $courseSchedule->courseScheduleCoursesUsers])
        </div>
    </div>
</div>-->

@endsection
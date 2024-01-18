@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.course.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.id') }}
                        </th>
                        <td>
                            {{ $course->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.tematica_asociada') }}
                        </th>
                        <td>
                            {{ $course->tematica_asociada->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.name') }}
                        </th>
                        <td>
                            {{ $course->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.goal') }}
                        </th>
                        <td>
                            {{ $course->goal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.tipo_ciclo') }}
                        </th>
                        <td>
                            {{ App\Models\Course::TIPO_CICLO_SELECT[$course->tipo_ciclo] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.unico') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $course->unico ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.mensaje_cierre') }} para participantes del ciclo
                        </th>
                        <td>
                            {{ $course->mensaje_cierre }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Archivo imprimible para coordinadores
                        </th>
                        <td>
                            @if($course->imagen)
                                <a href="{{ $course->imagen->getUrl() }}" target="_blank" style="display: inline-block">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.course.fields.additional_comments') }}
                        </th>
                        <td>
                            {{ $course->additional_comments }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses.index') }}">
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
            <a class="nav-link" href="#course_course_schedules" role="tab" data-toggle="tab">
                {{ trans('cruds.courseSchedule.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="course_course_schedules">
            @includeIf('admin.courses.relationships.courseCourseSchedules', ['courseSchedules' => $course->courseCourseSchedules])
        </div>
    </div>
</div>-->

@endsection
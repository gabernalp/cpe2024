@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coursesUser.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.id') }}
                        </th>
                        <td>
                            {{ $coursesUser->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.user') }}
                        </th>
                        <td>
                            {{ $coursesUser->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.course_schedule') }}
                        </th>
                        <td>
                            {{ $coursesUser->course_schedule->start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.course_name') }}
                        </th>
                        <td>
                            {{ $coursesUser->course_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.whatsapp_user') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coursesUser->whatsapp_user ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.actual_challenge') }}
                        </th>
                        <td>
                            {{ $coursesUser->actual_challenge }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.alert_messages') }}
                        </th>
                        <td>
                            {{ App\Models\CoursesUser::ALERT_MESSAGES_SELECT[$coursesUser->alert_messages] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.manual_feedback') }}
                        </th>
                        <td>
                            {{ $coursesUser->manual_feedback }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.additional_link') }}
                        </th>
                        <td>
                            {{ $coursesUser->additional_link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.file') }}
                        </th>
                        <td>
                            @if($coursesUser->file)
                                <a href="{{ $coursesUser->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesUser.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\CoursesUser::STATUS_SELECT[$coursesUser->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
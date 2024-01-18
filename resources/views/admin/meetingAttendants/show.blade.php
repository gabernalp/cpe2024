@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.meetingAttendant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meeting-attendants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingAttendant.fields.id') }}
                        </th>
                        <td>
                            {{ $meetingAttendant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingAttendant.fields.meeting') }}
                        </th>
                        <td>
                            {{ $meetingAttendant->meeting->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meetingAttendant.fields.user') }}
                        </th>
                        <td>
                            {{ $meetingAttendant->user->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meeting-attendants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.meeting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meetings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.id') }}
                        </th>
                        <td>
                            {{ $meeting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.user') }}
                        </th>
                        <td>
                            {{ $meeting->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.title') }}
                        </th>
                        <td>
                            {{ $meeting->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.description') }}
                        </th>
                        <td>
                            {{ $meeting->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.date') }}
                        </th>
                        <td>
                            {{ $meeting->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.time') }}
                        </th>
                        <td>
                            {{ $meeting->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.meeting_term') }}
                        </th>
                        <td>
                            {{ App\Models\Meeting::MEETING_TERM_SELECT[$meeting->meeting_term] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.methodology') }}
                        </th>
                        <td>
                            {{ App\Models\Meeting::METHODOLOGY_SELECT[$meeting->methodology] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.technical_referrers') }}
                        </th>
                        <td>
                            @foreach($meeting->technical_referrers as $key => $technical_referrers)
                                <span class="label label-info">{{ $technical_referrers->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.teachers_network') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $meeting->teachers_network ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.otro_referente') }}
                        </th>
                        <td>
                            {{ $meeting->otro_referente }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.link') }}
                        </th>
                        <td>
                            {{ $meeting->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.file') }}
                        </th>
                        <td>
                            @if($meeting->file)
                                <a href="{{ $meeting->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.meeting.fields.observaciones') }}
                        </th>
                        <td>
                            {{ $meeting->observaciones }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.meetings.index') }}">
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
            <a class="nav-link" href="#meeting_meeting_attendants" role="tab" data-toggle="tab">
                {{ trans('cruds.meetingAttendant.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="meeting_meeting_attendants">
            @includeIf('admin.meetings.relationships.meetingMeetingAttendants', ['meetingAttendants' => $meeting->meetingMeetingAttendants])
        </div>
    </div>
</div>-->

@endsection
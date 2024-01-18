@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eventsSchedule.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events-schedules.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.id') }}
                        </th>
                        <td>
                            {{ $eventsSchedule->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.title') }}
                        </th>
                        <td>
                            {{ $eventsSchedule->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.description') }}
                        </th>
                        <td>
                            {!! $eventsSchedule->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.date') }}
                        </th>
                        <td>
                            {{ $eventsSchedule->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.image') }}
                        </th>
                        <td>
                            @if($eventsSchedule->image)
                                <a href="{{ $eventsSchedule->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $eventsSchedule->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.link') }}
                        </th>
                        <td>
                            {{ $eventsSchedule->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.invitados') }}
                        </th>
                        <td>
                            {{ $eventsSchedule->invitados }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.newsletter') }}
                        </th>
                        <td>
                            {!! $eventsSchedule->newsletter !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.podcast') }}
                        </th>
                        <td>
                            @if($eventsSchedule->podcast)
                                <a href="{{ $eventsSchedule->podcast->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.video_embed') }}
                        </th>
                        <td>
                            {{ $eventsSchedule->video_embed }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events-schedules.index') }}">
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
            <a class="nav-link" href="#event_events_attendants" role="tab" data-toggle="tab">
                {{ trans('cruds.eventsAttendant.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="event_events_attendants">
            @includeIf('admin.eventsSchedules.relationships.eventEventsAttendants', ['eventsAttendants' => $eventsSchedule->eventEventsAttendants])
        </div>
    </div>
</div>-->

@endsection
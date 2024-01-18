@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.eventsAttendant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events-attendants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.id') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.event') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->event->date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.name') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.last_name') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.documenttype') }}
                        </th>
                        <td>
                            {{ App\Models\EventsAttendant::DOCUMENTTYPE_SELECT[$eventsAttendant->documenttype] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.document') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->document }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.department') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->department->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.city') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.entity') }}
                        </th>
                        <td>
                            {{ App\Models\EventsAttendant::ENTITY_SELECT[$eventsAttendant->entity] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.phone') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.email') }}
                        </th>
                        <td>
                            {{ $eventsAttendant->email }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events-attendants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
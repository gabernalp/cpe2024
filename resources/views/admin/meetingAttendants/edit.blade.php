@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.meetingAttendant.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.meeting-attendants.update", [$meetingAttendant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="meeting_id">{{ trans('cruds.meetingAttendant.fields.meeting') }}</label>
                <select reuired class="form-control select2 {{ $errors->has('meeting') ? 'is-invalid' : '' }}" name="meeting_id" id="meeting_id">
                    @foreach($meetings as $id => $entry)
                        <option value="{{ $id }}" {{ (old('meeting_id') ? old('meeting_id') : $meetingAttendant->meeting->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('meeting'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meeting') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meetingAttendant.fields.meeting_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.meetingAttendant.fields.user') }}</label>
                <select required class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $meetingAttendant->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meetingAttendant.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.courseSchedule.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.course-schedules.update", [$courseSchedule->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="course_id">{{ trans('cruds.courseSchedule.fields.course') }}</label>
                <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                    @foreach($courses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $courseSchedule->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('course'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.courseSchedule.fields.course_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.courseSchedule.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $courseSchedule->start_date) }}" required>
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.courseSchedule.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('revisa_tutor') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="revisa_tutor" value="0">
                    <input class="form-check-input" type="checkbox" name="revisa_tutor" id="revisa_tutor" value="1" {{ $courseSchedule->revisa_tutor || old('revisa_tutor', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="revisa_tutor">{{ trans('cruds.courseSchedule.fields.revisa_tutor') }}</label>
                </div>
                @if($errors->has('revisa_tutor'))
                    <div class="invalid-feedback">
                        {{ $errors->first('revisa_tutor') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.courseSchedule.fields.revisa_tutor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.courseSchedule.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $courseSchedule->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.courseSchedule.fields.user_helper') }}</span>
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
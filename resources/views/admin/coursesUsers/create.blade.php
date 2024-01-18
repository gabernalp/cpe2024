@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.coursesUser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses-users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.coursesUser.fields.user') }}</label>
                <select required class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="course_schedule_id">{{ trans('cruds.coursesUser.fields.course_schedule') }}</label>
                <select required class="form-control select2 {{ $errors->has('course_schedule') ? 'is-invalid' : '' }}" name="course_schedule_id" id="course_schedule_id">
                    @foreach($course_schedules as $entry)
                        @if(date("Y-m-d") < Carbon\Carbon::parse($entry->start_date)->addDays(28)->toDateString())
                        <option value="{{ $entry->id }}" {{ old('course_schedule_id') == $id ? 'selected' : '' }}>{{ '['.$entry->start_date.'] '.$entry->course->name }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('course_schedule'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_schedule') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.course_schedule_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('whatsapp_user') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="whatsapp_user" value="0">
                    <input class="form-check-input" type="checkbox" name="whatsapp_user" id="whatsapp_user" value="1" {{ old('whatsapp_user', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="whatsapp_user">{{ trans('cruds.coursesUser.fields.whatsapp_user') }}</label>
                </div>
                @if($errors->has('whatsapp_user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp_user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.whatsapp_user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="actual_challenge">{{ trans('cruds.coursesUser.fields.actual_challenge') }}</label>
                <input required class="form-control {{ $errors->has('actual_challenge') ? 'is-invalid' : '' }}" type="number" name="actual_challenge" id="actual_challenge" value="{{ old('actual_challenge', '0') }}" step="1">
                @if($errors->has('actual_challenge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('actual_challenge') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.actual_challenge_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.coursesUser.fields.alert_messages') }}</label>
                <select required class="form-control {{ $errors->has('alert_messages') ? 'is-invalid' : '' }}" name="alert_messages" id="alert_messages">
                    <option value disabled {{ old('alert_messages', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CoursesUser::ALERT_MESSAGES_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('alert_messages', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('alert_messages'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alert_messages') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.alert_messages_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="manual_feedback">{{ trans('cruds.coursesUser.fields.manual_feedback') }}</label>
                <textarea class="form-control {{ $errors->has('manual_feedback') ? 'is-invalid' : '' }}" name="manual_feedback" id="manual_feedback">{{ old('manual_feedback') }}</textarea>
                @if($errors->has('manual_feedback'))
                    <div class="invalid-feedback">
                        {{ $errors->first('manual_feedback') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.manual_feedback_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="additional_link">{{ trans('cruds.coursesUser.fields.additional_link') }}</label>
                <input class="form-control {{ $errors->has('additional_link') ? 'is-invalid' : '' }}" type="text" name="additional_link" id="additional_link" value="{{ old('additional_link', '') }}">
                @if($errors->has('additional_link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('additional_link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.additional_link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.coursesUser.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.file_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.courses-users.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($coursesUser) && $coursesUser->file)
      var file = {!! json_encode($coursesUser->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection
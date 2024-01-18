@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.meeting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.meetings.update", [$meeting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.meeting.fields.user') }}</label>
                <select required class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $meeting->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.meeting.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $meeting->title) }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.meeting.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $meeting->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.meeting.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $meeting->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="time">{{ trans('cruds.meeting.fields.time') }}</label>
                <input class="form-control timepicker {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $meeting->time) }}" required>
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.meeting.fields.meeting_term') }}</label>
                <select class="form-control {{ $errors->has('meeting_term') ? 'is-invalid' : '' }}" name="meeting_term" id="meeting_term">
                    <option value disabled {{ old('meeting_term', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Meeting::MEETING_TERM_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('meeting_term', $meeting->meeting_term) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('meeting_term'))
                    <div class="invalid-feedback">
                        {{ $errors->first('meeting_term') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.meeting_term_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.meeting.fields.methodology') }}</label>
                <select class="form-control {{ $errors->has('methodology') ? 'is-invalid' : '' }}" name="methodology" id="methodology">
                    <option value disabled {{ old('methodology', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Meeting::METHODOLOGY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('methodology', $meeting->methodology) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('methodology'))
                    <div class="invalid-feedback">
                        {{ $errors->first('methodology') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.methodology_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="technical_referrers">{{ trans('cruds.meeting.fields.technical_referrers') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('technical_referrers') ? 'is-invalid' : '' }}" name="technical_referrers[]" id="technical_referrers" multiple>
                    @foreach($technical_referrers as $id => $technical_referrer)
                        <option value="{{ $id }}" {{ (in_array($id, old('technical_referrers', [])) || $meeting->technical_referrers->contains($id)) ? 'selected' : '' }}>{{ $technical_referrer }}</option>
                    @endforeach
                </select>
                @if($errors->has('technical_referrers'))
                    <div class="invalid-feedback">
                        {{ $errors->first('technical_referrers') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.technical_referrers_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('teachers_network') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="teachers_network" value="0">
                    <input class="form-check-input" type="checkbox" name="teachers_network" id="teachers_network" value="1" {{ $meeting->teachers_network || old('teachers_network', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="teachers_network">{{ trans('cruds.meeting.fields.teachers_network') }}</label>
                </div>
                @if($errors->has('teachers_network'))
                    <div class="invalid-feedback">
                        {{ $errors->first('teachers_network') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.teachers_network_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="otro_referente">{{ trans('cruds.meeting.fields.otro_referente') }}</label>
                <input class="form-control {{ $errors->has('otro_referente') ? 'is-invalid' : '' }}" type="text" name="otro_referente" id="otro_referente" value="{{ old('otro_referente', $meeting->otro_referente) }}">
                @if($errors->has('otro_referente'))
                    <div class="invalid-feedback">
                        {{ $errors->first('otro_referente') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.otro_referente_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link">{{ trans('cruds.meeting.fields.link') }}</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $meeting->link) }}">
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.meeting.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="observaciones">{{ trans('cruds.meeting.fields.observaciones') }}</label>
                <textarea class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" name="observaciones" id="observaciones">{{ old('observaciones', $meeting->observaciones) }}</textarea>
                @if($errors->has('observaciones'))
                    <div class="invalid-feedback">
                        {{ $errors->first('observaciones') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.meeting.fields.observaciones_helper') }}</span>
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
    url: '{{ route('admin.meetings.storeMedia') }}',
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
@if(isset($meeting) && $meeting->file)
      var file = {!! json_encode($meeting->file) !!}
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
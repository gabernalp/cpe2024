@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.challenge.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.challenges.update", [$challenge->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="course_id">{{ trans('cruds.challenge.fields.course') }}</label>
                <select class="form-control select2 {{ $errors->has('course') ? 'is-invalid' : '' }}" name="course_id" id="course_id" required>
                    @foreach($courses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('course_id') ? old('course_id') : $challenge->course->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('course'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.course_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.challenge.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $challenge->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="goal">{{ trans('cruds.challenge.fields.goal') }}</label>
                <textarea class="form-control {{ $errors->has('goal') ? 'is-invalid' : '' }}" name="goal" id="goal" required>{{ old('goal', $challenge->goal) }}</textarea>
                @if($errors->has('goal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('goal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.goal_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="referencetype_capsule_id">{{ trans('cruds.challenge.fields.referencetype_capsule') }}</label>
                <select class="form-control select2 {{ $errors->has('referencetype_capsule') ? 'is-invalid' : '' }}" name="referencetype_capsule_id" id="referencetype_capsule_id" required>
                    @foreach($referencetype_capsules as $id => $entry)
                        <option value="{{ $id }}" {{ (old('referencetype_capsule_id') ? old('referencetype_capsule_id') : $challenge->referencetype_capsule->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('referencetype_capsule'))
                    <div class="invalid-feedback">
                        {{ $errors->first('referencetype_capsule') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.referencetype_capsule_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="capsule_content">{{ trans('cruds.challenge.fields.capsule_content') }}</label>
                <textarea class="form-control {{ $errors->has('capsule_content') ? 'is-invalid' : '' }}" name="capsule_content" id="capsule_content">{{ old('capsule_content', $challenge->capsule_content) }}</textarea>
                @if($errors->has('capsule_content'))
                    <div class="invalid-feedback">
                        {{ $errors->first('capsule_content') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.capsule_content_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="capsule_file">{{ trans('cruds.challenge.fields.capsule_file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('capsule_file') ? 'is-invalid' : '' }}" id="capsule_file-dropzone">
                </div>
                @if($errors->has('capsule_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('capsule_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.capsule_file_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.challenge.fields.challenge_action') }}</label>
                <select class="form-control {{ $errors->has('challenge_action') ? 'is-invalid' : '' }}" name="challenge_action" id="challenge_action">
                    <option value disabled {{ old('challenge_action', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Challenge::CHALLENGE_ACTION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('challenge_action', $challenge->challenge_action) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('challenge_action'))
                    <div class="invalid-feedback">
                        {{ $errors->first('challenge_action') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.challenge_action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action_detail">{{ trans('cruds.challenge.fields.action_detail') }}</label>
                <textarea class="form-control {{ $errors->has('action_detail') ? 'is-invalid' : '' }}" name="action_detail" id="action_detail">{{ old('action_detail', $challenge->action_detail) }}</textarea>
                @if($errors->has('action_detail'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action_detail') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.action_detail_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="referencetype_id">{{ trans('cruds.challenge.fields.referencetype') }}</label>
                <select class="form-control select2 {{ $errors->has('referencetype') ? 'is-invalid' : '' }}" name="referencetype_id" id="referencetype_id" required>
                    @foreach($referencetypes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('referencetype_id') ? old('referencetype_id') : $challenge->referencetype->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('referencetype'))
                    <div class="invalid-feedback">
                        {{ $errors->first('referencetype') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challenge.fields.referencetype_helper') }}</span>
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
    Dropzone.options.capsuleFileDropzone = {
    url: '{{ route('admin.challenges.storeMedia') }}',
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
      $('form').find('input[name="capsule_file"]').remove()
      $('form').append('<input type="hidden" name="capsule_file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="capsule_file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($challenge) && $challenge->capsule_file)
      var file = {!! json_encode($challenge->capsule_file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="capsule_file" value="' + file.file_name + '">')
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
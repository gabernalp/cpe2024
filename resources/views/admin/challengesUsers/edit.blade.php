@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.challengesUser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.challenges-users.update", [$challengesUser->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="courseschedule_id">{{ trans('cruds.challengesUser.fields.courseschedule') }}</label>
                <select class="form-control select2 {{ $errors->has('courseschedule') ? 'is-invalid' : '' }}" name="courseschedule_id" id="courseschedule_id">
                    @foreach($courseschedules as $id => $entry)
                        <option value="{{ $id }}" {{ (old('courseschedule_id') ? old('courseschedule_id') : $challengesUser->courseschedule->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('courseschedule'))
                    <div class="invalid-feedback">
                        {{ $errors->first('courseschedule') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.courseschedule_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.challengesUser.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $challengesUser->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="challenge_id">{{ trans('cruds.challengesUser.fields.challenge') }}</label>
                <select class="form-control select2 {{ $errors->has('challenge') ? 'is-invalid' : '' }}" name="challenge_id" id="challenge_id">
                    @foreach($challenges as $id => $entry)
                        <option value="{{ $id }}" {{ (old('challenge_id') ? old('challenge_id') : $challengesUser->challenge->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('challenge'))
                    <div class="invalid-feedback">
                        {{ $errors->first('challenge') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.challenge_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reference_text">{{ trans('cruds.challengesUser.fields.reference_text') }}</label>
                <textarea class="form-control {{ $errors->has('reference_text') ? 'is-invalid' : '' }}" name="reference_text" id="reference_text">{{ old('reference_text', $challengesUser->reference_text) }}</textarea>
                @if($errors->has('reference_text'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reference_text') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.reference_text_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reference_media">{{ trans('cruds.challengesUser.fields.reference_media') }}</label>
                <input class="form-control {{ $errors->has('reference_media') ? 'is-invalid' : '' }}" type="text" name="reference_media" id="reference_media" value="{{ old('reference_media', $challengesUser->reference_media) }}">
                @if($errors->has('reference_media'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reference_media') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.reference_media_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.challengesUser.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.challengesUser.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\ChallengesUser::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $challengesUser->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.challengesUser.fields.status_helper') }}</span>
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
    url: '{{ route('admin.challenges-users.storeMedia') }}',
    maxFilesize: 20, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20
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
@if(isset($challengesUser) && $challengesUser->file)
      var file = {!! json_encode($challengesUser->file) !!}
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
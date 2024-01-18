@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.whatsappWord.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.whatsapp-words.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="word">{{ trans('cruds.whatsappWord.fields.word') }}</label>
                <input required class="form-control {{ $errors->has('word') ? 'is-invalid' : '' }}" type="text" name="word" id="word" value="{{ old('word', '') }}">
                @if($errors->has('word'))
                    <div class="invalid-feedback">
                        {{ $errors->first('word') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.word_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="object">{{ trans('cruds.whatsappWord.fields.object') }}</label>
                <input class="form-control {{ $errors->has('object') ? 'is-invalid' : '' }}" type="text" name="object" id="object" value="{{ old('object', '') }}">
                @if($errors->has('object'))
                    <div class="invalid-feedback">
                        {{ $errors->first('object') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.object_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="action">{{ trans('cruds.whatsappWord.fields.action') }}</label>
                <input class="form-control {{ $errors->has('action') ? 'is-invalid' : '' }}" type="text" name="action" id="action" value="{{ old('action', '') }}">
                @if($errors->has('action'))
                    <div class="invalid-feedback">
                        {{ $errors->first('action') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.action_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link">{{ trans('cruds.whatsappWord.fields.link') }}</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', '') }}">
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.link_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.whatsappWord.fields.message') }}</label>
                <textarea required class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{{ old('message') }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.whatsappWord.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WhatsappWord::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extra">{{ trans('cruds.whatsappWord.fields.extra') }}</label>
                <input class="form-control {{ $errors->has('extra') ? 'is-invalid' : '' }}" type="text" name="extra" id="extra" value="{{ old('extra', '') }}">
                @if($errors->has('extra'))
                    <div class="invalid-feedback">
                        {{ $errors->first('extra') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.extra_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image">{{ trans('cruds.whatsappWord.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.whatsappWord.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.whatsappWord.fields.file_helper') }}</span>
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
    Dropzone.options.imageDropzone = {
    url: '{{ route('admin.whatsapp-words.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="image"]').remove()
      $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($whatsappWord) && $whatsappWord->image)
      var file = {!! json_encode($whatsappWord->image) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image" value="' + file.file_name + '">')
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
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.whatsapp-words.storeMedia') }}',
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
@if(isset($whatsappWord) && $whatsappWord->file)
      var file = {!! json_encode($whatsappWord->file) !!}
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
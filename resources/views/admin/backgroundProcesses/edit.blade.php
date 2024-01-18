@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.backgroundProcess.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.background-processes.update", [$backgroundProcess->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.backgroundProcess.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $backgroundProcess->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.backgroundProcess.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description', $backgroundProcess->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.backgroundProcess.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="images">{{ trans('cruds.backgroundProcess.fields.images') }}</label>
                <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                </div>
                @if($errors->has('images'))
                    <div class="invalid-feedback">
                        {{ $errors->first('images') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.images_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link">{{ trans('cruds.backgroundProcess.fields.link') }}</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $backgroundProcess->link) }}">
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.link_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('especial') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="especial" value="0">
                    <input class="form-check-input" type="checkbox" name="especial" id="especial" value="1" {{ $backgroundProcess->especial || old('especial', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="especial">{{ trans('cruds.backgroundProcess.fields.especial') }}</label>
                </div>
                @if($errors->has('especial'))
                    <div class="invalid-feedback">
                        {{ $errors->first('especial') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.especial_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="descripcion_especial">{{ trans('cruds.backgroundProcess.fields.descripcion_especial') }}</label>
                <textarea class="form-control {{ $errors->has('descripcion_especial') ? 'is-invalid' : '' }}" name="descripcion_especial" id="descripcion_especial">{{ old('descripcion_especial', $backgroundProcess->descripcion_especial) }}</textarea>
                @if($errors->has('descripcion_especial'))
                    <div class="invalid-feedback">
                        {{ $errors->first('descripcion_especial') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.descripcion_especial_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="imagen_especial">{{ trans('cruds.backgroundProcess.fields.imagen_especial') }}</label>
                <div class="needsclick dropzone {{ $errors->has('imagen_especial') ? 'is-invalid' : '' }}" id="imagen_especial-dropzone">
                </div>
                @if($errors->has('imagen_especial'))
                    <div class="invalid-feedback">
                        {{ $errors->first('imagen_especial') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.imagen_especial_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.backgroundProcess.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $backgroundProcess->comments) }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.backgroundProcess.fields.comments_helper') }}</span>
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
    var uploadedFileMap = {}
Dropzone.options.fileDropzone = {
    url: '{{ route('admin.background-processes.storeMedia') }}',
    maxFilesize: 5, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')
      uploadedFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedFileMap[file.name]
      }
      $('form').find('input[name="file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($backgroundProcess) && $backgroundProcess->file)
          var files =
            {!! json_encode($backgroundProcess->file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="file[]" value="' + file.file_name + '">')
            }
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
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.background-processes.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
      uploadedImagesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImagesMap[file.name]
      }
      $('form').find('input[name="images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($backgroundProcess) && $backgroundProcess->images)
      var files = {!! json_encode($backgroundProcess->images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
        }
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
    Dropzone.options.imagenEspecialDropzone = {
    url: '{{ route('admin.background-processes.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },

    success: function (file, response) {
      $('form').find('input[name="imagen_especial"]').remove()
      $('form').append('<input type="hidden" name="imagen_especial" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="imagen_especial"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($backgroundProcess) && $backgroundProcess->imagen_especial)
      var file = {!! json_encode($backgroundProcess->imagen_especial) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="imagen_especial" value="' + file.file_name + '">')
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
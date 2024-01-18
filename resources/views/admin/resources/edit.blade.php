@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.resource.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.resources.update", [$resource->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.resource.fields.name') }}</label>
                <input required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $resource->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="resourcescategory_id">{{ trans('cruds.resource.fields.resourcescategory') }}</label>
                <select class="form-control select2 {{ $errors->has('resourcescategory') ? 'is-invalid' : '' }}" name="resourcescategory_id" id="resourcescategory_id" required>
                    @foreach($resourcescategories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('resourcescategory_id') ? old('resourcescategory_id') : $resource->resourcescategory->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('resourcescategory'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resourcescategory') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.resourcescategory_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="resource_subcategories">{{ trans('cruds.resource.fields.resource_subcategory') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('resource_subcategories') ? 'is-invalid' : '' }}" name="resource_subcategories[]" id="resource_subcategories" multiple>
                    @foreach($resource_subcategories as $id => $resource_subcategory)
                        <option value="{{ $id }}" {{ (in_array($id, old('resource_subcategories', [])) || $resource->resource_subcategories->contains($id)) ? 'selected' : '' }}>{{ $resource_subcategory }}</option>
                    @endforeach
                </select>
                @if($errors->has('resource_subcategories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resource_subcategories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.resource_subcategory_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="imagen_archivo">{{ trans('cruds.resource.fields.imagen_archivo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('imagen_archivo') ? 'is-invalid' : '' }}" id="imagen_archivo-dropzone">
                </div>
                @if($errors->has('imagen_archivo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('imagen_archivo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.imagen_archivo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file">{{ trans('cruds.resource.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image_pdf">{{ trans('cruds.resource.fields.image_pdf') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image_pdf') ? 'is-invalid' : '' }}" id="image_pdf-dropzone">
                </div>
                @if($errors->has('image_pdf'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image_pdf') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.image_pdf_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link">{{ trans('cruds.resource.fields.link') }}</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $resource->link) }}">
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tag_categories">{{ trans('cruds.resource.fields.tag_category') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tag_categories') ? 'is-invalid' : '' }}" name="tag_categories[]" id="tag_categories" multiple>
                    @foreach($tag_categories as $id => $tag_category)
                        <option value="{{ $id }}" {{ (in_array($id, old('tag_categories', [])) || $resource->tag_categories->contains($id)) ? 'selected' : '' }}>{{ $tag_category }}</option>
                    @endforeach
                </select>
                @if($errors->has('tag_categories'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tag_categories') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.tag_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tags">{{ trans('cruds.resource.fields.tags') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('tags') ? 'is-invalid' : '' }}" name="tags[]" id="tags" multiple>
                    @foreach($tags as $id => $tag)
                        <option value="{{ $id }}" {{ (in_array($id, old('tags', [])) || $resource->tags->contains($id)) ? 'selected' : '' }}>{{ $tag }}</option>
                    @endforeach
                </select>
                @if($errors->has('tags'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tags') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.tags_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="manual">{{ trans('cruds.resource.fields.manual') }}</label>
                <div class="needsclick dropzone {{ $errors->has('manual') ? 'is-invalid' : '' }}" id="manual-dropzone">
                </div>
                @if($errors->has('manual'))
                    <div class="invalid-feedback">
                        {{ $errors->first('manual') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.manual_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="image_manual">{{ trans('cruds.resource.fields.image_manual') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image_manual') ? 'is-invalid' : '' }}" id="image_manual-dropzone">
                </div>
                @if($errors->has('image_manual'))
                    <div class="invalid-feedback">
                        {{ $errors->first('image_manual') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.image_manual_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.resource.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $resource->comments) }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resource.fields.comments_helper') }}</span>
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
    Dropzone.options.imagenArchivoDropzone = {
    url: '{{ route('admin.resources.storeMedia') }}',
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
      $('form').find('input[name="imagen_archivo"]').remove()
      $('form').append('<input type="hidden" name="imagen_archivo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="imagen_archivo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($resource) && $resource->imagen_archivo)
      var file = {!! json_encode($resource->imagen_archivo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="imagen_archivo" value="' + file.file_name + '">')
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
    url: '{{ route('admin.resources.storeMedia') }}',
    acceptedFiles: '.jpeg,.jpg,.png,.gif,.pdf,.ogg,.mp3,.mp4',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
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
@if(isset($resource) && $resource->file)
      var file = {!! json_encode($resource->file) !!}
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
<script>
    Dropzone.options.imagePdfDropzone = {
    url: '{{ route('admin.resources.storeMedia') }}',
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
      $('form').find('input[name="image_pdf"]').remove()
      $('form').append('<input type="hidden" name="image_pdf" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image_pdf"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($resource) && $resource->image_pdf)
      var file = {!! json_encode($resource->image_pdf) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image_pdf" value="' + file.file_name + '">')
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
    Dropzone.options.manualDropzone = {
    url: '{{ route('admin.resources.storeMedia') }}',
    acceptedFiles: '.jpeg,.jpg,.png,.gif,.pdf,.ogg,.mp3',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').find('input[name="manual"]').remove()
      $('form').append('<input type="hidden" name="manual" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="manual"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($resource) && $resource->manual)
      var file = {!! json_encode($resource->manual) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="manual" value="' + file.file_name + '">')
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
    Dropzone.options.imageManualDropzone = {
    url: '{{ route('admin.resources.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="image_manual"]').remove()
      $('form').append('<input type="hidden" name="image_manual" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="image_manual"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($resource) && $resource->image_manual)
      var file = {!! json_encode($resource->image_manual) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="image_manual" value="' + file.file_name + '">')
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
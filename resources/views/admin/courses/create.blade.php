@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.course.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="tematica_asociada_id">{{ trans('cruds.course.fields.tematica_asociada') }}</label>
                <select required class="form-control select2 {{ $errors->has('tematica_asociada') ? 'is-invalid' : '' }}" name="tematica_asociada_id" id="tematica_asociada_id">
                    @foreach($tematica_asociadas as $id => $entry)
                        <option value="{{ $id }}" {{ old('tematica_asociada_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tematica_asociada'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tematica_asociada') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.tematica_asociada_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.course.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="goal">{{ trans('cruds.course.fields.goal') }}</label>
                <textarea class="form-control {{ $errors->has('goal') ? 'is-invalid' : '' }}" name="goal" id="goal" required>{{ old('goal') }}</textarea>
                @if($errors->has('goal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('goal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.goal_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.course.fields.tipo_ciclo') }}</label>
                <select required class="form-control {{ $errors->has('tipo_ciclo') ? 'is-invalid' : '' }}" name="tipo_ciclo" id="tipo_ciclo">
                    <option value disabled {{ old('tipo_ciclo', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Course::TIPO_CICLO_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('tipo_ciclo', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('tipo_ciclo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tipo_ciclo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.tipo_ciclo_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('unico') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="unico" value="0">
                    <input class="form-check-input" type="checkbox" name="unico" id="unico" value="1" {{ old('unico', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="unico">{{ trans('cruds.course.fields.unico') }}</label>
                </div>
                @if($errors->has('unico'))
                    <div class="invalid-feedback">
                        {{ $errors->first('unico') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.unico_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mensaje_cierre">{{ trans('cruds.course.fields.mensaje_cierre') }} para participantes del ciclo</label>
                <textarea required class="form-control {{ $errors->has('mensaje_cierre') ? 'is-invalid' : '' }}" name="mensaje_cierre" id="mensaje_cierre">{{ old('mensaje_cierre') }}</textarea>
                @if($errors->has('mensaje_cierre'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mensaje_cierre') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.mensaje_cierre_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="imagen">Archivo imprimible para coordinadores</label>
                <div class="needsclick dropzone {{ $errors->has('imagen') ? 'is-invalid' : '' }}" id="imagen-dropzone">
                </div>
                @if($errors->has('imagen'))
                    <div class="invalid-feedback">
                        {{ $errors->first('imagen') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.imagen_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="additional_comments">{{ trans('cruds.course.fields.additional_comments') }}</label>
                <textarea class="form-control {{ $errors->has('additional_comments') ? 'is-invalid' : '' }}" name="additional_comments" id="additional_comments">{{ old('additional_comments') }}</textarea>
                @if($errors->has('additional_comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('additional_comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.course.fields.additional_comments_helper') }}</span>
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
    Dropzone.options.imagenDropzone = {
    url: '{{ route('admin.courses.storeMedia') }}',
    maxFilesize: 50, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
    },
    success: function (file, response) {
      $('form').find('input[name="imagen"]').remove()
      $('form').append('<input type="hidden" name="imagen" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="imagen"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($course) && $course->imagen)
      var file = {!! json_encode($course->imagen) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="imagen" value="' + file.file_name + '">')
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
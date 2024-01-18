@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.profile.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.profiles.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.profile.fields.name') }}</label>
                <input required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="entidad_asociada_id">{{ trans('cruds.profile.fields.entidad_asociada') }}</label>
                <select required class="form-control select2 {{ $errors->has('entidad_asociada') ? 'is-invalid' : '' }}" name="entidad_asociada_id" id="entidad_asociada_id">
                    @foreach($entidad_asociadas as $id => $entry)
                        <option value="{{ $id }}" {{ old('entidad_asociada_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('entidad_asociada'))
                    <div class="invalid-feedback">
                        {{ $errors->first('entidad_asociada') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.entidad_asociada_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="coursehooks">{{ trans('cruds.profile.fields.coursehook') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select required class="form-control select2 {{ $errors->has('coursehooks') ? 'is-invalid' : '' }}" name="coursehooks[]" id="coursehooks" multiple>
                    @foreach($coursehooks as $id => $coursehook)
                        <option value="{{ $id }}" {{ in_array($id, old('coursehooks', [])) ? 'selected' : '' }}>{{ $coursehook }}</option>
                    @endforeach
                </select>
                @if($errors->has('coursehooks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coursehooks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.coursehook_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.profile.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments') }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.profile.fields.comments_helper') }}</span>
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
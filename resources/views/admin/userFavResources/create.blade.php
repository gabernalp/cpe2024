@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userFavResource.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-fav-resources.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.userFavResource.fields.user') }}</label>
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
                <span class="help-block">{{ trans('cruds.userFavResource.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="resource_id">{{ trans('cruds.userFavResource.fields.resource') }}</label>
                <select required class="form-control select2 {{ $errors->has('resource') ? 'is-invalid' : '' }}" name="resource_id" id="resource_id">
                    @foreach($resources as $id => $entry)
                        <option value="{{ $id }}" {{ old('resource_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('resource'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resource') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.userFavResource.fields.resource_helper') }}</span>
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
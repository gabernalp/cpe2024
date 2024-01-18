@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.resourcesSubcategory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.resources-subcategories.update", [$resourcesSubcategory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="resourcescategory_id">{{ trans('cruds.resourcesSubcategory.fields.resourcescategory') }}</label>
                <select required class="form-control select2 {{ $errors->has('resourcescategory') ? 'is-invalid' : '' }}" name="resourcescategory_id" id="resourcescategory_id">
                    @foreach($resourcescategories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('resourcescategory_id') ? old('resourcescategory_id') : $resourcesSubcategory->resourcescategory->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('resourcescategory'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resourcescategory') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resourcesSubcategory.fields.resourcescategory_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.resourcesSubcategory.fields.name') }}</label>
                <input required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $resourcesSubcategory->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.resourcesSubcategory.fields.name_helper') }}</span>
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
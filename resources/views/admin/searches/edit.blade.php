@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.search.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.searches.update", [$search->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="search_item">{{ trans('cruds.search.fields.search_item') }}</label>
                <input required  class="form-control {{ $errors->has('search_item') ? 'is-invalid' : '' }}" type="text" name="search_item" id="search_item" value="{{ old('search_item', $search->search_item) }}">
                @if($errors->has('search_item'))
                    <div class="invalid-feedback">
                        {{ $errors->first('search_item') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.search.fields.search_item_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="resources">{{ trans('cruds.search.fields.resource') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('resources') ? 'is-invalid' : '' }}" name="resources[]" id="resources" multiple>
                    @foreach($resources as $id => $resource)
                        <option value="{{ $id }}" {{ (in_array($id, old('resources', [])) || $search->resources->contains($id)) ? 'selected' : '' }}>{{ $resource }}</option>
                    @endforeach
                </select>
                @if($errors->has('resources'))
                    <div class="invalid-feedback">
                        {{ $errors->first('resources') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.search.fields.resource_helper') }}</span>
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
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.tag.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tags.update", [$tag->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.tag.fields.name') }}</label>
                <input required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $tag->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.tag.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tag_category_id">{{ trans('cruds.tag.fields.tag_category') }}</label>
                <select class="form-control select2 {{ $errors->has('tag_category') ? 'is-invalid' : '' }}" name="tag_category_id" id="tag_category_id">
                    @foreach($tag_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('tag_category_id') ? old('tag_category_id') : $tag->tag_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('tag_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tag_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.tag.fields.tag_category_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="comments">{{ trans('cruds.tag.fields.comments') }}</label>
                <textarea class="form-control {{ $errors->has('comments') ? 'is-invalid' : '' }}" name="comments" id="comments">{{ old('comments', $tag->comments) }}</textarea>
                @if($errors->has('comments'))
                    <div class="invalid-feedback">
                        {{ $errors->first('comments') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.tag.fields.comments_helper') }}</span>
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
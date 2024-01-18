@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.tagCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tag-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.tagCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $tagCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tagCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $tagCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.tagCategory.fields.comments') }}
                        </th>
                        <td>
                            {{ $tagCategory->comments }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tag-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<!--<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#tag_category_tags" role="tab" data-toggle="tab">
                {{ trans('cruds.tag.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#tag_category_resources" role="tab" data-toggle="tab">
                {{ trans('cruds.resource.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="tag_category_tags">
            @includeIf('admin.tagCategories.relationships.tagCategoryTags', ['tags' => $tagCategory->tagCategoryTags])
        </div>
        <div class="tab-pane" role="tabpanel" id="tag_category_resources">
            @includeIf('admin.tagCategories.relationships.tagCategoryResources', ['resources' => $tagCategory->tagCategoryResources])
        </div>
    </div>
</div>-->

@endsection
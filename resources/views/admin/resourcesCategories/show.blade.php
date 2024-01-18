@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.resourcesCategory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.resources-categories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesCategory.fields.id') }}
                        </th>
                        <td>
                            {{ $resourcesCategory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesCategory.fields.name') }}
                        </th>
                        <td>
                            {{ $resourcesCategory->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesCategory.fields.description') }}
                        </th>
                        <td>
                            {{ $resourcesCategory->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.resources-categories.index') }}">
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
            <a class="nav-link" href="#resourcescategory_resources_subcategories" role="tab" data-toggle="tab">
                {{ trans('cruds.resourcesSubcategory.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#resourcescategory_resources" role="tab" data-toggle="tab">
                {{ trans('cruds.resource.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="resourcescategory_resources_subcategories">
            @includeIf('admin.resourcesCategories.relationships.resourcescategoryResourcesSubcategories', ['resourcesSubcategories' => $resourcesCategory->resourcescategoryResourcesSubcategories])
        </div>
        <div class="tab-pane" role="tabpanel" id="resourcescategory_resources">
            @includeIf('admin.resourcesCategories.relationships.resourcescategoryResources', ['resources' => $resourcesCategory->resourcescategoryResources])
        </div>
    </div>
</div>-->

@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.resource.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.resources.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.id') }}
                        </th>
                        <td>
                            {{ $resource->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.name') }}
                        </th>
                        <td>
                            {{ $resource->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.resourcescategory') }}
                        </th>
                        <td>
                            {{ $resource->resourcescategory->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.resource_subcategory') }}
                        </th>
                        <td>
                            @foreach($resource->resource_subcategories as $key => $resource_subcategory)
                                <span class="label label-info">{{ $resource_subcategory->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.imagen_archivo') }}
                        </th>
                        <td>
                            @if($resource->imagen_archivo)
                                <a href="{{ $resource->imagen_archivo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $resource->imagen_archivo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.file') }}
                        </th>
                        <td>
                            @if($resource->file)
                                <a href="{{ $resource->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.image_pdf') }}
                        </th>
                        <td>
                            @if($resource->image_pdf)
                                <a href="{{ $resource->image_pdf->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $resource->image_pdf->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.link') }}
                        </th>
                        <td>
                            {{ $resource->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.tag_category') }}
                        </th>
                        <td>
                            @foreach($resource->tag_categories as $key => $tag_category)
                                <span class="label label-info">{{ $tag_category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.tags') }}
                        </th>
                        <td>
                            @foreach($resource->tags as $key => $tags)
                                <span class="label label-info">{{ $tags->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.manual') }}
                        </th>
                        <td>
                            @if($resource->manual)
                                <a href="{{ $resource->manual->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.image_manual') }}
                        </th>
                        <td>
                            @if($resource->image_manual)
                                <a href="{{ $resource->image_manual->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $resource->image_manual->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resource.fields.comments') }}
                        </th>
                        <td>
                            {{ $resource->comments }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.resources.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
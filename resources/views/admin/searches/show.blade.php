@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.search.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.searches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.search.fields.id') }}
                        </th>
                        <td>
                            {{ $search->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.search.fields.search_item') }}
                        </th>
                        <td>
                            {{ $search->search_item }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.search.fields.resource') }}
                        </th>
                        <td>
                            @foreach($search->resources as $key => $resource)
                                <span class="label label-info">{{ $resource->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.searches.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
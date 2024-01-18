@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.resourcesAudit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.resources-audits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesAudit.fields.id') }}
                        </th>
                        <td>
                            {{ $resourcesAudit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesAudit.fields.recurso') }}
                        </th>
                        <td>
                            {{ $resourcesAudit->recurso->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesAudit.fields.ip') }}
                        </th>
                        <td>
                            {{ $resourcesAudit->ip }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.resourcesAudit.fields.user') }}
                        </th>
                        <td>
                            {{ $resourcesAudit->user->phone ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.resources-audits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
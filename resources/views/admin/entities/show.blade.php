@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.entity.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.entities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.entity.fields.id') }}
                        </th>
                        <td>
                            {{ $entity->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.entity.fields.name') }}
                        </th>
                        <td>
                            {{ $entity->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.entity.fields.initials') }}
                        </th>
                        <td>
                            {{ $entity->initials }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.entities.index') }}">
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
            <a class="nav-link" href="#entidad_courses_hooks" role="tab" data-toggle="tab">
                {{ trans('cruds.coursesHook.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#entidad_asociada_profiles" role="tab" data-toggle="tab">
                {{ trans('cruds.profile.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="entidad_courses_hooks">
            @includeIf('admin.entities.relationships.entidadCoursesHooks', ['coursesHooks' => $entity->entidadCoursesHooks])
        </div>
        <div class="tab-pane" role="tabpanel" id="entidad_asociada_profiles">
            @includeIf('admin.entities.relationships.entidadAsociadaProfiles', ['profiles' => $entity->entidadAsociadaProfiles])
        </div>
    </div>
</div>-->

@endsection
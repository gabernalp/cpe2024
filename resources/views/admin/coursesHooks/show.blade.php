@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coursesHook.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses-hooks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.id') }}
                        </th>
                        <td>
                            {{ $coursesHook->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.name') }}
                        </th>
                        <td>
                            {{ $coursesHook->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.description') }}
                        </th>
                        <td>
                            {{ $coursesHook->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.link') }}
                        </th>
                        <td>
                            {{ $coursesHook->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.file') }}
                        </th>
                        <td>
                            @if($coursesHook->file)
                                <a href="{{ $coursesHook->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.entidad') }}
                        </th>
                        <td>
                            {{ $coursesHook->entidad->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses-hooks.index') }}">
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
            <a class="nav-link" href="#courseshooks_self_interested_users" role="tab" data-toggle="tab">
                {{ trans('cruds.selfInterestedUser.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#coursehook_profiles" role="tab" data-toggle="tab">
                {{ trans('cruds.profile.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="courseshooks_self_interested_users">
            @includeIf('admin.coursesHooks.relationships.courseshooksSelfInterestedUsers', ['selfInterestedUsers' => $coursesHook->courseshooksSelfInterestedUsers])
        </div>
        <div class="tab-pane" role="tabpanel" id="coursehook_profiles">
            @includeIf('admin.coursesHooks.relationships.coursehookProfiles', ['profiles' => $coursesHook->coursehookProfiles])
        </div>
    </div>
</div>-->

@endsection
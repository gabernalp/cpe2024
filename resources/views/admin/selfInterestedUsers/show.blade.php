@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.selfInterestedUser.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.self-interested-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.id') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.profile') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->profile->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.name') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.lastname') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->lastname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.email') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.documenttype') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->documenttype->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.document') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->document }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.document_date') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->document_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.phone') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.education_background') }}
                        </th>
                        <td>
                            {{ App\Models\SelfInterestedUser::EDUCATION_BACKGROUND_RADIO[$selfInterestedUser->education_background] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.modality') }}
                        </th>
                        <td>
                            {{ App\Models\SelfInterestedUser::MODALITY_SELECT[$selfInterestedUser->modality] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.department') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->department->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.city') }}
                        </th>
                        <td>
                            {{ $selfInterestedUser->city->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.living_zone') }}
                        </th>
                        <td>
                            {{ App\Models\SelfInterestedUser::LIVING_ZONE_SELECT[$selfInterestedUser->living_zone] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.contacted') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $selfInterestedUser->contacted ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.selfInterestedUser.fields.courseshooks') }}
                        </th>
                        <td>
                            @foreach($selfInterestedUser->courseshooks as $key => $courseshooks)
                                <span class="label label-info">{{ $courseshooks->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.self-interested-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
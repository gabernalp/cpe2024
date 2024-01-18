@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.challengesUser.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.challenges-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.id') }}
                        </th>
                        <td>
                            {{ $challengesUser->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.courseschedule') }}
                        </th>
                        <td>
                            {{ $challengesUser->courseschedule->start_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.user') }}
                        </th>
                        <td>
                            {{ $challengesUser->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.challenge') }}
                        </th>
                        <td>
                            {{ $challengesUser->challenge->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.reference_text') }}
                        </th>
                        <td>
                            {{ $challengesUser->reference_text }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.reference_media') }}
                        </th>
                        <td>
                            {!! $challengesUser->reference_media !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.file') }}
                        </th>
                        <td>
                            @if($challengesUser->file)
                                <a href="{{ $challengesUser->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.challengesUser.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\ChallengesUser::STATUS_SELECT[$challengesUser->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.challenges-users.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
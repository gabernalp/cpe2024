@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.technicalReferrer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.technical-referrers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.technicalReferrer.fields.id') }}
                        </th>
                        <td>
                            {{ $technicalReferrer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.technicalReferrer.fields.name') }}
                        </th>
                        <td>
                            {{ $technicalReferrer->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.technicalReferrer.fields.link') }}
                        </th>
                        <td>
                            {{ $technicalReferrer->link }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.technical-referrers.index') }}">
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
            <a class="nav-link" href="#technical_referrers_meetings" role="tab" data-toggle="tab">
                {{ trans('cruds.meeting.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="technical_referrers_meetings">
            @includeIf('admin.technicalReferrers.relationships.technicalReferrersMeetings', ['meetings' => $technicalReferrer->technicalReferrersMeetings])
        </div>
    </div>
</div>-->

@endsection
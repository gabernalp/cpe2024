@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.whatsappWord.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whatsapp-words.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.id') }}
                        </th>
                        <td>
                            {{ $whatsappWord->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.word') }}
                        </th>
                        <td>
                            {{ $whatsappWord->word }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.object') }}
                        </th>
                        <td>
                            {{ $whatsappWord->object }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.action') }}
                        </th>
                        <td>
                            {{ $whatsappWord->action }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.link') }}
                        </th>
                        <td>
                            {{ $whatsappWord->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.message') }}
                        </th>
                        <td>
                            {{ $whatsappWord->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\WhatsappWord::STATUS_SELECT[$whatsappWord->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.extra') }}
                        </th>
                        <td>
                            {{ $whatsappWord->extra }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.image') }}
                        </th>
                        <td>
                            @if($whatsappWord->image)
                                <a href="{{ $whatsappWord->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $whatsappWord->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.whatsappWord.fields.file') }}
                        </th>
                        <td>
                            @if($whatsappWord->file)
                                <a href="{{ $whatsappWord->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.whatsapp-words.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
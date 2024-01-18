@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.closeImage.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.close-images.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.closeImage.fields.id') }}
                        </th>
                        <td>
                            {{ $closeImage->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.closeImage.fields.image') }}
                        </th>
                        <td>
                            @if($closeImage->image)
                                <a href="{{ $closeImage->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $closeImage->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.closeImage.fields.answered_challenges') }}
                        </th>
                        <td>
                            {{ $closeImage->answered_challenges }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.close-images.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
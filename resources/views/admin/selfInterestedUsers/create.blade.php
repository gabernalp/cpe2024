@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.selfInterestedUser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.self-interested-users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="profile_id">{{ trans('cruds.selfInterestedUser.fields.profile') }}</label>
                <select required class="form-control select2 {{ $errors->has('profile') ? 'is-invalid' : '' }}" name="profile_id" id="profile_id">
                    @foreach($profiles as $id => $entry)
                        <option value="{{ $id }}" {{ old('profile_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('profile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('profile') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.profile_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.selfInterestedUser.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="lastname">{{ trans('cruds.selfInterestedUser.fields.lastname') }}</label>
                <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', '') }}" required>
                @if($errors->has('lastname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lastname') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.lastname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.selfInterestedUser.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="documenttype_id">{{ trans('cruds.selfInterestedUser.fields.documenttype') }}</label>
                <select class="form-control select2 {{ $errors->has('documenttype') ? 'is-invalid' : '' }}" name="documenttype_id" id="documenttype_id" required>
                    @foreach($documenttypes as $id => $entry)
                        <option value="{{ $id }}" {{ old('documenttype_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('documenttype'))
                    <div class="invalid-feedback">
                        {{ $errors->first('documenttype') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.documenttype_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="document">{{ trans('cruds.selfInterestedUser.fields.document') }}</label>
                <input class="form-control {{ $errors->has('document') ? 'is-invalid' : '' }}" type="number" name="document" id="document" value="{{ old('document', '') }}" step="1" required>
                @if($errors->has('document'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.document_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="document_date">{{ trans('cruds.selfInterestedUser.fields.document_date') }}</label>
                <input class="form-control date {{ $errors->has('document_date') ? 'is-invalid' : '' }}" type="text" name="document_date" id="document_date" value="{{ old('document_date') }}" required>
                @if($errors->has('document_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('document_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.document_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.selfInterestedUser.fields.phone') }}</label>
                <input required class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.selfInterestedUser.fields.education_background') }}</label>
                @foreach(App\Models\SelfInterestedUser::EDUCATION_BACKGROUND_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('education_background') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="education_background_{{ $key }}" name="education_background" value="{{ $key }}" {{ old('education_background', '') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="education_background_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('education_background'))
                    <div class="invalid-feedback">
                        {{ $errors->first('education_background') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.education_background_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.selfInterestedUser.fields.modality') }}</label>
                <select class="form-control {{ $errors->has('modality') ? 'is-invalid' : '' }}" name="modality" id="modality" required>
                    <option value disabled {{ old('modality', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SelfInterestedUser::MODALITY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('modality', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('modality'))
                    <div class="invalid-feedback">
                        {{ $errors->first('modality') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.modality_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="department_id">{{ trans('cruds.selfInterestedUser.fields.department') }}</label>
                <select class="form-control select2 {{ $errors->has('department') ? 'is-invalid' : '' }}" name="department_id" id="department_id">
                    @foreach($departments as $id => $entry)
                        <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('department'))
                    <div class="invalid-feedback">
                        {{ $errors->first('department') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.department_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.selfInterestedUser.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.city_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.selfInterestedUser.fields.living_zone') }}</label>
                <select class="form-control {{ $errors->has('living_zone') ? 'is-invalid' : '' }}" name="living_zone" id="living_zone" required>
                    <option value disabled {{ old('living_zone', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\SelfInterestedUser::LIVING_ZONE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('living_zone', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('living_zone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('living_zone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.living_zone_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('contacted') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="contacted" value="0">
                    <input class="form-check-input" type="checkbox" name="contacted" id="contacted" value="1" {{ old('contacted', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="contacted">{{ trans('cruds.selfInterestedUser.fields.contacted') }}</label>
                </div>
                @if($errors->has('contacted'))
                    <div class="invalid-feedback">
                        {{ $errors->first('contacted') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.contacted_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="courseshooks">{{ trans('cruds.selfInterestedUser.fields.courseshooks') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select required class="form-control select2 {{ $errors->has('courseshooks') ? 'is-invalid' : '' }}" name="courseshooks[]" id="courseshooks" multiple>
                    @foreach($courseshooks as $id => $courseshook)
                        <option value="{{ $id }}" {{ in_array($id, old('courseshooks', [])) ? 'selected' : '' }}>{{ $courseshook }}</option>
                    @endforeach
                </select>
                @if($errors->has('courseshooks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('courseshooks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.courseshooks_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
<?php

namespace App\Http\Requests;

use App\Models\UserFavResource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserFavResourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_fav_resource_create');
    }

    public function rules()
    {
        return [];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_edit');
    }

    public function rules()
    {
        return [
            'document' => [
                'required',
                'nullable',
                'integer',
                'max:1999999999',
                'unique:users,document,' . request()->route('user')->id,
            ],
            'name' => [
                'string',
                'required',
                'max:191',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',                
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->route('user')->id,
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s\@]*$/',

            ],
            'phone' => [
                'string',
                'required',
                'min:10',
                'max:12',
                'unique:users,phone,' . request()->route('user')->id,
                'alpha_num',
            ],
            'devices.*' => [
                'integer',
            ],
            'devices' => [
                'array',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
        ];
    }
}

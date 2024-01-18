<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
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
                'unique:users,document,' . $this->user()->id,
            ],
            'name' => [
                'string',
                'required',
                'max:191',
            ],
            'email' => [
                'required',
                'unique:users,email,' . $this->user()->id,
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s\@]*$/',
                'max:255',

            ],
            'phone' => [
                'string',
                'required',
                'min:10',
                'max:12',
                'unique:users,phone,' . $this->user()->id,
                'alpha_num'
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

<?php

namespace App\Http\Requests;

use App\Models\ChallengesUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateChallengesUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('challenges_user_create');
    }

    public function rules()
    {
        return [
            'reference_media' => [
                'string',
                'nullable',
            ],
            'user_id' => [
                'required',
            ],
            'challenge_id' => [
                'required',
            ],            
            'reference_text' => [
                'nullable',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\?\¿\¡\!\*\-\(\)\s\:\/\&]*$/',
            ],
        ];
    }
}

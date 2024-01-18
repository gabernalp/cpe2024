<?php

namespace App\Http\Requests;

use App\Models\WhatsappWord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWhatsappWordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whatsapp_word_create');
    }

    public function rules()
    {
        return [
            'word' => [
                'string',
                'nullable',
                'required',
                'max:191',
            ],
            'object' => [
                'string',
                'nullable',
                'max:191',
            ],
            'action' => [
                'string',
                'nullable',
                'max:191',
            ],
            'message' => [
                'string',
                'nullable',
                'required'
            ],
            'link' => [
                'string',
                'nullable',
                'max:191',
            ],
            'extra' => [
                'string',
                'nullable',
                'max:191',
            ],
        ];
    }
}

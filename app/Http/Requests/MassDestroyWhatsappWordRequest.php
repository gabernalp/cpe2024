<?php

namespace App\Http\Requests;

use App\Models\WhatsappWord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWhatsappWordRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('whatsapp_word_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whatsapp_words,id',
        ];
    }
}

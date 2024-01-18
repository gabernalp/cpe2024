<?php

namespace App\Http\Requests;

use App\Models\WhatsappWord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWhatsappWordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whatsapp_word_edit');
    }

    public function rules()
    {
        return [
            'word' => [
                'string',
                'required',
                'max:191',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',    
            ],
            'object' => [
                'string',
                'nullable',
                'max:191',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',              ],
            'action' => [
                'string',
                'nullable',
            ],
            'link' => [
                'string',
                'nullable',
                'max:191',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',  
            ],
            'message' => [
                'string',
                'nullable',
                'required',
            ],
            'extra' => [
                'string',
                'nullable',
                'max:191',
                'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9,\.\;\(\)\s]*$/',              ],
        ];
    }
}

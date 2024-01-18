<?php

namespace App\Http\Requests;

use App\Models\CloseImage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCloseImageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('close_image_create');
    }

    public function rules()
    {
        return [
            'answered_challenges' => [
                'nullable',
                'integer',
            ],
        ];
    }
}

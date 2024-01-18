<?php

namespace App\Http\Requests;

use App\Models\CloseImage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCloseImageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('close_image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:close_images,id',
        ];
    }
}

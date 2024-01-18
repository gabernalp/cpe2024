<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCloseImageRequest;
use App\Http\Requests\UpdateCloseImageRequest;
use App\Http\Resources\Admin\CloseImageResource;
use App\Models\CloseImage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CloseImageApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('close_image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CloseImageResource(CloseImage::all());
    }

    public function store(StoreCloseImageRequest $request)
    {
        $closeImage = CloseImage::create($request->all());

        if ($request->input('image', false)) {
            $closeImage->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        return (new CloseImageResource($closeImage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CloseImage $closeImage)
    {
        abort_if(Gate::denies('close_image_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CloseImageResource($closeImage);
    }

    public function update(UpdateCloseImageRequest $request, CloseImage $closeImage)
    {
        $closeImage->update($request->all());

        if ($request->input('image', false)) {
            if (!$closeImage->image || $request->input('image') !== $closeImage->image->file_name) {
                if ($closeImage->image) {
                    $closeImage->image->delete();
                }
                $closeImage->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($closeImage->image) {
            $closeImage->image->delete();
        }

        return (new CloseImageResource($closeImage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CloseImage $closeImage)
    {
        abort_if(Gate::denies('close_image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $closeImage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

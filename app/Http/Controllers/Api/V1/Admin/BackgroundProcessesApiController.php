<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreBackgroundProcessRequest;
use App\Http\Requests\UpdateBackgroundProcessRequest;
use App\Http\Resources\Admin\BackgroundProcessResource;
use App\Models\BackgroundProcess;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BackgroundProcessesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('background_process_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BackgroundProcessResource(BackgroundProcess::all());
    }

    public function store(StoreBackgroundProcessRequest $request)
    {
        $backgroundProcess = BackgroundProcess::create($request->all());

        foreach ($request->input('file', []) as $file) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file');
        }

        foreach ($request->input('images', []) as $file) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($request->input('imagen_especial', false)) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_especial'))))->toMediaCollection('imagen_especial');
        }

        return (new BackgroundProcessResource($backgroundProcess))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BackgroundProcessResource($backgroundProcess);
    }

    public function update(UpdateBackgroundProcessRequest $request, BackgroundProcess $backgroundProcess)
    {
        $backgroundProcess->update($request->all());

        if (count($backgroundProcess->file) > 0) {
            foreach ($backgroundProcess->file as $media) {
                if (!in_array($media->file_name, $request->input('file', []))) {
                    $media->delete();
                }
            }
        }
        $media = $backgroundProcess->file->pluck('file_name')->toArray();
        foreach ($request->input('file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file');
            }
        }

        if (count($backgroundProcess->images) > 0) {
            foreach ($backgroundProcess->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $backgroundProcess->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        if ($request->input('imagen_especial', false)) {
            if (!$backgroundProcess->imagen_especial || $request->input('imagen_especial') !== $backgroundProcess->imagen_especial->file_name) {
                if ($backgroundProcess->imagen_especial) {
                    $backgroundProcess->imagen_especial->delete();
                }
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_especial'))))->toMediaCollection('imagen_especial');
            }
        } elseif ($backgroundProcess->imagen_especial) {
            $backgroundProcess->imagen_especial->delete();
        }

        return (new BackgroundProcessResource($backgroundProcess))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $backgroundProcess->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

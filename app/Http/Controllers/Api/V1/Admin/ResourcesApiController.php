<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Http\Resources\Admin\ResourceResource;
use App\Models\Resource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('resource_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourceResource(Resource::with(['resourcescategory', 'resource_subcategories', 'tag_categories', 'tags'])->get());
    }

    public function store(StoreResourceRequest $request)
    {
        $resource = Resource::create($request->all());
        $resource->resource_subcategories()->sync($request->input('resource_subcategories', []));
        $resource->tag_categories()->sync($request->input('tag_categories', []));
        $resource->tags()->sync($request->input('tags', []));
        if ($request->input('imagen_archivo', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_archivo'))))->toMediaCollection('imagen_archivo');
        }

        if ($request->input('file', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($request->input('image_pdf', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_pdf'))))->toMediaCollection('image_pdf');
        }

        if ($request->input('manual', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('manual'))))->toMediaCollection('manual');
        }

        if ($request->input('image_manual', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_manual'))))->toMediaCollection('image_manual');
        }

        return (new ResourceResource($resource))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Resource $resource)
    {
        abort_if(Gate::denies('resource_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourceResource($resource->load(['resourcescategory', 'resource_subcategories', 'tag_categories', 'tags']));
    }

    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $resource->update($request->all());
        $resource->resource_subcategories()->sync($request->input('resource_subcategories', []));
        $resource->tag_categories()->sync($request->input('tag_categories', []));
        $resource->tags()->sync($request->input('tags', []));
        if ($request->input('imagen_archivo', false)) {
            if (!$resource->imagen_archivo || $request->input('imagen_archivo') !== $resource->imagen_archivo->file_name) {
                if ($resource->imagen_archivo) {
                    $resource->imagen_archivo->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_archivo'))))->toMediaCollection('imagen_archivo');
            }
        } elseif ($resource->imagen_archivo) {
            $resource->imagen_archivo->delete();
        }

        if ($request->input('file', false)) {
            if (!$resource->file || $request->input('file') !== $resource->file->file_name) {
                if ($resource->file) {
                    $resource->file->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($resource->file) {
            $resource->file->delete();
        }

        if ($request->input('image_pdf', false)) {
            if (!$resource->image_pdf || $request->input('image_pdf') !== $resource->image_pdf->file_name) {
                if ($resource->image_pdf) {
                    $resource->image_pdf->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_pdf'))))->toMediaCollection('image_pdf');
            }
        } elseif ($resource->image_pdf) {
            $resource->image_pdf->delete();
        }

        if ($request->input('manual', false)) {
            if (!$resource->manual || $request->input('manual') !== $resource->manual->file_name) {
                if ($resource->manual) {
                    $resource->manual->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('manual'))))->toMediaCollection('manual');
            }
        } elseif ($resource->manual) {
            $resource->manual->delete();
        }

        if ($request->input('image_manual', false)) {
            if (!$resource->image_manual || $request->input('image_manual') !== $resource->image_manual->file_name) {
                if ($resource->image_manual) {
                    $resource->image_manual->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_manual'))))->toMediaCollection('image_manual');
            }
        } elseif ($resource->image_manual) {
            $resource->image_manual->delete();
        }

        return (new ResourceResource($resource))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Resource $resource)
    {
        abort_if(Gate::denies('resource_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

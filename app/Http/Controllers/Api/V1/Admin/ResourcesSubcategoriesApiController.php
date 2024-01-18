<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourcesSubcategoryRequest;
use App\Http\Requests\UpdateResourcesSubcategoryRequest;
use App\Http\Resources\Admin\ResourcesSubcategoryResource;
use App\Models\ResourcesSubcategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesSubcategoriesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('resources_subcategory_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourcesSubcategoryResource(ResourcesSubcategory::with(['resourcescategory'])->get());
    }

    public function store(StoreResourcesSubcategoryRequest $request)
    {
        $resourcesSubcategory = ResourcesSubcategory::create($request->all());

        return (new ResourcesSubcategoryResource($resourcesSubcategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourcesSubcategoryResource($resourcesSubcategory->load(['resourcescategory']));
    }

    public function update(UpdateResourcesSubcategoryRequest $request, ResourcesSubcategory $resourcesSubcategory)
    {
        $resourcesSubcategory->update($request->all());

        return (new ResourcesSubcategoryResource($resourcesSubcategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesSubcategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

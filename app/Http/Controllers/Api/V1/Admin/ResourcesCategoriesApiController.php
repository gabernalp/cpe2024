<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourcesCategoryRequest;
use App\Http\Requests\UpdateResourcesCategoryRequest;
use App\Http\Resources\Admin\ResourcesCategoryResource;
use App\Models\ResourcesCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesCategoriesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('resources_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourcesCategoryResource(ResourcesCategory::all());
    }

    public function store(StoreResourcesCategoryRequest $request)
    {
        $resourcesCategory = ResourcesCategory::create($request->all());

        return (new ResourcesCategoryResource($resourcesCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourcesCategoryResource($resourcesCategory);
    }

    public function update(UpdateResourcesCategoryRequest $request, ResourcesCategory $resourcesCategory)
    {
        $resourcesCategory->update($request->all());

        return (new ResourcesCategoryResource($resourcesCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

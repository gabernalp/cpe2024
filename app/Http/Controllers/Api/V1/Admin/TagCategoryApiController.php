<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagCategoryRequest;
use App\Http\Requests\UpdateTagCategoryRequest;
use App\Http\Resources\Admin\TagCategoryResource;
use App\Models\TagCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TagCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tag_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TagCategoryResource(TagCategory::all());
    }

    public function store(StoreTagCategoryRequest $request)
    {
        $tagCategory = TagCategory::create($request->all());

        return (new TagCategoryResource($tagCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TagCategory $tagCategory)
    {
        abort_if(Gate::denies('tag_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TagCategoryResource($tagCategory);
    }

    public function update(UpdateTagCategoryRequest $request, TagCategory $tagCategory)
    {
        $tagCategory->update($request->all());

        return (new TagCategoryResource($tagCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TagCategory $tagCategory)
    {
        abort_if(Gate::denies('tag_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tagCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

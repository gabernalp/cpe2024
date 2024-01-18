<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSearchRequest;
use App\Http\Requests\UpdateSearchRequest;
use App\Http\Resources\Admin\SearchResource;
use App\Models\Search;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SearchResource(Search::with(['resources'])->get());
    }

    public function store(StoreSearchRequest $request)
    {
        $search = Search::create($request->all());
        $search->resources()->sync($request->input('resources', []));

        return (new SearchResource($search))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Search $search)
    {
        abort_if(Gate::denies('search_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SearchResource($search->load(['resources']));
    }

    public function update(UpdateSearchRequest $request, Search $search)
    {
        $search->update($request->all());
        $search->resources()->sync($request->input('resources', []));

        return (new SearchResource($search))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Search $search)
    {
        abort_if(Gate::denies('search_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

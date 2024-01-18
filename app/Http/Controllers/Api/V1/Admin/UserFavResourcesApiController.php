<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserFavResourceRequest;
use App\Http\Requests\UpdateUserFavResourceRequest;
use App\Http\Resources\Admin\UserFavResourceResource;
use App\Models\UserFavResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserFavResourcesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_fav_resource_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserFavResourceResource(UserFavResource::with(['user', 'resource'])->get());
    }

    public function store(StoreUserFavResourceRequest $request)
    {
        $userFavResource = UserFavResource::create($request->all());

        return (new UserFavResourceResource($userFavResource))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserFavResource $userFavResource)
    {
        abort_if(Gate::denies('user_fav_resource_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserFavResourceResource($userFavResource->load(['user', 'resource']));
    }

    public function update(UpdateUserFavResourceRequest $request, UserFavResource $userFavResource)
    {
        $userFavResource->update($request->all());

        return (new UserFavResourceResource($userFavResource))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserFavResource $userFavResource)
    {
        abort_if(Gate::denies('user_fav_resource_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userFavResource->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\Admin\ProfileResource;
use App\Models\Profile;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfilesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProfileResource(Profile::with(['entidad_asociada', 'coursehooks'])->get());
    }

    public function store(StoreProfileRequest $request)
    {
        $profile = Profile::create($request->all());
        $profile->coursehooks()->sync($request->input('coursehooks', []));

        return (new ProfileResource($profile))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Profile $profile)
    {
        abort_if(Gate::denies('profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProfileResource($profile->load(['entidad_asociada', 'coursehooks']));
    }

    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->update($request->all());
        $profile->coursehooks()->sync($request->input('coursehooks', []));

        return (new ProfileResource($profile))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Profile $profile)
    {
        abort_if(Gate::denies('profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profile->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

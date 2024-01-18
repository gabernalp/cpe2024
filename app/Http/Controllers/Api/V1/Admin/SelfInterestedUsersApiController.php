<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSelfInterestedUserRequest;
use App\Http\Requests\UpdateSelfInterestedUserRequest;
use App\Http\Resources\Admin\SelfInterestedUserResource;
use App\Models\SelfInterestedUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SelfInterestedUsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('self_interested_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SelfInterestedUserResource(SelfInterestedUser::with(['profile', 'documenttype', 'department', 'city', 'courseshooks'])->get());
    }

    public function store(StoreSelfInterestedUserRequest $request)
    {
        $selfInterestedUser = SelfInterestedUser::create($request->all());
        $selfInterestedUser->courseshooks()->sync($request->input('courseshooks', []));

        return (new SelfInterestedUserResource($selfInterestedUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SelfInterestedUserResource($selfInterestedUser->load(['profile', 'documenttype', 'department', 'city', 'courseshooks']));
    }

    public function update(UpdateSelfInterestedUserRequest $request, SelfInterestedUser $selfInterestedUser)
    {
        $selfInterestedUser->update($request->all());
        $selfInterestedUser->courseshooks()->sync($request->input('courseshooks', []));

        return (new SelfInterestedUserResource($selfInterestedUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfInterestedUser->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

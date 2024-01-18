<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreChallengesUserRequest;
use App\Http\Requests\UpdateChallengesUserRequest;
use App\Http\Resources\Admin\ChallengesUserResource;
use App\Models\ChallengesUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChallengesUsersApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('challenges_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChallengesUserResource(ChallengesUser::with(['courseschedule', 'user', 'challenge'])->get());
    }

    public function store(StoreChallengesUserRequest $request)
    {
        $challengesUser = ChallengesUser::create($request->all());

        if ($request->input('file', false)) {
            $challengesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new ChallengesUserResource($challengesUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChallengesUserResource($challengesUser->load(['courseschedule', 'user', 'challenge']));
    }

    public function update(UpdateChallengesUserRequest $request, ChallengesUser $challengesUser)
    {
        $challengesUser->update($request->all());

        if ($request->input('file', false)) {
            if (!$challengesUser->file || $request->input('file') !== $challengesUser->file->file_name) {
                if ($challengesUser->file) {
                    $challengesUser->file->delete();
                }
                $challengesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($challengesUser->file) {
            $challengesUser->file->delete();
        }

        return (new ChallengesUserResource($challengesUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUser->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

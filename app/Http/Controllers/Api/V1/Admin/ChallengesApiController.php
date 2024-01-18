<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Http\Resources\Admin\ChallengeResource;
use App\Models\Challenge;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChallengesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('challenge_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChallengeResource(Challenge::with(['course', 'referencetype_capsule', 'referencetype'])->get());
    }

    public function store(StoreChallengeRequest $request)
    {
        $challenge = Challenge::create($request->all());

        if ($request->input('capsule_file', false)) {
            $challenge->addMedia(storage_path('tmp/uploads/' . basename($request->input('capsule_file'))))->toMediaCollection('capsule_file');
        }

        return (new ChallengeResource($challenge))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChallengeResource($challenge->load(['course', 'referencetype_capsule', 'referencetype']));
    }

    public function update(UpdateChallengeRequest $request, Challenge $challenge)
    {
        $challenge->update($request->all());

        if ($request->input('capsule_file', false)) {
            if (!$challenge->capsule_file || $request->input('capsule_file') !== $challenge->capsule_file->file_name) {
                if ($challenge->capsule_file) {
                    $challenge->capsule_file->delete();
                }
                $challenge->addMedia(storage_path('tmp/uploads/' . basename($request->input('capsule_file'))))->toMediaCollection('capsule_file');
            }
        } elseif ($challenge->capsule_file) {
            $challenge->capsule_file->delete();
        }

        return (new ChallengeResource($challenge))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

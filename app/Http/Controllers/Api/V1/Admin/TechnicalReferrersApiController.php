<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnicalReferrerRequest;
use App\Http\Requests\UpdateTechnicalReferrerRequest;
use App\Http\Resources\Admin\TechnicalReferrerResource;
use App\Models\TechnicalReferrer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechnicalReferrersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('technical_referrer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TechnicalReferrerResource(TechnicalReferrer::all());
    }

    public function store(StoreTechnicalReferrerRequest $request)
    {
        $technicalReferrer = TechnicalReferrer::create($request->all());

        return (new TechnicalReferrerResource($technicalReferrer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TechnicalReferrer $technicalReferrer)
    {
        abort_if(Gate::denies('technical_referrer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TechnicalReferrerResource($technicalReferrer);
    }

    public function update(UpdateTechnicalReferrerRequest $request, TechnicalReferrer $technicalReferrer)
    {
        $technicalReferrer->update($request->all());

        return (new TechnicalReferrerResource($technicalReferrer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TechnicalReferrer $technicalReferrer)
    {
        abort_if(Gate::denies('technical_referrer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $technicalReferrer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

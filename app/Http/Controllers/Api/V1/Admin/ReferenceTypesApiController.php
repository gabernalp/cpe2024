<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReferenceTypeRequest;
use App\Http\Requests\UpdateReferenceTypeRequest;
use App\Http\Resources\Admin\ReferenceTypeResource;
use App\Models\ReferenceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReferenceTypesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reference_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReferenceTypeResource(ReferenceType::all());
    }

    public function store(StoreReferenceTypeRequest $request)
    {
        $referenceType = ReferenceType::create($request->all());

        return (new ReferenceTypeResource($referenceType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReferenceTypeResource($referenceType);
    }

    public function update(UpdateReferenceTypeRequest $request, ReferenceType $referenceType)
    {
        $referenceType->update($request->all());

        return (new ReferenceTypeResource($referenceType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResourcesAuditRequest;
use App\Http\Requests\UpdateResourcesAuditRequest;
use App\Http\Resources\Admin\ResourcesAuditResource;
use App\Models\ResourcesAudit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesAuditsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('resources_audit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourcesAuditResource(ResourcesAudit::with(['recurso', 'user'])->get());
    }

    public function store(StoreResourcesAuditRequest $request)
    {
        $resourcesAudit = ResourcesAudit::create($request->all());

        return (new ResourcesAuditResource($resourcesAudit))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ResourcesAuditResource($resourcesAudit->load(['recurso', 'user']));
    }

    public function update(UpdateResourcesAuditRequest $request, ResourcesAudit $resourcesAudit)
    {
        $resourcesAudit->update($request->all());

        return (new ResourcesAuditResource($resourcesAudit))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesAudit->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

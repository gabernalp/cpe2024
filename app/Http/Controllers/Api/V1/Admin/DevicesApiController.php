<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Http\Resources\Admin\DeviceResource;
use App\Models\Device;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DevicesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('device_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeviceResource(Device::all());
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->all());

        return (new DeviceResource($device))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Device $device)
    {
        abort_if(Gate::denies('device_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DeviceResource($device);
    }

    public function update(UpdateDeviceRequest $request, Device $device)
    {
        $device->update($request->all());

        return (new DeviceResource($device))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Device $device)
    {
        abort_if(Gate::denies('device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $device->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

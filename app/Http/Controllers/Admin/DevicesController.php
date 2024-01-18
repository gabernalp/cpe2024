<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDeviceRequest;
use App\Http\Requests\StoreDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Device;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DevicesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('device_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Device::query()->select(sprintf('%s.*', (new Device())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'device_show';
                $editGate = 'device_edit';
                $deleteGate = 'device_delete';
                $crudRoutePart = 'devices';

                return view('partials.datatablesActions', compact(
                'viewGate',
                'editGate',
                'deleteGate',
                'crudRoutePart',
                'row'
            ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.devices.index');
    }

    public function create()
    {
        abort_if(Gate::denies('device_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.devices.create');
    }

    public function store(StoreDeviceRequest $request)
    {
        $device = Device::create($request->all());

        return redirect()->route('admin.devices.index');
    }

    public function edit(Device $device)
    {
        abort_if(Gate::denies('device_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.devices.edit', compact('device'));
    }

    public function update(UpdateDeviceRequest $request, Device $device)
    {
        $device->update($request->all());

        return redirect()->route('admin.devices.index');
    }

    public function show(Device $device)
    {
        abort_if(Gate::denies('device_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.devices.show', compact('device'));
    }

    public function destroy(Device $device)
    {
        abort_if(Gate::denies('device_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $device->delete();

        return back();
    }

    public function massDestroy(MassDestroyDeviceRequest $request)
    {
        Device::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

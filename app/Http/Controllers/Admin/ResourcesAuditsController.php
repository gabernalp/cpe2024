<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResourcesAuditRequest;
use App\Http\Requests\StoreResourcesAuditRequest;
use App\Http\Requests\UpdateResourcesAuditRequest;
use App\Models\Resource;
use App\Models\ResourcesAudit;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ResourcesAuditsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('resources_audit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ResourcesAudit::with(['recurso', 'user'])->select(sprintf('%s.*', (new ResourcesAudit())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'resources_audit_show';
                $editGate = 'resources_audit_edit';
                $deleteGate = 'resources_audit_delete';
                $crudRoutePart = 'resources-audits';

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
            $table->addColumn('recurso_name', function ($row) {
                return $row->recurso ? $row->recurso->name : '';
            });

            $table->editColumn('ip', function ($row) {
                return $row->ip ? $row->ip : '';
            });
            $table->addColumn('user_phone', function ($row) {
                return $row->user ? $row->user->phone : '';
            });

            $table->editColumn('user.document', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->document) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'recurso', 'user']);

            return $table->make(true);
        }

        return view('admin.resourcesAudits.index');
    }

    public function create()
    {
        abort_if(Gate::denies('resources_audit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recursos = Resource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.resourcesAudits.create', compact('recursos', 'users'));
    }

    public function store(StoreResourcesAuditRequest $request)
    {
        $resourcesAudit = ResourcesAudit::create($request->all());

        return redirect()->route('admin.resources-audits.index');
    }

    public function edit(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recursos = Resource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resourcesAudit->load('recurso', 'user');

        return view('admin.resourcesAudits.edit', compact('recursos', 'resourcesAudit', 'users'));
    }

    public function update(UpdateResourcesAuditRequest $request, ResourcesAudit $resourcesAudit)
    {
        $resourcesAudit->update($request->all());

        return redirect()->route('admin.resources-audits.index');
    }

    public function show(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesAudit->load('recurso', 'user');

        return view('admin.resourcesAudits.show', compact('resourcesAudit'));
    }

    public function destroy(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesAudit->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourcesAuditRequest $request)
    {
        ResourcesAudit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserFavResourceRequest;
use App\Http\Requests\StoreUserFavResourceRequest;
use App\Http\Requests\UpdateUserFavResourceRequest;
use App\Models\Resource;
use App\Models\User;
use App\Models\UserFavResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserFavResourcesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_fav_resource_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = UserFavResource::with(['user', 'resource'])->select(sprintf('%s.*', (new UserFavResource())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_fav_resource_show';
                $editGate = 'user_fav_resource_edit';
                $deleteGate = 'user_fav_resource_delete';
                $crudRoutePart = 'user-fav-resources';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('resource_name', function ($row) {
                return $row->resource ? $row->resource->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'resource']);

            return $table->make(true);
        }

        return view('admin.userFavResources.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_fav_resource_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resources = Resource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userFavResources.create', compact('resources', 'users'));
    }

    public function store(StoreUserFavResourceRequest $request)
    {
        $userFavResource = UserFavResource::create($request->all());

        return redirect()->route('admin.user-fav-resources.index');
    }

    public function edit(UserFavResource $userFavResource)
    {
        abort_if(Gate::denies('user_fav_resource_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resources = Resource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userFavResource->load('user', 'resource');

        return view('admin.userFavResources.edit', compact('resources', 'userFavResource', 'users'));
    }

    public function update(UpdateUserFavResourceRequest $request, UserFavResource $userFavResource)
    {
        $userFavResource->update($request->all());

        return redirect()->route('admin.user-fav-resources.index');
    }

    public function show(UserFavResource $userFavResource)
    {
        abort_if(Gate::denies('user_fav_resource_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userFavResource->load('user', 'resource');

        return view('admin.userFavResources.show', compact('userFavResource'));
    }

    public function destroy(UserFavResource $userFavResource)
    {
        abort_if(Gate::denies('user_fav_resource_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userFavResource->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserFavResourceRequest $request)
    {
        UserFavResource::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

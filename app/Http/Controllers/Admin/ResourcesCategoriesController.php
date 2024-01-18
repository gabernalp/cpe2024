<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResourcesCategoryRequest;
use App\Http\Requests\StoreResourcesCategoryRequest;
use App\Http\Requests\UpdateResourcesCategoryRequest;
use App\Models\ResourcesCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ResourcesCategoriesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('resources_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ResourcesCategory::query()->select(sprintf('%s.*', (new ResourcesCategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'resources_category_show';
                $editGate = 'resources_category_edit';
                $deleteGate = 'resources_category_delete';
                $crudRoutePart = 'resources-categories';

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
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.resourcesCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('resources_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.resourcesCategories.create');
    }

    public function store(StoreResourcesCategoryRequest $request)
    {
        $resourcesCategory = ResourcesCategory::create($request->all());

        return redirect()->route('admin.resources-categories.index');
    }

    public function edit(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.resourcesCategories.edit', compact('resourcesCategory'));
    }

    public function update(UpdateResourcesCategoryRequest $request, ResourcesCategory $resourcesCategory)
    {
        $resourcesCategory->update($request->all());

        return redirect()->route('admin.resources-categories.index');
    }

    public function show(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesCategory->load('resourcescategoryResourcesSubcategories', 'resourcescategoryResources');

        return view('admin.resourcesCategories.show', compact('resourcesCategory'));
    }

    public function destroy(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourcesCategoryRequest $request)
    {
        ResourcesCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

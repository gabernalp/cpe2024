<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResourcesSubcategoryRequest;
use App\Http\Requests\StoreResourcesSubcategoryRequest;
use App\Http\Requests\UpdateResourcesSubcategoryRequest;
use App\Models\ResourcesCategory;
use App\Models\ResourcesSubcategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ResourcesSubcategoriesController extends Controller
{
    use CsvImportTrait;
    
    public function get_by_category(Request $request)
    {

        if (!$request->category_id) {
            $html = '<option value="">'.trans('global.pleaseSelect').'</option>';
        } else {
            $html = '';
            $subcats = ResourcesSubcategory::where('resourcescategory_id', $request->category_id)->get();
            foreach ($subcats as $subcat) {
                $html .= '<option value="'.$subcat->id.'">'.$subcat->name.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('resources_subcategory_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ResourcesSubcategory::with(['resourcescategory'])->select(sprintf('%s.*', (new ResourcesSubcategory())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'resources_subcategory_show';
                $editGate = 'resources_subcategory_edit';
                $deleteGate = 'resources_subcategory_delete';
                $crudRoutePart = 'resources-subcategories';

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
            $table->addColumn('resourcescategory_name', function ($row) {
                return $row->resourcescategory ? $row->resourcescategory->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'resourcescategory']);

            return $table->make(true);
        }

        return view('admin.resourcesSubcategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('resources_subcategory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.resourcesSubcategories.create', compact('resourcescategories'));
    }

    public function store(StoreResourcesSubcategoryRequest $request)
    {
        $resourcesSubcategory = ResourcesSubcategory::create($request->all());

        return redirect()->route('admin.resources-subcategories.index');
    }

    public function edit(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resourcesSubcategory->load('resourcescategory');

        return view('admin.resourcesSubcategories.edit', compact('resourcesSubcategory', 'resourcescategories'));
    }

    public function update(UpdateResourcesSubcategoryRequest $request, ResourcesSubcategory $resourcesSubcategory)
    {
        $resourcesSubcategory->update($request->all());

        return redirect()->route('admin.resources-subcategories.index');
    }

    public function show(ResourcesSubcategory $resourcesSubcategory)
    {
        
        abort_if(Gate::denies('resources_subcategory_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesSubcategory->load('resourcescategory', 'resourceSubcategoryResources');

        return view('admin.resourcesSubcategories.show', compact('resourcesSubcategory'));
    }

    public function destroy(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesSubcategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourcesSubcategoryRequest $request)
    {
        ResourcesSubcategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

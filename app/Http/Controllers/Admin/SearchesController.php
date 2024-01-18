<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySearchRequest;
use App\Http\Requests\StoreSearchRequest;
use App\Http\Requests\UpdateSearchRequest;
use App\Models\Resource;
use App\Models\Search;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SearchesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Search::with(['resources'])->select(sprintf('%s.*', (new Search())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'search_show';
                $editGate = 'search_edit';
                $deleteGate = 'search_delete';
                $crudRoutePart = 'searches';

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
            $table->editColumn('search_item', function ($row) {
                return $row->search_item ? $row->search_item : '';
            });
            $table->editColumn('resource', function ($row) {
                $labels = [];
                foreach ($row->resources as $resource) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $resource->name);
                }

                return implode(' ', $labels);
            });

            $table->rawColumns(['actions', 'placeholder', 'resource']);

            return $table->make(true);
        }

        return view('admin.searches.index');
    }

    public function create()
    {
        abort_if(Gate::denies('search_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resources = Resource::pluck('name', 'id');

        return view('admin.searches.create', compact('resources'));
    }

    public function store(StoreSearchRequest $request)
    {
        $search = Search::create($request->all());
        $search->resources()->sync($request->input('resources', []));

        return redirect()->route('admin.searches.index');
    }

    public function edit(Search $search)
    {
        abort_if(Gate::denies('search_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resources = Resource::pluck('name', 'id');

        $search->load('resources');

        return view('admin.searches.edit', compact('resources', 'search'));
    }

    public function update(UpdateSearchRequest $request, Search $search)
    {
        $search->update($request->all());
        $search->resources()->sync($request->input('resources', []));

        return redirect()->route('admin.searches.index');
    }

    public function show(Search $search)
    {
        abort_if(Gate::denies('search_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search->load('resources');

        return view('admin.searches.show', compact('search'));
    }

    public function destroy(Search $search)
    {
        abort_if(Gate::denies('search_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $search->delete();

        return back();
    }

    public function massDestroy(MassDestroySearchRequest $request)
    {
        Search::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

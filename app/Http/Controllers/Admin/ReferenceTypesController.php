<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyReferenceTypeRequest;
use App\Http\Requests\StoreReferenceTypeRequest;
use App\Http\Requests\UpdateReferenceTypeRequest;
use App\Models\ReferenceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ReferenceTypesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('reference_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ReferenceType::query()->select(sprintf('%s.*', (new ReferenceType())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'reference_type_show';
                $editGate = 'reference_type_edit';
                $deleteGate = 'reference_type_delete';
                $crudRoutePart = 'reference-types';

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
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.referenceTypes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('reference_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.referenceTypes.create');
    }

    public function store(StoreReferenceTypeRequest $request)
    {
        $referenceType = ReferenceType::create($request->all());

        return redirect()->route('admin.reference-types.index');
    }

    public function edit(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.referenceTypes.edit', compact('referenceType'));
    }

    public function update(UpdateReferenceTypeRequest $request, ReferenceType $referenceType)
    {
        $referenceType->update($request->all());

        return redirect()->route('admin.reference-types.index');
    }

    public function show(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.referenceTypes.show', compact('referenceType'));
    }

    public function destroy(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceType->delete();

        return back();
    }

    public function massDestroy(MassDestroyReferenceTypeRequest $request)
    {
        ReferenceType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

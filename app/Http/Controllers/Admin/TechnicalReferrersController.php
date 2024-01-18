<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyTechnicalReferrerRequest;
use App\Http\Requests\StoreTechnicalReferrerRequest;
use App\Http\Requests\UpdateTechnicalReferrerRequest;
use App\Models\TechnicalReferrer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechnicalReferrersController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('technical_referrer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $technicalReferrers = TechnicalReferrer::all();

        return view('admin.technicalReferrers.index', compact('technicalReferrers'));
    }

    public function create()
    {
        abort_if(Gate::denies('technical_referrer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.technicalReferrers.create');
    }

    public function store(StoreTechnicalReferrerRequest $request)
    {
        $technicalReferrer = TechnicalReferrer::create($request->all());

        return redirect()->route('admin.technical-referrers.index');
    }

    public function edit(TechnicalReferrer $technicalReferrer)
    {
        abort_if(Gate::denies('technical_referrer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.technicalReferrers.edit', compact('technicalReferrer'));
    }

    public function update(UpdateTechnicalReferrerRequest $request, TechnicalReferrer $technicalReferrer)
    {
        $technicalReferrer->update($request->all());

        return redirect()->route('admin.technical-referrers.index');
    }

    public function show(TechnicalReferrer $technicalReferrer)
    {
        abort_if(Gate::denies('technical_referrer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $technicalReferrer->load('technicalReferrersMeetings');

        return view('admin.technicalReferrers.show', compact('technicalReferrer'));
    }

    public function destroy(TechnicalReferrer $technicalReferrer)
    {
        abort_if(Gate::denies('technical_referrer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $technicalReferrer->delete();

        return back();
    }

    public function massDestroy(MassDestroyTechnicalReferrerRequest $request)
    {
        TechnicalReferrer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

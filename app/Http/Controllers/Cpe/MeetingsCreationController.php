<?php

namespace App\Http\Controllers\Cpe;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMeetingRequest;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Department;
use App\Models\Meeting;
use App\Models\TechnicalReferrer;
use App\Models\BackgroundProcess;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MeetingsCreationController extends Controller
{
    public function index(){
		 
		abort_if(Gate::denies('meeting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $technical_referrers = TechnicalReferrer::all()->pluck('name', 'id');
		
        return view('cpe.crear-encuentro', compact('technical_referrers'));
		
	}
	
	public function store(StoreMeetingRequest $request)
    {
        $meeting = Meeting::create($request->all());
        $meeting->technical_referrers()->sync($request->input('technical_referrers', []));
		$message = '<p>¡Tu encuentro ha sido creado!<br />Recuerda que será confirmado cuando tenga mínimo 2 inscritos y podrás acceder a la videollamada desde “tu perfil”.</p>';

        return redirect()->route('cpe.crear-encuentro.index')->with('message',$message)->with('share','share');

    }
}

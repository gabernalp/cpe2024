<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMeetingRequest;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use App\Models\Meeting;
use App\Models\TechnicalReferrer;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MeetingsController extends Controller
{
    use MediaUploadingTrait;
    
    public function hide(){

        abort_if(Gate::denies('meeting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = base_path('.env');

        if (file_exists($path)) {
            $old = env('ENCUENTROS');
            if($old == 'encendido') $new = 'apagado'; 
            if($old == 'apagado') $new = 'encendido';
            file_put_contents($path, str_replace(
                'ENCUENTROS='.$old, 'ENCUENTROS='.$new, file_get_contents($path)
            ));
        }
        
            return redirect()->route('admin.meetings.index');        
    }


    public function index(Request $request)
    {
        abort_if(Gate::denies('meeting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Meeting::with(['user', 'technical_referrers'])->select(sprintf('%s.*', (new Meeting())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'meeting_show';
                $editGate = 'meeting_edit';
                $deleteGate = 'meeting_delete';
                $crudRoutePart = 'meetings';

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

            $table->editColumn('user.email', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->email) : '';
            });
            $table->editColumn('user.phone', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->phone) : '';
            });
            $table->editColumn('user.document', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->document) : '';
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });

            $table->editColumn('time', function ($row) {
                return $row->time ? $row->time : '';
            });
            $table->editColumn('meeting_term', function ($row) {
                return $row->meeting_term ? Meeting::MEETING_TERM_SELECT[$row->meeting_term] : '';
            });
            $table->editColumn('methodology', function ($row) {
                return $row->methodology ? Meeting::METHODOLOGY_SELECT[$row->methodology] : '';
            });
            $table->editColumn('technical_referrers', function ($row) {
                $labels = [];
                foreach ($row->technical_referrers as $technical_referrer) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $technical_referrer->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('teachers_network', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->teachers_network ? 'checked' : null) . '>';
            });
            $table->editColumn('otro_referente', function ($row) {
                return $row->otro_referente ? $row->otro_referente : '';
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('observaciones', function ($row) {
                return $row->observaciones ? $row->observaciones : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'technical_referrers', 'teachers_network', 'file']);

            return $table->make(true);
        }

        return view('admin.meetings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('meeting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $technical_referrers = TechnicalReferrer::pluck('name', 'id');

        return view('admin.meetings.create', compact('technical_referrers', 'users'));
    }

    public function store(StoreMeetingRequest $request)
    {
        $meeting = Meeting::create($request->all());
        $meeting->technical_referrers()->sync($request->input('technical_referrers', []));
        if ($request->input('file', false)) {
            $meeting->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $meeting->id]);
        }

        return redirect()->route('admin.meetings.index');
    }

    public function edit(Meeting $meeting)
    {
        abort_if(Gate::denies('meeting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $technical_referrers = TechnicalReferrer::pluck('name', 'id');

        $meeting->load('user', 'technical_referrers');

        return view('admin.meetings.edit', compact('meeting', 'technical_referrers', 'users'));
    }

    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        $meeting->update($request->all());
        $meeting->technical_referrers()->sync($request->input('technical_referrers', []));
        if ($request->input('file', false)) {
            if (!$meeting->file || $request->input('file') !== $meeting->file->file_name) {
                if ($meeting->file) {
                    $meeting->file->delete();
                }
                $meeting->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($meeting->file) {
            $meeting->file->delete();
        }

        return redirect()->route('admin.meetings.index');
    }

    public function show(Meeting $meeting)
    {
        abort_if(Gate::denies('meeting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meeting->load('user', 'technical_referrers', 'meetingMeetingAttendants');

        return view('admin.meetings.show', compact('meeting'));
    }

    public function destroy(Meeting $meeting)
    {
        abort_if(Gate::denies('meeting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meeting->delete();

        return back();
    }

    public function massDestroy(MassDestroyMeetingRequest $request)
    {
        Meeting::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('meeting_create') && Gate::denies('meeting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Meeting();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

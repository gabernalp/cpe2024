<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyMeetingAttendantRequest;
use App\Http\Requests\StoreMeetingAttendantRequest;
use App\Http\Requests\UpdateMeetingAttendantRequest;
use App\Models\Meeting;
use App\Models\MeetingAttendant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MeetingAttendantsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('meeting_attendant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MeetingAttendant::with(['meeting', 'user'])->select(sprintf('%s.*', (new MeetingAttendant())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'meeting_attendant_show';
                $editGate = 'meeting_attendant_edit';
                $deleteGate = 'meeting_attendant_delete';
                $crudRoutePart = 'meeting-attendants';

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
            $table->addColumn('meeting_title', function ($row) {
                return $row->meeting ? $row->meeting->title : '';
            });

            $table->editColumn('meeting.date', function ($row) {
                return $row->meeting ? (is_string($row->meeting) ? $row->meeting : $row->meeting->date) : '';
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

            $table->rawColumns(['actions', 'placeholder', 'meeting', 'user']);

            return $table->make(true);
        }

        return view('admin.meetingAttendants.index');
    }

    public function create()
    {
        abort_if(Gate::denies('meeting_attendant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetings = Meeting::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.meetingAttendants.create', compact('meetings', 'users'));
    }

    public function store(StoreMeetingAttendantRequest $request)
    {
        $meetingAttendant = MeetingAttendant::create($request->all());

        return redirect()->route('admin.meeting-attendants.index');
    }

    public function edit(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetings = Meeting::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $meetingAttendant->load('meeting', 'user');

        return view('admin.meetingAttendants.edit', compact('meetingAttendant', 'meetings', 'users'));
    }

    public function update(UpdateMeetingAttendantRequest $request, MeetingAttendant $meetingAttendant)
    {
        $meetingAttendant->update($request->all());

        return redirect()->route('admin.meeting-attendants.index');
    }

    public function show(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingAttendant->load('meeting', 'user');

        return view('admin.meetingAttendants.show', compact('meetingAttendant'));
    }

    public function destroy(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingAttendant->delete();

        return back();
    }

    public function massDestroy(MassDestroyMeetingAttendantRequest $request)
    {
        MeetingAttendant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

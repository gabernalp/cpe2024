<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyChallengesUserRequest;
use App\Http\Requests\StoreChallengesUserRequest;
use App\Http\Requests\UpdateChallengesUserRequest;
use App\Models\Challenge;
use App\Models\ChallengesUser;
use App\Models\CourseSchedule;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ChallengesUsersController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('challenges_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ChallengesUser::with(['courseschedule', 'user', 'challenge'])->select(sprintf('%s.*', (new ChallengesUser())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'challenges_user_show';
                $editGate = 'challenges_user_edit';
                $deleteGate = 'challenges_user_delete';
                $crudRoutePart = 'challenges-users';

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
            $table->addColumn('courseschedule_start_date', function ($row) {
                return $row->courseschedule ? $row->courseschedule->start_date : '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('challenge_name', function ($row) {
                return $row->challenge ? $row->challenge->name : '';
            });

            $table->editColumn('challenge.goal', function ($row) {
                return $row->challenge ? (is_string($row->challenge) ? $row->challenge : $row->challenge->goal) : '';
            });
            $table->editColumn('reference_text', function ($row) {
                return $row->reference_text ? $row->reference_text : '';
            });
            $table->editColumn('reference_media', function ($row) {
                return $row->reference_media ? $row->reference_media : '';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? ChallengesUser::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'courseschedule', 'user', 'challenge', 'file']);

            return $table->make(true);
        }

        return view('admin.challengesUsers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('challenges_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $today = date("Y-m-d");
        
        $courseschedules = CourseSchedule::where('start_date','>',$today)->orWhere('start_date','=',$today)->get();

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $challenges = Challenge::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.challengesUsers.create', compact('challenges', 'courseschedules', 'users'));
    }

    public function store(StoreChallengesUserRequest $request)
    {
        $challengesUser = ChallengesUser::create($request->all());

        if ($request->input('file', false)) {
            $challengesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $challengesUser->id]);
        }

        return redirect()->route('admin.challenges-users.index');
    }

    public function edit(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courseschedules = CourseSchedule::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $challenges = Challenge::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $challengesUser->load('courseschedule', 'user', 'challenge');

        return view('admin.challengesUsers.edit', compact('challenges', 'challengesUser', 'courseschedules', 'users'));
    }

    public function update(UpdateChallengesUserRequest $request, ChallengesUser $challengesUser)
    {
        $challengesUser->update($request->all());

        if ($request->input('file', false)) {
            if (!$challengesUser->file || $request->input('file') !== $challengesUser->file->file_name) {
                if ($challengesUser->file) {
                    $challengesUser->file->delete();
                }
                $challengesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($challengesUser->file) {
            $challengesUser->file->delete();
        }

        return redirect()->route('admin.challenges-users.index');
    }

    public function show(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUser->load('courseschedule', 'user', 'challenge');

        return view('admin.challengesUsers.show', compact('challengesUser'));
    }

    public function destroy(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyChallengesUserRequest $request)
    {
        ChallengesUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('challenges_user_create') && Gate::denies('challenges_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ChallengesUser();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
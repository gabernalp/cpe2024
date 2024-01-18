<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyChallengeRequest;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\Models\Challenge;
use App\Models\Course;
use App\Models\ReferenceType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ChallengesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('challenge_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Challenge::with(['course', 'referencetype_capsule', 'referencetype'])->select(sprintf('%s.*', (new Challenge())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'challenge_show';
                $editGate = 'challenge_edit';
                $deleteGate = 'challenge_delete';
                $crudRoutePart = 'challenges';

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
            $table->addColumn('course_name', function ($row) {
                return $row->course ? $row->course->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('goal', function ($row) {
                return $row->goal ? $row->goal : '';
            });
            $table->addColumn('referencetype_capsule_name', function ($row) {
                return $row->referencetype_capsule ? $row->referencetype_capsule->name : '';
            });

            $table->editColumn('capsule_content', function ($row) {
                return $row->capsule_content ? $row->capsule_content : '';
            });
            $table->editColumn('capsule_file', function ($row) {
                return $row->capsule_file ? '<a href="' . $row->capsule_file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('challenge_action', function ($row) {
                return $row->challenge_action ? Challenge::CHALLENGE_ACTION_SELECT[$row->challenge_action] : '';
            });
            $table->editColumn('action_detail', function ($row) {
                return $row->action_detail ? $row->action_detail : '';
            });
            $table->addColumn('referencetype_name', function ($row) {
                return $row->referencetype ? $row->referencetype->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'course', 'referencetype_capsule', 'capsule_file', 'referencetype']);

            return $table->make(true);
        }

        return view('admin.challenges.index');
    }

    public function create()
    {
        abort_if(Gate::denies('challenge_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referencetype_capsules = ReferenceType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referencetypes = ReferenceType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.challenges.create', compact('courses', 'referencetype_capsules', 'referencetypes'));
    }

    public function store(StoreChallengeRequest $request)
    {
        $challenge = Challenge::create($request->all());

        if ($request->input('capsule_file', false)) {
            $challenge->addMedia(storage_path('tmp/uploads/' . basename($request->input('capsule_file'))))->toMediaCollection('capsule_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $challenge->id]);
        }

        return redirect()->route('admin.challenges.index');
    }

    public function edit(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referencetype_capsules = ReferenceType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referencetypes = ReferenceType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $challenge->load('course', 'referencetype_capsule', 'referencetype');

        return view('admin.challenges.edit', compact('challenge', 'courses', 'referencetype_capsules', 'referencetypes'));
    }

    public function update(UpdateChallengeRequest $request, Challenge $challenge)
    {
        $challenge->update($request->all());

        if ($request->input('capsule_file', false)) {
            if (!$challenge->capsule_file || $request->input('capsule_file') !== $challenge->capsule_file->file_name) {
                if ($challenge->capsule_file) {
                    $challenge->capsule_file->delete();
                }
                $challenge->addMedia(storage_path('tmp/uploads/' . basename($request->input('capsule_file'))))->toMediaCollection('capsule_file');
            }
        } elseif ($challenge->capsule_file) {
            $challenge->capsule_file->delete();
        }

        return redirect()->route('admin.challenges.index');
    }

    public function show(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge->load('course', 'referencetype_capsule', 'referencetype', 'challengeChallengesUsers');

        return view('admin.challenges.show', compact('challenge'));
    }

    public function destroy(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge->delete();

        return back();
    }

    public function massDestroy(MassDestroyChallengeRequest $request)
    {
        Challenge::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('challenge_create') && Gate::denies('challenge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Challenge();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

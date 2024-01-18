<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCoursesUserRequest;
use App\Http\Requests\StoreCoursesUserRequest;
use App\Http\Requests\UpdateCoursesUserRequest;
use App\Models\CourseSchedule;
use App\Models\CoursesUser;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CoursesUsersController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('courses_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CoursesUser::with(['user', 'course_schedule'])->select(sprintf('%s.*', (new CoursesUser())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'courses_user_show';
                $editGate = 'courses_user_edit';
                $deleteGate = 'courses_user_delete';
                $crudRoutePart = 'courses-users';

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

            $table->editColumn('user.document', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->document) : '';
            });
            $table->addColumn('course_schedule_start_date', function ($row) {
                return $row->course_schedule ? $row->course_schedule->start_date : '';
            });

            $table->editColumn('course_name', function ($row) {
                return $row->course_name ? $row->course_name : '';
            });
            $table->editColumn('whatsapp_user', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->whatsapp_user ? 'checked' : null) . '>';
            });
            $table->editColumn('actual_challenge', function ($row) {
                return $row->actual_challenge ? $row->actual_challenge : '';
            });
            $table->editColumn('alert_messages', function ($row) {
                return $row->alert_messages ? CoursesUser::ALERT_MESSAGES_SELECT[$row->alert_messages] : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? CoursesUser::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'course_schedule', 'whatsapp_user']);

            return $table->make(true);
        }

        return view('admin.coursesUsers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('courses_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');


        $course_schedules = CourseSchedule::get();

        return view('admin.coursesUsers.create', compact('course_schedules', 'users'));
    }

    public function store(StoreCoursesUserRequest $request)
    {
        $coursesUser = CoursesUser::create($request->all());

        if ($request->input('file', false)) {
            $coursesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $coursesUser->id]);
        }
        
        $updateCourseName = CoursesUser::find($coursesUser->id);
        $updateCourseName->course_name = $coursesUser->course_schedule->course->name;
        $updateCourseName->status = 'Inscrito';
        $updateCourseName->save();

        return redirect()->route('admin.courses-users.index');
    }

    public function edit(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course_schedules = CourseSchedule::pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursesUser->load('user', 'course_schedule');

        return view('admin.coursesUsers.edit', compact('course_schedules', 'coursesUser', 'users'));
    }

    public function update(UpdateCoursesUserRequest $request, CoursesUser $coursesUser)
    {
        $coursesUser->update($request->all());

        if ($request->input('file', false)) {
            if (!$coursesUser->file || $request->input('file') !== $coursesUser->file->file_name) {
                if ($coursesUser->file) {
                    $coursesUser->file->delete();
                }
                $coursesUser->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($coursesUser->file) {
            $coursesUser->file->delete();
        }

        return redirect()->route('admin.courses-users.index');
    }

    public function show(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesUser->load('user', 'course_schedule');

        return view('admin.coursesUsers.show', compact('coursesUser'));
    }

    public function destroy(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoursesUserRequest $request)
    {
        CoursesUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('courses_user_create') && Gate::denies('courses_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CoursesUser();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\City;
use App\Models\Department;
use App\Models\Device;
use App\Models\DocumentType;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['documenttype', 'department', 'city', 'devices', 'roles', 'profile'])->select(sprintf('%s.*', (new User())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

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
            $table->addColumn('documenttype_name', function ($row) {
                return $row->documenttype ? $row->documenttype->name : '';
            });

            $table->editColumn('document', function ($row) {
                return $row->document ? $row->document : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('gender', function ($row) {
                return $row->gender ? User::GENDER_SELECT[$row->gender] : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });
            $table->addColumn('department_name', function ($row) {
                return $row->department ? $row->department->name : '';
            });

            $table->addColumn('city_name', function ($row) {
                return $row->city ? $row->city->name : '';
            });

            $table->editColumn('etnia', function ($row) {
                return $row->etnia ? User::ETNIA_SELECT[$row->etnia] : '';
            });
            $table->editColumn('academic_background', function ($row) {
                return $row->academic_background ? User::ACADEMIC_BACKGROUND_SELECT[$row->academic_background] : '';
            });
            $table->editColumn('devices', function ($row) {
                $labels = [];
                foreach ($row->devices as $device) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $device->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('roles', function ($row) {
                $labels = [];
                foreach ($row->roles as $role) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $role->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('place_role', function ($row) {
                return $row->place_role ? User::PLACE_ROLE_SELECT[$row->place_role] : '';
            });
            $table->addColumn('profile_name', function ($row) {
                return $row->profile ? $row->profile->name : '';
            });

            $table->editColumn('profile_pic', function ($row) {
                if ($photo = $row->profile_pic) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'documenttype', 'department', 'city', 'devices', 'roles', 'profile', 'profile_pic']);

            return $table->make(true);
        }

        return view('admin.users.index');
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documenttypes = DocumentType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $devices = Device::pluck('name', 'id');

        $roles = Role::pluck('title', 'id');

        $profiles = Profile::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.users.create', compact('cities', 'departments', 'devices', 'documenttypes', 'profiles', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->devices()->sync($request->input('devices', []));
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('profile_pic', false)) {
            $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_pic'))))->toMediaCollection('profile_pic');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $user->id]);
        }

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documenttypes = DocumentType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $devices = Device::pluck('name', 'id');

        $roles = Role::pluck('title', 'id');

        $profiles = Profile::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('documenttype', 'department', 'city', 'devices', 'roles', 'profile');

        return view('admin.users.edit', compact('cities', 'departments', 'devices', 'documenttypes', 'profiles', 'roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->devices()->sync($request->input('devices', []));
        $user->roles()->sync($request->input('roles', []));
        if ($request->input('profile_pic', false)) {
            if (!$user->profile_pic || $request->input('profile_pic') !== $user->profile_pic->file_name) {
                if ($user->profile_pic) {
                    $user->profile_pic->delete();
                }
                $user->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_pic'))))->toMediaCollection('profile_pic');
            }
        } elseif ($user->profile_pic) {
            $user->profile_pic->delete();
        }

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('documenttype', 'department', 'city', 'devices', 'roles', 'profile', 'userCoursesUsers', 'userChallengesUsers', 'userMeetings', 'userCourseSchedules', 'userUserFavResources', 'userUserAlerts');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_create') && Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new User();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

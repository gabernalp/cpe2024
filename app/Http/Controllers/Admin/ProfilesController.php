<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProfileRequest;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\CoursesHook;
use App\Models\Entity;
use App\Models\Profile;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProfilesController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('profile_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Profile::with(['entidad_asociada', 'coursehooks'])->select(sprintf('%s.*', (new Profile())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'profile_show';
                $editGate = 'profile_edit';
                $deleteGate = 'profile_delete';
                $crudRoutePart = 'profiles';

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
            $table->addColumn('entidad_asociada_name', function ($row) {
                return $row->entidad_asociada ? $row->entidad_asociada->name : '';
            });

            $table->editColumn('coursehook', function ($row) {
                $labels = [];
                foreach ($row->coursehooks as $coursehook) {
                    $labels[] = sprintf('<span class="label label-info label-many"><small>· %s</small></span><br />', $coursehook->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'entidad_asociada', 'coursehook']);

            return $table->make(true);
        }

        return view('admin.profiles.index');
    }

    public function create()
    {
        abort_if(Gate::denies('profile_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entidad_asociadas = Entity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursehooks = CoursesHook::pluck('name', 'id');

        return view('admin.profiles.create', compact('coursehooks', 'entidad_asociadas'));
    }

    public function store(StoreProfileRequest $request)
    {
        $profile = Profile::create($request->all());
        $profile->coursehooks()->sync($request->input('coursehooks', []));

        return redirect()->route('admin.profiles.index');
    }

    public function edit(Profile $profile)
    {
        abort_if(Gate::denies('profile_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entidad_asociadas = Entity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursehooks = CoursesHook::pluck('name', 'id');

        $profile->load('entidad_asociada', 'coursehooks');

        return view('admin.profiles.edit', compact('coursehooks', 'entidad_asociadas', 'profile'));
    }

    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->update($request->all());
        $profile->coursehooks()->sync($request->input('coursehooks', []));

        return redirect()->route('admin.profiles.index');
    }

    public function show(Profile $profile)
    {
        abort_if(Gate::denies('profile_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profile->load('entidad_asociada', 'coursehooks');

        return view('admin.profiles.show', compact('profile'));
    }

    public function destroy(Profile $profile)
    {
        abort_if(Gate::denies('profile_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $profile->delete();

        return back();
    }

    public function massDestroy(MassDestroyProfileRequest $request)
    {
        Profile::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

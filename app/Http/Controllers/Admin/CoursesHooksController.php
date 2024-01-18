<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCoursesHookRequest;
use App\Http\Requests\StoreCoursesHookRequest;
use App\Http\Requests\UpdateCoursesHookRequest;
use App\Models\CoursesHook;
use App\Models\Entity;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CoursesHooksController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;
    
    public function hide(){
        
        abort_if(Gate::denies('courses_hook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $path = base_path('.env');

        if (file_exists($path)) {
            $old = env("OFERTAS");
            if($old == 'encendido') $new = 'apagado'; 
            if($old == 'apagado') $new = 'encendido';
            file_put_contents($path, str_replace(
                'OFERTAS='.$old, 'OFERTAS='.$new, file_get_contents($path)
            ));
        }
        
            return redirect()->route('admin.courses-hooks.index');        
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('courses_hook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CoursesHook::with(['entidad'])->select(sprintf('%s.*', (new CoursesHook())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'courses_hook_show';
                $editGate = 'courses_hook_edit';
                $deleteGate = 'courses_hook_delete';
                $crudRoutePart = 'courses-hooks';

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
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->addColumn('entidad_name', function ($row) {
                return $row->entidad ? $row->entidad->name : '';
            });

            $table->editColumn('entidad.initials', function ($row) {
                return $row->entidad ? (is_string($row->entidad) ? $row->entidad : $row->entidad->initials) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'file', 'entidad']);

            return $table->make(true);
        }

        return view('admin.coursesHooks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('courses_hook_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entidads = Entity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.coursesHooks.create', compact('entidads'));
    }

    public function store(StoreCoursesHookRequest $request)
    {
        $coursesHook = CoursesHook::create($request->all());

        if ($request->input('file', false)) {
            $coursesHook->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $coursesHook->id]);
        }

        return redirect()->route('admin.courses-hooks.index');
    }

    public function edit(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $entidads = Entity::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursesHook->load('entidad');

        return view('admin.coursesHooks.edit', compact('coursesHook', 'entidads'));
    }

    public function update(UpdateCoursesHookRequest $request, CoursesHook $coursesHook)
    {
        $coursesHook->update($request->all());

        if ($request->input('file', false)) {
            if (!$coursesHook->file || $request->input('file') !== $coursesHook->file->file_name) {
                if ($coursesHook->file) {
                    $coursesHook->file->delete();
                }
                $coursesHook->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($coursesHook->file) {
            $coursesHook->file->delete();
        }

        return redirect()->route('admin.courses-hooks.index');
    }

    public function show(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->load('entidad', 'courseshooksSelfInterestedUsers', 'coursehookProfiles');

        return view('admin.coursesHooks.show', compact('coursesHook'));
    }

    public function destroy(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoursesHookRequest $request)
    {
        CoursesHook::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('courses_hook_create') && Gate::denies('courses_hook_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CoursesHook();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\BackgroundProcess;
use App\Models\Course;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\App;

class CoursesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function hide(){
        
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $path = base_path('.env');

        if (file_exists($path)) {
            $old = env('CICLOS');
            if($old == 'encendido') $new = 'apagado'; 
            if($old == 'apagado') $new = 'encendido';
            file_put_contents($path, str_replace(
                'CICLOS='.$old, 'CICLOS='.$new, file_get_contents($path)
            ));
        }
        
    return redirect()->route('admin.courses.index');        
        
    }
    
    public function index(Request $request)
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Course::with(['tematica_asociada'])->select(sprintf('%s.*', (new Course())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'course_show';
                $editGate = 'course_edit';
                $deleteGate = 'course_delete';
                $crudRoutePart = 'courses';

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
            $table->addColumn('tematica_asociada_name', function ($row) {
                return $row->tematica_asociada ? $row->tematica_asociada->name : '';
            });

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('goal', function ($row) {
                return $row->goal ? $row->goal : '';
            });
            $table->editColumn('tipo_ciclo', function ($row) {
                return $row->tipo_ciclo ? Course::TIPO_CICLO_SELECT[$row->tipo_ciclo] : '';
            });
            $table->editColumn('unico', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->unico ? 'checked' : null) . '>';
            });
            $table->editColumn('additional_comments', function ($row) {
                return $row->additional_comments ? $row->additional_comments : '';
            });
            $table->editColumn('mensaje_cierre', function ($row) {
                return $row->mensaje_cierre ? $row->mensaje_cierre : '';
            });
            $table->editColumn('imagen', function ($row) {
                if ($photo = $row->imagen) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });

            $table->rawColumns(['actions', 'placeholder', 'tematica_asociada', 'unico', 'imagen']);

            return $table->make(true);
        }

        $background_processes = BackgroundProcess::get();

        return view('admin.courses.index', compact('background_processes'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tematica_asociadas = BackgroundProcess::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.courses.create', compact('tematica_asociadas'));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        if ($request->input('imagen', false)) {
            $course->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen'))))->toMediaCollection('imagen');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $course->id]);
        }

        return redirect()->route('admin.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tematica_asociadas = BackgroundProcess::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $course->load('tematica_asociada');

        return view('admin.courses.edit', compact('course', 'tematica_asociadas'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());

        if ($request->input('imagen', false)) {
            if (!$course->imagen || $request->input('imagen') !== $course->imagen->file_name) {
                if ($course->imagen) {
                    $course->imagen->delete();
                }
                $course->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen'))))->toMediaCollection('imagen');
            }
        } elseif ($course->imagen) {
            $course->imagen->delete();
        }

        return redirect()->route('admin.courses.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('tematica_asociada', 'courseCourseSchedules');

        return view('admin.courses.show', compact('course'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('course_create') && Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Course();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

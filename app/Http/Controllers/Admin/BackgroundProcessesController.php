<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBackgroundProcessRequest;
use App\Http\Requests\StoreBackgroundProcessRequest;
use App\Http\Requests\UpdateBackgroundProcessRequest;
use App\Models\BackgroundProcess;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BackgroundProcessesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('background_process_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BackgroundProcess::query()->select(sprintf('%s.*', (new BackgroundProcess())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'background_process_show';
                $editGate = 'background_process_edit';
                $deleteGate = 'background_process_delete';
                $crudRoutePart = 'background-processes';

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
            $table->editColumn('file', function ($row) {
                if (!$row->file) {
                    return '';
                }
                $links = [];
                foreach ($row->file as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('images', function ($row) {
                if (!$row->images) {
                    return '';
                }
                $links = [];
                foreach ($row->images as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('especial', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->especial ? 'checked' : null) . '>';
            });
            $table->editColumn('descripcion_especial', function ($row) {
                return $row->descripcion_especial ? $row->descripcion_especial : '';
            });
            $table->editColumn('imagen_especial', function ($row) {
                if ($photo = $row->imagen_especial) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'file', 'images', 'especial', 'imagen_especial']);

            return $table->make(true);
        }

        return view('admin.backgroundProcesses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('background_process_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.backgroundProcesses.create');
    }

    public function store(StoreBackgroundProcessRequest $request)
    {
        $backgroundProcess = BackgroundProcess::create($request->all());

        foreach ($request->input('file', []) as $file) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file');
        }

        foreach ($request->input('images', []) as $file) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($request->input('imagen_especial', false)) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_especial'))))->toMediaCollection('imagen_especial');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $backgroundProcess->id]);
        }

        return redirect()->route('admin.background-processes.index');
    }

    public function edit(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.backgroundProcesses.edit', compact('backgroundProcess'));
    }

    public function update(UpdateBackgroundProcessRequest $request, BackgroundProcess $backgroundProcess)
    {
        $backgroundProcess->update($request->all());

        if (count($backgroundProcess->file) > 0) {
            foreach ($backgroundProcess->file as $media) {
                if (!in_array($media->file_name, $request->input('file', []))) {
                    $media->delete();
                }
            }
        }
        $media = $backgroundProcess->file->pluck('file_name')->toArray();
        foreach ($request->input('file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('file');
            }
        }

        if (count($backgroundProcess->images) > 0) {
            foreach ($backgroundProcess->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $backgroundProcess->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        if ($request->input('imagen_especial', false)) {
            if (!$backgroundProcess->imagen_especial || $request->input('imagen_especial') !== $backgroundProcess->imagen_especial->file_name) {
                if ($backgroundProcess->imagen_especial) {
                    $backgroundProcess->imagen_especial->delete();
                }
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_especial'))))->toMediaCollection('imagen_especial');
            }
        } elseif ($backgroundProcess->imagen_especial) {
            $backgroundProcess->imagen_especial->delete();
        }

        return redirect()->route('admin.background-processes.index');
    }

    public function show(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.backgroundProcesses.show', compact('backgroundProcess'));
    }

    public function destroy(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $backgroundProcess->delete();

        return back();
    }

    public function massDestroy(MassDestroyBackgroundProcessRequest $request)
    {
        BackgroundProcess::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('background_process_create') && Gate::denies('background_process_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BackgroundProcess();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

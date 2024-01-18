<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCloseImageRequest;
use App\Http\Requests\StoreCloseImageRequest;
use App\Http\Requests\UpdateCloseImageRequest;
use App\Models\CloseImage;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CloseImageController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('close_image_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CloseImage::query()->select(sprintf('%s.*', (new CloseImage())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'close_image_show';
                $editGate = 'close_image_edit';
                $deleteGate = 'close_image_delete';
                $crudRoutePart = 'close-images';

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
            $table->editColumn('image', function ($row) {
                if ($photo = $row->image) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('answered_challenges', function ($row) {
                return $row->answered_challenges ? $row->answered_challenges : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image']);

            return $table->make(true);
        }

        return view('admin.closeImages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('close_image_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.closeImages.create');
    }

    public function store(StoreCloseImageRequest $request)
    {
        $closeImage = CloseImage::create($request->all());

        if ($request->input('image', false)) {
            $closeImage->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $closeImage->id]);
        }

        return redirect()->route('admin.close-images.index');
    }

    public function edit(CloseImage $closeImage)
    {
        abort_if(Gate::denies('close_image_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.closeImages.edit', compact('closeImage'));
    }

    public function update(UpdateCloseImageRequest $request, CloseImage $closeImage)
    {
        $closeImage->update($request->all());

        if ($request->input('image', false)) {
            if (!$closeImage->image || $request->input('image') !== $closeImage->image->file_name) {
                if ($closeImage->image) {
                    $closeImage->image->delete();
                }
                $closeImage->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($closeImage->image) {
            $closeImage->image->delete();
        }

        return redirect()->route('admin.close-images.index');
    }

    public function show(CloseImage $closeImage)
    {
        abort_if(Gate::denies('close_image_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.closeImages.show', compact('closeImage'));
    }

    public function destroy(CloseImage $closeImage)
    {
        abort_if(Gate::denies('close_image_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $closeImage->delete();

        return back();
    }

    public function massDestroy(MassDestroyCloseImageRequest $request)
    {
        CloseImage::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('close_image_create') && Gate::denies('close_image_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new CloseImage();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

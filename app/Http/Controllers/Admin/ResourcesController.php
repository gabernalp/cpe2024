<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyResourceRequest;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use App\Models\ResourcesAudit;
use App\Models\ResourcesCategory;
use App\Models\ResourcesSubcategory;
use App\Models\UserFavResource;
use App\Models\Tag;
use App\Models\TagCategory;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ResourcesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;
    
    public function favorite(Request $request){
        
        if(!UserFavResource::where('user_id',auth()->id())->where('resource_id',$request->resource_id)->first()) {
          
            $favorite = new UserFavResource;
            $favorite->resource_id = $request->resource_id;
            $favorite->user_id = auth()->id();
            $favorite->save();            
        }
        
        return true;
        
    }
    
    public function accessResource(Request $request){
        
        $access = new ResourcesAudit;
        $access->ip = request()->ip() ?? null;
        $access->recurso_id = $request->resource_id;
        $access->user_id = auth()->id();
        $access->save();
        
        return true;
        
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('resource_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Resource::with(['resourcescategory', 'resource_subcategories', 'tag_categories', 'tags'])->select(sprintf('%s.*', (new Resource())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'resource_show';
                $editGate = 'resource_edit';
                $deleteGate = 'resource_delete';
                $crudRoutePart = 'resources';

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
            $table->addColumn('resourcescategory_name', function ($row) {
                return $row->resourcescategory ? $row->resourcescategory->name : '';
            });

            $table->editColumn('resource_subcategory', function ($row) {
                $labels = [];
                foreach ($row->resource_subcategories as $resource_subcategory) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $resource_subcategory->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('imagen_archivo', function ($row) {
                if ($photo = $row->imagen_archivo) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('image_pdf', function ($row) {
                if ($photo = $row->image_pdf) {
                    return sprintf(
        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
        $photo->url,
        $photo->thumbnail
    );
                }

                return '';
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('tag_category', function ($row) {
                $labels = [];
                foreach ($row->tag_categories as $tag_category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag_category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('tags', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('manual', function ($row) {
                return $row->manual ? '<a href="' . $row->manual->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('image_manual', function ($row) {
                if ($photo = $row->image_manual) {
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

            $table->rawColumns(['actions', 'placeholder', 'resourcescategory', 'resource_subcategory', 'imagen_archivo', 'file', 'image_pdf', 'tag_category', 'tags', 'manual', 'image_manual']);

            return $table->make(true);
        }

        return view('admin.resources.index');
    }

    public function create()
    {
        abort_if(Gate::denies('resource_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resource_subcategories = ResourcesSubcategory::pluck('name', 'id');

        $tag_categories = TagCategory::pluck('name', 'id');

        $tags = Tag::pluck('name', 'id');

        return view('admin.resources.create', compact('resource_subcategories', 'resourcescategories', 'tag_categories', 'tags'));
    }

    public function store(StoreResourceRequest $request)
    {
        $resource = Resource::create($request->all());
        $resource->resource_subcategories()->sync($request->input('resource_subcategories', []));
        $resource->tag_categories()->sync($request->input('tag_categories', []));
        $resource->tags()->sync($request->input('tags', []));
        if ($request->input('imagen_archivo', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_archivo'))))->toMediaCollection('imagen_archivo');
        }

        if ($request->input('file', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($request->input('image_pdf', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_pdf'))))->toMediaCollection('image_pdf');
        }

        if ($request->input('manual', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('manual'))))->toMediaCollection('manual');
        }

        if ($request->input('image_manual', false)) {
            $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_manual'))))->toMediaCollection('image_manual');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $resource->id]);
        }

        return redirect()->route('admin.resources.index');
    }

    public function edit(Resource $resource)
    {
        abort_if(Gate::denies('resource_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resource_subcategories = ResourcesSubcategory::pluck('name', 'id');

        $tag_categories = TagCategory::pluck('name', 'id');

        $tags = Tag::pluck('name', 'id');

        $resource->load('resourcescategory', 'resource_subcategories', 'tag_categories', 'tags');

        return view('admin.resources.edit', compact('resource', 'resource_subcategories', 'resourcescategories', 'tag_categories', 'tags'));
    }

    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        $resource->update($request->all());
        $resource->resource_subcategories()->sync($request->input('resource_subcategories', []));
        $resource->tag_categories()->sync($request->input('tag_categories', []));
        $resource->tags()->sync($request->input('tags', []));
        if ($request->input('imagen_archivo', false)) {
            if (!$resource->imagen_archivo || $request->input('imagen_archivo') !== $resource->imagen_archivo->file_name) {
                if ($resource->imagen_archivo) {
                    $resource->imagen_archivo->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('imagen_archivo'))))->toMediaCollection('imagen_archivo');
            }
        } elseif ($resource->imagen_archivo) {
            $resource->imagen_archivo->delete();
        }

        if ($request->input('file', false)) {
            if (!$resource->file || $request->input('file') !== $resource->file->file_name) {
                if ($resource->file) {
                    $resource->file->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($resource->file) {
            $resource->file->delete();
        }

        if ($request->input('image_pdf', false)) {
            if (!$resource->image_pdf || $request->input('image_pdf') !== $resource->image_pdf->file_name) {
                if ($resource->image_pdf) {
                    $resource->image_pdf->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_pdf'))))->toMediaCollection('image_pdf');
            }
        } elseif ($resource->image_pdf) {
            $resource->image_pdf->delete();
        }

        if ($request->input('manual', false)) {
            if (!$resource->manual || $request->input('manual') !== $resource->manual->file_name) {
                if ($resource->manual) {
                    $resource->manual->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('manual'))))->toMediaCollection('manual');
            }
        } elseif ($resource->manual) {
            $resource->manual->delete();
        }

        if ($request->input('image_manual', false)) {
            if (!$resource->image_manual || $request->input('image_manual') !== $resource->image_manual->file_name) {
                if ($resource->image_manual) {
                    $resource->image_manual->delete();
                }
                $resource->addMedia(storage_path('tmp/uploads/' . basename($request->input('image_manual'))))->toMediaCollection('image_manual');
            }
        } elseif ($resource->image_manual) {
            $resource->image_manual->delete();
        }

        return redirect()->route('admin.resources.index');
    }

    public function show(Resource $resource)
    {
        abort_if(Gate::denies('resource_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource->load('resourcescategory', 'resource_subcategories', 'tag_categories', 'tags');

        return view('admin.resources.show', compact('resource'));
    }

    public function destroy(Resource $resource)
    {
        abort_if(Gate::denies('resource_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resource->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourceRequest $request)
    {
        Resource::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('resource_create') && Gate::denies('resource_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Resource();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

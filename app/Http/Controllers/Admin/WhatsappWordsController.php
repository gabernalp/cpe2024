<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWhatsappWordRequest;
use App\Http\Requests\StoreWhatsappWordRequest;
use App\Http\Requests\UpdateWhatsappWordRequest;
use App\Models\WhatsappWord;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WhatsappWordsController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('whatsapp_word_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WhatsappWord::query()->select(sprintf('%s.*', (new WhatsappWord())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'whatsapp_word_show';
                $editGate = 'whatsapp_word_edit';
                $deleteGate = 'whatsapp_word_delete';
                $crudRoutePart = 'whatsapp-words';

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
            $table->editColumn('word', function ($row) {
                return $row->word ? $row->word : '';
            });
            $table->editColumn('object', function ($row) {
                return $row->object ? $row->object : '';
            });
            $table->editColumn('action', function ($row) {
                return $row->action ? $row->action : '';
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? WhatsappWord::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('extra', function ($row) {
                return $row->extra ? $row->extra : '';
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
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image', 'file']);

            return $table->make(true);
        }

        return view('admin.whatsappWords.index');
    }

    public function create()
    {
        abort_if(Gate::denies('whatsapp_word_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsappWords.create');
    }

    public function store(StoreWhatsappWordRequest $request)
    {
        $whatsappWord = WhatsappWord::create($request->all());

        if ($request->input('image', false)) {
            $whatsappWord->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($request->input('file', false)) {
            $whatsappWord->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $whatsappWord->id]);
        }

        return redirect()->route('admin.whatsapp-words.index');
    }

    public function edit(WhatsappWord $whatsappWord)
    {
        abort_if(Gate::denies('whatsapp_word_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsappWords.edit', compact('whatsappWord'));
    }

    public function update(UpdateWhatsappWordRequest $request, WhatsappWord $whatsappWord)
    {
        $whatsappWord->update($request->all());

        if ($request->input('image', false)) {
            if (!$whatsappWord->image || $request->input('image') !== $whatsappWord->image->file_name) {
                if ($whatsappWord->image) {
                    $whatsappWord->image->delete();
                }
                $whatsappWord->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($whatsappWord->image) {
            $whatsappWord->image->delete();
        }

        if ($request->input('file', false)) {
            if (!$whatsappWord->file || $request->input('file') !== $whatsappWord->file->file_name) {
                if ($whatsappWord->file) {
                    $whatsappWord->file->delete();
                }
                $whatsappWord->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($whatsappWord->file) {
            $whatsappWord->file->delete();
        }

        return redirect()->route('admin.whatsapp-words.index');
    }

    public function show(WhatsappWord $whatsappWord)
    {
        abort_if(Gate::denies('whatsapp_word_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsappWords.show', compact('whatsappWord'));
    }

    public function destroy(WhatsappWord $whatsappWord)
    {
        abort_if(Gate::denies('whatsapp_word_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappWord->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhatsappWordRequest $request)
    {
        WhatsappWord::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('whatsapp_word_create') && Gate::denies('whatsapp_word_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new WhatsappWord();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

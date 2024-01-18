<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWhatsappWordRequest;
use App\Http\Requests\UpdateWhatsappWordRequest;
use App\Http\Resources\Admin\WhatsappWordResource;
use App\Models\WhatsappWord;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsappWordsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('whatsapp_word_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsappWordResource(WhatsappWord::all());
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

        return (new WhatsappWordResource($whatsappWord))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WhatsappWord $whatsappWord)
    {
        abort_if(Gate::denies('whatsapp_word_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsappWordResource($whatsappWord);
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

        return (new WhatsappWordResource($whatsappWord))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WhatsappWord $whatsappWord)
    {
        abort_if(Gate::denies('whatsapp_word_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsappWord->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

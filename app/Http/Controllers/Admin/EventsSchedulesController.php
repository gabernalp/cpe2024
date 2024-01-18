<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventsScheduleRequest;
use App\Http\Requests\StoreEventsScheduleRequest;
use App\Http\Requests\UpdateEventsScheduleRequest;
use App\Models\EventsSchedule;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EventsSchedulesController extends Controller
{
    use MediaUploadingTrait;
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('events_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EventsSchedule::query()->select(sprintf('%s.*', (new EventsSchedule())->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'events_schedule_show';
                $editGate = 'events_schedule_edit';
                $deleteGate = 'events_schedule_delete';
                $crudRoutePart = 'events-schedules';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
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
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : '';
            });
            $table->editColumn('invitados', function ($row) {
                return $row->invitados ? $row->invitados : '';
            });
            $table->editColumn('podcast', function ($row) {
                return $row->podcast ? '<a href="' . $row->podcast->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('video_embed', function ($row) {
                return $row->video_embed ? $row->video_embed : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'image', 'podcast']);

            return $table->make(true);
        }

        return view('admin.eventsSchedules.index');
    }

    public function create()
    {
        abort_if(Gate::denies('events_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventsSchedules.create');
    }

    public function store(StoreEventsScheduleRequest $request)
    {
        $eventsSchedule = EventsSchedule::create($request->all());

        if ($request->input('image', false)) {
            $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($request->input('podcast', false)) {
            $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('podcast'))))->toMediaCollection('podcast');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $eventsSchedule->id]);
        }

        return redirect()->route('admin.events-schedules.index');
    }

    public function edit(EventsSchedule $eventsSchedule)
    {
        abort_if(Gate::denies('events_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.eventsSchedules.edit', compact('eventsSchedule'));
    }

    public function update(UpdateEventsScheduleRequest $request, EventsSchedule $eventsSchedule)
    {
        $eventsSchedule->update($request->all());

        if ($request->input('image', false)) {
            if (!$eventsSchedule->image || $request->input('image') !== $eventsSchedule->image->file_name) {
                if ($eventsSchedule->image) {
                    $eventsSchedule->image->delete();
                }
                $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($eventsSchedule->image) {
            $eventsSchedule->image->delete();
        }

        if ($request->input('podcast', false)) {
            if (!$eventsSchedule->podcast || $request->input('podcast') !== $eventsSchedule->podcast->file_name) {
                if ($eventsSchedule->podcast) {
                    $eventsSchedule->podcast->delete();
                }
                $eventsSchedule->addMedia(storage_path('tmp/uploads/' . basename($request->input('podcast'))))->toMediaCollection('podcast');
            }
        } elseif ($eventsSchedule->podcast) {
            $eventsSchedule->podcast->delete();
        }

        return redirect()->route('admin.events-schedules.index');
    }

    public function show(EventsSchedule $eventsSchedule)
    {
        abort_if(Gate::denies('events_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsSchedule->load('eventEventsAttendants');

        return view('admin.eventsSchedules.show', compact('eventsSchedule'));
    }

    public function destroy(EventsSchedule $eventsSchedule)
    {
        abort_if(Gate::denies('events_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsSchedule->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventsScheduleRequest $request)
    {
        EventsSchedule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('events_schedule_create') && Gate::denies('events_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new EventsSchedule();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

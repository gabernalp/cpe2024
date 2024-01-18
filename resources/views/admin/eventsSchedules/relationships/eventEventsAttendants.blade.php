@can('events_attendant_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.events-attendants.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eventsAttendant.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.eventsAttendant.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-eventEventsAttendants">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.event') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsSchedule.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.last_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.documenttype') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.document') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.department') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.city') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.entity') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.eventsAttendant.fields.email') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventsAttendants as $key => $eventsAttendant)
                        <tr data-entry-id="{{ $eventsAttendant->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $eventsAttendant->id ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->event->date ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->event->title ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->name ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->last_name ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->documenttype ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->document ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->department->name ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->city->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\EventsAttendant::ENTITY_SELECT[$eventsAttendant->entity] ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->phone ?? '' }}
                            </td>
                            <td>
                                {{ $eventsAttendant->email ?? '' }}
                            </td>
                            <td>
                                @can('events_attendant_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.events-attendants.show', $eventsAttendant->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('events_attendant_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.events-attendants.edit', $eventsAttendant->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('events_attendant_delete')
                                    <form action="{{ route('admin.events-attendants.destroy', $eventsAttendant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('events_attendant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.events-attendants.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-eventEventsAttendants:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
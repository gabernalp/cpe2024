@extends('layouts.admin')
@section('content')
@can('events_attendant_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.events-attendants.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.eventsAttendant.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EventsAttendant', 'route' => 'admin.events-attendants.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.eventsAttendant.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-EventsAttendant">
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('events_attendant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.events-attendants.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.events-attendants.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'event_date', name: 'event.date' },
{ data: 'event.title', name: 'event.title' },
{ data: 'name', name: 'name' },
{ data: 'last_name', name: 'last_name' },
{ data: 'documenttype', name: 'documenttype' },
{ data: 'document', name: 'document' },
{ data: 'department_name', name: 'department.name' },
{ data: 'city_name', name: 'city.name' },
{ data: 'entity', name: 'entity' },
{ data: 'phone', name: 'phone' },
{ data: 'email', name: 'email' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-EventsAttendant').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
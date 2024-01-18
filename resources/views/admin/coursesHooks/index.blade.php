@extends('layouts.admin')
@section('content')
@can('courses_hook_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.courses-hooks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.coursesHook.title_singular') }}
            </a>
            
            @include('csvImport.modal', ['model' => 'CoursesHook', 'route' => 'admin.courses-hooks.parseCsvImport'])
            <a class="btn btn-info" href="{{ route('admin.courses-hooks.hide') }}">
                @if(env('OFERTAS') == 'encendido') Ocultar del menú principal @else Mostrar sección en menú principal @endif
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.coursesHook.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CoursesHook">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.coursesHook.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.coursesHook.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.coursesHook.fields.description') }}
                    </th>
                    <th>
                        {{ trans('cruds.coursesHook.fields.link') }}
                    </th>
                    <th>
                        {{ trans('cruds.coursesHook.fields.file') }}
                    </th>
                    <th>
                        {{ trans('cruds.coursesHook.fields.entidad') }}
                    </th>
                    <th>
                        {{ trans('cruds.entity.fields.initials') }}
                    </th>
                    <th>&nbsp;
                        
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
@can('courses_hook_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.courses-hooks.massDestroy') }}",
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
    ajax: "{{ route('admin.courses-hooks.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'description', name: 'description' },
{ data: 'link', name: 'link' },
{ data: 'file', name: 'file', sortable: false, searchable: false },
{ data: 'entidad_name', name: 'entidad.name' },
{ data: 'entidad.initials', name: 'entidad.initials' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-CoursesHook').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
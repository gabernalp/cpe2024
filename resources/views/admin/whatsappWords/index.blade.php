@extends('layouts.admin')
@section('content')
@can('whatsapp_word_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.whatsapp-words.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.whatsappWord.title_singular') }}
            </a>
            
            @include('csvImport.modal', ['model' => 'WhatsappWord', 'route' => 'admin.whatsapp-words.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.whatsappWord.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-WhatsappWord">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.word') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.object') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.action') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.link') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.message') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.extra') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.image') }}
                    </th>
                    <th>
                        {{ trans('cruds.whatsappWord.fields.file') }}
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
@can('whatsapp_word_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.whatsapp-words.massDestroy') }}",
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
    ajax: "{{ route('admin.whatsapp-words.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'word', name: 'word' },
{ data: 'object', name: 'object' },
{ data: 'action', name: 'action' },
{ data: 'link', name: 'link' },
{ data: 'message', name: 'message' },
{ data: 'status', name: 'status' },
{ data: 'extra', name: 'extra' },
{ data: 'image', name: 'image', sortable: false, searchable: false },
{ data: 'file', name: 'file', sortable: false, searchable: false },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 2, 'asc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-WhatsappWord').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
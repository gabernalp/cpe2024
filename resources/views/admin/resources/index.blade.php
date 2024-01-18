@extends('layouts.admin')
@section('content')
@can('resource_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.resources.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.resource.title_singular') }}
            </a>
            
            @include('csvImport.modal', ['model' => 'Resource', 'route' => 'admin.resources.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.resource.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Resource">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.resourcescategory') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.resource_subcategory') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.imagen_archivo') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.file') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.image_pdf') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.link') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.tag_category') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.tags') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.manual') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.image_manual') }}
                    </th>
                    <th>
                        {{ trans('cruds.resource.fields.comments') }}
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
@can('resource_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.resources.massDestroy') }}",
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
    ajax: "{{ route('admin.resources.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'resourcescategory_name', name: 'resourcescategory.name' },
{ data: 'resource_subcategory', name: 'resource_subcategories.name' },
{ data: 'imagen_archivo', name: 'imagen_archivo', sortable: false, searchable: false },
{ data: 'file', name: 'file', sortable: false, searchable: false },
{ data: 'image_pdf', name: 'image_pdf', sortable: false, searchable: false },
{ data: 'link', name: 'link' },
{ data: 'tag_category', name: 'tag_categories.name' },
{ data: 'tags', name: 'tags.name' },
{ data: 'manual', name: 'manual', sortable: false, searchable: false },
{ data: 'image_manual', name: 'image_manual', sortable: false, searchable: false },
{ data: 'comments', name: 'comments' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  let table = $('.datatable-Resource').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
@extends('layouts.admin')
@section('content')
@can('self_interested_user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.self-interested-users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.selfInterestedUser.title_singular') }}
            </a> 
            <a class="btn btn-danger" href="/admin/empty-interested-users/" onClick="javascript: return confirm('Esta seguro de eliminar TODOS los registros actuales?\r\n\r\nEsta operación no se puede deshacer')">
                Vaciar lista de registros
            </a>
            @include('csvImport.modal', ['model' => 'SelfInterestedUser', 'route' => 'admin.self-interested-users.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.selfInterestedUser.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-SelfInterestedUser">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.profile') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.lastname') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.email') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.documenttype') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.document') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.document_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.phone') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.education_background') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.modality') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.department') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.city') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.living_zone') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.contacted') }}
                    </th>
                    <th>
                        {{ trans('cruds.selfInterestedUser.fields.courseshooks') }}
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
@can('self_interested_user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.self-interested-users.massDestroy') }}",
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
    ajax: "{{ route('admin.self-interested-users.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'profile_name', name: 'profile.name' },
{ data: 'name', name: 'name' },
{ data: 'lastname', name: 'lastname' },
{ data: 'email', name: 'email' },
{ data: 'documenttype_name', name: 'documenttype.name' },
{ data: 'document', name: 'document' },
{ data: 'document_date', name: 'document_date' },
{ data: 'phone', name: 'phone' },
{ data: 'education_background', name: 'education_background' },
{ data: 'modality', name: 'modality' },
{ data: 'department_name', name: 'department.name' },
{ data: 'city_name', name: 'city.name' },
{ data: 'living_zone', name: 'living_zone' },
{ data: 'contacted', name: 'contacted' },
{ data: 'courseshooks', name: 'courseshooks.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
    lengthMenu: [ [25, 50, 100, 500, 1000, 2000], [25, 50, 100, 500, 1000, 2000] ],
  };
  let table = $('.datatable-SelfInterestedUser').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
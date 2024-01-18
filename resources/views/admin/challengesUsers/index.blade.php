@extends('layouts.admin')
@section('content')
@can('challenges_user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.challenges-users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.challengesUser.title_singular') }}
            </a>
            
            @include('csvImport.modal', ['model' => 'ChallengesUser', 'route' => 'admin.challenges-users.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.challengesUser.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ChallengesUser">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.challengesUser.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.challengesUser.fields.courseschedule') }}
                    </th>
                    <th>
                        ID Ciclo
                    </th>
                    <th>
                        ID Programacion
                    </th>
                    <th>
                        {{ trans('cruds.challengesUser.fields.user') }}
                    </th>
					<th>
                        ID Usuario
                    </th>
					<th>
                        Telefono
                    </th>
                    <th>
                        {{ trans('cruds.challengesUser.fields.challenge') }}
                    </th>
                    <th>
                        {{ trans('cruds.challengesUser.fields.reference_text') }}
                    </th>
                    <th>
                        {{ trans('cruds.challengesUser.fields.status') }}
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
@can('challenges_user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.challenges-users.massDestroy') }}",
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
    ajax: "{{ route('admin.challenges-users.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'courseschedule_start_date', name: 'courseschedule.start_date' },
{ data: 'courseschedule.course_id', name: 'courseschedule.course_id' },
{ data: 'courseschedule.id', name: 'courseschedule.id' },
{ data: 'user_name', name: 'user.name' },
{ data: 'user_id', name: 'user.id' },
{ data: 'user.phone', name: 'user.phone' },
{ data: 'challenge_name', name: 'challenge.name' },
{ data: 'reference_text', name: 'reference_text' },
{ data: 'status', name: 'status' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
    lengthMenu: [ [25, 50, 100, 500, 1000, 2000], [25, 50, 100, 500, 1000, 2000] ],
  };
  let table = $('.datatable-ChallengesUser').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
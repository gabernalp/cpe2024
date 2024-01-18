@extends('layouts.admin')
@section('content')
@can('technical_referrer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.technical-referrers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.technicalReferrer.title_singular') }}
            </a>
            
            @include('csvImport.modal', ['model' => 'TechnicalReferrer', 'route' => 'admin.technical-referrers.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.technicalReferrer.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-TechnicalReferrer">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.technicalReferrer.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.technicalReferrer.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.technicalReferrer.fields.link') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($technicalReferrers as $key => $technicalReferrer)
                        <tr data-entry-id="{{ $technicalReferrer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $technicalReferrer->id ?? '' }}
                            </td>
                            <td>
                                {{ $technicalReferrer->name ?? '' }}
                            </td>
                            <td>
                                {{ $technicalReferrer->link ?? '' }}
                            </td>
                            <td>
                                @can('technical_referrer_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.technical-referrers.show', $technicalReferrer->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('technical_referrer_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.technical-referrers.edit', $technicalReferrer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('technical_referrer_delete')
                                    <form action="{{ route('admin.technical-referrers.destroy', $technicalReferrer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('technical_referrer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.technical-referrers.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-TechnicalReferrer:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
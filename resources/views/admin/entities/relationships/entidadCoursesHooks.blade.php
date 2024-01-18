@can('courses_hook_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.courses-hooks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.coursesHook.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.coursesHook.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-entidadCoursesHooks">
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
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coursesHooks as $key => $coursesHook)
                        <tr data-entry-id="{{ $coursesHook->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $coursesHook->id ?? '' }}
                            </td>
                            <td>
                                {{ $coursesHook->name ?? '' }}
                            </td>
                            <td>
                                {{ $coursesHook->description ?? '' }}
                            </td>
                            <td>
                                {{ $coursesHook->link ?? '' }}
                            </td>
                            <td>
                                @if($coursesHook->file)
                                    <a href="{{ $coursesHook->file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $coursesHook->entidad->name ?? '' }}
                            </td>
                            <td>
                                {{ $coursesHook->entidad->initials ?? '' }}
                            </td>
                            <td>
                                @can('courses_hook_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.courses-hooks.show', $coursesHook->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('courses_hook_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.courses-hooks.edit', $coursesHook->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('courses_hook_delete')
                                    <form action="{{ route('admin.courses-hooks.destroy', $coursesHook->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('courses_hook_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.courses-hooks.massDestroy') }}",
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
  let table = $('.datatable-entidadCoursesHooks:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
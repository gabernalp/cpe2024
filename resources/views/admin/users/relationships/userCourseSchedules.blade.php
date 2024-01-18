@can('course_schedule_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.course-schedules.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.courseSchedule.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.courseSchedule.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userCourseSchedules">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.course') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.revisa_tutor') }}
                        </th>
                        <th>
                            {{ trans('cruds.courseSchedule.fields.user') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courseSchedules as $key => $courseSchedule)
                        <tr data-entry-id="{{ $courseSchedule->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $courseSchedule->id ?? '' }}
                            </td>
                            <td>
                                {{ $courseSchedule->course->name ?? '' }}
                            </td>
                            <td>
                                {{ $courseSchedule->start_date ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $courseSchedule->revisa_tutor ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $courseSchedule->revisa_tutor ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $courseSchedule->user->name ?? '' }}
                            </td>
                            <td>
                                @can('course_schedule_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.course-schedules.show', $courseSchedule->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('course_schedule_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.course-schedules.edit', $courseSchedule->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('course_schedule_delete')
                                    <form action="{{ route('admin.course-schedules.destroy', $courseSchedule->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('course_schedule_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.course-schedules.massDestroy') }}",
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
    order: [[ 3, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-userCourseSchedules:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
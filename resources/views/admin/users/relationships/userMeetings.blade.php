@can('meeting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.meetings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.meeting.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.meeting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userMeetings">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.document') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.time') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.meeting_term') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.methodology') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.technical_referrers') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.teachers_network') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.otro_referente') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.link') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.file') }}
                        </th>
                        <th>
                            {{ trans('cruds.meeting.fields.observaciones') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meetings as $key => $meeting)
                        <tr data-entry-id="{{ $meeting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $meeting->id ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->user->phone ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->user->document ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->title ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->description ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->date ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->time ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Meeting::MEETING_TERM_SELECT[$meeting->meeting_term] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Meeting::METHODOLOGY_SELECT[$meeting->methodology] ?? '' }}
                            </td>
                            <td>
                                @foreach($meeting->technical_referrers as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span style="display:none">{{ $meeting->teachers_network ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $meeting->teachers_network ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $meeting->otro_referente ?? '' }}
                            </td>
                            <td>
                                {{ $meeting->link ?? '' }}
                            </td>
                            <td>
                                @if($meeting->file)
                                    <a href="{{ $meeting->file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $meeting->observaciones ?? '' }}
                            </td>
                            <td>
                                @can('meeting_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.meetings.show', $meeting->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('meeting_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.meetings.edit', $meeting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('meeting_delete')
                                    <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('meeting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.meetings.massDestroy') }}",
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
  let table = $('.datatable-userMeetings:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
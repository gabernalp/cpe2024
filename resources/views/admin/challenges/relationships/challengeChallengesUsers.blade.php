@can('challenges_user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.challenges-users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.challengesUser.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.challengesUser.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-challengeChallengesUsers">
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
                            {{ trans('cruds.challengesUser.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.challengesUser.fields.challenge') }}
                        </th>
                        <th>
                            {{ trans('cruds.challenge.fields.goal') }}
                        </th>
                        <th>
                            {{ trans('cruds.challengesUser.fields.reference_text') }}
                        </th>
                        <th>
                            {{ trans('cruds.challengesUser.fields.reference_media') }}
                        </th>
                        <th>
                            {{ trans('cruds.challengesUser.fields.file') }}
                        </th>
                        <th>
                            {{ trans('cruds.challengesUser.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($challengesUsers as $key => $challengesUser)
                        <tr data-entry-id="{{ $challengesUser->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $challengesUser->id ?? '' }}
                            </td>
                            <td>
                                {{ $challengesUser->courseschedule->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $challengesUser->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $challengesUser->challenge->name ?? '' }}
                            </td>
                            <td>
                                {{ $challengesUser->challenge->goal ?? '' }}
                            </td>
                            <td>
                                {{ $challengesUser->reference_text ?? '' }}
                            </td>
                            <td>
                                {{ $challengesUser->reference_media ?? '' }}
                            </td>
                            <td>
                                @if($challengesUser->file)
                                    <a href="{{ $challengesUser->file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ App\Models\ChallengesUser::STATUS_SELECT[$challengesUser->status] ?? '' }}
                            </td>
                            <td>
                                @can('challenges_user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.challenges-users.show', $challengesUser->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('challenges_user_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.challenges-users.edit', $challengesUser->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('challenges_user_delete')
                                    <form action="{{ route('admin.challenges-users.destroy', $challengesUser->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('challenges_user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.challenges-users.massDestroy') }}",
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
  let table = $('.datatable-challengeChallengesUsers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
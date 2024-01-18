@can('self_interested_user_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.self-interested-users.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.selfInterestedUser.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.selfInterestedUser.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-courseshooksSelfInterestedUsers">
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
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($selfInterestedUsers as $key => $selfInterestedUser)
                        <tr data-entry-id="{{ $selfInterestedUser->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $selfInterestedUser->id ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->profile->name ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->name ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->lastname ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->email ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->documenttype->name ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->document ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->document_date ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->phone ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\SelfInterestedUser::EDUCATION_BACKGROUND_RADIO[$selfInterestedUser->education_background] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\SelfInterestedUser::MODALITY_SELECT[$selfInterestedUser->modality] ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->department->name ?? '' }}
                            </td>
                            <td>
                                {{ $selfInterestedUser->city->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\SelfInterestedUser::LIVING_ZONE_SELECT[$selfInterestedUser->living_zone] ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $selfInterestedUser->contacted ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $selfInterestedUser->contacted ? 'checked' : '' }}>
                            </td>
                            <td>
                                @foreach($selfInterestedUser->courseshooks as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('self_interested_user_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.self-interested-users.show', $selfInterestedUser->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('self_interested_user_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.self-interested-users.edit', $selfInterestedUser->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('self_interested_user_delete')
                                    <form action="{{ route('admin.self-interested-users.destroy', $selfInterestedUser->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('self_interested_user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.self-interested-users.massDestroy') }}",
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
  let table = $('.datatable-courseshooksSelfInterestedUsers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
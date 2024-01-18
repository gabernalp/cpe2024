@can('resource_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.resources.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.resource.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.resource.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-tagCategoryResources">
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
                <tbody>
                    @foreach($resources as $key => $resource)
                        <tr data-entry-id="{{ $resource->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $resource->id ?? '' }}
                            </td>
                            <td>
                                {{ $resource->name ?? '' }}
                            </td>
                            <td>
                                {{ $resource->resourcescategory->name ?? '' }}
                            </td>
                            <td>
                                @foreach($resource->resource_subcategories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($resource->imagen_archivo)
                                    <a href="{{ $resource->imagen_archivo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $resource->imagen_archivo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($resource->file)
                                    <a href="{{ $resource->file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($resource->image_pdf)
                                    <a href="{{ $resource->image_pdf->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $resource->image_pdf->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $resource->link ?? '' }}
                            </td>
                            <td>
                                @foreach($resource->tag_categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($resource->tags as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($resource->manual)
                                    <a href="{{ $resource->manual->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if($resource->image_manual)
                                    <a href="{{ $resource->image_manual->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $resource->image_manual->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $resource->comments ?? '' }}
                            </td>
                            <td>
                                @can('resource_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.resources.show', $resource->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('resource_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.resources.edit', $resource->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('resource_delete')
                                    <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('resource_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.resources.massDestroy') }}",
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
  let table = $('.datatable-tagCategoryResources:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
@extends('layouts.cpe')
@section('content')
<div class="container pt-5 pb-2">
	<div class="row pb-4">
		<div class="col-md-6">
			<div>
				<a class="bcrumb" href="/">Inicio </a>» <a class="bcrumb" href="/recursos">Recursos y herramientas </a>» <a class="bcrumb" href="#">Búsqueda avanzada</a>
			</div>
			<h1 class="pt-4">Resultados de la búsqueda</h1>
			<p class="pt-4">Palabra clave o enunciado de búsqueda: <em>{{$sterm}}</em></p>
		</div>
	</div>
    @if($resourceIds !== false)
	<div class="row">
        @foreach($resourceIds as $resourceId)
        @php
        $resource = App\Models\Resource::find($resourceId)
        @endphp
            @if($resource->file)
            @php
                $inforesult = $resource->file->mime_type;
                $expmime = explode("/",$inforesult);
                $imgbase = $expmime[0];
            @endphp
            <div class="col-md-2 mb-2"  style="min-height:180px" id="myResource{{$resource->id}}">
                <p>@if($resource->image_pdf)
                        <a target="_blank" href="{{ $resource->file->getUrl() }}"><img src="{{$resource->image_pdf->getUrl()}}" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                        </a>
                    @else
                        <a target="_blank" href="{{ $resource->file->getUrl() }}">
                        <img src="/images/{{ $imgbase }}.png" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                        </a>
                    @endif</p>
                <p class="text-center"><i style="cursor: pointer" id="favorite{{$resource->id}}" class="fas fa-heart" data-toggle="tooltip" data-html="true" title="<small>Agregar a mi Biblioteca</small>"></i><input type="hidden" value="{{$resource->id}}" id="fav{{$resource->id}}"> <a target="_blank" href="{{ $resource->file->getUrl() }}"><i class="fa fa-download"></i> <small>Descargar</small></a><br /><a target="_blank" href="{{ $resource->file->getUrl() }}"><small style="color: gray">{{ $resource->name }}</small></a><br />
                @if($resource->manual)
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-md-4"><a href="{{$resource->manual->getUrl()}}" target="_blank">@if($resource->image_manual)<img src="{{$resource->image_manual->getUrl()}}" class="img-fluid">@else<img src="/images/{{ $imgbase }}.png" class="img-fluid">@endif</a></div>
                              <div class="col-md-8"><a href="{{$resource->manual->getUrl()}}" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso {{$resource->name}}</a></div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
            </div>
            <p class="mb-2"></p>
            @elseif($resource->imagen_archivo)
            @php
                $inforesult = $resource->imagen_archivo->mime_type;
                $expmime = explode("/",$inforesult);
                $imgbase = $expmime[0];
            @endphp
            <div class="col-md-2 mb-2" id="myResource{{$resource->id}}">
                <p>@if($resource->image_pdf)
                        <a  target="_blank" href="{{ $resource->file->getUrl() }}"><img src="{{$resource->image_pdf->getUrl()}}" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                        </a>
                    @else
                        <a  target="_blank" href="{{ $resource->imagen_archivo->getUrl() }}">
                        <img src="/images/{{ $imgbase }}.png" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                        </a>
                    @endif</p>
                <p class="text-center"><i style="cursor: pointer" id="favorite{{$resource->id}}" class="fas fa-heart" data-toggle="tooltip" data-html="true" title="<small>Agregar a mi Biblioteca</small>"></i><input type="hidden" value="{{$resource->id}}" id="fav{{$resource->id}}"> <a target="_blank" href="{{ $resource->imagen_archivo->getUrl() }}"><i class="fa fa-download"></i> <small>Descargar</small></a><br /><a  target="_blank" href="{{ $resource->imagen_archivo->getUrl() }}"><small style="color: gray">{{ $resource->name }}</small></a><br />
                @if($resource->manual)
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-md-4"><a href="{{$resource->manual->getUrl()}}" target="_blank">@if($resource->image_manual)<img src="{{$resource->image_manual->getUrl()}}" class="img-fluid">@else<img src="/images/{{ $imgbase }}.png" class="img-fluid">@endif</a></div>
                              <div class="col-md-8"><a href="{{$resource->manual->getUrl()}}" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso {{$resource->name}}</a></div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
            </div>
            <p class="mb-2"></p>
            @else
            <div class="col-md-2 mb-2" id="myResource{{$resource->id}}">
                <p class="text-center"><a target="_blank" href="{{ $resource->link }}"><img title="{{$resource->comments}}" src="/images/link.png" class="img-fluid" alt=""></a></p>
                <p class="text-center"><i style="cursor: pointer" id="favorite{{$resource->id}}" class="fas fa-heart" data-toggle="tooltip" data-html="true" title="<small>Agregar a mi Biblioteca</small>"></i><input type="hidden" value="{{$resource->id}}" id="fav{{$resource->id}}"> <a  target="_blank" href="{{ $resource->link }}"><i class="fa fa-link"></i> <small>Ir al recurso</small></a></p>
                <p class="text-center"><a  target="_blank" href="{{ $resource->link }}"><small style="color: gray">{{ $resource->name }}</small></a><br />
                @if($resource->manual)
                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="col-md-4"><a href="{{$resource->manual->getUrl()}}" target="_blank">@if($resource->image_manual)<img src="{{$resource->image_manual->getUrl()}}" class="img-fluid">@else<img src="/images/{{ $imgbase }}.png" class="img-fluid">@endif</a></div>
                              <div class="col-md-8"><a href="{{$resource->manual->getUrl()}}" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso {{$resource->name}}</a></div>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
            </div>
            <p class="mb-2"></p>
            @endif
		@endforeach
	</div>
    @else
    <h5>No hemos encontrado resultados para su búsqueda, por favor intente nuevamente</h5>
    @endif
</div>
<div class="jumbotron mt-1 mb-0 bgw">
    <div class="container">
        <h4><strong>Otros recursos que tambien<br>pueden interesarte...</strong></h4>
        <p>Encuentra más recursos disponibles a los que puedes acceder:</p>
        <div class="row">
            @foreach($resourceRands as $resource)
                @if($resource->file)
                @php
                    $inforesult = $resource->file->mime_type;
                    $expmime = explode("/",$inforesult);
                    $imgbase = $expmime[0];
                @endphp
                <div class="col-md-2 mb-2" style="min-height:180px" id="myResource{{$resource->id}}">
                    <p>@if($resource->image_pdf)
                            <a target="_blank" href="{{ $resource->file->getUrl() }}"><img src="{{$resource->image_pdf->getUrl()}}" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                            </a>
                        @else
                            <a target="_blank" href="{{ $resource->file->getUrl() }}">
                            <img src="/images/{{ $imgbase }}.png" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                            </a>
                        @endif</p>
                    <p class="text-center"><i class="fa fa-download"></i> <small>Descargar</small></a><br /><a target="_blank" href="{{ $resource->file->getUrl() }}"><small style="color: gray">{{ $resource->name }}</small></a><br />
                    @if($resource->manual)
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-md-4"><a href="{{$resource->manual->getUrl()}}" target="_blank">@if($resource->image_manual)<img src="{{$resource->image_manual->getUrl()}}" class="img-fluid">@else<img src="/images/{{ $imgbase }}.png" class="img-fluid">@endif</a></div>
                                  <div class="col-md-8"><a href="{{$resource->manual->getUrl()}}" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso {{$resource->name}}</a></div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                </div>
                <p class="mb-2"></p>
                @elseif($resource->imagen_archivo)
                @php
                    $inforesult = $resource->imagen_archivo->mime_type;
                    $expmime = explode("/",$inforesult);
                    $imgbase = $expmime[0];
                @endphp
                <div class="col-md-2 mb-2" id="myResource{{$resource->id}}">
                    <p>@if($resource->image_pdf)
                            <a  target="_blank" href="{{ $resource->file->getUrl() }}"><img src="{{$resource->image_pdf->getUrl()}}" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                            </a>
                        @else
                            <a  target="_blank" href="{{ $resource->imagen_archivo->getUrl() }}">
                            <img src="/images/{{ $imgbase }}.png" class="img-fluid" alt="" data-toggle="tooltip" data-html="true" title="<small>{{$resource->comments}}</small>">
                            </a>
                        @endif</p>
                    <p class="text-center"><i class="fa fa-download"></i> <small>Descargar</small></a><br /><a  target="_blank" href="{{ $resource->imagen_archivo->getUrl() }}"><small style="color: gray">{{ $resource->name }}</small></a><br />
                    @if($resource->manual)
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-md-4"><a href="{{$resource->manual->getUrl()}}" target="_blank">@if($resource->image_manual)<img src="{{$resource->image_manual->getUrl()}}" class="img-fluid">@else<img src="/images/{{ $imgbase }}.png" class="img-fluid">@endif</a></div>
                                  <div class="col-md-8"><a href="{{$resource->manual->getUrl()}}" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso {{$resource->name}}</a></div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                </div>
                <p class="mb-2"></p>
                @else
                <div class="col-md-2 mb-2" id="myResource{{$resource->id}}">
                    <p class="text-center"><a target="_blank" href="{{ $resource->link }}"><img title="{{$resource->comments}}" src="/images/link.png" class="img-fluid" alt=""></a></p>
                    <p class="text-center"><i class="fa fa-link"></i> <small>Ir al recurso</small></a></p>
                    <p class="text-center"><a  target="_blank" href="{{ $resource->link }}"><small style="color: gray">{{ $resource->name }}</small></a><br />
                    @if($resource->manual)
                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-download"></i> Guia adicional</button></p>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Manual o guía adicional asociada</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <div class="row">
                                  <div class="col-md-4"><a href="{{$resource->manual->getUrl()}}" target="_blank">@if($resource->image_manual)<img src="{{$resource->image_manual->getUrl()}}" class="img-fluid">@else<img src="/images/{{ $imgbase }}.png" class="img-fluid">@endif</a></div>
                                  <div class="col-md-8"><a href="{{$resource->manual->getUrl()}}" target="_blank"><i class="fa fa-download"></i> Ver/descargar guía o manual relacionado con el recurso {{$resource->name}}</a></div>
                              </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                </div>
                <p class="mb-2"></p>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
@section('scripts')
@if($resourceIds)
@foreach($resourceIds as $resourceId)
<script type="text/javascript">
    $("#favorite{{$resourceId}}").click(function(){
        $.ajax({
            url: "{{ route('admin.resources.favorite') }}?resource_id={{$resourceId}}",
            method: 'GET',
            success: function(data) {
                alert('Recurso agregado exitosamente a tu biblioteca');
            }
        });
    });
</script>
<script type="text/javascript">
    $("#myResource{{$resourceId}}").click(function(){
        $.ajax({
            url: "{{ route('admin.resources.accessResource') }}?resource_id={{$resourceId}}",
            method: 'GET',
            success: function(data) {
                
            }
        });
    });
</script>
@endforeach
@endif
@endsection
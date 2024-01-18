<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<div align="center"><img src="{{env('APP_URL')}}/images/logoseo.png" class="logo" alt="Logo Conectar para educar"></div>
@else
<p><img src="{{env('APP_URL')}}/images/logoseo.png" class="logo" alt="Logo Conectar para educar"></p>
{{ $slot }}
@endif
</a>
</td>
</tr>

@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.educationalBgReport.title') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6"><p class="colormain"><strong>Ciclos de retos activos</strong></p><hr />
            @foreach($courseSchedules as $courseSchedule)
                @if(Carbon\Carbon::parse($courseSchedule->start_date)->addDays(28) > Carbon\Carbon::now())
                <p><strong><a href="ver-reporte-ciclo?id={{$courseSchedule->id}}">{{$courseSchedule->course->name}}</a></strong><br />Fecha de inicio: {{fechaEs($courseSchedule->start_date)}}<br/>Fecha de finalización: {{fechaEs(substr(Carbon\Carbon::parse($courseSchedule->start_date)->addDays(28),0,10))}}</p>
                @endif
            @endforeach
            </div> 
            <div class="col-md-6"><p class="colormain"><strong>Ciclos de retos pasados</strong></p><hr />
            @foreach($courseSchedules as $courseSchedule)
                @if(Carbon\Carbon::parse($courseSchedule->start_date)->addDays(28) <= Carbon\Carbon::now())
                <p><strong><a href="ver-reporte-ciclo?id={{$courseSchedule->id}}">{{$courseSchedule->course->name}}</a></strong><br />Fecha de inicio: {{fechaEs($courseSchedule->start_date)}}<br/>Fecha de finalización: {{fechaEs(substr(Carbon\Carbon::parse($courseSchedule->start_date)->addDays(28),0,10))}}</p>
                @endif
            @endforeach
            </div>        
        </div>
    </div>
</div>



@endsection
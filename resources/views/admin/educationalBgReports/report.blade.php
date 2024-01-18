@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4><strong>Reporte Ciclo de retos</strong></h4><strong class="colormain">{{$courseSchedule->course->name}}</strong><br />
        <small>[Temática: {{$courseSchedule->course->tematica_asociada->name}}]</small><br />
        Fecha de inicio: {{fechaEs($courseSchedule->start_date)}}<br/>
        Fecha de finalización: {{fechaEs(substr(Carbon\Carbon::parse($courseSchedule->start_date)->addDays(28),0,10))}}
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover datatable datatable-Report">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>
                        Nombre Usuario
                    </th>
                    <th>
                        Teléfono
                    </th>
                    <th style="text-align:center">
                        Medio
                    </th>
                    <th>
                        Reto 1
                    </th>
                    <th>
                        Reto 2
                    </th>
                    <th>
                        Reto 3
                    </th>
                    <th>
                        Reto 4
                    </th>
                    <th>
                        Reto 5
                    </th>
                    <th>
                        Reto 6
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($courseUsers as $courseUser )
                <tr>
                    <td></td>
                    <td>
                        {{$courseUser->user->name}}
                    </td>
                    <td>
                        {{$courseUser->user->phone}}
                    </td>
                    <td style="text-align:center">
                        @if($courseUser->whatsapp_user == 1)
                        <i class="fab fa-whatsapp"></i> <small>WApp</small>
                        @else
                        <i class="fas fa-laptop"></i> <small>Web</small>
                        @endif
                    </td>
                    <td>
                        @foreach($courseChallenges as $courseChallenge)
                            @if($loop->index == 0)
                                @if($challengeUserLoad = App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Recibido')->first())
                                    <a target="_blank" href="/admin/challenges-users/{{$challengeUserLoad->id}}"><i class="fas fa-eye"></i> Si</a>
                                @else
                                    No<br />
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Enviado')->first())
                                    <small class="colormain">[Enviado]</small>
                                    @endif
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','No entregado')->first())
                                    <small class="colormain">[No entregado]</small>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($courseChallenges as $courseChallenge)
                            @if($loop->index == 1)
                                @if($challengeUserLoad = App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Recibido')->first())
                                    <a target="_blank" href="/admin/challenges-users/{{$challengeUserLoad->id}}"><i class="fas fa-eye"></i> Si</a>
                                @else
                                    No<br />
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Enviado')->first())
                                    <small class="colormain">[Enviado]</small>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($courseChallenges as $courseChallenge)
                            @if($loop->index == 2)
                                @if($challengeUserLoad = App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Recibido')->first())
                                    <a target="_blank" href="/admin/challenges-users/{{$challengeUserLoad->id}}"><i class="fas fa-eye"></i> Si</a>
                                @else
                                    No<br />
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Enviado')->first())
                                    <small class="colormain">[Enviado]</small>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($courseChallenges as $courseChallenge)
                            @if($loop->index == 3)
                                @if($challengeUserLoad = App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Recibido')->first())
                                    <a target="_blank" href="/admin/challenges-users/{{$challengeUserLoad->id}}"><i class="fas fa-eye"></i> Si</a>
                                @else
                                    No<br />
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Enviado')->first())
                                    <small class="colormain">[Enviado]</small>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($courseChallenges as $courseChallenge)
                            @if($loop->index == 4)
                                @if($challengeUserLoad = App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Recibido')->first())
                                    <a target="_blank" href="/admin/challenges-users/{{$challengeUserLoad->id}}"><i class="fas fa-eye"></i> Si</a>
                                @else
                                    No<br />
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Enviado')->first())
                                    <small class="colormain">[Enviado]</small>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>
                        @foreach($courseChallenges as $courseChallenge)
                            @if($loop->index == 5)
                                @if($challengeUserLoad = App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Recibido')->first())
                                    <a target="_blank" href="/admin/challenges-users/{{$challengeUserLoad->id}}"><i class="fas fa-eye"></i> Si</a>
                                @else
                                    No<br />
                                    @if(App\Models\ChallengesUser::where('courseschedule_id',$courseSchedule->id)->where('user_id',$courseUser->user->id)->where('challenge_id',$courseChallenge->id)->where('status','Enviado')->first())
                                    <small class="colormain">[Enviado]</small>
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td></td>

                </tr>
                
            @endforeach
                
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Report:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
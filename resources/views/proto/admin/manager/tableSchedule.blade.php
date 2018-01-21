<section class="panel">

    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar" class="fc fc-ltr">
                    <table class="fc-header" style="width: 100%;">
                        <tbody>
                        <tr>
                            <td class="fc-header-left">
<span class="fc-header-title">
@if(!empty($navigate) && is_object($navigate))
        <h2>{{$navigate->month .' '.$navigate->years }}</h2>
    @endif
</span>
                            </td>
                            <td class="fc-header-right">
                                @if(!empty($navigate) && is_object($navigate))
                                    <div class="btn-group mt-sm mr-md mb-sm ml-sm">

<span class="btn btn-sm btn-default" id='data-prev' data-prev="{{$navigate->previousDate}}">
<span class="fc-icon fc-icon-left-single-arrow"></span>
</span>
                                        <span class="btn btn-sm btn-default" id="data-now" >Cегодня</span>
                                        <span class="btn btn-sm btn-default" id='data-next' data-next="{{$navigate->nextDate}}">
<span class="fc-icon fc-icon-right-single-arrow"></span>
</span>

                                    </div>
                                @endif
                                <br class="hidden"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="week-panel" style="padding-top: 60px">
        @foreach($week as $key => $day)
        <div class="col-md-6 col-lg-6 col-xl-3">
            <section class="panel schedule {{(strtotime(date('d-m-Y')) > strtotime($day['last'])) ? 'schedule-old' :''}} ">
                <a href="{{route('schedule.show',$day['first'].'+'.$day['last'])}}" >
                <header class="panel-heading bg-white">
                    <div class="panel-heading-icon bg-primary mt-sm">
                        <i class="fa fa-table"></i>
                    </div>
                </header>
                <div class="panel-body">
                    <h3 class="text-semibold mt-none text-center">Неделя № {{$key + 1}}</h3>
                    <p class="text-center">{{(!empty($day['first'])) ? $day['first'] : ''}} - {{(!empty($day['last'])) ? $day['last'] : ''}}</p>
                </div>
                </a>
            </section>
        </div>
        @endforeach
    </div>

</section>
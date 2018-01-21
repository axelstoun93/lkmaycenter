<section class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="container-fluid">
                <div id="calendar"  class="fc fc-ltr calendar-tv">
                    <table class="fc-header" style="width: 100%;">
                        <tbody>
                        <tr>
                            <td class="fc-header-left">
<span class="fc-header-title">
@if(!empty($navigate))
        <h2>{{$navigate}}</h2>
    @endif
</span>
                                <div id="external-events">
                                    <div class="external-event label label-success ui-draggable"  data-event-class="fc-event-success" id="fc-event-success">Отделение парикмахеров</div>
                                    <div class="external-event label label-warning ui-draggable"  data-event-class="fc-event-warning" id="fc-event-warning">Отделение нейл-арта</div>
                                    <div class="external-event label label-primary ui-draggable" data-event-class="fc-event-primary"  id="fc-event-primary">Отделение косметологии</div>
                                    <div class="external-event label label-info ui-draggable"    data-event-class="fc-event-info"     id="fc-event-info">Отделение визажа</div>
                                    <div class="external-event label label-default ui-draggable" data-event-class="fc-event-default"  id="fc-event-default">Отделение бизнеса</div>
                                </div>

                            </td>
                            <td class="fc-header-right">
                                @if(!empty($weekNavigate))
                                    <div class="btn-group mt-sm mr-md mb-sm ml-sm">

<span class="btn btn-sm btn-default" id='data-prev' data-prev="{{$weekNavigate['backward']}}">
<span class="fc-icon fc-icon-left-single-arrow"></span>
</span>
                                        <span class="btn btn-sm btn-default" id="data-now" >Cегодня</span>
                                        <span class="btn btn-sm btn-default" id='data-next' data-next="{{$weekNavigate['next']}}">
<span class="fc-icon fc-icon-right-single-arrow"></span>
</span>

                                    </div>
                                @endif


                                    <div id="filters">
                                        @if(!empty($category))
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <select class="form-control mb-md" id="filter-category">
                                                        <option value="0">Фильтр</option>
                                                        @foreach($category as $val)
                                                            <option value="{{$val->id}}">{{$val->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                            </td>
                        </tr>

                        </tr>
                        </tbody>
                    </table>
                    <div class="fc-content" style="">
                        <div class="fc-view fc-view-month fc-grid calendar-tv" unselectable="on">
                            <table class="fc-border-separate calendar-tv" style="width: 100%;" cellspacing="0">
                                @if(!empty($week))
                                    <thead>
                                    <tr class="fc-first fc-last">
                                        <th class="fc-day-header fc-sun fc-widget-header fc-first">Пн {{$week[0]['date']}}</th>
                                        <th class="fc-day-header fc-mon fc-widget-header">Вт {{$week[1]['date']}}</th>
                                        <th class="fc-day-header fc-tue fc-widget-header">Ср {{$week[2]['date']}}</th>
                                        <th class="fc-day-header fc-wed fc-widget-header">Чт {{$week[3]['date']}}</th>
                                        <th class="fc-day-header fc-thu fc-widget-header">Пт {{$week[4]['date']}}</th>
                                        <th class="fc-day-header fc-fri fc-widget-header">Сб {{$week[5]['date']}}</th>
                                        <th class="fc-day-header fc-sat fc-widget-header fc-last">Вс {{$week[6]['date']}}</th>
                                    </tr>
                                    </thead>
                                @endif
                                <tbody>
                                <tr class="fc-week fc-first fc-last">
                                    @for($i=0;7 > $i;++$i)
                                        @if($i == 0)     <td class="fc-day fc-sun fc-widget-content fc-today fc-state-highlight fc-first">
                                        @elseif($i == 6) <td class="fc-day fc-sat fc-widget-content fc-future fc-last">
                                        @else            <td class="fc-day fc-sat fc-widget-content fc-future">
                                            @endif
                                            <div class="cell-week" data-full-date="{{$week[$i]['fullDate']}}">
                                                @foreach($weekEvent as $event)
                                                    @if($event->date == $week[$i]['fullDate'])
                                                        <div class="fc-day-content"  data-category="{{$event->category_id}}">
                                                            <div class="fc-event-container" data-id="{{$event->id}}">
                                                                <div class="fc-event {{$event->schedule_css}} fc-event-hori  fc-event-start fc-event-end">
                                                                    <div class="fc-event-inner">
                                                                        <span class="fc-event-s-date">{{$week[$i]['date']}}</span>
                                                                        <span class="fc-event-s-title">{{$event->title}}</span>
                                                                        @if(!empty($event->start_time))
                                                                            <span class="fc-event-s-time">{{$event->start_time}} - {{$event->end_time}}</span>
                                                                        @endif
                                                                        @if(!empty($event->place))
                                                                            <span class="fc-event-s-place">{{$event->place}}</span>
                                                                        @endif
                                                                        @if(!empty($event->note))
                                                                            <span class="fc-event-s-note">{{$event->note}}</span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @continue
                                                    @endif

                                                @endforeach
                                            </div>
                                        </td>
                                        @endfor
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- modal windows edit-->
</section>
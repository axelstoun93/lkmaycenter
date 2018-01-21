<section class="panel">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-9">
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
</span><span class="btn btn-sm btn-default" id="data-now" >Cегодня</span>
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
                    <div class="fc-content" style="">
                        <div class="fc-view fc-view-month fc-grid" unselectable="on">
                            <table class="fc-border-separate" style="width: 100%;" cellspacing="0">
                                <thead>
                                <tr class="fc-first fc-last">
                                    <th class="fc-day-header fc-sun fc-widget-header fc-first" style="width: 167px;">Пн</th>
                                    <th class="fc-day-header fc-mon fc-widget-header" style="width: 167px;">Вт</th>
                                    <th class="fc-day-header fc-tue fc-widget-header" style="width: 167px;">Ср</th>
                                    <th class="fc-day-header fc-wed fc-widget-header" style="width: 167px;">Чт</th>
                                    <th class="fc-day-header fc-thu fc-widget-header" style="width: 167px;">Пт</th>
                                    <th class="fc-day-header fc-fri fc-widget-header" style="width: 167px;">Сб</th>
                                    <th class="fc-day-header fc-sat fc-widget-header fc-last" style="width: 167px;">Вс</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i = 0; $i < count($month);++$i)

                                    <tr class="fc-week {{($i + 1 === count($month) ) ? 'fc-last' : ''}}">
                                        @for($j = 0; $j < 7; $j++)
                                            @if(!empty($month[$i][$j]['day']))

                                                @if($j == 6)
                                                    <td class="fc-day fc-sun fc-widget-content fc-past fc-last">
                                                @else
                                                    <td class="fc-day fc-sun fc-widget-content fc-past">
                                                        @endif
                                                        <div style="min-height: 134px;" class="cell-calendar"  data-full-data="{{$month[$i][$j]['fullDate']}}">
                                                            <div class="fc-day-number">{{$month[$i][$j]['day']}}</div>
                                                            @if(!empty($month[$i][$j]['events']))
                                                                @if(is_array($month[$i][$j]['events']))
                                                                    @foreach($month[$i][$j]['events'] as $val)
                                                                        <div class="fc-day-content" >
                                                                            <div class="fc-event-container" data-id={{$val->id}}>
                                                                                <div class="fc-event {{$val->course_css}} fc-event-hori  fc-event-start fc-event-end " >
                                                                                    <div class="fc-event-inner">
                                                                                        {!! (!empty($val->start_time)) ? '<span class="fc-event-time">'.$val->start_time.'</span>' : ''!!}
                                                                                        <span class="fc-event-title">{{$val->title}}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="fc-day-content">
                                                                        <div class="fc-event-container" data-id={{$val->id}} >
                                                                            <div class="fc-event {{$val->course_css}} fc-event-hori  fc-event-start fc-event-end " >
                                                                                <div class="fc-event-inner">
                                                                                    {!! (!empty($val->start_time)) ? '<span class="fc-event-time">'.$val->start_time.'</span>' : ''!!}
                                                                                    <span class="fc-event-title">{{$val->title}}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>

                                                    </td>
                                                    @else
                                                        @if($j == 6)
                                                            <td class="fc-day fc-sun fc-widget-content fc-past fc-last">
                                                        @else
                                                            <td class="fc-day fc-sun fc-widget-content fc-past">
                                                        @endif
                                                    @endif
                                                    @endfor
                                    </tr>
                                @endfor

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <p class="h4 text-weight-light">Маркеры</p>
                <hr>
                <div id="external-events">
                    <div class="external-event label label-warning"  data-event-class="fc-event-warning" id="fc-event-warning" style="position: relative;">Зачет</div>
                    <div class="external-event label label-primary"  data-event-class="fc-event-primary" id="fc-event-primary" style="position: relative;">Экзамен</div>
                </div>
                <hr>
                <p class="h4 text-weight-light">Инструкция</p>
                <div>
                    <div id="external-events">
                        <p>Для просмотра подробной информации и записи щелкните по событию на календарe.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal windows show -->
    <div class="modal fade" id="modal-show" tabindex="-1">
        <div class="mfp-bg mfp-ready"></div>
        <div id="edit" class="modal-block mfp-show" style="z-index: 10001;">
            <section class="panel">
                <form id="edit-events" action="/"  method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <header class="panel-heading">
                        <h2 class="panel-title">Подробнее о событии</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="title">
                                        Название
                                    </label>
                                    <div class="col-md-8">
                                        <input type="text"  id="title" name="title" class="form-control"   readonly>
                                    </div>
                                </div>
                                @if(!empty($category))
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="category">
                                            Категория
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control mb-md" id="category"  readonly>
                                                <option></option>
                                                @foreach($category as $val)
                                                    <option value="{{$val->id}}">{{$val->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="type">
                                        Тип
                                    </label>
                                    <div class="col-md-8">
                                        <select class="form-control mb-md" id="type" readonly>
                                            <option value="fc-event-warning" selected>Зачет</option>
                                            <option value="fc-event-primary">Экзамен</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="date">Дата</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                            <input class="form-control" id="date" name="data" data-plugin-datepicker=""  type="text"   readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="time">Время</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                        </span>
                                            <input class="form-control" id="start" name="start_time" data-plugin-timepicker="" data-plugin-options='{"showMeridian": false,"defaultTime":"0:00" }' type="text"  readonly>
                                            <span class="input-group-addon">до</span>
                                            <input class="form-control" id="end" name="end_time"  data-plugin-timepicker="" data-plugin-options='{"showMeridian": false ,"defaultTime": "0:00" }'  type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="note">Примечание</label>
                                    <div class="col-md-8">
                                        <textarea id="note" class="form-control" rows="3" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button id="dialogCancel" class="btn btn-default">Закрыть</button>
                                <button id="dialogEnroll" class="btn btn-primary">Записаться</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
    <!-- modal windows show-->
    <!-- modal windows success -->
    <div class="modal fade" id="modal-alert" tabindex="-1">
        <div class="mfp-bg mfp-ready"></div>
        <div id="edit" class="modal-block mfp-show" style="z-index: 10001;">
            <section class="panel">
                <form id="edit-events" action=""  method="post" class="form-horizontal">
                    {{method_field('PUT')}}
                    <header class="panel-heading">
                        <h2 class="panel-title">Оповещение</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button id="dialogCancel" class="btn btn-default">Закрыть</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
    <!-- modal windows show-->
</section>
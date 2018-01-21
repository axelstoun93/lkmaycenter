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
@if(!empty($navigate))
        <h2>{{$navigate}}</h2>
    @endif
</span>
                            </td>
                          
						 <td class="fc-header-right">
						 <div class="btn-group mb-sm mt-sm" id="add-event">
                                    <span class="btn btn-sm btn-default" >Добавить событие</span>
                                </div>
                                @if(!empty($weekNavigate))
                                    <div class="btn-group mt-sm mr-md mb-sm ml-sm">

<span class="btn btn-sm btn-default" id="data-week-prev" data-prev="{{$weekNavigate['backward']}}">
<span class="fc-icon fc-icon-left-single-arrow"></span>
</span>
                                        <span class="btn btn-sm btn-default" id="data-week-now" >Cегодня</span>
                                        <span class="btn btn-sm btn-default" id="data-week-next" data-next="{{$weekNavigate['next']}}">
<span class="fc-icon fc-icon-right-single-arrow"></span>
</span>

                                    </div>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="fc-content" style="">
                        <div class="fc-view fc-view-month fc-grid" unselectable="on">
                            <table class="fc-border-separate" style="width: 100%;" cellspacing="0">
                               @if(!empty($week))
                                <thead>
                                <tr class="fc-first fc-last">
                                    <th class="fc-day-header fc-sun fc-widget-header fc-first" style="width: 167px;">Пн {{$week[0]['date']}}</th>
                                    <th class="fc-day-header fc-mon fc-widget-header" style="width: 167px;">Вт {{$week[1]['date']}}</th>
                                    <th class="fc-day-header fc-tue fc-widget-header" style="width: 167px;">Ср {{$week[2]['date']}}</th>
                                    <th class="fc-day-header fc-wed fc-widget-header" style="width: 167px;">Чт {{$week[3]['date']}}</th>
                                    <th class="fc-day-header fc-thu fc-widget-header" style="width: 167px;">Пт {{$week[4]['date']}}</th>
                                    <th class="fc-day-header fc-fri fc-widget-header" style="width: 167px;">Сб {{$week[5]['date']}}</th>
                                    <th class="fc-day-header fc-sat fc-widget-header fc-last" style="width: 167px;">Вс {{$week[6]['date']}}</th>
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
                                    <div class="fc-day-content" data-category="{{$event->category_id}}">
                                        <div class="fc-event-container" data-id="{{$event->id}}">
                                            <div class="fc-event {{$event->schedule_css}} fc-event-hori  fc-event-start fc-event-end">
                                                <div class="fc-event-inner">
                                                    <p class="fc-event-s-title">{{$event->title}}</p>
                                                    @if(!empty($event->start_time))
                                                    <p class="fc-event-s-time">{{$event->start_time}} - {{$event->end_time}}</p>
                                                    @endif
                                                    @if(!empty($event->place))
                                                        <p class="fc-event-s-place">{{$event->place}}</p>
                                                    @endif
                                                    @if(!empty($event->note))
                                                        <p class="fc-event-s-note">{{$event->note}}</p>
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
            <div class="col-md-3">
                <p class="h4 text-weight-light">Перетаскиваемые действия</p>
                <hr>
                <div id="external-events">
                    <div class="external-event label label-success ui-draggable"  data-event-class="fc-event-success" id="fc-event-success"  style="position: relative;">Отделение парикмахеров</div>
                    <div class="external-event label label-warning ui-draggable"  data-event-class="fc-event-warning" id="fc-event-warning"  style="position: relative;">Отделение нейл-арта</div>
                    <div class="external-event label label-primary ui-draggable" data-event-class="fc-event-primary"  id="fc-event-primary"  style="position: relative;">Отделение косметологии</div>
                    <div class="external-event label label-info ui-draggable"    data-event-class="fc-event-info"     id="fc-event-info"     style="position: relative;">Отделение визажа</div>
                    <div class="external-event label label-default ui-draggable" data-event-class="fc-event-default"  id="fc-event-default"  style="position: relative;">Отделение бизнеса</div>
                </div>
                <hr />
                <p class="h4 text-weight-light">Фильтры</p>

                <div id="filters">
                    @if(!empty($category))
                        <div class="form-group">
                            <div class="col-md-12">
                                <select class="form-control mb-md" id="filter-category">
                                    <option value="0">Все</option>
                                    @foreach($category as $val)
                                        <option value="{{$val->id}}">{{$val->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
                <hr />
                    <div>
                        <div class="checkbox-custom checkbox-default ib">
                            <input id="deleteEvents" type="checkbox"/>
                            <label for="deleteEvents"> Удалять по клику</label>
                        </div>
                    </div>
                <p class="button-schedule"><a href="{{route('schedule')}}" class="btn btn-default">Вернуться назад</a></p>
            </div>
        </div>
    </div>

    <!-- modal windows add -->
    <div class="modal fade" id="modal-add" tabindex="-1">
        <div class="mfp-bg mfp-ready"></div>
        <div id="add" class="modal-block mfp-show" style="z-index: 10001;">
            <section class="panel">
                <form id="add-events" action="{{route('schedule.store')}}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <header class="panel-heading">
                        <h2 class="panel-title">Добавить событие</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="title">
                                        Название группы
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="title" id="title" class="form-control" required>
                                    </div>
                                </div>

                                @if(!empty($category))
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="category">
                                            Категория события
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control mb-md" id="category" name="category" required>
                                                <option></option>
                                                @foreach($category as $val)
                                                    <option value="{{$val->id}}">{{$val->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="date">Дата <span class="required">*</span></label>
                                    <div class="col-md-8">
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                    <input class="form-control" id="date" data-plugin-datepicker="" name="date" type="text" required>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="start">Время   <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                        </span>
                                            <input class="form-control" id="start" name="start" type="text"  required>
                                            <span class="input-group-addon">до</span>
                                            <input class="form-control" id="end" name="end" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="place">
                                        Место проведения
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="place" id="place" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="textareaDefault">Примечание</label>
                                    <div class="col-md-8">
                                        <textarea id="textareaDefault" class="form-control" rows="3" name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button id="dialogCancel" class="btn btn-default">Закрыть</button>
                                <button type="reset" class="btn btn-default">Обновить</button>
                                <button id="dialogConfirm" class="btn btn-primary">Добавить</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
    <!-- modal windows close-->
    <!-- modal windows edit -->
    <div class="modal fade" id="modal-edit" tabindex="-1">
        <div class="mfp-bg mfp-ready"></div>
        <div id="edit" class="modal-block mfp-show" style="z-index: 10001;">
            <section class="panel">
                <form id="edit-events" action="/" method="post" class="form-horizontal">
                    <header class="panel-heading">
                        <h2 class="panel-title">Обновить событие</h2>
                    </header>
                    <div class="panel-body">
                        <div class="modal-wrapper">
                            <div class="modal-text">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="title">
                                        Название группы
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="title" id="title" class="form-control" required>
                                    </div>
                                </div>

                                @if(!empty($category))
                                    <div class="form-group">
                                        <label class="col-md-4 control-label" for="category">
                                            Категория события
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8">
                                            <select class="form-control mb-md" id="category" name="category" required>
                                                <option></option>
                                                @foreach($category as $val)
                                                    <option value="{{$val->id}}">{{$val->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="date-edit">Дата <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                            <input class="form-control" id="date-edit"  name="date" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="start-edit">Время   <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                        </span>
                                            <input class="form-control" id="start-edit" name="start" type="text"  required>
                                            <span class="input-group-addon">до</span>
                                            <input class="form-control" id="end-edit" name="end" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="place">
                                        Место проведения
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="place" id="place" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label" for="note">Примечание</label>
                                    <div class="col-md-8">
                                        <textarea id="note" class="form-control" rows="3" name="note"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button id="dialogCancel" class="btn btn-default">Закрыть</button>
                                <button id="dialogConfirm" class="btn btn-primary">Обновить</button>
                            </div>
                        </div>
                    </footer>
                </form>
            </section>
        </div>
    </div>
    <!-- modal windows edit-->
</section>
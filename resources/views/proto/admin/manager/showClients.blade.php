<div class="row">
    <div class="col-md-4 col-lg-3">
        <section class="panel">
            <div class="panel-body">
                <div class="thumb-info mb-md">
                    <img src="{{asset(env('THEME'))}}/images/partners/logo/{{(!empty($user->getClientInfo->logo)) ? $user->getClientInfo->logo : 'no-logo.jpg'}}" class="rounded img-responsive">
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner">{{(!empty($user->getClientInfo->company_name)) ? $user->getClientInfo->company_name :''}}</span>
                        <span class="thumb-info-type">{{(!empty($user->fio)) ? $user->fio :''}}</span>
                    </div>
                </div>

                <div class="widget-toggle-expand mb-md">
                    <div class="widget-header">
                        <h6>Профиль заполнен</h6>
                        <div class="widget-toggle">+</div>
                    </div>
                    <div class="widget-content-collapsed">
                        <div class="progress progress-xs light">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{floor($user->countInfo /7 * 100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {!!floor($user->countInfo /7 * 100).'%'!!};">
                                {!!floor($user->countInfo /7 * 100).'%'!!}
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-expanded">
                        <ul class="simple-todo-list">
                            <li {!!(!empty($user->fio)) ? 'class="completed"' : ''  !!} >Указано фио</li>
                            <li {!!(!empty($user->email)) ? 'class="completed"' : ''  !!} >Заполнен Email</li>
                            <li {!!(!empty($user->getClientInfo->company_name)) ? 'class="completed"' : ''  !!} >Название компании</li>
                            <li {!!(!empty($user->getClientInfo->logo)) ? 'class="completed"' : ''  !!}>Загружено лого</li>
                            <li {!!(!empty($user->getClientInfo->address)) ? 'class="completed"' : ''  !!}>Адрес</li>
                            <li {!!(!empty($user->getCientInfo->phone)) ? 'class="completed"' : ''  !!}>Телефон</li>
                            <li {!!(!empty($user->getClientInfo->company_info)) ? 'class="completed"' : ''  !!}>Информация о компании</li>
                        </ul>
                    </div>
                </div>
                <hr class="dotted short">
            </div>
        </section>
    </div>
    <div class="col-md-10 col-lg-8">

        <div class="tabs">

            <div class="tab-content">

                <div id="edit" class="tab-pane active">
                    @if(!empty($user))
                    <form class="form-horizontal" method="get">
                        <h4 class="mb-xlg">Вся информация о клиенте - {{$user->name}}</h4>
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="login">Логин</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="login" value="{{$user->name}}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="fio">Фио</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="fio" value="{{$user->fio}}" readonly>
                                </div>
                            </div>
                            @if(!empty($user->getClientInfo->company_name))
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="company-name">Название компании</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="company-name" value="{{$user->getClientInfo->company_name}}" readonly>
                                </div>
                            </div>
                            @endif
                            @if(!empty($user->getClientInfo->address))
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="address">Адрес</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="address" value="{{$user->getClientInfo->address}}" readonly>
                                </div>
                            </div>
                            @endif
                            @if(!empty($user->getClientInfo->phone))
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="phone">Телефон</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="phone" value="{{$user->getClientInfo->phone}}" readonly>
                                </div>
                            </div>
                            @endif
                            @if(!empty($user->getClientInfo->company_info))
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="info-company">Информация о компании</label>
                                <div class="col-md-8">
                                    <textarea id="info-company" class="form-control" rows="3" readonly>{{$user->getClientInfo->company_info}}</textarea>
                                </div>
                            </div>
                            @endif
                            @if(!empty($user->getClientInfo->days_left))
                            <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-3 progress-bar-form">
                                <span class="stats-title">Осталось дней:</span>
                                <span class="stats-complete" >{{$user->getClientInfo->days_left}}</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="{{floor($user->getClientInfo->days_left /365*100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {!!floor($user->getClientInfo->days_left /365*100).'%'!!};">
                                    </div>
                                </div>
                            </div>
                            </div>
                            @endif
                        </fieldset>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-12" style="text-align: center">
                                    <a href="{{URL::previous()}}" class="btn btn-default">Вернуться назад</a>
                                </div>
                            </div>
                        </div>

                    </form>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end: page -->
</section>
</div>
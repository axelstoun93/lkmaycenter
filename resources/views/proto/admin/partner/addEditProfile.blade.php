<div class="row">
    <div class="col-md-4 col-lg-3">
        <section class="panel">
            <div class="panel-body">
                <div class="thumb-info mb-md">
                    <img src="{{asset(env('THEME'))}}/images/partners/logo/{{(!empty($user->getPartnerInfo->logo)) ? $user->getPartnerInfo->logo : 'no-logo.jpg'}}" class="rounded img-responsive">
                    <div class="thumb-info-title">
                        <span class="thumb-info-inner">{{(!empty($user->getPartnerInfo->company_name)) ? $user->getPartnerInfo->company_name :''}}</span>
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
                            <li {!!(!empty($user->email)) ? 'class="completed"' : ''  !!} >Заполнен email</li>
                            <li {!!(!empty($user->getPartnerInfo->company_name)) ? 'class="completed"' : ''  !!} >Название компании</li>
                            <li {!!(!empty($user->getPartnerInfo->logo)) ? 'class="completed"' : ''  !!}>Загружено лого</li>
                            <li {!!(!empty($user->getPartnerInfo->address)) ? 'class="completed"' : ''  !!}>Адрес</li>
                            <li {!!(!empty($user->getPartnerInfo->phone)) ? 'class="completed"' : ''  !!}>Телефон</li>
                            <li {!!(!empty($user->getPartnerInfo->company_info)) ? 'class="completed"' : ''  !!}>Информация о компании</li>
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
                        <form class="form-horizontal" action="{{route('profile.update',['id' => $user->id])}}" method="post" enctype="multipart/form-data">
                            <h4>Мой профиль</h4>
                            {{ csrf_field() }}
                            {{method_field('PUT')}}
                            @if(Session::has('status'))
                                <div class="alert alert-success">
                                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                                    <strong>{!! Session::get('status') !!}</strong>
                                </div>
                            @endif
                            @if(!empty($errors->all()))
                            <div class="validation-message"  style="padding-top: 20px;">
                                    <ul style="display: block;">
                                        @foreach($errors->all() as $error)
                                            <li>
                                                <label class="error"  style="display: inline;">{{$error}}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                            </div>
                            @endif
                            @if($user->countInfo < 7)
                            <div class="alert alert-info">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                                Пожалуйста заполните все поля.
                            </div>
                            @endif
                            <fieldset>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="fio">Фио <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="fio" id="fio" value="{{$user->fio}}" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="email">E-mail <span class="required">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="email" id="email" value="{{$user->email}}" required>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="company-name">Название компании <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="company_name" id="company-name" value="{{(!empty($user->getPartnerInfo->company_name) ? $user->getPartnerInfo->company_name : '')}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="address">Адрес <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="address" id="address" value="{{(!empty($user->getPartnerInfo->address) ? $user->getPartnerInfo->address : '')}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="phone">Телефон <span class="required">*</span></label>
                                        <div class="col-md-8">
                                            <input type="text"  class="form-control" name="phone" id="phone" value="{{(!empty($user->getPartnerInfo->phone) ? $user->getPartnerInfo->phone : '')}}" required>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="site">Сайт</label>
                                    <div class="col-md-8">
                                        <input type="text"  class="form-control" name="site" id="site" placeholder="maycenter.ru" value="{{(!empty($user->getPartnerInfo->site) ? $user->getPartnerInfo->site : '')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Логотип компании</label>
                                    <div class="col-md-8">
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <input value="" name="" type="hidden">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <i class="fa fa-file fileupload-exists"></i>
                                                    <span class="fileupload-preview"></span>
                                                </div>
<span class="btn btn-default btn-file">
<span class="fileupload-exists">Изменить</span>
<span class="fileupload-new">Выбрать файл</span>
<input name="logo" type="file" >
</span>
                                                <a class="btn btn-default fileupload-exists" href="#" data-dismiss="fileupload">Удалить</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="info-company">Информация о компании</label>
                                        <div class="col-md-8">
                                            <textarea id="info-company" name="company_info" class="form-control" rows="3" >{{(!empty($user->getPartnerInfo->company_info) ? $user->getPartnerInfo->company_info : '')}}</textarea>
                                        </div>
                                    </div>
                                @if(!empty($user->getPartnerInfo->days_left))
                                    <div class="form-group">
                                        <div class="col-sm-8 col-sm-offset-3 progress-bar-form">
                                            <span class="stats-title">Осталось дней:</span>
                                            <span class="stats-complete" >{{$user->getPartnerInfo->days_left}}</span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="{{floor($user->getPartnerInfo->days_left /365*100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {!!floor($user->getPartnerInfo->days_left /365*100).'%'!!};">
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
                                        <button class="btn btn-primary">{{!empty($user->id) ? 'Обновить' : 'Создать' }}</button>
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
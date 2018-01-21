<div id="edit" class="tab-pane">

    <div class="row">
        <div class="col-md-12">

            <form id="add-clients" action="{{!empty($user->id)? route('users.update',['id' => $user->id]) :route('users.store')}}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                @if(!empty($user->id))
                    {{method_field('PUT')}}
                @endif
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                        </div>
                        @if(!empty($user->id))
                        <h2 class="panel-title">Редактирование пользователя - {{$user->name}}</h2>
                        <p class="panel-subtitle">
                            Семь раз подумай, один раз обнови =)
                        </p>
                        @else
                            <h2 class="panel-title">Создание аккаунта пользователя</h2>
                            <p class="panel-subtitle">
                                Пожалуйста заполните все поля.
                            </p>
                        @endif
                    </header>
                    <div class="panel-body">
                        <div class="validation-message">
                            @if(!empty($errors->all()))
                                <ul style="display: block;">
                                @foreach($errors->all() as $error)
                                        <li>
                                            <label class="error" for="email" style="display: inline;">{{$error}}</label>
                                        </li>
                                @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Логин <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="name" class="form-control" title="Пожалуйста укажите логин клиента" placeholder="Логин клиента" value="{{!empty($user->name) ? $user->name : old('name')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Фио <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="fio" class="form-control" title="Пожалуйста укажите Фио клиента" placeholder="Фио клиента" value="{{!empty($user->fio) ? $user->fio : old('fio')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="email" name="email" class="form-control" title="Пожалуйста введите адрес электронной почты." placeholder="Email клиента" value="{{!empty($user->email) ? $user->email : old('email')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="roles">Роль <span class="required">*</span></label>
                            <div class="col-md-6">
                                <select class="form-control mb-md" name="roles">
                                    <option {{(!empty($user->roles[0]->id) and $user->roles[0]->id == 3) ? 'selected' :''}} value="3">Партнер</option>
                                    <option {{(!empty($user->roles[0]->id) and $user->roles[0]->id == 2) ? 'selected' :''}} value="2">Менеджер</option>
                                </select>
                            </div>
                        </div>
                        @if(!empty($user->id) and $user->roles[0]->id >= 3 )

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputSuccess">Статус <span class="required">*</span></label>
                            <div class="col-md-6">
                        <select class="form-control mb-md" name="status">
                            <option {{($user->getPartnerInfo->status == 1) ? 'selected' :''}} value="1">Активирован</option>
                            <option {{($user->getPartnerInfo->status == 0) ? 'selected' :''}} value="0">Деактевирован</option>
                        </select>
                                </div>
                            </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Продлить на 1 год</label>
                            <div class="col-sm-2">
                                <div class="radio-custom">
                                    <input id="extendNo" name="extend"  type="radio" value="0" checked>
                                    <label for="extendNo">Нет</label>
                                </div>
                                <div class="radio-custom radio-success">
                                    <input id="extendYes" name="extend" value="1"  type="radio">
                                    <label for="extendYes">Да</label>
                                </div>
                                </div>
                                <div class="col-sm-4 progress-bar-form">
                                    <span class="stats-title">Осталось дней:</span>
                                    <span class="stats-complete" >{{$user->getPartnerInfo->days_left}}</span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="{{floor($user->getPartnerInfo->days_left /365*100)}}" aria-valuemin="0" aria-valuemax="100" style="width: {!!floor($user->getPartnerInfo->days_left /365*100).'%'!!};">

                                        </div>
                                    </div>
                                </div>
                        </div>
                            @endif
                        <div class="form-group">
                            <label class="control-label col-md-3">Пароль<span class="required">*</span></label>
                            <div class="col-md-6">
                                <section class="form-group-vertical">
                                    <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                    <span class="icon">
                                    <i class="fa fa-key"></i>
                                    </span>
                                    </span>
                                        <input class="form-control" name="password" placeholder="Пароль" type="password">
                                    </div>
                                    <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                    <span class="icon">
                                    <i class="fa fa-key"></i>
                                    </span>
                                    </span>
                                        <input class="form-control" name="repeat-password" placeholder="Повторите пароль" type="password">
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <a id="generate" class="btn btn-default">{{!empty($user->id) ? 'Сгенерировать новый пароль' : 'Сгенерировать пароль' }}</a>
                            </div>
                            <div id="generate-windows" class="col-sm-12" style="margin-top:10px;">

                            </div>
                        </div>

                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <a href="{{URL::previous()}}" class="btn btn-default">Назад</a>
                                @if(empty($user->id))
                                <button type="reset" class="btn btn-default">Обновить</button>
                                @endif
                                <button class="btn btn-primary">{{!empty($user->id) ? 'Обновить' : 'Создать' }}</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>

</div>
    </div>
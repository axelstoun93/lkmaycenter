<div id="add-edit" class="tab-pane">
    <div class="row">
        <div class="col-md-12">
            <form id="add-clients" action="{{!empty($job->id)? route('jobs.update',['id' => $job->id]) :route('jobs.store')}}" method="post" class="form-horizontal">
                {{ csrf_field() }}
                @if(!empty($job->id))
                    {{method_field('PUT')}}
                @endif
                <input type="hidden" name="post_id" value="{{(!empty($job->post_id)) ? $job->post_id : ''}}"/>
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                        </div>
                        @if(!empty($job->id))
                            <h2 class="panel-title">Редактирование вакансии - {{$job->job_title}}</h2>
                            <p class="panel-subtitle">
                                Пожалуйста заполните все поля.
                            </p>
                        @else
                            <h2 class="panel-title">Размещение вакансии</h2>
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
                            <label class="col-sm-3 control-label" for="title">Название должности <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="title"  id="title" class="form-control" title="Пожалуйста укажите логин клиента" placeholder="Парикмахер-универсал" value="{{!empty($job->job_title) ? $job->job_title : old('title')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="category">
                                Категория
                                <span class="required">*</span>
                            </label>
                            <div class="col-md-6">
                                <select class="form-control mb-md" id="category" name="category" required>
                                 @if(!empty($job->job_category))
                                    <option value="{{$job->job_category}}">{{$job->job_category}}</option>
                                  @else
                                        <option></option>
                                  @endif
                                    <option value="Парикхмахерское искусство">Парикхмахерское искусство</option>
                                    <option value="Нейл-арт">Нейл-арт</option>
                                    <option value="Косметология">Косметология</option>
                                    <option value="Визаж">Визаж</option>
                                    <option value="Менеджмент">Менеджмент</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="salary">Заработная плата <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="salary"  id="salary" class="form-control" placeholder="30 000 - 50 000 руб." value="{{!empty($job->salary) ? $job->salary : old('salary')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="schedule">График работы <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="schedule"  id="schedule" class="form-control" placeholder="5/7" value="{{!empty($job->working_schedule) ? $job->working_schedule : old('schedule')}}"  required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="experience">Необходимый опыт работы <span class="required">*</span></label>
                            <div class="col-sm-6">
                                <input type="text" name="experience"  id="experience" class="form-control" placeholder="5 лет" value="{{!empty($job->work_experience) ? $job->work_experience : old('experience')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="address">Адрес</label>
                            <div class="col-sm-6">
                                <input type="text" name="address"  id="address" class="form-control" placeholder="Санкт-Петербург, Тепловозная улица, 31" value="{{!empty($job->address) ? $job->address : old('address')}}" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="duties">Обязанности <span class="required"> *</span></label>
                            <div class="col-sm-6">
                                <textarea  name="duties" id="duties" class="form-control" required>{{!empty($job->duties) ? $job->duties : old('duties')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="demand">Требование к кандидату <span class="required"> *</span></label>
                            <div class="col-sm-6">
                                <textarea  name="demand" id="demand" class="form-control"  required>{{!empty($job->demand) ? $job->duties : old('demand')}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="condition">Условия работы <span class="required"> *</span></label>
                            <div class="col-sm-6">
                                <textarea  name="condition" id="condition" class="form-control"  required>{{!empty($job->condition) ? $job->condition : old('condition')}}</textarea>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-12" style="text-align: center">
                                <a href="{{URL::previous()}}" class="btn btn-default">Назад</a>
                                @if(empty($job->id))
                                    <button type="reset" class="btn btn-default">Обновить</button>
                                @endif
                                <button class="btn btn-primary">{{!empty($job->id) ? 'Обновить' : 'Добавить' }}</button>
                            </div>
                        </div>
                    </footer>
                </section>
            </form>
        </div>
    </div>
</div>
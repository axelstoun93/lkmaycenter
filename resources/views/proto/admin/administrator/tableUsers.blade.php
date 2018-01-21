<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>
        <h2 class="panel-title">Список пользователей</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-md">
                    <a href="{{route('users.create')}}" id="addToTable" class="btn btn-primary">Добавить пользователя <i class="fa fa-plus"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <div id="datatable-editable_filter" class="dataTables_filter">
                    <label>
                        <input class="form-control" placeholder="Поиск..." aria-controls="datatable-editable" type="search">
                    </label>
                </div>
            </div>
        </div>
        @if(Session::has('status'))
            <div class="alert alert-success">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>{!! Session::get('status') !!}</strong>
            </div>
        @endif
        @if(!empty($users))
        <table class="table table-bordered table-striped mb-none" id="datatable-editable">
            <thead>

            <tr>
                <th>Логин</th>
                <th>ФИО</th>
                <th>Осталось дней</th>
                <th>Роль</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as  $value)

                <tr class="gradeA">
                    <td>{!! $value->name !!}</td>
                    <td>{!! $value->fio !!}</td>
                    <td>@if(!empty($value->getPartnerInfo->days_left))
                            {!! $value->getPartnerInfo->days_left !!}
                     @endif
                    </td>
                    <td>
                        @if(!empty($value->roles[0]->name))
                            {!! $value->roles[0]->name !!}
                        @endif
                    </td>
                    <td>
                            @if(!empty($value->roles[0]->id == '3'))
                            @if(!empty($value->getPartnerInfo->status))
                            Активирован
                            @else
                            Деактивирован
                            @endif
                            @else

                            @endif
                    </td>
                    <td class="actions">
                        <a href="{{route('users.show',['id'=> $value->id])}}" class="on-default show-row"><i class="el-icon-eye-open"></i></a>
                        <a href="{{route('users.edit',['id'=> $value->id])}}" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="on-default remove-row" data-form-id="{{$value->id}}"><i class="fa fa-trash-o"></i></a>
                        <form action="{{route('users.destroy',['id' => $value->id])}}"  data-form="{{$value->id}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
            @else
            <div class="alert alert-success">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Нет данных!</strong>
            </div>
        @endif
        <div class="row datatables-footer">
            <div class="col-sm-12 col-md-6">
                <div id="datatable-editable_info" class="dataTables_info" role="status" aria-live="polite"></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="datatable-editable_paginate" class="dataTables_paginate paging_bs_normal">
                    <ul class="pagination">
                        @if(!empty($users))
                        @if($users->lastPage() > 1)
                            @if($users->currentPage() == 1)
                                <li class="prev disabled">
                                    <a href="#">
                                        <span class="fa fa-chevron-left"></span>
                                    </a>
                                </li>
                                @else
                                <li class="prev">
                                    <a href="{{$users->url(($users->currentPage() - 1)) }}">
                                        <span class="fa fa-chevron-left"></span>
                                    </a>
                                </li>
                            @endif
                            @for($i = 1; $i <= $users->lastPage(); $i++)
                                @if($users->currentPage() == $i)
                                        <li href="{{$users->url($i) }}" class="active">
                                            <a href="#">{{$i}}</a>
                                        </li>
                                @else
                                        <li>
                                            <a href="{{$users->url($i) }}">{{ $i }}</a>
                                        </li>
                                @endif
                            @endfor

                            @if($users->currentPage() == $users->lastPage())
                                    <li class="prev disabled">
                                        <a href="#">
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                    </li>
                                @else
                                    <li class="prev">
                                        <a href="{{$users->url(($users->currentPage() + 1)) }}">
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                    </li>
                            @endif
                        @endif
                            @endif
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!-- modal windows -->

    <div class="modal fade" id="modal-admin" tabindex="-1">
        <div class="mfp-bg mfp-ready"></div>
    <div id="dialog" class="modal-block mfp-show" style="z-index: 10001;">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title">Удаление</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>Вы уверены что хотите удалить пользователя ?</p>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button id="dialogConfirm" class="btn btn-primary">Да</button>
                        <button id="dialogCancel" class="btn btn-default">Отмена</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
        </div>
    <!-- modal windows close-->
</section>

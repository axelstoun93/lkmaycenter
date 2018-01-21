<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>
        <h2 class="panel-title">Список клиентов</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-md">
                    <a href="{{route('clients.create')}}" id="addToTable" class="btn btn-primary">Добавить клиента <i class="fa fa-plus"></i></a>
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
        @if(!empty($clients))
        <table class="table table-bordered table-striped mb-none" id="datatable-editable">
            <thead>

            <tr>
                <th>Логин</th>
                <th>ФИО</th>
                <th>Осталось дней</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>

            <tbody>
            @foreach($clients as  $value)
                @if(!empty($value->getClientInfo))
                @endif
                <tr class="gradeA">
                    <td>{!! $value->name !!}</td>
                    <td>{!! $value->fio !!}</td>
                    <td>@if(!empty($value->getClientInfo->days_left))
                            {!! $value->getClientInfo->days_left !!}
                     @endif
                    </td>
                    <td>
                            @if(!empty($value->getClientInfo->status))
                            Активирован
                            @else
                            Деактивирован
                            @endif
                    </td>
                    <td class="actions">
                        <a href="{{route('clients.show',['id'=> $value->id])}}" class="on-default show-row"><i class="el-icon-eye-open"></i></a>
                        <a href="{{route('clients.edit',['id'=> $value->id])}}" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                        <a href="#" class="on-default remove-row" data-form-id="{{$value->id}}"><i class="fa fa-trash-o"></i></a>
                        <form action="{{route('clients.destroy',['id' => $value->id])}}"  data-form="{{$value->id}}" method="post">
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
                        @if(!empty($clients))
                        @if($clients->lastPage() > 1)
                            @if($clients->currentPage() == 1)
                                <li class="prev disabled">
                                    <a href="#">
                                        <span class="fa fa-chevron-left"></span>
                                    </a>
                                </li>
                                @else
                                <li class="prev">
                                    <a href="{{$clients->url(($clients->currentPage() - 1)) }}">
                                        <span class="fa fa-chevron-left"></span>
                                    </a>
                                </li>
                            @endif
                            @for($i = 1; $i <= $clients->lastPage(); $i++)
                                @if($clients->currentPage() == $i)
                                        <li href="{{$clients->url($i) }}" class="active">
                                            <a href="#">{{$i}}</a>
                                        </li>
                                @else
                                        <li>
                                            <a href="{{$clients->url($i) }}">{{ $i }}</a>
                                        </li>
                                @endif
                            @endfor

                            @if($clients->currentPage() == $clients->lastPage())
                                    <li class="prev disabled">
                                        <a href="#">
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                    </li>
                                @else
                                    <li class="prev">
                                        <a href="{{$clients->url(($clients->currentPage() + 1)) }}">
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
                        <p>Вы уверены что хотите удалить клиента ?</p>
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

<section class="panel">
    <header class="panel-heading">
        <div class="panel-actions">
            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
        </div>
        <h2 class="panel-title">Список вакансий</h2>
    </header>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-md">
                    <a href="{{route('jobs.create')}}" id="addToTable" class="btn btn-primary">Добавить вакансию <i class="fa fa-plus"></i></a>
                </div>
            </div>
        </div>
        @if(Session::has('status'))
            <div class="alert {{Session::has('alert') ? Session::get('alert') : Session::get('alert') }}">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>{!! Session::get('status') !!}</strong>
            </div>
        @endif
        @if(count($jobs) != 0  )
            <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Должность</th>
                    <th>Дата обновления</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($jobs as  $value)
                    <tr class="gradeA">
                        <td>{!! $count+=1 !!}</td>
                        <td>{!! $value->job_title !!}</td>
                        <td><i class="fa fa-calendar"></i> {!! $value->updated_at !!}</td>
                        <td><i class="fa fa-calendar"></i> {!! $value->created_at !!}</td>
                        <td class="actions">
                            <a href="{{route('jobs.edit',['id'=> $value->id])}}" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="on-default remove-row" data-form-id="{{$value->id}}"><i class="fa fa-trash-o"></i></a>
                            <form action="{{route('jobs.destroy',['id' => $value->id])}}"  data-form="{{$value->id}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Вы не разместили еще не одной вакансии!</strong>
            </div>
        @endif
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
                            <p>Вы уверены что хотите удалить вакансию ?</p>
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
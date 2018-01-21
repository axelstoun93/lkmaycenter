$(function() {

    $('#fc-event-warning').draggable({
        helper: "clone"
    });
    $('#fc-event-primary').draggable(
        {
            helper: "clone"
        });

    $('.fc-event-container').draggable(
        {
            helper: "clone"
        });
    $('.cell-calendar').droppable({
        drop: function(event, ui) {
            var form = document.getElementById('add-events');
            var ev = ui.draggable[0].getAttribute('data-event-class');
            var data = event.target.getAttribute('data-full-data');
            var eventCell = ui.draggable[0].className;
            console.log(eventCell);
            if(ev == 'fc-event-warning' || ev == 'fc-event-primary') {
                $('#modal-add').modal(
                    {
                        keyboard: true,
                        show: true
                    });
                form.reset();
                //get cell date
                $('#modal-add #date').val(data);
                //get event date
                $("#modal-add #type").val(ev);
            }
            if(eventCell == 'fc-event-container ui-draggable')
            {
                var id = ui.draggable[0].getAttribute('data-id');
                var data = {date:data};
                console.log(data);
                var updateUrl = 'http://' + location.host + '/administrator/offsets/' + id;
                $.ajax(
                    {
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: updateUrl,
                        data:data,
                        asyns:false,
                        method:'POST',
                        dataType:'json',
                        success:function(e)
                        {
                            location.reload(true);
                        },
                        error:function(e)
                        {
                            alert('Ошибка при получении данных')
                        }
                    });
            }
        },
        tolerance: "intersect",
        hoverClass: "active"
    });
    //Кликаем кнопку отправить
    //Мутим получение данных о событии
    $('.fc-event-container').click(function(e)
    {
        var id = this.getAttribute('data-id');
        var url = 'http://'+ location.host + '/administrator/offsets/' + id + '/edit';
        var updateUrl = 'http://' + location.host + '/administrator/offsets/' + id;
        var form = document.getElementById('edit-events');
        if($("#deleteEvents").is(':checked'))
        {
            var data = {_method:'DELETE'};
            $.ajax(
                {
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: updateUrl,
                    data:data,
                    asyns:false,
                    method:'POST',
                    dataType:'json',
                    success:function(e)
                    {
                     $('#modal-edit').modal('hide');
                        location.reload(true);
                    },
                    error:function(e)
                    {
                        alert('Ошибка при получении данных')
                    }
                });
        }
        else
        {
        $.ajax(
            {
                method:'GET',
                url:url,
                dataType:'JSON',
                success:function(json)
                {
                    $('#modal-edit').modal(
                        {
                            keyboard: true,
                            show: true
                        });
                    $('#modal-edit #start').val('10');
                    (json.hasOwnProperty('title'))  ?   $('#modal-edit #title').val(json.title) : '';
                    (json.hasOwnProperty('category_id'))  ?   $('#modal-edit #category').val(json.category_id) : '';
                    (json.hasOwnProperty('course_css'))  ?   $('#modal-edit #type').val(json.course_css) : '';
                    (json.hasOwnProperty('date'))  ?   $('#modal-edit #date').val(json.date) : '';
                    (json.hasOwnProperty('start_time'))  ?   $('#modal-edit #start').val(json.start_time) : '';
                    (json.hasOwnProperty('end_time'))  ?   $('#modal-edit #end').val(json.end_time) : '';
                    (json.hasOwnProperty('course_note'))  ?   $('#modal-edit #note').val(json.course_note) : '';
                },
                error:function()
                {
                    alert('Произошла ошибка при получении данных');
                }
            });
        // отправка данных
        $('#edit-events #dialogConfirm').click(function(e)
        {

            var data = $('#edit-events').serializeArray();

            e.preventDefault();
            $.ajax(
                {
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: updateUrl,
                    data:data,
                    asyns:false,
                    method:'POST',
                    dataType:'json',
                    success:function(e)
                    {
                        $('#modal-edit').modal('hide');
                        location.reload(true);
                    },
                    error:function(e)
                    {
                        console.log(e);
                        alert('Ошибка при получении данных')
                    }
                });


        });
        }
    });
    //Клики по кнопкам навигации
    $('#data-prev').click(function()
    {
        var date = this.getAttribute('data-prev');
        var updateUrl = 'http://' + location.host + '/administrator/offsets/' + date;
        location.assign(updateUrl);
    });
    $('#data-next').click(function()
    {
        var date = this.getAttribute('data-next');
        var updateUrl = 'http://' + location.host + '/administrator/offsets/' + date;
        location.assign(updateUrl);
    });
    $('#data-now').click(function()
    {
        var date = this.getAttribute('data-prev');
        var updateUrl = 'http://' + location.host + '/administrator/offsets/';
        location.assign(updateUrl);
    });

    //Кликаем по кнопке добавить событие
    $('#add-event').click(function()
    {
        $('#modal-add').modal(
            {
                keyboard: true,
                show: true
            });
        form.reset();
        //get cell date
        $('#modal-add #date').val(data);
        //get event date
        $("#modal-add #type").val(ev);

    });


    //---
    $('.modal-block  #dialogCancel').click(function(e)
    {
        e.preventDefault();
        $('#modal-add').modal('hide');
        $('#modal-edit').modal('hide');
    });
});
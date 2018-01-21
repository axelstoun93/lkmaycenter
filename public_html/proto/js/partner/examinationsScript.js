$(function() {

    //Клики по кнопкам навигации
    $('#data-prev').click(function()
    {
        var date = this.getAttribute('data-prev');
        var updateUrl = 'http://' + location.host + '/partner/examinations/' + date;
        location.assign(updateUrl);
    });
    $('#data-next').click(function()
    {
        var date = this.getAttribute('data-next');
        var updateUrl = 'http://' + location.host + '/partner/examinations/' + date;
        location.assign(updateUrl);
    });
    $('#data-now').click(function()
    {
        var date = this.getAttribute('data-prev');
        var updateUrl = 'http://' + location.host + '/partner/examinations/';
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
    $('.fc-event-container').click(function(e)
    {
        var id = this.getAttribute('data-id');
        var url = 'http://'+ location.host + '/partner/examinations/'+id;
        var urlEnroll = 'http://'+ location.host + '/partner/examinations';
        var form = document.getElementById('edit-events');
        var array;
        var title;
            $.ajax(
                {
                    method:'GET',
                    url:url,
                    dataType:'JSON',
                    success:function(json)
                    {
                        $('#modal-show').modal(
                            {
                                keyboard: true,
                                show: true
                            });
                        array = json;
                        title =  (json.hasOwnProperty('title'))  ?   (json.title) : '';
                        $('#modal-show #start').val('10');
                        (json.hasOwnProperty('title'))  ?   $('#modal-show #title').val(json.title) : '';
                        (json.hasOwnProperty('category_id'))  ?   $('#modal-show #category').val(json.category_id) : '';
                        (json.hasOwnProperty('course_css'))  ?   $('#modal-show #type').val(json.course_css) : '';
                        (json.hasOwnProperty('date'))  ?   $('#modal-show #date').val(json.date) : '';
                        (json.hasOwnProperty('start_time'))  ?   $('#modal-show #start').val(json.start_time) : '';
                        (json.hasOwnProperty('end_time'))  ?   $('#modal-show #end').val(json.end_time) : '';
                        (json.hasOwnProperty('course_note'))  ?   $('#modal-show #note').val(json.course_note) : '';
                        $("#modal-show #title").prop("disabled", true);
                        $("#modal-show #category").prop("disabled", true);
                        $("#modal-show #type").prop("disabled", true);
                        $("#modal-show #date").prop("disabled", true);
                        $("#modal-show #start").prop("disabled", true);
                        $("#modal-show #end").prop("disabled", true);
                        $("#modal-show #note").prop("disabled", true);
                        
                    },
                    error:function()
                    {
                        alert('Произошла ошибка при получении данных');
                    }
                });
        $('#modal-show #dialogEnroll').click(function (e) {
         
             e.preventDefault();
             array['id'] = id;
            $.ajax(
                {
                    method:'POST',
                    url:urlEnroll,
                    data:array,
                    dataType:'JSON',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(json)
                    {
                        $('#modal-show').modal('hide');
                        $('#modal-alert .modal-text').empty().html('<div class="alert alert-success">Вы были успешно записаны на '+ title +'!</div>');
                        $('#modal-alert').modal(
                            {
                                keyboard: true,
                                show: true
                            });
                        title ='';
                    },
                    error:function()
                    {
                        alert('Произошла ошибка при получении данных!');
                    }
                });
           
        });
});
    //---
    $('.modal-block  #dialogCancel').click(function(e)
    {
        e.preventDefault();
        $('#modal-show').modal('hide');
        $('#modal-alert').modal('hide');
    });
});
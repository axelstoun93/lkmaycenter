/**
 * Created by User on 13.01.2018.
 */
//Вызываем функцию проверки url
selectGet();
//Клики по кнопкам навигации
$('#data-prev').click(function()
{
    var date = this.getAttribute('data-prev');
    var updateUrl = 'http://' + location.host + '/manager/schedule/' + date;
    location.assign(updateUrl);
});
$('#data-next').click(function()
{
    var date = this.getAttribute('data-next');
    var updateUrl = 'http://' + location.host + '/manager/schedule/' + date;
    location.assign(updateUrl);
});
$('#data-now').click(function()
{
    var date = this.getAttribute('data-prev');
    var updateUrl = 'http://' + location.host + '/manager/schedule/';
    location.assign(updateUrl);
});
//Клики по кнопкам навигации находясь в неделе 
$('#data-week-prev').click(function()
{
    var date = this.getAttribute('data-prev');
    var updateUrl = 'http://' + location.host + '/manager/schedule/' + date;
    location.assign(updateUrl);
});
$('#data-week-next').click(function()
{
    var date = this.getAttribute('data-next');
    var updateUrl = 'http://' + location.host + '/manager/schedule/' + date;
    location.assign(updateUrl);
});
$('#data-week-now').click(function()
{
    var date = this.getAttribute('data-prev');
    var updateUrl = 'http://' + location.host + '/manager/schedule/';
    location.assign(updateUrl);
});
// Перетаскиваемые действия
$('#fc-event-success').draggable({
    helper: "clone"
});
$('#fc-event-warning').draggable(
    {
        helper: "clone"
    });
$('#fc-event-primary').draggable({
    helper: "clone"
});
$('#fc-event-info').draggable(
    {
        helper: "clone"
    });
$('#fc-event-default').draggable(
    {
        helper: "clone"
    });
$('.fc-event-container').draggable(
    {
        helper: "clone"
    });
//

$('.cell-week').droppable({
    drop: function(event, ui) {
        var form = document.getElementById('add-events');
        var ev = ui.draggable[0].getAttribute('data-event-class');
        var date = event.target.getAttribute('data-full-date');
        var eventCell = ui.draggable[0].className;
        switch (ev)
        {
            case 'fc-event-success':
                $('#modal-add').modal(
                    {
                        keyboard: true,
                        show: true
                    });
                form.reset();
                //get cell date
                $('#modal-add #date').val(date);

                $("#modal-add #category").val("2");
                break;
            case 'fc-event-warning':
                $('#modal-add').modal(
                    {
                        keyboard: true,
                        show: true
                    });
                form.reset();
                //get cell date
                $('#modal-add #date').val(date);
                //get event date
                $("#modal-add #category").val("3");
            break;
            case 'fc-event-primary':
                $('#modal-add').modal(
                    {
                        keyboard: true,
                        show: true
                    });
                form.reset();
                //get cell date
                $('#modal-add #date').val(date);
                //get event date
                // add
                $("#modal-add #category").val("4");
                break;
            case 'fc-event-info':
                $('#modal-add').modal(
                    {
                        keyboard: true,
                        show: true
                    });
                form.reset();
                //get cell date
                $('#modal-add #date').val(date);
                //get event date
                // add
                $("#modal-add #category").val("5");
                break;
            case 'fc-event-default':
                $('#modal-add').modal(
                    {
                        keyboard: true,
                        show: true
                    });
                form.reset();
                //get cell date
                $('#modal-add #date').val(date);
                //get event date
                // add
                $("#modal-add #category").val("6");
                break;
        }
        //Динамическое перемещение
        if(eventCell == 'fc-event-container ui-draggable')
        {
            var id = ui.draggable[0].getAttribute('data-id');
            var data = {date:date};
            var updateUrl = 'http://' + location.host + '/manager/schedule/' + id;
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
                        console.log(e);
                        alert('Ошибка при получении данных')
                    }
                });
        }
    },
    tolerance: "intersect",
    hoverClass: "active"
});

//закрыть модельное окно
$('.modal-block  #dialogCancel').click(function(e)
{
    e.preventDefault();
    $('#modal-add').modal('hide');
    $('#modal-edit').modal('hide');
});
// Дата и время в формах
$('#date').datepicker({
    format: 'dd/mm/yyyy'
});
$('#start').timepicker({
    format: 'H:i:s',
    showMeridian: false
});
$('#end').timepicker({
    format: 'H:i:s',
    showMeridian: false
});
$('#date-edit').datepicker({
    format: 'dd/mm/yyyy'
});
$('#start-edit').timepicker({
    format: 'H:i:s',
    showMeridian: false
});
$('#end-edit').timepicker({
    format: 'H:i:s',
    showMeridian: false
});
// Получаем удаляем данные
$('.fc-event-container').click(function(e)
{
    var id = this.getAttribute('data-id');
    var url = 'http://'+ location.host + '/manager/schedule/' + id + '/edit';
    var updateUrl = 'http://' + location.host + '/manager/schedule/' + id;
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
                    (json.hasOwnProperty('title'))  ?   $('#modal-edit #title').val(json.title) : '';
                    (json.hasOwnProperty('place'))  ?   $('#modal-edit #place').val(json.place) : '';
                    (json.hasOwnProperty('note'))  ?   $('#modal-edit #note').val(json.note) : '';
                    (json.hasOwnProperty('schedule_css'))  ?   $('#modal-edit #css').val(json.schedule_css) : '';
                    (json.hasOwnProperty('category_id'))  ?   $('#modal-edit #category').val(json.category_id) : '';
                    (json.hasOwnProperty('date'))  ?   $('#modal-edit #date-edit').val(json.date) : '';
                    (json.hasOwnProperty('start_time'))  ?   $('#modal-edit #start-edit').val(json.start_time) : '';
                    (json.hasOwnProperty('end_time'))  ?   $('#modal-edit #end-edit').val(json.end_time) : '';
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
                        alert('Ошибка при получении данных')
                    }
                });


        });
    }
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
});

// Выборка отделений
$('#filter-category').on('change', function() {
    var change = this.value;
    var url = location.href.split('?');
    var readyUrl =  url[0]+'?category=' + change;
    setLocation(readyUrl);
    hideDiv(change,'slow');

});
function hideDiv(value,speed) {
    var change = value;
    $(".fc-day-content").each(function (i, val) {
       var div = $(val).attr('data-category');
       if(change != 0){
       if(div != change)
       {
           $(val).hide(speed);
       }
       else
       {
           $(val).show(speed);
       }
       }
       else {$(val).show(speed);}
    }
    )
}
// Управление фильтрами через get
function selectGet() {
   var param = getUrlVar();
   var category = param['category'];
   if(category)
   {
       hideDiv(param['category'],'fast');
       $("#filter-category [value="+category+"]").attr("selected", "selected");
   }
}
// Динамическое изменения url
function setLocation(curLoc){
    window.history.pushState("", "Расписание академии Май", curLoc);
}




// Функция для разбора get

function getUrlVar(){
    var urlVar = window.location.search; // получаем параметры из урла
    var arrayVar = []; // массив для хранения переменных
    var valueAndKey = []; // массив для временного хранения значения и имени переменной
    var resultArray = []; // массив для хранения переменных
    arrayVar = (urlVar.substr(1)).split('&'); // разбираем урл на параметры
    if(arrayVar[0]=="") return false; // если нет переменных в урле
    for (i = 0; i < arrayVar.length; i ++) { // перебираем все переменные из урла
        valueAndKey = arrayVar[i].split('='); // пишем в массив имя переменной и ее значение
        resultArray[valueAndKey[0]] = valueAndKey[1]; // пишем в итоговый массив имя переменной и ее значение
    }
    return resultArray; // возвращаем результат
}
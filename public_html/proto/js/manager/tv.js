//Клики по кнопкам навигации
$('#data-prev').click(function()
{
    var date = this.getAttribute('data-prev');
    var updateUrl = 'http://' + location.host + '/tv/' + date;
    location.assign(updateUrl);
});
$('#data-next').click(function()
{
    var date = this.getAttribute('data-next');
    var updateUrl = 'http://' + location.host + '/tv/' + date;
    location.assign(updateUrl);
});
$('#data-now').click(function()
{
    var date = this.getAttribute('data-prev');
    var updateUrl = 'http://' + location.host + '/tv/';
    location.assign(updateUrl);
});
/* Фильтр */
$('#filter-category').on('change', function() {
    var change = this.value;
    hideDiv(change,'fast');

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
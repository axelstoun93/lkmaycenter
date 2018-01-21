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
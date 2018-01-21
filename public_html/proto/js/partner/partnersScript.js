// Ограничиваем доступ к разделам сайта
$('.nav-main a').hover(function()
{
    if(this.getAttribute('data-l-access') == 'true')
    {
        $(this).click(function(e)
        {
            e.preventDefault();
        });
        $(this).css({cursor:'not-allowed'});
    }

});
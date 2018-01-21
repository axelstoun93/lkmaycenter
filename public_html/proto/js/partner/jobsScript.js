jQuery(document).ready(function($) {
    $("#datatable-editable").tablesorter({
        headers:{
            4:{
                sorter:false
            }
        }
    });
    $('.remove-row').click(function(e)
    {
         e.preventDefault();
        $('#modal-admin').modal(
            {
                keyboard: true,
                show:true
            });
        $('.modal-block  #dialogCancel').click(function()
        {
            $('#modal-admin').modal('hide');
        })
        $('.modal-block  #dialogConfirm').click(function()
        {
            var elemA;
            elemA = e.target.parentElement;
            var formAtr = elemA.getAttribute('data-form-id');
            var form = $("[data-form = " + formAtr +"]");
            // Вызываем форму
            form.submit();
        })
    });
});
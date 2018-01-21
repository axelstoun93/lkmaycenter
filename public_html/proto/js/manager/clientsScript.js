jQuery(document).ready(function($) {
    $("#datatable-editable").tablesorter({
        headers:{
            4:{
                sorter:false
            }
        }
    });
    $('#datatable-editable_filter input').click(function () {

            $('#datatable-editable_filter input').keypress(function(e){
                if(e.keyCode==13){
                    var searchString = $('#datatable-editable_filter input').val();
                    var url = location.href.split('?');
                    var urldone = url[0] + '?search=' + searchString;
                    window.location.replace(urldone);
                }
            });
        $('#datatable-editable_filter input').focusout(function(){
            var searchString = $('#datatable-editable_filter input').val();
            var url = location.href.split('?');
            var urldone = url[0] + '?search=' + searchString;
            window.location.replace(urldone);
        });
    })
    /*generate password*/
    /*------------------------------------------------------------------------------*/
    $("form #generate").click(function () {
       var password = PassGenJS.getPassword({score: 2});
       var inputPassword =  $("input[name='password']");
       var repeatPassword =  $("input[name='repeat-password']");
       inputPassword.val(password);
       repeatPassword.val(password);
       $('#generate-windows').html('<div class="col-sm-2 col-sm-offset-5 alert alert-success" ><button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button> <strong>Пароль:</strong> '+password+'</div>');
    });
    /*validate form*/
    $("#add-clients").submit(function (e) {
        e.preventDefault();
        var inputPassword =  $("input[name='password']");
        var repeatPassword =  $("input[name='repeat-password']");
        if(inputPassword.val() === repeatPassword.val())
        {
            (this).submit();
        }
        else
        {
            $('#generate-windows').html('<div class="col-sm-4 col-sm-offset-4 alert alert-danger" ><button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button> <strong>Пароли не совпадают друг с другом.</strong></div>');
        }
    });
    /*delete windows open logic*/

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
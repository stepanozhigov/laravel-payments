$(function() {
    var $form = $('#oldpayment-form');
    //console.log($form);
    $form.submit((e)=>{
        e.preventDefault();
        $.post('/api/create',$form.serialize())
            .done((res)=>{
                if(res.status == 'success') {
                    //console.log(res);
                    window.location.href = res.redirect_to;
                }
            });
    })
});

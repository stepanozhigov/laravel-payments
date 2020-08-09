$(function() {
    var $form = $('#qwertykassa-form');
    //console.log($form);
    $form.submit((e)=>{
        e.preventDefault();
        $.post('/oldpay',$form.serialize())
            .done((res)=>{
                if(res.status == 'success') {
                    window.location.href = $form.data('url')+res.redirect_to;
                }
            });
    })
});

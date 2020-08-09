$(function() {
    var $form = $('#qwertykassa-form');
    //console.log($form);
    $form.submit((e)=>{
        e.preventDefault();
        $.post('/qwertykassa',$form.serialize())
            .done((res)=>{
                //console.log(res.status);
                if(res.status == 'success') {
                    //console.log($form.data('url')+res.redirect_to);
                    window.location.href = $form.data('url')+res.redirect_to;
                }
        });
    })
});

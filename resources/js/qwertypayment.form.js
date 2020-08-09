$(function() {
    var $form = $('#qwertykassa-form');
    //console.log($form);
    //SUBMIT FORM
    $form.submit((e)=>{
        e.preventDefault();
        $.post('/qwertykassa',$form.serialize())
            .done((res)=>{
                //console.log(res.status);
                if(res.status == 'success') {
                    fillValues(res);
                    showResult();
                }
        });
    });
    //FILL VALUES
    function fillValues(res) {
        $('#result-order_id').next().text(res.order_id);
        $('#result-payment_id').next().text(res.payment_id);
        $('#result-sum').next().text(res.sum);
        $('#result-currency').next().text(res.currency);
        $('#result-link').attr('href',$form.attr('action')+'/'+res.id);
    }

    //TOGGLE BOX
    function showResult() {
        $('#result-box').show();
    }
    function hideResult() {
        $('#result-box').hide();
    }

    //CLICK CLOSE BOX
    $('#close-box').click((e)=>{
        e.preventDefault();
        hideResult();
    });

});



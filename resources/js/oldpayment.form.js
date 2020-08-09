$(function() {
    var $form = $('#oldpayment-form');
     var $transaction_id = $('#transaction_id');
     var $secret_key = $('#secret_key');
     var $searchForm = $('#search-form');
     var $searchResult = $('#search-result');
    // console.log($searchForm);
    // console.log($searchResult);

    //SUBMIT PAYMENT FORM
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

    //SUBMIT SEARCH FORM
    $searchForm.submit(function (e) {
        e.preventDefault();
        $.get('/api/get-status/'+$transaction_id.val(),{
            'secret_key': $secret_key.val()
        })
        .done(function (res) {
            //FILL DATA
            $('#order_id').text(res.order_id);
            $('#sum').text(res.sum);
            //
            $searchForm.css('display','none');
            $searchResult.css('display','flex');
        });
    });

    //CLICK CLOSE
    $('#close-status').click(function (e) {
        e.preventDefault();
        $searchForm.css('display','flex');
        $searchResult.css('display','none');
    });

});

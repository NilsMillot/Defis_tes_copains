$('.liked').on('click',function(){
    let count = $(this).prev().text();
    if($(this).hasClass('like-challenge') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-challenge-id-'+data).removeClass('far fa-heart like-challenge').addClass('unlike-challenge fas fa-heart')
                    $('.id-'+data+'-count').text(Number(count)+1)
                }
            }
        });
    }else if($(this).hasClass('unlike-challenge') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-challenge-id-'+data).removeClass('fas fa-heart unlike-challenge').addClass('like-challenge far fa-heart')
                    $('.id-'+data+'-count').text(Number(count)-1)
                }
            }
        });
    }
})

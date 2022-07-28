$('.liked').on('click',function(){
    let count = $(this).prev().text();
    if($(this).hasClass('like') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-id-'+data).removeClass('far fa-heart like').addClass('unlike fas fa-heart')
                    $('.id-'+data+'-count').text(Number(count)+1)
                }
            }
        });
    }else{
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-id-'+data).removeClass('fas fa-heart unlike').addClass('like far fa-heart')
                    $('.id-'+data+'-count').text(Number(count)-1)
                }
            }
        });
    }


})

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

$('.liked').on('click',function(){
    let count = $(this).prev().text();
    if($(this).hasClass('like-post') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-post-id-'+data).removeClass('far fa-heart like-post').addClass('unlike-post fas fa-heart')
                    $('.id-'+data+'-count').text(Number(count)+1)
                }
            }
        });
    }else if($(this).hasClass('unlike-post') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-post-id-'+data).removeClass('fas fa-heart unlike-post').addClass('like-post far fa-heart')
                    $('.id-'+data+'-count').text(Number(count)-1)
                }
            }
        });
    }
})

$('.liked').on('click',function(){
    let count = $(this).prev().text();
    if($(this).hasClass('like-remark') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-remark-id-'+data).removeClass('far fa-heart like-remark').addClass('unlike-remark fas fa-heart')
                    $('.id-'+data+'-count').text(Number(count)+1)
                }
            }
        });
    }else if($(this).hasClass('unlike-remark') ){
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.like-remark-id-'+data).removeClass('fas fa-heart unlike-remark').addClass('like-remark far fa-heart')
                    $('.id-'+data+'-count').text(Number(count)-1)
                }
            }
        });
    }
})
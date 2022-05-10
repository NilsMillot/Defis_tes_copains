$('.liked').on('click',function(){
    let count = $(this).prev().text();
    console.log($(this).attr('class'))
    if($(this).hasClass('like') ){
        console.log('like')
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.id-'+data).removeClass('far fa-heart like').addClass('unlike fas fa-heart')
                    $('.id-'+data+'-count').text(Number(count)+1)
                }
            }
        });
    }else{
        console.log('unlike')
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.id-'+data).removeClass('fas fa-heart unlike').addClass('like far fa-heart')
                    $('.id-'+data+'-count').text(Number(count)-1)
                }
            }
        });
    }


})

$('.like_remark').on('click',function(){
    console.log($(this).data('url'));
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                console.log(data)
                $('.id-'+data).attr('data-url',"{{ path('unlike_remark', {'id': post.id }) }}");
                $('.id-'+data).removeClass('far fa-heart like_remark').addClass('unlike_remark fas fa-heart')
            }
        }
    });

})


$('.unlike_remark').on('click',function(){
    console.log("bla")
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                $('.id-'+data).attr('data-url',"{{ path('like_remark', {'id': post.id }) }}");
                $('.id-'+data).removeClass('fas fa-heart unlike_remark').addClass('like_remark far fa-heart')
            }
        }
    });
})
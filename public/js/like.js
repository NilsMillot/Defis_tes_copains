$('.like_post').on('click',function(){
    console.log($(this).data('url'));
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                console.log(data)
                $('.id-'+data).attr('data-url',"{{ path('unlike_post', {'id': post.id }) }}");
                $('.id-'+data).removeClass('far fa-heart like_post').addClass('unlike_post fas fa-heart')
            }
        }
    });

})


$('.unlike_post').on('click',function(){
    console.log("bla")
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                $('.id-'+data).attr('data-url',"{{ path('like_post', {'id': post.id }) }}");
                $('.id-'+data).removeClass('fas fa-heart unlike_post').addClass('like_post far fa-heart')
            }
        }
    });
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
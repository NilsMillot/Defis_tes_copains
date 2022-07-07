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

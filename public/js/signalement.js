$('.signalement').on('click',function(){
    if($(this).hasClass('signale') ) {
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.parent-'+data.id).removeClass('signale').addClass('signaled')
                    $('.id-' + data.id).removeClass('orange-text').addClass('red-text')
                }
            }
        });
    }else{
        $.ajax({
            url: $(this).data('url'),
            type: "GET",
            success: function (data) {
                if (data) {
                    $('.parent-'+data.id).removeClass('signaled').addClass('signale')
                    $('.id-' + data.id).removeClass('red-text').addClass('orange-text')
                }
            }
        });
    }
})

$('.signalement').on('click',function(){
    console.log($(this).data('url'));
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {

            }
        }
    });
})
$('.modal_show_admin').on('click', function(){
    let modal = $('#show_challenge_admin');
    let id = $(this).data('id')
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                console.log(data)
                $('#name').text(data.name)
                $('#image').attr('src',"{{ vich_uploader_asset("+data.image+", 'imageFile') }}")
                modal.modal('open');
            }
        }
    });
})
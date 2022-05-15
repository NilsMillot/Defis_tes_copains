$('.edit_post').on('click', function(){
    console.log($(this).data('url'))
    let modal = $('#modal_post');
    let id = $(this).data('id')
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                console.log(data)
                console.log( $('#post_imageFile_file').val())
                $('#post_id').val(id+'');
                $('#post_name').val(data.name);
                $('#post_content').val(data.content);
                // $('#post_imageFile_file').val(data.image);
                $('.file-field').hide();
                modal.modal('open');
            }
        }
    });
})

$('.create_post').on('click', function() {
    $('.file-field').show();
})
$('.edit_post').on('click', function(){
    let modal = $('#modal_post');
    let id = $(this).data('id')
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                $('.label_post').attr('active')
                $('#post_id').val(id+'');
                $('#post_name').val(data.name);
                $('#post_content').val(data.content);
                $('.file-field').hide();
                modal.modal('open');
            }
        }
    });
})

$('.create_post').on('click', function() {
    $('.file-field').show();
})

$('.edit_remark').on('click', function(){
    let modal = $('#modal1');
    let id = $(this).data('id')
    $.ajax({
        url: $(this).data('url'),
        type: "GET",
        success: function (data) {
            if (data) {
                $('.label_remark').attr('active');
                $("#remark_contentRemark").val(data.content);
                $('#remark_id').val(id+'');
                modal.modal('open');
            }
        }
    });
})
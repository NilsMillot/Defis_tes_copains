
  $(document).ready(function(){
    $('.modal').modal();

    $('.modal_href').on('click',function() {
      $('#post-id').val(this.dataset.id);
    });
  });
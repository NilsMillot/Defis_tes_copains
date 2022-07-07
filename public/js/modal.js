
  $(document).ready(function(){
    $('.modal').modal({
      dismissible: true
    });

    $('.modal_href').on('click',function() {
      $('#post-id').val(this.dataset.id);
    });
  });


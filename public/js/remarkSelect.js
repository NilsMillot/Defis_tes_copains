$('.remark_post_new').on('change', function(){
  console.log($(this).val());
  $.ajax({
    url: 'find/post/'+ Number($(this).val()),
    type: "GET",
    success: function (data) {
      if(data) {
        $('.name_challenge').text('Challenge : '+ data.challenge)
        console.log(data)
      }
    }
  });
})
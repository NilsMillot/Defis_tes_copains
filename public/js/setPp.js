$("#imageUpload").on("change", function () {
  console.log($("#imageUpload")[0]);
  console.log("url", $(this).data("url"));

  var formData = new FormData($("#profil_card_avatar-edit")[0]);
  // var formData = new FormData();
  formData.append('image', $('input[type=file]')[0].files[0]);
  console.log( $('input[type=file]')[0].files[0])
console.log(formData)
  $.ajax({
    url: $(this).data("url"),
    type: "GET",
    data: {
      data: formData
    },
    // data: new FormData($("#imageUpload")[0]),
    // data: $("#imageUpload")[0].files[0],
    // data: {
    //   pp: $("#imageUpload")[0].files[0],
    // },
    success: function (data) {
      console.log(data)
      // $("#image").attr("src", data);
      //   console.log("%csetPp.js line:8 data", "color: #007acc;", data);
      console.log("done");
    },
    processData: false,
  });
});

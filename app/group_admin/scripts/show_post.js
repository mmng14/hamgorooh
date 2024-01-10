$(document).ready(function () {
  $("#menu_user_post_management").addClass("active");

});

function acceptPost(sId,pId) {
  LoadElement('.post__author');
  let check = $("#accept_request_code").val();//ACCEPT_REQUEST_CODE;
  let _csrf = $("#_csrf").val();

  $.ajax({
    url: HOST_NAME + "group_admin/user_posts/",
    type: "POST",
    data: {
      subject_id: sId,
      post_id: pId,
      _csrf: _csrf,
      check: check,
    },
    dataType: "json",
    success: function (data) {
      UnLoadElement('.post__author');
      if (data.result == "1") {
        toastr["success"](data.message);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement('.post__author');
      console.log(xhr);
      toastr["error"]("خطا در انجام عملیات");
    },
  });
}

function rejectPost(sId,pId) {
  LoadElement('.post__author');
  let check = $("#reject_request_code").val();//REJECT_REQUEST_CODE;
  let _csrf = $("#_csrf").val();

  $.ajax({
      url: HOST_NAME + "group_admin/user_posts/",
      type: 'POST',
      data: {
          subject_id: sId,
          post_id: pId,
          _csrf : _csrf,
          check: check,
      },
      dataType: "json",
      success: function (data) {
          UnLoadElement('.post__author');
          if (data.result == "1") {
              toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }
      },
      error: function (xhr, textStatus, errorThrown) {
          UnLoadElement('.post__author');
          toastr["error"]("خطا در انجام عملیات");
      },
  });

}

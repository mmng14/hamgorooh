$(document).ready(function () {
  $("#menu_user_post_management").addClass("active");

});

function acceptPost(sId,pId) {
  LoadElement('#post_item_' + sId + '_' + pId);
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
      UnLoadElement('#post_item_' + sId + '_' + pId);
      if (data.result == "1") {
        toastr["success"](data.message);
        $('#post_item_' + sId + '_' + pId).fadeOut(1000);
        // -----
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement('#post_item_' + sId + '_' + pId);
      console.log(xhr);
      toastr["error"]("خطا در انجام عملیات");
    },
  });
}

function rejectPost(sId,pId) {
  LoadElement('#post_item_' + sId + '_' + pId);
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
          UnLoadElement('#post_item_' + sId + '_' + pId);
          if (data.result == "1") {
              toastr["success"](data.message);
             $('#post_item_' + sId + '_' + pId).fadeOut(1000);
             // -----
          }else{
            toastr["error"](data.message);
          }
      },
      error: function (xhr, textStatus, errorThrown) {
          UnLoadElement('#post_item_' + sId + '_' + pId);
          toastr["error"]("خطا در انجام عملیات");
      },
  });

}

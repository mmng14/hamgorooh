$(document).ready(function () {
  //$("#menu_user_comment_management").addClass("active");
});

function acceptComment(sId,cId) {

  LoadElement('#post_item_' + sId + '_' + cId);
  let check = $("#accept_request_code").val();//ACCEPT_REQUEST_CODE;
  let _csrf = $("#_csrf").val();

  $.ajax({
    url: HOST_NAME + "group_admin/user_comments/",
    type: "POST",
    data: {
      subject_id: sId,
      comment_id: cId,
      _csrf: _csrf,
      check: check
    },
    dataType: "json",
    success: function (data) {
      UnLoadElement('#post_item_' + sId + '_' + cId);
      if (data.result == "1") {
        toastr["success"](data.message);
        $('#post_item_' + sId + '_' + cId).fadeOut(1000);
        // -----
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement('#post_item_' + sId + '_' + cId);
      console.log(xhr);
      toastr["error"]("خطا در انجام عملیات");
      console.log(errorThrown);
    },
  });
}

function rejectComment(sId,cId) {
  LoadElement('#post_item_' + sId + '_' + cId);
  let check = $("#reject_request_code").val();//REJECT_REQUEST_CODE;
  let _csrf = $("#_csrf").val();

  $.ajax({
      url: HOST_NAME + "group_admin/user_comments/",
      type: 'POST',
      data: {
          subject_id: sId,
          comment_id: cId,
          _csrf : _csrf,
          check: check
      },
      dataType: "json",
      success: function (data) {
          UnLoadElement('#post_item_' + sId + '_' + cId);
          if (data.result == "1") {
              toastr["success"](data.message);
             $('#post_item_' + sId + '_' + cId).fadeOut(1000);
             // -----
          }else{
            toastr["error"](data.message);
          }
      },
      error: function (xhr, textStatus, errorThrown) {
          UnLoadElement('#post_item_' + sId + '_' + cId);
          toastr["error"]("خطا در انجام عملیات");
          console.log(errorThrown);
      },
  });

}

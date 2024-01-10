$(document).ready(function () {
  $("#menu_home").addClass("active");
  //$('#menu_ads > ul').show();
  //$('#menu_ads_add').addClass('active');
});

function acceptRequest(rId) {
  LoadElement("#request_item_" + rId);
  let check = $("#accept_request_code").val();//ACCEPT_REQUEST_CODE;
  let _csrf = $("#_csrf").val();

  $.ajax({
    url: HOST_NAME + "group_admin/request_management/",
    type: "POST",
    data: {
      obj: rId,
      _csrf: _csrf,
      check: check,
    },
    dataType: "json",
    success: function (data) {
      UnLoadElement("#request_item_" + rId);
      if (data.result == "1") {
        toastr["success"](data.message);
        $("#request_item_" + rId).fadeOut(1000);
        // -----
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement("#request_item_" + rId);
      console.log(xhr);
      toastr["error"]("خطا در انجام عملیات");
    },
  });
}

function rejectRequest(rId) {
  LoadElement("#request_item_" + rId);
  let check = $("#reject_request_code").val();//REJECT_REQUEST_CODE;
  let _csrf = $("#_csrf").val();

  $.ajax({
      url: HOST_NAME + "group_admin/request_management/",
      type: 'POST',
      data: {
          obj: rId,
          _csrf : _csrf,
          check: check,
      },
      dataType: "json",
      success: function (data) {
          UnLoadElement('#request_item_' + rId);
          if (data.result == "1") {
              toastr["success"](data.message);
             $("#request_item_" + rId).fadeOut(1000);
             // -----
          }else{
            toastr["error"](data.message);
          }
      },
      error: function (xhr, textStatus, errorThrown) {
          UnLoadElement('#request_item_' + rId);
          toastr["error"]("خطا در انجام عملیات");
      },
  });

}

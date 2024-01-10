var postTable = null;

$(document).ready(function () {
  $('#menu_comment_management').addClass('active');
});

window.onload = function () {

  LoadElement("#divResults");

  var this_subject_id = $("#this_subject_id").val();
  var this_category_id = $("#this_category_id").val();
  var this_post_id = $("#this_post_id").val();

  var page = $("#page_num").val();
  $("#results").load(HOST_NAME + "group_admin/comments/", {
    cmd: $('#listing_code').val(),
    page: page,
    s_id: this_subject_id,
    c_id: this_category_id,
    p_id: this_post_id,
    _csrf: $("#_csrf").val(),
  }); //load initial records

  UnLoadElement("#divResults");

  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    LoadElement("#divResults"); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    var exp = document.getElementById("txtsearch").value;
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;

    var this_subject_id = $("#this_subject_id").val();
    var this_category_id = $("#this_category_id").val();
    var this_post_id = $("#this_post_id").val();
  

    $("#results").load(
      HOST_NAME + "group_admin/comments/",
      {
        page: page,
        order: order,
        perpage: perpage,
        s_id: this_subject_id,
        c_id: this_category_id,
        p_id: this_post_id,
        exp: exp,
        _csrf: $("#_csrf").val(),
        cmd: $('#listing_code').val(),
      },
      function () {
        //get content from PHP page
        $("#page_num").val(page);
        var url = window.location.href;
        window.history.pushState(
          "obj",
          "newtitle",
          HOST_NAME + "group_admin/posts/" + cat_filter + "/" + page
        );
        UnLoadElement("#divResults");
      }
    );
  });




$('#txtsearch').on('change', function (e) {
    loadData();
});

$('#cmbnumberPage').on('change', function (e) {
    loadData();
});

$('#cmbsort').on('change', function (e) {
    loadData();
});


  function loadData() {
    LoadElement("#divResults"); //show loading element
    var page = $("#page_num").val();
    var exp = document.getElementById("txtsearch").value;
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;

    var this_subject_id = $("#this_subject_id").val();
    var this_category_id = $("#this_category_id").val();
    var this_post_id = $("#this_post_id").val();
    
    $("#results").load(
      HOST_NAME + "group_admin/comments/",
      {
        page: page,
        order: order,
        perpage: perpage,
        s_id: this_subject_id,
        c_id: this_category_id,
        p_id: this_post_id,
        exp: exp,
        _csrf: $("#_csrf").val(),
        cmd: $('#listing_code').val(),
      },
      function () {
        //get content from PHP page
        $("#page_num").val(page);
        UnLoadElement("#divResults");
      }
    );
    
  }
 
};


function deleteData(id) {
  var subject_id = $("#this_subject_id").val();
  var check = $('#delete_code').val();
  var checkInputs = true;
  var _csrf = $("#_csrf").val();
  if (checkInputs == true) {
    Swal.fire({
      title: "آیا از حذف این گزینه اطمینان دارید؟",
      text: "امکان برگشت این رکود وجود ندارد!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "بله",
      cancelButtonText: "خیر",
    }).then((result) => {
      if (result.isConfirmed) {
        LoadElement("#results");

        $.ajax({
          url: HOST_NAME + "group_admin/comments/",
          type: "POST",
          data: {
            obj: id,
            s_id: subject_id,
            _csrf: _csrf,
            check: check,
          },
          dataType: "json",
          success: function (data) {
            UnLoadElement("#results");
            if (data.result == "1") {
              // window.location.reload();
              toastr["success"]("اطلاعات با موفقیت حذف شد");
              location.reload();
            }
          },
          error: function (xhr, textStatus, errorThrown) {
            toastr["error"]("خطا در انجام عملیات");
            UnLoadElement("#results");
          },
        });
      }
    });
  }
}

function checkedAll() {
  var inputs = document.querySelectorAll("input[type='checkbox']");
  if (document.getElementById("selectall").checked) {
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].checked = true;
    }
  } else {
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].checked = false;
    }
  }
}

function checkElement() {
  var inputs = document.querySelectorAll("input[type='checkbox']");
  var count = 0;
  for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].checked == true) count++;
  }
  if (count == 0) {
    alert("پستی برای حذف انتخاب نشده است");
    return false;
  }
  return true;
}

function activate(id) {
  var _html =
    '<img  src="' +
    HOST_NAME +
    'resources/shared/images/loading-spinner-blue.gif" />';
  var subject_id = $("#this_subject_id").val();

  var _csrf = $("#_csrf").val();
  $("#status_" + id).html(_html);
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/comments/",
    data:
      "s_id=" +
      subject_id +
      "&obj=" +
      id +
      "&_csrf=" +
      _csrf +
      "&check=" + $('#activate_code').val(),
    dataType: "json",
    cache: false,
    success: function (result) {
      if (result.state == "1") {
        var _html =
          '<span   onClick="deactivate(' +
          id +
          ');" ><i class="fa  fa-toggle-on active-toggle"></i></span>';
        $("#status_" + id).html(_html);
      }
    },
  });
}

function deactivate(id) {
  var _html =
    '<img  src="' +
    HOST_NAME +
    'resources/shared/images/loading-spinner-blue.gif" />';
  var subject_id = $("#this_subject_id").val();
  var _csrf = $("#_csrf").val();
  $("#status_" + id).html(_html);
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/comments/",
    data:
      "s_id=" +
      subject_id +
      "&obj=" +
      id +
      "&_csrf=" +
      _csrf +
      "&check=" + $('#deactivate_code').val(),
    dataType: "json",
    cache: false,
    success: function (result) {
      if (result.state == "1") {
        var _html =
          '<span   onClick="activate(' +
          id +
          ');" ><i class="fa  fa-toggle-off deactive-toggle"></i></span>';
        $("#status_" + id).html(_html);
      }
    },
  });
}

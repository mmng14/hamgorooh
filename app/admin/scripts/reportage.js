$(document).ready(function () {
  $("#menu_reportage").addClass("active");
});

window.onload = function () {
  
  $(".loading-div").show();

  $("#results").load(
    HOST_NAME + "admin/reportage/", // url
    { cmd: $('#listing_code').val(), _csrf: $("#_csrf").val() }, // data
    function (data, status, jqXGR) {
      // callback function
      $(".loading-div").hide();
    }
  );

  //executes code below when user click on pagination links
  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    $(".loading-div").show(); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    $("#txtpagenumber").val(page);
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;
    $("#results").load(
      HOST_NAME + "admin/reportage/",
      {
        page: page,
        order: order,
        perpage: perpage,
        _csrf: $("#_csrf").val(),
        cmd: $('#listing_code').val(),
      },
      function () {
        //get content from PHP page
        $(".loading-div").hide(); //once done, hide loading element
      }
    );
  });
};

function loadData() {
  var order = document.getElementById("cmbsort").value;
  var perpage = document.getElementById("cmbnumberPage").value;
  var page = document.getElementById("page_num").value;
  $("#results").load(
    HOST_NAME + "admin/reportage/",
    {
      _csrf: $("#_csrf").val(),
      page: page,
      order: order,
      perpage: perpage,
      cmd: $('#listing_code').val(),
    },
    function () {
      $(".loading-div").hide(); //once done, hide loading element
    }
  );
}



function deleteData(id) {
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
          url: HOST_NAME + "admin/reportage/",
          type: "POST",
          data: {
            obj: id,
            _csrf: _csrf,
            check: check,
          },
          dataType: "json",
          success: function (data) {
            UnLoadElement("#results");
            if (data.result == "1") {
              // window.location.reload();
              toastr["success"]("اطلاعات با موفقیت حذف شد");
              loadData();
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

function sendToSubjects(id) {
  LoadElement("#results");
  var _csrf = $("#_csrf").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/reportage/",
    data: "obj=" + id + "&check=" + $('#send_to_subjects_code').val() + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      UnLoadElement("#results");
      if (result.status === "1") {
        console.log(result);
      } else {
        console.log("Failed");
      }
    },
  });
}

function activate(id) {
  var _html =
    '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/reportage/",
    data: "obj=" + id + "&check=" + $('#activate_code').val() + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      if (result.state == "1") {
        var _html =
          '<span  onClick="deactivate(' +
          id +
          ');" ><i class="fa  fa-toggle-on active-toggle"></i></span>';
        $("#status_" + id).html(_html);
      }
    },
  });
}

function deactivate(id) {
  var _html =
    '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/reportage/",
    data: "obj=" + id + "&check=" + $('#deactivate_code').val() + "&_csrf=" + _csrf,
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

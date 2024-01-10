$(document).ready(function () {
    $('#menu_notifications').addClass('active');

});

window.onload = function () {


    $("#loader").show();
    console.log(HOST_NAME);
    $("#results").load(HOST_NAME + "users/notifications/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "users/notifications/", {
            "page": page,
            "order": order,
            "perpage": perpage,
            "_csrf": $("#_csrf").val(),
            "cmd": $("#listing_code").val()//LISTING_CODE
        },
            function () { //get content from PHP page
                $(".loading-div").hide(); //once done, hide loading element
            });
    });
};

function loadData() {
    var order = document.getElementById('cmbsort').value;
    var perpage = document.getElementById('cmbnumberPage').value;
    var page = document.getElementById('page_num').value;
    $("#results").load(HOST_NAME + "users/notifications/", {
        "_csrf": $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
        "cmd": $("#listing_code").val()//LISTING_CODE
    }, function () {
        $(".loading-div").hide(); //once done, hide loading element
    });
}

function deleteData(id) {

    var check =$("#delete_code").val();//DELETE_CODE ;
    var checkInputs = true;
  
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
          //LoadElement("#results");
          $('.loading-div').show();
          $.ajax({
            url: HOST_NAME + "users/notifications/",
            type: "POST",
            data: {
              obj: id,
              check: check,
              _csrf: $("#_csrf").val(),
            },
            dataType: "json",
            success: function (data) {
              UnLoadElement("#results");
              $('.loading-div').hide();
              if (data.result == "1") {
                // window.location.reload();
                toastr["success"]("اطلاعات با موفقیت حذف شد");
                location.reload();
                //loadData();
              }
            },
            error: function (xhr, textStatus, errorThrown) {
              toastr["error"]("خطا در انجام عملیات");
              //UnLoadElement("#results");
              $('.loading-div').hide();
            },
          });
        }
      });
    }
}

function setData(id) {
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "users/notifications/",
        data: "obj=" + id + "&check=" + $("#edit_code").val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {

            document.getElementById('hashId').value = id;

            // document.getElementById('subjectId').value = result.subject_id;
            // document.getElementById('title').value = result.title;
            // document.getElementById('adsType').value = result.type;
            // document.getElementById('startDate').value = result.start;
            // document.getElementById('endDate').value = result.end;
            // document.getElementById('link').value = result.linkname;
            // document.getElementById('price').value = result.price;
            // document.getElementById('active_days').value = result.active_days;
            // document.getElementById('description').value = result.desc;
     
        }
    });
}


$(document).ready(function () {
    $('#menu_monthly_visits').addClass('active');


    $("#this_subject_id").change(function(e){
        e.preventDefault();
        console.log('changed');
        return false;
      });

      $("#calcYear").change(function(e){
        e.preventDefault();
        console.log('changed');
        return false;
      });

      $("#calcMonth").change(function(e){
        e.preventDefault();
        console.log('changed');
        return false;
      });

    registerFormValidation = $("#frmMonthlyVisit").validate({
        rules: {

            this_subject_id: {
                required: true, noHtmlTag: true, maxlength: 200,
            },
            calcYear: {
                required: true, noHtmlTag: true, maxlength: 200,
            },
            calcMonth: {
                required: true, noHtmlTag: true, maxlength: 200,
            },

        },
        submitHandler: function () {

            sendingData();
        }
    });



});

window.onload = function () {


    $("#loader").show();
    console.log(HOST_NAME);
    var subject = $('#this_subject_id').val();
    var calcYear = $('#calcYear').val();
    var calcMonth = $('#calcMonth').val();
    $("#results").load(HOST_NAME + "admin/monthly_visit/", 
      { "cmd": $('#listing_code').val(), 
      "_csrf": $("#_csrf").val(),
      "subject_id": subject ,
      "cal_year": calcYear ,
      "cal_month": calcMonth , 
    }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var subject = $('#this_subject_id').val();
        var calcYear = $('#calcYear').val();
        var calcMonth = $('#calcMonth').val();
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/monthly_visit/", {
            "page": page,
            "order": order,
            "perpage": perpage,
            "_csrf": $("#_csrf").val(),
            "subject":subject,
            "cal_year": calcYear ,
            "cal_month": calcMonth , 
            "cmd": $('#listing_code').val()
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
    var subject = $('#this_subject_id').val();
    var calcYear = $('#calcYear').val();
    var calcMonth = $('#calcMonth').val();

    $("#results").load(HOST_NAME + "admin/monthly_visit/", {
        "_csrf": $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
        "subject":subject,
        "cal_year": calcYear ,
        "cal_month": calcMonth , 
        "cmd": $('#listing_code').val()
    }, function () {
        $(".loading-div").hide(); //once done, hide loading element
    });
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
            url: HOST_NAME + "admin/monthly_visit/",
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


function checkElement() {
    if (document.getElementById("txtname").value == "") {
        alert(" پر کردن نام تصویر الزامی است");
        return false;
    }
    return true;
}

function clearData() {

    document.getElementById('this_subject_id').value = "";
    document.getElementById('calcYear').value = "";
    document.getElementById('calcMonth').value = "";

}

function activate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/monthly_visit/",
        data: "obj=" + id + "&check=" + $('#activate_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                //var _html = "<span  class=\"btn btn-success btn-sm\" onClick=\"deactivate(" + id + ");\" ><i class=\"fa  fa-toggle-on\"></i></span>";
                var _html = "<span   onClick=\"deactivate(" + id + ");\" ><i class=\"fa  fa-toggle-on active-toggle\"></i></span>";
                $('#status_' + id).html(_html);
            }

        }
    });
}

function deactivate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/monthly_visit/",
        data: "obj=" + id + "&check=" + $('#deactivate_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                //var _html = "<span  class=\"btn btn-danger btn-sm\" onClick=\"activate(" + id + ");\" ><i class=\"fa fa-toggle-off\"></i></span>";
                var _html = "<span   onClick=\"activate(" + id + ");\" ><i class=\"fa  fa-toggle-off deactive-toggle\"></i></span>";
                $('#status_' + id).html(_html);
            }

        }
    });
}

function sendingData() {
    let validate = true; //secondValidation();
    if (validate) {

        var _csrf = $("#_csrf").val();
        var page_num = $("#page_num").val();
        var subjectId = $("#this_subject_id").val();
        var calcYear = $("#calcYear").val();
        var calcMonth = $("#calcMonth").val();
        var check = $('#insert_code').val(); //Add
        
        LoadElement(".modal-dialog");

        $.ajax({

            url: HOST_NAME + "admin/monthly_visit/",
            type : 'POST',
            data : {
                '_csrf' : _csrf,
                'subjectId' :subjectId,
                'calcYear' : calcYear,
                'calcMonth' : calcMonth,
                'check' : check,
            },
            dataType:'json',
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status === "1") {
                    toastr["success"](response.message);
                    console.log(response);
                    loadData();
                } else {
                    toastr["error"](response.message);
                }
            },
            error: function (error) {
                UnLoadElement(".modal-dialog");
                toastr["error"]("خطا در ارسال اطلاعات");
            }
        });

    }
}


function clearForm() {


    document.getElementById('this_subject_id').value = "";
    document.getElementById('calcYear').value = "";
    document.getElementById('calcMonth').value = "";




}
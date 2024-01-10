$(document).ready(function () {
    $('#menu_users').addClass('active');



    $(document.body).on('change', 'select[name^="type_"]', function () {
        let role = $(this).val();
        let uId = $(this).data('user');

        setUserType(role, uId);
    })

  

    registerFormValidation = $("#frmUserSubjects").validate({
        rules: {
            subject: {
                required: true, noHtmlTag: true, maxlength: 100,
            },

            role: {
                required: true, noHtmlTag: true, maxlength: 100,
            },
            rights: {
                required: true, noHtmlTag: true,maxlength: 100,
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
    
    $("#results").load(HOST_NAME + "admin/user_subjects/", { "cmd": $('#listing_code').val(),"uid":$('#this_user_id').val() ,"_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        var uid = $('#this_user_id').val();
        $("#results").load(HOST_NAME + "admin/user_subjects/", {
            "page": page,
            "order": order,
            "perpage": perpage,
            "uid":uid,
            "_csrf": $("#_csrf").val(),
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
    var uid = $('#this_user_id').val();
    $("#results").load(HOST_NAME + "admin/user_subjects/", {
        "_csrf": $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
        "uid":uid,
        "cmd": $('#listing_code').val()
    }, function () {
        $(".loading-div").hide(); //once done, hide loading element
    });
}

function set_subject_name() {
    var subject_name = $('#subject').find(':selected').data('name');
    $('#subject_name').val(subject_name);
    console.log(subject_name);
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
            url: HOST_NAME + "admin/user_subjects/",
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

function setData(id) {
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/user_subjects/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {

            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;
            document.getElementById('subject').value=result.subject;
            document.getElementById('subject_name').value = result.subject_name;
            document.getElementById('role').value=result.role;
            document.getElementById('rights').value=result.user_rights;


            if (result.status == 1)
                document.getElementById('status').checked = true;
            else
                document.getElementById('status').checked = false;
        }
    });
}

function activate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/user_subjects/",
        data: "obj=" + id + "&check=" + $('#activate_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
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
        url: HOST_NAME + "admin/user_subjects/",
        data: "obj=" + id + "&check=" + $('#deactivate_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                var _html = "<span   onClick=\"activate(" + id + ");\" ><i class=\"fa  fa-toggle-off deactive-toggle\"></i></span>";
                $('#status_' + id).html(_html);
            }

        }
    });
}

function clearData() {

    $('#save').name = "add";
    $('#save').val("افزودن");
    $('#hashId').val("");

    document.getElementById('subject').value="";
    document.getElementById('subject_name').value="";
    document.getElementById('role').value="";
    document.getElementById('rights').value="";

    $('#status').prop('checked', false);

}

function sendingData() {
    let validate = true; //secondValidation();
    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["hashId"] = $("#hashId").val();
        data["page_num"] = $("#page_num").val();

        data["user_id"] = $('#this_user_id').val();
        data["subject"] = $("#subject").val();
        data["subject_name"] = $("#subject_name").val();
        data["role"] = $("#role").val();
        data["rights"] = $("#rights").val();
        data["status"] = $('#status').val();


        if (data["hashId"] != undefined && data["hashId"] != null && data["hashId"] != "") {
            data["check"] = $('#update_code').val(); //update
        } else {
            data["check"] = $('#insert_code').val(); //add
        }



        let formData = new FormData();
        formData.append("_csrf", data["_csrf"]);
        formData.append("hashId", data["hashId"]);
        formData.append("page_num", data["page_num"]);


        formData.append("user_id", data["user_id"]);
        formData.append("subject", data["subject"]);
        formData.append("subject_name", data["subject_name"]);
        formData.append("role", data["role"]);
        formData.append("rights", data["rights"]);

        formData.append("status", data["status"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/user_subjects/",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status === "1") {
                    
                    clearData();
                    loadData();
                    toastr["success"](response.message);
                    console.log(response);
                    // window.location.replace(response.redirect);
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

    $('#save').name = "add";
    $('#save').val("افزودن");
    $('#hashId').val("");

    document.getElementById('subject').value="";
    document.getElementById('subject_name').value="";
    document.getElementById('role').value="";
    document.getElementById('rights').value="";

    $('#status').prop('checked', false);

}
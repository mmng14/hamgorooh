$(document).ready(function () {
    $('#menu_subjects').addClass('active');

    $("#upload").change(function () {
        LoadElement("#imageSelectBox");
        readURL(this);
    });

    registerFormValidation = $("#frmCategory").validate({
        rules: {
            name: {
                required: true, noHtmlTag: true, maxlength: 200,
            },

            description: {
                required: true, noHtmlTag: true, maxlength: 500,
            },
            ordering: {
                required: true, noHtmlTag: true, 
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
    $("#results").load(HOST_NAME + "admin/subject_category/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val(),"subject": subject  }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var subject = $('#this_subject_id').val();
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/subject_category/", {
            "page": page,
            "order": order,
            "perpage": perpage,
            "_csrf": $("#_csrf").val(),
            "subject":subject,
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
    $("#results").load(HOST_NAME + "admin/subject_category/", {
        "_csrf": $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
        "subject":subject,
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
            url: HOST_NAME + "admin/subject_category/",
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

function sendToSubjects(id){

    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subject_category/",
        data: "obj=" + id + "&check=" + $('#send_to_subjects_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement("#results");
            if(result.status==="1")
            {
                console.log(result);
            }
            else
            {
                console.log("Failed");
            }

        }
    });

}

function deleteToSubjects(id){

    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subject_category/",
        data: "obj=" + id +   "&check=" + $('#delete_to_subjects_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement("#results");
            if(result.status==="1")
            {
                console.log(result);
            }
            else
            {
                console.log("Failed");
            }

        }
    });

}

function setData(id) {
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subject_category/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;
            document.getElementById('name').value = result.name;
            document.getElementById('category_type').value = result.category_type;    
            document.getElementById('description').value = result.desc;
            document.getElementById('ordering').value = result.ordering;
            document.getElementById('photo_address').value = result.photo;
            $('#uploadImage').attr('src', HOST_NAME + result.photo);

            if (result.is_custom == 1)
                document.getElementById('custom').checked = true;
            else
                document.getElementById('custom').checked = false;

            if (result.status == 1)
                document.getElementById('status').checked = true;
            else
                document.getElementById('status').checked = false;
        }
    });
}

function checkElement() {
    if (document.getElementById("txtname").value == "") {
        alert(" پر کردن نام تصویر الزامی است");
        return false;
    }
    return true;
}

function clearData() {

    $('#save').name = "add";
    $('#save').val("افزودن");
    $('#hashId').val("");

    $('#form_title').html('فرم افزودن پست');
    $('#hashId').val('');

    document.getElementById('name').value = "";
    document.getElementById('data_name').value = "";
    document.getElementById('description').value = "";
    document.getElementById('category_type').value = "";
    document.getElementById('ordering').value = "";

    $('#custom').prop('checked', false);
    $('#status').prop('checked', false);

    $('#uploadImage').attr('src', '');
    $('#photo_address').val('');
}

function activate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subject_category/",
        data: "obj=" + id + "&check=" + $('#activate_code').val() + "&_csrf=" + _csrf,
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
        url: HOST_NAME + "admin/subject_category/",
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

function customize(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#custom_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subject_category/",
        data: "obj=" + id + "&check=" + $('#customize_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                var _html = "<span   onClick=\"uncustomize(" + id + ");\" ><i class=\"fa  fa-toggle-on active-toggle\"></i></span>";
                $('#custom_' + id).html(_html);
            }

        }
    });
}

function uncustomize(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#custom_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subject_category/",
        data: "obj=" + id + "&check="  + $('#uncustomize_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                var _html = "<span   onClick=\"customize(" + id + ");\" ><i class=\"fa  fa-toggle-off deactive-toggle\"></i></span>";
                $('#custom_' + id).html(_html);
            }

        }
    });
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#uploadImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        UnLoadElement("#imageSelectBox");
    }
}

function sendingData() {
    let validate = true; //secondValidation();
    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["hashId"] = $("#hashId").val();
        data["page_num"] = $("#page_num").val();

        data["subject_id"] = $("#subject_id").val();
        data["name"] = $("#name").val();
        data["category_type"] = $("#category_type").val();
        data["data_name"] = $("#data_name").val();
        data["description"] = $("#description").val();

        data["ordering"] = $("#ordering").val();
        data["photo"] = $("#photo_address").val();
        data["custom"] = $('#custom').val();
        data["status"] = $('#status').val();
      

        if (data["hashId"] != undefined && data["hashId"] != null && data["hashId"] != "") {
            data["check"] = $('#update_code').val(); //update
        } else {
            data["check"] = $('#insert_code').val(); //add
        }

        let file = document.getElementById("upload").files[0];

        let formData = new FormData();
        formData.append("upload", file);
        formData.append("_csrf", data["_csrf"]);
        formData.append("hashId", data["hashId"]);
        formData.append("page_num", data["page_num"]);

        formData.append("subject_id", data["subject_id"]);
        formData.append("name", data["name"]);
        formData.append("data_name", data["data_name"]);
        formData.append("category_type", data["category_type"]);
        formData.append("description", data["description"]);

        formData.append("photo", data["photo"]);
        formData.append("custom", data["custom"]);
        formData.append("status", data["status"]);
        formData.append("ordering", data["ordering"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/subject_category/",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status === "1") {
                    toastr["success"](response.message);
                    console.log(response);
                    clearData();
                    loadData();
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
    $('#form_title').html('فرم افزودن ');
    $('#hashId').val('');

    document.getElementById('name').value = "";
    document.getElementById('data_name').value = "";
    document.getElementById('description').value = "";
    document.getElementById('category_type').value = "";
    document.getElementById('ordering').value = "";

    $('#custom').prop('checked', false);
    $('#status').prop('checked', false);

    $('#uploadImage').attr('src', '');
    $('#photo_address').val('');
}
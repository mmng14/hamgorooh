$(document).ready(function () {
    $('#menu_subjects').addClass('active');

    $("#upload").change(function () {
        LoadElement("#imageSelectBox");
        readURL(this);
    });

    registerFormValidation = $("#formSubjects").validate({
        rules: {
            name: {
                required: true, noHtmlTag: true, maxlength: 200,
            },

            description: {
                required: true, noHtmlTag: true, maxlength: 500,
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
    $("#results").load(HOST_NAME + "admin/subjects/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/subjects/", {
            "page": page,
            "order": order,
            "perpage": perpage,
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
    $("#results").load(HOST_NAME + "admin/subjects/", {
        "_csrf": $("#_csrf").val(),
        "page": page,
        "order": order,
        "perpage": perpage,
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
            url: HOST_NAME + "admin/subjects/",
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
        url: HOST_NAME + "admin/subjects/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;
            document.getElementById('name').value = result.name;
            document.getElementById('data_name').value = result.data_name;
            document.getElementById('db_server').value = result.db_server;
            document.getElementById('db_name').value = result.db_name;
            document.getElementById('db_user').value = result.db_user;
            document.getElementById('db_pass').value = result.db_pass;
            document.getElementById('description').value = result.desc;
            // document.getElementById('telegram_token').value = result.telegram_token;
            // document.getElementById('telegram_id').value = result.telegram_id;
            // document.getElementById('telegram_link').value = result.telegram_link;
            document.getElementById('ordering').value = result.ordering;
            document.getElementById('photo_address').value = result.photo;
            $('#uploadImage').attr('src', HOST_NAME + result.photo);

            if (result.top_menu == 1)
                document.getElementById('top_menu').checked = true;
            else
                document.getElementById('top_menu').checked = false;

            if (result.has_resource == 1)
                document.getElementById('has_resource').checked = true;
            else
                document.getElementById('has_resource').checked = false;

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

    document.getElementById('name').value = "";
    document.getElementById('data_name').value = "";
    document.getElementById('db_server').value = "";
    document.getElementById('db_name').value = "";
    document.getElementById('db_user').value = "";
    document.getElementById('db_pass').value = "";
    document.getElementById('description').value = "";
    // document.getElementById('telegram_token').value = "";
    // document.getElementById('telegram_id').value = "";
    // document.getElementById('telegram_link').value = "";
    document.getElementById('ordering').value = "";

    $('#chktopmenu').prop('checked', false);
    $('#has_resource').prop('checked', false);
    $('#status').prop('checked', false);

    $('#uploadImage').attr('src', '');
    $('#photo_address').val('');
}

function activate(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#status_' + id).html(_html);
    LoadElement('#status_' + id);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subjects/",
        data: "obj=" + id + "&check=" + $('#activate_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement('#status_' + id);
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
        url: HOST_NAME + "admin/subjects/",
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

function activateTopMenu(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#topmenu_' + id).html(_html);
    LoadElement('#topmenu_' + id);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subjects/",
        data: "obj=" + id + "&check=" + $('#activate_topmenu_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement('#topmenu_' + id);
            if (result.state == '1') {
                var _html = "<span   onClick=\"deactivateTopMenu(" + id + ");\" ><i class=\"fa  fa-toggle-on active-toggle\"></i></span>";
                $('#topmenu_' + id).html(_html);
            }

        }
    });
}

function deactivateTopMenu(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#topmenu_' + id).html(_html);
    LoadElement('#topmenu_' + id);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subjects/",
        data: "obj=" + id + "&check=" + $('#deactivate_topmenu_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement('#topmenu_' + id);
            if (result.state == '1') {
                var _html = "<span   onClick=\"activateTopMenu(" + id + ");\" ><i class=\"fa  fa-toggle-off deactive-toggle\"></i></span>";
                $('#topmenu_' + id).html(_html);
            }

        }
    });
}

function activateHasResource(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#has_resource_' + id).html(_html);
    LoadElement('#has_resource_' + id);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subjects/",
        data: "obj=" + id + "&check=" + $('#activate_hasresource_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement('#has_resource_' + id);
            if (result.state == '1') {
                var _html = "<span   onClick=\"deactivateHasResource(" + id + ");\" ><i class=\"fa  fa-toggle-on active-toggle\"></i></span>";
                $('#has_resource_' + id).html(_html);
            }

        }
    });
}

function deactivateHasResource(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#has_resource_' + id).html(_html);
    LoadElement('#has_resource_' + id);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/subjects/",
        data: "obj=" + id + "&check=" + $('#deactivate_hasresource_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement('#has_resource_' + id);
            if (result.state == '1') {
                var _html = "<span   onClick=\"activateHasResource(" + id + ");\" ><i class=\"fa  fa-toggle-off deactive-toggle\"></i></span>";
                $('#has_resource_' + id).html(_html);
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

        data["name"] = $("#name").val();
        data["data_name"] = $("#data_name").val();
        data["db_server"] = $("#db_server").val();
        data["db_name"] = $("#db_name").val();
        data["db_user"] = $("#db_user").val();
        data["db_pass"] = $("#db_pass").val();
        data["description"] = $("#description").val();
        // data["telegram_token"] = $("#telegram_token").val();
        // data["telegram_id"] = $("#telegram_id").val();
        // data["telegram_link"] = $("#telegram_link").val();

        data["ordering"] = $("#ordering").val();
        data["photo"] = $("#photo_address").val();
        data["top_menu"] = $('#top_menu').val();
        data["has_resource"] = $('#has_resource').val();
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


        formData.append("name", data["name"]);
        formData.append("data_name", data["data_name"]);
        formData.append("db_server", data["db_server"]);
        formData.append("db_name", data["db_name"]);
        formData.append("db_user", data["db_user"]);
        formData.append("db_pass", data["db_pass"]);
        formData.append("description", data["description"]);
        // formData.append("telegram_token", data["telegram_token"]);
        // formData.append("telegram_id", data["telegram_id"]);
        // formData.append("telegram_link", data["telegram_link"]);

        formData.append("photo", data["photo"]);
        formData.append("top_menu", data["top_menu"]);
        formData.append("has_resource", data["has_resource"]);
        formData.append("status", data["status"]);
        formData.append("ordering", data["ordering"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/subjects/",
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

    $('#add_update').name = "add";
    $('#form_title').html('فرم افزودن پست');
    $('#hashId').val('');

    document.getElementById('name').value = "";
    document.getElementById('data_name').value = "";
    document.getElementById('db_server').value = "";
    document.getElementById('db_name').value = "";
    document.getElementById('db_user').value = "";
    document.getElementById('db_pass').value = "";
    document.getElementById('description').value = "";
    // document.getElementById('telegram_token').value = "";
    // document.getElementById('telegram_id').value = "";
    // document.getElementById('telegram_link').value = "";
    document.getElementById('ordering').value = "";

    $('#chktopmenu').prop('checked', false);
    $('#has_resource').prop('checked', false);
    $('#status').prop('checked', false);
}
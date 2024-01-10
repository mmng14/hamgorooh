$(document).ready(function () {
    $('#menu_users').addClass('active');

    $("#upload").change(function () {
        LoadElement("#imageSelectBox");
        readURL(this);
    });


    $(document.body).on('change', 'select[name^="type_"]', function () {
        let role = $(this).val();
        let uId = $(this).data('user');

        setUserType(role, uId);
    })

    $(".date-picker").persianDatepicker();

    registerFormValidation = $("#frmUsers").validate({
        rules: {
            fname: {
                required: true, noHtmlTag: true, maxlength: 100,
            },

            lname: {
                required: true, noHtmlTag: true, maxlength: 100,
            },
            gender: {
                required: true, noHtmlTag: true,
            },
            type: {
                required: true, noHtmlTag: true,
            },
        },
        submitHandler: function () {
            sendingData();
        }
    });

    registerFormValidation = $("#frmChangePass").validate({
        rules: {
            pass: {
                required: true, noHtmlTag: true, maxlength: 100,
            },

            rePass: {
                required: true, noHtmlTag: true, maxlength: 100,
            },

        },
        submitHandler: function () {
            if (checkPassChangeValidation()) {
                sendingChangePassData();
            }
        }
    });


});

window.onload = function () {


    $("#loader").show();
    console.log(HOST_NAME);
    $("#results").load(HOST_NAME + "admin/users/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/users/", {
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
    $("#results").load(HOST_NAME + "admin/users/", {
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
            url: HOST_NAME + "admin/users/",
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
        url: HOST_NAME + "admin/users/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;
            document.getElementById('fname').value = result.fname;
            document.getElementById('lname').value = result.lname;
            document.getElementById('email').value = result.email;
            document.getElementById('user').value = result.user_name;
            document.getElementById('tell').value = result.phone;
            document.getElementById('gender').value = result.gender;
            document.getElementById('type').value = result.type;
            document.getElementById('birthDate').value = result.birth_date;
            document.getElementById('address').value = result.address;

            document.getElementById('photo_address').value = result.photo;
            $('#uploadImage').attr('src', HOST_NAME + result.photo);


            if (result.status == 1)
                document.getElementById('status').checked = true;
            else
                document.getElementById('status').checked = false;
        }
    });
}

function setUserType(role,uId) {
    LoadElement('#results');
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/users/",
        data: "userId=" + uId + "&role=" + role + "&check=" + $('#set_user_type_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            console.log(result);
            UnLoadElement('#results');
            if (result.status == '1') {
                toastr["success"](result.message);
            }
            else {
                toastr["error"](result.message);
            }
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

    document.getElementById('fname').value = "";
    document.getElementById('lname').value = "";
    document.getElementById('email').value = "";
    document.getElementById('user').value = "";
    document.getElementById('tell').value = "";
    document.getElementById('birthDate').value = "";
    document.getElementById('gender').value = "";
    document.getElementById('mobile').value = "";
    document.getElementById('address').value = "";
    document.getElementById('type').value="";

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
        url: HOST_NAME + "admin/users/",
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
        url: HOST_NAME + "admin/users/",
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

function setPassData(id) {
    document.getElementById('userId').value = id;
}

function checkPassChangeValidation() {
    if (document.getElementById("pass").value == "") {
        toastr["error"](" رمز عبور را وارد کنید");
        return false;
    }

    if (document.getElementById("rePass").value == "") {
        toastr["error"](" تکرار رمز عبور را وارد کنید ");
        return false;
    }
    if (document.getElementById("pass").value != document.getElementById("rePass").value) {
        toastr["error"](" رمز عبور با تکرار آن برابر نیست ");
        return false;
    }

    return true;
}

function sendingChangePassData() {
    let validate = true; //secondValidation();
    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["userId"] = $("#userId").val();
        data["pass"] = $("#pass").val();
        data["rePass"] = $("#rePass").val();
        data["check"] = $('#password_change_code').val(); //change pass

        let formData = new FormData();

        formData.append("_csrf", data["_csrf"]);
        formData.append("userId", data["userId"]);
        formData.append("pass", data["pass"]);
        formData.append("rePass", data["rePass"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/users/",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status === "1") {
                    toastr["success"](response.message);
                    console.log(response);
                    clearPassFormData();
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


        data["fname"] = $("#fname").val();
        data["lname"] = $("#lname").val();
        data["email"] = $("#email").val();
        data["user"] = $("#user").val();
        data["tell"] = $("#tell").val();
        data["birthDate"] = $("#birthDate").val();
        data["gender"] = $("#gender").val();
        data["mobile"] = $("#mobile").val();
        data["address"] = $("#address").val();
        data["type"] = $("#type").val();

        data["photo"] = $("#photo_address").val();
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


        formData.append("fname", data["fname"]);
        formData.append("lname", data["lname"]);
        formData.append("email", data["email"]);
        formData.append("user", data["user"]);
        formData.append("tell", data["tell"]);
        formData.append("birthDate", data["birthDate"]);
        formData.append("gender", data["gender"]);
        formData.append("mobile", data["mobile"]);
        formData.append("address", data["address"]);
        formData.append("type", data["type"]);

        formData.append("photo", data["photo"]);
        formData.append("status", data["status"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/users/",
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

function clearPassFormData(){
    document.getElementById('userId').value = "";
    document.getElementById('pass').value = "";
    document.getElementById('rePass').value = "";
}

function clearForm() {

    $('#save').name = "add";
    $('#save').val("افزودن");
    $('#hashId').val("");

    document.getElementById('fname').value = "";
    document.getElementById('lname').value = "";
    document.getElementById('email').value = "";
    document.getElementById('user').value = "";
    document.getElementById('tell').value = "";
    document.getElementById('birthDate').value = "";
    document.getElementById('gender').value = "";
    document.getElementById('mobile').value = "";
    document.getElementById('address').value = "";
    document.getElementById('type').value="";

    $('#status').prop('checked', false);

    $('#uploadImage').attr('src', '');
    $('#photo_address').val('');
}
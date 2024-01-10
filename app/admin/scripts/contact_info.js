$(document).ready(function () {
    $('#menu_contact_info').addClass('active');

    registerFormValidation = $("#frmContactInfo").validate({
        rules: {
            address: {
                required: true, noHtmlTag: true, maxlength: 300,
            },

            telephones: {
                required: true, noHtmlTag: true, maxlength: 500,
            },
            email: {
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
    $("#results").load(HOST_NAME + "admin/contact_info/", {"cmd": $('#listing_code').val(),"_csrf" : $("#_csrf").val()}); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/contact_info/", {
                "page": page,
                "order": order,
                "perpage": perpage,
                "_csrf" : $("#_csrf").val(),
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
    $("#results").load(HOST_NAME + "admin/contact_info/", {
        "_csrf" : $("#_csrf").val(),
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
            url: HOST_NAME + "admin/contact_info/",
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
        url: HOST_NAME + "admin/contact_info/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;
            document.getElementById('country').value = result.country;
            document.getElementById('address').value = result.address;
            document.getElementById('latitude').value = result.latitude;
            document.getElementById('longitude').value = result.longitude;
            document.getElementById('mobile').value = result.mobile;
            document.getElementById('telephones').value = result.telephones;
            document.getElementById('fax').value = result.fax;
            document.getElementById('email').value = result.email;
            document.getElementById('facebook').value = result.facebook;
            document.getElementById('twitter').value = result.twitter;
            document.getElementById('google_plus').value = result.google_plus;
            document.getElementById('instagram').value = result.instagram;
            document.getElementById('linkedin').value = result.linkedin;
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

    $('#save').val("افزودن");
    $('#form_title').html('فرم افزودن');
    $('#hashId').val('');
    $('#address').val('');
    $('#latitude').val('');
    $('#longitude').val('');
    $('#country').val('');
    $('#mobile').val('');
    $('#telephones').val('');
    $('#fax').val('');
    $('#email').val('');
    $('#facebook').val('');
    $('#twitter').val('');
    $('#google_plus').val('');
    $('#instagram').val('');
    $('#linkedin').val('');

    $('#status').prop('checked', false);
}

function activate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/contact_info/",
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
        url: HOST_NAME + "admin/contact_info/",
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

function secondValidation() {


    // var title = $('#title').val();
    // var keywords = $('#keywords').val();
    // var brief_desc = $('#brief_description').val();
    // var description = CKEDITOR.instances["description"].getData();


    // //Validation Check
    // let ret = true;
    // let messagesArr = [];

    // if (title === "") {
    //     messagesArr.push('عنوان وارد نشده است ');
    //     ret = false;
    // }

    // if (keywords === "") {
    //     messagesArr.push('کلمات کلیدی وارد نشده است ');
    //     ret = false;
    // }

    // if (brief_desc === "") {
    //     messagesArr.push('شرح مختصر وارد نشده است ');
    //     ret = false;
    // }

    // if (description === "") {
    //     messagesArr.push('شرح  وارد نشده است ');
    //     ret = false;
    // }

    // if (!ret) {

    //     // swal({
    //     //     title: "خطا",
    //     //     text: messagesArr.join('<br>'),
    //     //     html: true,
    //     //     confirmButtonColor: "#EF5350",
    //     //     type: "error"
    //     // });
    //     toastr["error"](messagesArr.join('<br>'));
    //     return false;
    // } else {
    //     return true;
    // }
}

function sendingData() {
    let validate = true; 
    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["hashId"] = $("#hashId").val();
        data["page_num"] = $("#page_num").val();
        data["country"] = $("#country").val();
        data["address"] = $("#address").val();
        data["latitude"] = $("#latitude").val();
        data["longitude"] = $("#longitude").val();
        data["mobile"] = $("#mobile").val();
        data["telephones"] = $("#telephones").val();
        data["fax"] = $("#fax").val();
        data["email"] = $("#email").val();
        data["facebook"] = $("#facebook").val();
        data["twitter"] = $("#twitter").val();
        data["google_plus"] = $("#google_plus").val();
        data["instagram"] = $("#instagram").val();
        data["linkedin"] = $("#linkedin").val();
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

        formData.append("country", data["country"]);
        formData.append("address", data["address"]);
        formData.append("latitude", data["latitude"]);
        formData.append("longitude", data["longitude"]);
        formData.append("mobile", data["mobile"]);
        formData.append("telephones", data["telephones"]);
        formData.append("fax", data["fax"]);
        formData.append("email", data["email"]);
        formData.append("facebook", data["facebook"]);
        formData.append("twitter", data["twitter"]);
        formData.append("google_plus", data["google_plus"]);
        formData.append("instagram", data["instagram"]);
        formData.append("linkedin", data["linkedin"]);
        formData.append("status", data["status"]);

        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/contact_info/",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status === "1") {
                    toastr["success"](response.message);
                    console.log(response);
                    clearForm();
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

    $('#save').val("افزودن");
    $('#form_title').html('فرم افزودن ');
    $('#hashId').val('');
    $('#address').val('');
    $('#latitude').val('');
    $('#longitude').val('');
    $('#country').val('');
    $('#mobile').val('');
    $('#telephones').val('');
    $('#fax').val('');
    $('#email').val('');
    $('#facebook').val('');
    $('#twitter').val('');
    $('#google_plus').val('');
    $('#instagram').val('');
    $('#linkedin').val('');

    $('#status').prop('checked', false);
}
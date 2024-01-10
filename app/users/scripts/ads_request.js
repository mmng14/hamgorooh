$(document).ready(function () {
    $('#menu_ads_request').addClass('active');

    $('#active_days').on('input', function() {
        console.log("active_days");
        getDateAndPrice();
    });

    $('#adsType').on('change', function() {
        console.log("adsType");
        getDateAndPrice();
    });

    $('#subjectId').on('change', function() {
        console.log("subjectId");
        getDateAndPrice();
    });

    $(".date-picker").persianDatepicker();

    $("#upload").change(function () {
        LoadElement("#imageSelectBox");
        readURL(this);
    });

    registerFormValidation = $("#formAds").validate({
        rules: {
            title: {
                required: true, noHtmlTag: true, maxlength: 300,
            },
            subjectId: {
                required: true, maxlength: 10, digitStr: true,
            },
            adsType: {
                required: true, maxlength: 1, digitStr: true,
            },
            startDate: {
                required: true, dateRange: true, noHtmlTag: true,
            },
            endDate: {
                required: true, dateRange: true, noHtmlTag: true,
            },
            link: {
                required: true, noHtmlTag: true, maxlength: 300,
            },
            price: {
                noHtmlTag: true, maxlength: 23, digitStr: true,
            },
            active_days: {
                required: true, noHtmlTag: true, maxlength: 23, digitStr: true,
            },
            description: {
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
    $("#results").load(HOST_NAME + "users/ads_request/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "users/ads_request/", {
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
    $("#results").load(HOST_NAME + "users/ads_request/", {
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
            url: HOST_NAME + "users/ads_request/",
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
        url: HOST_NAME + "users/ads_request/",
        data: "obj=" + id + "&check=" + $("#edit_code").val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;

            document.getElementById('subjectId').value = result.subject_id;
            document.getElementById('title').value = result.title;
            document.getElementById('adsType').value = result.type;
            document.getElementById('startDate').value = result.start;
            document.getElementById('endDate').value = result.end;
            document.getElementById('link').value = result.linkname;
            document.getElementById('price').value = result.price;
            document.getElementById('active_days').value = result.active_days;
            document.getElementById('description').value = result.desc;


            document.getElementById('photo_address').value = result.photo;
            $('#uploadImage').attr('src', HOST_NAME + result.photo);
     
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

    document.getElementById('subjectId').value = "";
    document.getElementById('title').value = "";
    document.getElementById('adsType').value = "";
    document.getElementById('startDate').value = "";
    document.getElementById('endDate').value = "";
    document.getElementById('link').value = "";
    document.getElementById('price').value = "";
    document.getElementById('active_days').value = "";
    document.getElementById('description').value = "";

    $('#uploadImage').attr('src', '');
    $('#photo_address').val('');
}

function readURL(input) {
    LoadElement("#imageSelectBox");
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

    var title = $('#title').val();
    var description = CKEDITOR.instances["description"].getData();

    //Validation Check
    let ret = true;
    let messagesArr = [];

    if (title === "") {
        messagesArr.push('عنوان وارد نشده است ');
        ret = false;
    }

    if (description === "") {
        messagesArr.push('شرح  وارد نشده است ');
        ret = false;
    }

    if (!ret) {

        toastr["error"](messagesArr.join('<br>'));
        return false;
    } else {
        return true;
    }
}

function sendingData() {
    let validate = true; //secondValidation();
    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["hashId"] = $("#hashId").val();
        data["page_num"] = $("#page_num").val();
        data["subjectId"] = $("#subjectId").val();
        data["title"] = $("#title").val();
        data["adsType"] = $("#adsType").val();
        data["startDate"] = $("#startDate").val();
        data["endDate"] = $("#endDate").val();
        data["link"] = $("#link").val();
        data["price"] = $("#price").val();
        data["description"] = $("#description").val();
        data["active_days"] = $("#active_days").val();
        data["photo"] = $("#photo_address").val();
        let UPDATE_CODE = $('#update_code').val();
        let INSERT_CODE = $('#insert_code').val();
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
        formData.append("subjectId", data["subjectId"]);
        formData.append("title", data["title"]);
        formData.append("adsType", data["adsType"]);
        formData.append("startDate", data["startDate"]);
        formData.append("endDate", data["endDate"]);
        formData.append("link", data["link"]);
        formData.append("price", data["price"]);
        formData.append("description", data["description"]);
        formData.append("photo", data["photo"]);
        formData.append("active_days", data["active_days"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "users/ads_request/",
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

function getDateAndPrice() {
    let validate = true;
    if ($("#adsType").val() == "" || $("#adsType").val() == "0" || $("#active_days").val() == ""|| $("#subjectId").val() == "") {
        validate = false;
    }

    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["subjectId"] = $("#subjectId").val();
        data["adsType"] = $("#adsType").val();
        data["active_days"] = $("#active_days").val();
        data["check"] = $('#get_date_and_price_code').val();// GET_DATE_AND_PRICE_CODE; //Get Date And Price

        let formData = new FormData();

        formData.append("_csrf", data["_csrf"]);
        formData.append("subjectId", data["subjectId"]);
        formData.append("adsType", data["adsType"]);
        formData.append("active_days", data["active_days"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "users/ads_request/",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status == "1") {

                    document.getElementById('startDate').value = response.start;
                    document.getElementById('endDate').value = response.end;
                    document.getElementById('price').value = response.price;

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
    $('#subjectId').val('');
    $('#title').val('');
    $('#briefDescription').val('');
    CKEDITOR.instances["description"].setData('');
    $('#active_days').val('');

}
$(document).ready(function () {
    $('#menu_reportage_request').addClass('active');


    $('#subjectId').on('change', function() {
        console.log("subjectId");
        getPrice();
    });

    $(".date-picker").persianDatepicker();

    $("#upload").change(function () {
        LoadElement("#imageSelectBox");
        readURL(this);
    });

    registerFormValidation = $("#formReportage").validate({
        rules: {

            subjectId: {
                required: true, maxlength: 10, digitStr: true
            },
            back_link_address: {
                required: true, noHtmlTag: true, maxlength: 300
            },
            back_link_name: {
                required: true, noHtmlTag: true, maxlength: 300
            },
            price: {
                noHtmlTag: true, maxlength: 23, digitStr: true
            },

            description: {
                required: true, noHtmlTag: true, maxlength: 500
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
    $("#results").load(HOST_NAME + "users/reportage_request/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "users/reportage_request/", {
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
    $("#results").load(HOST_NAME + "users/reportage_request/", {
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

    var check =$('#delete_code').val();// DELETE_CODE;
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
            url: HOST_NAME + "users/reportage_request/",
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
    let EDIT_CODE = $('#edit_code').val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "users/reportage_request/",
        data: "obj=" + id + "&check=" + EDIT_CODE + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            document.getElementById('save').name = "update";
            document.getElementById('save').value = "ویرایش";
            document.getElementById('hashId').value = id;

            document.getElementById('subjectId').value = result.subject_id;
            document.getElementById('back_link_address').value = result.back_link_address;
            document.getElementById('back_link_name').value = result.back_link_name;
            document.getElementById('price').value = result.price;
            document.getElementById('description').value = result.description;


            document.getElementById('file_address').value = result.file_address;
     
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
    document.getElementById('back_link_address').value = "";
    document.getElementById('back_link_name').value = "";
    document.getElementById('price').value = "";
    document.getElementById('description').value = "";

    $('#uploadImage').attr('src', '');
    $('#photo_address').val('');
}

function readURL(input) {
    LoadElement("#imageSelectBox");
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        // reader.onload = function (e) {
        //     $('#uploadImage').attr('src', e.target.result);
        // }

        reader.readAsDataURL(input.files[0]);
        UnLoadElement("#imageSelectBox");
    }
}

function secondValidation() {

    var backLinkAddress = $('#back_link_address').val();
    var backLinkName = $('#back_link_name').val();
    var description = CKEDITOR.instances["description"].getData();

    //Validation Check
    let ret = true;
    let messagesArr = [];

    if (backLinkAddress === "") {
        messagesArr.push('آدرس سایت وارد نشده است ');
        ret = false;
    }
    if (backLinkName === "") {
        messagesArr.push('نام سایت وارد نشده است ');
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
        data["back_link_address"] = $("#back_link_address").val();
        data["back_link_name"] = $("#back_link_name").val();
        data["price"] = $("#price").val();
        data["description"] = $("#description").val();
        data["file_address"] = $("#file_address").val();
       

        if (data["hashId"] != undefined && data["hashId"] != null && data["hashId"] != "") {
            data["check"] = $("#update_code").val(); //UPDATE_CODE //update
        } else {
            data["check"] = $("#insert_code").val(); //INSERT_CODE; //add
        }

        let file = document.getElementById("upload").files[0];

        let formData = new FormData();
        formData.append("upload", file);
        formData.append("_csrf", data["_csrf"]);
        formData.append("hashId", data["hashId"]);
        formData.append("page_num", data["page_num"]);
        formData.append("subjectId", data["subjectId"]);
   
        formData.append("back_link_address", data["back_link_address"]);
        formData.append("back_link_name", data["back_link_name"]);

        formData.append("price", data["price"]);
        formData.append("description", data["description"]);
        formData.append("file_address", data["file_address"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "users/reportage_request/",
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

function getPrice() {
    let validate = true;
    if ( $("#subjectId").val() == "") {
        validate = false;
    }

    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["subjectId"] = $("#subjectId").val();
        data["check"] = $("#get_price_code").val();//GET_PRICE_CODE; //Get Date And Price

        let formData = new FormData();

        formData.append("_csrf", data["_csrf"]);
        formData.append("subjectId", data["subjectId"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "users/reportage_request/",
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                UnLoadElement(".modal-dialog");
                if (response.status === "1") {

                   $('#price').val(response.price);

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
    $('#back_link_address').val('');
    $('#back_link_name').val('');
    $('#description').val('');

}
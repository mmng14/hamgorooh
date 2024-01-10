$(document).ready(function () {
    $('#menu_manage_reportage_request').addClass('active');


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
    $("#results").load(HOST_NAME + "admin/reportage_request/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/reportage_request/", {
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
    $("#results").load(HOST_NAME + "admin/reportage_request/", {
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
            url: HOST_NAME + "admin/reportage_request/",
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
        url: HOST_NAME + "admin/reportage_request/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() + "&_csrf=" + _csrf,
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
            document.getElementById('post_id').value = result.post_id;
            document.getElementById('reportage_link').value = result.reportage_link;
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
    document.getElementById('post_id').value = "";
    document.getElementById('reportage_link').value = "";

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
        data["post_id"] = $("#post_id").val();
        data["reportage_link"] = $("#reportage_link").val();
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
   
        formData.append("back_link_address", data["back_link_address"]);
        formData.append("back_link_name", data["back_link_name"]);

        formData.append("price", data["price"]);
        formData.append("description", data["description"]);
        formData.append("post_id", data["post_id"]);
        formData.append("reportage_link", data["reportage_link"]);
        
        
        formData.append("file_address", data["file_address"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/reportage_request/",
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
        data["check"] = $('#get_date_and_price_code').val(); //Get Date And Price

        let formData = new FormData();

        formData.append("_csrf", data["_csrf"]);
        formData.append("subjectId", data["subjectId"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/reportage_request/",
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

function activate(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#status_' + id).html(_html);
    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/reportage_request/",
        data: "obj=" + id + "&check=" +  $('#activate_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.state == '1') {
                var _html = "<span   onClick=\"deactivate(" + id + ");\" ><i class=\"fa  fa-toggle-on active-toggle\"></i></span>";
                $('#status_' + id).html(_html);
            }
            UnLoadElement("#results");
        }
    });
}

function deactivate(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/reportage_request/",
        data: "obj=" + id + "&check=" + $('#deactivate_code').val() +"&_csrf=" + _csrf,
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

function activatePayment(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#payment_status_' + id).html(_html);
    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/reportage_request/",
        data: "obj=" + id + "&check=" + $('#activate_payment_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.payment_state == '1') {
                var _html = "<button  class=\"btn btn-success btn-sm\" onClick=\"deactivatePayment(" + id + ");\" >پرداخت شده</button>";
                $('#payment_status_' + id).html(_html);
            }
            UnLoadElement("#results");
        }
    });
}

function deactivatePayment(id) {
    // var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    // $('#payment_status_' + id).html(_html);
    LoadElement("#results");
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/reportage_request/",
        data: "obj=" + id + "&check=" + $('#deactivate_payment_code').val() +"&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.payment_state == '1') {
                var _html = "<button  class=\"btn btn-danger btn-sm\" onClick=\"activatePayment(" + id + ");\" >پرداخت نشده</button>";
                $('#payment_status_' + id).html(_html);
            }
            UnLoadElement("#results");
        }
    });
}

function clearForm() {

    $('#add_update').name = "add";
    $('#form_title').html('فرم افزودن پست');
    $('#hashId').val('');
    $('#subjectId').val('');
    $('#back_link_address').val('');
    $('#back_link_name').val('');
    $('#description').val('');
    $('#post_id').val('');
    $('#reportage_link').val('');

}
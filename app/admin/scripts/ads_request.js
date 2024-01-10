$(document).ready(function () {
    $('#menu_manage_ads_request').addClass('active');

    $('#subjectId').on('change', function() {
        console.log("subjectId");
        getDateAndPrice();
    });

    $('#active_days').on('input', function() {
        console.log("active_days");
        getDateAndPrice();
    });

    $('#adsType').on('change', function() {
        console.log("adsType");
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
    $("#results").load(HOST_NAME + "admin/ads_request/", { "cmd": $('#listing_code').val(), "_csrf": $("#_csrf").val() }); //load initial records

    //executes code below when user click on pagination links
    $("#results").on("click", ".pagination a", function (e) {
        e.preventDefault();
        $(".loading-div").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $('#txtpagenumber').val(page);
        var order = document.getElementById('cmbsort').value;
        var perpage = document.getElementById('cmbnumberPage').value;
        $("#results").load(HOST_NAME + "admin/ads_request/", {
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
    $("#results").load(HOST_NAME + "admin/ads_request/", {
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

        swal({

            title: "",
            text: "<div style='text-align:right;font-size:14px;'>"
                + "<strong> آیا مطمعن هستید که قصد حذف این گزینه  را دارید؟ </strong>"
                + "</div>"
            ,

            showCancelButton: true,
            confirmButtonColor: "#4fbaaf",
            confirmButtonText: "بله",
            className: "confirm-swal-btn",
            cancelButtonColor: "#EF5350",
            cancelButtonText: "خیر",
            closeOnConfirm: true,
            //imageUrl: '/Content/assets/images/question.png',
            html: true,
            closeOnCancel: true

        },
            function (isConfirm) {
                if (isConfirm) {

                    LoadElement('#results');

                    $.ajax({
                        url: HOST_NAME + "admin/ads_request/",
                        type: 'POST',
                        data: {
                            obj: id,
                            _csrf: _csrf,
                            check: check,

                        },
                        dataType: "json",
                        success: function (data) {
                            UnLoadElement('#results');
                            if (data.result == "1") {
                                // window.location.reload();
                                loadData();
                            }

                        },
                        error: function (xhr, textStatus, errorThrown) {
                            UnLoadElement('#results');
                        },
                    });

                } else {
                    //Cancel the delete
                }
            });
    }


}

function setData(id) {
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/ads_request/",
        data: "obj=" + id + "&check=" + $('#edit_code').val() + "&_csrf=" + _csrf,
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

    document.getElementById('subjectId').value = "";
    document.getElementById('title').value = "";
    document.getElementById('adsType').value = "";
    document.getElementById('startDate').value = "";
    document.getElementById('endDate').value = "";
    document.getElementById('link').value = "";
    document.getElementById('price').value = "";
    document.getElementById('active_days').value = "";
    document.getElementById('description').value = "";

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
        url: HOST_NAME + "admin/ads_request/",
        data: "obj=" + id + "&check=" + $('#activate_code').val()  + "&_csrf=" + _csrf,
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
        url: HOST_NAME + "admin/ads_request/",
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

function activatePayment(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#payment_status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/ads_request/",
        data: "obj=" + id + "&check=" + $('#activate_payment_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.payment_state == '1') {
                var _html = "<button  class=\"btn btn-green btn-sm\" onClick=\"deactivatePayment(" + id + ");\" >پرداخت شده</button>";
                $('#payment_status_' + id).html(_html);
            }

        }
    });
}

function deactivatePayment(id) {
    var _html = "<img  src=\"" + HOST_NAME + "resources/images/loading-spinner-blue.gif\" />";
    $('#payment_status_' + id).html(_html);
    var _csrf = $("#_csrf").val();
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/ads_request/",
        data: "obj=" + id + "&check=" + $('#deactivate_payment_code').val() + "&_csrf=" + _csrf,
        dataType: "json",
        cache: false,
        success: function (result) {
            if (result.payment_state == '1') {
                var _html = "<button  class=\"btn btn-danger btn-sm\" onClick=\"activatePayment(" + id + ");\" >پرداخت نشده</button>";
                $('#payment_status_' + id).html(_html);
            }

        }
    });
}

function sendToSubjects(id) {

    LoadElement("#results");
    $.ajax({
        type: "POST",
        url: HOST_NAME + "admin/ads_request/",
        data: "obj=" + id + "&check=" + $('#send_to_subjects_code').val(),
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement("#results");
            if (result.status === "1") {
                console.log(result);
                toastr["success"](result.message);
            }
            else {
                toastr["error"](result.message);
            }

        }
    });

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
        formData.append("subjectId", data["subjectId"]);
        formData.append("title", data["title"]);
        formData.append("adsType", data["adsType"]);
        formData.append("startDate", data["startDate"]);
        formData.append("endDate", data["endDate"]);
        formData.append("link", data["link"]);
        formData.append("price", data["price"]);
        formData.append("description", data["description"]);
        formData.append("photo", data["photo"]);
        formData.append("status", data["status"]);
        formData.append("active_days", data["active_days"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/ads_request/",
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
    if ($("#adsType").val() == "" || $("#adsType").val() == "0" || $("#active_days").val() == "") {
        validate = false;
    }

    if (validate) {

        var data = {};
        data["_csrf"] = $("#_csrf").val();
        data["subjectId"] = $("#subjectId").val();
        data["adsType"] = $("#adsType").val();
        data["active_days"] = $("#active_days").val();
        data["check"] = $('#get_date_and_price_code').val(); //Get Date And Price

        let formData = new FormData();

        formData.append("_csrf", data["_csrf"]);
        formData.append("subjectId", data["subjectId"]);
        formData.append("adsType", data["adsType"]);
        formData.append("active_days", data["active_days"]);
        formData.append("check", data["check"]);


        LoadElement(".modal-dialog");
        $.ajax({
            type: 'post',
            url: HOST_NAME + "admin/ads_request/",
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
    $('#status').prop('checked', false);
}
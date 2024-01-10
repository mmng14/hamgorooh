$(document).ready(function () {
  /* "LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,INSERT_CODE" */
  $("#menu_authors").addClass("active");

  $("#upload").change(function () {
    LoadElement("#imageSelectBox");
    readURL(this);
  });

  registerFormValidation = $("#formAuthors").validate({
    rules: {
      full_name: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
      },

      brief_description: {
        required: true,
        noHtmlTag: true,
        maxlength: 500,
      },
      description: {
        required: true,
        noHtmlTag: true,
      },
    },
    submitHandler: function () {
      sendingData();
    },
  });

  // Enable CKEditor in all environments except IE7 and below.
  if (!CKEDITOR.env.ie || CKEDITOR.env.version > 7)
    CKEDITOR.env.isCompatible = true;
});

window.onload = function () {
  $("#loader").show();
  console.log(HOST_NAME);
  $("#results").load(HOST_NAME + "admin/authors/", {
    cmd:  $("#listing_code").val(),//LISTING_CODE,
    _csrf: $("#_csrf").val(),
  }); //load initial records

  //executes code below when user click on pagination links
  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    $(".loading-div").show(); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    $("#txtpagenumber").val(page);
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;
    $("#results").load(
      HOST_NAME + "admin/authors/",
      {
        page: page,
        order: order,
        perpage: perpage,
        _csrf: $("#_csrf").val(),
        cmd: $("#listing_code").val(),//LISTING_CODE,
      },
      function () {
        //get content from PHP page
        $(".loading-div").hide(); //once done, hide loading element
      }
    );
  });
};

function loadData() {
  var order = document.getElementById("cmbsort").value;
  var perpage = document.getElementById("cmbnumberPage").value;
  var page = document.getElementById("page_num").value;
  $("#results").load(
    HOST_NAME + "admin/authors/",
    {
      _csrf: $("#_csrf").val(),
      page: page,
      order: order,
      perpage: perpage,
      cmd: $("#listing_code").val(),// LISTING_CODE,
    },
    function () {
      $(".loading-div").hide(); //once done, hide loading element
    }
  );
}

function deleteData(id) {
  var check = $("#delete_code").val();//DELETE_CODE;
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
          url: HOST_NAME + "admin/authors/",
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
  let EDIT_CODE = $("#edit_code").val();
  var _csrf = $("#_csrf").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/authors/",
    data: "obj=" + id + "&check=" + EDIT_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      document.getElementById("save").name = "update";
      document.getElementById("save").value = "ویرایش";
      document.getElementById("hashId").value = id;
      document.getElementById("full_name").value = result.full_name;
      document.getElementById("description").value = result.description;
      document.getElementById("brief_description").value = result.brief_description;
      document.getElementById("fame_fields").value = result.fame_fields;
      document.getElementById("start_year").value = result.start_year;
      document.getElementById("end_year").value = result.end_year;
      document.getElementById("photo_address").value = result.photo_address;
      $("#uploadImage").attr("src", HOST_NAME + result.photo_address);
      if (result.status == 1) document.getElementById("status").checked = true;
      else document.getElementById("status").checked = false;
    },
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
  $("#save").name = "add";
  $("#save").val("افزودن");
  $("#hashId").val("");
  $("#full_name").val("");
  $("#brief_description").val("");
  $("#description").val("");
  $("#fame_fields").val("");
  $("#start_year").val("");
  $("#end_year").val("");
  $("#status").prop("checked", false);
  $("#uploadImage").attr("src", "");
  $("#photo_address").val("");
}

function activate(id) {
  var _html = '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  let ACTIVATE_CODE =$("#activate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/authors/",
    data: "obj=" + id + "&check=" + ACTIVATE_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      if (result.state == "1") {
        var _html =
          '<span   onClick="deactivate(' +
          id +
          ');" ><i class="fa  fa-toggle-on active-toggle"></i></span>';
        $("#status_" + id).html(_html);
      }
    },
  });
}

function deactivate(id) {
  var _html =
    '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  let DEACTIVATE_CODE =$("#deactivate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/authors/",
    data: "obj=" + id + "&check=" + DEACTIVATE_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      if (result.state == "1") {
        var _html =
          '<span   onClick="activate(' +
          id +
          ');" ><i class="fa  fa-toggle-off deactive-toggle"></i></span>';
        $("#status_" + id).html(_html);
      }
    },
  });
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#uploadImage").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
    UnLoadElement("#imageSelectBox");
  }
}

function secondValidation() {
  var full_name = $("#full_name").val();
  var brief_desc = $("#brief_description").val();
  var description =  $("#description").val(); 

  //Validation Check
  let ret = true;
  let messagesArr = [];

  if (full_name === "") {
    messagesArr.push("عنوان وارد نشده است ");
    ret = false;
  }


  if (brief_desc === "") {
    messagesArr.push("شرح مختصر وارد نشده است ");
    ret = false;
  }

  if (description === "") {
    messagesArr.push("شرح  وارد نشده است ");
    ret = false;
  }

  if (!ret) {
    toastr["error"](messagesArr.join("<br>"));
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
    data["full_name"] = $("#full_name").val();
    data["brief_description"] = $("#brief_description").val();
    data["description"] = $("#description").val(); // CKEDITOR.instances["description"].getData();
    data["fame_fields"] = $("#fame_fields").val();
    data["start_year"] = $("#start_year").val();
    data["end_year"] = $("#end_year").val();
    data["status"] = $("#status").val();

    if (
      data["hashId"] != undefined &&
      data["hashId"] != null &&
      data["hashId"] != ""
    ) {
      data["check"] =  $("#update_code").val();//UPDATE_CODE; //update
    } else {
      data["check"] =  $("#insert_code").val();//INSERT_CODE; //add
    }

    let file = document.getElementById("upload").files[0];

    let formData = new FormData();
    formData.append("upload", file);
    formData.append("_csrf", data["_csrf"]);
    formData.append("hashId", data["hashId"]);
    formData.append("page_num", data["page_num"]);
    formData.append("full_name", data["full_name"]);
    formData.append("brief_description", data["brief_description"]);
    formData.append("description", data["description"]);
    formData.append("photo_address", data["photo_address"]);
    formData.append("status", data["status"]);
    formData.append("fame_fields", data["fame_fields"]);
    formData.append("start_year", data["start_year"]);
    formData.append("end_year", data["end_year"]);
    formData.append("check", data["check"]);

    LoadElement(".modal-dialog");
    $.ajax({
      type: "post",
      url: HOST_NAME + "admin/authors/",
      data: formData,
      dataType: "json",
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
      },
    });
  }
}

function clearForm() {
  $("#add_update").name = "add";
  $("#form_title").html("فرم افزودن پست");
  $("#hashId").val("");
  $("#full_name").val("");
  $("#brief_description").val("");
  $("#description").val("");
  //CKEDITOR.instances["description"].setData("");
  $("#fame_fields").val("");
  $("#start_year").val("");
  $("#end_year").val("");
  $("#status").prop("checked", false);
}

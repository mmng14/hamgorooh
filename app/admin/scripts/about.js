$(document).ready(function () {
  $("#menu_about").addClass("active");

  $("#upload").change(function () {
    LoadElement("#imageSelectBox");
    readURL(this);
  });

  registerFormValidation = $("#formAbout").validate({
    rules: {
      title: {
        required: true,
        noHtmlTag: true,
        justPersian: true,
        maxlength: 300,
      },

      briefDescription: {
        required: true,
        noHtmlTag: true,
        justPersian: true,
        maxlength: 500,
      },
      description: {
        required: true,
        noHtmlTag: true,
        justPersian: true,
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
  $("#results").load(HOST_NAME + "admin/about/", {
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
      HOST_NAME + "admin/about/",
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
    HOST_NAME + "admin/about/",
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
          url: HOST_NAME + "admin/about/",
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
    url: HOST_NAME + "admin/about/",
    data: "obj=" + id + "&check=" + EDIT_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      document.getElementById("save").name = "update";
      document.getElementById("save").value = "ویرایش";
      document.getElementById("hashId").value = id;
      document.getElementById("title").value = result.title;
      document.getElementById("description").value = result.desc;
    //  CKEDITOR.instances["description"].setData(result.desc);

    //   let rawStr = CKEDITOR.instances["description"].getData();
    //   data["description"] = rawStr.replace(
    //     /[\u00A0-\u9999<>\&]/gim,
    //     function (i) {
    //       return "&#" + i.charCodeAt(0) + ";";
    //     }
    //   );
    //   var encodedString = btoa(data["description"]);
    //   data["description"] = encodedString;

      document.getElementById("briefDescription").value = result.brief_desc;
      document.getElementById("ordering").value = result.ordering;
      document.getElementById("photo_address").value = result.photo;
      $("#uploadImage").attr("src", HOST_NAME + result.photo);
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
  $("#title").val("");
  $("#briefDescription").val("");
  // CKEDITOR.instances["description"].setData("");
  $("#description").val("");
  $("#ordering").val("");
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
    url: HOST_NAME + "admin/about/",
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
    url: HOST_NAME + "admin/about/",
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
  var title = $("#title").val();
  var keywords = $("#keywords").val();
  var brief_desc = $("#brief_description").val();
  var description =  $("#description").val(); // CKEDITOR.instances["description"].getData();

  //Validation Check
  let ret = true;
  let messagesArr = [];

  if (title === "") {
    messagesArr.push("عنوان وارد نشده است ");
    ret = false;
  }

  if (keywords === "") {
    messagesArr.push("کلمات کلیدی وارد نشده است ");
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
    // swal({
    //     title: "خطا",
    //     text: messagesArr.join('<br>'),
    //     html: true,
    //     confirmButtonColor: "#EF5350",
    //     type: "error"
    // });
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
    data["title"] = $("#title").val();
    data["brief_description"] = $("#briefDescription").val();
    data["description"] = $("#description").val(); // CKEDITOR.instances["description"].getData();
    data["ordering"] = $("#ordering").val();
    data["photo"] = $("#photo_address").val();
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
    formData.append("title", data["title"]);
    formData.append("brief_description", data["brief_description"]);
    formData.append("description", data["description"]);
    formData.append("photo", data["photo"]);
    formData.append("status", data["status"]);
    formData.append("ordering", data["ordering"]);
    formData.append("check", data["check"]);

    LoadElement(".modal-dialog");
    $.ajax({
      type: "post",
      url: HOST_NAME + "admin/about/",
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
  $("#title").val("");
  $("#briefDescription").val("");
  $("#description").val("");
  //CKEDITOR.instances["description"].setData("");
  $("#ordering").val("");
  $("#status").prop("checked", false);
}

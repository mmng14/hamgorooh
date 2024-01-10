$(document).ready(function () {
  $("#menu_resources").addClass("active");


  getParentListData(0);

  $("#upload").change(function () {
    LoadElement("#imageSelectBox");
    readURL(this);
  });

  registerFormValidation = $("#formResourceAttachments").validate({
    rules: {
      title: {
        required: true,
        noHtmlTag: true,
        justPersian: true,
        maxlength: 300,
      },

      link_address: {
        required: true,
        noHtmlTag: true,
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
  $("#results").load(HOST_NAME + "group_admin/resources-attachments/", {
    cmd:  $("#listing_code").val(),//LISTING_CODE,
    resource_id : $("#selected_resource_id").val(),
    subject_id : $("#selected_subject_id").val(),
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
      HOST_NAME + "group_admin/resources-attachments/",
      {
        page: page,
        order: order,
        perpage: perpage,
        _csrf: $("#_csrf").val(),
        resource_id : $("#selected_resource_id").val(),
        subject_id : $("#selected_subject_id").val(),
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
    HOST_NAME + "group_admin/resources-attachments/",
    {
      _csrf: $("#_csrf").val(),
      resource_id : $("#selected_resource_id").val(),
      subject_id : $("#selected_subject_id").val(),
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
          url: HOST_NAME + "group_admin/resources-attachments/",
          type: "POST",
          data: {
            obj: id,
            _csrf: _csrf,
            subject_id : $("#selected_subject_id").val(),
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

  getParentListData(id);

  let EDIT_CODE = $("#edit_code").val();
  var subject_id = $("#selected_subject_id").val();
  var _csrf = $("#_csrf").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/resources-attachments/",
    data: "obj=" + id  + "&subject_id=" + subject_id + "&check=" + EDIT_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      document.getElementById("save").name = "update";
      document.getElementById("save").value = "ویرایش";
      document.getElementById("hashId").value = id;
      document.getElementById("title").value = result.title;
      document.getElementById("description").value = result.description;
      document.getElementById("link_address").value = result.link_address;
      document.getElementById("attachment_type").value = result.attachment_type;
      document.getElementById("parent_id").value = result.parent_id;
      document.getElementById("resource_id").value = result.resource_id;
      document.getElementById("photo_address").value = result.photo_address;
      document.getElementById("ordering").value = result.ordering;
      $("#uploadImage").attr("src", HOST_NAME + result.photo_address);
      if (result.status == 1) document.getElementById("status").checked = true;
      else document.getElementById("status").checked = false;
    },
  });
}

function getParentListData(id) {
  let listing_code = $("#get_category_list_code").val();
  var _csrf = $("#_csrf").val();
  var resourceId =  $("#selected_resource_id").val();
  var subject_id = $("#selected_subject_id").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/resources-attachments/",
    data: "id=" + id + "&resourceId=" + resourceId + "&subject_id=" + subject_id + "&check=" + listing_code + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      $('#parent_id').html(result.html_options);
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
  $("#link_address").val("");
  $("#description").val("");
  $("#attachment_type").val("");
  $("#parent_id").val("");
  $("#resource_id").val("");
  $("#ordering").val("");
  $("#status").prop("checked", false);
  $("#uploadImage").attr("src", "");
  $("#photo_address").val("");
}

function activate(id) {
  var _html = '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  var subject_id = $("#selected_subject_id").val();
  let ACTIVATE_CODE =$("#activate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/resources-attachments/",
    data: "obj=" + id + "&subject_id=" + subject_id +  "&check=" + ACTIVATE_CODE + "&_csrf=" + _csrf,
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
  var subject_id = $("#selected_subject_id").val();
  let DEACTIVATE_CODE =$("#deactivate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/resources-attachments/",
    data: "obj=" + id + "&subject_id=" + subject_id + "&check=" + DEACTIVATE_CODE + "&_csrf=" + _csrf,
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
  var brief_desc = $("#brief_description").val();
  var description =  $("#description").val(); 

  //Validation Check
  let ret = true;
  let messagesArr = [];

  if (title === "") {
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
    data["title"] = $("#title").val();
    data["link_address"] = $("#link_address").val();
    data["attachment_type"] = $("#attachment_type").val();
    data["description"] = $("#description").val(); // CKEDITOR.instances["description"].getData();
    data["resource_id"] = $("#selected_resource_id").val();
    data["subject_id"] = $("#selected_subject_id").val();
    data["parent_id"] = $("#parent_id").val();
    data["ordering"] = $("#ordering").val();
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
    formData.append("link_address", data["link_address"]);
    formData.append("description", data["description"]);
    formData.append("photo_address", data["photo_address"]);
    formData.append("attachment_type", data["attachment_type"]);
    formData.append("resource_id", data["resource_id"]);
    formData.append("subject_id", data["subject_id"]);
    formData.append("parent_id", data["parent_id"]);
    formData.append("ordering", data["ordering"]);
    formData.append("status", data["status"]);
    formData.append("check", data["check"]);

    LoadElement(".modal-dialog");
    $.ajax({
      type: "post",
      url: HOST_NAME + "group_admin/resources-attachments/",
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
  $("#link_address").val("");
  $("#description").val("");
  //CKEDITOR.instances["description"].setData("");
  $("#attachment_type").val("");
  $("#parent_id").val("");
  $("#ordering").val("");
  $("#status").prop("checked", false);


  getParentListData(0);

}

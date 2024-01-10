$(document).ready(function () {
  $("#menu_subjects").addClass("active");

  $("#upload").change(function () {
    LoadElement("#imageSelectBox");
    readURL(this);
  });

  registerFormValidation = $("#frmSubjectResources").validate({
    rules: {
      resource_id: {
        required: true,
        noHtmlTag: true,
        maxlength: 200,
      },

      title: {
        required: true,
        noHtmlTag: true,
        maxlength: 500,
      },
      brief_description: {
        required: true,
        noHtmlTag: true,
        maxlength: 1000,
      },
      importance: {
        required: true,
        noHtmlTag: true,
      },
      ordering: {
        required: true,
        noHtmlTag: true,
      },
    },
    submitHandler: function () {
      sendingData();
    },
  });
});

$(function () {
  // Apply the plugin

  var categories = $("#categories").filterMultiSelect({
    selectAllText: "انتخاب همه",
    placeholderText: "برای انتخاب کلیک نمایید",
    filterText: "جستجو",
    labelText: "",
    caseSensitive: false,
  });

  $("#select_resource").click((e) => {
    categories.deselectAll();
  });

  $("#categories").on("optionselected", function (e) {
    var categoriesJson = JSON.parse(categories.getSelectedOptionsAsJson());
    console.log("deselected", categoriesJson);
    $("#category_ids").val(categoriesJson["categories"].join(","));
  });

  $("#categories").on("optiondeselected", function (e) {
    var categoriesJson = JSON.parse(categories.getSelectedOptionsAsJson());
    console.log("deselected", categoriesJson);
    $("#category_ids").val(categoriesJson["categories"].join(","));
  });

  $("#form").on("keypress keyup", function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });
});

window.onload = function () {
  $("#loader").show();
  console.log(HOST_NAME);
  var subject = $("#this_subject_id").val();
  $("#results").load(HOST_NAME + "group_admin/subject_resources/", {
    cmd: $("#listing_code").val(),
    _csrf: $("#_csrf").val(),
    subject: subject,
  }); //load initial records

  //executes code below when user click on pagination links
  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    $(".loading-div").show(); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    $("#txtpagenumber").val(page);
    var subject = $("#this_subject_id").val();
    var order = 1;
    var perpage = 100;

    $("#results").load(
      HOST_NAME + "group_admin/subject_resources/",
      {
        page: page,
        order: order,
        perpage: perpage,
        _csrf: $("#_csrf").val(),
        subject: subject,
        cmd: $("#listing_code").val(),
      },
      function () {
        //get content from PHP page
        $(".loading-div").hide(); //once done, hide loading element
      }
    );
  });
};

function loadData() {
  var order = 1;
  var perpage = 100;
  var page = document.getElementById("page_num").value;
  var subject = $("#this_subject_id").val();
  $("#results").load(
    HOST_NAME + "group_admin/subject_resources/",
    {
      _csrf: $("#_csrf").val(),
      page: page,
      order: order,
      perpage: perpage,
      subject: subject,
      cmd: $("#listing_code").val(),
    },
    function () {
      $(".loading-div").hide(); //once done, hide loading element
    }
  );
}

function deleteData(id) {
  var check = $("#delete_code").val();
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
          url: HOST_NAME + "group_admin/subject_resources/",
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
    url: HOST_NAME + "group_admin/subject_resources/",
    data: "obj=" + id + "&check=" + $("#edit_code").val() + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      document.getElementById("save").name = "update";
      document.getElementById("save").value = "ویرایش";
      document.getElementById("hashId").value = id;
      document.getElementById("resource_id").value = result.resource_id;
      document.getElementById("category_ids").value = result.category_ids;
      document.getElementById("title").value = result.title;
      document.getElementById("brief_description").value = result.brief_description;
      document.getElementById("importance").value = result.importance;
      document.getElementById("ordering").value = result.ordering;
      document.getElementById("photo_address").value = result.photo_address;
      $("#resource_photo").attr("src", HOST_NAME + result.photo_address);

      $("#categories_div").html(result.categories_options);
      var categories = $("#categories").filterMultiSelect({
        selectAllText: "انتخاب همه",
        placeholderText: "برای انتخاب کلیک نمایید",
        filterText: "جستجو",
        labelText: "",
        caseSensitive: false,
      });

      $("#select_resource").click((e) => {
        categories.deselectAll();
      });

      $("#categories").on("optionselected", function (e) {
        //console.log("selected", e.detail.label);
        var categoriesJson = JSON.parse(categories.getSelectedOptionsAsJson());
        console.log("selected", categoriesJson);
        $("#category_ids").val(categoriesJson["categories"].join(","));
      });

      $("#categories").on("optiondeselected", function (e) {
        //console.log("deselected", e.detail.label);
        var categoriesJson = JSON.parse(categories.getSelectedOptionsAsJson());
        console.log("deselected", categoriesJson);
        $("#category_ids").val(categoriesJson["categories"].join(","));
      });
    },
  });
}

function checkElement() {
  if (document.getElementById("description").value == "") {
    alert(" پر کردن نام تصویر الزامی است");
    return false;
  }
  return true;
}

function clearData() {
  $("#save").name = "add";
  $("#save").val("افزودن");
  $("#hashId").val("");

  $("#form_title").html("فرم افزودن منبع");
  $("#hashId").val("");

  document.getElementById("resource_id").value = "";
  document.getElementById("photo_address").value = "";
  document.getElementById("title").value = "";
  document.getElementById("brief_description").value = "";
  document.getElementById("importance").value = "";
  document.getElementById("category_ids").value = "";
  document.getElementById("ordering").value = "";

  $("#status").prop("checked", false);
  $("#resource_photo").attr("src", "");
  $("#photo_address").val("");

  var categories = $("#categories").filterMultiSelect();
  categories.deselectAll();
}

function activate(id) {
  var _html =
    '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/subject_resources/",
    data:
      "obj=" + id + "&check=" + $("#activate_code").val() + "&_csrf=" + _csrf,
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
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/subject_resources/",
    data:
      "obj=" + id + "&check=" + $("#deactivate_code").val() + "&_csrf=" + _csrf,
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

function sendingData() {
  let validate = true; //secondValidation();
  if (validate) {
    var data = {};
    data["_csrf"] = $("#_csrf").val();
    data["hashId"] = $("#hashId").val();
    data["page_num"] = $("#page_num").val();

    data["subject_id"] = $("#this_subject_id").val();
    data["resource_id"] = $("#resource_id").val();
    data["category_ids"] = $("#category_ids").val();
    data["importance"] = $("#importance").val();
    data["title"] = $("#title").val();
    data["brief_description"] = $("#brief_description").val();
    data["photo_address"] = $("#photo_address").val();
    data["ordering"] = $("#ordering").val();
    data["status"] = $("#status").val();

    if (
      data["hashId"] != undefined &&
      data["hashId"] != null &&
      data["hashId"] != ""
    ) {
      data["check"] = $("#update_code").val(); //update
    } else {
      data["check"] = $("#insert_code").val(); //add
    }

    let formData = new FormData();

    formData.append("_csrf", data["_csrf"]);
    formData.append("hashId", data["hashId"]);
    formData.append("page_num", data["page_num"]);

    formData.append("subject_id", data["subject_id"]);
    formData.append("resource_id", data["resource_id"]);
    formData.append("category_ids", data["category_ids"]);
    formData.append("importance", data["importance"]);
    formData.append("title", data["title"]);
    formData.append("brief_description", data["brief_description"]);
    formData.append("photo_address", data["photo_address"]);
    formData.append("status", data["status"]);
    formData.append("ordering", data["ordering"]);
    formData.append("check", data["check"]);

    LoadElement(".modal-dialog");
    $.ajax({
      type: "post",
      url: HOST_NAME + "group_admin/subject_resources/",
      data: formData,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (response) {
        UnLoadElement(".modal-dialog");
        if (response.status === "1") {
          toastr["success"](response.message);
          console.log(response);
          //clearData();
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

function loadResourceList(type) {
  //AJAX CALL Save image and get result
  var _csrf = $("#_csrf").val();
  var subject_id = $("#subject_id").val();
  var category_id = $("#category_id").val();
  var check = $("#post_resource_list_code").val();
  var pageNumber = $("#photoListPageNumber").val();
  var searchExp = $("#txtResourceSearch").val();

  LoadElement("#choose-from-resources");
  $.ajax({
    type: "POST",
    url: HOST_NAME + "group_admin/subject_resources/",
    data: {
      s_id: subject_id,
      cf: category_id,
      exp: searchExp,
      page: pageNumber,
      perpage: 9,
      _csrf: _csrf,
      check: check,
    },
    dataType: "json",
    cache: false,
    success: function (result) {
      UnLoadElement("#choose-from-resources");
      if (result.status === "1") {
        if (type == "paging") {
          if (pageNumber === 1) {
            $("#resourceListContainer").html(result.html);
          } else {
            $("#resourceListContainer").append(result.html);
          }
        } else {
          //if search
          $("#resourceListContainer").html(result.html);
        }
        if (result.total_pages > result.page_number) {
          $("#loadMoreResource").fadeIn(100);
          $("#resourceListPageNumber").val(result.page_number);
        } else {
          $("#loadMoreResource").fadeOut(100);
        }
      } else {
        toastr["error"]("خطایی رخ داده است");
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      console.log(errorThrown);
      console.log("we have a problem :(");
      UnLoadElement("#choose-from-resources");
    },
  });
}

function selectFromResourceList(id) {
  console.log(id);
  var resourcePhoto = $("#resource_photo_" + id).val();
  var resourceAddress = $("#resource_address_" + id).val();
  var resourceTitle = $("#resource_title_" + id).val();
  console.log(resourceAddress + " " + resourceTitle);
  if (resourceAddress != undefined && resourceAddress != "") {
    $("#title").val(resourceTitle);
    $("#photo_address").val(resourcePhoto);
    $("#resource_id").val(id);
    $("#resource_photo").attr("src", HOST_NAME + resourcePhoto);
    toastr["success"]("عنوان و آدرس منبع با موفقیت در داخل متن قرار گرفت");
    $("#choose-from-resources").modal("toggle");
  }
}

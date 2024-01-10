var subjects;
$(document).ready(function () {
  $("#menu_resources").addClass("active");

  $("#upload").change(function () {
    LoadElement("#imageSelectBox");
    readURL(this);
  });

  // Checkboxes, radios
  // $(".styled, .multiselect-container input").uniform({
  //   radioClass: 'choice'
  // });

  // ConvertElementToSelect2StaticWithCounter({
  //   selector: "#subjects",
  //   placeHolder: "جستجوی موضوعات",
  //   closeOnSelect: false,
  //   minimumLength: 0,
  // });

  registerFormValidation = $("#formResources").validate({
    rules: {
      title: {
        required: true,
        noHtmlTag: true,
        // justPersian: true,
        maxlength: 300,
      },
      subject_id: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
      },
      brief_description: {
        required: true,
        noHtmlTag: true,
        // justPersian: true,
        maxlength: 500,
      },
      description: {
        required: true,
        noHtmlTag: true,
        // justPersian: true,
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

$(function () {
  // Apply the plugin

  subjects = $("#subjects").filterMultiSelect({
    selectAllText: "انتخاب همه",
    placeholderText: "برای انتخاب کلیک نمایید",
    filterText: "جستجو",
    labelText: "",
    caseSensitive: false,
  });

  $("#subjects").on("optionselected", function (e) {
    console.log("selected", e.detail.label);
    var subjectsJson = JSON.parse(subjects.getSelectedOptionsAsJson());
    $("#subject_ids").val(subjectsJson["subjects"].join(","));
  });

  $("#subjects").on("optiondeselected", function (e) {
    console.log("deselected", e.detail.label);
    var subjectsJson = JSON.parse(subjects.getSelectedOptionsAsJson());
    $("#subject_ids").val(subjectsJson["subjects"].join(","));
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

  $("#results").load(HOST_NAME + "admin/resources/", {
    cmd: $("#listing_code").val(), //LISTING_CODE,
    _csrf: $("#_csrf").val(),
    sf: $("#subject_filter").val(),
  }); //load initial records

  //executes code below when user click on pagination links
  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    $(".loading-div").show(); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    $("#txtpagenumber").val(page);
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;
    var subject_filter = $("#subject_filter").val();
    $("#results").load(
      HOST_NAME + "admin/resources/",
      {
        page: page,
        order: order,
        perpage: perpage,
        sf: subject_filter,
        _csrf: $("#_csrf").val(),
        cmd: $("#listing_code").val(), //LISTING_CODE,
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
  var subject_filter = $("#subject_filter").val();
  $("#results").load(
    HOST_NAME + "admin/resources/",
    {
      _csrf: $("#_csrf").val(),
      page: page,
      order: order,
      perpage: perpage,
      sf: subject_filter,
      cmd: $("#listing_code").val(), // LISTING_CODE,
    },
    function () {
      $(".loading-div").hide(); //once done, hide loading element
    }
  );
}

function deleteData(id) {
  var check = $("#delete_code").val(); //DELETE_CODE;
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
          url: HOST_NAME + "admin/resources/",
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
    url: HOST_NAME + "admin/resources/",
    data: "obj=" + id + "&check=" + EDIT_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      document.getElementById("save").name = "update";
      document.getElementById("save").value = "ویرایش";
      document.getElementById("hashId").value = id;
      document.getElementById("title").value = result.title;
      document.getElementById("subject_ids").value = result.subject_ids;
      document.getElementById("description").value = result.description;
      document.getElementById("brief_description").value =
        result.brief_description;
      document.getElementById("publish_year").value = result.publish_year;
      document.getElementById("author_id").value = result.author_id;
      document.getElementById("ordering").value = result.ordering;
      document.getElementById("photo_address").value = result.photo_address;
      $("#uploadImage").attr("src", HOST_NAME + result.photo_address);
      if (result.status == 1) document.getElementById("status").checked = true;
      else document.getElementById("status").checked = false;

      $("#subjects_div").html(result.subjects_options);
      var subjects = $("#subjects").filterMultiSelect({
        selectAllText: "انتخاب همه",
        placeholderText: "برای انتخاب کلیک نمایید",
        filterText: "جستجو",
        labelText: "",
        caseSensitive: false,
      });

      $("#subjects").on("optionselected", function (e) {
        console.log("selected", e.detail.label);
        var subjectsJson = JSON.parse(subjects.getSelectedOptionsAsJson());
        $("#subject_ids").val(subjectsJson["subjects"].join(","));
      });

      $("#subjects").on("optiondeselected", function (e) {
        console.log("deselected", e.detail.label);
        var subjectsJson = JSON.parse(subjects.getSelectedOptionsAsJson());
        $("#subject_ids").val(subjectsJson["subjects"].join(","));
      });
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
  console.log("clean");
  $("#save").name = "add";
  $("#save").val("افزودن");
  $("#hashId").val("");
  $("#title").val("");
  //$("#subject_ids").val("");
  subjects.deselectAll();
  $("#brief_description").val("");
  $("#description").val("");
  $("#publish_year").val("");
  $("#author_id").val("");
  $("#ordering").val("");
  $("#status").prop("checked", false);
  $("#uploadImage").attr("src", "");
  $("#photo_address").val("");
}

function activate(id) {
  var _html =
    '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  let ACTIVATE_CODE = $("#activate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/resources/",
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
  let DEACTIVATE_CODE = $("#deactivate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/resources/",
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
  var brief_desc = $("#brief_description").val();
  var description = $("#description").val();

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
    data["subject_ids"] = $("#subject_ids").val();
    data["brief_description"] = $("#brief_description").val();
    data["description"] = $("#description").val(); // CKEDITOR.instances["description"].getData();
    data["publish_year"] = $("#publish_year").val();
    data["author_id"] = $("#author_id").val();
    data["ordering"] = $("#ordering").val();
    data["status"] = $("#status").val();

    if (
      data["hashId"] != undefined &&
      data["hashId"] != null &&
      data["hashId"] != ""
    ) {
      data["check"] = $("#update_code").val(); //UPDATE_CODE; //update
    } else {
      data["check"] = $("#insert_code").val(); //INSERT_CODE; //add
    }

    let file = document.getElementById("upload").files[0];

    let formData = new FormData();
    formData.append("upload", file);
    formData.append("_csrf", data["_csrf"]);
    formData.append("hashId", data["hashId"]);
    formData.append("page_num", data["page_num"]);
    formData.append("title", data["title"]);
    formData.append("subject_ids", data["subject_ids"]);
    formData.append("brief_description", data["brief_description"]);
    formData.append("description", data["description"]);
    formData.append("photo_address", data["photo_address"]);
    formData.append("status", data["status"]);
    formData.append("publish_year", data["publish_year"]);
    formData.append("author_id", data["author_id"]);
    formData.append("ordering", data["ordering"]);
    formData.append("check", data["check"]);

    LoadElement(".modal-dialog");
    $.ajax({
      type: "post",
      url: HOST_NAME + "admin/resources/",
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
  console.log('clearForm');
  $("#add_update").name = "add";
  $("#form_title").html("فرم افزودن پست");
  $("#hashId").val("");
  $("#title").val("");
  //$("#subject_ids").val("");
  subjects.deselectAll();
  $("#brief_description").val("");
  $("#description").val("");
  //CKEDITOR.instances["description"].setData("");
  $("#publish_year").val("");
  $("#author_id").val("");
  $("#ordering").val("");
  $("#status").prop("checked", false);
  $("#uploadImage").attr("src", "");
  $("#photo_address").val("");
}

// Use the plugin once the DOM has been loaded.
$(function () {
  // Apply the plugin
  var notifications = $("#notifications");
  $("#animals").on("optionselected", function (e) {
    createNotification("selected", e.detail.label);
  });
  $("#animals").on("optiondeselected", function (e) {
    createNotification("deselected", e.detail.label);
  });
  function createNotification(event, label) {
    var n = $(document.createElement("span"))
      .text(event + " " + label + "  ")
      .addClass("notification")
      .appendTo(notifications)
      .fadeOut(3000, function () {
        n.remove();
      });
  }
  var shapes = $("#shapes").filterMultiSelect({
    selectAllText: "all...",
    placeholderText: "click to select a shape",
    filterText: "search",
    labelText: "Shapes",
    caseSensitive: true,
  });
  var cars = $("#cars").filterMultiSelect();
  var pl1 = $("#programming_languages_1").filterMultiSelect();
  $("#b1").click((e) => {
    pl1.enableOption("1");
  });
  $("#b2").click((e) => {
    pl1.disableOption("1");
  });
  var pl2 = $("#programming_languages_2").filterMultiSelect();
  $("#b3").click((e) => {
    pl2.enable();
  });
  $("#b4").click((e) => {
    pl2.disable();
  });
  var pl3 = $("#programming_languages_3").filterMultiSelect({
    allowEnablingAndDisabling: false,
  });
  $("#b5").click((e) => {
    pl3.enableOption("1");
  });
  $("#b6").click((e) => {
    pl3.disableOption("1");
  });
  $("#b7").click((e) => {
    pl3.enable();
  });
  $("#b8").click((e) => {
    pl3.disable();
  });
  var cities = $("#cities").filterMultiSelect({
    items: [
      ["San Francisco", "a"],
      ["Milan", "b", false, true],
      ["Singapore", "c", true],
      ["Berlin", "d", true, true],
    ],
  });
  var colors = $("#colors").filterMultiSelect();
  var trees = $("#trees").filterMultiSelect({
    selectionLimit: 3,
  });
  $("#jsonbtn1").click((e) => {
    var b = true;
    $("#jsonresult1").text(JSON.stringify(getJson(b), null, "  "));
  });
  var getJson = function (b) {
    var result = $.fn.filterMultiSelect.applied
      .map((e) => JSON.parse(e.getSelectedOptionsAsJson(b)))
      .reduce((prev, curr) => {
        prev = {
          ...prev,
          ...curr,
        };
        return prev;
      });
    return result;
  };
  $("#jsonbtn2").click((e) => {
    var b = false;
    $("#jsonresult2").text(JSON.stringify(getJson(b), null, "  "));
  });
  $("#form").on("keypress keyup", function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });
});

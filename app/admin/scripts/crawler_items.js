$(document).ready(function () {
  $("#menu_robot_resources").addClass("active");

  $("#upload").change(function () {
    LoadElement("#imageSelectBox");
    readURL(this);
  });

  $("#category_id").change(function () {
    getSubCategories();
    //loadData();
  });

  function getSubCategories() {
    console.log("print");
    //var htmlOptions = '<oprion value="1">test</option>';
    //$('#sub_category_filter').html(htmlOptions);
    //$('#sub_category_filter').selectpicker('refresh');
    //$("#sub_category_filter").html(htmlOptions).selectpicker('refresh'); //.empty().append(htmlOptions).selectpicker('refresh').trigger('change');
    var cat_id = document.getElementById("category_id").value;
    var check = $("#get_subcategory_list_code").val(); // get sub cageory list;
    var checkInputs = true;
  
    if (checkInputs == true) {
      //LoadElement("#results");
      $(".loading-div").show();
      $.ajax({
        url: HOST_NAME + "admin/crawler-sources/",
        type: "POST",
        data: {
          c: cat_id,
          sc: 0,
          check: check,
          _csrf: $("#_csrf").val(),
        },
        dataType: "json",
        success: function (result) {
          UnLoadElement("#results");
          $(".loading-div").hide();
          console.log(result.html);
          $("#sub_category_id").html(result.html).selectpicker("refresh");
          //loadData();
        },
        error: function (xhr, textStatus, errorThrown) {
          toastr["error"]("خطا در انجام عملیات");
          //UnLoadElement("#results");
          $(".loading-div").hide();
        },
      });
    }
  }


  registerFormValidation = $("#formCrawlerItems").validate({
    rules: {

      subject_id: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
      },
      category_id: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
      },
      site_name: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
      },
      crawler: {
        required: true,
        noHtmlTag: true,
        noHtmlTag: true,
        maxlength: 200,
      },
      source_name: {
        required: true,
        noHtmlTag: true,
        justPersian: true,
      },
      source_link: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
      },
      item_link: {
        required: true,
        noHtmlTag: true,
        maxlength: 300,
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

  $("#results").load(HOST_NAME + "admin/crawler-items/", {
    cmd:  $("#listing_code").val(),//LISTING_CODE,
    _csrf: $("#_csrf").val(),
    subject_id: $("#selected_subject_id").val(),
    source_id: $("#selected_source_id").val()
  }); //load initial records

  //executes code below when user click on pagination links
  $("#results").on("click", ".pagination a", function (e) {
    e.preventDefault();
    $(".loading-div").show(); //show loading element
    var page = $(this).attr("data-page"); //get page number from link
    $("#txtpagenumber").val(page);
    var order = document.getElementById("cmbsort").value;
    var perpage = document.getElementById("cmbnumberPage").value;
    var subject_filter =  $("#selected_subject_id").val();
    
    $("#results").load(
      HOST_NAME + "admin/crawler-items/",
      {
        page: page,
        order: order,
        perpage: perpage,
        subject_id:subject_filter,
        source_id: $("#selected_source_id").val(),
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
  var subject_filter =  $("#selected_subject_id").val();
  $("#results").load(
    HOST_NAME + "admin/crawler-items/",
    {
      _csrf: $("#_csrf").val(),
      page: page,
      order: order,
      perpage: perpage,
      source_id:subject_filter,
      source_id: $("#selected_source_id").val(),
      cmd: $("#listing_code").val(),// LISTING_CODE,
    },
    function () {
      $(".loading-div").hide(); //once done, hide loading element
    }
  );
}

function deleteData(id) {
  var check = $("#delete_code").val();//DELETE_CODE;
  var subject_id=  $("#selected_subject_id").val();
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
          url: HOST_NAME + "admin/crawler-items/",
          type: "POST",
          data: {
            obj: id,
            subject_id:subject_id,
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
  var subject_id=  $("#selected_subject_id").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/crawler-items/",
    data: "obj=" + id +"&subject_id=" + subject_id + "&check=" + EDIT_CODE + "&_csrf=" + _csrf,
    dataType: "json",
    cache: false,
    success: function (result) {
      document.getElementById("save").name = "update";
      document.getElementById("save").value = "ویرایش";
      document.getElementById("hashId").value = id;
      // document.getElementById("category_type").value = result.category_type;
      document.getElementById("category_id").value = result.category_id;
      //document.getElementById("selected_subject_id").value = result.subject_id;
      document.getElementById("sub_category_id").value = result.sub_category_id;
      // document.getElementById("site_name").value = result.site_name;
      document.getElementById("crawler").value = result.crawler;
      document.getElementById("source_name").value = result.source_name;
      document.getElementById("source_link").value = result.source_link;
      document.getElementById("item_link").value = result.item_link;
      // document.getElementById("photo_address").value = result.photo_address;
      // $("#uploadImage").attr("src", HOST_NAME + result.photo_address);
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
  // $("#category_type").val("");
  $("#category_id").val("");
  $("#sub_category_id").val("");
  // $("#site_name").val("");
  $("#crawler").val("");
  $("#source_name").val("");
  $("#source_link").val("");
  $("#item_link").val("");
  $("#status").prop("checked", false);
  //$("#uploadImage").attr("src", "");
  //$("#photo_address").val("");
}

function activate(id) {
  var _html = '<img  src="' + HOST_NAME + 'resources/images/loading-spinner-blue.gif" />';
  $("#status_" + id).html(_html);
  var _csrf = $("#_csrf").val();
  var subject_id=  $("#selected_subject_id").val();
  let ACTIVATE_CODE =$("#activate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/crawler-items/",
    data: "obj=" + id +"&subject_id=" + subject_id + "&check=" + ACTIVATE_CODE + "&_csrf=" + _csrf,
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
  var subject_id=  $("#selected_subject_id").val();
  let DEACTIVATE_CODE =$("#deactivate_code").val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "admin/crawler-items/",
    data: "obj=" + id +"&subject_id=" + subject_id + "&check=" + DEACTIVATE_CODE + "&_csrf=" + _csrf,
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
    data["category_type"] = $("#category_type").val();
    data["subject_id"] = $("#selected_subject_id").val();
    data["source_id"] = $("#selected_source_id").val();
    data["category_id"] = $("#category_id").val();
    data["sub_category_id"] = $("#sub_category_id").val(); // CKEDITOR.instances["description"].getData();
    data["site_name"] = $("#site_name").val();
    data["crawler"] = $("#crawler").val();
    data["source_name"] = $("#source_name").val();
    data["source_link"] = $("#source_link").val();
    data["item_link"] = $("#item_link").val();
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
    formData.append("category_type", data["category_type"]);
    formData.append("subject_id", data["subject_id"]);
    formData.append("source_id", data["source_id"]);
    formData.append("category_id", data["category_id"]);
    formData.append("sub_category_id", data["sub_category_id"]);
    formData.append("site_name", data["site_name"]);
    formData.append("status", data["status"]);
    formData.append("crawler", data["crawler"]);
    formData.append("source_name", data["source_name"]);
    formData.append("author_id", data["author_id"]);
    formData.append("source_link", data["source_link"]);
    formData.append("item_link", data["item_link"]);
    formData.append("check", data["check"]);

    LoadElement(".modal-dialog");
    $.ajax({
      type: "post",
      url: HOST_NAME + "admin/crawler-items/",
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
  // $("#category_type").val("");
  $("#category_id").val("");
  $("#sub_category_id").val("");
  //CKEDITOR.instances["description"].setData("");
  $("#site_name").val("");
  $("#crawler").val("");
  $("#source_name").val("");
  $("#source_link").val("");
  $("#item_link").val("");
  $("#status").prop("checked", false);
}

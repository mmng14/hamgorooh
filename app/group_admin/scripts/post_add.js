$(document).ready(function () {
    $("#menu_post_management").addClass("active");
    //$('#menu_menu_post_management > ul').show();
    //$('#menu_menu_post_management_add').addClass('active');
  
    $("#upload").change(function (evt) {
      LoadElement("#divPostForm");
      var files = evt.target.files;
      var file = files[0];
  
      if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("postImage").src = e.target.result;
        };
        reader.readAsDataURL(file);
        setTimeout(function () {
          ResizeImage(file, "photo_data");
        }, 200);
        UnLoadElement("#divPostForm");
      }
    });
  
    $("#category_id").change(function () {
      getSubCategories();
      //loadData();
    });

    $("#upload_image").change(function (evt) {
      LoadElement(".upload-photo-item");
      var files = evt.target.files;
      var file = files[0];
  
      if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
          document.getElementById("uploadedImage").src = e.target.result;
        };
        reader.readAsDataURL(file);
  
        setTimeout(function () {
          ResizeImage(file, "image_data");
        }, 200);
  
        setTimeout(function () {
          uploadImageToServer();
        }, 500);
      }
    });
  
    registerPostValidation = $("#add_post_form").validate({
      rules: {
        title: {
          required: true,
          noHtmlTag: true,
          maxlength: 300,
        },
        keywords: {
          required: true,
          noHtmlTag: true,
          digits: true,
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
  
    $("#keywords").tagsinput({
      confirmKeys: [13, 44, 45],
      tagClass: "label label-danger",
    });
  
    // Enable CKEditor in all environments except IE7 and below.
    if (!CKEDITOR.env.ie || CKEDITOR.env.version > 7)
      CKEDITOR.env.isCompatible = true;
  
    $(window).focus(function () {
      //----
    });
  });
  
  $(document).on("click", ".cke_button__image", function () {
    console.log("image clicked");
    setUploadFolder();
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
        url: HOST_NAME + "group_admin/post_add/",
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
  

  function setUploadFolder() {
    LoadElement("#divPostForm");
    var subject_id = $("#subject_id").val();
    var uploadFolder = $("#_upload_folder").val();
    $.ajax({
      type: "POST",
      url: HOST_NAME + "group_admin/post_add/",
      data:
        "s_id=" +
        subject_id +
        "&upload_folder=" +
        uploadFolder +
        "&check=" + $("#set_upload_folder_code").val(),//   SET_UPLOAD_FOLDER_CODE,
      dataType: "json",
      cache: false,
      success: function (result) {
        UnLoadElement("#divPostForm");
        console.log(result);
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log("we have a problem :(");
        UnLoadElement("#divPostForm");
      },
    });
  }
  
  function uploadImageToServer() {
    //AJAX CALL Save image and get result
    var _csrf = $("#_csrf").val();
    var subject_id = $("#subject_id").val();
    var category_id = $("#category_id").val();
    var uploadFolder = $("#_upload_folder").val();
    var check = $("#post_image_upload_code").val();// POST_IMAGE_UPLOAD_CODE;
    let file = document.getElementById("upload_image").files[0];
  
    let formData = new FormData();
  
    formData.append("upload", file);
    formData.append("_csrf", _csrf);
    formData.append("upload_folder", uploadFolder);
    formData.append("s_id", subject_id);
    formData.append("c_id", category_id);
    formData.append("check", check);
  
    $.ajax({
      type: "POST",
      url: HOST_NAME + "group_admin/post_add/",
      data: formData,
      dataType: "json",
      contentType: false,
      processData: false,
      cache: false,
      success: function (result) {
        UnLoadElement(".upload-photo-item");
        var savedImageAddress = result.image_address;
        CKEDITOR.instances["description"].insertHtml(
          '<img src="' + savedImageAddress + '">'
        );
        console.log(result);
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log(errorThrown);
        console.log("we have a problem :(");
        UnLoadElement(".upload-photo-item");
      },
    });
  }
  
  function secondValidation() {
    var title = $("#title").val();
    var keywords = $("#keywords").val();
    var brief_desc = $("#brief_description").val();
    var description = CKEDITOR.instances["description"].getData();
  
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
      toastr["error"](messagesArr.join("<br>"));
      return false;
    } else {
      return true;
    }
  }
  
  function sendingData() {
    let validate = secondValidation();
    if (validate) {
      var data = {};
      data["_csrf"] = $("#_csrf").val();
      data["_upload_folder"] = $("#_upload_folder").val();
      data["post_id"] = $("#post_id").val();
      data["hashId"] = $("#_hashId").val();
      data["subject_id"] = $("#subject_id").val();
      data["category_id"] = $("#category_id").val();
      data["page_num"] = $("#page_num").val();
      data["sub_category_id"] = $("#sub_category_id").val();
      data["title"] = $("#title").val();
      data["keywords"] = $("#keywords").val();
      data["brief_description"] = $("#brief_description").val();
  
      let rawStr = CKEDITOR.instances["description"].getData();
      data["description"] = rawStr.replace(
        /[\u00A0-\u9999<>\&]/gim,
        function (i) {
          return "&#" + i.charCodeAt(0) + ";";
        }
      );
      var encodedString = btoa(data["description"]);
      data["description"] = encodedString;
  
      //data["description"]= CKEDITOR.instances["description"].getData();
      data["source_name"] = $("#source_name").val();
      data["source_link"] = $("#source_link").val();

      data["post_type"] = $("#post_type").val();
      data["post_status"] = $("#post_status").val();
      data["parent_id"] = $("#parent_id").val();
      data["comment_status"] = $("#comment_status").val();
      data["has_attachment"] = $("#has_attachment").val();

      data["photo_address"] = $("#photo_address").val();
      if (data["hashId"] !== null && data["hashId"] !== "") {
        //Update
        data["check"] = $("#update_code").val();//UPDATE_CODE;
      } else {
        data["check"] = $("#insert_code").val();// INSERT_CODE; //Add
      }
  
      let file = document.getElementById("upload").files[0];
      let photo_data = $("#photo_data").val();
  
      let formData = new FormData();
      formData.append("upload", file);
      formData.append("_csrf", data["_csrf"]);
      formData.append("_upload_folder", data["_upload_folder"]);
      formData.append("hashId", data["hashId"]);
      formData.append("subject_id", data["subject_id"]);
      formData.append("category_id", data["category_id"]);
      formData.append("page_num", data["page_num"]);
      formData.append("sub_category_id", data["sub_category_id"]);
      formData.append("title", data["title"]);
      formData.append("keywords", data["keywords"]);
      formData.append("brief_description", data["brief_description"]);
      formData.append("description", data["description"]);
      formData.append("source_name", data["source_name"]);
      formData.append("source_link", data["source_link"]);

      formData.append("post_type", data["post_type"]);
      formData.append("post_status", data["post_status"]);
      formData.append("parent_id", data["parent_id"]);
      formData.append("comment_status", data["comment_status"]);
      formData.append("has_attachment", data["has_attachment"]);

      formData.append("photo_address", data["photo_address"]);
      formData.append("check", data["check"]);
  
      LoadElement("#divPostForm");
  
      $.ajax({
        type: "post",
        url: HOST_NAME + "group_admin/post_add/",
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
          UnLoadElement("#divPostForm");
          if (response.status === "1") {
            toastr["success"](response.message);
            console.log(response);
            clearForm();
            window.location.replace(response.redirect);
          } else {
            toastr["error"](response.message);
          }
        },
        error: function (error) {
          UnLoadElement("#divPostForm");
          console.log(error);
          toastr["error"]("خطا در ارسال اطلاعات");
        },
      });
    }
  }
  
  function clearForm() {
    $("#add_update").name = "add";
    $("#form_title").html("فرم افزودن پست");
    $("#post_id").val("");
    $("#keywords").val("");
    $("#title").val("");
    $("#brief_description").val("");
    CKEDITOR.instances["description"].setData("");
    $("#source_name").val("");
    $("#post_type").val("");
    $("#source_link").val("");
    $("#has_attachment").val("");
    $("#comment_status").val("");
    $("#parent_id").val("0");
    $("#post_status").val("");
  }
  
  function loadPhotoList() {
    //AJAX CALL Save image and get result
    var _csrf = $("#_csrf").val();
    var subject_id = $("#subject_id").val();
    var category_id = $("#category_id").val();
    var check = $('#post_image_list_code').val();
    var pageNumber = $("#photoListPageNumber").val();
  
    LoadElement(".choose-from-my-photo");
    $.ajax({
      type: "POST",
      url: HOST_NAME + "group_admin/post_add/",
      data: {
        s_id: subject_id,
        cf: category_id,
        exp: "",
        page: pageNumber,
        perpage: 9,
        _csrf: _csrf,
        check: check,
      },
      dataType: "json",
      cache: false,
      success: function (result) {
        UnLoadElement(".choose-from-my-photo");
        if (result.status === "1") {
          if (pageNumber === 1) {
            $("#photoListContainer").html(result.html);
          } else {
            $("#photoListContainer").append(result.html);
          }
          $("#photoListPageNumber").val(result.page_number);
        } else {
          toastr["error"]("خطایی رخ داده است");
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log(errorThrown);
        console.log("we have a problem :(");
        UnLoadElement(".choose-from-my-photo");
      },
    });
  }
  
  function selectFromPhotoList(id) {
    var thumnImageAddress = $(".choose-photo-item #img_" + id).attr("src");
    var mainImageAddress = $(".choose-photo-item #photo_" + id).val();
    if (mainImageAddress != undefined && mainImageAddress != "") {
      CKEDITOR.instances["description"].insertHtml(
        '<img src="' + mainImageAddress + '">'
      );
      toastr["success"]("تصویر با موفقیت در داخل متن قرار گرفت");
    }
  }
  
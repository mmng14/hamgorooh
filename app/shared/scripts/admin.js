$(document).ready(function () {
  //   setTimeout(function () {
  //     getUnvisitedNotificationsCount();
  //   }, 5000);



  getAllGroups();

  var intervalId = window.setInterval(function () {
    getUnvisitedNotificationsCount();
  }, 100000);

  //setTimeout(function() { getNewOpCodes(); }, 2000);
  //toastr config
  toastr.options = {
    closeButton: true,
    debug: false,
    rtl: false,
    newestOnTop: false,
    progressBar: false,
    positionClass: "toast-top-full-width",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "3000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
  };
});



$(function () {
  $("#show_notifications").hover(
    function () {
        getNotifications();

      $("#notifications_list").show();
    },
    function () {
      $("#notifications_list").hide();
    }
  );

  $('li.show-notifications').click(function(e) 
    { 
      getNotifications();
    });
});


function ConvertElementToSelect2(options, searchSelector) {

  var setting = $.extend({
      selector: ".select2",
      urlAddress: "",
      placeHolder: "انتخاب نمایید",
      pageSize: 10,
      closeOnSelect: true,
      minimumLength: 0
  }, options);


  $(setting.selector).select2({
      
      ajax: {
          url: setting.urlAddress,
          dataType: 'jsonp',
          delay: 250,
          data: function (params) {
              //Static Search Parametrs For Select@
              var result = {
                  searchTerm: params.term, // search term
                  pageNum: params.page, // page number
                  pageSize: setting.pageSize // page size
              };
              //Add Dynamic User Search Parametr 
              for (var key in searchSelector)
                  result[key] = $(searchSelector[key]).val();

              return result;
          },
          processResults: function (data, params) {

              params.page = params.page || 1;

              return {
                  results: data.Results,
                  pagination: {
                      more: (params.page * setting.pageSize) < data.Total
                  }
              };
          },
          cache: true
      },

      allowClear: true,

      placeholder: setting.placeHolder,

      closeOnSelect: setting.closeOnSelect,

      minimumInputLength: setting.minimumLength,

      formatInputTooShort: function () {
          return " حداقل 1 کاراکتر وارد نمایید";
      },
      formatLoadMore: function () {
          return "نمایش داده های بیشتر...";
      },
      formatNoMatches: function () {
          return "هیچ داده ای یافت نشد";
      },
      width: "100%",
      theme: "bootstrap",
      dir: "rtl"
  });
}

function ConvertElementToSelect2WithCounter(options, searchSelector) {

  var setting = $.extend({
      selector: ".select2",
      urlAddress: "",
      placeHolder: "انتخاب نمایید",
      pageSize: 10,
      closeOnSelect: true,
      minimumLength: 0
  }, options);

  $(setting.selector).select2({
      ajax: {
          url: setting.urlAddress,
          dataType: 'jsonp',
          delay: 250,
          data: function (params) {
              //Static Search Parametrs For Select@
              var result = {
                  searchTerm: params.term, // search term
                  pageNum: params.page, // page number
                  pageSize: setting.pageSize // page size
              };
              //Add Dynamic User Search Parametr 
              for (var key in searchSelector)
                  result[key] = $(searchSelector[key]).val();

              return result;
          },
          processResults: function (data, params) {

              params.page = params.page || 1;

              return {
                  results: data.Results,
                  pagination: {
                      more: (params.page * setting.pageSize) < data.Total
                  }
              };
          },
          cache: true
      },

      allowClear: true,

      placeholder: setting.placeHolder,

      closeOnSelect: setting.closeOnSelect,

      minimumInputLength: setting.minimumLength,

      formatInputTooShort: function () {
          return " حداقل 1 کاراکتر وارد نمایید";
      },
      formatLoadMore: function () {
          return "نمایش داده های بیشتر...";
      },
      formatNoMatches: function () {
          return "هیچ داده ای یافت نشد";
      },
      width: "100%",
      theme: "bootstrap",
      dir: "rtl"
  });

  $('.select2-search__field').attr('style', '');

  $(setting.selector).on('select2:close', function (evt) {

      $(this).siblings('span.select2').find('ul .select2-selection__choice').remove();
      $(this).siblings('span.select2').find('ul .select2-count').remove();
      var count = $(this).select2('data').length;
      if (count != 0)
          $(this).siblings('span.select2').find('ul').prepend("<li class='select2-count'>" + count + " - " + "مورد انتخاب شده !</li>");

  });
}

function ConvertElementToSelect2StaticWithCounter(options) {

  var setting = $.extend({
      selector: ".select2",
      placeHolder: "انتخاب نمایید",
      closeOnSelect: true,
      minimumLength: 0
  }, options);

  $(setting.selector).select2({

      allowClear: true,

      placeholder: setting.placeHolder,

      closeOnSelect: setting.closeOnSelect,

      formatInputTooShort: function () {
          return " حداقل 1 کاراکتر وارد نمایید";
      },
      formatLoadMore: function () {
          return "نمایش داده های بیشتر...";
      },
      formatNoMatches: function () {
          return "هیچ داده ای یافت نشد";
      },
      width: "100%",
      theme: "bootstrap",
      dir: "rtl"
  });

  $('.select2-search__field').attr('style', '');

  $(setting.selector).on('select2:close', function (evt) {

      $(this).siblings('span.select2').find('ul .select2-selection__choice').remove();
      $(this).siblings('span.select2').find('ul .select2-count').remove();
      var count = $(this).select2('data').length;
      if (count != 0)
          $(this).siblings('span.select2').find('ul').prepend("<li class='select2-count'>" + count + " - " + "مورد انتخاب شده !</li>");

  });
}

function LoadElement(pSelector) {
  $(pSelector).block({
    message:
      '<i class="fas fa-circle-notch fa-spin fa-3x fa-fw" style="color:#FF763A"></i><span class="text-semibold display-block">   </span>',
    overlayCSS: {
      backgroundColor: "#fff",
      opacity: 0.8,
      cursor: "wait",
    },
    css: {
      border: 0,
      padding: 0,
      backgroundColor: "transparent",
    },
  });
}

function UnLoadElement(pSelector) {
  $(pSelector).unblock();
}

function SetParentHeight() {
  window.parent.postMessage(
    '{"funcName":"ResizeIframe","parameters": "' +
      document.body.scrollHeight +
      '"}',
    "*"
  );
}

function ResizeImage(file, ctrlName) {
  if (window.File && window.FileReader && window.FileList && window.Blob) {
    //var filesToUploads = document.getElementById('PhotoAddress').files;
    //var file = filesToUploads[0];
    if (file) {
      var reader = new FileReader();
      // Set the image once loaded into file reader
      reader.onload = function (e) {
        var img = document.createElement("img");
        img.src = e.target.result;

        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);

        var MAX_WIDTH = 1600;
        var MAX_HEIGHT = 1200;
        var width = img.width;
        var height = img.height;

        if (width > height) {
          if (width > MAX_WIDTH) {
            height *= MAX_WIDTH / width;
            width = MAX_WIDTH;
          }
        } else {
          if (height > MAX_HEIGHT) {
            width *= MAX_HEIGHT / height;
            height = MAX_HEIGHT;
          }
        }

        canvas.width = width;
        canvas.height = height;

        ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, width, height);

        dataurl = canvas.toDataURL(file.type);

        $("#" + ctrlName).val(dataurl);

        console.log(dataurl);
        //uploadPhoto(dataurl);
      };

      reader.readAsDataURL(file);
    }
  } else {
    alert("The File APIs are not fully supported in this browser.");
  }
}

function getNewOpCodesX() {
  $.ajax({
    url: HOST_NAME + "shared/opcode/",
    type: "post",
    data: {
      check: "GET_ADMIN_OP_CODES",
      code: "GET_ADMIN_OP_CODES",
    },
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (response) {
      if (response.status === "1") {
        console.log("ok");
        $("#insert_code").val(response.insert_code);
        $("#update_code").val(response.update_code);
        $("#delete_code").val(response.delete_code);
        $("#multi_delete_code").val(response.multi_delete_code);
        $("#activate_code").val(response.activate_code);
        $("#deactivate_code").val(response.deactivate_code);
        $("#activate_topmenu_code").val(response.activate_topmenu_code);
        $("#deactivate_topmenu_code").val(response.deactivate_topmenu_code);
        $("#activate_payment_code").val(response.activate_payment_code);
        $("#deactivate_payment_code").val(response.deactivate_payment_code);
        $("#customize_code").val(response.customize_code);
        $("#uncustomize_code").val(response.uncustomize_code);
        $("#get_date_and_price_code").val(response.get_date_and_price_code);
        $("#get_price_code").val(response.get_price_code);
        $("#send_to_subjects_code").val(response.send_to_subjects_code);
        $("#update_to_subjects_code").val(response.update_to_subjects_code);
        $("#delete_to_subjects_code").val(response.delete_to_subjects_code);
        $("#send_to_all_subjects_code").val(response.send_to_all_subjects_code);
        $("#edit_code").val(response.edit_code);
        $("#set_upload_folder_code").val(response.set_upload_folder_code);
        $("#send_to_telegram_code").val(response.send_to_telegram_code);
        $("#send_to_reportage_code").val(response.send_to_reportage_code);
        $("#set_group_access_code").val(response.set_group_access_code);
        $("#set_category_code").val(response.set_category_code);
        $("#set_user_type_code").val(response.set_user_type_code);
        $("#password_change_code").val(response.password_change_code);
        $("#get_category_list_code").val(response.get_category_list_code);
        $("#get_subcategory_list_code").val(response.get_subcategory_list_code);
        $("#get_city_list_code").val(response.get_city_list_code);
        $("#listing_code").val(response.listing_code);
        $("#accept_request_code").val(response.accept_request_code);
        $("#reject_request_code").val(response.reject_request_code);
        $("#post_image_upload_code").val(response.post_image_upload_code);
        $("#post_image_list_code").val(response.post_image_list_code);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      console.log("error");
    },
  });
}

function getNewOpCodes() {
  var check = "GET_ADMIN_OP_CODES";
  let formData = new FormData();

  formData.append("check", check);

  $.ajax({
    type: "POST",
    url: HOST_NAME + "shared/opcode/",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    cache: false,
    success: function (response) {
      if (response.status === "1") {
        console.log("ok");
        $("#insert_code").val(response.insert_code);
        $("#update_code").val(response.update_code);
        $("#delete_code").val(response.delete_code);
        $("#multi_delete_code").val(response.multi_delete_code);
        $("#activate_code").val(response.activate_code);
        $("#deactivate_code").val(response.deactivate_code);
        $("#activate_topmenu_code").val(response.activate_topmenu_code);
        $("#deactivate_topmenu_code").val(response.deactivate_topmenu_code);
        $("#activate_payment_code").val(response.activate_payment_code);
        $("#deactivate_payment_code").val(response.deactivate_payment_code);
        $("#customize_code").val(response.customize_code);
        $("#uncustomize_code").val(response.uncustomize_code);
        $("#get_date_and_price_code").val(response.get_date_and_price_code);
        $("#get_price_code").val(response.get_price_code);
        $("#send_to_subjects_code").val(response.send_to_subjects_code);
        $("#update_to_subjects_code").val(response.update_to_subjects_code);
        $("#delete_to_subjects_code").val(response.delete_to_subjects_code);
        $("#send_to_all_subjects_code").val(response.send_to_all_subjects_code);
        $("#edit_code").val(response.edit_code);
        $("#set_upload_folder_code").val(response.set_upload_folder_code);
        $("#send_to_telegram_code").val(response.send_to_telegram_code);
        $("#send_to_reportage_code").val(response.send_to_reportage_code);
        $("#set_group_access_code").val(response.set_group_access_code);
        $("#set_category_code").val(response.set_category_code);
        $("#set_user_type_code").val(response.set_user_type_code);
        $("#password_change_code").val(response.password_change_code);
        $("#get_category_list_code").val(response.get_category_list_code);
        $("#get_subcategory_list_code").val(response.get_subcategory_list_code);
        $("#get_city_list_code").val(response.get_city_list_code);
        $("#listing_code").val(response.listing_code);
        $("#accept_request_code").val(response.accept_request_code);
        $("#reject_request_code").val(response.reject_request_code);
        $("#post_image_upload_code").val(response.post_image_upload_code);
        $("#post_image_list_code").val(response.post_image_list_code);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
}

function goToURL(elem) {
  var href = $(elem).attr("href");
  console.log($(elem), href);
  window.location = href;
}

function getNotifications() {
  let notification_type = 0; //all notif types
  let check = $("#notifications_list_op_code").val();
  LoadElement('.notifications-result-list');

  $.ajax({
    type: "POST",
    async: true,
    dataType: "json",
    data: "notification_type=" + notification_type + "&check=" + check,
    url: HOST_NAME + "shared/notifications/",
    cache: false,
    success: function (result) {
      console.log(result);
      $(".notifications-result-list").html(result.html);
      $(".notifications-result-list").fadeIn(500);
      UnLoadElement('.notifications-result-list');
    },
  });
}

function getUnvisitedNotificationsCount() {
  let notification_type = 0; //all notif types
  let check = $("#notifications_count_op_code").val();
  $.ajax({
    type: "POST",
    dataType: "json",
    async: true,
    data: "notification_type=" + notification_type + "&check=" + check,
    url: HOST_NAME + "shared/notifications/",
    cache: false,
    success: function (result) {
      console.log(result);
      console.log(result);
      if (result.result == "1") {
        console.log(result.result);
      }
      $(".totoal-unvisited-notifications").html(result.total_rows);
      //$('#totoal_unvisited_notifications').html(result.total_rows);
    },
  });
}


function getAllGroups() {
  let check = $('#listing_code').val();
  let page=1;
  let pageSize=6;
  let searchExp = "";
  LoadElement('.notification-list');

  $.ajax({
    type: "POST",
    async: true,
    dataType: "json",
    data: "page=" + page + "&perpage=" + pageSize+ "&searchExp=" + searchExp + "&check=" + check,
    url: HOST_NAME + "shared/groups/",
    cache: false,
    success: function (result) {
      console.log(result);
     
      var e = $(".js-user-search");
      e.length &&
        e.selectize({
          delimiter: ",",
          persist: !1,
          maxItems: 2,
          valueField: "name",
          labelField: "name",
          searchField: ["name"],
          options:result.list,
          render: {
            option: function (e, i) {
              return (
                '<div class="inline-items">' +
                (e.image
                  ? '<div class="author-thumb"><img src="' +
                    i(e.image) +
                    '" alt="avatar" width="45"></div>'
                  : "") +
                '<div class="notification-event">' +
                (e.name
                  ? '<a href=' + i(e.link) + '"><span class="h6 notification-friend"></a>' +
                    i(e.name) +
                    " - </span>"
                  : "") +
                (e.message
                  ? '<span class="chat-message-item">' + i(e.message) + "</span>"
                  : "") +
                "</div>" +
                (e.icon
                  ? '<span class="notification-icon"><svg class="' +
                    i(e.icon) +
                    '"><use xlink:href="icons/icons.svg#' +
                    i(e.icon) +
                    '"></use></svg></span>'
                  : "") +
                "</div>"
              );
            },
            item: function (e, i) {
              return '<div><span class="label">' + i(e.name) + "</span></div>";
            },
          },
        });

      UnLoadElement('.notification-list');
    },
  });
}


// [
//   {
//     image: "img/avatar30-sm.jpg",
//     name: "Marie Claire Stevens",
//     message: "12 Friends in Common",
//     icon: "olymp-happy-face-icon",
//   },
//   {
//     image: "img/avatar54-sm.jpg",
//     name: "Marie Davidson",
//     message: "4 Friends in Common",
//     icon: "olymp-happy-face-icon",
//   },
//   {
//     image: "img/avatar49-sm.jpg",
//     name: "Marina Polson",
//     message: "Mutual Friend: Mathilda Brinker",
//     icon: "olymp-happy-face-icon",
//   },
//   {
//     image: "img/avatar36-sm.jpg",
//     name: "Ann Marie Gibson",
//     message: "New York, NY",
//     icon: "olymp-happy-face-icon",
//   },
//   {
//     image: "img/avatar22-sm.jpg",
//     name: "Dave Marinara",
//     message: "8 Friends in Common",
//     icon: "olymp-happy-face-icon",
//   },
//   {
//     image: "img/avatar41-sm.jpg",
//     name: "The Marina Bar",
//     message: "Restaurant / Bar",
//     icon: "olymp-star-icon",
//   },
// ]
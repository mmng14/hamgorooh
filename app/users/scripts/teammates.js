$(document).ready(function () {
  $("#menu_user_messages").addClass("active");

  $("#sendMessage").click(function (event) {
    event.preventDefault();
   
    sendMessage();
  });

  $("#load_more").click(function (event) {
    event.preventDefault();
    var pageNumber  = $('#page_number').val();
   
    loadMessages(parseInt(pageNumber));
  });

  //loadMessages(1);
});

function prepareChatForm(userId){
  $("#selected_friend_id").val(userId);
}

function loadMessages(page) {
  LoadElement("#chatMessages");
  var selectedFriendId = $('#selected_friend_id').val();
  $.ajax({
    type: "POST",
    url: HOST_NAME + "users/user_messages/",
    data: {
      page: page,
      friend_id:selectedFriendId,
      subject_id: $("#selected_subject_id").val(),
      cmd: $("#listing_code").val(),
      _csrf: $("#_csrf").val(),
    },
    dataType: "json",
    cache: false,
    success: function (result) {
      
      if (result.status == "1") {

        if (page == 1) {
          $("#chatMessages").html(result.html);
          console.log(result.last_seen_message_id);
        } else {
          $("#chatMessages").prepend(result.html);
        }

        page++;

        $('#page_number').val(page);
        $('.mCustomScrollbar ').scrollTop($('.mCustomScrollbar ')[0].scrollHeight);
       
        //toastr["success"](result.message);

      } else {
        toastr["warning"](result.message);
      }
      UnLoadElement("#chatMessages");
    },
    error: function (error) {
      UnLoadElement("#chatMessages");
      toastr["error"]("خطا در ارسال اطلاعات");
    },
  });
}

function sendMessage() {
  var _csrf = $("#_csrf").val();
  var selectedFriendId = $('#selected_friend_id').val();
  LoadElement("#userMessageDiv");
  $.ajax({
    type: "POST",
    url: HOST_NAME + "users/user_messages/",
    data: {
      subject_id: $("#selected_subject_id").val(),
      friend_id:selectedFriendId,
      message: $("#userMessage").val(),
      check: $("#insert_code").val(),
      _csrf: _csrf,
    },
    dataType: "json",
    cache: false,
    success: function (result) {
      UnLoadElement("#userMessageDiv");
      if (result.status == "1") {
        $("#chatMessages").append(result.html);
        $('.mCustomScrollbar ').scrollTop($('.mCustomScrollbar ')[0].scrollHeight);
        
        loadMessages(1);
        
        $("#userMessage").val('');
        //toastr["success"](result.message);
      } else {
        toastr["error"](result.message);
      }
    },
    error: function (error) {
      UnLoadElement("#userMessageDiv");
      toastr["error"]("خطا در ارسال اطلاعات");
    },
  });
}

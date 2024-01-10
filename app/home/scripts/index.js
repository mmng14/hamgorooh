$(document).ready(function () {
  loginFormValidation = $("#frmLogin").validate({
    rules: {
      username: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },

      userpass: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },
    },
    submitHandler: function () {
      loginHome();
    },
  });

  registrationFormValidation = $("#registationForm").validate({
    rules: {
      first_name: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },
      last_name: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },
      email: {
        required: true,
        email: true,
        maxlength: 200,
      },

      password: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },

      password_repeat: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },
      gender: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },
      acceptRulesOfSite: {
        required: true,
        noHtmlTag: true,
        maxlength: 100,
      },
    },
    submitHandler: function () {
        registerHome();
    },
  });

  $("#loginButton").click(function (e) {
    e.preventDefault();
    $("#frmLogin").submit();
    //loginHome();
  });

  $("#registerButton").click(function (e) {
    e.preventDefault();
    $("#registationForm").submit();
    //registerHome();
  });

  $("#sendRecoverPasswordCode").click(function (e) {
    e.preventDefault();
    sendRecoverPasswordCode();
  });

  $("#recoverPassword").click(function (e) {
    e.preventDefault();
    recoverPassword();
  });

  

  $(".date-picker").persianDatepicker();
});
//---Refresh captcha code
function refresh_captcha() {
  src = $("#captcha_img").attr("src");
  // check for existing ? and remove if found
  queryPos = src.indexOf("?");
  if (queryPos != -1) {
    src = src.substring(0, queryPos);
  }
  $("#captcha_img").attr("src", src + "?cap=login.png&newId=" + Math.random());
  return false;
}

function loginHome() {
  let username = $("#username").val();
  let userpass = $("#userpass").val();
  let remember = $('#remember_me:checked').val();

  LoadElement(".registration-login-form");
  $.ajax({
    type: "POST",
    url: HOST_NAME + "signin/",
    data:
      "username=" + username + "&userpass=" + userpass+ "&remember=" + remember + "&check=" + LOGIN_CODE,
    dataType: "json",
    cache: false,
    success: function (result) {
      console.log(result);
      UnLoadElement(".registration-login-form");
      // $("#frmLogin")[0].reset();
      if (result.status == "1") {
        toastr["success"](result.message);
        window.location.replace(result.redirect);
      } else {
        toastr["error"](result.message);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement(".registration-login-form");
      toastr["error"]("خطا در ارسال داده ها");
    },
  });
}

function registerHome() {
  let formData = new FormData();

  let check = REGISTER_CODE;
  let firstName = $("#first_name").val();
  let lastName = $("#last_name").val();
  let email = $("#email").val();
  let birthDate = $("#birth_date").val();
  let gender = $("#gender").val();
  let genderText = $("#gender option:selected").text();
  let password = $("#password").val();
  let passwordRepeat = $("#password_repeat").val();

  //region Client_Validation
  if (firstName.length < 3) {
    let msg = "نام نباید کمتر از 3 حرف باشد ";
    toastr["error"](msg);
    return false;
  }
  if (lastName.length < 3) {
    let msg = "نام خانوادگی نباید کمتر از 3 حرف باشد ";
    toastr["error"](msg);
    return false;
  }
  if (gender == "") {
    let msg = " لطفا جنسیت را انتخاب نمایید ";
    toastr["error"](msg);
    return false;
  }
  if (password.length < 8) {
    let msg = "کلمه عبور نباید کمتر از 8 حرف باشد ";
    toastr["error"](msg);
    return false;
  }
  if (password != passwordRepeat) {
    let msg = " کلمه عبور و تکرار آن برابر نیستند ";
    toastr["error"](msg);
    return false;
  }
  if ($("#acceptRulesOfSite").prop("checked") != true) {
    let msg = " شما پذیرش قوانین و مقررات سایت را  فعال نکرده اید";
    toastr["error"](msg);
    return false;
  }
  //endregion Client_Validation

  formData.append("firstName", firstName);
  formData.append("lastName", lastName);
  formData.append("email", email);
  formData.append("password", password);
  formData.append("passwordRepeat", passwordRepeat);
  formData.append("birthDate", birthDate);
  formData.append("gender", gender);
  formData.append("check", check);

  console.log(formData);

  LoadElement(".registration-login-form");
  $.ajax({
    type: "post",
    url: HOST_NAME + "signup/",
    data: formData,
    dataType: "json",
    contentType: false,
    processData: false,
    success: function (response) {
      UnLoadElement(".registration-login-form");
      console.log(response);

      if (response.status === "1") {
        toastr["success"](response.message);
        clearRegistrationForm();
      } else {
        toastr["error"](response.message);
      }
    },
    error: function (error) {
      console.log(error);
      UnLoadElement(".registration-login-form");
      toastr["error"]("خطا در ارسال اطلاعات");
    },
  });
}

function sendRecoverPasswordCode() {
  let userEmail = $("#userEmail").val();

  LoadElement(".form-restore-password");
  $.ajax({
    type: "POST",
    url: HOST_NAME + "recoverPassword/",
    data:
      "userEmail=" + userEmail +  "&check=" + SEND_OTP_CODE,
    dataType: "json",
    cache: false,
    success: function (result) {
      console.log(result);
      UnLoadElement(".form-restore-password");
      if (result.status == "1") {
        toastr["success"](result.message);
      } else {
        toastr["error"](result.message);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement(".form-restore-password");
      toastr["error"]("خطا در ارسال داده ها");
    },
  });
}

function recoverPassword() {
  let userEmail = $("#userEmail").val();
  let verifyCode = $("#verifyCode").val();
  let newPassword = $("#newPassword").val();


  LoadElement(".form-restore-password");
  $.ajax({
    type: "POST",
    url: HOST_NAME + "recoverPassword/",
    data:
      "userEmail=" + userEmail +"&verifyCode=" + verifyCode +"&newPassword=" + newPassword +  "&check=" + RECOVER_PASSWORD_CODE,
    dataType: "json",
    cache: false,
    success: function (result) {
      console.log(result);
      UnLoadElement(".form-restore-password");
      if (result.status == "1") {
        toastr["success"](result.message);
        //Clear Form
        $("#userEmail").val('');
        $("#verifyCode").val('');
        $("#newPassword").val('');
        //Close modal
        $('#restore-password').modal('hide');
      } else {
        toastr["error"](result.message);
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      UnLoadElement(".form-restore-password");
      toastr["error"]("خطا در ارسال داده ها");
    },
  });
}

function clearRegistrationForm() {
  $("#first_name").val("");
  $("#last_name").val("");
  $("#email").val("");
  $("#birth_date").val("");
  $("#gender").val("");
  $("#gender option[value='']").attr("selected", "selected");
  $("#password").val("");
  $("#password_repeat").val("");
}

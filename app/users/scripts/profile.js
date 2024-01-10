$(document).ready(function () {

    $('#menu_profile').addClass('active');

    $(".date-picker").persianDatepicker();

    $(document).on('change', '#FileUpload', function () { uploadPhoto(); });
    $(document).on('click', '#btnChangePassword', function (e) { e.preventDefault(); changePassword(); });
    $(document).on('click', '#btnUpdateUserInfo', function (e) { e.preventDefault(); updateUserInfo(); });
});

function uploadPhoto() {

    let formData = new FormData();
    let check = $('#insert_code').val();// INSERT_CODE; //upload photo
    // var totalFiles = document.getElementById("FileUpload").files.length;
    // for (var i = 0; i < totalFiles; i++) {
    //     var file = document.getElementById("FileUpload").files[i];
    //     formData.append("FileUpload", file);
    //     formData.append("check", check);
    // }
    let file = document.getElementById("FileUpload").files[0];

    formData.append("FileUpload", file);
    formData.append("check", check);

    //$(".loading").show();
    LoadElement("#userThumbnail");
    $.ajax({
        type: 'post',
        url: HOST_NAME + "users/profile/",
        data: formData ,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            UnLoadElement("#userThumbnail");
            if (response.status === "1") {
                console.log(response.html);
                $('#user_photo').attr("src", response.html);
                $('#layout_user_photo_small').attr("src", response.html);
                $('#layout_user_photo').attr("src", response.html);

                toastr["success"](response.message);
            }
            else {
                toastr["error"](response.message);
            }
        },
        error: function (error) {
            UnLoadElement("#userThumbnail");
            toastr["error"]("خطا در ارسال اطلاعات");
            }
    });
}

function removePhoto() {

    //$(".loading").show();
    LoadElement("#userThumbnail");
    $.ajax({
        type: 'post',
        url: HOST_NAME + "users/profile/",
        data:"check=" + $('#delete_code').val(),// DELETE_CODE,//remove photo
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            UnLoadElement("#userThumbnail");
            //$(".loading").hide();
            if (response.status === "1") {
                console.log(response.html);
                $('#user_photo').attr("src", response.html);
                $('#FileUpload').val('');
            }
            else {

                toastr["error"](response.message);

            }
        },
        error: function (error) {
            //$(".loading").hide();
            UnLoadElement("#userThumbnail");
            $("#FileUpload").change(function () {
                uploadPhoto();
            });
            toastr["error"]("خطا در ارسال اطلاعات");
        }
    });
}

function changePassword() {
   
    let formData = new FormData();

    let check = $('#password_change_code').val();// PASSWORD_CHANGE_CODE;
    let currentPassword = $('#currentPassword').val();
    let newPassword =$('#newPassword').val();
    let repeatNewPassword =$('#repeatNewPassword').val();

    //region Client_Validation
    if(currentPassword === "")
    {
        let msg = "کلمه عبور فعلی وارد نشده است " ;
        toastr["error"](msg);
        return false;
    }
    if(newPassword.length < 6)
    {
       let msg = "کلمه عبور جدید نباید کمتر از 6 حرف باشد " ;
        toastr["error"](msg);
        return false;
    }
    if(newPassword !== repeatNewPassword)
    {
        let msg = "کلمه عبور جدید با تکرار آن برابر نیست " ;
        toastr["error"](msg);
        return false;
    }
    //endregion Client_Validation

    formData.append("currentPassword", currentPassword);
    formData.append("newPassword", newPassword);
    formData.append("repeatNewPassword", repeatNewPassword);
    formData.append("check", check);

    //$(".loading").show();
    LoadElement("#change_password");
    $.ajax({
        type: 'post',
        url: HOST_NAME + "users/profile/",
        data: formData ,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            UnLoadElement("#change_password");
            if (response.status === "1") {
                resetPasswordForm();
                toastr["success"](response.message);
            }
            else {
                toastr["error"](response.message);
            }
        },
        error: function (error) {
            UnLoadElement("#change_password");
            toastr["error"]("خطا در ارسال اطلاعات");
        }
    });
}

function updateUserInfo() {

    let formData = new FormData();

    let check = $('#update_code').val();//UPDATE_CODE;
    let firstName = $('#firstName').val();
    let lastName =$('#lastName').val();
    let phoneNumber =$('#phoneNumber').val();
    let birthDate = $('#birthDate').val();
    let gender =$('#gender').val();
    let genderText =  $("#gender option:selected").text();
    let address =$('#address').val();
    let notes =$('#notes').val();

    //region Client_Validation
    if(firstName.length < 3)
    {
        let msg = "نام نباید کمتر از 3 حرف باشد " ;
        toastr["error"](msg);
        return false;
    }
    if(lastName.length < 3)
    {
        let msg = "نام خانوادگی نباید کمتر از 3 حرف باشد " ;
        toastr["error"](msg);
        return false;
    }

    //endregion Client_Validation

    formData.append("firstName", firstName);
    formData.append("lastName", lastName);
    formData.append("phoneNumber", phoneNumber);
    formData.append("birthDate", birthDate);
    formData.append("gender", gender);
    formData.append("address", address);
    formData.append("notes", notes);
    formData.append("check", check);

    LoadElement("#edit_user_information");
    $.ajax({
        type: 'post',
        url: HOST_NAME + "users/profile/",
        data: formData ,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (response) {
            UnLoadElement("#edit_user_information");
            if (response.status === "1") {
                toastr["success"](response.message);
                //update page info
                $('#aFullName').html(firstName + ' ' + lastName);
                $('#hFullName').html(firstName + ' ' + lastName);
                $('#aPhone').html(phoneNumber);
                $('#aBirthDate').html(birthDate);
                $('#aGender').html(genderText);
                $('#aAddress').html(address);
                $('#pNotes').html(notes);
            }
            else {
                toastr["error"](response.message);
            }
        },
        error: function (error) {
            UnLoadElement("#edit_user_information");
            toastr["error"]("خطا در ارسال اطلاعات");
        }
    });
}

function resetPasswordForm(){
    $('#currentPassword').val('');
    $('#newPassword').val('');
    $('#repeatNewPassword').val('');
}


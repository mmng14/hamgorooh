$(document).ready(function () {

});
//---Refresh captcha code
function refresh_captcha(){
    src = $('#captcha_img').attr('src');
    // check for existing ? and remove if found
    queryPos = src.indexOf('?');
    if(queryPos != -1) {
        src = src.substring(0, queryPos);
    }
    $('#captcha_img').attr('src', src + '?cap=login.png&newId=' + Math.random());
    return false;
}

function loginHomeCaptcha(elem){

    let username = $('#username').val();
    let userpass = $('#userpass').val();
    let captcha = grecaptcha.getResponse();
    console.log(username + "," + userpass+"," + captcha) ;
    LoadElement(".top-user-form");
    $.ajax({
        type: "POST",
        url: HOST_NAME + "signin/",
        data: "username=" + username + "&userpass=" + userpass  + "&recaptcha-response=" + captcha + "&check=" + LOGIN_WITH_CAPTCHA_CODE,
        dataType: "json",
        cache: false,
        success: function (result) {
            UnLoadElement(".top-user-form");
            $("#message-form")[0].reset();
            if(result.status==="1") {
                toastr["success"](result.message);

            }
            if(result.status==="0" || result.status==="-1") {
                toastr["error"](result.message);
            }
            console.log(result);
        },
        error: function (xhr, textStatus, errorThrown) {
            UnLoadElement(".top-user-form");
            toastr["error"]("خطا در ارسال داده ها");

        },

    });

}
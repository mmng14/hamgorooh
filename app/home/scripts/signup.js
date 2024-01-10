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

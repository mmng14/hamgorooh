<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';


    ///USER_VALIDATION///
    if (!isset($_SESSION["user_name"]) || $_SESSION["user_type"] != 1) {
        redirect_to($HOST_NAME);
    }
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    if (isset($url_user_id)) {

        $first_name = "";
        $last_name = "";
        $user_full_name = "";
        $user_name = "";
        $user_photo = "";
        $user_email = "";
        $user_mobile = "";
        $user_phone = "";
        $user_address = "";
        $user_type = "";

        $user = $database->users[$url_user_id];
        $first_name = $user['name'];
        $last_name = $user['family'];
        $user_full_name = $first_name . " " . $last_name;
        $user_name = $user['username'];
        $user_photo = $user['photo'];
        $user_email = $user['email'];
        $user_mobile = $user['mobile'];
        $user_phone = $user['phone'];
        $user_address = $user['address'];
        $user_type = getTypeName($user['type']);
    } else {
        $user = "";
    }

    //-----------Header HTML -----------/
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/user_info.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

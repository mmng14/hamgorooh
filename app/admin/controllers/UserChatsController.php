<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    if (isset($url_user_id)) {

        $logged_in_user = $_SESSION["user_id"];
        $logged_in_user_name = $_SESSION['user_name'];
        $logged_in_full_name = $_SESSION['full_name'];
        $logged_in_user_email = $_SESSION['user_email'];
        $logged_in_user_photo = $_SESSION['user_photo'];
        $logged_in_reg_date = $_SESSION['reg_date'];
        $logged_in_user_type = $_SESSION['user_type'];


        $user_id = $url_user_id;
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

        $chat_count = 6;


        //    $user_chats =  $database->user_chat()
        //        ->where(array(
        //            'user_id' => $user_id,
        //            'receiver_id' => $logged_in_user
        //        ))
        //        ->or(array(
        //            'user_id' => $logged_in_user,
        //            'receiver_id' => $user_id
        //        ));

        $user_chats = $database->user_chat()
            ->where('user_id', $user_id)
            ->or('receiver_id', $user_id)
            ->where('user_id', $logged_in_user)
            ->or('receiver_id', $logged_in_user);;
    } else {
        $user = "";
    }


    //-----------Header HTML -----------/
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/user_chats.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

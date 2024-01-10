<?php
//require_once "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (!isset($_SESSION["user_name"])) {
        redirect_to($HOST_NAME);
    }
    page_access_check(array(1, 2,3,4,5), $HOST_NAME );
    include 'libraries/csrf_validation.php';


    //Get UserInfo
    if (isset($url_subject_id)) {
        $user_subjects = $database->user_subjects()
            ->select("*")
            ->where("status = ?", 1)
            ->where("subject_id = ?", $url_subject_id)
            ->where("user_id <> ?", $_SESSION["user_id"])
            ->order("subject_name asc");

        $subject = $database->subject[$url_subject_id];
        $subject_name = $subject["name"];

    }


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;

    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/teammates.view.php";
    return   include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}




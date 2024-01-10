<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    ///USER_VALIDATION///
    page_access_check(array(1), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    //Get UserInfo
    if (isset($url_subject_id)) {
        $user_subjects = $database->user_subjects()
            ->select("*")
            ->where("status = ?", 1)
            ->where("subject_id = ?", $url_subject_id)
            ->order("subject_name asc");

        $subject = $database->subject[$url_subject_id];
        $subject_name = $subject["name"];
    }


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/teammates.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

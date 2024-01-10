<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    
    $managers = $database->user_subjects()
        ->select("id,user_id,subject_id,subject_name")
        ->where("status = ?", 1)
        ->where("role = ?", 2)
        ->order("subject_name asc");
    //    ->limit(6  ,1);



    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/managers.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

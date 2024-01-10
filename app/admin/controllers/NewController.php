<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show new template page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "new_theme";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';



    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content =   $ROOT_DIR . "app/admin/views/new.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

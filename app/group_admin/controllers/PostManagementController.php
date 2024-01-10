<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1,2), $HOST_NAME);
    /////////////////////
    $active_menu = "post_manaement";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';


    $user_subjects = $database->user_subjects()
        ->select("*")
        ->where("status=?", 1)
        ->where("user_id=?", $_SESSION["user_id"])
        ->where("role=?", 2);


    $user_subject_list = array();

    if ($user_subjects) {
        foreach ($user_subjects as $user_subject_item) {
            $user_subject_list[] = $user_subject_item["subject_id"];
        }
    }


    $subject_list = $database->subject()
        ->select("*")
        ->where("status = ?", 1)
        ->where("id", $user_subject_list)
        ->order("ordering asc");

    $category_list = $database->category()
        ->select("*")
        ->where("status = ?", 1)
        ->where("subject_id", $user_subject_list)
        ->order("ordering asc");

//-----------Header HTML -----------/

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
//and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/post_management.view.php";
   return  include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


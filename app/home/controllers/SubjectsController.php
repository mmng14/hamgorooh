<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {



    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();


    ////////////////////////////////

    if (isset($subject_page)) {
        $page = (int) substr($subject_page, 1, strlen($subject_page) - 1);
    } else {
        $page = 0;
    }


    $today = jdate('Y/m/d');
    $current_year = jdate('Y');
    $current_year = convertPersianToEng($current_year);


    $subjects = $database->subject()
        ->select("*")
        ->where("status = ?", 1);




    $show_header = false;
    $header_title = "موضوع";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/subjects.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}

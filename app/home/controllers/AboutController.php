<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();

    $about = $database->about_us()
        ->where("status = ?", 1)
        ->order("id asc")
        ->fetch();

    $users = $database->users()
        ->where("status = ?", 1)
        ->order("id asc")
        ->limit(12, 1);

    //get post counts    
    $post_count = $database->post()
        ->select(" count(id) as post_count")
        // ->where("status = ?", 1)
        ->fetch();

    $total_posts =  $post_count["post_count"];    
    //-----------------

    $show_header = false;
    $header_title = "درباره ما";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR."app/home/views/about.view.php";
    include "app/shared/views/_layout_home.php";
}

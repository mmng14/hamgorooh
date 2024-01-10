<?php
// require_once "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    if (!isset($_SESSION["user_name"])) {
        redirect_to($HOST_NAME);
    }
    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    include 'libraries/csrf_validation.php';

    $this_subject_id = "";
    $this_subject_name = "";
    if (isset($url_subject_id)) {
        $subject_string = $url_subject_id;
        $this_subject_id = $subject_string;
        $subject = $database->subject[$this_subject_id];
        $this_subject_name = $subject["name"];
    }

    subject_access_check($this_subject_id, null, $HOST_NAME);

    $current_user_id = $_SESSION["user_id"];

    $user_subject = $database->user_subjects()
        ->select("*")
        ->where("status = ?", 1)
        ->where("role <> ?", 2)
        ->where("subject_id = ?", $this_subject_id)
        ->where("user_id = ?", $current_user_id)
        ->fetch();

    $user_groups = $database->user_groups()
        ->select("*")
        ->where("status = ?", 1)
        ->where("role <> ?", 0)
        ->where("subject_id = ?", $this_subject_id)
        ->where("user_id = ?", $current_user_id)
        ->order("group_id asc");



    $user_category_list = array();

    if ($user_groups) {
        foreach ($user_groups as $user_group_item) {
            $user_category_list[] = $user_group_item["group_id"];
        }
    }



    $category_list = $database->category()
        ->select("*")
        ->where("status = ?", 1)
        ->where("id", $user_category_list)
        ->order("ordering asc");

   


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;

    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/post_management.view.php";
    return  include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

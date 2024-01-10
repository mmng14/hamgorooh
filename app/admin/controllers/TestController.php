<?php
//require_once "core/utility_controller.php";

///USER_VALIDATION///
if (!isset($_SESSION["user_name"]) || $_SESSION["user_type"] != 1) {
    redirect_to($HOST_NAME);
}
///////////////////////////
$active_menu = "test";
//-------CSRF Check----------
include 'libraries/csrf_validation.php';
//--------------------------

try {

    $this_subject_id =1;
    $this_category_id = 2;
    $this_sub_category_id = 3;
    $post_code="4";
    $crawler_title="5";
    $post_name="51";
    $keywords = "6";
    $brief_desc = "7";
    $desc ="8";
    $photo_address = "9";
    $thumb_address = "10";
    $item_link_address="11";
    $post_date = jdate('Y/m/d');
    $register_date = date('Y/m/d H:i:s');

    //Insert referal record to post table
    $main_db_post_property = array("id" => null, "subject_id" => $this_subject_id, "category_id" => $this_category_id,
        "sub_category_id" => $this_sub_category_id, "post_code" => $post_code, "title" => $crawler_title, "url_name" => $post_name,
        "photo_address" => $photo_address, "thumb_address" => $thumb_address, "link_address" => $item_link_address, "post_date" => $post_date, "register_date" => $register_date,"robot_status" => 0,"status" => 0);

      debugSql();
      $database->post()->insert($main_db_post_property);
//    $main_db_post_insert = $database->post()->insert($main_db_post_property);
//    $main_db_post_id = $main_db_post_insert['id'];
//    $database->debug=function($query, $parameters){
//        echo "query: ".$query.' with param: '.var_export($parameters,1);
//    };
//    if ($main_db_post_id == null || $file_id == '') {
//        $message =  "<div class='alert alert-error'>خطا در ثبت داده ها</div>";
//    } else {
//        $message =  "<div class='alert alert-success'>داده ها با موفقیت ثبت شد</div>";
//
//    }

}
catch (PDOException $pdo_exp){
    $message = "<div class='alert alert-error'>{$pdo_exp->getMessage()}</div>";
}

//-------------------------------------------------------------------------------------

$HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
$ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
//and then call a template:
$page_title = "همگروه - بانک اطلاعات عمومی";
$page_content = $ROOT_DIR . "app/admin/views/test.view.php";
include $ROOT_DIR . "app/shared/views/_layout_admin.php";


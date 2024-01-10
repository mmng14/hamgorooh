<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2), $HOST_NAME);


    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';


    if (isset($post_code)) {
        $subject_id_length = (int) substr($post_code, 0, 1);
        $subject_id = (int) substr($post_code, 1, $subject_id_length);
        $category_id_length = (int) substr($post_code, 1 + $subject_id_length, 1);
        $category_id = (int) substr($post_code, 1 + $subject_id_length + 1, $category_id_length);
        $post_length = (int) substr($post_code, 1 + $subject_id_length + 1 + $category_id_length, 1);
        $subcategory_id = "";
        $post_id = substr($post_code, 1 + $subject_id_length + 1 + $category_id_length + 1, $post_length);
    }

    //Check user access if user is group_admin
    subject_access_check($subject_id, array(2), $HOST_NAME);

    if (isset($subject_id)) {
        if (is_numeric($subject_id)) {
            //Set Subject Database Connection
            $database_subject = getSubjectDatabase($subject_id);
        }
    }

    if (isset($post_id) && $post_id != -1) {
        $post = $database_subject->post()
            ->select("id,subject_id,category_id,sub_category_id,user_id,post_name,title,brief_description,user_full_name,reg_date,photo_address,source_name,source_link,visit_count,comment_count")
            ->where("id = ?", $post_id)
            ->fetch();

        $post_content = $database_subject->post_content()
            ->select("id,content")
            ->where("post_id = ?", $post_id)
            ->fetch();

        $photo_address = $post['photo_address'];
        if (strpos(strtolower($photo_address), 'http') === false) {
            $photo_address = $HOST_NAME . $photo_address;
        }
    }

    //-----------Header HTML -----------/

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/show_post.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

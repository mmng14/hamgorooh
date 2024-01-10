<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2), $HOST_NAME);
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


    $viewModel = [];

    if (isset($subject_list)) {

        foreach ($subject_list as $user_subject) {

            $database_subject = getSubjectDatabase($user_subject["id"]);

            $rows = $database_subject->comment
                ->where("approved = ?", 0)
                ->order("id desc");


            foreach ($rows as $row) {
                $post_link = "";

                $viewModel[] = [
                    "id" =>  $row['id'],
                    "subject_id" =>  $row['post_subject_id'],
                    "category_id" =>  $row['post_category_id'],
                    "post_id" =>  $row['post_id'],
                    "post_user_id" => $row['post_user_id'],
                    "author_name" => $row['author_name'],
                    "author_email"=>$row['author_email'],
                    "author_ip" => $row['author_ip'],
                    "user_id" => $row['user_id'],
                    "content" => $row['content'],
                    "reg_date" => $row['reg_date'],
                    "post_link" =>  $post_link,
                    "status" =>  $row['status']
                ];
            }

        }
    }

    //-----------Header HTML -----------/

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/user_comments.view.php";
    return  include $ROOT_DIR . "app/shared/views/_layout_admin.php";

}



//Approve User Comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACCEPT_REQUEST_CODE"]) {

    try {
        page_access_check(array(1, 2), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);

        $subject_id = test_input($_POST["subject_id"]);
        $comment_id = test_input($_POST["comment_id"]);
        subject_access_check_ajax($subject_id, array(1, 2), $HOST_NAME);
        $database_subject = getSubjectDatabase($subject_id); 

        if ($comment_id != "") {

            $update_row = $database_subject->comment[$comment_id];
            $now = date('Y/m/d H:i:s');
            $status = 1;
            $approved = 1;
            $approve_user = $_SESSION["user_id"];

            $property = array("id" => $comment_id, "status" => $status,"approved"=>$approved);
            $affected = $update_row->update($property);
            
            echo json_encode(
                array(
                    "result" => '1',
                    "status" => $approved,
                    "message" => "عملیات با موفقیت انجام شد"
                )
            );
        }
    } catch (Exception $ex) {
        echo json_encode(
            array(
                "result" => '0',
                "message" => "خطا در انجام عملیات"
            )
        );
    }
    exit;
}

//Reject User Comment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["REJECT_REQUEST_CODE"]) {

    try {
        page_access_check(array(1, 2), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);

        $subject_id = test_input($_POST["subject_id"]);
        $comment_id = test_input($_POST["comment_id"]);
        subject_access_check_ajax($subject_id, array(1, 2), $HOST_NAME);
        $database_subject = getSubjectDatabase($subject_id); 

        if ($comment_id != "") {

            $update_row = $database_subject->comment[$comment_id];
            $now = date('Y/m/d H:i:s');
            $status = 0;
            $approved = -1;
            $approve_user = $_SESSION["user_id"];

            $property = array("id" => $comment_id, "status" => $status,"approved"=>$approved);
            $affected = $update_row->update($property);
            
            echo json_encode(
                array(
                    "result" => '1',
                    "status" => $approved,
                    "message" => "عملیات با موفقیت انجام شد"
                )
            );
        }
    } catch (Exception $ex) {
        echo json_encode(
            array(
                "result" => '0',
                "message" => "خطا در انجام عملیات"
            )
        );
    }
    exit;
}

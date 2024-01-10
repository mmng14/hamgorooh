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

            $rows = $database_subject->post
                ->where("status = ?", 0)
                ->where("user_post = ?", 1)
                ->order("ordering desc");

            foreach ($rows as $row) {
                $post_link = "";

                $viewModel[] = [
                    "id" =>  $row['id'],
                    "subject_id" =>  $row['subject_id'],
                    "category_id" =>  $row['category_id'],
                    "post_name" =>  $row['post_name'],
                    "title" => $row['title'],
                    "brief_description"=>$row['brief_description'],
                    "thumb_address" => $row['thumb_address'],
                    "user_id" => $row['user_id'],
                    "user_name" => $row['user_name'],
                    "user_full_name" => $row['user_full_name'],
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
    $page_content = $ROOT_DIR . "app/group_admin/views/user_posts.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//Approve User Post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACCEPT_REQUEST_CODE"]) {

    try {
        page_access_check(array(1, 2), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);

        $subject_id = test_input($_POST["subject_id"]);
        $post_id = test_input($_POST["post_id"]);
        subject_access_check_ajax($subject_id, null, $HOST_NAME);
        $database_subject = getSubjectDatabase($subject_id); 

        if ($post_id != "") {

            $update_row = $database_subject->post[$post_id];
            $now = date('Y/m/d H:i:s');
            $status = 1;
            $approve_user = $_SESSION["user_id"];

            $property = array("id" => $post_id, "status" => $status);
            $affected = $update_row->update($property);
            
            echo json_encode(
                array(
                    "result" => '1',
                    "status" => $status,
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
}

//Reject User Post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["REJECT_REQUEST_CODE"]) {
    try {

        page_access_check(array(1, 2), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);
        
        $subject_id = test_input($_POST["subject_id"]);
        $post_id = test_input($_POST["post_id"]);
        subject_access_check_ajax($subject_id, null, $HOST_NAME);
        $database_subject = getSubjectDatabase($subject_id); 

        if ($post_id != "") {
            $update_row = $database_subject->post[$post_id];
            $now = date('Y/m/d H:i:s');
            $status = 2;
            $approve_user = $_SESSION["user_id"];
            $property = array("id" => $post_id, "status" => $status);
            $affected = $update_row->update($property);
            
            echo json_encode(
                array(
                    "result" => '1',
                    "status" => $status,
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
}

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1), $HOST_NAME);
    /////////////////////
    $active_menu = "ads";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';



    $subject_list = $database->subject()
        ->select("*")
        ->where("status = ?", 1)
        ->order("ordering asc");



    $user_subject_list = $database->user_subjects()
        ->select("*")
        ->where("status = ?", 0)
        ->where("accept_user is ?", null)
        ->where("role=?", 5)
        ->order("request_date asc");

    $subject_user_array_list = array();

    if ($user_subject_list) {
        foreach ($user_subject_list as $user_subject_list_item) {
            $subject_user_array_list[] = $user_subject_list_item["user_id"];
        }
    }

    $user_list = $database->users()
        ->where("status = ?", 1)
        ->where("id", $subject_user_array_list);

    $userSubjectViewModel = [];


    if (isset($user_subject_list)) {

        foreach ($user_subject_list as $user_subject_item) {

            //Get user info
            $user_found = false;
            foreach ($user_list as $user_list_item) {
                if ($user_subject_item["user_id"] == $user_list_item["id"]) {
                    $user_photo = $user_list_item["photo"];
                    $user_full_name = $user_list_item["name"] . ' ' . $user_list_item["family"];
                    $user_email = $user_list_item["email"];
                    $user_found = true;
                }
            }

            if (!$user_found) {
                $user_photo = "";
                $user_full_name = "";
                $user_email = "";
            }
            //--------------
            //Get subject info
            $subject_found = false;
            foreach ($subject_list as $subject_list_item) {
                if ($user_subject_item["subject_id"] == $subject_list_item["id"]) {
                    $subject_photo = $subject_list_item["photo"];
                    $subject_name = $subject_list_item["name"];
                    $subject_found = true;
                }
            }

            if (!$subject_found) {
                $subject_photo = "";
                $subject_name = "";
            }
            //------------
            $userSubjectViewModel[] = [
                "id" =>  $user_subject_item['id'],
                "user_id" => $user_subject_item['user_id'],
                "full_name" => $user_full_name,
                "email" => $user_email,
                "photo" => $user_photo,
                "subject_id" =>  $user_subject_item['subject_id'],
                "subject_name" =>  $subject_name,
                "visited" =>  $user_subject_item['visited'],
                "status" =>  $user_subject_item['status']
            ];
        }
    }


    //-----------Header HTML -----------/

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/request_management.view.php";
    return  include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACCEPT_REQUEST_CODE"]) {
    
    try {
        page_access_check(array(1), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);
        $id = test_input($_POST["obj"]);

        if ($id != "") {
            $update_row = $database->user_subjects[$id];
            $now = date('Y/m/d H:i:s');
            $accept_status = 1;
            $accept_user = $_SESSION["user_id"];
            $visited = 1;
            $property = array("id" => $id,"visited" => $visited, "status" => $accept_status,"accept_date"=>$now,"accept_user"=>$accept_user);
            $affected = $update_row->update($property);
            echo json_encode(
                array(
                    "result" => '1',
                    "accept_status" => $accept_status,
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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["REJECT_REQUEST_CODE"]) {
    try {

        page_access_check(array(1), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);
        $id = test_input($_POST["obj"]);

        if ($id != "") {
            $update_row = $database->user_subjects[$id];
            $now = date('Y/m/d H:i:s');
            $accept_status = 0;
            $accept_user = $_SESSION["user_id"];
            $visited = 1;
            $property = array("id" => $id,"visited" => $visited, "status" => $accept_status,"accept_date"=>$now,"accept_user"=>$accept_user);
            $affected = $update_row->update($property);
            echo json_encode(
                array(
                    "result" => '1',
                    "accept_status" => $accept_status,
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

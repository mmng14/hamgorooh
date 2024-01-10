<?php
// require_once "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_SESSION["user_name"])) {
        redirect_to($HOST_NAME);
    }
    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    include 'libraries/csrf_validation.php';

    $search_query = "";
    if (isset($_GET["searchq"])) {
        $search_query = htmlspecialchars($_GET["searchq"]);
    }
    
  //get all subject admins users
  $user_subjects = $database->user_subjects()
  ->select("*")
  ->where("role = ?", 2)
  ->order("subject_name asc");



    //Get UserId
    $current_user_id = $_SESSION["user_id"];
    //get user subjects diffrent status and role
    $user_subjects = $database->user_subjects()
        ->select("*")
        ->where("user_id = ?", $current_user_id)
        ->order("subject_name asc");

    //for all user  subjects
    $user_subject_list_arr = array();
    //for user management subjects
    $user_subject_manager_list_arr = array();
    //for user approved subjects
    $user_subject_approved_list_arr = array();
    //for user pending subjects
    $user_subject_pending_list_arr = array();
    //for user rejected subjects
    $user_subject_rejected_list_arr = array();

    if ($user_subjects) {
        foreach ($user_subjects as $user_subject_item) {

            $user_subject_list_arr[] = $user_subject_item["subject_id"];

            if ($user_subject_item["status"] == 1) {
                if ($user_subject_item["role"] == 2) {
                    $user_subject_manager_list_arr[] = $user_subject_item["subject_id"];
                } else {
                    $user_subject_approved_list_arr[] = $user_subject_item["subject_id"];
                }
            }

            if ($user_subject_item["status"] == 0) {
                $user_subject_pending_list_arr[] = $user_subject_item["subject_id"];
            }

            if ($user_subject_item["status"] == -1) {
                $user_subject_rejected_list_arr[] = $user_subject_item["subject_id"];
            }
        }
    }

    //------------------------------
    $subject_list = $database->subject()
        ->select("*")
        ->where("name like ?", '%' . $search_query . '%')
        ->where("status = ?", 1)
        ->order("ordering asc");

    foreach ($subject_list as $row) {

        $membership_status=0; // default status

        if(in_array($row['id'], $user_subject_manager_list_arr)){$membership_status=1;} // subject manager
        if(in_array($row['id'], $user_subject_approved_list_arr)){$membership_status=2;} // subject member
        if(in_array($row['id'], $user_subject_pending_list_arr)){$membership_status=3;} // subject requect pending
        if(in_array($row['id'], $user_subject_rejected_list_arr)){$membership_status=4;} // subject requect rejected

        $subject_list_view_model[] = [
            "id" =>  $row['id'],
            "name" =>  $row["name"],
            "photo" =>  $row["photo"],
            "membership_status" =>  $membership_status
        ];
    }



    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/groups.view.php";
    return  include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//****************************************************************************
//***************** add user subject membership request    ************************
//****************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    page_access_check_ajax(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['user_name'];
        $user_full_name = $_SESSION['full_name'];
        //---------------------
        $status = 0;
        $category = 0;
        $url_user_id = $user_id;
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $subject_name = mysql_escape_mimic($_POST['subject_name']);
        $role = 5;
        $user_rights = "000";
        $now = date('Y/m/d H:i:s');
        $request_date = $now;
        //$accept_date = $now;
        //$accept_user =  $_SESSION["user_id"];
        $visited = 0;
        $status = 0;

        if ($subject_id != 0 && $subject_id != -1) {
            //Check if didn't added before
            $find = $database->user_subjects()
                ->select("id")
                ->where("user_id = ?", $url_user_id)
                ->where("subject_id = ?", $subject_id)
                ->fetch();

            if (!$find) {

                $property = array(
                    "id" => null, "user_id" => $url_user_id, "subject_id" => $subject_id,
                    "subject_name" => $subject_name, "role" => $role, "user_rights" => $user_rights,
                    "request_date" => $request_date, "visited" => $visited, "status" => $status
                );

                $user_subjects = $database->user_subjects()->insert($property);
                $file_id = $user_subjects['id'];


                if ($file_id == null || $file_id == '') {
                    $msg = "خطا در ارسال درخواست";
                    echo json_encode(
                        array(
                            "status" => '0',
                            "message" => $msg,

                        )
                    );
                    exit;
                } else {
                    $msg = "درخواست شما با موفقیت ارسال شد";

                    //Start Notifications
                    $notification_type = $NOTIFICATION_TYPE_MEMBERSHIP_REQUEST; //request group     
                    $notification_id= addNotification($notification_type,0,$subject_id,$file_id);
                    //End Notification    

                    $html  = "<button class=\"btn  bg-yellow full-width\">درخواست ارسال شد <svg class=\"olymp-happy-face-icon\"><use xlink:href=\"#olymp-happy-face-icon\"></use></svg></button>";
                    echo json_encode(
                        array(
                            "status" => '1',
                            "message" => $msg,
                            "notification_id"=>$notification_id,
                            "user_id"=>$user_id,
                            "html"=> $html   
                        )
                    );
                    exit;
                }
            } else {
                $msg = " درخواست قبلا ارسال  شده است ";
                echo json_encode(
                    array(
                        "status" => '0',
                        "message" => $msg,

                    )
                );
                exit;
            }
        }
    } catch (PDOException $ex) {

        $msg = $ex->getMessage();
        echo json_encode(
            array(
                "status" => '0',
                "message" => $msg,

            )
        );
        exit;
    }
}
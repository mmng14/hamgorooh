<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['check']) && $_POST['check'] == "COMMENT_OP_CODE") {

    csrf_validation_ajax($_POST["_csrf"]);


    $afid = test_input($_POST['afid']); // antiforgery token
    $subject_id = test_input($_POST['sid']);
    $category_id = test_input($_POST['cid']);
    $sub_category_id = test_input($_POST['scid']);
    $post_id = test_input($_POST['pid']);
    $post_user_id = test_input($_POST['puid']);
    $author_name = test_input($_POST['fullName']);
    $author_email = test_input($_POST['email']);
    $user_comment = test_input($_POST['comment']);

    $database_subject = getSubjectDatabase($subject_id);

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_id = 0;
    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    }

    $approved = 0;
    $parent = 0;
    $has_child = 0;
    $status = 0;

    //if visit time is more than 1 minute 
    if (isset($post_id) && $user_comment != "") {

        if ($user_id == 0) {
            echo json_encode(
                array(
                    "rate_id" => 0,
                    "status" => "0",
                    "message" => "برای اظهار نظر ابتدا باید وارد سایت شوید"
                )
            );
            exit;
        }

        date_default_timezone_set('Asia/Tehran');
        $reg_date = date("Y/m/d");
        $reg_time = date('H:i:s');


        //Add to comment table 
        $comment_array = array(
            "id" => null, "post_id" => $post_id, "post_subject_id" => $subject_id,
            "post_category_id" => $category_id, "post_user_id" => $post_user_id,
            "author_name" => $author_name, "author_email" => $author_email,
            "user_id" => $user_id, "content" => $user_comment, "author_ip" => $user_ip,
            "reg_date" => $reg_date, "reg_time" => $reg_time,
            "approved" => $approved, "parent" => $parent, "has_child" => $has_child,
            "status" => $status
        );

        $comment = $database_subject->comment()->insert($comment_array);
        $commet_id = $comment['id'];
        if ($commet_id != null && $commet_id  > 0) {

            //Start Notifications
            $notification_type = $NOTIFICATION_TYPE_POST_COMMENT; //Post Comment    
            $notification_id = addNotification($notification_type, 0, $subject_id, $commet_id);
            //End Notification    

            echo json_encode(
                array(
                    "comment_id" => $commet_id,
                    "status" => "1",
                    "message" => "با تشکر - نظر شما با موفقیت ثبت شده است"
                )
            );
        } else {
            echo json_encode(
                array(
                    "status" => "0",
                    "message" => "خطایی در ثبت نظر رخ داده است . لطفا زمانی دیگر اقدام نمایید"
                )
            );
        }

        exit;
    }
}

<?php
//require_once "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show Notifications page   ************************
//*************************************************************************************
//[GET]
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    /////////////////////
    $active_menu = "user_messages";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    //--------------------------


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/user_messages.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


//****************************************************************************
//*****************     send message to chat group    ************************
//****************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    try {
        page_access_check_ajax(array(1, 2, 3, 4, 5), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $reciever_id = mysql_escape_mimic($_POST['friend_id']);
        subject_access_check_ajax($subject_id, null, $HOST_NAME);

        $sender_id = $_SESSION['user_id'];
        $sender_photo =   $_SESSION['user_photo'];
        $sender_full_name = $_SESSION['full_name'];
        $message_type = 2; // Private Message

        $register_date = date('Y/m/d H:i:s');
        $register_date = date('Y/m/d H:i:s');
        date_default_timezone_set('Asia/Tehran');
        $message_time = date('H:i:s');
        $message_date = jdate("Y/m/d");
        $message_date = convertPersianToEng($message_date);
        $visit_date_no_slash = str_replace('/', '', $message_date);

        $status = 0;

        $input_message = mysql_escape_mimic($_POST['message']);
        $breaks = array("\\r\\n", "\\n", "\\r");
        $message = str_ireplace($breaks, "<br/>", $input_message);

        $res = sendMessage($subject_id, $message_type, $sender_id, $sender_full_name, $sender_photo, $reciever_id, $message);

        $html = "<li>
                <div class=\"author-thumb\">
                    <img src=\"{$HOST_NAME}{$sender_photo}\" alt=\"{$sender_full_name}\">
                </div>
                <div class=\"notification-event\">
                    <div class=\"event-info-wrap\">
                        <a href=\"#\" class=\"h6 notification-friend\">{$sender_full_name}</a>
                        <span class=\"notification-date\"><time class=\"entry-date updated\" datetime=\"{$register_date}\">{$message_date}  -  {$message_time}</time></span>
                    </div>
                    <span class=\"chat-message-item\">{$message}</span>
                </div>
            </li>";


        if ($res > 0) {

            echo json_encode(
                array(
                    "status" => '1',
                    "message" => "پیام شما با موفقیت ارسال شد",
                    "html" => $html
                )
            );
        }
        exit;
    } catch (PDOException $e) {
        echo json_encode(
            array(

                "result" => "0",
                "redirect" => "",
                "message" => $e->getMessage(),
                "status" => "0",
            )
        );
    } catch (Exception $ex) {
        echo json_encode(
            array(

                "result" => "0",
                "redirect" => "",
                "message" => $ex->getMessage(),
                "status" => "0",
            )
        );
    }
    exit;
}


//*************************************************************************************
//*****************************    List Records   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {
    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $subject_id = mysql_escape_mimic($_POST['subject_id']);
    $friend_id = mysql_escape_mimic($_POST['friend_id']);
    subject_access_check_ajax($subject_id, null, $HOST_NAME);


    $database_messaging = getMessagingDatabase();

    $user_id = 0;
    $user_id = $_SESSION["user_id"];

    //--------------------------- page -----------------------------
    //Get page number from Ajax POST
    if (isset($_POST["page"])) {
        $page_number = filter_var(mysql_escape_mimic($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if (!is_numeric($page_number)) {
            die('Invalid page number!');
        } //incase of invalid page number
    } else {
        $page_number = 1; //if there's no page number, set it to 1
    }
    //------------------------------------------------------------
    //-------------------------- perpage -------------------------
    if (isset($_POST['perpage'])) {
        $item_per_page = mysql_escape_mimic($_POST['perpage']);
    } else
        $item_per_page = 10;
    //---------------------------------------------------------------
    //-------------------------- order -------------------------------
    if (isset($_POST['order'])) {
        $orderBy = mysql_escape_mimic($_POST['order']);
        if ($orderBy == 1) $order = 'id DESC';
        else if ($orderBy == 2) $order = 'id ASC';
    } else {
        $orderBy = 2;
        $order = 'id DESC';
    }
    //-----------------------------------------------------------------
    $count = $database_messaging->messages()
        ->select(" count(id) as c")        
        ->where("message_type=?", 2)
        //->and(["sender_user_id=?",  $friend_id],["reciever_user_id=?",  $$user_id])
        ->fetch();

    //------------
    $get_total_rows = $count["c"];
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number) {
        echo json_encode(
            array(
                "status" => '0',
                "message" => "به انتهای پیامها رسیده اید",
                "html" => ""
            )
        );
        exit;
    }


    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);



    $rows =  $database_messaging->messages()
        ->select("*")
        ->where("message_type=?", 2)
       // ->or($where(["sender_user_id=?",  $friend_id],["reciever_user_id=?",  $user_id]))
        ->order($order)
        ->limit($item_per_page, $page_position);


    // $group_message_ids = "";

    // $user_message_recievers = $database_messaging->group_message_recievers()
    // ->select("id,subject_id,group_message_id,reciever_user_id")
    // ->where("subject_id=?", $subject_id)
    // ->where("reciever_user_id=?", $group_message_ids);

    $viewModel = null;
    $reverseRows = null;
    $last_seen_message_id = 0;
    $is_first_row = true;

    if (isset($rows) && count($rows) > 0) {



        foreach ($rows as $row) {

            if ($page_number == 1 && $is_first_row==true) {
                $last_seen_message_id = $row['id'];
                $is_first_row = false;
            }

            $breaks = array("\\r\\n", "\\n", "\\r");
            $message = str_ireplace($breaks, "<br/>", $row['message']);

            $viewModel[] = [
                "id" =>  $row['id'],
                "subject_id" =>  $row['subject_id'],
                "sender_user_id" =>  $row['sender_user_id'],
                "sender_full_name" =>  $row['sender_full_name'],
                "sender_photo" =>  $row['sender_photo'],
                "message_type" =>  $row['message_type'],
                "reciever_user_id" =>  $row['reciever_user_id'],
                "message" =>  $message,
                "register_date_fa" =>  $row['register_date_fa'],
                "register_time_fa" =>  $row['register_time_fa'],
                "status" =>  $row['status']
            ];
        }

        $reverseRows = array_reverse($viewModel, true);
    }

    //TODO Update User Message Seen 
    if ($last_seen_message_id > 0) {
       // $res_id = groupMessageSeen($subject_id, $user_id, $last_seen_message_id);

    }

    //---------------------

    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );


    $html = view_to_string("_group_messages.php", "app/users/views/partial/", $reverseRows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);

    echo json_encode(
        array(
            "status" => '1',
            "message" => "",
            "html" => $html
        )
    );
    exit;
}

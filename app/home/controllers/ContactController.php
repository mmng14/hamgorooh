<?php
//require_once "core/utility_controller.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();

    $contact_info = $database->contact_info()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();

    //and then call a template:
    $show_header = false;
    $header_title = "تماس با ما";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/contact.view.php";
    include "app/shared/views/_layout_home.php";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] = $_SESSION["CONTACT_MESSAGE_CODE"]) {
    try {
        $status = 0;
        $name = mysql_escape_mimic($_POST['name']);
        $email = mysql_escape_mimic($_POST['email']);
        $title = mysql_escape_mimic($_POST['title']);
        $message = mysql_escape_mimic($_POST['message']);
        $register_date = date('Y/m/d H:i:s');
        $status = 0;

        $contact_type = 1;


        $property = array(
            "id" => null, "contact_type" => $contact_type, "name" => $name, "email" => $email,
            "title" => $title, "message" => $message, "register_date" => $register_date, "status" => $status
        );

        $contact_us = $database->contact_us()->insert($property);
        $file_id = $contact_us['id'];

        if ($file_id == null || $file_id == '') {
            $msg = "خطا در ارسال پیام . لطفا چند دقیقه دیگر دوباره امتحان نمایید ";
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
        } else {
            $msg = "با تشکر  . پیام شما با موفقیت ارسال گردید.";
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "1",
                )
            );
        }
    } catch (PDOException $ex) {

        $msg = "{$ex->getMessage()}";
        echo json_encode(
            array(
                "message" => $msg,
                "status" => "-1",
            )
        );
    }
}

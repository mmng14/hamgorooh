<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    $OP_CODE_LIST="LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,INSERT_CODE";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/messages.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//Add Data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] = $_SESSION["INSERT_CODE"]) {
    try {
        $status = 0;
        $name = mysql_escape_mimic($_POST['name']);
        $email = mysql_escape_mimic($_POST['email']);
        $title = mysql_escape_mimic($_POST['title']);
        $message = mysql_escape_mimic($_POST['message']);
        $register_date = date('Y/m/d H:i:s');
        $status = 0;

        $contact_type = 1;


        $property = array("id" => null, "contact_type" => $contact_type, "name" => $name, "email" => $email,
            "title" => $title, "message" => $message, "register_date" => $register_date, "status" => $status);

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

//*************************************************************************************
//*****************************   Delete  row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->contact_us[$tblId];
            $photo = $delete_row['photo'];

            $path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
            if (is_file($path)) {
                unlink($path);
            }

            $affected = $delete_row->delete();
            echo json_encode(
                array(

                    "result" => "1",
                    "redirect" => "",
                    "message" => "رکورد با موفقیت حذف شد",
                    "status" => "1",
                )
            );
        }
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
}

//*************************************************************************************
//**********************************   Activate  row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->contact_us[$tblId];
        $status = 1;
        $property = array("id" => $tblId, "status" => $status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  De Activate  row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->contact_us[$tblId];
        $status = 0;
        $property = array("id" => $tblId, "status" => $status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}


//*************************************************************************************
//*********************************   Messages  List   *************************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    // Define variables and set to empty values

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

    //get total number of records from database for pagination
//    $get_total_rows = countRows('ads', 'id');//hold total records in variable
    $get_total_rows = $database->contact_us()->count("id");
    //break records into pages
    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);

    //SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause

    $rows = $database->contact_us()
//        ->where("status = ?", 1)
        ->order("{$order}")
        ->limit($item_per_page, $page_position);


    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );

//    $html = view_tostring("_messages.php", "/partial/", $rows, $pagination, $HOST_NAME);
    $html = view_to_string("_messages.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
}


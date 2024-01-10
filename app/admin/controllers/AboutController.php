<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show about_us page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "about_us";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/about.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete about_us row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->about_us[$tblId];
            $photo = $delete_row['photo'];

            $path = $RELATIVE_UPLOAD_FOLDER_PREFIX .  $photo;
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
//**********************************   Activate subject row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] ==  $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->about_us[$tblId];
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
//**********************************  De Activate subject row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->about_us[$tblId];
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
//*****************************   Select about_us row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $about_us_title = $about_us_brief_desc = $about_us_photo = $about_us_desc = $about_us_ordering = $about_us_status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->about_us()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $about_us_title = $result['title'];
            $about_us_photo = $result['photo'];
            $about_us_brief_desc = $result['brief_description'];
            $about_us_desc = $result['description'];
            $about_us_ordering = $result['ordering'];
            $about_us_status = $result['status'];
        }
        echo json_encode(
            array(
                "title" => $about_us_title,
                "photo" => $about_us_photo,
                "desc" => $about_us_desc,
                "brief_desc" => nl2br($about_us_brief_desc),
                "ordering" => $about_us_ordering,
                "status" => $about_us_status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add about_us    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $status = 0;
        $title = mysql_escape_mimic($_POST['title']);
        $brief_desc = nl2br(mysql_escape_mimic($_POST['brief_description']));
        $desc = $_POST['description'];
        //$desc =  base64_decode($_POST['description']);
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $status = mysql_escape_mimic($_POST['status']);
        $photo = '';
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo = "uploads/admin/about_us/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $property = array(
            "id" => null, "title" => $title, "description" => $desc,
            "brief_description" => $brief_desc, "photo" => $photo, "lang" => 1, "ordering" => $ordering, "status" => $status
        );

        $about_us = $database->about_us()->insert($property);
        $file_id = $about_us['id'];

        if ($file_id == null || $file_id == '') {
            $msg = "خطا در ثبت دادهد";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,

                )
            );
            exit;
        } else {

            $msg = "داده ها با موفقیت ثبت شد";
            echo json_encode(
                array(
                    "status" => '1',
                    "message" => $msg,

                )
            );
            exit;
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

//*************************************************************************************
//*****************************   update about_us    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $about_us_id = mysql_escape_mimic($_POST['hashId']);
        $title = mysql_escape_mimic($_POST['title']);
        $brief_desc = nl2br(mysql_escape_mimic($_POST['brief_description']));
        $desc = $_POST['description'];
        //$desc =  base64_decode($_POST['description']);
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $status = 0;
        $status = mysql_escape_mimic($_POST['status']);

        $photo = '';
        if (isset($_POST['photo'])) {
            $photo = mysql_escape_mimic($_POST['photo']);
        }

        $edit_row = $database->about_us[$about_us_id];

        $old_photo = "";
        //get old photo address
        if ($edit_row) {
            $old_photo = $edit_row["photo"];
            $photo = $old_photo;
        }
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();

                $photo = "uploads/admin/about_us/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
                //delete old photo if exists
                $old_photo_path = "" . $old_photo;
                if (is_file($old_photo_path)) {
                    unlink($old_photo_path);
                }

                //---------------------
            }
        }


        $property = array(
            "title" => $title, "description" => $desc,
            "brief_description" => $brief_desc, "photo" => $photo, "ordering" => $ordering, "status" => $status
        );

        $affected = $edit_row->update($property);

        if ($affected == null) {
            //$msg = "<div class='alert alert-danger'>خطا در بروز رسانی داده ها  </div>";
            $msg = "خطا در بروز رسانی داده ها";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,

                )
            );
            exit;
        } else {

            //$msg = "<div class='alert alert-success'>داده ها با موفقیت بروز رسانی شد</div>";
            $msg = "داده ها با موفقیت بروز رسانی شد";
            echo json_encode(
                array(
                    "status" => '1',
                    "message" => $msg,

                )
            );
            exit;
        }
    } catch (PDOException $ex) {

        //$msg = "<div class='alert alert-danger'>{$ex->getMessage()} </div>";
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

//*************************************************************************************
//*****************************   about_us  List   ***************************** 
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {


    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);


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
    $count = $database->about_us()
        ->select(" count(id) as c")
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->about_us()
        ->select("*")
        ->order($order)
        ->limit($item_per_page, $page_position);

    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );

    $data = array();
    $data['list'] = $rows;
    $data['pagination'] = $pagination;
    //echo json_encode($data);

    $html = view_to_string("_about.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

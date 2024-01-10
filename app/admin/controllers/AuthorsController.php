<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show authors page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "authors";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    $OP_CODE_LIST="LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,INSERT_CODE";
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/authors.view.php";
    include  $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete authors row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->authors[$tblId];
            $photo = $delete_row['photo_address'];

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
//**********************************   Activate authors row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] ==  $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->authors[$tblId];
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
//**********************************  De Activate authors row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->authors[$tblId];
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
//*****************************   Select authors row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $authors_title = $authors_brief_desc = $authors_photo = $authors_desc = $authors_ordering = $authors_status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->authors()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $full_name = $result['full_name'];
            $photo_address = $result['photo_address'];
            $brief_description = $result['brief_description'];           
            $description = $result['description'];
            $fame_fields = $result['fame_fields'];
            $start_year = $result['start_year'];
            $end_year = $result['end_year'];
            $status = $result['status'];
        }
        echo json_encode(
            array(
                "full_name" => $full_name,
                "photo_address" => $photo_address,
                "brief_description" => $brief_description,
                "description" => nl2br($description),
                "fame_fields"=>$fame_fields,
                "start_year" => $start_year,
                "end_year" => $end_year,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add authors    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $status = 0;
        $full_name = mysql_escape_mimic($_POST['full_name']);
        $brief_description = mysql_escape_mimic($_POST['brief_description']);
        $description = nl2br(mysql_escape_mimic($_POST['description']));
        $fame_fields = mysql_escape_mimic($_POST['fame_fields']);
        $start_year = mysql_escape_mimic($_POST['start_year']);
        if($start_year ==''){$start_year=null;} 
        $end_year = mysql_escape_mimic($_POST['end_year']);
        if($end_year ==''){$end_year=null;}
        // $ordering = mysql_escape_mimic($_POST['ordering']);
        $status = mysql_escape_mimic($_POST['status']);


        $photo_address = '';
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo_address = "uploads/admin/authors/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo_address;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }
        
        $property = array(
            "id" => null, "full_name" => $full_name, "brief_description" => $brief_description, "description" => $description,
            "photo_address" => $photo_address,"fame_fields" => $fame_fields, "start_year" => $start_year, "end_year" => $end_year, 
            "status" => $status
        );

        $authors = $database->authors()->insert($property);
        $file_id = $authors['id'];

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
//*****************************   update authors    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $authors_id = mysql_escape_mimic($_POST['hashId']);
        $status = 0;
        $full_name = mysql_escape_mimic($_POST['full_name']);
        $brief_description = mysql_escape_mimic($_POST['brief_description']);
        $description = nl2br(mysql_escape_mimic($_POST['description']));
        $fame_fields = mysql_escape_mimic($_POST['fame_fields']); 
        $start_year = mysql_escape_mimic($_POST['start_year']);
        if($start_year ==''){$start_year=null;} 
        $end_year = mysql_escape_mimic($_POST['end_year']);
        if($end_year ==''){$end_year=null;}
        // $ordering = mysql_escape_mimic($_POST['ordering']);
        $status = mysql_escape_mimic($_POST['status']);

        $photo_address = '';
        if (isset($_POST['photo_address'])) {
            $photo_address = mysql_escape_mimic($_POST['photo_address']);
        }

        $edit_row = $database->authors[$authors_id];

        $old_photo = "";
        //get old photo address
        if ($edit_row) {
            $old_photo = $edit_row["photo_address"];
            $photo_address = $old_photo;
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

                $photo_address = "uploads/admin/authors/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo_address;
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
            "full_name" => $full_name,"brief_description" => $brief_description, "description" => $description,
            "photo_address" => $photo_address,"fame_fields" => $fame_fields, "start_year" => $start_year, "end_year" => $end_year, 
            "status" => $status
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
//*****************************   authors  List   ***************************** 
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
    $count = $database->authors()
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


    $rows = $database->authors()
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

    $html = view_to_string("_authors.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

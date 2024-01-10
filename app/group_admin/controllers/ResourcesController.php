<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show resources page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1,2), $HOST_NAME);
    $active_menu = "resources";
    $selected_subject_id =0;
    $page_number = 1;

    if (isset($url_subject_id) && is_numeric($url_subject_id)) {

        $selected_subject_id = (int)$url_subject_id;
        subject_access_check($selected_subject_id, array(1, 2), $HOST_NAME);
    } else {
        echo "<h1> Subject Code Is Not Valid </h1>";
        exit;
    }

    if (isset($url_page_number)) {
        if (is_numeric($url_page_number)) {
            $page_number = $url_page_number;
        }
    }

    $authors_rows = $database->authors()
        ->select("*")
        ->where("status = ?", 1);
    
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    $OP_CODE_LIST="LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,INSERT_CODE";


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/resources.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete resources row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->resources[$tblId];
            subject_access_check_ajax($delete_row["subject_id"],  array(1, 2), $HOST_NAME);
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
//**********************************   Activate resources row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] ==  $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->resources[$tblId];
        subject_access_check_ajax($update_row["subject_id"],  array(1, 2), $HOST_NAME);
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
//**********************************  De Activate resources row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->resources[$tblId];
        subject_access_check_ajax($update_row["subject_id"],  array(1, 2), $HOST_NAME);
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
//*****************************   Select resources row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
   
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $resources_title = $resources_brief_desc = $resources_photo = $resources_desc = $resources_ordering = $resources_status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->resources()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {

            subject_access_check_ajax($result["subject_id"],  array(1, 2), $HOST_NAME);

            $title = $result['title'];
            $subject_id = $result['subject_id'];
            $photo_address = $result['photo_address'];
            $brief_description = $result['brief_description'];           
            $description = $result['description'];
            $author_id = $result['author_id'];
            $publish_year = $result['publish_year'];
            $categories = $result['categories'];
            $ordering = $result['ordering'];
            $status = $result['status'];
        }
        echo json_encode(
            array(
                "title" => $title,
                "subject_id" => $subject_id,
                "photo_address" => $photo_address,
                "brief_description" => $brief_description,
                "description" => nl2br($description),
                "author_id"=>$author_id,
                "publish_year" => $publish_year,
                "categories" => $categories,
                "ordering" => $ordering,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add resources    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    subject_access_check_ajax($_POST['subject_id'],  array(1, 2), $HOST_NAME);

    csrf_validation_ajax($_POST["_csrf"]);
    
    try {
        $status = 0;
        $title = mysql_escape_mimic($_POST['title']);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $brief_description = mysql_escape_mimic($_POST['brief_description']);
        $description = nl2br(mysql_escape_mimic($_POST['description']));
        $author_id = mysql_escape_mimic($_POST['author_id']);
        $categories = mysql_escape_mimic($_POST['categories']);
        $publish_year = mysql_escape_mimic($_POST['publish_year']);
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $register_date = date('Y/m/d H:i:s');
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
                $photo_address = "uploads/admin/resources/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo_address;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $property = array(
            "id" => null, "title" => $title,"subject_id" => $subject_id, "brief_description" => $brief_description, "description" => $description,
            "photo_address" => $photo_address,"categories" => $categories, "publish_year" => $publish_year, "author_id" => $author_id, 
            "ordering" => $ordering,"register_date" => $register_date,"status" => $status
        );

        $resources = $database->resources()->insert($property);
        $file_id = $resources['id'];

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
//*****************************   update resources    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    subject_access_check_ajax($_POST['subject_id'],  array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $resources_id = mysql_escape_mimic($_POST['hashId']);
        $status = 0;
        $title = mysql_escape_mimic($_POST['title']);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $brief_description = mysql_escape_mimic($_POST['brief_description']);
        $description = nl2br(mysql_escape_mimic($_POST['description']));
        $categories = mysql_escape_mimic($_POST['categories']); 
        $publish_year = mysql_escape_mimic($_POST['publish_year']);
        $author_id = mysql_escape_mimic($_POST['author_id']);
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $register_date = date('Y/m/d H:i:s');
        $status = mysql_escape_mimic($_POST['status']);

        $photo_address = '';
        if (isset($_POST['photo_address'])) {
            $photo_address = mysql_escape_mimic($_POST['photo_address']);
        }

        $edit_row = $database->resources[$resources_id];

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

                $photo_address = "uploads/admin/resources/" . $newGUID . $extension;
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
            "title" => $title,"subject_id" => $subject_id,"brief_description" => $brief_description, "description" => $description,
            "photo_address" => $photo_address,"categories" => $categories, "publish_year" => $publish_year, "author_id" => $author_id, 
            "ordering" => $ordering,"status" => $status
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
//*****************************   Resources  List   ***************************** 
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {


    page_access_check_ajax(array(1,2), $HOST_NAME);
    subject_access_check_ajax($_POST["sf"],  array(1, 2), $HOST_NAME);

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

    $subject_filter = 0;
    //if subject filter is set
    if (isset($_POST["sf"])); {
        if (is_numeric($_POST["sf"]) && $_POST["sf"] != 0) {
            $subject_filter = mysql_escape_mimic($_POST["sf"]);
        }
    }
    $subject_check = "subject_id = ?";
    if ($subject_filter == 0) {
        $subject_filter = 1;
        $subject_check = " 1 = ?";
    }


    //-----------------------------------------------------------------
    $count = $database->resources()
        ->select(" count(id) as c")
        ->where($subject_check, $subject_filter)
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);

    $rows = $database->resources()
    ->select("*")
    ->where($subject_check, $subject_filter)
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

    $html = view_to_string("_resources.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}
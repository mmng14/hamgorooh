<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show subject page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "subjects";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/subjects.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete subject row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->subject[$tblId];
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
//**********************************   Activate subject row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject[$tblId];
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
        $update_row = $database->subject[$tblId];
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
//**********************************   Activate TopMenu    *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_TOPMENU_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject[$tblId];
        $top_menu = 1;
        $property = array("id" => $tblId, "top_menu" => $top_menu);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  De Activate TopMenu    *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_TOPMENU_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject[$tblId];
        $top_menu = 0;
        $property = array("id" => $tblId, "top_menu" => $top_menu);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************   Activate Has Resource    *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_HASRESOURCE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject[$tblId];
        $has_resource = 1;
        $property = array("id" => $tblId, "has_resource" => $has_resource);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  De Activate Has Resource     *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_HASRESOURCE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject[$tblId];
        $has_resource = 0;
        $property = array("id" => $tblId, "has_resource" => $has_resource);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//*****************************   Select subject row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject_title = $subject_brief_desc = $subject_photo = $subject_desc = $subject_ordering = $subject_status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->subject()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $subject_name=$result['name'];
			$subject_photo=$result['photo'];
			$subject_top_menu=$result['top_menu'];
            $subject_has_resource=$result['has_resource'];
			$subject_desc=$result['description'];
            $subject_data_name=$result['data_name'];
            $subject_db_server=$result['db_server'];
            $subject_db_name=$result['db_name'];
            $subject_db_user=$result['db_user'];
            $subject_db_pass=$result['db_pass'];
			// $subject_telegram_token=$result['telegram_token'];
			// $subject_telegram_id=$result['telegram_id'];
			// $subject_telegram_link=$result['telegram_link'];
			$subject_ordering=$result['ordering'];
			$subject_status=$result['status'];
        }
        echo json_encode(
            array(
                "name" => $subject_name,
				"photo" => $subject_photo,
			    "top_menu" => $subject_top_menu,
                "has_resource" => $subject_has_resource,
			    "desc" => $subject_desc,

                "data_name" => $subject_data_name,
                "db_server" => $subject_db_server,
                "db_name" => $subject_db_name,
                "db_user" => $subject_db_user,
                "db_pass" => $subject_db_pass,
                // "telegram_token" => $subject_telegram_token,
                // "telegram_id" => $subject_telegram_id,
                // "telegram_link" => $subject_telegram_link,
				"ordering" => $subject_ordering,
				"status" => $subject_status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add subject    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $status=0;
        $top_menu=0;
        $has_resource=0;
        $user_group=0;
        $name  = mysql_escape_mimic($_POST['name']);
        $url_name = sanitize(strip_tags($name));
        $desc  = mysql_escape_mimic($_POST['description']);
        if (isset($_POST['topmenu']))
            $top_menu=1;

        if (isset($_POST['has_resource']))
            $has_resource=1;    

        $ordering  = mysql_escape_mimic($_POST['ordering']);
        if (isset($_POST['status']))
            $status=1;
        $is_custom = 0;

        $data_name  = mysql_escape_mimic($_POST['data_name']);
        $db_server  = mysql_escape_mimic($_POST['db_server']);
        $db_name  = mysql_escape_mimic($_POST['db_name']);
        $db_user  = mysql_escape_mimic($_POST['db_user']);
        $db_pass  = mysql_escape_mimic($_POST['db_pass']);
        // $telegram_token  = mysql_escape_mimic($_POST['telegram_token']);
        // $telegram_id  = mysql_escape_mimic($_POST['telegram_id']);
        // $telegram_link  = mysql_escape_mimic($_POST['telegram_link']);
        $register_date = jdate('Y/m/d');
        $photo ="";

        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo = "uploads/admin/subject/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $current_time = date("Y-m-d H:i:s");


        $property = array("id" => null, "name" => $name, "url_name" => $url_name,"photo" => $photo, "has_category" => 0
        ,"has_resource" => $has_resource, "top_menu" => $top_menu, "description" => $desc,
            "is_custom" => $is_custom, "data_name" => $data_name, "db_server" => $db_server, "db_name" => $db_name,
            "db_user" => $db_user, "db_pass" => $db_pass, 
            //"telegram_token" => $telegram_token, "telegram_id" => $telegram_id,"telegram_link" => $telegram_link, "update_date" => $register_date,
            "ordering" => $ordering, "status" => $status);

        $subject = $database->subject()->insert($property);
        $file_id = $subject['id'];

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
//*****************************   update subject    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $subject_id = mysql_escape_mimic($_POST['hashId']);

        $status=0;
        $top_menu=0;
        $has_resource=0;
        $user_group=0;
        $name  = mysql_escape_mimic($_POST['name']);
        $url_name = sanitize(strip_tags($name));
        $desc  = mysql_escape_mimic($_POST['description']);
        if (isset($_POST['topmenu']))
            $top_menu=1;

        if (isset($_POST['has_resource']))
            $has_resource=1;

        $ordering  = mysql_escape_mimic($_POST['ordering']);
        if (isset($_POST['status']))
            $status=1;
        $is_custom = 0;

        $data_name  = mysql_escape_mimic($_POST['data_name']);
        $db_server  = mysql_escape_mimic($_POST['db_server']);
        $db_name  = mysql_escape_mimic($_POST['db_name']);
        $db_user  = mysql_escape_mimic($_POST['db_user']);
        $db_pass  = mysql_escape_mimic($_POST['db_pass']);
        // $telegram_token  = mysql_escape_mimic($_POST['telegram_token']);
        // $telegram_id  = mysql_escape_mimic($_POST['telegram_id']);
        // $telegram_link  = mysql_escape_mimic($_POST['telegram_link']);

        $photo = '';
        if (isset($_POST['photo'])) {
            $photo = mysql_escape_mimic($_POST['photo']);
        }

        $edit_row = $database->subject[$subject_id];

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

                $photo = "uploads/admin/subject/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
                //delete old photo if exists
                $old_photo_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $old_photo;
                if (is_file($old_photo_path)) {
                    unlink($old_photo_path);
                }

                //---------------------
            }
        }


       $property = array("name" => $name, "url_name" => $url_name,"photo" => $photo,
            "has_resource" => $has_resource,"top_menu" => $top_menu, "description" => $desc,
            "is_custom" => $is_custom, "data_name" => $data_name, "db_server" => $db_server, "db_name" => $db_name,
            "db_user" => $db_user, "db_pass" => $db_pass, 
            //"telegram_token" => $telegram_token, "telegram_id" => $telegram_id,"telegram_link" => $telegram_link,
            "ordering" => $ordering, "status" => $status);


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
//*****************************   subject  List   *****************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

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
    $count = $database->subject()
        ->select(" count(id) as c")
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //$get_total_rows = isset($count["c"]) ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->subject()
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

    $html = view_to_string("_subjects.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

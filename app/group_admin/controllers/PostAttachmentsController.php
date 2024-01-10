<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show resource_attachments page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1, 2), $HOST_NAME);
    $active_menu = "post_attachments";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    $subject_id=0;
    $category_id=0;
    $post_id=0;
    if (isset($url_post_id) && isset($url_subject_id) && isset($url_category_id)) {
        if (is_numeric($url_post_id)) {
            $post_id = $url_post_id;
        }
        if (is_numeric($url_subject_id)) {
            $subject_id = $url_subject_id;
        }
        if (is_numeric($url_category_id)) {
            $category_id = $url_category_id;
        }
    }

    //Check user access if user is group_admin or user
    subject_access_check($subject_id, null, $HOST_NAME);

    $database_subject = getSubjectDatabase($subject_id); 
    $selected_post = $database_subject->post()
        ->select("*")
        ->where("id = ?", $post_id)
        ->fetch();


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/post_attachments.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete post_attachments row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);
    $photo = "";
    $subject_id = test_input($_POST["subject_id"]);
    $category_id = test_input($_POST["category_id"]);
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {
            $database_subject = getSubjectDatabase($subject_id); 

            $delete_row = $database_subject->post_attachments[$tblId];
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
//**********************************   Activate post_attachments row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] ==  $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);
    $subject_id = test_input($_POST["subject_id"]);
    $category_id = test_input($_POST["category_id"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $database_subject = getSubjectDatabase($subject_id); 
        $update_row = $database_subject->post_attachments[$tblId];
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
//**********************************  De Activate post_attachments row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);

    $subject_id = test_input($_POST["subject_id"]);
    $category_id = test_input($_POST["category_id"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $database_subject = getSubjectDatabase($subject_id); 
        $update_row = $database_subject->post_attachments[$tblId];
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
//*****************************   Select post_attachments row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);

    $subject_id = test_input($_POST["subject_id"]);
    $category_id = test_input($_POST["category_id"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $database_subject = getSubjectDatabase($subject_id); 
        $result = $database_subject->post_attachments()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $title = $result['title'];
            $photo_address = $result['photo_address'];
            $link_address = $result['link_address'];
            $description = $result['description'];
            $post_id = $result['post_id'];
            $parent_id = $result['parent_id'];
            $attachment_type = $result['attachment_type'];
            $ordering = $result['ordering'];
            $status = $result['status'];
        }
        echo json_encode(
            array(
                "title" => $title,
                "photo_address" => $photo_address,
                "link_address" => $link_address,
                "description" => nl2br($description),
                "post_id" => $post_id,
                "parent_id" => $parent_id,
                "attachment_type" => $attachment_type,
                "ordering" => $ordering,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//***************************** Get post_attachments parent List   ***************************** 
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_CATEGORY_LIST_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);

    $subject_id = test_input($_POST["subject_id"]);
    $category_id = test_input($_POST["category_id"]);
    $postId = test_input($_POST["postId"]);
    $id=0;
    
    if(isset($_POST["id"]) && $_POST["id"] !=0){
        $id =test_input($_POST["id"]); 
    }
    $database_subject = getSubjectDatabase($subject_id);
    $rows = $database_subject->post_attachments()
        ->select("*")
        ->where("post_id", $postId);

    $html_options = "<option value=\"0\" selected=\"selected\">انتخاب کنید</option>";    
    foreach($rows as  $row){
        if($id !=  $row['id']){
            $html_options.= "<option value=\"" . $row['id'] . "\">" . $row['title'] . "</option>";
        }
    }
   
    echo json_encode(
        array(
            "html_options" => $html_options,
            "state" => 1,
            "message"=>"عملیات با موفقیت انجام شد"
        )
    );
    exit;
}


//*************************************************************************************
//*****************************   Add post_attachments    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);

    try {
        $status = 0;
        $parent_id=0;
        $subject_id = test_input($_POST["subject_id"]);
        $category_id = test_input($_POST["category_id"]);
        $title = mysql_escape_mimic($_POST['title']);
        $link_address = mysql_escape_mimic($_POST['link_address']);
        $description = nl2br(mysql_escape_mimic($_POST['description']));
        $post_id = mysql_escape_mimic($_POST['post_id']);
        $attachment_type = mysql_escape_mimic($_POST['attachment_type']);
        if(isset($_POST['parent_id'])  && $_POST['parent_id'] !=null){
            $parent_id = mysql_escape_mimic($_POST['parent_id']);
        }
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $status = mysql_escape_mimic($_POST['status']);

        $photo_address = '';
        //if there is a picture
        $UPLOAD_FOLDER = $UPLOAD_ARR[$subject_id];
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo_address = "uploads/{$UPLOAD_FOLDER}/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo_address;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $property = array(
            "id" => null, "title" => $title, "link_address" => $link_address, "description" => $description,
            "photo_address" => $photo_address, "post_id" => $post_id, "attachment_type" => $attachment_type, 
            "parent_id" => $parent_id,"ordering" => $ordering, "status" => $status
        );

        $database_subject = getSubjectDatabase($subject_id);
        $post_attachments = $database_subject->post_attachments()->insert($property);
        $file_id = $post_attachments['id'];

        if ($file_id == null || $file_id == '') {
            $msg = "خطا در ثبت داده ";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,
                    "photo_address"=>$photo_address,
                    "insert_model"=>$property,
                    "new_id"=>$file_id,
                    "subject_id"=>$subject_id
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
//*****************************   Update post_attachments    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);

    try {

        $subject_id = test_input($_POST["subject_id"]);
        $category_id = test_input($_POST["category_id"]);
        $post_attachments_id = mysql_escape_mimic($_POST['hashId']);
        $status = 0;
        $parent_id = 0;
        
        $title = mysql_escape_mimic($_POST['title']);
        $link_address = mysql_escape_mimic($_POST['link_address']);
        $description = nl2br(mysql_escape_mimic($_POST['description']));
        $post_id = mysql_escape_mimic($_POST['post_id']);
        $attachment_type = mysql_escape_mimic($_POST['attachment_type']);
        if(isset($_POST['parent_id'])  && $_POST['parent_id'] !=null){
            $parent_id = mysql_escape_mimic($_POST['parent_id']);
        }

        $ordering = mysql_escape_mimic($_POST['ordering']);
        $status = mysql_escape_mimic($_POST['status']);

        $photo_address = '';
        if (isset($_POST['photo_address'])) {
            $photo_address = mysql_escape_mimic($_POST['photo_address']);
        }

        $database_subject = getSubjectDatabase($subject_id);
        $edit_row = $database_subject->post_attachments[$post_attachments_id];

        $old_photo = "";
        //get old photo address
        if ($edit_row) {
            $old_photo = $edit_row["photo_address"];
            $photo_address = $old_photo;
        }
        //if there is a picture
        $UPLOAD_FOLDER = $UPLOAD_ARR[$subject_id];
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();

                $photo_address = "uploads/{$UPLOAD_FOLDER}/" . $newGUID . $extension;
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
            "title" => $title, "link_address" => $link_address, "description" => $description,
            "photo_address" => $photo_address, "post_id" => $post_id, "attachment_type" => $attachment_type,
            "parent_id" => $parent_id,"ordering" => $ordering, "status" => $status
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
//*****************************   post_attachments  List   ***************************** 
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {


    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    subject_access_check_ajax($_POST["subject_id"], null, $HOST_NAME);

    $subject_id = test_input($_POST["subject_id"]);
    $category_id = test_input($_POST["category_id"]);

    $database_subject = getSubjectDatabase($subject_id);
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

    //----------------------------------------------------------------------
    //-------------------------- post id -------------------------------
    $post_filter = 0;
    //if resource filter is set
    if (isset($_POST["post_id"])); {
        if (is_numeric($_POST["post_id"]) && $_POST["post_id"] != 0) {
            $post_filter = mysql_escape_mimic($_POST["post_id"]);
        }
    }

    $post_check = "post_id = ?";
    if ($post_filter == 0) {
        $post_filter = 1;
        $post_check = " 1 = ?";
    }


    $count = $database_subject->post_attachments()
        ->select(" count(id) as c")
        ->where($post_check, $post_filter)
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database_subject->post_attachments()
        ->select("*")
        ->where($post_check, $post_filter)
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

    $html = view_to_string("_post_attachments.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

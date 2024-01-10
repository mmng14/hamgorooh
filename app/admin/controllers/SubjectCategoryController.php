<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show category page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "subjects";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    $this_subject_id = "";
    $this_subject_name = "";
    if (isset($url_subject_id)) {
        $this_subject_id = $url_subject_id;
        $subject = $database->subject[$this_subject_id];
        $this_subject_name = $subject["name"];
    }

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/subject_category.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete category row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->category[$tblId];
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
//******************************   Send to subject site   ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_SUBJECTS_CODE"]) {
    // Define variables and set to empty values
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $tblId = test_input($_POST["obj"]);
        $results = "";

        if ($tblId != "") {

            $category = $database->category()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();

            $subj_id = $category["subject_id"];

            $subject_site = $database->subject_sites()
                ->select("*")
                ->where("subject_id=?", $subj_id)
                ->fetch();




            $id = $category['id'];
            $subject_id = $category['subject_id'];
            $name = $category['name'];
            $url_name = $category['url_name'];
            $has_sub = $category['has_sub'];
            $sub_count = $category['sub_count'];
            $desc = $category['description'];
            $is_custom = $category['is_custom'];
            $photo = $category['category_type'];
            $resource_id = $category['resource_id'];
            $author_id = $category['author_id'];
            $post_count = $category['post_count'];
            $visit_count = $category['visit_count'];
            $update_date = $category['update_date'];
            $ordering = $category['ordering'];
            $status = $category['status'];
            $photo_address = $HOST_NAME . $photo;

            $data_to_post_category = array(
                "id" => $id, "subject_id" => $subject_id, "name" => $name, "url_name" => $url_name, "photo" => $photo, "has_sub" => $has_sub, "sub_count" => $sub_count, "has_header" => $has_header,  "description" => $desc, "is_custom" => $is_custom, "telegram_token" => $telegram_token, "telegram_id" => $telegram_id, "telegram_link" => $telegram_link, "post_count" => $post_count, "visit_count" => $visit_count, "update_date" => $update_date, "ordering" => $ordering, "status" => $status
            );


            $remote_url =  $subject_site["recieve_link"] . "insert/category";
            $ch = curl_init($remote_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post_category);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_data = curl_exec($ch);
            $results .= $return_data . ",";

            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $data_to_post_category,
                    "result" => $results,
                    "status" => "1",
                )
            );
        } else {
            echo json_encode(
                array(
                    "message" => "",
                    "status" => "0",
                )
            );
        }
    } catch (Exception $ex) {
        echo json_encode(
            array(
                "message" => "",
                "status" => "-1",
            )
        );
    }
}

//*************************************************************************************
//******************************  Delete from subject site   ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_TO_SUBJECTS_CODE"]) {
    // Define variables and set to empty values
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        $tblId = test_input($_POST["obj"]);
        $results = "";

        if ($tblId != "") {

            $category = $database->category()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();

            $subj_id = $category["subject_id"];

            $subject_site = $database->subject_sites()
                ->select("*")
                ->where("subject_id=?", $subj_id)
                ->fetch();

            $id = $category['id'];
            $category_post = array("id" => $id);
            $remote_url = $subject_site["recieve_link"] . "delete/category";
            $ch = curl_init($remote_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $category_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_data = curl_exec($ch);
            $results .= $return_data . ",";


            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $category_post,
                    "result" => $results,
                    "status" => "1",
                )
            );
        } else {
            echo json_encode(
                array(
                    "message" => "",
                    "status" => "0",
                )
            );
        }
    } catch (Exception $ex) {
        echo json_encode(
            array(
                "message" => "",
                "status" => "-1",
            )
        );
    }
}
//*************************************************************************************
//**********************************   Activate category row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->category[$tblId];
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
//**********************************  De Activate category row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->category[$tblId];
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
//**********************************   Customize category row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["CUSTOMIZE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->category[$tblId];
        $is_custom = 1;
        $property = array("id" => $tblId, "is_custom" => $is_custom);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  UnCustomize category row   **********************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["UNCUSTOMIZE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->category[$tblId];
        $is_custom = 0;
        $property = array("id" => $tblId, "is_custom" => $is_custom);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}
//*************************************************************************************
//*****************************   Select category row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject_id = $category_name = $category_discount = $category_photo = $category_desc = $category_ordering = $category_status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->category()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $subject_id = $result['subject_id'];
            $category_name = $result['name'];
            $category_data_name = $result['data_name'];
            $category_photo = $result['photo'];
            $category_desc = $result['description'];
            $category_type = $result['category_type'];
            $resource_id = $result['resource_id'];
            $author_id = $result['author_id'];
            $category_ordering = $result['ordering'];
            $category_is_custom = $result['is_custom'];
            $category_status = $result['status'];
        }
        echo json_encode(
            array(
                "subject" => $subject_id,
                "name" => $category_name,
                "data_name" => $category_data_name,
                "photo" => $category_photo,
                "desc" => $category_desc,
                "category_type" => $category_type,
                "resource_id" => $resource_id,
                "author_id" => $author_id,
                "ordering" => $category_ordering,
                "is_custom" => $category_is_custom,
                "status" => $category_status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add category    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $resource_id = null;
        $author_id = null;
        $status = 0;
        $is_custom = 0;
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $name = mysql_escape_mimic($_POST['name']);
        $url_name = sanitize(strip_tags($name));
        $data_name = mysql_escape_mimic($_POST['data_name']);
        $desc = mysql_escape_mimic($_POST['description']);
        $category_type = mysql_escape_mimic($_POST['category_type']);
        if (isset($_POST['resource_id'])) {
            $resource_id = mysql_escape_mimic($_POST['resource_id']);
        }
        if (isset($_POST['author_id'])) {
            $author_id = mysql_escape_mimic($_POST['author_id']);
        }
        $post_count = 0;
        $visit_count = 0;
        $ordering = mysql_escape_mimic($_POST['ordering']);
        if (isset($_POST['status']))
            $status = 1;
        if (isset($_POST['custom']))
            $is_custom = 1;

        $register_date = jdate('Y/m/d');

        $photo = "";

        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo = "uploads/admin/category/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $current_time = date("Y-m-d H:i:s");


        $property = array(
            "id" => null, "subject_id" => $subject_id, "name" => $name, "url_name" => $url_name,
            "photo" => $photo, "has_sub" => 0, "sub_count" => 0,
            "description" => $desc, "is_custom" => $is_custom, "data_name" => $data_name,
            "category_type" => $category_type, "resource_id" => $resource_id, "author_id" => $author_id,
            "update_date" => $register_date, "ordering" => $ordering, "status" => $status
        );


        $category = $database->category()->insert($property);
        $file_id = $category['id'];

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
//*****************************   update category    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        $category_id = mysql_escape_mimic($_POST['hashId']);

        $resource_id = null;
        $author_id = null;
        $status = 0;
        $is_custom = 0;
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $name = mysql_escape_mimic($_POST['name']);
        $url_name = sanitize(strip_tags($name));
        $data_name = mysql_escape_mimic($_POST['data_name']);
        $desc = mysql_escape_mimic($_POST['description']);
        $category_type = mysql_escape_mimic($_POST['category_type']);
        if (isset($_POST['resource_id'])) {
            $resource_id = mysql_escape_mimic($_POST['resource_id']);
        }
        if (isset($_POST['author_id'])) {
            $author_id = mysql_escape_mimic($_POST['author_id']);
        }
        $post_count = 0;
        $visit_count = 0;
        $ordering = mysql_escape_mimic($_POST['ordering']);
        if (isset($_POST['status']))
            $status = 1;
        if (isset($_POST['custom']))
            $is_custom = 1;

        $photo = '';
        if (isset($_POST['photo'])) {
            $photo = mysql_escape_mimic($_POST['photo']);
        }

        $edit_row = $database->category[$category_id];

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

        $update_date = jdate('Y/m/d');
        
        $property = array(

            "name" => $name, "url_name" => $url_name,
            "photo" => $photo, "has_sub" => 0, "sub_count" => 0,
            "description" => $desc, "is_custom" => $is_custom, "data_name" => $data_name,
            "category_type" => $category_type, "resource_id" => $resource_id, "author_id" => $author_id,
            "update_date" => $update_date, "ordering" => $ordering, "status" => $status

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
//*****************************   category  List   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    //-------subjectId ----------------
    if (isset($_POST['subject'])) {
        $subject_id = $_POST['subject'];
    }
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
    $count = $database->category()
        ->select(" count(id) as c")
        ->where("subject_id=?", $subject_id)
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->category()
        ->select("*")
        ->where("subject_id=?", $subject_id)
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

    $html = view_to_string("_subject_category.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

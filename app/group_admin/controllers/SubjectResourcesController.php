<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show subject_resources page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1,2), $HOST_NAME);
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

    subject_access_check($this_subject_id, array(1, 2), $HOST_NAME);

    $subject_categories = $database->category()
        ->select("*")
        ->where("subject_id=?", $this_subject_id)
        ->where("status=?", 1)
        ->order("id asc");

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/subject_resources.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete subject_resources row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);

    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->subject_resources[$tblId];
            subject_access_check_ajax($delete_row["subject_id"], array(1, 2), $HOST_NAME);

            
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
//**********************************   Activate subject_resources row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject_resources[$tblId];
        subject_access_check_ajax($update_row["subject_id"], array(1, 2), $HOST_NAME);
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
//**********************************  De Activate subject_resources row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->subject_resources[$tblId];
        subject_access_check_ajax($update_row["subject_id"], array(1, 2), $HOST_NAME);
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
//*****************************   Select subject_resource row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject_id = $resource_id=$category_ids = $photo_address = $title = $importance = $ordering = $status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->subject_resources()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        subject_access_check_ajax($result["subject_id"], array(1, 2), $HOST_NAME);

        if ($result) {
            $subject_id = $result['subject_id'];
            $resource_id = $result['resource_id'];
            $category_ids = $result['category_ids'];
            $photo_address = $result['photo_address'];
            $title = $result['title'];
            $brief_description = $result['brief_description'];
            $user_id = $result['user_id'];
            $importance = $result['importance'];
            $ordering = $result['ordering'];
            $status = $result['status'];

            $category_rows = $database->category()
            ->select("*")
            ->where("subject_id = ?", $subject_id)
            ->where("status = ?", 1);

            $category_ids_array = explode(',', $category_ids);
        
            $categories_options ="<select id='categories' name='categories' class='form-control multi-select-full full-width' multiple='multiple'>"; 
            foreach($category_rows as $category_row){
                if (in_array($category_row["id"], $category_ids_array)) {
                    $categories_options .= "<option selected value='{$category_row["id"]}'>{$category_row["name"]}</option>";
                }else{
                    $categories_options .= "<option value='{$category_row["id"]}'>{$category_row["name"]}</option>";
                }
            }
            $categories_options .= "</option>";

        }
        echo json_encode(
            array(
                "subject_id" => $subject_id,
                "resource_id" => $resource_id,
                "category_ids" => $category_ids,
                "categories_options"=>$categories_options,
                "photo_address" => $photo_address,
                "title" => $title,
                "brief_description" => $brief_description,
                "user_id" => $user_id,
                "importance" => $importance,
                "ordering" => $ordering,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add subject_resource    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    page_access_check_ajax(array(1,2), $HOST_NAME);
    subject_access_check_ajax($_POST['subject_id'], array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $status = 0;
        $resource_id = mysql_escape_mimic($_POST['resource_id']);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $category_ids = mysql_escape_mimic($_POST['category_ids']);
        $importance = mysql_escape_mimic($_POST['importance']);
        $photo_address = mysql_escape_mimic($_POST['photo_address']);
        $title = mysql_escape_mimic($_POST['title']);
        $brief_description = mysql_escape_mimic($_POST['brief_description']);
        $user_id = mysql_escape_mimic($_SESSION["user_id"]);
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $current_time = date("Y-m-d H:i:s");

        $property = array(
            "id" => null, "subject_id" => $subject_id, "resource_id" => $resource_id, "importance" => $importance,
            "category_ids"=>$category_ids,"title" => $title,"brief_description" => $brief_description, "photo_address" => $photo_address, "user_id" => $user_id,
            "register_date" => $current_time, "ordering" => $ordering, "status" => $status
        );


        $subject_resource = $database->subject_resources()->insert($property);
        $file_id = $subject_resource['id'];

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
//*****************************   update subject_resource    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    subject_access_check_ajax($_POST['subject_id'], array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        $status = 0;
        $id = mysql_escape_mimic($_POST['hashId']);
        $resource_id = mysql_escape_mimic($_POST['resource_id']);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $category_ids = mysql_escape_mimic($_POST['category_ids']);
        $importance = mysql_escape_mimic($_POST['importance']);
        $photo_address = mysql_escape_mimic($_POST['photo_address']);
        $title = mysql_escape_mimic($_POST['title']);
        $brief_description = mysql_escape_mimic($_POST['brief_description']);
        $user_id = mysql_escape_mimic($_SESSION["user_id"]);
        $ordering = mysql_escape_mimic($_POST['ordering']);
        $current_time = date("Y-m-d H:i:s");

        $edit_row = $database->subject_resources[$id];

        $update_date = jdate('Y/m/d');
        
        $property = array(
            "subject_id" => $subject_id, "resource_id" => $resource_id, "importance" => $importance,
            "category_ids"=>$category_ids,"title" => $title,"brief_description" => $brief_description,
            "photo_address" => $photo_address, "user_id" => $user_id,
            "register_date" => $current_time, "ordering" => $ordering, "status" => $status
        );



        $affected = $edit_row->update($property);

        if ($affected == null) {
          
            $msg = "خطا در بروز رسانی داده ها";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,

                )
            );
            exit;
        } else {

           
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
//*****************************   subject_resource  List   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    //-------subjectId ----------------
    if (isset($_POST['subject'])) {
        $subject_id = $_POST['subject'];
    }

    subject_access_check_ajax($subject_id, array(1, 2), $HOST_NAME);

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
    $count = $database->subject_resources()
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


    $rows = $database->subject_resources()
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

    $html = view_to_string("_subject_resources.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}


//*************************************************************************************
//*****************************   List Resources ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&   isset($_POST["check"]) && $_POST["check"] == $_SESSION["POST_RESOURCE_LIST_CODE"]) {


    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);



    $search_exp = "";
    // Define variables and set to empty values
    if (isset($_POST["exp"])) {
        $search_exp = mysql_escape_mimic($_POST["exp"]);
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
        $item_per_page = 9;
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


    $count = $database->resources()
        ->select(" count(id) as c")
        ->where("title LIKE ?", "%{$search_exp}%")
        ->fetch();

    //------------
    $get_total_rows = $count["c"];
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);

    $rows = $database->resources()
        ->select("*")
        ->where("title LIKE ?", "%{$search_exp}%")
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

    $html = view_to_string("_resourceList.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);

    if($total_pages > $page_number){    
        $page_number++;
    }

    echo json_encode(
        array(
            "status" => '1',
            "html" => $html,
            "page_number" => $page_number,
            "total_pages" => $total_pages,
            "message" => 'عملیات موفقیت آمیز',
        )
    );
    exit;
}
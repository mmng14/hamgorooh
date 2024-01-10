<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show user group page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "users";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    if (isset($url_user_id)) {
        $fname = "";
        $lname = "";
        $user_name = "";

        $user = $database->users[$url_user_id];
        $fname = $user['name'];
        $lname = $user['family'];
        $user_name = $user['username'];

        $user_info = $fname . " " . $lname . "(" . $user_name . ")";
    } else {
        $user = 0;
        $user_info = "";
    }

    $user_subjects = $database->user_subjects()
        ->select("*")
        ->where("status=?", 1)
        ->where("user_id=?", $user["id"])
        ->where("role <> ?", 2);


    $user_subject_list = array();

    if ($user_subjects) {
        foreach ($user_subjects as $user_subject_item) {
            $user_subject_list[] = $user_subject_item["subject_id"];
        }
    }


    $subject_list = $database->subject()
        ->select("*")
        ->where("status = ?", 1)
        ->where("id", $user_subject_list)
        ->order("ordering asc");

    $page_number = '0';
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/user_groups.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete user group row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->user_groups[$tblId];

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
//*****************************   Select user group row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject = $group_id = $user = $role = $user_rights =  $status  = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->user_groups()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $subject = $result['subject_id'];
            $group_id = $result['group_id'];
            $user = $result['user_id'];
            $role = $result['role'];
            $user_rights = $result['user_rights'];
            $status = $result['status'];
        }
        echo json_encode(
            array(
                "subject" => $subject,
                "group" => $group_id,
                "user" => $user,
                "role" => $role,
                "user_rights" => $user_rights,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   Category List for combobox   ********************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["SET_CATEGORY_CODE"]) {
    // Define variables and set to empty values
    $category_list = "";
    $subjectId = test_input($_POST['s']);
    $categoryId = test_input($_POST['c']);

    if ($categoryId != "") {

        $rows = $database->category()
            ->select("*")
            ->where("subject_id=?", $subjectId);


        $category_list .= "<option value='0' >همه گروه‌ها</option>";
        foreach ($rows as $result) {
            
            if ($categoryId != 0 && $categoryId == $result["id"])
                $category_list .= "<option value='" . $result["id"] . "' selected >" . $result["name"] . "</option>";
            else
                $category_list .= "<option value='" . $result["id"] . "' >" . $result["name"]. "</option>";
        
            }
    }

    echo  $category_list; //html response
   

}

//*************************************************************************************
//**********************************   Activate user group row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->user_groups[$tblId];
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
//**********************************  De Activate user group row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->user_groups[$tblId];
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

//****************************************************************************
//*****************************   Add user group    ************************
//****************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {
        $status = 0;
        $category = 0;
        $url_user_id = mysql_escape_mimic($_POST['user_id']);
        $subject = mysql_escape_mimic($_POST['subject']);
        if (isset($_POST['group']))
            $category = mysql_escape_mimic($_POST['group']);
        else
            $category = -1;
        $role = mysql_escape_mimic($_POST['role']);

        $user_rights = mysql_escape_mimic($_POST['rights']);
        $register_date = date('Y/m/d H:i:s');
        if (isset($_POST['status']))
            $status = 1;

        if ($category != 0 && $category != -1) {
            //Check if didn't added before

            $find = $database->user_groups()
                ->select("id")
                ->where("user_id = ?", $url_user_id)
                ->where("group_id = ?", $category)
                ->fetch();

            if (!$find) {

                $property = array(
                    "id" => null, "user_id" => $url_user_id, "subject_id" => $subject, "group_id" => $category,
                    "register_date" => $register_date, "role" => $role, "user_rights" => $user_rights, "status" => $status
                );

                $user_groups = $database->user_groups()->insert($property);
                $file_id = $user_groups['id'];

                if ($file_id == null || $file_id == '') {
                    $msg = "خطا در ذخیره سازی داده ها";
                    echo json_encode(
                        array(
                            "status" => '0',
                            "message" => $msg,

                        )
                    );
                } else {
                    $msg = "داده ها با موفقیت ثبت شد";
                    echo json_encode(
                        array(
                            "status" => '1',
                            "message" => $msg,

                        )
                    );
                }
            } else {
                $msg = "قبلا ذخیره شده است";
                echo json_encode(
                    array(
                        "status" => '0',
                        "message" => $msg,

                    )
                );
            }
        }

        if ($category == 0) {

            $all_categories = $database->category()
                ->select("id,name,subject_id")
                ->where("subject_id = ?", $subject)
                ->where("status = ?", 1);

            foreach ($all_categories as $cat) {

                $find = $database->user_groups()
                    ->select("id")
                    ->where("user_id = ?", $url_user_id)
                    ->where("group_id = ?", $cat['id'])
                    ->fetch();
                if (!$find) {

                    $property = array(
                        "id" => null, "user_id" => $url_user_id, "subject_id" => $subject, "group_id" => $cat['id'],
                        "register_date" => $register_date, "role" => $role, "user_rights" => $user_rights, "status" => $status
                    );
                    $user_groups = $database->user_groups()->insert($property);
                }
            }
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
//*****************************   Update user group    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $user_group_id = mysql_escape_mimic($_POST['hashId']);
        $status = 0;
        $category = 0;
        $subject = mysql_escape_mimic($_POST['subject']);
        if (isset($_POST['group']))
            $category = mysql_escape_mimic($_POST['group']);
        else
            $category = 0;
        $role = mysql_escape_mimic($_POST['role']);
        $user_rights = mysql_escape_mimic($_POST['rights']);
        if (isset($_POST['chkstatus']))
            $status = 1;
        $edit_row = $database->user_groups[$user_group_id];

        $property = array(
            "subject_id" => $subject, "group_id" => $category,
            "role" => $role, "user_rights" => $user_rights, "status" => $status
        );

        $affected = $edit_row->update($property);

        if ($affected == null) {
            $msg = "خطا در بروز رسانی داده ها  ";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,

                )
            );
        } else {

            $msg = "داده ها با موفقیت بروز رسانی شد";
            echo json_encode(
                array(
                    "status" => '1',
                    "message" => $msg,

                )
            );
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
//*****************************   User Group List   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);


    //-------userId ----------------
    if (isset($_POST['uid'])) {
        $user_id = $_POST['uid'];
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
    $count = $database->user_groups()
        ->select(" count(id) as c")
        ->where("user_id=?", $user_id)
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->user_groups()
        ->select("*")
        ->where("user_id=?", $user_id)
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

     $viewModel = [];

     $subject_rows = $database->subject()
     ->select("id,name")
     ->where("status=?", 1);

     $category_rows = $database->category()
     ->select("id,name")
     ->where("status=?", 1);

   if (isset($rows)){

            foreach ($rows as $row){

                $subject_name = "نام موضوع";
                foreach ($subject_rows as $subject_row){
                    if($subject_row["id"]==$row["subject_id"]){
                        $subject_name = $subject_row["name"];
                    }
                 }

                 $group_name = "نام گروه";
                 foreach ($category_rows as $category_row){
                    if($category_row["id"]==$row["group_id"]){
                        $group_name = $category_row["name"];
                    }
                 }


                $viewModel[] = ["id" =>  $row['id'],
                "subject_id" =>  $row['subject_id'],
                "subject_name" =>  $subject_name,
                "group_id" =>  $row['group_id'],
                "group_name" =>  $group_name,
                "user_id" =>  $row['user_id'],
                "role" =>  $row['role'],
                "user_rights" =>  $row['user_rights'],
                "register_date" =>  $row['register_date'],
                "status" =>  $row['status']];
            }
        }
        
    $html =  view_to_string("_user_groups.php", "app/admin/views/partial/", $viewModel, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
   
    echo $html;
    exit;
}

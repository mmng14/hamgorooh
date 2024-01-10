<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show user subject page   ************************
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

    //Get subject for combobox
    $subject_rows = $database->subject()
        ->where("status = ?", 1);

    $page_number = '0';
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/user_subjects.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete user subject row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->user_subjects[$tblId];

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
//*****************************   Select user subject row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject = $subject_name = $user = $role = $user_rights = $status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->user_subjects()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $subject = $result['subject_id'];
            $subject_name = $result['subject_name'];
            $user = $result['user_id'];
            $role = $result['role'];
            $user_rights = $result['user_rights'];
            $status = $result['status'];
        }
        echo json_encode(
            array(
                "subject" => $subject,
                "subject_name" => $subject_name,
                "user" => $user,
                "role" => $role,
                "user_rights" => $user_rights,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//**********************************   Activate user subject row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->user_subjects[$tblId];
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
//**********************************  De Activate user subject row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->user_subjects[$tblId];
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
//*****************************   add user subject    ************************
//****************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $status = 0;
        $category = 0;
        $url_user_id = mysql_escape_mimic($_POST['user_id']);
        $subject = mysql_escape_mimic($_POST['subject']);
        $subject_name = mysql_escape_mimic($_POST['subject_name']);
        $role = mysql_escape_mimic($_POST['role']);
        $user_rights = mysql_escape_mimic($_POST['rights']);
        $now = date('Y/m/d H:i:s');
        $request_date = $now;
        $accept_date = $now;
        $accept_user =  $_SESSION["user_id"];
        $visited = 0;
        if (isset($_POST['status']))
            $status = 1;

        if ($subject != 0 && $subject != -1) {
            //Check if didn't added before
            $find = $database->user_subjects()
                ->select("id")
                ->where("user_id = ?", $url_user_id)
                ->where("subject_id = ?", $subject)
                ->fetch();

            if (!$find) {



                $property = array(
                    "id" => null, "user_id" => $url_user_id, "subject_id" => $subject,
                    "subject_name" => $subject_name, "role" => $role, "user_rights" => $user_rights,
                    "request_date" => $request_date, "accept_date" => $accept_date, "accept_user" => $accept_user,
                    "visited" => $visited, "status" => $status
                );

                $user_subjects = $database->user_subjects()->insert($property);
                $file_id = $user_subjects['id'];


                if ($file_id == null || $file_id == '') {
                    $msg = "خطا در ذخیره سازی داده ها";
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
            } else {
                $msg = "قبلا ذخیره شده است";
                echo json_encode(
                    array(
                        "status" => '0',
                        "message" => $msg,

                    )
                );
                exit;
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
//*****************************   update user subject    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $user_subject_id = mysql_escape_mimic($_POST['hashId']);
        $status = 0;
        $subject = mysql_escape_mimic($_POST['subject']);
        $subject_name = mysql_escape_mimic($_POST['subject_name']);
        $role = mysql_escape_mimic($_POST['role']);
        $user_rights = mysql_escape_mimic($_POST['rights']);

        if (isset($_POST['status']))
            $status = 1;


        $edit_row = $database->user_subjects[$user_subject_id];
        $edit_row_user_id = $edit_row["user_id"];
        $property = array(
            "subject_id" => $subject,
            "subject_name" => $subject_name, "role" => $role, "user_rights" => $user_rights,
            "status" => $status
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
//*****************************   User subject List   *****************************
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
    $count = $database->user_subjects()
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


    $rows = $database->user_subjects()
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
    //echo json_encode($data);

    $html = view_to_string("_user_subjects.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

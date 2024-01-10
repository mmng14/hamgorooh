<?php
//require_once "includes/utility_controller.php";

/////////////////////
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2), $HOST_NAME);
    include 'libraries/csrf_validation.php';

    $this_category_id = "";
    $this_subject_id = "";
    $this_category_name = "";

    if (isset($url_cat_id)) {

        $this_category_id = $url_cat_id;
        //--Get Category Name
        $category = $database->category[$this_category_id];
        $this_category_name = $category["name"];
        $this_subject_id = $category['subject_id'];
    }

    //-----------Header HTML -----------/
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/user_management.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


//********************************************************************************
//*********************************   Add Group User Role   ***************************
//********************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["subjId"]) && isset($_POST["catId"]) &&  isset($_POST["role"]) && isset($_POST["userId"])  && isset($_POST['check']) && $_POST['check'] = $_SESSION["LISTING_CODE"]) {
    try {


        page_access_check_ajax(array(1, 2), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);


        $subject_id = mysql_escape_mimic($_POST['subjId']);
        $category_id = mysql_escape_mimic($_POST['catId']);
        $user_id = mysql_escape_mimic($_POST['userId']);
        $role = mysql_escape_mimic($_POST['role']);
        $register_date = date('Y/m/d H:i:s');
        $user_rights = "777";
        $status = 1;

        $find_row = $database->user_groups()
            ->where("subject_id = ?", $subject_id)
            ->where("group_id = ?", $category_id)
            ->where("user_id = ?", $user_id)
            ->fetch();


        $action = "";
        if ($find_row) {
            $row_id = $find_row['id'];
            $edit_row = $database->user_groups[$row_id];

            $property = array(
                "subject_id" => $subject_id, "group_id" => $category_id,
                "register_date" => $register_date, "role" => $role, "user_rights" => $user_rights, "status" => $status
            );

            $affected = $edit_row->update($property);
            $action = " بروز رسانی ";
        } else {
            $property = array(
                "id" => null, "user_id" => $user_id, "subject_id" => $subject_id, "group_id" => $category_id,
                "register_date" => $register_date, "role" => $role, "user_rights" => $user_rights, "status" => $status
            );
            try {
                $user_groups = $database->user_groups()->insert($property);
                $row_id = $user_groups['id'];
                $affected = true;
                $action = " افزودن ";
            } catch (PDOException $e) {
                $affected = false;
                $action = $e->getMessage();
            }
        }



        if ($affected == null || !$affected) {
            $msg = "خطا در انجام عملیات  " . $action;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
        } else {
            $msg = "  عملیات موفق " . $action;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "1",
                    "role" => $role,
                    "user_id" => $user_id,
                    "group_id" => $category_id,
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
//*********************************   Subject Users  List   ***************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cmd"]) && isset($_POST["subj"]) && isset($_POST["cat"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {


    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $subject_id = mysql_escape_mimic($_POST['subj']);
    $category_id = mysql_escape_mimic($_POST['cat']);

    $user_subjects = $database->user_subjects()
        ->select("*")
        ->where("status=?", 1)
        ->where("user_id <> ?",  $_SESSION["user_id"])
        ->where("subject_id=?", $subject_id);


    $subject_user_list = array();

    if ($user_subjects) {
        foreach ($user_subjects as $user_subject_item) {
            $subject_user_list[] = $user_subject_item["user_id"];
        }
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

    //get total number of records from database for pagination

    $get_total_rows = $database->users()
        ->where("status = ?", 1)
        ->where("id", $subject_user_list)
        ->count("id");
    //break records into pages
    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);

    //SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause


    $rows = $database->users()
        ->where("status = ?", 1)
        ->where("id", $subject_user_list)
        ->order("{$order}")
        ->limit($item_per_page, $page_position);

    $user_group_rows = $database->user_groups()
        ->select("*")
        ->where("status = ?", 1)
        ->where("group_id=?",  $category_id);


    $user_groups =

        $pagination = array(
            "item_per_page" => $item_per_page,
            "page_number" => $page_number,
            "total_rows" => $get_total_rows,
            "total_pages" => $total_pages,
        );

    $viewModel = [];

    if (isset($rows)) {

        foreach ($rows as $row) {

            //todo handle later
            $found = false;
            foreach ($user_group_rows as $user_group_row) {
                if ($user_group_row["user_id"] == $row["id"]) {
                    $user_group_role = $user_group_row["role"];
                    $user_group_rights = $user_group_row["user_rights"];
                    $user_group_register_date = $user_group_row["register_date"];
                    $found = true;
                }
            }

            if (!$found) {
                $user_group_role = "0";
                $user_group_rights = "";
                $user_group_register_date = "";
            }

            $viewModel[] = [
                "id" =>  $row['id'],
                "fname" => $row['name'],
                "lname" => $row['family'],
                "email" => $row['email'],
                "user_name" => $row['username'],
                "phone" => $row['phone'],
                "birth_date" => $row['birth_date'],
                "address" => $row['address'],
                "photo" => $row['photo'],
                "gender" => $row['gender'],
                "role" =>   $user_group_role,
                "user_rights" =>  $user_group_rights,
                "register_date" =>  $user_group_register_date,
                "status" =>  $row['status']
            ];
        }
    }



    $html = view_to_string("_users.php", "app/group_admin/views/partial/", $viewModel, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
}

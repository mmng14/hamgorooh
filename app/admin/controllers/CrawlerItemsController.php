<?php

//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show crawler items page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "crawler_items";
    $selected_subject_id = 0;
    $selected_subject_name = "";
    $selected_source_id = 0;
    $selected_source_name = "";

    $page_number = 1;


    if (isset($url_subject_id) && is_numeric($url_subject_id)) {

        $selected_subject_id = (int)$url_subject_id;
        $categories = $database->category()
            ->select("*")
            ->where("subject_id=?", $selected_subject_id);
    } else {
        echo "<h1> Subject Code Is Not Valid </h1>";
        exit;
    }

    if (isset($url_source_id) && is_numeric($url_source_id)) {

        $selected_source_id = (int)$url_source_id;
        $database_subject = getSubjectDatabase($selected_subject_id);
        $crawler_source = $database_subject->crawler_source()
            ->select("*")
            ->where("id=?", $selected_source_id);
    } else {
        echo "<h1> Subject Code Is Not Valid </h1>";
        exit;
    }

    if (isset($url_page_number) && is_numeric($url_page_number)) {

        $page_number = $url_page_number;
    }


    //-------CSRF Check----------
    include_once 'libraries/csrf_validation.php';
    $OP_CODE_LIST = "LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,
    INSERT_CODE,GET_SUBCATEGORY_LIST_CODE,";


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/crawler_items.view.php";
    include_once $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete crawler items row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {


    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["subject_id"]);
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {

            $delete_row = $database_subject->crawler_items[$tblId];

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
//**********************************   Activate crawler items row   ********************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] ==  $_SESSION["ACTIVATE_CODE"]) {


    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["subject_id"]);
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {
            $update_row = $database_subject->crawler_items[$tblId];

            $status = 1;
            $property = array("id" => $tblId, "status" => $status);
            $affected = $update_row->update($property);
            echo json_encode(
                array(
                    "state" => '1',
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
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  De Activate crawler items row   ******************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) &&
    $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]
) {

    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["subject_id"]);
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {
            $update_row = $database_subject->crawler_items[$tblId];
            $status = 0;
            $property = array("id" => $tblId, "status" => $status);
            $affected = $update_row->update($property);
            echo json_encode(
                array(
                    "state" => '1',
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
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//*****************************   Select crawler items row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["subject_id"]);
        // Define variables and set to empty values
        $source_id = $subject_id = $category_id = $sub_category_id =
            $item_link = $crawler = $source_name = $source_link = "";
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {
            $result = $database_subject->crawler_items()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();

            if ($result) {

                $source_id = $result['source_id'];
                $subject_id = $result['subject_id'];
                $category_id = $result['category_id'];
                $sub_category_id = $result['sub_category_id'];
                $crawler = $result['crawler'];
                $source_name = $result['source_name'];
                $source_link = $result['source_link'];
                $item_link = $result['item_link'];
                $status = $result['status'];
            }
            echo json_encode(
                array(
                    "source_id" => $source_id,
                    "subject_id" => $subject_id,
                    "category_id" => $category_id,
                    "sub_category_id" => $sub_category_id,
                    "crawler" => $crawler,
                    "source_name" => $source_name,
                    "source_link" => $source_link,
                    "item_link" => $item_link,
                    "status" => $status,
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
                "state" => '1',
            )
        );
    }
}


//*************************************************************************************
//*****************************   add crawler sources    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["subject_id"]);
        $status = 0;
        $category_type = mysql_escape_mimic($_POST['category_type']);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $category_id = mysql_escape_mimic($_POST['category_id']);
        $sub_category_id = mysql_escape_mimic($_POST['sub_category_id']);
        $site_name = mysql_escape_mimic($_POST['site_name']);
        $crawler = mysql_escape_mimic($_POST['crawler']);
        $source_name = mysql_escape_mimic($_POST['source_name']);
        $source_link = mysql_escape_mimic($_POST['source_link']);
        $item_link = mysql_escape_mimic($_POST['item_link']);
        $register_date = date('Y/m/d H:i:s');
        $status = mysql_escape_mimic($_POST['status']);


        $property = array(
            "id" => null, "category_type" => $category_type, "subject_id" => $subject_id,
            "category_id" => $category_id, "sub_category_id" => $sub_category_id,
            "site_name" => $site_name, "crawler" => $crawler, "source_name" => $source_name,
            "source_link" => $source_link, "item_link" => $item_link,
            "status" => $status
        );

        $resources = $database_subject->crawler_items()->insert($property);
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
//*****************************   update crawler sources    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["subject_id"]);

        $sources_id = mysql_escape_mimic($_POST['hashId']);
        $status = 0;
        $category_type = mysql_escape_mimic($_POST['category_type']);
        $subject_id = mysql_escape_mimic($_POST['subject_id']);
        $category_id = mysql_escape_mimic($_POST['category_id']);
        $sub_category_id = mysql_escape_mimic($_POST['sub_category_id']);
        $site_name = mysql_escape_mimic($_POST['site_name']);
        $crawler = mysql_escape_mimic($_POST['crawler']);
        $source_name = mysql_escape_mimic($_POST['source_name']);
        $source_link = mysql_escape_mimic($_POST['source_link']);
        $register_date = date('Y/m/d H:i:s');
        $status = mysql_escape_mimic($_POST['status']);



        $edit_row = $database_subject->crawler_items[$sources_id];


        $property = array(
            "category_type" => $category_type, "subject_id" => $subject_id, "category_id" => $category_id,
            "sub_category_id" => $sub_category_id,
            "site_name" => $site_name, "crawler" => $crawler, "source_name" => $source_name,
            "source_link" => $source_link, "item_link" => $item_link,
            "status" => $status
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
//*****************************   Crawler Sources  List   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) &&
    $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {


    page_access_check(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $subject_id = $_POST["subject_id"];
    $source_id = $_POST["source_id"];
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($subject_id);

    //--------------------------- page -----------------------------
    //Get page number from Ajax POST
    if (isset($_POST["page"])) {
        $page_number = filter_var(
            mysql_escape_mimic($_POST["page"]),
            FILTER_SANITIZE_NUMBER_INT,
            FILTER_FLAG_STRIP_HIGH
        ); //filter number
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
    } else {
        $item_per_page = 10;
    }
    //---------------------------------------------------------------
    //-------------------------- order -------------------------------
    if (isset($_POST['order'])) {
        $orderBy = mysql_escape_mimic($_POST['order']);
        if ($orderBy == 1) {
            $order = 'id DESC';
        } elseif ($orderBy == 2) {
            $order = 'id ASC';
        }
    } else {
        $orderBy = 2;
        $order = 'id DESC';
    }

    $subject_filter = 0;
    //if subject filter is set
    if (isset($subject_id) && is_numeric($subject_id) && $subject_id != 0) {
        $subject_filter = mysql_escape_mimic($subject_id);
    }
    $subject_check = "subject_id = ?";
    if ($subject_filter == 0) {
        $subject_filter = 1;
        $subject_check = " 1 = ?";
    }


    $source_filter = 0;
    //if subject filter is set
    if (isset($source_id) && is_numeric($source_id) && $source_id != 0) {

        $source_filter = mysql_escape_mimic($source_id);
    }
    $source_check = "source_id = ?";
    if ($source_filter == 0) {
        $source_filter = 1;
        $source_check = " 1 = ?";
    }

    //-----------------------------------------------------------------
    $count = $database_subject->crawler_items()
        ->select(" count(id) as c")
        ->where($subject_check, $subject_filter)
        ->where($source_check, $source_filter)
        ->fetch();

    //------------
    $get_total_rows = $count["c"] != null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number) {
        $page_number = 1;
    }

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);

    $rows = $database_subject->crawler_items()
        ->select("*")
        ->where($subject_check, $subject_filter)
        ->where($source_check, $source_filter)
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


    $html = view_to_string(
        "_crawler_items.php",
        "app/admin/views/partial/",
        $rows,
        $pagination,
        $SUBFOLDER_NAME,
        $HOST_NAME
    );
    echo $html;
    exit;
}

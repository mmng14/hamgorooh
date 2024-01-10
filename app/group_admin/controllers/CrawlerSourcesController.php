<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show crawler sources page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1,2), $HOST_NAME);
    $active_menu = "resources";
    $selected_subject_id = 0;
    $page_number = 1;

    if (isset($url_subject_id) && is_numeric($url_subject_id)) {

        $selected_subject_id = (int)$url_subject_id;
        subject_access_check($selected_subject_id, array(1, 2), $HOST_NAME);

        $categories = $database->category()
            ->select("*")
            ->where("subject_id=?", $selected_subject_id);

    } else {
        echo "<h1> Subject Code Is Not Valid </h1>";
        exit;
    }

    if (isset($url_page_number)) {
        if (is_numeric($url_page_number)) {
            $page_number = $url_page_number;
        }
    }


    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    $OP_CODE_LIST = "LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,INSERT_CODE,GET_SUBCATEGORY_LIST_CODE,";


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/crawler_sources.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   sub_category List for combobox   ********************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_SUBCATEGORY_LIST_CODE"]) {

    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $categoryId = $sub_category_id = 0;

    subject_access_check_ajax($_POST["s_id"],  array(1, 2), $HOST_NAME);
    $user_id = $_SESSION["user_id"];
    // Define variables and set to empty values
    $txtsub_category = "";
    $categoryId = test_input($_POST['c']);
    $sub_category_id = test_input($_POST['sc']);

    if ($categoryId != "") {
        $rows = $database->sub_category()
            ->select("*")
            ->where("status=?", 1)
            ->where("category_id=?", $categoryId);


        $txtsub_category .= '<option value="0" >انتخاب کنید</option>';
        foreach ($rows as $result) {
            if ($sub_category_id != 0 && $sub_category_id == $result["id"])
                $txtsub_category .= '<option value="' . $result["id"] . '" selected >' . $result["name"] . '</option>';
            else
                $txtsub_category .= '<option value="' . $result["id"] . '" >' . $result["name"] . '</option>';
        }
    }

    echo json_encode(
        array(
            "status" => "1",
            "html" =>  $txtsub_category,
            "message" => "عملیات با موفقیت  انجام شد",
        )
    );
    //echo $txtsub_category;
}

//*************************************************************************************
//*****************************   Delete crawler sources row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {


    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        subject_access_check_ajax($_POST["s_id"],  array(1, 2), $HOST_NAME);
        $database_subject = getSubjectDatabase($_POST["s_id"]);
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {

            $delete_row = $database_subject->crawler_source[$tblId];

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
//**********************************   Activate crawler sources row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] ==  $_SESSION["ACTIVATE_CODE"]) {


    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        subject_access_check_ajax($_POST["s_id"],  array(1, 2), $HOST_NAME);
        $database_subject = getSubjectDatabase($_POST["s_id"]);
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {
            $update_row = $database_subject->crawler_source[$tblId];
          
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
//**********************************  De Activate crawler sources row   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        subject_access_check_ajax($_POST["s_id"],  array(1, 2), $HOST_NAME);
        $database_subject = getSubjectDatabase($_POST["s_id"]);
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {
            $update_row = $database_subject->crawler_source[$tblId];
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
//*****************************   Select crawler sources row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        subject_access_check_ajax($_POST["s_id"],  array(1, 2), $HOST_NAME);
        $database_subject = getSubjectDatabase($_POST["s_id"]);
        // Define variables and set to empty values
        $category_type = $subject_id = $category_id = $sub_category_id = $site_name = $crawler = $source_name = $source_link = "";
        $tblId = test_input($_POST["obj"]);

        if ($tblId != "") {
            $result = $database_subject->crawler_source()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();

            if ($result) {

                $category_type = $result['category_type'];
                $subject_id = $result['subject_id'];
                $category_id = $result['category_id'];
                $sub_category_id = $result['sub_category_id'];
                $site_name = $result['site_name'];
                $crawler = $result['crawler'];
                $source_name = $result['source_name'];
                $source_link = $result['source_link'];
                $status = $result['status'];
            }
            echo json_encode(
                array(
                    "category_type" => $category_type,
                    "subject_id" => $subject_id,
                    "category_id" => $category_id,
                    "sub_category_id" => $sub_category_id,
                    "site_name" => $site_name,
                    "crawler" => $crawler,
                    "source_name" => $source_name,
                    "source_link" => $source_link,
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

    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        subject_access_check_ajax($_POST["subject_id"],  array(1, 2), $HOST_NAME);
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
        $register_date = date('Y/m/d H:i:s');
        $status = mysql_escape_mimic($_POST['status']);


        $property = array(
            "id" => null, "category_type" => $category_type, "subject_id" => $subject_id, "category_id" => $category_id, "sub_category_id" => $sub_category_id,
            "site_name" => $site_name, "crawler" => $crawler, "source_name" => $source_name, "source_link" => $source_link,
            "status" => $status
        );

        $resources = $database_subject->crawler_source()->insert($property);
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

    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        subject_access_check_ajax($_POST["subject_id"],  array(1, 2), $HOST_NAME);
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



        $edit_row = $database_subject->crawler_source[$sources_id];


        $property = array(
            "category_type" => $category_type, "subject_id" => $subject_id, "category_id" => $category_id, "sub_category_id" => $sub_category_id,
            "site_name" => $site_name, "crawler" => $crawler, "source_name" => $source_name, "source_link" => $source_link,
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
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {


    page_access_check(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    subject_access_check_ajax($_POST["sf"],  array(1, 2), $HOST_NAME);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["sf"]);

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
    $count = $database_subject->crawler_source()
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

    $rows = $database_subject->crawler_source()
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

    $html = view_to_string("_crawler_sources.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

<?php
//require_once  "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {


    page_access_check(array(1, 2), $HOST_NAME);
    //Check user access if user is group_admin or user
    subject_access_check($url_subject_id, null, $HOST_NAME);

    include 'libraries/csrf_validation.php';

    $active_menu = "comments";

    $pagetitle = "نظرات";
    $pagedesc = "";
    $keywords = "";

    $selected_subject_id = 0;
    $selected_category_id = 0;
    $selected_post_id = 0;

    $page_number = 1;

    if (isset($url_subject_id)) {
        if (is_numeric($url_subject_id)) {
            $selected_subject_id = (int) $url_subject_id;
        }
    }

    if (isset($url_category_id)) {
        if (is_numeric($url_category_id)) {
            $selected_category_id = (int) $url_category_id;
        }
    }

    if (isset($url_post_id)) {
        if (is_numeric($url_post_id)) {
            $selected_post_id = (int) $url_post_id;
        }
    }

    if (isset($url_page_number)) {
        if (is_numeric($url_page_number)) {
            $page_number = $url_page_number;
        }
    }

  

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;

    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/comments.view.php";
    return   include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*********************************   Delete comment row   ****************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check(array(1, 2), $HOST_NAME);
    subject_access_check_ajax($_POST["s_id"], null, $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["s_id"]);

        $comment_id = test_input($_POST["obj"]);

        $delete_row = $database_subject->comment[$comment_id];

        $affected = $delete_row->delete();

        echo json_encode(
            array(

                "result" => "1",
                "redirect" => "",
                "message" => "رکورد با موفقیت حذف شد",
                "status" => "1",
            )
        );
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
//**********************************   Activate comment row   *************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {

    page_access_check(array(1, 2), $HOST_NAME);
    subject_access_check_ajax($_POST["s_id"], null, $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $comment_id = test_input($_POST["obj"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    if ($comment_id != "") {
        $update_row = $database_subject->comment[$comment_id];
        $status = 1;
        $approved = 1;
        $property = array("approved" => $approved, "status" => $status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  DeActivate comment row   ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check(array(1, 2), $HOST_NAME);
    subject_access_check_ajax($_POST["s_id"], null, $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $comment_id = test_input($_POST["obj"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    if ($comment_id != "") {
        $update_row = $database_subject->comment[$comment_id];
        $status = 0;
        $approved = 0;
        $property = array("approved" => $approved, "status" => $status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}


//*************************************************************************************
//********************************   comment  List   **********************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    //Auth Check
    page_access_check(array(1, 2), $HOST_NAME);
    subject_access_check_ajax($_POST["s_id"], null, $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    $user_id = 0;
    $user_id = $_SESSION["user_id"];

    $category_filter = 0;
    //if category filter is set
    if (isset($_POST["c_id"])); {
        if (is_numeric($_POST["c_id"]) && $_POST["c_id"] != 0) {
            $category_filter = mysql_escape_mimic($_POST["c_id"]);
        }
    }

    $post_filter = 0;
    //if post filter is set
    if (isset($_POST["p_id"])); {
        if (is_numeric($_POST["p_id"]) && $_POST["p_id"] != 0) {
            $post_filter = mysql_escape_mimic($_POST["p_id"]);
        }
    }

    //------------------
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

    $category_check = "post_category_id = ?";
    if ($category_filter == 0) {
        $category_filter = 1;
        $category_check = " 1 = ?";
    }

    $post_check = "post_id = ?";
    if ($post_filter == 0) {
        $post_filter = 1;
        $post_check = " 1 = ?";
    }



    $count = $database_subject->comment()
        ->select(" count(id) as c")
        ->where($category_check, $category_filter)
        ->where($post_check, $post_filter)
        ->where("title LIKE ?", "%{$search_exp}%")
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database_subject->comment
        ->where($category_check, $category_filter)
        ->where($post_check, $post_filter)
        ->where("content LIKE ?", "%{$search_exp}%")
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

    $html = view_to_string("_comments.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

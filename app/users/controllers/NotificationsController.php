<?php
//require_once "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show Notifications page   ************************
//*************************************************************************************
//[GET]
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    /////////////////////
    $active_menu = "notifications";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    //--------------------------


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/notifications.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}




//*************************************************************************************
//*****************************    List Records   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {
    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $database_notifications = getNotificationsDatabase();

    $user_id = 0;
    $user_id = $_SESSION["user_id"];

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
    $count = $database_notifications->notifications()
        ->select(" count(id) as c")
        ->where("user_id=?", $user_id)
        ->fetch();

    //------------
    $get_total_rows = $count["c"];
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);



    $rows = $database_notifications->notifications()
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


    $html = view_to_string("_notifications.php", "app/users/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}



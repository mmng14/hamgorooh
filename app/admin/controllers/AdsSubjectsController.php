<?php
//require_once "includes/utility_controller.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    /////////////////////
    $active_menu = "ads";

    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    //--------------------------
    $ads_id = 0;
    if (isset($url_ads_id)) {
        $ads_id = $url_ads_id;
    }

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/ads_subjects.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


//*************************************************************************************
//******************************   SEND TO ALL SUBJECTS API   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_ALL_SUBJECTS_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    try {
        $title = $start_date = $end_date = $link_address = $type = $price = $ordering = $photo = $desc = $status = "";
        $tblId = test_input($_POST["obj"]);
        $results = "";

        if ($tblId != "") {


            $ads = $database->ads[$tblId];

            $subject_sites = $database->subject_sites()
                ->select("*");

            foreach ($subject_sites as $subject_site) {
                $id = $ads['id'];
                $title = $ads['title'];
                $start_date = $ads['start_date_num'];
                $end_date = $ads['end_date_num'];
                $link_address = $ads['link_address'];
                $type = $ads['type'];
                $price = $ads['price_per_day'];
                $photo = $ads['photo'];
                $desc = $ads['description'];
                $ordering = $ads['ordering'];
                $status = $ads['status'];
                $photo_address = $HOST_NAME . $photo;

                $data_to_post_ads = array(
                    "id" => "$id", "title" => "$title", "description" => "$desc",
                    "keywords" => $title, "photo_address" => "$photo_address", "link_address" => "$link_address",
                    "start_date" => "$start_date", "end_date" => "$end_date", "ordering" => "1", "position" => "$type", "status" => $status
                );


                $remote_url =  $subject_site["recieve_link"] . "insert/ads";
                $ch = curl_init($remote_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post_ads);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $return_data = curl_exec($ch);
                $results .= $return_data . ",";
            }
            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $data_to_post_ads,
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
    exit;
}

//*************************************************************************************
//******************************   Add API   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_SUBJECTS_CODE"]) {
 
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    // Define variables and set to empty values
    try {
        $title = $start_date = $end_date = $link_address = $type = $price = $ordering = $photo = $desc = $status = "";
        $tblId = test_input($_POST["obj"]);
        $adsId = test_input($_POST["ads_id"]);
        $results = "";

        if ($tblId != "") {


            $ads = $database->ads()
            ->select("*")
            ->where("id= ?", $adsId)
            ->fetch();

            $subject_site = $database->subject_sites()
            ->select("*")
            ->where("id= ?", $tblId)
            ->fetch();

            $id = $ads['id'];
            $title = $ads['title'];
            $start_date = $ads['start_date_num'];
            $end_date = $ads['end_date_num'];
            $link_address = $ads['link_address'];
            $type = $ads['type'];
            $price = $ads['price_per_day'];
            $photo = $ads['photo'];
            $desc = $ads['description'];
            $ordering = $ads['ordering'];
            $status = $ads['status'];
            $photo_address = $HOST_NAME . $photo;

            $data_to_post_ads = array("id" => $id, "title" => $title, "description" => $desc,
                "keywords" => $title, "photo_address" => $photo_address, "link_address" => $link_address,
                "start_date" => $start_date, "end_date" => $end_date, "ordering" => "1", "position" => $type, "status" => $status
            );

            $remote_url = $subject_site["recieve_link"]  . "insert/ads";
            $ch = curl_init($remote_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post_ads);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_data = curl_exec($ch);
            $results .= $return_data . ",";

            $results="done";

            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $data_to_post_ads,
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


    exit;
}


//*************************************************************************************
//******************************   Delete API   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    try {

        $tblId = test_input($_POST["obj"]);
        $adsId = test_input($_POST["ads_id"]);
        $results = "";

        if ($tblId != "") {

            $ads = $database->ads()
            ->select("*")
            ->where("id= ?", $adsId)
            ->fetch();

            $subject_site = $database->subject_sites()
            ->select("*")
            ->where("id= ?", $tblId)
            ->fetch();

            $id = $ads['id'];

            $data_to_post_ads = array("id" => "$id");


            $remote_url = $subject_site["recieve_link"] . "delete/ads";
            $ch = curl_init($remote_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post_ads);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_data = curl_exec($ch);
            $results .= $return_data . ",";


            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $data_to_post_ads,
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
    exit;
}


//*************************************************************************************
//*****************************    List Records   *****************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ){
   
       
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
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
    $count = $database->subject_sites()
        ->select(" count(id) as c")
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->subject_sites()
        ->select("*")
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

    $html = view_to_string("_ads_subjects.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

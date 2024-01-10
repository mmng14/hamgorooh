<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);

    /////////////////////
    $active_menu = "reportage";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    //--------------------------
    $reportage_id = 0;
    if (isset($url_reportage_id)) {
        $reportage_id = $url_reportage_id;
    }

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/reportage_subjects.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//******************************   Send to subjects   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_SUBJECTS_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    try {
        $title = $start_date = $end_date = $link_address = $type = $price = $ordering = $photo = $desc = $status = "";
        $tblId = test_input($_POST["obj"]);
        $results = "";

        if ($tblId != "") {

            $reportage = $database->reportage()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();

            $subject_sites = $database->subject_sites()
                ->select("*")
                ->where("status=?", 1);



            foreach ($subject_sites as $subject_site) {

                $id = $reportage['id'];
                $subj_id = $reportage['subject_id'];
                $cat_id = $reportage['category_id'];
                $sub_cat_id = $reportage['sub_category_id'];
                $post_code = $reportage['post_code'];
                $title = $reportage['title'];
                $url_name = $reportage['url_name'];
                $reportage_photo_address = $reportage['photo_address'];
                $reportage_thumb_address = $reportage['thumb_address'];
                $reportage_link = $reportage['link_address'];
                $post_date = $reportage['post_date'];
                $reg_date = $reportage['reg_date'];
                $keywords = $reportage['keywords'];



                $reportage_post = array(
                    "id" => null, "subject_id" => $subj_id, "category_id" => $cat_id,
                    "sub_category_id" => $sub_cat_id, "post_code" => $post_code, "title" => $title, "author" => "همگروه",
                    "post_type" => 2, "url_name" => $url_name, "photo_address" => $reportage_photo_address,
                    "thumb_address" => $reportage_thumb_address, "link_address" => $reportage_link,
                    "post_date" => $post_date, "reg_date" => $reg_date, "featured" => 1, "keywords" => $keywords
                );

                $remote_url = $subject_site["recieve_link"] . "insert/reportage";
                $ch = curl_init($remote_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $reportage_post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $return_data = curl_exec($ch);
                $results .= $return_data . ",";
            }
            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $reportage_post,
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
//******************************   Add API   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["INSERT_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $title = $start_date = $end_date = $link_address = $type = $price = $ordering = $photo = $desc = $status = "";
        $tblId = test_input($_POST["obj"]);
        $reportageId = test_input($_POST["reportage_id"]);
        $results = "";

        if ($tblId != "") {

            $reportage = $database->reportage()
                ->select("*")
                ->where("id=?", $reportageId)
                ->fetch();


            $subject_site = $database->subject_sites()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();



            $id = $reportage['id'];
            $subj_id = $reportage['subject_id'];
            $cat_id = $reportage['category_id'];
            $sub_cat_id = $reportage['sub_category_id'];
            $post_code = $reportage['post_code'];
            $title = $reportage['title'];
            $url_name = $reportage['url_name'];
            $reportage_photo_address = $reportage['photo_address'];
            $reportage_thumb_address = $reportage['thumb_address'];
            $reportage_link = $reportage['link_address'];
            $iframe_link = str_replace("/post/", "/iframe/", $reportage_link);
            $post_date = $reportage['post_date'];
            $reg_date = $reportage['reg_date'];
            $keywords = $reportage['keywords'];
            $status = 1;

            $reportage_post = array(
                "id" => $id, "subject_id" => $subj_id, "category_id" => $cat_id,
                "sub_category_id" => $sub_cat_id, "post_code" => $post_code, "title" => $title, "author" => "همگروه",
                "post_type" => 2, "url_name" => $url_name, "photo_address" => $reportage_photo_address,
                "thumb_address" => $reportage_thumb_address, "link_address" => $iframe_link,
                "post_date" => $post_date, "reg_date" => $reg_date, "featured" => 1, "keywords" => $keywords, "status" => $status
            );

            $remote_url = $subject_site["recieve_link"] . "insert/reportage";
            $ch = curl_init($remote_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $reportage_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_data = curl_exec($ch);
            $results .= $return_data . ",";


            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $reportage_post,
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
                "message" => $ex->getMessage(),
                "status" => "-1",
            )
        );
    }
}


//*************************************************************************************
//******************************   Delete API   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $tblId = test_input($_POST["obj"]);
        $reportageId = test_input($_POST["reportage_id"]);
        $results = "";

        if ($tblId != "") {
            $reportage = $database->reportage()
                ->select("*")
                ->where("id=?", $reportageId)
                ->fetch();


            $subject_site = $database->subject_sites()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();

            $id = $reportage['id'];

            $reportage_post = array("id" => $id);


            $remote_url = $subject_site["recieve_link"] . "delete/reportage";
            $ch = curl_init($remote_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $reportage_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $return_data = curl_exec($ch);
            $results .= $return_data . ",";


            echo json_encode(
                array(
                    "message" => $results,
                    "data" => $reportage_post,
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
//*****************************   reportage  List   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

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

    $html = view_to_string("_reportage_subjects.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

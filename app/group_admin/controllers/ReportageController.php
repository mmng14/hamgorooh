<?php
//require_once "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1, 2), $HOST_NAME);
    $active_menu = "reportage";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/reportage.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete reportage row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->reportage[$tblId];
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
//**********************************   Activate reportage row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->reportage[$tblId];
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
//**********************************  De Activate reportage row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->reportage[$tblId];
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
//*********************************  Send to Subject Site   ***************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_TO_SUBJECTS_CODE"]) {

    //Get the post
    try {

        page_access_check_ajax(array(1, 2), $HOST_NAME);
        csrf_validation_ajax($_POST["_csrf"]);

        $reportage_id = $_POST["obj"];
        $reportage = $database->reportage()
            ->select("*")
            ->where("id=?", $reportage_id)
            ->fetch();

        //-------------------------------
        if ($reportage) {
            $main_subj_id = $reportage["subject_id"];
            $main_cat_id = $reportage["category_id"];
            $main_sub_cat_id = $reportage["sub_category_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);
            $post_id_length = strlen($post_id);
            $subcategory_id_length = 0;
            $photo_address = $reportage['photo_address'];
            $thumb_address = $reportage['thumb_address'];
            $title = $reportage['title'];
            $post_name = $reportage["post_name"];
            $keywords = $reportage["keywords"];
            $reg_date = $reportage["reg_date"];
            $status = $reportage["status"];

            $post_code = "{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$post_id}";
            $item_link_address = $HOST_NAME . "iframe/{$post_code}/" . $post_name;

            $referal_photo_address = $HOST_NAME . $photo_address;
            $referal_thumb_address = $HOST_NAME . $thumb_address;


            $datatopost = array("post_code" => "$post_code", "subject_id" => "$main_subj_id", "category_id" => "$main_cat_id",
                "sub_category_id" => "$main_sub_cat_id", "title" => "$title", "url_name" => "$post_name", "keywords" => $keywords,
                "photo_address" => "$referal_photo_address", "thumb_address" => "$referal_thumb_address", "link_address" => "$item_link_address", "post_date" => "$reg_date", "reg_date" => "$reg_date", "post_type" => "1", "status" => $status);


            $return_data = "failed";
            $remote_url = "not found";


            $subject_site = $database->subject_sites()
                ->select("id,subject_id,recieve_link")
                ->where("subject_id = ?", $main_subj_id)
                ->fetch();

            if ($subject_site) {

                $remote_url = $subject_site["recieve_link"] . "insert/post";
                $ch = curl_init($remote_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $return_data = curl_exec($ch);


                echo json_encode(
                    array(
                        "status" => "1",
                        "result" => $return_data,
                        "message" => " ارسال به سایت " . $subject_site["recieve_link"],

                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "0",
                        "result" => "failed",
                        "message" => " سایت مورد نظر یافت نشد ",

                    )
                );
            }


        } else {
            echo json_encode(
                array(
                    "status" => "0",
                    "result" => "failed",
                    "message" => " پست مورد نظر یافت نشد ",

                )
            );
        }

    } catch (PDOException $ex) {
        echo json_encode(
            array(
                "status" => "0",
                "result" => $ex->getMessage(),
                "message" => "خطا در ارسال به سایت",
            )
        );
    }

}


//*************************************************************************************
//********************************   reportage  List   *************************************
//*************************************************************************************
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    //---------------------------
    $user_id = 0;
    $user_id = $_SESSION["user_id"];

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

    //-------------------------- perpage -----------------------
    if (isset($_POST['perpage'])) {
        $item_per_page = mysql_escape_mimic($_POST['perpage']);
    } else
        $item_per_page = 10;

    //-------------------------- order ---------------------------
    if (isset($_POST['order'])) {
        $orderBy = mysql_escape_mimic($_POST['order']);
        if ($orderBy == 1) $order = 'id DESC';
        else if ($orderBy == 2) $order = 'id ASC';
    } else {
        $orderBy = 2;
        $order = 'id DESC';
    }


    $user_check = "user_id = ?";
    if ($user_id == 0) {
        $user_id = 1;
        $user_check = " 1 = ?";
    }



    $count = $database->reportage()
        ->select(" count(id) as c")
        //->where($user_check, $user_id)
        ->where("title LIKE ?", "%{$search_exp}%")
        ->fetch();

    //------------
    $get_total_rows = $count["c"];
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->reportage()
        ->select("*")
        //->where($user_check, $user_id)
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
    //echo json_encode($data);

    $html = view_to_string("_reportages.php", "app/group_admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

<?php
//*************************************************************************************
//*****************************   Show contact_info page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "contact_info";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    $OP_CODE_LIST="LISTING_CODE,DELETE_CODE,EDIT_CODE,ACTIVATE_CODE,DEACTIVATE_CODE,UPDATE_CODE,INSERT_CODE";
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/contact_info.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete contact_info row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->contact_info[$tblId];
           
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
//**********************************   Activate subject row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->contact_info[$tblId];
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
//**********************************  De Activate subject row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->contact_info[$tblId];
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
//*****************************   Select contact_info row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $country = $address = $mobile = $telephones = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->contact_info()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $country = mysql_escape_mimic($result['country']);
            $address = mysql_escape_mimic($result['address']);
            $latitude = mysql_escape_mimic($result['latitude']);
            $longitude = mysql_escape_mimic($result['longitude']);
            $mobile = mysql_escape_mimic($result['mobile']);
            $telephones = mysql_escape_mimic($result['telephones']);
            $fax = mysql_escape_mimic($result['fax']);
            $email = mysql_escape_mimic($result['email']);
            $facebook = mysql_escape_mimic($result['facebook']);
            $twitter = mysql_escape_mimic($result['twitter']);
            $google_plus = mysql_escape_mimic($result['google_plus']);
            $instagram = mysql_escape_mimic($result['instagram']);
            $linkedin = mysql_escape_mimic($result['linkedin']);
            $status = mysql_escape_mimic($result['status']);
        }
        echo json_encode(
			array(
                "country" => $country, "address" => $address,"latitude" => $latitude, "longitude" => $longitude,
                "mobile" => $mobile, "telephones" => $telephones, "fax" => $fax, "email" => $email,
                "facebook" => $facebook, "twitter" => $twitter, "google_plus" => $google_plus,
                "instagram" => $instagram, "linkedin" => $linkedin,  "status" => $status
			)
		);
    }
}

//*************************************************************************************
//*****************************   add contact_info    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {
;
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $status = 0;
        $country = mysql_escape_mimic($_POST['country']);
        $address = mysql_escape_mimic($_POST['address']);
        $latitude = mysql_escape_mimic($_POST['latitude']);
        $longitude = mysql_escape_mimic($_POST['longitude']);
        $mobile = mysql_escape_mimic($_POST['mobile']);
        $telephones = mysql_escape_mimic($_POST['telephones']);
        $fax = mysql_escape_mimic($_POST['fax']);
        $email = mysql_escape_mimic($_POST['email']);
        $facebook = mysql_escape_mimic($_POST['facebook']);
        $twitter = mysql_escape_mimic($_POST['twitter']);
        $google_plus = mysql_escape_mimic($_POST['google_plus']);
        $instagram = mysql_escape_mimic($_POST['instagram']);
        $linkedin = mysql_escape_mimic($_POST['linkedin']);
        $lang = 1;
        if (isset($_POST['status']))
            $status = 1;


        $property = array(
            "id" => null, "country" => $country, "address" => $address,"latitude" => $latitude, "longitude" => $longitude,
            "mobile" => $mobile, "telephones" => $telephones, "fax" => $fax, "email" => $email,
            "facebook" => $facebook, "twitter" => $twitter, "google_plus" => $google_plus,
            "instagram" => $instagram, "linkedin" => $linkedin, "lang" => $lang, "status" => $status
        );

        $contact_info = $database->contact_info()->insert($property);
        $file_id = $contact_info['id'];

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
//*****************************   update contact_info    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

   $status = 0;
    $contact_info_id = mysql_escape_mimic($_POST['hashId']);
    $country = mysql_escape_mimic($_POST['country']);
    $address = mysql_escape_mimic($_POST['address']);
    $latitude = mysql_escape_mimic($_POST['latitude']);
    $longitude = mysql_escape_mimic($_POST['longitude']);
    $mobile = mysql_escape_mimic($_POST['mobile']);
    $telephones = mysql_escape_mimic($_POST['telephones']);
    $fax = mysql_escape_mimic($_POST['fax']);
    $email = mysql_escape_mimic($_POST['email']);
    $facebook = mysql_escape_mimic($_POST['facebook']);
    $twitter = mysql_escape_mimic($_POST['twitter']);
    $google_plus = mysql_escape_mimic($_POST['google_plus']);
    $instagram = mysql_escape_mimic($_POST['instagram']);
    $linkedin = mysql_escape_mimic($_POST['linkedin']);

    $lang = 1;
    if (isset($_POST['status']))
        $status = 1;

    $edit_row = $database->contact_info[$contact_info_id];

    $property = array(
        "country" => $country, "address" => $address,"latitude" => $latitude, "longitude" => $longitude,
        "mobile" => $mobile, "telephones" => $telephones, "fax" => $fax, "email" => $email,
        "facebook" => $facebook, "twitter" => $twitter, "google_plus" => $google_plus,
        "instagram" => $instagram, "linkedin" => $linkedin, "lang" => $lang, "status" => $status
    );

        $affected = $edit_row->update($property);

        if ($affected == null) {
            //$msg = "<div class='alert alert-danger'>خطا در بروز رسانی داده ها  </div>";
            $msg = "خطا در بروز رسانی داده ها";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,

                )
            );
            exit;
        } else {

            //$msg = "<div class='alert alert-success'>داده ها با موفقیت بروز رسانی شد</div>";
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
//*****************************   contact_info  List   *****************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {


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
    $count = $database->contact_info()
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


    $rows = $database->contact_info()
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

    $html = view_to_string("_contact_info.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

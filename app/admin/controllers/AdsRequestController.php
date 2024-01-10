<?php
//require_once "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show ads page   ************************
//*************************************************************************************
//[GET]
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1), $HOST_NAME);
    /////////////////////
    $active_menu = "ads_request";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    //--------------------------
    $subject_sites = $database->subject_sites()
        ->select("*")
        ->where("status=?", 1);

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/ads_request.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete  row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->ads_request[$tblId];

            if ($delete_row) {
                $photo = $delete_row['photo'];

                $path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                if (is_file($path)) {
                    unlink($path);
                }

                $affected = $delete_row->delete();
                echo json_encode(
                    array(

                        "result" => "1",
                        "redirect" => "",
                        "message" => "رکورد با موفقیت حذف شد",
                        "status" => "1",
                    )
                );
            } else {
                echo json_encode(
                    array(

                        "result" => "0",
                        "redirect" => "",
                        "message" => "خطایی رخ داده است",
                        "status" => "0",
                    )
                );
            }
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
//**********************************   Activate  row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->ads_request[$tblId];

        if ($update_row["user_id"]) {
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
}

//*************************************************************************************
//**********************************  DeActivate  row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->ads_request[$tblId];

        if ($update_row) {
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
}

//*************************************************************************************
//**********************************   Activate  Payment row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_PAYMENT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {

        $update_row = $database->ads_request[$tblId];

        //region update start_date end_date and price_per_date and total_price

        $start_date =test_input($update_row["start_date"]);
        $end_date =  test_input($update_row["end_date"]);
        $price = test_input($update_row["price_per_day"]);

        $subjectId = test_input($update_row["subject_id"]);
        $adsTypeId = test_input($update_row["type"]);
        $active_days = test_input($update_row["active_days"]);
        $total_price = test_input($update_row["total_price"]);
    
        if ($adsTypeId != null) {
            $result = $database->ads_type()
                ->select("*")
                ->where("id=?", $adsTypeId)
                ->fetch();

            if ($result) {

                $price =  $result["price_per_day"];

                $last_ads = $database->ads()
                    ->select("*")
                    ->where("type=?", $adsTypeId)
                    ->where("subject_id=?", $subjectId)
                    ->order("end_date_num DESC")
                    ->fetch();


                $last_ads_end_date =convertPersianToEng(jdate('Y/m/d'));

                if ($last_ads) {
                    $data_last_ads_end_date = $last_ads["end_date"];
                    if ($data_last_ads_end_date > $data_last_ads_end_date) {

                        $last_ads_end_date = $data_last_ads_end_date;
                    }
                }

                $start_date = $last_ads_end_date;
                //Convert to gregorian
                $arrayJalaliToGregorian = explode('/', $last_ads_end_date);
                $year = $arrayJalaliToGregorian[0];
                $month = $arrayJalaliToGregorian[1];
                $day = $arrayJalaliToGregorian[2];
                $last_ads_end_date_gregorian = jalali_to_gregorian($year, $month, $day, "-");
                $date = new DateTime($last_ads_end_date_gregorian);
                $date->add(new DateInterval('P' . $active_days . 'D'));
                $last_ads_end_date_gregorian = date_format($date, 'Y-m-d');

                $arrayGregorianToJalali = explode('-', $last_ads_end_date_gregorian);
                $g_y = $arrayGregorianToJalali[0];
                $g_m = $arrayGregorianToJalali[1];
                $g_d = $arrayGregorianToJalali[2];

                $end_date = gregorian_to_jalali($g_y, $g_m, $g_d, "/");
                $end_date = formatDateByZero($end_date);
                $total_price = $price * $active_days;


            }
        }
        
        //endregion update start_date end_date and price_per_date and total_price


        if ($update_row["user_id"]) {
            $payment_status = 1;

            $property = array("id" => $tblId,"start_date" => $start_date,"end_date" => $end_date,"price_per_day" => $price,"total_price" => $total_price, "payment_status" => $payment_status);
            $affected = $update_row->update($property);

           $newAdsId =  moveToAdsTable($database,$tblId);

            echo json_encode(
                array(
                    "payment_state" => '1',
                )
            );
        }
    }
}

//*************************************************************************************
//**********************************  DeActivate Payment  row   ***********************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_PAYMENT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->ads_request[$tblId];

        if ($update_row) {
            $payment_status = 0;
            $property = array("id" => $tblId, "payment_status" => $payment_status);
            $affected = $update_row->update($property);

            $deletedAdsId =  removeFromAdsTable($database,$tblId);

            echo json_encode(
                array(
                    "payment_state" => '1',
                )
            );
        }
    }
}

//*******************************************************************************
//*****************************   Select  row   ************************
//*******************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    // Define variables and set to empty values
    $title = $start_date = $end_date = $link_address = $type = $price = $ordering = $photo = $desc = $status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->ads_request()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {


            $subject_id = $result['subject_id'];
            $title = $result['title'];
            $start_date = $result['start_date'];
            $end_date = $result['end_date'];
            $link_address = $result['link_address'];
            $type = $result['type'];
            $price = $result['price_per_day'];
            $photo = $result['photo'];
            $desc = $result['description'];
            $active_days = $result['active_days'];
            $status = $result['status'];

            echo json_encode(
                array(
                    "subject_id" => $subject_id,
                    "title" => $title,
                    "start" => $start_date,
                    "end" => $end_date,
                    "linkname" => $link_address,
                    "type" => $type,
                    "price" => $price,
                    "photo" => $photo,
                    "desc" => $desc,
                    "active_days" => $active_days,
                    "status" => $status,
                )
            );
        }
    }
}


//*****************************************************************************
//*****************************   Get Date And Price   ************************
//*****************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_DATE_AND_PRICE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    // Define variables and set to empty values
    $start_date = $end_date =  $price =  "";

    $subjectId = test_input($_POST["subjectId"]);
    $adsTypeId = test_input($_POST["adsType"]);
    $active_days = test_input($_POST["active_days"]);

    if ($adsTypeId != "") {
        $result = $database->ads_type()
            ->select("*")
            ->where("id=?", $adsTypeId)
            ->fetch();

        if ($result) {

            $price =  $result["price_per_day"];

            $last_ads = $database->ads()
                ->select("*")
                ->where("type=?", $adsTypeId)
                ->where("subject_id=?", $subjectId)
                ->order("end_date_num DESC")
                ->fetch();


            $last_ads_end_date =convertPersianToEng( jdate('Y/m/d'));

            if ($last_ads) {
                $data_last_ads_end_date = $last_ads["end_date"];
                if ($data_last_ads_end_date > $data_last_ads_end_date) {

                    $last_ads_end_date = $data_last_ads_end_date;
                }
            }

            $start_date = $last_ads_end_date;
            //Convert to gregorian
            $arrayJalaliToGregorian = explode('/', $last_ads_end_date);
            $year = $arrayJalaliToGregorian[0];
            $month = $arrayJalaliToGregorian[1];
            $day = $arrayJalaliToGregorian[2];
            $last_ads_end_date_gregorian = jalali_to_gregorian($year, $month, $day, "-");
            $date = new DateTime($last_ads_end_date_gregorian);
            $date->add(new DateInterval('P' . $active_days . 'D'));
            $last_ads_end_date_gregorian = date_format($date, 'Y-m-d');

            $arrayGregorianToJalali = explode('-', $last_ads_end_date_gregorian);
            $g_y = $arrayGregorianToJalali[0];
            $g_m = $arrayGregorianToJalali[1];
            $g_d = $arrayGregorianToJalali[2];

            $end_date = gregorian_to_jalali($g_y, $g_m, $g_d, "/");
            $end_date = formatDateByZero($end_date);


            $status = "1";
            $message = "";
            echo json_encode(
                array(

                    "start" => $start_date,
                    "end" => $end_date,
                    "price" => $price,
                    "status" => $status,
                    "message" => $message,
                )
            );
        }
    }
}



//*************************************************************************************
//*****************************   Add Record    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $user_id = 0;

    try {
        $subject_id = mysql_escape_mimic($_POST['subjectId']);
        $title = mysql_escape_mimic($_POST['title']);
        $type = mysql_escape_mimic($_POST['adsType']);
        $start_date = mysql_escape_mimic($_POST["startDate"]);
        $end_date = mysql_escape_mimic($_POST['endDate']);
        $link_address = mysql_escape_mimic($_POST['link']);
        $price = mysql_escape_mimic($_POST['price']);
        $desc = mysql_escape_mimic($_POST['description']);

        $user_id = $_SESSION["user_id"];
        $customer_name = $_SESSION['full_name'];
        $customer_email = $_SESSION['user_email'];


        $active_days = mysql_escape_mimic($_POST['active_days']);
        $status =  mysql_escape_mimic($_POST['status']);

        $total_price = $price * $active_days;

        $register_date = date('Y/m/d H:i:s');

        $photo = '';
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo = "uploads/admin/ads/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $property = array(
            "id" => null, "subject_id" => $subject_id, "title" => $title, "start_date" => $start_date, "end_date" => $end_date,  "link_address" => $link_address,
            "type" => $type, "price_per_day" => $price, 'total_price' => $total_price, "photo" => $photo, "description" => $desc, "user_id" => $user_id, "customer_name" => $customer_name,
            "customer_email" => $customer_email, "active_days" => $active_days, "register_date" => $register_date, "status" => $status
        );

        $ad = $database->ads_request()->insert($property);
        $file_id = $ad['id'];
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
//*****************************   Update Record    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        $ads_id = mysql_escape_mimic($_POST['hashId']);
        $subject_id = mysql_escape_mimic($_POST['subjectId']);
        $title = mysql_escape_mimic($_POST['title']);
        $type = mysql_escape_mimic($_POST['adsType']);
        $start_date = mysql_escape_mimic($_POST["startDate"]);
        $end_date = mysql_escape_mimic($_POST['endDate']);
        $link_address = mysql_escape_mimic($_POST['link']);
        $price = mysql_escape_mimic($_POST['price']);
        $desc = mysql_escape_mimic($_POST['description']);
        $user_id = $_SESSION["user_id"];
        $customer_name = $_SESSION['full_name'];
        $customer_email = $_SESSION['user_email'];
        $active_days = mysql_escape_mimic($_POST['active_days']);
        $status = 0;
        $status =  mysql_escape_mimic($_POST['status']);

        $total_price = $price * $active_days;


        $photo = '';
        if (isset($_POST['photo'])) {
            $photo = mysql_escape_mimic($_POST['photo']);
        }

        $edit_row = $database->ads_request[$ads_id];

        $old_photo = "";
        //get old photo address
        if ($edit_row) {
            $old_photo = $edit_row["photo"];
            $photo = $old_photo;
        }
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();

                $photo = "uploads/admin/ads/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
                //delete old photo if exists
                $old_photo_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $old_photo;
                if (is_file($old_photo_path)) {
                    unlink($old_photo_path);
                }

                //---------------------
            }
        }


        $property = array(
            "id" => $ads_id, "subject_id" => $subject_id, "title" => $title, "start_date" => $start_date, "end_date" => $end_date,  "link_address" => $link_address,
            "type" => $type, "price_per_day" => $price, 'total_price' => $total_price, "photo" => $photo, "description" => $desc, "user_id" => $user_id, "customer_name" => $customer_name,
            "customer_email" => $customer_email, "active_days" => $active_days, "status" => $status
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
//*****************************    List Records   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
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
    $count = $database->ads_request()
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


    $rows = $database->ads_request()
        ->select("*")
        ->order($order)
        ->limit($item_per_page, $page_position);

        $subject_sites_rows = $database->subject_sites()
        ->select("id,subject_id,site_name,site_link")
        ->where("status=?", 1);
   
     $viewModel=null;

      if (isset($rows)){
   
               foreach ($rows as $row){
   
                   $subject_site_name = "سایت اصلی همگروه";
                   $subject_site_link="https://www.hamgorooh.com/";

                   foreach ($subject_sites_rows as $subject_sites_row){
                       if($row["subject_id"] == 0){
                        $subject_site_name = "سایت اصلی همگروه";
                        $subject_site_link="https://www.hamgorooh.com/";
                       }
                       else if($row["subject_id"] == $subject_sites_row["subject_id"]){
                           $subject_site_name = $subject_sites_row["site_name"];
                           $subject_site_link = $subject_sites_row["site_link"];
                       }
                    }
   
             
   
                   $viewModel[] = [
                   "id" =>  $row['id'],
                   "subject_id" =>  $row['subject_id'],
                   "subject_name" =>  $subject_site_name,
                   "subject_link" =>  $subject_site_link,
                   "type" =>  $row['type'],
                   "photo" =>  $row['photo'],
                   "title" =>  $row['title'],
                   "description" =>  $row['description'],
                   "link_address" =>  $row['link_address'],
                   "start_date" =>  $row['start_date'],
                   "end_date" =>  $row['end_date'],
                   "active_days" =>  $row['active_days'],
                   "price_per_day" =>  $row['price_per_day'],
                   "total_price" =>  $row['total_price'],
                   "payment_status" =>  $row['payment_status'],
                   "user_id" =>  $row['user_id'],
                   "customer_name" =>  $row['customer_name'],
                   "customer_email" =>  $row['customer_email'],
                   "customer_phone" =>  $row['customer_phone'],
                   "customer_address" =>  $row['customer_address'],
                   "follow_code" =>  $row['follow_code'],
                   "status_desc" =>  $row['status_desc'],

                   "register_date" =>  $row['register_date'],
                   "status" =>  $row['status']
                ];
               }
           }


    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );

    //for datatable in the future
    // $data = array();
    // $data['list'] = $viewModel;
    // $data['pagination'] = $pagination;
    //echo json_encode($data);

    $html = view_to_string("_ads_request.php", "app/admin/views/partial/", $viewModel, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

function moveToAdsTable($database,$request_id){

        // Define variables and set to empty values
        $tblId = test_input($request_id);
    
        if ($tblId != "") {
            $result = $database->ads_request()
                ->select("*")
                ->where("id=?", $tblId)
                ->fetch();
    
            if ($result) {
    
                $subject_id = $result['subject_id'];
                $title = $result['title'];
                $start_date =str_replace("-", "/", $result['start_date']); 
                $end_date = str_replace("-", "/", $result['end_date']);
                $start_date_num = (int) str_replace("/", "", $start_date);
                $end_date_num = (int) str_replace("/", "", $end_date);
                $link_address = $result['link_address'];
                $type = $result['type'];
                $price = $result['price_per_day'];
                $total_price= $result['total_price'];
                $photo = $result['photo'];
                $desc = $result['description'];
                $active_days = $result['active_days'];
                $payment_status = $result['payment_status'];
                $status = $result['status'];
                $ordering = 1;
                $register_date = date('Y/m/d H:i:s');

                $desc = $result['customer_name'];

                $property = array(
                    "id" => null,"request_id"=>$request_id,"subject_id"=>$subject_id ,"title" => $title, "start_date" => $start_date, "end_date" => $end_date, "start_date_num" => $start_date_num, "end_date_num" => $end_date_num, "link_address" => $link_address,
                    "type" => $type,"active_days"=>$active_days ,"price_per_day" => $price,"total_price"=>$total_price ,"photo" => $photo, "description" => $desc,"register_date"=>$register_date,
                    "ordering" => $ordering,"payment_status"=>$payment_status, "status" => $status
                );
        
                $ad = $database->ads()->insert($property);
                $file_id = $ad['id'];

                return $file_id;  
            }
        }
        return 0;  
}

function removeFromAdsTable($database,$request_id){

    // Define variables and set to empty values
    $tblId = test_input($request_id);

    if ($tblId != "") {
        $result = $database->ads()
            ->select("*")
            ->where("request_id=?", $tblId)
            ->fetch();



        if ($result) {

            $ads_id = $result['id'];


            $delete_row = $database->ads[$ads_id];

            $affected = $delete_row->delete();

            return $ads_id;  
        }
    }
    return 0;  
}
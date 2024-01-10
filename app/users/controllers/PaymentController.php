<?php
//require_once "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show ads page   ************************
//*************************************************************************************
//[GET]
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    /////////////////////
    $active_menu = "payment";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';
    //--------------------------
    if (isset($url_payment_type) && isset($url_request_id)) {

        if ($url_payment_type == 'ads') {

            $invoice_type="ads";

            $result = $database->ads_request()
                ->select("*")
                ->where("id=?", $url_request_id)
                ->fetch();


            if ($result) {

                $invoice_number = "A00" . $result['id'];
                $title = $result['title'];
                // $start_date = $result['start_date'];
                // $end_date = $result['end_date'];
                // $link_address = $result['link_address'];
                // $type = $result['type'];
                $price = $result['price_per_day'];
                // $photo = $result['photo'];
                $desc = $result['description'];
                // $active_days = $result['active_days'];

                $product_name = "تبلیغات";
                $customer_name = $result['customer_name'];
                $customer_email = $result['customer_email'];
                $customer_phone = $result['customer_phone'];
                $customer_address = $result['customer_address'];
                $status = $result['status'];

                //-----------------
                $payment_date  =  jdate('Y/m/d');
                $tax = $price * 0.93;
                $total_price =  $price + $tax;
            }
        }

        if ($url_payment_type == 'reportage') {

            $invoice_type="reportage";

            $result = $database->reportage_request()
            ->select("*")
            ->where("id=?", $url_request_id)
            ->fetch();


        if ($result) {

            $invoice_number = "R00" . $result['id'];
             $title = $result['description'];
            // $start_date = "";
            // $end_date = "";
            // $link_address = "";

            // $back_link_address = $result["back_link_address"];
            // $back_link_name = $result["back_link_name"];

            $price = $result['price'];
            // $photo = $result['file_address'];
            $desc = $result['description'];
            // $active_days = "";

            $product_name = "رپرتاژ";
            $customer_name = $result['customer_name'];
            $customer_email = $result['customer_email'];
            $customer_phone = $result['customer_phone'];
            $customer_address = $result['customer_address'];
            $status = $result['status'];

            //-----------------
            $payment_date  =  jdate('Y/m/d');
            $tax = $price * 0.93;
            $total_price =  $price + $tax;
        }
        }
    }

    //--------------------------
    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/payment.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


//*******************************************************************************
//*****************************   Select  row   ************************
//*******************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
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
            $user_id = 0;
            $user_id = $_SESSION["user_id"];
            if ($result["user_id"] == $user_id) {

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
}


//*****************************************************************************
//*****************************   Get Date And Price   ************************
//*****************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_DATE_AND_PRICE_CODE"]) {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    // Define variables and set to empty values
    $start_date = $end_date =  $price =  "";

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
                ->order("end_date_num DESC")
                ->fetch();

            if ($last_ads) {


                $last_ads_end_date = $last_ads["end_date"];
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
            } else {

                $start_date = "1398/11/22";
                $end_date =  "1398/12/29";
            }



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
//*****************************   Update Record    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        $ads_id = mysql_escape_mimic($_POST['hashId']);
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
            "id" => $ads_id, "title" => $title, "start_date" => $start_date, "end_date" => $end_date,  "link_address" => $link_address,
            "type" => $type, "price_per_day" => $price, 'total_price' => $total_price, "photo" => $photo, "description" => $desc, "user_id" => $user_id, "customer_name" => $customer_name,
            "customer_email" => $customer_email, "active_days" => $active_days
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

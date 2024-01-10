<?php
//require_once "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show reportage request page   ************************
//*************************************************************************************
//[GET]
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    /////////////////////
    $active_menu = "reportage_request";
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
    $page_content = $ROOT_DIR . "app/users/views/reportage_request.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete  row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $file = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->reportage_request[$tblId];
            $user_id = 0;
            $user_id = $_SESSION["user_id"];
            if ($delete_row["user_id"] == $user_id) {
                $file = $delete_row['file_address'];

                $path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $file;
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
                        "message" => "عدم دسترسی",
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


//*******************************************************************************
//*****************************   Select  row   ************************
//*******************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    // Define variables and set to empty values
    $title = $price = $ordering = $photo = $desc = $status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->reportage_request()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $user_id = 0;
            $user_id = $_SESSION["user_id"];
            if ($result["user_id"] == $user_id) {
                $subject_id = $result['subject_id'];
                $description = $result['description'];
                $price = $result['price'];
                $file_address = $result['file_address'];
                $back_link_address = $result['back_link_address'];
                $back_link_name = $result['back_link_name'];
                $status = $result['status'];

                echo json_encode(
                    array(
                        "subject_id" => $subject_id,
                        "description" => $description,
                        "back_link_address" => $back_link_address,
                        "back_link_name" => $back_link_name,
                        "file_address" => $file_address,
                        "price" => $price,            
                        "status" => $status,
                    )
                );
            }
        }
    }
}


//*****************************************************************************
//*****************************   Get  Reportage Site Price   ************************
//*****************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_PRICE_CODE"]) {

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    // Define variables and set to empty values
    $price =  "";

    $subjectId = test_input($_POST["subjectId"]);
   

    if ($subjectId != "") {
        $result = $database->reportage_site_prices()
            ->select("*")
            ->where("reportage_site_id=?", $subjectId)
            ->fetch();
        if($result){
            $status = "1";
            $price = $result["price"]; 
            $message = "";
            echo json_encode(
                array(
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

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $user_id = 0;

    try {

        $subject_id = mysql_escape_mimic($_POST['subjectId']);
        $desc = mysql_escape_mimic($_POST['description']);
        $back_link_address = mysql_escape_mimic($_POST['back_link_address']);
        $back_link_name = mysql_escape_mimic($_POST['back_link_name']);
        $reportage_link = "";
        
        $price = mysql_escape_mimic($_POST['price']);
        $user_id = $_SESSION["user_id"];
        $customer_name = $_SESSION['full_name'];
        $customer_email = $_SESSION['user_email'];
        $status = 0;

        //$total_price = $price;

        $register_date = date('Y/m/d H:i:s');

        $file_address = '';
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidCompressedFileExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $file_address = "uploads/admin/reportages/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $file_address;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $property = array(
            "id" => null, "subject_id" => $subject_id, "description" => $desc, "back_link_address" => $back_link_address, "back_link_name" => $back_link_name, 
            "price" => $price,  "file_address" => $file_address, "user_id" => $user_id, "customer_name" => $customer_name,
            "customer_email" => $customer_email, "register_date" => $register_date, "status" => $status
        );

        $ad = $database->reportage_request()->insert($property);
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

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    try {

        $request_id = mysql_escape_mimic($_POST['hashId']);
        $subject_id = mysql_escape_mimic($_POST['subjectId']);
        $desc = mysql_escape_mimic($_POST['description']);
        $back_link_address = mysql_escape_mimic($_POST['back_link_address']);
        $back_link_name = mysql_escape_mimic($_POST['back_link_name']);
        $reportage_link = "";
        
        $price = mysql_escape_mimic($_POST['price']);
        $user_id = $_SESSION["user_id"];
        $customer_name = $_SESSION['full_name'];
        $customer_email = $_SESSION['user_email'];


        //$total_price = $price ;


        $file_address = '';
        if (isset($_POST['file_address'])) {
            $file_address = mysql_escape_mimic($_POST['file_address']);
        }

        $edit_row = $database->reportage_request[$request_id];

        $old_file = "";
        //get old photo address
        if ($edit_row) {
            $old_file = $edit_row["file_address"];
            $fifile_addressle = $old_file;
        }
        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidCompressedFileExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();

                $file_address = "uploads/admin/reportages/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $file_address;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
                //delete old file if exists
                $old_file_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $old_file;
                if (is_file($old_file_path)) {
                    unlink($old_file_path);
                }

                //---------------------
            }
        }


        $property = array(
            "id" => $request_id, "subject_id" => $subject_id, "description" => $desc, "back_link_address" => $back_link_address, "back_link_name" => $back_link_name, 
            "price" => $price,  "file_address" => $file_address, "user_id" => $user_id, "customer_name" => $customer_name,
            "customer_email" => $customer_email
       
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
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {
    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

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
    $count = $database->reportage_request()
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



    $rows = $database->reportage_request()
        ->select("*")
        ->where("user_id=?", $user_id)
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
                   "file_address" =>  $row['file_address'],
                   "description" =>  $row['description'],
                   "back_link_address" =>  $row['back_link_address'],
                   "back_link_name" =>  $row['back_link_name'],
                   "reportage_link" =>  $row['reportage_link'],
                   "price" =>  $row['price'],
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

    // $data = array();
    // $data['list'] = $viewModel;
    // $data['pagination'] = $pagination;
    //echo json_encode($data);

    $html = view_to_string("_reportage_request.php", "app/users/views/partial/", $viewModel, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}



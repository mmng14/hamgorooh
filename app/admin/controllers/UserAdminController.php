<?php
//require_once $HOST_NAME . "includes/utility_controller.php";
//*************************************************************************************
//*****************************   Show subject page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "users";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/user_admin.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete user row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $photo = "";
    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $delete_row = $database->users[$tblId];
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
//**********************************   Activate user row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->users[$tblId];
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
//**********************************  De Activate user row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $update_row = $database->users[$tblId];
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
//*****************************   Select user row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject_title = $subject_brief_desc = $subject_photo = $subject_desc = $subject_ordering = $subject_status = "";
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $result = $database->users()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        if ($result) {
            $fname=$result['name'];
			$lname=$result['family'];
			$email=$result['email'];
			$user_name=$result['username'];
			$user_pass=$result['password'];
			$phone=$result['phone'];
			$mobile=$result['mobile'];
			$address=$result['address'];
			$photo=$result['photo'];
            $gender=$result['gender'];
			$type=$result['type'];
			$status=$result['status'];
        }
        echo json_encode(
            array(
				"fname" => $fname,
				"lname" => $lname,
				"email" => $email,
				"user_name" => $user_name,
				"user_pass" => $user_pass,
				"phone" => $phone,
				"mobile" => $mobile,
				"address" => $address,
				"photo" => $photo,
                "gender" => $gender,
				"type" => $type,
				"status" => $status,
            )
        );
    }
}

//*************************************************************************************
//*****************************   add user    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {;
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {
        $status = 0;
        $type = 2;
        $fname  = mysql_escape_mimic($_POST['fname']);
        $lname  = mysql_escape_mimic($_POST['lname']);
        $email  = mysql_escape_mimic($_POST['email']);
        $user  = mysql_escape_mimic($_POST['user']);
        $tell  = mysql_escape_mimic($_POST['tell']);
        $gender  = mysql_escape_mimic($_POST['gender']);
        $mobile  = mysql_escape_mimic($_POST['mobile']);
        $address  = mysql_escape_mimic($_POST['address']);
        if (isset($_POST['status']))
            $status = 1;
        if (isset($_POST['poweruser']))
            $type = 3;
        $register_date = jdate('Y/m/d');
        $photo = "";

        //if there is a picture
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
            $uploadfile = $_FILES['upload']['tmp_name'];
            $uploadname = $_FILES['upload']['name'];
            $uploadtype = $_FILES['upload']['type'];
            $extension = getExtension($uploadname);

            if (isValidImageExtension($extension)) {

                $extension = '.' . $extension;

                $newGUID = GUIDv4();
                $photo = "uploads/admin/subject/" . $newGUID . $extension;
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . $photo;
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            }
        }

        $current_time = date("Y-m-d H:i:s");


        $property = array(
            "id" => null, "name" => $fname, "family" => $lname, "email" => $email, "username" => $user,
            "password" => "", "phone" => $tell, "gender" => $gender, "mobile" => $mobile, "address" => $address, "photo" => $photo,
            "reg_date" => $reg_date, "type" => $type, "status" => $status
        );

        $users = $database->users()->insert($property);
        $file_id = $users['id'];

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
//*****************************   update user    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $user_id = mysql_escape_mimic($_POST['hashId']);

        $status = 0;
        $type = 2;
        $fname  = mysql_escape_mimic($_POST['fname']);
        $lname  = mysql_escape_mimic($_POST['lname']);
        $email  = mysql_escape_mimic($_POST['email']);
        $user  = mysql_escape_mimic($_POST['user']);
        $tell  = mysql_escape_mimic($_POST['tell']);
        $gender  = mysql_escape_mimic($_POST['gender']);
        $mobile  = mysql_escape_mimic($_POST['mobile']);
        $address  = mysql_escape_mimic($_POST['address']);

        $photo = '';
        if (isset($_POST['photo'])) {
            $photo = mysql_escape_mimic($_POST['photo']);
        }

        $edit_row = $database->users[$user_id];

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

                $photo = "uploads/admin/subject/" . $newGUID . $extension;
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
            "name" => $fname, "family" => $lname, "email" => $email, "username" => $user,
            "phone" => $tell, "mobile" => $mobile, "gender" => $gender, "address" => $address, "photo" => $photo,
            "type" => $type, "status" => $status
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
//*****************************   change pass    ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["PASSWORD_CHANGE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $status = 0;
        $user_id  = mysql_escape_mimic($_POST['userId']);
        $pass  = mysql_escape_mimic($_POST['pass']);
        $re_pass  = mysql_escape_mimic($_POST['rePass']);

        if ($pass == $re_pass) {
            $edit_row = $database->users[$user_id];
            $property = array("password" => $pass);
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
        } else {
            $msg = "کلمه عبور با تکرار آن برابر نمی باشد  ";
            echo json_encode(
                array(
                    "status" => '0',
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
//*****************************   User  List   *****************************
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
    $count = $database->users()
        ->select(" count(id) as c")
        ->where("type", array("2", "3","4"))
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database->users()
        ->select("*")
        ->where("type", array("2", "3","4"))
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

    $html = view_to_string("_user_admin.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

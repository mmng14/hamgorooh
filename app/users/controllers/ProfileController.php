<?php
// require_once "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (!isset($_SESSION["user_name"])) {
        redirect_to($HOST_NAME);
    }

    page_access_check(array(1, 2, 3, 4, 5), $HOST_NAME);

    include 'libraries/csrf_validation.php';



    $current_user_id = $_SESSION["user_id"];

    $user_info = $database->users()
        ->select("*")
        ->where("status = ?", 1)
        ->where("id = ?", $current_user_id)
        ->fetch();

    $gender = "نا مشخص";
    if ($user_info['gender'] == 0) {
        $gender = "زن";
    }
    if ($user_info['gender'] == 1) {
        $gender = "مرد";
    }
    if ($user_info['gender'] == 2) {
        $gender = "سایر";
    }

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;

    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/users/views/profile.view.php";
    return   include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//Upload Photo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {
    try {
        page_access_check(array(1,2,3,4,5), $HOST_NAME );
        $photo_address = "";
        if (is_uploaded_file($_FILES['FileUpload']['tmp_name'])) {
            $uploadfile = $_FILES['FileUpload']['tmp_name'];
            $uploadname = $_FILES['FileUpload']['name'];
            $uploadtype = $_FILES['FileUpload']['type'];
            $extension = getExtension($uploadname);


            if (isValidPhotoExtension($extension)) {
                //upload the file in services folder
                $extension = '.' . $extension;
                $guid = GUIDv4();
                //-----Save the  file-------
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX ."uploads/admin/user/{$guid}{$extension}";
                $photo_address = "uploads/admin/user/{$guid}{$extension}";
                move_uploaded_file($_FILES["FileUpload"]["tmp_name"], $save_address);

            } else {
                $msg = "<div class='error'>نوع فایل معتبر نمی باشد</div>";
            }


            //----End for Photo
        }

        $row_id = $_SESSION['user_id'];
        $edit_row = $database->users[$row_id];
        $property = array("photo" => $photo_address);
        $affected = $edit_row->update($property);
        $action = " بروز رسانی ";

        if ($affected == null || !$affected) {
            $msg = "خطا در انجام عملیات  " . $action;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
        } else {
            $msg = "  عملیات موفق " . $action;
            $_SESSION["user_photo"] = $photo_address;
            $user_photo_address = $HOST_NAME . $photo_address;

            echo json_encode(
                array(
                    "message" => $msg,
                    "html" => $HOST_NAME . $photo_address,
                    "status" => "1",
                )
            );
        }
    } catch (PDOException $ex) {

        $msg = "{$ex->getMessage()}";
        echo json_encode(
            array(
                "message" => $msg,
                "status" => "-1",
            )
        );
    }


}

//Change Password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['repeatNewPassword']) && isset($_POST['check']) && $_POST['check'] == $_SESSION["PASSWORD_CHANGE_CODE"]) {
    try {

        page_access_check(array(1,2,3,4,5), $HOST_NAME );
        $valid_data =  true;
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $repeatNewPassword = $_POST['repeatNewPassword'];

        $current_user_id = $_SESSION["user_id"];

        $user_info = $database->users()
            ->select("*")
            ->where("status = ?", 1)
            ->where("id = ?", $current_user_id)
            ->fetch();


        //region Server_Validation
        if($currentPassword != $user_info["password"] )
        {
            $msg = "کلمه عبور فعلی معتبر نیست  "  ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
            $valid_data =false;
            exit;
        }
        if( strlen($newPassword) < 6  )
        {
            $msg = "کلمه عبور نباید کمتر از 6 حرف باشد " ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
            $valid_data =false;
            exit;
        }
        if( $newPassword != $repeatNewPassword  )
        {
            $msg = "کلمه عبور با تکرار آن برابر نیست " ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
            $valid_data =false;
            exit;
        }
        //endregion Server_Validation

        if( $valid_data) {


            $edit_row = $database->users[$current_user_id];
            $property = array("password" => $newPassword);
            $affected = $edit_row->update($property);
            $action = " بروز رسانی ";

            if ($affected == null || !$affected) {
                $msg = "خطا در انجام عملیات  " . $action;
                echo json_encode(
                    array(
                        "message" => $msg,
                        "status" => "0",
                    )
                );
            } else {
                $msg = "  عملیات موفق " . $action;


                echo json_encode(
                    array(
                        "message" => $msg,
                        "html" => "",
                        "status" => "1",
                    )
                );
            }
        }
        else
        {
            $msg = "داده ها معتبر نمی باشد " ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
        }

    } catch (PDOException $ex) {

        $msg = "{$ex->getMessage()}";
        echo json_encode(
            array(
                "message" => $msg,
                "status" => "-1",
            )
        );
    }


}

//Change User Info
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {
    try {

        page_access_check(array(1,2,3,4,5), $HOST_NAME );
        $valid_data =  true;

        $firstName = $_POST['firstName'];
        $lastName =$_POST['lastName'];
        $phoneNumber =$_POST['phoneNumber'];
        $birthDate = $_POST['birthDate'];
        $gender =$_POST['gender'];
        $address =$_POST['address'];
        $notes =$_POST['notes'];


        $current_user_id = $_SESSION["user_id"];

        $user_info = $database->users()
            ->select("*")
            ->where("status = ?", 1)
            ->where("id = ?", $current_user_id)
            ->fetch();


        //region Server_Validation

        if( strlen($firstName) < 3  )
        {
            $msg = "نام نباید کمتر از 3 حرف باشد " ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
            $valid_data =false;
            exit;
        }
        if( strlen($lastName) < 3  )
        {
            $msg = "نام خانوادگی نباید کمتر از 3 حرف باشد " ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
            $valid_data =false;
            exit;
        }
        //endregion Server_Validation

        if( $valid_data) {


            $edit_row = $database->users[$current_user_id];
            $property = array("name" => $firstName,"	family" => $lastName,"phone" => $phoneNumber,"birth_date" => $birthDate,"gender" => $gender,"address" => $address,"notes" => $notes);
            $affected = $edit_row->update($property);


            if ($affected == null || !$affected) {
                $msg = "خطا در انجام عملیات  " ;
                echo json_encode(
                    array(
                        "message" => $msg,
                        "status" => "0",
                    )
                );
            } else {
                $msg = "  عملیات موفق " ;
                $_SESSION['full_name'] = $firstName . " " . $lastName;

                echo json_encode(
                    array(
                        "message" => $msg,
                        "html" => "",
                        "status" => "1",
                    )
                );
            }
        }
        else
        {
            $msg = "داده ها معتبر نمی باشد " ;
            echo json_encode(
                array(
                    "message" => $msg,
                    "status" => "0",
                )
            );
        }

    } catch (PDOException $ex) {

        $msg = "{$ex->getMessage()}";
        echo json_encode(
            array(
                "message" => $msg,
                "status" => "-1",
            )
        );
    }


}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["p_id"]) && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_CITY_LIST_CODE"]) {
    
    page_access_check(array(1,2,3,4,5), $HOST_NAME );
    $_cities = "";
    $pId = test_input($_POST["p_id"]);

    if ($pId != "") {
        Connect();

        $cities = select('city', "*", "province_id='$pId'");
        if ($cities) {
            $_cities .= "<option value='0'>انتخاب شهرستان</option>";
            foreach ($cities as $city) {
                $_cities .= "<option value='{$city['id']}'>{$city['name']}</option>";
            }
        }
        echo json_encode(
            array(
                "state" => 'ok',
                "cities" => $_cities,
            )
        );
        Disconnect();
    }

}

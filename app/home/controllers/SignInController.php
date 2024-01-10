<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    // Get a key from https://www.google.com/recaptcha/admin/create
    $publickey = "6LfpYbIUAAAAAF9AGYPdkrx-ZyWqaIYj7aOCg5mK";
    $privatekey = "6LfpYbIUAAAAAIddCWyrcxbZ6hbpAOdgT2sfEEHW";

    # the response from reCAPTCHA
    $resp = null;
    # the error code from reCAPTCHA, if any
    $error = null;

    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();

    if (!isset($_SESSION['user_id'])) {
        if (isset($_POST['signin']) && isset($_POST['userpass']) && $_POST['username'] != "") {
            $user_name = mysql_escape_mimic($_POST['username']);
            $user_pass = mysql_escape_mimic($_POST['userpass']);
            $captcha = $_POST['g-recaptcha-response'];
            //        $captcha = mysql_escape_mimic($_POST['captcha_code']);

            //Check google recaptcha response
            $ip = $_SERVER['REMOTE_ADDR'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $privatekey . "&response=" . $captcha . "&remoteip=" . $ip);
            $responseKeys = json_decode($response, true);

            if (intval($responseKeys["success"]) !== 1) {
                $page_validation = false;
                $login_msg = $captcha_err = "<div class='alert alert-danger'>" . "لطفا بر روی من ربات نیستم کلیک کنید" . "</div>";
            } else {
                $user_result = $database->users()
                    ->where("username = ?", $user_name)
                    //                ->where("password = ?", $user_pass)
                    ->where("status = ?", 1)
                    ->fetch();


                if ($user_result) // if found something
                {
                    $password = $user_result["password"];
                    if (password_verify($user_pass, $password)) {
                        // If the password inputs matched the hashed password in the database

                        $_SESSION['user_id'] = $user_result['id'];
                        $_SESSION['user_name'] = $user_result['username'];
                        $_SESSION['full_name'] = $user_result['name'] . " " . $user_result['family'];
                        $_SESSION['user_email'] = $user_result['email'];
                        $_SESSION['user_photo'] = $user_result['photo'];
                        $_SESSION['reg_date'] = $user_result['reg_date'];
                        $_SESSION['user_type'] = $user_result['type']; // 1 = admin / 2 = subject admin / 3 = group admin / 4 = power user / 5 = user

                        $user_subjects = $database->user_subjects()
                            ->select("*")
                            ->where("status = ?", 1)
                            ->where("user_id = ?", $user_result['id'])
                            ->order("subject_name asc");

                        $userSubjectsViewModel = [];

                        $subject_rows = $database->subject()
                            ->select("id,name,photo")
                            ->where("status=?", 1);


                        if (isset($user_subjects)) {

                            foreach ($user_subjects as $user_subject) {

                                $subject_name = "نام موضوع";
                                foreach ($subject_rows as $subject_row) {
                                    if ($subject_row["id"] == $user_subject["subject_id"]) {
                                        $subject_name = $subject_row["name"];
                                        $subject_photo = $subject_row["photo"];
                                    }
                                }


                                $userSubjectsViewModel[] = [
                                    "id" =>  $user_subject['id'],
                                    "subject_id" =>  $user_subject['subject_id'],
                                    "subject_name" =>  $subject_name,
                                    "subject_photo" =>  $subject_photo,
                                    "user_id" =>  $user_subject['user_id'],
                                    "role" =>  $user_subject['role'],
                                    "user_rights" =>  $user_subject['user_rights'],
                                    // "register_date" =>  $user_subject['register_date'],
                                    "accept_date" =>  $user_subject['accept_date'],
                                    "status" =>  $user_subject['status']
                                ];
                            }
                        }


                        $_SESSION["user_subjects"] = $userSubjectsViewModel;




                        $user_groups = $database->user_groups()
                            ->select("*")
                            ->where("status = ?", 1)
                            ->where("user_id = ?", $user_result['id'])
                            ->order("group_id asc");

                        $user_groups_arr = iteratorToArray($user_groups);
                        $_SESSION["user_groups"] = $user_groups_arr;


                        $user_type_name = "";
                        if ($user_result['type'] == 1) {
                            $user_type_name = "مدیر سایت";
                        }
                        if ($user_result['type'] == 2) {
                            $user_type_name = "مدیر گروه اصلی";
                        }
                        if ($user_result['type'] == 3) {
                            $user_type_name = "مدیر گروه";
                        }
                        if ($user_result['type'] == 4) {
                            $user_type_name = "کابر ويژه";
                        }
                        if ($user_result['type'] == 5) {
                            $user_type_name = "کاربر سایت";
                        }
                        $_SESSION['user_type_name'] = $user_type_name;

                        /* START OP CODES */
                        $_SESSION["INSERT_CODE"] = GUIDv4();
                        $_SESSION["UPDATE_CODE"] = GUIDv4();
                        $_SESSION["DELETE_CODE"] = GUIDv4();
                        $_SESSION["MULTI_DELETE_CODE"] = GUIDv4();
                        $_SESSION["ACTIVATE_CODE"] = GUIDv4();
                        $_SESSION["DEACTIVATE_CODE"] = GUIDv4();
                        $_SESSION["ACTIVATE_TOPMENU_CODE"] = GUIDv4();
                        $_SESSION["DEACTIVATE_TOPMENU_CODE"] = GUIDv4();
                        $_SESSION["ACTIVATE_HASRESOURCE_CODE"] = GUIDv4();
                        $_SESSION["DEACTIVATE_HASRESOURCE_CODE"] = GUIDv4();
                        $_SESSION["ACTIVATE_PAYMENT_CODE"] = GUIDv4();
                        $_SESSION["DEACTIVATE_PAYMENT_CODE"] = GUIDv4();
                        $_SESSION["CUSTOMIZE_CODE"] = GUIDv4();
                        $_SESSION["UNCUSTOMIZE_CODE"] = GUIDv4();
                        $_SESSION["GET_DATE_AND_PRICE_CODE"] = GUIDv4();
                        $_SESSION["GET_PRICE_CODE"] = GUIDv4();
                        $_SESSION["SEND_TO_SUBJECTS_CODE"] = GUIDv4();
                        $_SESSION["UPDATE_TO_SUBJECTS_CODE"] = GUIDv4();
                        $_SESSION["DELETE_TO_SUBJECTS_CODE"] = GUIDv4();
                        $_SESSION["SEND_TO_ALL_SUBJECTS_CODE"] = GUIDv4();
                        $_SESSION["EDIT_CODE"] = GUIDv4();
                        $_SESSION["SET_UPLOAD_FOLDER_CODE"] = GUIDv4();
                        $_SESSION["SEND_TO_TELEGRAM_CODE"] = GUIDv4();
                        $_SESSION["SEND_TO_REPORTAGE_CODE"] = GUIDv4();
                        $_SESSION["SET_GROUP_ACCESS_CODE"] = GUIDv4();
                        $_SESSION["SET_CATEGORY_CODE"] = GUIDv4();
                        $_SESSION["SET_USER_TYPE_CODE"] = GUIDv4();
                        $_SESSION["PASSWORD_CHANGE_CODE"] = GUIDv4();
                        $_SESSION["GET_CATEGORY_LIST_CODE"] = GUIDv4();
                        $_SESSION["GET_SUBCATEGORY_LIST_CODE"] = GUIDv4();
                        $_SESSION["GET_CITY_LIST_CODE"] = GUIDv4();
                        $_SESSION["LISTING_CODE"] = GUIDv4();
                        $_SESSION["ACCEPT_REQUEST_CODE"] = GUIDv4();
                        $_SESSION["REJECT_REQUEST_CODE"] = GUIDv4();
                        $_SESSION["POST_IMAGE_UPLOAD_CODE"] = GUIDv4();
                        $_SESSION["POST_IMAGE_LIST_CODE"] = GUIDv4();
                        $_SESSION["POST_RESOURCE_LIST_CODE"] = GUIDv4();
                        $_SESSION["NOTOFICATIONS_LIST_OP_CODE"] = GUIDv4();
                        $_SESSION["NOTOFICATIONS_COUNT_OP_CODE"] = GUIDv4();

                        /* END OP CODES */

                        //Redirect To Home Page
                        #region redirect_home
                        //admin home
                        if ($_SESSION['user_type'] == "1") {
                            header("Location: {$HOST_NAME}admin/index"); /* Redirect browser */
                            exit();
                        }

                        //admin subject
                        if ($_SESSION['user_type'] == "2") {
                            header("Location: {$HOST_NAME}group_admin/index"); /* Redirect browser */
                            exit();
                        }

                        //group admin
                        if ($_SESSION['user_type'] == "3") {
                            header("Location: {$HOST_NAME}users/index"); /* Redirect browser */
                            exit();
                        }

                        //group user
                        if ($_SESSION['user_type'] == "4" || $_SESSION['user_type'] == "5") {
                            header("Location: {$HOST_NAME}users/index"); /* Redirect browser */
                            exit();
                        }
                        #endregion redirect_home
                    } else {
                        $login_msg = "<div class='alert alert-danger'>" . "نام کاربری یا کلمه عبور اشتباه است" . "</div>";
                    }
                } else {
                    $login_msg = "<div class='alert alert-danger'>" . "نام کاربری یا کلمه عبور اشتباه است" . "</div>";
                }
            }
        }
    } else {
        #region redirect_home
        //admin home
        if ($_SESSION['user_type'] == "1") {
            header("Location: {$HOST_NAME}admin/index"); /* Redirect browser */
            exit();
        }

        //admin subject
        if ($_SESSION['user_type'] == "2") {
            header("Location: {$HOST_NAME}group_admin/index"); /* Redirect browser */
            exit();
        }

        //group admin
        if ($_SESSION['user_type'] == "3") {
            header("Location: {$HOST_NAME}users/index"); /* Redirect browser */
            exit();
        }

        //group user
        if ($_SESSION['user_type'] == "4" || $_SESSION['user_type'] == "5") {
            header("Location: {$HOST_NAME}users/index"); /* Redirect browser */
            exit();
        }
        #endregion redirect_home
    }

    $show_header = false;
    $header_title = "";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/signin.view.php";
    include "app/shared/views/_layout_home.php";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["LOGIN_CODE"]) {
    $user_name = mysql_escape_mimic($_POST['username']);
    $user_pass = mysql_escape_mimic($_POST['userpass']);
    $remember = mysql_escape_mimic($_POST['remember']);

    $remember_me = false;
    if ($remember == "on") {
        $remember_me = true;
    }

    $user_result = $database->users()
        ->where("username = ?", $user_name)
        ->where("status = ?", 1)
        ->fetch();


    if ($user_result) // if found something
    {

        $password = $user_result["password"];
        if (password_verify($user_pass, $password)) {
            // If the password inputs matched the hashed password in the database

            $_SESSION['user_id'] = $user_result['id'];
            $_SESSION['user_name'] = $user_result['username'];
            $_SESSION['full_name'] = $user_result['name'] . " " . $user_result['family'];
            $_SESSION['user_email'] = $user_result['email'];
            $_SESSION['user_photo'] = $user_result['photo'];
            $_SESSION['reg_date'] = $user_result['reg_date'];
            // 1 = admin / 2 = subject admin / 3 = group admin / 4 = power user / 5 = user
            $_SESSION['user_type'] = $user_result['type'];

            $user_subjects = $database->user_subjects()
                ->select("*")
                ->where("status = ?", 1)
                ->where("user_id = ?", $user_result['id'])
                ->order("subject_name asc");


            $userSubjectsViewModel = [];

            $subject_rows = $database->subject()
                ->select("id,name,photo")
                ->where("status=?", 1);

            $counter = 0;    
            if (isset($user_subjects)) {

                foreach ($user_subjects as $user_subject) {

                    $subject_name = "نام موضوع";
                    foreach ($subject_rows as $subject_row) {
                        if ($subject_row["id"] == $user_subject["subject_id"]) {
                            $subject_name = $subject_row["name"];
                            $subject_photo = $subject_row["photo"];
                        }
                    }

                    $userSubjectsViewModel[] = [
                        "id" =>  $user_subjects['id'],
                        "subject_id" =>  $user_subject['subject_id'],
                        "subject_name" =>  $subject_name,
                        "subject_photo" =>  $subject_photo,
                        "user_id" =>  $user_subject['user_id'],
                        "role" =>  $user_subject['role'],
                        "user_rights" =>  $user_subject['user_rights'],
                        // "register_date" =>  $user_subject['register_date'],
                        "accept_date" =>  $user_subject['accept_date'],
                        "status" =>  $user_subject['status']
                    ];
                    $counter++;
                }
            }

           //var_dump($counter);
           // exit;

            $_SESSION["user_subjects"] = $userSubjectsViewModel;

            $user_groups = $database->user_groups()
                ->select("*")
                ->where("status = ?", 1)
                ->where("user_id = ?", $user_result['id'])
                ->order("group_id asc");

            $user_groups_arr = iteratorToArray($user_groups);
            $_SESSION["user_groups"] = $user_groups_arr;

            $user_type_name = "";
            if ($user_result['type'] == 1) {
                $user_type_name = "مدیر سایت";
            }
            if ($user_result['type'] == 2) {
                $user_type_name = "مدیر گروه اصلی";
            }
            if ($user_result['type'] == 3) {
                $user_type_name = "مدیر گروه";
            }
            if ($user_result['type'] == 4) {
                $user_type_name = "کابر ويژه";
            }
            if ($user_result['type'] == 5) {
                $user_type_name = "کاربر سایت";
            }
            $_SESSION['user_type_name'] = $user_type_name;


            /* START OP CODES */
            $_SESSION["INSERT_CODE"] = GUIDv4();
            $_SESSION["UPDATE_CODE"] = GUIDv4();
            $_SESSION["DELETE_CODE"] = GUIDv4();
            $_SESSION["MULTI_DELETE_CODE"] = GUIDv4();
            $_SESSION["ACTIVATE_CODE"] = GUIDv4();
            $_SESSION["DEACTIVATE_CODE"] = GUIDv4();
            $_SESSION["ACTIVATE_TOPMENU_CODE"] = GUIDv4();
            $_SESSION["DEACTIVATE_TOPMENU_CODE"] = GUIDv4();
            $_SESSION["ACTIVATE_HASRESOURCE_CODE"] = GUIDv4();
            $_SESSION["DEACTIVATE_HASRESOURCE_CODE"] = GUIDv4();
            $_SESSION["ACTIVATE_PAYMENT_CODE"] = GUIDv4();
            $_SESSION["DEACTIVATE_PAYMENT_CODE"] = GUIDv4();
            $_SESSION["CUSTOMIZE_CODE"] = GUIDv4();
            $_SESSION["UNCUSTOMIZE_CODE"] = GUIDv4();
            $_SESSION["GET_DATE_AND_PRICE_CODE"] = GUIDv4();
            $_SESSION["GET_PRICE_CODE"] = GUIDv4();
            $_SESSION["SEND_TO_SUBJECTS_CODE"] = GUIDv4();
            $_SESSION["UPDATE_TO_SUBJECTS_CODE"] = GUIDv4();
            $_SESSION["DELETE_TO_SUBJECTS_CODE"] = GUIDv4();
            $_SESSION["SEND_TO_ALL_SUBJECTS_CODE"] = GUIDv4();
            $_SESSION["EDIT_CODE"] = GUIDv4();
            $_SESSION["SET_UPLOAD_FOLDER_CODE"] = GUIDv4();
            $_SESSION["SEND_TO_TELEGRAM_CODE"] = GUIDv4();
            $_SESSION["SEND_TO_REPORTAGE_CODE"] = GUIDv4();
            $_SESSION["SET_GROUP_ACCESS_CODE"] = GUIDv4();
            $_SESSION["SET_CATEGORY_CODE"] = GUIDv4();
            $_SESSION["SET_USER_TYPE_CODE"] = GUIDv4();
            $_SESSION["PASSWORD_CHANGE_CODE"] = GUIDv4();
            $_SESSION["GET_CATEGORY_LIST_CODE"] = GUIDv4();
            $_SESSION["GET_SUBCATEGORY_LIST_CODE"] = GUIDv4();
            $_SESSION["GET_CITY_LIST_CODE"] = GUIDv4();
            $_SESSION["LISTING_CODE"] = GUIDv4();
            $_SESSION["ACCEPT_REQUEST_CODE"] = GUIDv4();
            $_SESSION["REJECT_REQUEST_CODE"] = GUIDv4();
            $_SESSION["POST_IMAGE_UPLOAD_CODE"] = GUIDv4();
            $_SESSION["POST_IMAGE_LIST_CODE"] = GUIDv4();
            $_SESSION["POST_RESOURCE_LIST_CODE"] = GUIDv4();
            $_SESSION["NOTOFICATIONS_LIST_OP_CODE"] = GUIDv4();
            $_SESSION["NOTOFICATIONS_COUNT_OP_CODE"] = GUIDv4();

            /* END OP CODES */

            //Redirect To Home Page

            $redirect = "";
            #region redirect_home
            //admin home
            if ($_SESSION['user_type'] == "1") {
                $redirect = "{$HOST_NAME}admin/index"; /* Redirect browser */
            }

            //admin subject
            if ($_SESSION['user_type'] == "2") {
                $redirect = "{$HOST_NAME}group_admin/index"; /* Redirect browser */
            }

            //group admin
            if ($_SESSION['user_type'] == "3") {
                $redirect = "{$HOST_NAME}users/index"; /* Redirect browser */
            }

            //group user
            if ($_SESSION['user_type'] == "4" || $_SESSION['user_type'] == "5") {
                $redirect =  "{$HOST_NAME}users/index"; /* Redirect browser */
            }
            $login_msg =  "عملیات با موفقیت انجام شد";

            //if remember_me is checked
            $cookie_value = "";
            if ($remember_me) {
                //save login info in cookie
                $cookie_name = "hamgorooh";
                $cookie_value =  encrypt_data($user_name);
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30)); // 86400 = 1 day
                $_COOKIE[$cookie_name] = $cookie_value;
                // setcookie($cookie_name, $cookie_value, [
                //     'expires' => time() + (86400 * 30),
                //     'path' => '/',
                //     'domain' => 'hamgorooh.com',
                //     'secure' => true,
                //     'httponly' => true,
                //     'samesite' => 'None',
                // ]);



            }

            echo json_encode(
                array(
                    "message" => $login_msg,
                    "redirect" => $redirect,
                    "status" => "1",
                    "remember" => $remember_me,
                )
            );

            #endregion redirect_home
        } else {
            $login_msg =  "نام کاربری یا کلمه عبور اشتباه است";
            echo json_encode(
                array(
                    "message" => $login_msg,
                    "redirect" => "",
                    "status" => "-1",
                    "remember" => $remember_me
                )
            );
        }
    } else {
        $login_msg =  "نام کاربری یا کلمه عبور اشتباه است";
        echo json_encode(
            array(
                "message" => $login_msg,
                "redirect" => "",
                "status" => "-1",
                "remember" => $remember_me
            )
        );
    }
    exit;
}

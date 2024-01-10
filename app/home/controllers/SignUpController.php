<?php
//require_once "core/utility_controller.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();

    $flag = false;
    $register_msg = null;


    $show_header = false;
    $header_title = "";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR ."app/home/views/signup.view.php";
    include "app/shared/views/_layout_home.php";
}

//for signup ajax call
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["REGISTER_CODE"]) {

    $page_validation = true;

    $first_name = mysql_escape_mimic($_POST['firstName']);
    $last_name = mysql_escape_mimic($_POST['lastName']);
    $email = mysql_escape_mimic($_POST['email']);
    $user_pass = mysql_escape_mimic($_POST['password']);
    $user_pass_repeat = mysql_escape_mimic($_POST['passwordRepeat']);
    $birth_date = mysql_escape_mimic($_POST['birthDate']);
    $gender = mysql_escape_mimic($_POST['gender']);



    //Check Server Side Validation
    $server_validation_errors = "";
    #region validation_check
    if (strlen($first_name) < 3) {
        $page_validation = false;
        $firstname_err = "<li>" . "نام معتبر نمی باشد" . "</li>";
        $server_validation_errors .=$firstname_err;
    }
    if (strlen($last_name) < 3) {
        $page_validation = false;
        $lastname_err = "<li>" . "نام خانوادگی معتبر نمی باشد" . "</li>";
        $server_validation_errors .=$lastname_err;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $page_validation = false;
        $email_err = "<li>" . "پست الکترونیکی معتبر نیست" . "</li>";
        $server_validation_errors .=$email_err;
    }
    if (strlen($user_pass) < 8) {
        $page_validation = false;
        $password_err = "<li>" . "کلمه عبور نباید کمتر از 8 حرف باشد" . "</li>";
        $server_validation_errors .=$password_err;
    }
    if ($user_pass != $user_pass_repeat) {
        $page_validation = false;
        $password_repeat_err = "<li>" . "کلمه عبور با تکرار آن برابر نیست" . "</li>";
        $server_validation_errors .=$password_repeat_err;
    }
    if (!isset($gender) || $gender=="") {
        $page_validation = false;
        $gender_err = "<li>" . "جنسیت انتخاب نشده است" . "</li>";
        $server_validation_errors .=$gender_err;
    }
    if (!isset($birth_date) || $birth_date=="") {
        $page_validation = false;
        $birth_date_err = "<li>" . "تاریخ تولد انتخاب نشده است" . "</li>";
        $server_validation_errors .=$birth_date_err;
    }

    if ($page_validation == true) {

        $email_user = $database->users()
            ->where("email = ?", $email)
            ->fetch();

        if ($email_user) {
            $page_validation = false;
            $email_err = "<li>" . "پست الکترونیکی قبلا استفاده شده است" . "</li>";
            $server_validation_errors .=$email_err;
        }
    }
    #endregion validation_check
    //---------------

    if ($page_validation) {
        try {
            $today = jdate('Y/m/d');
            $user_type = "5"; // Normal user
            $status = "0"; // Not activated
            $hashed_password = password_hash($user_pass, PASSWORD_DEFAULT);

            $verify_code = mt_rand(10000000,99999999);
            $last_verify_code_date = date("Y-m-d H:i:s");
            $email_verify=0;
            $phone_verify=0;
            $failed_login_try=0;

            $property = array(
                "id" => null, "name" => $first_name, "family" => $last_name, "email" => $email, "username" => $email,
                "password" => $hashed_password, "phone" => "", "gender" => $gender, "birth_date" => $birth_date, "address" => "", "photo" => "",
                "reg_date" => $today, "type" => $user_type, "verify_code"=>$verify_code,"last_verify_code_date"=>$last_verify_code_date,
                "email_verify"=>$email_verify,"phone_verify"=>$phone_verify,"failed_login_try"=>$failed_login_try,"status" => $status
            );

            $users = $database->users()->insert($property);
            $file_id = $users['id'];

            if ($file_id == null || $file_id == '') {
                $msg = "خطا در ذخیره سازی داده ها";
                echo json_encode(
                    array(
                        "message" => $msg,
                        "redirect" => "",
                        "status" => "-1",
                    )
                );
            } else {
                SendEmailToUser($email,$first_name,$last_name,$file_id,$HOST_NAME,$verify_code);
                
                $email_verify_message ="<li>". " کاربر کرامی ، ثبت نام شما انجام شد. "."</li>";
                $email_verify_message .="<li>"." برای فعال سازی اکانت خود وارد ایمیل خود شوید و بر روی لینک ارسالی کلیک نمایید."."</li>";
                $email_verify_message .="<li>"." توجه : امکان دارد ایمیل ارسال وارد قسمت اسپم  شده باشد"."</li>";

                $msg = $email_verify_message;
                echo json_encode(
                    array(
                        "message" => $msg,
                        "redirect" => "",
                        "status" => "1",
                    )
                );
            }
        } catch (PDOException $ex) {
            $msg = $ex->getMessage();
            echo json_encode(
                array(
                    "message" => $msg,
                    "redirect" => "",
                    "status" => "-1",
                )
            );
        }
    } else {
       
        echo json_encode(
            array(
                "message" => $server_validation_errors,
                "redirect" => "",
                "status" => "-1",
            )
        );
    }
}

//for normal post (not ajax call)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['captcha_code'])) {

    $page_validation = true;

    $first_name = mysql_escape_mimic($_POST['first_name']);
    $last_name = mysql_escape_mimic($_POST['last_name']);
    $email = mysql_escape_mimic($_POST['email']);
    $user_pass = mysql_escape_mimic($_POST['password']);
    $user_pass_repeat = mysql_escape_mimic($_POST['re_password']);
    $captcha = mysql_escape_mimic($_POST['captcha_code']);

    //Check Server Side Validation
    #region validation_check
    if (strlen($first_name) < 3) {
        $page_validation = false;
        $firstname_err = "<div class='alert alert-danger'>" . "نام معتبر نمی باشد" . "</div>";
    }
    if (strlen($last_name) < 3) {
        $page_validation = false;
        $lastname_err = "<div class='alert alert-danger'>" . "نام خانوادگی معتبر نمی باشد" . "</div>";
    }
    if ($captcha != $_SESSION['login']) {
        $page_validation = false;
        $captcha_err = "<div class='alert alert-danger'>" . "کد امنیتی به درستی وارد نشده است" . "</div>";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $page_validation = false;
        $email_err = "<div class='alert alert-danger'>" . "پست الکترونیکی معتبر نیست" . "</div>";
    }
    if (strlen($user_pass) < 8) {
        $page_validation = false;
        $password_err = "<div class='alert alert-danger'>" . "کلمه عبور نباید کمتر از 8 حرف باشد" . "</div>";
    }
    if ($user_pass != $user_pass_repeat) {
        $page_validation = false;
        $password_repeat_err = "<div class='alert alert-danger'>" . "کلمه عبور با تکرار آن برابر نیست" . "</div>";
    }
    if ($page_validation == true) {

        $email_user = $database->users()
            ->where("email = ?", $email)
            ->fetch();

        if ($email_user) {
            $page_validation = false;
            $email_err = "<div class='alert alert-danger'>" . "پست الکترونیکی قبلا استفاده شده است" . "</div>";
        }
    }
    #endregion validation_check
    //---------------

    if ($page_validation) {
        try {
            $today = jdate('Y/m/d');
            $user_type = "5"; // Normal user
            $status = "0"; // Not activated
            $hashed_password = password_hash($user_pass, PASSWORD_DEFAULT);
            $verify_code = mt_rand(10000000,99999999);
            $last_verify_code_date = date("Y-m-d H:i:s");
            $email_verify=0;
            $phone_verify=0;
            $failed_login_try=0;

            $property = array(
                "id" => null, "name" => $first_name, "family" => $last_name, "email" => $email, "username" => $email,
                "password" => $hashed_password, "phone" => "", "gender" => null, "birth_date" => "", "address" => "", "photo" => "",
                "reg_date" => $today, "type" => $user_type, "verify_code"=>$verify_code,"last_verify_code_date"=>$last_verify_code_date,
                "email_verify"=>$email_verify,"phone_verify"=>$phone_verify,"failed_login_try"=>$failed_login_try,"status" => $status
            );

            $users = $database->users()->insert($property);
            $file_id = $users['id'];

            if ($file_id == null || $file_id == '') {
                $msg = "<div class='alert alert-danger'>خطا در ذخیره سازی داده ها</div>";
            } else {
                SendEmailToUser($email,$first_name,$last_name,$file_id,$HOST_NAME,$verify_code);
                $email_verify_message = "ایمیل برای شما ارسال گردیده است";
                $msg = "<div class='alert alert-success'>{$email_verify_message}</div>";
            }
        } catch (PDOException $ex) {
            $msg = $ex->getMessage();
        }
    } else {
        $msg = "<div class='alert alert-danger'>داده ها به درستی وارد نشده است</div>";
    }
}


function SendEmailToUser($email, $first_name, $last_name, $file_id, $host_name,$verify_code)
{
    $to = $email;
    $subject = 'همگروه';
    $sender = "info@hamgorooh.com";
    $headers = "From: " . strip_tags($sender) . "\r\n";
    $headers .= "Reply-To: " . strip_tags($sender) . "\r\n";
    $headers .= "CC: mmng14@gmail.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";

    $msg_body = '';
    $msg_body = $msg_body . ' ' . $first_name . ' ' . $last_name;
    $msg_body = $msg_body . ' ' . 'به سايت همگروه خوش آمدید' . '<br/>';
    $msg_body = $msg_body . ' ' . ' نام کاربری : ' . $email . '<br/>';
    $msg_body = $msg_body . ' ' . 'برای فعال سازی اکانت ،  به آدرس زیر بروید' . '<br/>';
    $str_code = $verify_code;// base64_encode($email . "hamgorooh" . $file_id);
    //$msg_body = $msg_body . "<a style=\"color:blue;\" href=\"{$host_name}/user_activate/{$email}/{$str_code}/\>لینک فعال سازی</a>";
    $msg_body = $msg_body . "{$host_name}user_activate/{$email}/{$str_code}";
    //--Make a html box------
    $msg_body_header = "
			<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
			'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
			<html>
				<head>
					<style type='text/css'>
					.box
					{
					border: 4px solid green;
					padding:10px;
					font-family:tahoma;
					font-size:12px;
					color: #4F8A10;
					float:right;
					text-align:right;
                    width:100%;
					}
					</style>
			</head>
			<body>
					<div class='box'>
                      <h3>بانک اطلاعات عمومی همگروه</h3>
					  <hr/>";

    $msg_body_footer = "</div></body></html>";
    $msg_body = $msg_body_header . $msg_body . $msg_body_footer;
    $flag = mail($to, $subject, $msg_body, $headers);
    if ($flag == true)
        $register_msg = "<div class='alert alert-success'> یک ایمیل برای شما ارسال گردید . برای فعال سازی اکانت خود برروی لینک ارسالی کلیک نمایید </div>";
    else
        $register_msg = "<div class='alert alert-danger'> خطا در ارسال ایمیل </div>";
}



<?php
//require_once "core/utility_controller.php";


//for sendCode ajax call
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["SEND_OTP_CODE"]) {

    $page_validation = true;

    $email = mysql_escape_mimic($_POST['userEmail']);
    $user_id = "";
    $first_name = "";
    $last_name = "";
    //Check Server Side Validation
    $server_validation_errors = "";
    #region validation_check

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $page_validation = false;
        $email_err = "<li>" . "پست الکترونیکی معتبر نیست" . "</li>";
        $server_validation_errors .= $email_err;
    }

    if ($page_validation == true) {

        $email_user = $database->users()
            ->where("email = ?", $email)
            ->fetch();

        if (!$email_user) {
            $page_validation = false;
            $email_err = "<li>" . "پست الکترونیکی در سیستم موجود نیست" . "</li>";
            $server_validation_errors .= $email_err;
        }
    }
    #endregion validation_check
    //---------------

    if ($page_validation) {
        try {

            $user_id = $email_user["id"];
            $first_name = $email_user["name"];
            $last_name = $email_user["family"];

            $verify_code = mt_rand(10000000, 99999999);
            $last_verify_code_date = date("Y-m-d H:i:s");

            $edit_row = $database->users[$user_id];
            $property = array("verify_code" => $verify_code, "last_verify_code_date" => $last_verify_code_date);
            $affected = $edit_row->update($property);



            if ($affected == null || $affected == '') {
                $msg = "خطا در ارسال کد";
                echo json_encode(
                    array(
                        "message" => $msg,
                        "redirect" => "",
                        "status" => "-1",
                    )
                );
            } else {

                SendEmailToUser($email, $first_name, $last_name, $user_id, $HOST_NAME, $verify_code);

                $email_verify_message = "<li>" . " کاربر کرامی ، یک کد 8 رقمی برای شما ارسال شد. " . "</li>";
                $email_verify_message .= "<li>" . " برای تغییر کلمه عبور خود وارد ایمیل خود شوید و کد ارسالی را در قسمت زیر وارد نمایید." . "</li>";
                $email_verify_message .= "<li>" . " توجه : امکان دارد ایمیل ارسال وارد قسمت اسپم  شده باشد" . "</li>";

                $msg = $email_verify_message;
                echo json_encode(
                    array(
                        "message" => $msg,
                        "redirect" => "",
                        "code" => $verify_code,
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

//Recover Password Ajax
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["RECOVER_PASSWORD_CODE"]) {

    $page_validation = true;

    $userEmail = mysql_escape_mimic($_POST['userEmail']);
    $userVerifyCode = mysql_escape_mimic($_POST['verifyCode']);
    $newPassword = mysql_escape_mimic($_POST['newPassword']);

    $user_id = "";

    //Check Server Side Validation
    $server_validation_errors = "";
    #region validation_check

    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        $page_validation = false;
        $email_err = "<li>" . "پست الکترونیکی معتبر نیست" . "</li>";
        $server_validation_errors .= $email_err;
    }

    if ($page_validation == true) {

        $email_user = $database->users()
            ->where("email = ?", $userEmail)
            ->fetch();

        if (!$email_user) {
            $page_validation = false;
            $email_err = "<li>" . "پست الکترونیکی در سیستم موجود نیست" . "</li>";
            $server_validation_errors .= $email_err;
        }
    }
    #endregion validation_check
    //---------------

    if ($page_validation) {

        $verify_code =  $email_user['verify_code'];
        if ($verify_code == $userVerifyCode) {
            try {
                $user_id = $email_user["id"];
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

                $edit_row = $database->users[$user_id];
                $property = array( "password" => $hashed_password);
                $affected = $edit_row->update($property);

                if ($affected == null || $affected == '') {
                    $msg = "خطا در ارسال کد";
                    echo json_encode(
                        array(
                            "message" => $msg,
                            "redirect" => "",
                            "status" => "-1",
                        )
                    );
                } else {

                    $msg = "کلمه عبور با موفقیت بروز رسانی شد";
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
        }else{
            echo json_encode(
                array(
                    "message" => "کد ارسالی صحیح نیست",
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


function SendEmailToUser($email, $first_name, $last_name, $file_id, $host_name, $verify_code)
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
    $msg_body = $msg_body . ' ' . 'بازیابی کلمه عبور' . '<br/>';
    $msg_body = $msg_body . ' ' . ' نام کاربری : ' . $email . '<br/>';
    $msg_body = $msg_body . ' ' . 'کد ارسالی شما :' . '<br/>';
    $str_code = $verify_code; // base64_encode($email . "hamgorooh" . $file_id);
    //$msg_body = $msg_body . "<a style=\"color:blue;\" href=\"{$host_name}/user_activate/{$email}/{$str_code}/\>لینک فعال سازی</a>";
    $msg_body = $msg_body . "{$str_code}";
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
        $register_msg = "<div class='alert alert-success'> یک ایمیل برای شما ارسال گردید . برای تغییر رمز عبور خود از آن استفاده  نمایید </div>";
    else
        $register_msg = "<div class='alert alert-danger'> خطا در ارسال ایمیل </div>";
}

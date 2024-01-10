<?php
//require_once "core/utility_controller.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();


    $activation = null;
    $msg = null;
    if (isset($url_user_name) && isset($url_verify_code)) {

        $verify_username = $url_user_name;
        $user = $database->users()
            ->where("username = ?", $url_user_name)
            ->fetch();

        if ($user) {
            $str_code = "";
            $verify_status = $user['status'];
            if ($verify_status == 0) {
                $user_id = $user["id"];
                $verify_code =  $user['verify_code']; // base64_encode($verify_username . "hamgorooh" . $user_id);
                if ($verify_code == $url_verify_code) {

                    $edit_row = $database->users[$user_id];
                    $property = array("status" => 1);
                    $affected = $edit_row->update($property);

                    if ($affected == null) {
                        $msg = "<div class='alert alert-danger'>خطا در بروز رسانی داده ها  </div>";
                    } else {

                        $msg = "<div class='alert alert-success'>داده ها با موفقیت بروز رسانی شد</div>";
                        $flag = true;
                    }


                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['username'];
                    $_SESSION['full_name'] = $user['name'] . " " . $user['family'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_photo'] = $user['photo'];
                    $_SESSION['user_type'] = $user['type'];
                    
                    $user_type_name = "";
                    if ($user['type'] == 1) {
                        $user_type_name = "مدیر سایت";
                    }
                    if ($user['type'] == 2) {
                        $user_type_name = "مدیر ويژه";
                    }
                    if ($user['type'] == 3) {
                        $user_type_name = "مدیر گروه";
                    }
                    if ($user['type'] == 4) {
                        $user_type_name = "کابر ويژه";
                    }
                    if ($user['type'] == 5) {
                        $user_type_name = "کاربر سایت";
                    }
                    $_SESSION['user_type_name'] = $user_type_name;
                    $msg = "<div class='alert alert-success'>اکانت شما با موفقيت فعال شد  </div>";

                    $activation = "pass";
                    header("refresh: 10; {$HOST_NAME}users/profile"); // change to profile.php later
                } else {
                    $activation = "failed";
                    $msg = "<div class='alert alert-danger'>خطا در فعال سازی  </div>";
                }
            } elseif ($verify_status == '1') {
                $msg = "<div class='alert alert-danger'>اين اکانت قبلا فعال شده است  </div>";
            } elseif ($verify_status == '-1') {
                $msg = "<div class='alert alert-danger'>اين اکانت  توسط مدیر سايت مسدود شده است  شده است  </div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>کاربری با این مشخصات یافت نشد  </div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>اطلاعات ارسالی نادرست می باشد  </div>";
    }


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/user_activate.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}

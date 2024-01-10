
<!-- signup-page -->
<div class="signup-page">
    <div class="container">
        <div class="row">
            <!-- user-login -->
            <div class="col-sm-4 col-sm-offset-4">
                <div class="register-account">
                    <h1 class="section-title title">ثبت نام</h1>
                    <?php if(isset($msg)) echo $msg; ?>
                    <form id="registation-form" name="registation-form" method="post" action="#">
                        <div class="form-group">
                            <label>نام</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required="required">
                            <div id="first_name_msg"><?php if(isset($firstname_err)) echo $firstname_err; ?></div>
                        </div>
                        <div class="form-group">
                            <label>نام خانوادگی</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required="required">
                            <div id="last_name_msg"><?php if(isset($lastname_err)) echo $lastname_err; ?></div>
                        </div>
                        <div class="form-group">
                            <label>ایمیل</label>
                            <input type="email" name="email" id="email" class="form-control" required="required">
                            <div id="email_msg"><?php if(isset($email_err)) echo $email_err; ?></div>
                        </div>
                        <div class="form-group">
                            <label>کلمه عبور</label>
                            <input type="password" name="password" id="password" class="form-control" required="required">
                            <div id="password_msg"><?php if(isset($password_err)) echo $password_err; ?></div>
                        </div>
                        <div class="form-group">
                            <label>تکرار کلمه عبور</label>
                            <input type="password" name="re_password" id="re_password" class="form-control" required="required">
                            <div id="re_password_msg"><?php if(isset($password_repeat_err)) echo $password_repeat_err; ?></div>
                        </div>
                        <div class="form-group text-center ">
                            <img id="captcha_img" src="<?php echo $HOST_NAME; ?>/libraries/captcha.class.php?cap=login.png" />
                            <img  id="refresh" onclick="refresh_captcha()"  src="<?php echo $HOST_NAME; ?>resources/admin/img/refresh-icon.png" title="کد امنیتی جدید" style="cursor: pointer;">
                        </div>
                        <div class="form-group">
                            <label>کد امنیتی</label>
                            <input type="text" name="captcha_code" id="captcha_code" class="form-control" required="required">
                            <div id="captcha_code_msg"><?php if(isset($captcha_err)) echo $captcha_err; ?></div>
                        </div>

                        <!-- checkbox -->
                        <div class="checkbox">
                            <label class="pull-left" for="signing"><input type="checkbox" name="signing" id="signing"> با کلیه شرایط و قوانین سایت موافق هستم </label>
                        </div><!-- checkbox -->
                        <div class="submit-button text-center">
                            <button type="submit" name="signup" id="signup" class="btn btn-primary">ثبت نام</button>
                        </div>
                    </form>
                </div>
            </div><!-- user-login -->
        </div><!-- row -->
    </div><!-- container -->
</div>
<!-- signup-page -->

<script src="<?php echo $HOST_NAME; ?>app/home/scripts/signup.js"></script>
<style>
    .captcha-text{
        direction: ltr;
        font-family: tahoma;
        font-size: 16px;
        text-align: center;
    }


</style>
<!-- signup-page -->
<div class="signup-page">
    <div class="container">
        <div class="row">
            <!-- user-login -->
            <div class="col-sm-4 col-sm-offset-4">
                <div class="register-account account-login">
                    <h1 class="section-title title">ورود کاربر</h1>
                    <?php if(isset($login_msg)) echo $login_msg; ?>
                    <form id="registation-form" name="registation-form" method="post" action="#">

                        <div class="form-group">
                            <label>نام کاربری</label>
                            <input type="email" name="username" id="username" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label>کلمه عبور</label>
                            <input type="password" name="userpass"  id="userpass" class="form-control" required="required">
                        </div>
                        <div class="form-group text-center ">
                            <div class="g-recaptcha" data-sitekey="6LfpYbIUAAAAAF9AGYPdkrx-ZyWqaIYj7aOCg5mK"></div>

<!--                            <img id="captcha_img" src="--><?php //echo $HOST_NAME; ?><!--/libraries/captcha.class.php?cap=login.png" />-->
<!--                            <img  id="refresh" onclick="refresh_captcha()"  src="--><?php //echo $HOST_NAME; ?><!--resources/admin/img/refresh-icon.png" title="کد امنیتی جدید" style="cursor: pointer;">-->
                        </div>
<!--                        <div class="form-group text-center">-->
<!--                            <label>کد امنیتی</label>-->
<!--                            <input type="text" name="captcha_code" id="captcha_code" class="form-control text-center captcha-text" required="required">-->
<!--                            <div id="captcha_code_msg">--><?php //if(isset($captcha_err)) echo $captcha_err; ?><!--</div>-->
<!--                        </div>-->
                        <!-- checkbox -->
                        <div class="checkbox">
                            <label class="pull-left"><input type="checkbox" name="signing" id="signing"> مرا بخاطر بسپار </label>
                            <a href="#" class="pull-right ">کلمه عبور را فراموش کرده ام </a>
                        </div><!-- checkbox -->
                        <div class="submit-button text-center">
                            <button type="submit" name="signin" class="btn btn-primary">ورود به سیستم</button>
                        </div>
                    </form>
                    <div class="new-user text-center">
                        <p>هنور ثبت نام نکرده اید  ؟ <a href="<?= $HOST_NAME ?>/signup/">اکنون ثبت نام نمایید</a> </p>
                    </div>

                </div>
            </div><!-- user-login -->
        </div><!-- row -->
    </div><!-- container -->
</div>
<!-- signup-page -->
<script src='https://www.google.com/recaptcha/api.js'></script>

<script src="<?php echo $HOST_NAME; ?>app/home/scripts/signin.js"></script>

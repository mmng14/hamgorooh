<div class="container">
	<div class="row display-flex">
		<div class="col col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
			<div class="landing-content">
				<h3>بانک اطلاعات عمومی و شبکه اجتماعی همگروه</h1>
				<p>
					این سامانه به منظور استفاده صحیح تر از شبکه های اجتماعی و در جهت استفاده از خرد جمعی
					برای بالا بردن اطلاعات عمومی افراد طراحی شده است.
				</p>
				<a href="#" class="btn btn-md btn-border c-white">همین الان ثبت نام کنید!</a>
			</div>
		</div>

		<div class="col col-xl-5 ml-auto col-lg-6 col-md-12 col-sm-12 col-12">


			<!-- Login-Registration Form  -->

			<div class="registration-login-form">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">

					<li class="nav-item ">
						<a class="nav-link " data-toggle="tab" href="#home" role="tab" title="ثبت نام">
							<svg class="olymp-register-icon">
								<use xlink:href="#olymp-register-icon"></use>
							</svg>
						</a>
					</li>

					<li class="nav-item active">
						<a class="nav-link" data-toggle="tab" href="#profile" role="tab" title="ورود">
							<svg class="olymp-login-icon">
								<use xlink:href="#olymp-login-icon"></use>
							</svg>
						</a>
					</li>

				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

					<div class="tab-pane " id="home" role="tabpanel" data-mh="log-tab">
						<div class="title h6">ثبت نام در همگروه</div>
						<form id="registationForm"  method="post" class="content" >
							<div class="row">
							<?php if(isset($msg)) echo $msg; ?>
								<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div class="form-group label-floating">
										<label class="control-label">نام</label>
										<input name="first_name" id="first_name" class="form-control" placeholder="" type="text">
										<div id="first_name_msg"><?php if(isset($firstname_err)) echo $firstname_err; ?></div>
									</div>
								</div>
								<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
									<div class="form-group label-floating">
										<label class="control-label">نام خانوادگی</label>
										<input name="last_name" id="last_name" class="form-control" placeholder="" type="text">
										<div id="last_name_msg"><?php if(isset($lastname_err)) echo $lastname_err; ?></div>
									</div>
								</div>
								<div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
									<div class="form-group label-floating">
										<label class="control-label">ایمیل</label>
										<input name="email" id="email" class="form-control" style="text-align: center;direction: ltr;" placeholder="" type="email">
										<div id="email_msg"><?php if(isset($email_err)) echo $email_err; ?></div>
									</div>
									<div class="form-group label-floating">
										<label class="control-label">کلمه عبور</label>
										<input name="password" id="password" class="form-control" style="text-align: center;direction: ltr;" placeholder="" type="password">
										<div id="password_msg"><?php if(isset($password_err)) echo $password_err; ?></div>
									</div>
									<div class="form-group label-floating">
										<label class="control-label"> تکرار کلمه عبور</label>
										<input name="password_repeat" id="password_repeat" class="form-control" style="text-align: center;direction: ltr;" placeholder="" type="password">
										<div id="password_repeat_msg"><?php if(isset($password_repeat_err)) echo $password_repeat_err; ?></div>
									</div>
									<div class="form-group date-time-picker label-floating">
										<label class="control-label">تاریخ تولد</label>
										<input name="birth_date" id="birth_date" class="form-control date-picker" autocomplete="off" style="text-align: center;direction: ltr;" value="1358/07/20" />
										<span class="input-group-addon">
											<svg class="olymp-calendar-icon">
												<use xlink:href="#olymp-calendar-icon"></use>
											</svg>
										</span>
									</div>

									<div class="form-group label-floating is-select">
										<label class="control-label">جنسیت</label>
										<select  name="gender" id="gender" class="selectpicker form-control ">
											<option value=""> انتخاب جنسیت </option>	
											<option value="1">مرد</option>
											<option value="0">زن</option>											
										</select>
									</div>

									<div class="remember">
										<div class="checkbox">
											<label>
												<input id="acceptRulesOfSite" name="acceptRulesOfSite" type="checkbox">
												من <a href="#">قوانین و مقررات </a> سایت را می پذیرم.
											</label>
										</div>
									</div>

									<button name="registerButton" id="registerButton"  class="btn btn-purple btn-lg full-width ">ثبت نام</button>
								</div>
							</div>
						</form>
					</div>

					<div class="tab-pane active" id="profile" role="tabpanel" data-mh="log-tab">
						<div class="title h6">ورود به سیستم</div>
						<form id="frmLogin" class="content">
							<div class="row">
								<div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
									<div class="form-group label-floating">
										<label class="control-label">ایمیل</label>
										<input name="username" id="username" class="form-control" style="text-align: center;direction: ltr;" placeholder="" type="email" required="required">
									</div>
									<div class="form-group label-floating">
										<label class="control-label">کلمه عبور</label>
										<input name="userpass" id="userpass" class="form-control" style="text-align: center;direction: ltr;" placeholder="" type="password" required="required">
									</div>

									<div class="remember">

										<div class="checkbox">
											<label>
												<input name="remember_me" id="remember_me" type="checkbox">
												مرا به خاطر بسپار
											</label>
										</div>
										<a href="#" class="forgot" data-toggle="modal" data-target="#restore-password">کلمه عبور را فراموش کرده ام</a>
									</div>

									<button name="loginButton" id="loginButton"  class="btn btn-lg btn-primary full-width">ورود</button>

									<!-- <div class="or"></div>
				
										<a href="#" class="btn btn-lg bg-facebook full-width btn-icon-left"><i class="fab fa-facebook-f" aria-hidden="true"></i>Login with Facebook</a>
				
										<a href="#" class="btn btn-lg bg-twitter full-width btn-icon-left"><i class="fab fa-twitter" aria-hidden="true"></i>Login with Twitter</a> -->


									<p>اگر هنوز ثبت نام نکرده اید <a  data-toggle="tab" href="#home" role="tab" title="ثبت نام">اکنون ثبت نام</a> نمایید .</p>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>

			<!-- ... end Login-Registration Form  -->
		</div>
	</div>
</div>

<img class="img-bottom" src="<?= $HOST_NAME . "resources/assets/" ?>img/group-bottom.png" alt="friends">
<img class="img-rocket" src="<?= $HOST_NAME . "resources/assets/" ?>img/rocket.png" alt="rocket">
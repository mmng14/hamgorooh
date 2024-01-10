<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker-default.css">
<script src="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker.min.js"></script>

<?php if (isset($_SESSION["user_id"]) && isset($_SESSION["user_subjects"])) : ?>
	<section class="medium-padding120">
		<div class="container">
			<div class="row mb60">
				<div class="col col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12 m-auto">
					<div class="crumina-module crumina-heading align-center">
						<div class="heading-sup-title">همگروه</div>
						<h4 class="heading-title">گروههای من</h4>
						<!-- <p class="heading-text">
						تیم مدیریت گروههای اصلی ما
					</p> -->
					</div>
				</div>
			</div>

			<div class="row teammembers-wrap">

				<?php foreach ($_SESSION["user_subjects"] as $userSubject) : ?>

					<div class="col col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="ui-block">

							<!-- Friend Item -->
							<?php
							$subject_link =  $HOST_NAME . "subject/" . strlen($userSubject['subject_id']) . $userSubject['subject_id'] . "/" . preg_replace('#[ -]+#', '-', $userSubject['subject_name']);
							$resource_link =  $HOST_NAME . "resources/" . strlen($userSubject['subject_id']) . $userSubject['subject_id'] . "/" . preg_replace('#[ -]+#', '-', $userSubject['subject_name']);
							?>
							<div class="friend-item crumina-module crumina-teammembers-item">
								<a href="<?php echo $subject_link ?>" target="_blank">
									<div class="teammembers-thumb" style="height: 350px;overflow: hidden;margin-bottom: 5px;">
										<!-- <img src="<?php echo $HOST_NAME . $userSubject["subject_photo"]; ?>" alt="<?php echo $userSubject["subject_name"]; ?>"> -->
										<img class="main" style="object-fit: cover;height: 350px;" src="<?= $HOST_NAME; ?><?= $userSubject['subject_photo'] ?>" alt="<?= $userSubject['subject_name']  ?>">
										<img class="hover" style="object-fit: cover;height: 350px;" src="<?= $HOST_NAME; ?><?= $userSubject['subject_photo'] ?>" alt="<?= $userSubject['subject_name']  ?>">
										<div class="friend-avatar" style="text-align: center;">
											<div class="author-content" style="margin-right: 15px;">
												<a href="<?php echo $subject_link ?>" target="_blank" class="h5 author-name">
												<?php echo $userSubject["subject_name"]; ?>
											</a>
												<div class="country">همگروه</div>ّ
											</div>
										</div>

									</div>
								</a>
								<div class="swiper-wrapper">
									<div class="swiper-slide">

										<div class="control-block-button" data-swiper-parallax="-100">

											<a href="<?php echo $HOST_NAME; ?>users/post_management/<?php echo $userSubject["subject_id"] ?>" class="btn  bg-green">
												مدیریت پستها
												<!-- <svg class="olymp-blog-icon right-menu-icon">
													<use xlink:href="#olymp-blog-icon"></use>
												</svg> -->
											</a>

											<a href="<?php echo $subject_link ?>" target="_blank" class="btn  bg-blue">
												نمایش در سایت
												<!-- <svg class="olymp-chat---messages-icon">
                                                    <use xlink:href="#olymp-chat---messages-icon"></use>
                                                </svg> -->
											</a>

											<!-- <a href="<?php echo $resource_link ?>" target="_blank" class="btn  bg-orange">
                                                منابع گروه
                                                <svg class="olymp-chat---messages-icon">
                                                    <use xlink:href="#olymp-chat---messages-icon"></use>
                                                </svg>
                                            </a> -->
											<a href="<?php echo $HOST_NAME; ?>users/teammates/<?php echo $userSubject["subject_id"] ?>" class="btn  bg-purple">
												اعضای گروه
												<!-- <svg class="olymp-happy-faces-icon right-menu-icon">
													<use xlink:href="#olymp-happy-faces-icon"></use>
												</svg> -->
											</a>
											<a href="<?php echo $HOST_NAME; ?>users/messages/<?php echo $userSubject["subject_id"] ?>" class="btn  bg-orange">
												پیامهای گروه
												<!-- <svg class="olymp-chat---messages-icon">
                                                    <use xlink:href="#olymp-chat---messages-icon"></use>
                                                </svg> -->
											</a>
										</div>
									</div>

								</div>

							</div>

							<!-- ... end Friend Item -->
						</div>
					</div>
				<?php endforeach;    ?>


			</div>

		</div>
	</section>
<?php endif ?>
<section class="medium-padding120">
	<div class="container">
		<div class="row">
			<div class="col col-xl-4 col-lg-4 m-auto col-md-12 col-sm-12 col-12">
				<div class="crumina-module crumina-heading">
					<h4 class="heading-title">اطلاعات خود را با دیگران <span class="c-primary">به اشتراک </span>بگذارید</h4>
					<p class="heading-text">
						این سامانه به منظور به اشتراک گذاشتن اطلاعات عمومی افراد با استفاده از فناوری شبکه های اجتماعی طراحی شده است
					<h5> هدف ما <span class="c-primary"> جمع آوری </span> پستها و مقالات زبان فارسی <span class="c-primary"> و دسته بندی </span> آنها به شکلی است که <span class="c-primary"> دسترسی به آن ساده تر </span> و نحوه استفاده از آن <span class="c-primary"> مفید تر </span>باشد.</h5>
					</p>
					<a class="btn btn-primary btn-lg" href="<?= $HOST_NAME ?>subjects/">
						لیست همه گروهها
					</a>
				</div>
			</div>

			<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<img src="<?= $HOST_NAME . "resources/assets/" ?>img/image1.png" alt="screen">
			</div>
		</div>
	</div>
</section>


<!-- Planer Animation -->

<section class="medium-padding120 bg-section3 background-cover planer-animation">
	<div class="container">
		<div class="row mb60">
			<div class="col col-xl-4 col-lg-4 m-auto col-md-12 col-sm-12 col-12">
				<div class="crumina-module crumina-heading align-center">
					<!-- <div class="heading-sup-title">
						<a  href="<?= $HOST_NAME ?>subjects/">
							لیست همه گروهها
						</a>
					</div> -->
					<h4 class="heading-title">گروههای فعال </h4>
					<p class="heading-text"> لیست گروههایی که اعضای آن بیشترین میزان فعالیت را دارند وبیشترین بازدید را خود جذب کرده اند</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="swiper-container pagination-bottom" data-show-items="3">
				<div class="swiper-wrapper">
					<?php foreach ($subject_list as $subject) : ?>
						<div class="ui-block swiper-slide">

							<!-- Testimonial Item -->

							<div class="crumina-module crumina-testimonial-item">
								<div class="testimonial-header-thumb"></div>
								<?php
								$subject_link =  $HOST_NAME . "subject/" . strlen($subject['id']) . $subject['id'] . "/" . $subject['url_name'];
								$resource_link =  $HOST_NAME . "resources/" . strlen($subject['id']) . $subject['id'] . "/" . $subject['url_name'];
								?>
								<div class="testimonial-item-content">

									<div class="author-thumb">
										<a href="<?= $subject_link  ?>">
											<img src="<?= $HOST_NAME . $subject['photo']  ?>" alt="<?= $subject['name']  ?>" style="height:80px;max-width: 120px;">
										</a>
									</div>
									<a href="<?= $subject_link  ?>">
										<h4 class="testimonial-title"><?= $subject['name']  ?></h4>
									</a>
									<ul class="rait-stars" style="direction: ltr;">
										<li>
											<i class="fa fa-star star-icon c-primary" aria-hidden="true"></i>
										</li>
										<li>
											<i class="fa fa-star star-icon c-primary" aria-hidden="true"></i>
										</li>

										<li>
											<i class="fa fa-star star-icon c-primary" aria-hidden="true"></i>
										</li>
										<li>
											<i class="fa fa-star-half star-icon c-primary" aria-hidden="true"></i>
										</li>
										<li>
											<i class="far fa-star star-icon" aria-hidden="true"></i>
										</li>
									</ul>

									<p class="testimonial-message">
										<?= $subject['description']  ?>
									</p>

									<div class="author-content">

										<a href="<?= $subject_link  ?>" class="h6 author-name">نمایش پستهای گروه</a>
										<?php if ($subject['has_resource'] != null && $subject['has_resource'] == 1) : ?>
											<br />
											<a href="<?= $resource_link  ?>" class="h6 author-name country">نمایش منابع گروه</a>
										<?php endif ?>
										<!-- <div class="country">Los Angeles, CA</div> -->
									</div>
								</div>
							</div>

							<!-- ... end Testimonial Item -->
						</div>
					<?php endforeach ?>

				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>

	<img src="<?= $HOST_NAME . "resources/assets/" ?>img/planer.png" alt="planer" class="planer">
</section>

<!-- ... end Section Planer Animation -->

<!-- <section class="medium-padding120">
	<div class="container">
		<div class="row">
			<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<img src="<?= $HOST_NAME . "resources/assets/" ?>img/image4.png" alt="screen">
			</div>

			<div class="col col-xl-5 col-lg-5 m-auto col-md-12 col-sm-12 col-12">
				<div class="crumina-module crumina-heading">
					<h2 class="h1 heading-title">Release all the Power with the <span class="c-primary">Olympus App!</span></h2>
					<p class="heading-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
						incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
						ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</p>
				</div>

				
				<ul class="list--styled">
					<li>
						<i class="far fa-check-circle" aria-hidden="true"></i>
						Build your profile in just minutes, it’s that simple!
					</li>
					<li>
						<i class="far fa-check-circle" aria-hidden="true"></i>
						Unlimited messaging with the best interface.
					</li>
				</ul>

				<a href="#" class="btn btn-market">
					<img class="icon" src="svg-icons/apple-logotype.svg" alt="app store">
					<div class="text">
						<span class="sup-title">AVAILABLE ON THE</span>
						<span class="title">App Store</span>
					</div>
				</a>

				<a href="#" class="btn btn-market">
					<img class="icon" src="svg-icons/google-play.svg" alt="google">
					<div class="text">
						<span class="sup-title">ANDROID APP ON</span>
						<span class="title">Google Play</span>
					</div>
				</a>
			</div>
		</div>
	</div>
</section> -->


<!-- Section Subscribe Animation -->

<!-- <section class="medium-padding100 subscribe-animation scrollme bg-users">
	<div class="container">
		<div class="row">
			<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
				<div class="crumina-module crumina-heading c-white custom-color">
					<h2 class="h1 heading-title">Olympus Newsletter</h2>
					<p class="heading-text">Subscribe to be the first one to know about updates, new features and much more!
					</p>
				</div>

				
			
				
				<form class="form-inline subscribe-form" method="post">
					<div class="form-group label-floating is-empty">
						<label class="control-label">Enter your email</label>
						<input class="form-control bg-white" placeholder="" type="email">
					</div>
				
					<button class="btn btn-blue btn-lg">Send</button>
				</form>
				
				

			</div>
		</div>

		<img src="<?= $HOST_NAME . "resources/assets/" ?>img/paper-plane.png" alt="plane" class="plane">
	</div>
</section> -->

<!-- ... end Section Subscribe Animation -->



<!-- Section Call To Action Animation -->

<!-- <section class="align-right pt160 pb80 section-move-bg call-to-action-animation scrollme">
	<div class="container">
		<div class="row">
			<div class="col col-xl-10 m-auto col-lg-10 col-md-12 col-sm-12 col-12">
				<a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#registration-login-form-popup">Start Making Friends Now!</a>
			</div>
		</div>
	</div>
	<img class="first-img" alt="guy" src="<?= $HOST_NAME . "resources/assets/" ?>img/guy.png">
	<img class="second-img" alt="rocket" src="<?= $HOST_NAME . "resources/assets/" ?>img/rocket1.png">
	<div class="content-bg-wrap bg-section1"></div>
</section> -->

<!-- ... end Section Call To Action Animation -->


<div class="modal fade" id="registration-login-form-popup" tabindex="-1" role="dialog" aria-labelledby="registration-login-form-popup" aria-hidden="true">
	<div class="modal-dialog window-popup registration-login-form-popup" role="document">
		<div class="modal-content">
			<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
				<svg class="olymp-close-icon">
					<use xlink:href="#olymp-close-icon"></use>
				</svg>
			</a>
			<div class="modal-body">
				<div class="registration-login-form">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#profile1" role="tab">
								<svg class="olymp-login-icon">
									<use xlink:href="#olymp-login-icon"></use>
								</svg>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#home1" role="tab">
								<svg class="olymp-register-icon">
									<use xlink:href="#olymp-register-icon"></use>
								</svg>
							</a>
						</li>

					</ul>

					<!-- Tab panes -->
					<div class="tab-content">

						<div class="tab-pane active" id="profile1" role="tabpanel" data-mh="log-tab">
							<div class="title h6">ورود به سیستم</div>
							<form class="content">
								<div class="row">
									<div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
										<div class="form-group label-floating">
											<label class="control-label">Your Email</label>
											<input class="form-control" placeholder="" type="email">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Your Password</label>
											<input class="form-control" placeholder="" type="password">
										</div>

										<div class="remember">

											<div class="checkbox">
												<label>
													<!-- <input name="optionsCheckboxes" type="checkbox"> -->
													مرا به خاطر بسپار
												</label>
											</div>
											<a href="#" class="forgot" data-toggle="modal" data-target="#restore-password">Forgot my Password</a>
										</div>

										<a href="#" class="btn btn-lg btn-primary full-width">Login</a>

										<div class="or"></div>

										<a href="#" class="btn btn-lg bg-facebook full-width btn-icon-left"><i class="fab fa-facebook-f" aria-hidden="true"></i>Login with Facebook</a>

										<a href="#" class="btn btn-lg bg-twitter full-width btn-icon-left"><i class="fab fa-twitter" aria-hidden="true"></i>Login with Twitter</a>


										<p>Don’t you have an account?
											<a href="#">Register Now!</a> it’s really simple and you can start enjoing all the benefits!
										</p>
									</div>
								</div>
							</form>
						</div>

						<div class="tab-pane" id="home1" role="tabpanel" data-mh="log-tab">
							<div class="title h6">ثبت نام در همگروه</div>
							<form class="content">
								<div class="row">
									<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
										<div class="form-group label-floating">
											<label class="control-label">First Name</label>
											<input class="form-control" placeholder="" type="text">
										</div>
									</div>
									<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
										<div class="form-group label-floating">
											<label class="control-label">Last Name</label>
											<input class="form-control" placeholder="" type="text">
										</div>
									</div>
									<div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
										<div class="form-group label-floating">
											<label class="control-label">Your Email</label>
											<input class="form-control" placeholder="" type="email">
										</div>
										<div class="form-group label-floating">
											<label class="control-label">Your Password</label>
											<input class="form-control" placeholder="" type="password">
										</div>

										<div class="form-group date-time-picker label-floating">
											<label class="control-label">Your Birthday</label>
											<input name="datetimepicker" value="10/24/1984" />
											<span class="input-group-addon">
												<svg class="olymp-calendar-icon">
													<use xlink:href="#olymp-calendar-icon"></use>
												</svg>
											</span>
										</div>

										<div class="form-group label-floating is-select">
											<label class="control-label">Your Gender</label>
											<select class="selectpicker form-control">
												<option value="MA">Male</option>
												<option value="FE">Female</option>
											</select>
										</div>

										<div class="remember">
											<div class="checkbox">
												<label>
													<!-- <input name="optionsCheckboxes" type="checkbox"> -->
													I accept the <a href="#">Terms and Conditions</a> of the website
												</label>
											</div>
										</div>

										<a href="#" class="btn btn-purple btn-lg full-width">Complete Registration!</a>
									</div>
								</div>
							</form>
						</div>

					</div>
					<!--End Tab panes -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Window-popup Restore Password -->

<div class="modal fade" id="restore-password" tabindex="-1" role="dialog" aria-labelledby="restore-password" aria-hidden="true">
	<div class="modal-dialog window-popup restore-password-popup" role="document">
		<div class="modal-content">
			<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
				<svg class="olymp-close-icon">
					<use xlink:href="#olymp-close-icon"></use>
				</svg>
			</a>

			<div class="modal-header">
				<h6 class="title">فراموشی کلمه عبور</h6>
			</div>

			<div class="modal-body form-restore-password">
				<form id="frmRestorePassword">
					<p>ایمیل خود را وارد کرده و روی دکمه ارسال کد کلیک کنید. شما یک کد 8 رقمی برای شما ایمیل خواهد شد. لطفاً از کد ارسالی برای تغییر رمز عبور قدیمی برای رمز جدید استفاده کنید.
					</p>
					<div class="form-group label-floating">
						<label class="control-label">آدرس ایمیل خود را وارد نمایید</label>
						<input name="userEmail" id="userEmail" class="form-control text-center" placeholder="" type="email" value="">
					</div>
					<button class="btn btn-purple btn-lg full-width" name="sendRecoverPasswordCode" id="sendRecoverPasswordCode">ارسال کد به ایمیل</button>
					<div class="form-group label-floating">
						<label class="control-label">کد ارسالی به ایمیل را وارد نمایید</label>
						<input name="verifyCode" id="verifyCode" class="form-control text-center" placeholder="" type="text" value="">
					</div>
					<div class="form-group label-floating">
						<label class="control-label">کلمه عبور جدید را وارد نمایید</label>
						<input name="newPassword" id="newPassword" class="form-control text-center" placeholder="" type="password" value="">
					</div>
					<button name="recoverPassword" id="recoverPassword" class="btn btn-primary btn-lg full-width">تغییر کلمه عبور</button>
				</form>

			</div>
		</div>
	</div>
</div>

<!-- ... end Window-popup Restore Password -->

<script src="<?php echo $HOST_NAME; ?>app/home/scripts/index.js"></script>
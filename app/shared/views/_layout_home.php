<?php
date_default_timezone_set('Asia/Tehran');
$now_time = date('H:i:s', time());
$today_date = jdate('l d F Y');

if (isset($_SESSION['user_id'])) {
	#region redirect_home
	//admin home
	if ($_SESSION['user_type'] == "1") {
		$user_home = ("{$HOST_NAME}admin/index"); /* Redirect browser */
	}

	//admin subject
	if ($_SESSION['user_type'] == "2") {
		$user_home = ("{$HOST_NAME}group_admin/index"); /* Redirect browser */
	}

	//group admin
	if ($_SESSION['user_type'] == "3") {
		$user_home = ("{$HOST_NAME}users/index"); /* Redirect browser */
	}

	//group user
	if ($_SESSION['user_type'] == "4" || $_SESSION['user_type'] == "5") {
		$user_home = ("{$HOST_NAME}users/index"); /* Redirect browser */
	}
	#endregion redirect_home
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.crumina.net/html-olympus/51-OlympusCompanyPageHome.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 03 Aug 2020 16:02:48 GMT -->

<head>
	<!-- Google Tag Manager -->
	<script>
		(function(w, d, s, l, i) {
			w[l] = w[l] || [];
			w[l].push({
				'gtm.start': new Date().getTime(),
				event: 'gtm.js'
			});
			var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s),
				dl = l != 'dataLayer' ? '&l=' + l : '';
			j.async = true;
			j.src =
				'../../www.googletagmanager.com/gtm5445.html?id=' + i + dl;
			f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-TKGD7NP');
	</script>
	<!-- End Google Tag Manager -->

	<title><?= $page_title  ?></title>

	<!-- Required meta tags always come first -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- Bootstrap CSS -->

	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>Bootstrap/dist/css/bootstrap.css">


	<!-- Main Styles CSS -->
	<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/shared/css/fonts.css">
	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>css/main.rtl.css">
	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>css/fonts.min.css">
	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>css/custom.home.css">



	<!-- Main JS Libraries -->
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/jQuery/jquery-3.4.1.js"></script>
	<!-- <script src="<?php echo $HOST_NAME ?>/resources/plugins/sweetalert/sweetalert.min.js"></script> -->
	<script src="<?php echo $HOST_NAME ?>/resources/plugins/loaders/blockui.min.js"></script>
	<link rel="manifest" href="/manifest.json">

	<!-- toast alert -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> -->

	<script src="<?= $HOST_NAME ?>resources/plugins/toaster/toastr.min.js?v.d.002"></script>
	<link href="<?= $HOST_NAME ?>resources/plugins/toaster/toastr.min.css?v.d.002" rel="stylesheet">

	<!-- Sweet alert -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> -->
	<link href="<?= $HOST_NAME ?>resources/assets/js/libs/sweetalert2@9.js?v.d.002" rel="stylesheet">
	<script>
		var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
	</script>

	<!-- Main Font -->
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/webfontloader.min.js"></script>
	<script>
		WebFont.load({
			google: {
				families: ['Roboto:300,400,500,700:latin']
			}
		});
	</script>
	<style>
		#toast-container {
			width: 100% !important;
		}

		.toast-message {
			width: 100% !important;
		}

		.toast-top-full-width {
			width: 100% !important;
		}

		.toast-top-full-width .toast {
			width: 100% !important;
		}
	</style>

</head>

<body class="body-bg-white">
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TKGD7NP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->


	<!-- Preloader -->

	<!-- <div id="hellopreloader">
	<div class="preloader">
		<svg width="45" height="45" stroke="#fff">
			<g fill="none" fill-rule="evenodd" stroke-width="2" transform="translate(1 1)">
				<circle cx="22" cy="22" r="6" stroke="none">
					<animate attributeName="r" begin="1.5s" calcMode="linear" dur="3s" repeatCount="indefinite" values="6;22"/>
					<animate attributeName="stroke-opacity" begin="1.5s" calcMode="linear" dur="3s" repeatCount="indefinite" values="1;0"/>
					<animate attributeName="stroke-width" begin="1.5s" calcMode="linear" dur="3s" repeatCount="indefinite" values="2;0"/>
				</circle>
				<circle cx="22" cy="22" r="6" stroke="none">
					<animate attributeName="r" begin="3s" calcMode="linear" dur="3s" repeatCount="indefinite" values="6;22"/>
					<animate attributeName="stroke-opacity" begin="3s" calcMode="linear" dur="3s" repeatCount="indefinite" values="1;0"/>
					<animate attributeName="stroke-width" begin="3s" calcMode="linear" dur="3s" repeatCount="indefinite" values="2;0"/>
				</circle>
				<circle cx="22" cy="22" r="8">
					<animate attributeName="r" begin="0s" calcMode="linear" dur="1.5s" repeatCount="indefinite" values="6;1;2;3;4;5;6"/>
				</circle>
			</g>
		</svg>

		<div class="text">Loading ...</div>
	</div>
</div>-->
	<!-- ... end Preloader -->

	<div class="main-header main-header-fullwidth main-header-has-header-standard">


		<!-- Header Standard Landing  -->

		<div class="header--standard header--standard-landing" id="header--standard">
			<div class="container">
				<div class="header--standard-wrap">

					<a href="<?= $HOST_NAME ?>" class="logo">
						<div class="img-wrap">
							<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo.png" alt="بانک اطلاعات عمومی همگروه">
							<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo-colored-small.png" alt="بانک اطلاعات عمومی همگروه" class="logo-colored">
						</div>
						<div class="title-block">
							<h6 class="logo-title">بانک اطلاعات عمومی</h6>
							<div class="sub-title">شبکه اجتماعی</div>
						</div>
					</a>

					<a href="#" class="open-responsive-menu" data-toggle="modal" data-target="#main-popup-search">
						<svg class="olymp-magnifying-glass-icon">
							<use xlink:href="#olymp-magnifying-glass-icon"></use>
						</svg>
					</a>
					<?php if (!isset($_SESSION["user_id"])) : ?>

						<a href="<?= $HOST_NAME ?>" class="open-responsive-menu shoping-cart more">
							<svg class="olymp-login-icon">
								<use xlink:href="#olymp-login-icon"></use>
							</svg>
						</a>

					<?php else : ?>


						<a href="<?= $user_home  ?>" class="open-responsive-menu shoping-cart more">
							<img src="<?= $HOST_NAME ?><?= $_SESSION["user_photo"] ?>" alt="<?= $_SESSION["full_name"] ?>" title="<?= $_SESSION["full_name"] ?>" width="30" style="object-fit: cover;border-radius:50px" />

							<!-- <span style="margin-top: -25px;">
												خانه کاربر
											</span> -->
						</a>

						<a href="<?= $HOST_NAME ?>users/signout/" class="open-responsive-menu shoping-cart more text-white text-bold">
							خروج
						</a>

					<?php endif ?>
					<a href="#" class="open-responsive-menu js-open-responsive-menu">
						<svg class="olymp-menu-icon">
							<use xlink:href="#olymp-menu-icon"></use>
						</svg>
					</a>

					<div class="nav nav-pills nav1 header-menu">
						<div class="mCustomScrollbar">
							<ul>
								<li class="nav-item">
									<a href="<?= $HOST_NAME ?>" class="nav-link">صفحه اصلی</a>
								</li>
								<li class="nav-item">
									<a href="<?= $HOST_NAME ?>about/درباره-ما" class="nav-link">درباره ما</a>
								</li>
								<li class="nav-item">
									<a href="<?= $HOST_NAME ?>subjects/گروهها" class="nav-link">گروهها</a>
								</li>
								<!-- <li class="nav-item dropdown dropdown-has-megamenu">
									<a href="#" class="nav-link dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false" tabindex='1'>گروهها</a>
									<div class="dropdown-menu megamenu">
										<div class="row">
											<div class="col col-sm-2">
												<h6 class="column-tittle">آشپزی و شیرینی پزی</h6>
												<a class="dropdown-item" href="#">انواع غذاهای خارجی و داخلی<span class="tag-label bg-blue-light">new</span></a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">BuddyPress</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page<span class="tag-label bg-primary">HOT!</span></a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Corporate</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											

												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
											
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
											<div class="col col-sm-2">
												<h6 class="column-tittle">Forums</h6>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
												<a class="dropdown-item" href="#">Profile Page</a>
											</div>
							
										</div>
									</div>
								</li> -->

								<li class="nav-item">
									<a href="<?= $HOST_NAME ?>contact/تماس-با-ما" class="nav-link">تماس باما</a>
								</li>
								<li class="nav-item">
									<a href="<?= $HOST_NAME ?>ads/تبلیغات" class="nav-link">تبلیغات</a>
								</li>
								<!-- <li class="nav-item">
									<a href="<?= $HOST_NAME ?>help/راهنما" class="nav-link">راهنما</a>
								</li> -->
								<li class="nav-item">
									<a href="<?= $HOST_NAME ?>terms/قوانین-و-مقررات" class="nav-link">قوانین و مقررات</a>
								</li>
								<li class="close-responsive-menu js-close-responsive-menu">
									<svg class="olymp-close-icon">
										<use xlink:href="#olymp-close-icon"></use>
									</svg>
								</li>
								<li class="nav-item js-expanded-menu">
									<a href="#" class="nav-link">
										<svg class="olymp-menu-icon">
											<use xlink:href="#olymp-menu-icon"></use>
										</svg>
										<svg class="olymp-close-icon">
											<use xlink:href="#olymp-close-icon"></use>
										</svg>
									</a>
								</li>
								<?php if (!isset($_SESSION["user_id"])) : ?>
									<li class="shoping-cart more">
										<a href="#" class="nav-link">
											<svg class="olymp-login-icon">
												<use xlink:href="#olymp-login-icon"></use>
											</svg>
											<span class="count-product"></span>
										</a>
										<div class="more-dropdown shop-popup-cart" id="frmLoginMaster">
											<form>
												<h5 style="text-align: center;border-bottom: 1px solid #eee;padding: 20px 10px;">ورود به سیستم</h5>
												<div style="padding:20px;">
													<div class="p-0">
														<input type="text" name="username_master" id="username_master" class="form-control text-center" autocomplete="off" placeholder="نام کاربری" />
													</div>
													<div class="p-0">
														<input type="password" name="userpass_master" id="userpass_master" class="form-control text-center" autocomplete="off" placeholder="کلمه عبور" />
													</div>
													<span>رمز خود را فراموش کرده اید ؟</span>
													<div class="cart-btn-wrap">
														<button id="btnLoginMaster" name="btnLoginMaster" class="btn btn-primary btn-sm">ورود</button>
														<a href="<?= $HOST_NAME ?>" class="btn btn-purple btn-sm">ثبت نام</a>
													</div>
												</div>
											</form>
										</div>
									</li>
								<?php else : ?>

									<li class="shoping-cart more">
										<a href="<?= $user_home  ?>" class="nav-link">
											<img src="<?= $HOST_NAME ?><?= $_SESSION["user_photo"] ?>" alt="<?= $_SESSION["full_name"] ?>" title="<?= $_SESSION["full_name"] ?>" width="30" style="object-fit: cover;border-radius:50px" />

											<!-- <span style="margin-top: -25px;">
												خانه کاربر
											</span> -->
										</a>


										<div class="more-dropdown shop-popup-cart">

											<h5 style="text-align: center;border-bottom: 1px solid #eee;padding: 20px 10px;"><?= $_SESSION["full_name"] ?></h5>
											<div style="padding:20px;">
												<div class="p-0 text-center ">
													<img src="<?= $HOST_NAME ?><?= $_SESSION["user_photo"] ?>" alt="<?= $_SESSION["full_name"] ?>" title="<?= $_SESSION["full_name"] ?>" width="80" style="object-fit: cover;border-radius:50px" />
												</div>
												<hr />
												<div class="cart-btn-wrap">
													<a href="<?= $user_home  ?>" class="btn btn-primary btn-sm">خانه کاربر</a>
													<a href="<?= $HOST_NAME ?>users/signout/" class="btn btn-purple btn-sm">خروج</a>
												</div>
											</div>

										</div>
									</li>
									<li class="menu-search-item">
										<a href="<?= $HOST_NAME ?>users/signout/" class="nav-link">
											خروج
										</a>
									</li>
								<?php endif ?>

								<li class="menu-search-item">
									<a href="#" class="nav-link" data-toggle="modal" data-target="#main-popup-search">
										<svg class="olymp-magnifying-glass-icon">
											<use xlink:href="#olymp-magnifying-glass-icon"></use>
										</svg>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ... end Header Standard Landing  -->

		<div class="header-spacer--standard"></div>

		<div class="content-bg-wrap bg-landing"></div>

		<?php if (isset($show_register_form) && $show_register_form) : ?>
			<?php include $ROOT_DIR . "app/shared/views/_partials/_register_users.php"; ?>
		<?php endif ?>

		<?php if (isset($show_header) && $show_header) : ?>
			<div class="stunning-header-content">
				<h1 class="stunning-header-title"><?= $header_title ?></h1>

				<ul class="breadcrumbs">
					<li class="breadcrumbs-item">
						<a href="/">خانه</a>
						<span class="icon breadcrumbs-custom">/</span>
					</li>
					<li class="breadcrumbs-item active">
						<span><?= $header_title ?></span>
					</li>
				</ul>
			</div>
		<?php endif ?>
	</div>

	<!-- OP Codes -->


	<?php include $page_content ?>

	<!-- Window Popup Main Search -->

	<div class="modal fade" id="main-popup-search" tabindex="-1" role="dialog" aria-labelledby="main-popup-search" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered window-popup main-popup-search" role="document">
			<div class="modal-content">
				<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
					<svg class="olymp-close-icon">
						<use xlink:href="#olymp-close-icon"></use>
					</svg>
				</a>
				<div class="modal-body">
					<!-- <form role="form" action="https://www.google.com/search" target="_blank">
						<input type="hidden" value="hamgorooh.com/" name="domains">
						<input type="hidden" value="UTF-8" name="oe">
						<input type="hidden" value="UTF-8" name="ie">
						<input type="hidden" value="fa" name="hl">
						<input type="hidden" value="hamgorooh.com" name="sitesearch">
						<input type="text" id="query" name="q" class="search-form" autocomplete="off" placeholder="عبارت را وارد نموده و کلید Enter را فشار دهید">
					</form> -->
					<form class="form-inline search-form" role="form" action="https://www.google.com/search" target="_blank">
						<input type="hidden" value="hamgorooh.com/" name="domains">
						<input type="hidden" value="UTF-8" name="oe">
						<input type="hidden" value="UTF-8" name="ie">
						<input type="hidden" value="fa" name="hl">
						<input type="hidden" value="hamgorooh.com" name="sitesearch">
						<div class="form-group label-floating">
							<label class="control-label">عبارت جستجو را وارد نمایید</label>
							<input class="form-control bg-white" type="text" placeholder="" id="query" name="q" value="">
						</div>

						<button class="btn btn-purple btn-lg">جستجو</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- ... end Window Popup Main Search -->

	<!-- Footer Full Width -->

	<div class="footer footer-full-width" id="footer">
		<div class="container">
			<div class="row">
				<div class="col col-lg-4 col-md-4 col-sm-12 col-12">


					<!-- Widget About -->

					<div class="widget w-about">

						<a href="02-ProfilePage.html" class="logo">
							<div class="img-wrap">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo-colored-small.png" alt="شبکه اجتماعی همگروه">
							</div>
							<div class="title-block">
								<h6 class="logo-title">اطلاعات عمومی</h6>
								<div class="sub-title">شبکه اجتماعی</div>
							</div>
						</a>
						<p>سایت همگروه با هدف بالابردن سطح اطلاعات عمومی هموطنان عزیز طراحی شده و مطالب منتشر شده در آن منطبق با قوانین جمهوری اسلامی ایران می باشد.در ضمن مسئولیت صحت مطالب آن بر عهده نویسنده و یا سایت منبع می باشد.</p>
						<ul class="socials">
							<li>
								<a href="#">
									<i class="fab fa-facebook-square" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fab fa-twitter" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fab fa-youtube" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fab fa-google-plus-g" aria-hidden="true"></i>
								</a>
							</li>
							<li>
								<a href="#">
									<i class="fab fa-instagram" aria-hidden="true"></i>
								</a>
							</li>
						</ul>
					</div>

					<!-- ... end Widget About -->

				</div>

				<div class="col col-lg-2 col-md-4 col-sm-12 col-12">


					<!-- Widget List -->

					<div class="widget w-list">
						<h6 class="title">پیوند ها</h6>
						<ul>
							<li>
								<a href="<?= $HOST_NAME ?>">صفحه اصلی</a>
							</li>
							<li>
								<a href="<?= $HOST_NAME ?>about/درباره-ما">درباره ما</a>
							</li>
							<li>
								<a href="<?= $HOST_NAME ?>contact/تماس-با-ما">تماس باما</a>
							</li>
							<li>
								<a href="<?= $HOST_NAME ?>gallery/گالری">گالری</a>
							</li>
						</ul>
					</div>

					<!-- ... end Widget List -->

				</div>
				<div class="col col-lg-2 col-md-4 col-sm-12 col-12">


					<div class="widget w-list">
						<h6 class="title">پروفایل</h6>
						<ul>
							<li>
								<a href="#">خانه کاربر</a>
							</li>
							<li>
								<a href="#">درباره</a>
							</li>
							<li>
								<a href="#">دوستان</a>
							</li>
							<li>
								<a href="#">پستها</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="col col-lg-2 col-md-4 col-sm-12 col-12">


					<div class="widget w-list">
						<h6 class="title">امکانات</h6>
						<ul>
							<li>
								<a href="#">ایجاد گروه</a>
							</li>
							<li>
								<a href="#">ارسال و مدیریت پست</a>
							</li>
							<li>
								<a href="#">ارسال پیام</a>
							</li>
							<li>
								<a href="#">گروه دوستان</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="col col-lg-2 col-md-4 col-sm-12 col-12">


					<div class="widget w-list">
						<h6 class="title">همگروه</h6>
						<ul>
							<li>
								<a href="#">قوانین و مقررات</a>
							</li>
							<li>
								<a href="#">راهنما</a>
							</li>
							<li>
								<a href="#">تبلیغات</a>
							</li>
							<li>
								<a href="#">رپرتاژ </a>
							</li>
						</ul>
					</div>

				</div>

				<div class="col col-lg-12 col-md-12 col-sm-12 col-12">


					<!-- SUB Footer -->

					<div class="sub-footer-copyright">
						<span>
							تمامی حقوق سایت متعلق به شبکه اجتماعی
							<a href="https://www.hamgorooh.com/"> همگروه </a>
							می باشد


						</span>
					</div>

					<!-- ... end SUB Footer -->

				</div>
			</div>
		</div>
	</div>

	<!-- ... end Footer Full Width -->




	<!-- Window-popup-CHAT for responsive min-width: 768px -->

	<div class="ui-block popup-chat popup-chat-responsive" tabindex="-1" role="dialog" aria-labelledby="popup-chat-responsive" aria-hidden="true">

		<div class="modal-content">
			<div class="modal-header">
				<span class="icon-status online"></span>
				<h6 class="title">Chat</h6>
				<div class="more">
					<svg class="olymp-three-dots-icon">
						<use xlink:href="#olymp-three-dots-icon"></use>
					</svg>
					<svg class="olymp-little-delete js-chat-open">
						<use xlink:href="#olymp-little-delete"></use>
					</svg>
				</div>
			</div>
			<div class="modal-body">
				<div class="mCustomScrollbar">
					<ul class="notification-list chat-message chat-message-field">
						<li>
							<div class="author-thumb">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/avatar14-sm.jpg" alt="author" class="mCS_img_loaded">
							</div>
							<div class="notification-event">
								<span class="chat-message-item">Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks</span>
								<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
							</div>
						</li>

						<li>
							<div class="author-thumb">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/author-page.jpg" alt="author" class="mCS_img_loaded">
							</div>
							<div class="notification-event">
								<span class="chat-message-item">Don’t worry Mathilda!</span>
								<span class="chat-message-item">I already bought everything</span>
								<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:29pm</time></span>
							</div>
						</li>

						<li>
							<div class="author-thumb">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/avatar14-sm.jpg" alt="author" class="mCS_img_loaded">
							</div>
							<div class="notification-event">
								<span class="chat-message-item">Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks</span>
								<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
							</div>
						</li>
					</ul>
				</div>

				<form class="need-validation">

					<div class="form-group">
						<textarea class="form-control" placeholder="Press enter to post..."></textarea>
						<div class="add-options-message">
							<a href="#" class="options-message">
								<svg class="olymp-computer-icon">
									<use xlink:href="#olymp-computer-icon"></use>
								</svg>
							</a>
							<div class="options-message smile-block">

								<svg class="olymp-happy-sticker-icon">
									<use xlink:href="#olymp-happy-sticker-icon"></use>
								</svg>

								<ul class="more-dropdown more-with-triangle triangle-bottom-right">
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat1.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat2.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat3.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat4.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat5.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat6.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat7.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat8.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat9.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat10.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat11.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat12.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat13.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat14.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat15.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat16.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat17.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat18.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat19.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat20.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat21.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat22.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat23.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat24.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat25.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat26.png" alt="icon">
										</a>
									</li>
									<li>
										<a href="#">
											<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat27.png" alt="icon">
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>

	</div>

	<!-- ... end Window-popup-CHAT for responsive min-width: 768px -->



	<a class="back-to-top" href="#">
		<img src="<?= $HOST_NAME . "resources/assets/" ?>svg-icons/back-to-top.svg" alt="arrow" class="back-icon">
	</a>



	<!-- JS Scripts -->

	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.appear.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.mousewheel.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/perfect-scrollbar.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.matchHeight.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/svgxuse.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/imagesloaded.pkgd.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/Headroom.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/velocity.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/ScrollMagic.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.waypoints.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.countTo.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/popper.min.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/material.min.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/bootstrap-select.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/smooth-scroll.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/selectize.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/swiper.jquery.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/moment.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/daterangepicker.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/fullcalendar.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/isotope.pkgd.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/ajax-pagination.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/Chart.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/chartjs-plugin-deferred.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/circle-progress.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/loader.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/run-chart.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.magnific-popup.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/jquery.gifplayer.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/mediaelement-and-player.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/mediaelement-playlist-plugin.min.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/ion.rangeSlider.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/leaflet.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/MarkerClusterGroup.js"></script>

	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/main.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs-init/libs-init.js"></script>
	<script defer src="<?= $HOST_NAME . "resources/assets/" ?>fonts/fontawesome-all.js"></script>

	<script src="<?= $HOST_NAME . "resources/assets/" ?>Bootstrap/dist/js/bootstrap.bundle.js"></script>

	<!-- SVG icons loader -->
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/svg-loader.js"></script>
	<!-- /SVG icons loader -->

	<script src="<?php echo $HOST_NAME ?>resources/plugins/masks/jquery.mask.js"></script>
	<script src="<?php echo $HOST_NAME ?>resources/plugins/animations/animations.js"></script>
	<script src="<?php echo $HOST_NAME ?>/resources/plugins/jquery-validate/jquery.validate.js?v.d.001"></script>
	<script src="<?php echo $HOST_NAME ?>/app/shared/scripts/jqueryValidatoinConfig.js?v.d.001"></script>

	<script src="<?php echo $HOST_NAME ?>/app/shared/scripts/home.js"></script>
	<?php include_once $ROOT_DIR . "app/shared/views/_partials/_home_op_codes.php"; ?>

	<script>
		if ('serviceWorker' in navigator) {
			navigator.serviceWorker
				.register('/serviceworker.js')
				.then(function() {
					console.log('Service Worker Registered');
				});
		}
	</script>

</body>

<!-- Mirrored from html.crumina.net/html-olympus/51-OlympusCompanyPageHome.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 03 Aug 2020 16:03:00 GMT -->

</html>
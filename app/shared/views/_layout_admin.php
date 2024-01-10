<?php
date_default_timezone_set('Asia/Tehran');
$now_time = date('H:i:s', time());
//$today_date = jdate('Y/m/d');
if (!isset($page_title)) {
	$page_title = "پنل مدیریت";
}
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from html.crumina.net/html-olympus/42-ForumsOpenTopic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 03 Aug 2020 16:03:54 GMT -->

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

	<title><?= $page_title ?></title>

	<!-- Required meta tags always come first -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- Bootstrap CSS -->

	<link rel="stylesheet" type="text/css" href="<?php echo $HOST_NAME . "resources/assets/"  ?>Bootstrap/dist/css/bootstrap.css">


	<!-- Main Styles CSS -->
	<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/shared/css/fonts.css">
	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>css/admin.rtl.css">
	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>css/fonts.min.css">
	<link rel="stylesheet" type="text/css" href="<?= $HOST_NAME . "resources/assets/" ?>css/custom.admin.css">

	<link href="<?= $HOST_NAME ?>resources/plugins/datatable/datatables.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/admin/css/custom.css?v1.0.0.1">

	<!-- Main JS -->
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/jQuery/jquery-3.4.1.js"></script>
	<script src="<?php echo $HOST_NAME ?>/resources/plugins/loaders/blockui.min.js"></script>
	<link rel="manifest" href="/manifest.json">

	<!-- toast alert -->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"> -->
	<script src="<?= $HOST_NAME ?>resources/plugins/toaster/toastr.min.js?v.d.003"></script>
	<link href="<?= $HOST_NAME ?>resources/plugins/toaster/toastr.min.css?v.d.003" rel="stylesheet">

	<!-- Sweet alert -->

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- <script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/sweetalert2@10"></script> -->



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
		#notifications_list li {
			padding: 10px;
			list-style-type: none;
		}

		#notifications_list li div.author-thumb {
			padding: 10px;
			float: right;
			margin-left: 8px;
		}
	</style>

</head>

<body class="page-has-right-panels page-has-left-panels">
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


	<!-- Fixed Sidebar right -->

	<div class="fixed-sidebar">
		<div class="fixed-sidebar-right sidebar--small" id="sidebar-right">

			<a href="<?= $HOST_NAME ?>" class="logo">
				<div class="img-wrap">
					<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo.png" alt="Olympus">
				</div>
			</a>

			<div class="mCustomScrollbar" data-mcs-theme="dark">
				<?php include "includes/sidebars_responsive.php" ?>
			</div>
			<?php include "includes/sidebars_new.php" ?>
		</div>

		<div class="fixed-sidebar-right sidebar--large" id="sidebar-right-1">
			<a href="<?php echo $HOST_NAME; ?>users/profile/" class="logo">
				<div class="img-wrap">
					<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo.png" alt="Olympus">
				</div>
				<div class="title-block">
					<h6 class="logo-title">شبکه اجتماعی</h6>
				</div>
			</a>

			<div class="mCustomScrollbar" data-mcs-theme="dark">

				<?php include "includes/sidebars_new.php" ?>

				<div class="profile-completion">

					<div class="skills-item">
						<div class="skills-item-info">
							<span class="skills-item-title">تکمیل پروفایل</span>
							<span class="skills-item-count"><span class="count-animate" data-speed="1000" data-refresh-interval="50" data-to="76" data-from="0"></span><span class="units">76%</span></span>
						</div>
						<div class="skills-item-meter">
							<span class="skills-item-meter-active bg-primary" style="width: 76%"></span>
						</div>
					</div>

					<span> <a href="<?= $HOST_NAME ?>users/profile/">پروفایل</a> خود را کامل نمایید تا بقیه بهتر شما را بشناسند!</span>

				</div>
			</div>
		</div>
	</div>

	<!-- ... end Fixed Sidebar right -->


	<!-- Fixed Sidebar right -->

	<div class="fixed-sidebar fixed-sidebar-responsive">

		<div class="fixed-sidebar-right sidebar--small" id="sidebar-right-responsive">
			<a href="<?= $HOST_NAME ?>" class="logo js-sidebar-open">
				<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo.png" alt="Olympus">
			</a>

		</div>

		<div class="fixed-sidebar-right sidebar--large" id="sidebar-right-1-responsive">
			<a href="<?= $HOST_NAME ?>" class="logo">
				<div class="img-wrap">
					<img src="<?= $HOST_NAME . "resources/assets/" ?>img/logo.png" alt="Olympus">
				</div>
				<div class="title-block">
					<h6 class="logo-title">همگروه</h6>
				</div>
			</a>

			<div class="mCustomScrollbar" data-mcs-theme="dark">

				<div class="control-block">
					<div class="author-page author vcard inline-items">
						<div class="author-thumb">
							<img alt="author" src="<?= $HOST_NAME . "resources/assets/" ?>img/author-page.jpg" class="avatar">
							<span class="icon-status online"></span>
						</div>
						<a href="02-ProfilePage.html" class="author-name fn">
							<div class="author-title">
								نام کاربر <svg class="olymp-dropdown-arrow-icon">
									<use xlink:href="#olymp-dropdown-arrow-icon"></use>
								</svg>
							</div>
							<span class="author-subtitle">شرح کوتاه کاربر</span>
						</a>
					</div>
				</div>

				<div class="ui-block-title ui-block-title-small">
					<h6 class="title">قسمت اصلی</h6>
				</div>

				<?php include "includes/sidebars_new.php" ?>

				<div class="ui-block-title ui-block-title-small">
					<h6 class="title">حساب کاربری</h6>
				</div>

				<ul class="account-settings">
					<li>
						<a href="<?= $HOST_NAME ?>users/profile/">

							<svg class="olymp-menu-icon">
								<use xlink:href="#olymp-menu-icon"></use>
							</svg>

							<span>پروفایل کاربر</span>
						</a>
					</li>
					<li>
						<a href="#">
							<svg class="olymp-star-icon right-menu-icon" data-toggle="tooltip" data-placement="left" data-original-title="FAV PAGE">
								<use xlink:href="#olymp-star-icon"></use>
							</svg>

							<span>در خواست ایجاد گروه</span>
						</a>
					</li>
					<li>
						<a href="<?= $HOST_NAME ?>users/signout/">
							<svg class="olymp-logout-icon">
								<use xlink:href="#olymp-logout-icon"></use>
							</svg>

							<span>خروج</span>
						</a>
					</li>
				</ul>

				<div class="ui-block-title ui-block-title-small">
					<h6 class="title">درباره همگروه</h6>
				</div>

				<ul class="about-olympus">
					<li>
						<a href="#">
							<span>قوانین و مقررات</span>
						</a>
					</li>
					<li>
						<a href="#">
							<span>سوالات متداول</span>
						</a>
					</li>
					<li>
						<a href="#">
							<span>تماس با ما</span>
						</a>
					</li>
				</ul>

			</div>
		</div>
	</div>

	<!-- ... end Fixed Sidebar right -->


	<!-- Fixed Sidebar left -->

	<div class="fixed-sidebar left">
		<div class="fixed-sidebar-left sidebar--small" id="sidebar-left">

			<div class="mCustomScrollbar" data-mcs-theme="dark">
				<ul class="chat-users">
					<?php if (isset($_SESSION["user_subjects"])) : ?>
						<?php foreach ($_SESSION["user_subjects"] as $user_subject) : ?>
							<!-- <li class="inline-items js-chat-open"> -->
							<li class="inline-items">
								<?php

								$color = "";
								$role = $user_subject["role"];
								if ($role == 1) {
									$color = "red";
								}
								if ($role == 2) {
									$color = "orange";
								}
								if ($role == 3) {
									$color = "green";
								}
								if ($role == 4) {
									$color = "blue";
								}
								if ($role == 5) {
									$color = "purple";
								}
								?>
								<div class="author-thumb">
									<a href="<?= $HOST_NAME ?>users/group_messages/<?= $user_subject["subject_id"] ?>">
										<img alt="author" src="<?= $HOST_NAME ?><?php if ($user_subject["subject_photo"] != null) {
																					echo $user_subject["subject_photo"];
																				} else {
																					echo  "";
																				}   ?>" class="avatar" style="width:38px;height:38px">
									</a>
									<span class="icon-status bg-<?= $color ?>"></span>
								</div>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
				</ul>
			</div>

			<div class="search-friend inline-items">
				<a href="#" class="js-sidebar-open">
					<svg class="olymp-menu-icon">
						<use xlink:href="#olymp-menu-icon"></use>
					</svg>
				</a>
			</div>

			<a href="#" class="olympus-chat inline-items js-chat-open">
				<svg class="olymp-chat---messages-icon">
					<use xlink:href="#olymp-chat---messages-icon"></use>
				</svg>
			</a>

		</div>

		<div class="fixed-sidebar-left sidebar--large" id="sidebar-left-1">

			<div class="mCustomScrollbar" data-mcs-theme="dark">

				<div class="ui-block-title ui-block-title-small">
					<a href="#" class="title">گروههای من</a>
					<a href="#">تنظیمات</a>
				</div>

				<ul class="chat-users">
					<?php if (isset($_SESSION["user_subjects"])) : ?>
						<?php foreach ($_SESSION["user_subjects"] as $user_subject) : ?>

							<li class="inline-items">
								<?php

								$color = "";
								$role = $user_subject["role"];
								if ($role == 1) {
									$color = "red";
								}
								if ($role == 2) {
									$color = "orange";
								}
								if ($role == 3) {
									$color = "green";
								}
								if ($role == 4) {
									$color = "blue";
								}
								if ($role == 5) {
									$color = "purple";
								}
								?>
								<div class="author-thumb">
									<a href="<?= $HOST_NAME ?>users/group_messages/<?= $user_subject["subject_id"] ?>">
										<img alt="author" src="<?= $HOST_NAME ?><?php if ($user_subject["subject_photo"] != null) {
																					echo $user_subject["subject_photo"];
																				} else {
																					echo  "";
																				}   ?>" class="avatar" style="width:38px;height:38px">
									</a>
									<span class="icon-status bg-<?= $color ?>"></span>
								</div>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>

				</ul>

			</div>

			<div class="search-friend inline-items">
				<form class="form-group">
					<input class="form-control" placeholder="جستجوی گروهها من..." value="" type="text">
				</form>

				<a href="29-YourAccount-AccountSettings.html" class="settings">
					<svg class="olymp-settings-icon">
						<use xlink:href="#olymp-settings-icon"></use>
					</svg>
				</a>

				<a href="#" class="js-sidebar-open">
					<svg class="olymp-close-icon">
						<use xlink:href="#olymp-close-icon"></use>
					</svg>
				</a>
			</div>

			<a href="<?= $HOST_NAME ?>users/groups/" class="olympus-chat inline-items js-chat-open">

				<h6 class="olympus-chat-title">لیست همه گروهها</h6>
				<svg class="olymp-chat---messages-icon">
					<use xlink:href="#olymp-chat---messages-icon"></use>
				</svg>
			</a>

		</div>

	</div>

	<!-- ... end Fixed Sidebar left -->


	<!-- Fixed Sidebar left-Responsive -->

	<div class="fixed-sidebar left fixed-sidebar-responsive" id="sidebar-left-responsive">

		<div class="fixed-sidebar-left sidebar--small">
			<a href="#" class="js-sidebar-open">
				<svg class="olymp-menu-icon">
					<use xlink:href="#olymp-menu-icon"></use>
				</svg>
				<svg class="olymp-close-icon">
					<use xlink:href="#olymp-close-icon"></use>
				</svg>
			</a>
		</div>

		<div class="fixed-sidebar-left sidebar--large">
			<div class="mCustomScrollbar" data-mcs-theme="dark">

				<div class="ui-block-title ui-block-title-small">
					<a href="#" class="title">گروههای من</a>
					<a href="#">تنظیمات</a>
				</div>

				<ul class="chat-users">
					<?php if (isset($_SESSION["user_subjects"])) : ?>
						<?php foreach ($_SESSION["user_subjects"] as $user_subject) : ?>

							<li class="inline-items">
								<?php

								$color = "";
								$role = $user_subject["role"];
								if ($role == 1) {
									$color = "red";
								}
								if ($role == 2) {
									$color = "orange";
								}
								if ($role == 3) {
									$color = "green";
								}
								if ($role == 4) {
									$color = "blue";
								}
								if ($role == 5) {
									$color = "purple";
								}
								?>
								<div class="author-thumb">
									<a href="<?= $HOST_NAME ?>users/group_messages/<?= $user_subject["subject_id"] ?>">
										<img alt="author" src="<?= $HOST_NAME ?><?php if ($user_subject["subject_photo"] != null) {
																					echo $user_subject["subject_photo"];
																				} else {
																					echo  "";
																				}   ?>" class="avatar" style="width:38px;height:38px">
									</a>
									<span class="icon-status bg-<?= $color ?>"></span>
								</div>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>



				</ul>



			</div>

			<div class="search-friend inline-items">
				<form class="form-group">
					<input class="form-control" placeholder="جستجو در گروههای من..." value="" type="text">
				</form>

				<a href="29-YourAccount-AccountSettings.html" class="settings">
					<svg class="olymp-settings-icon">
						<use xlink:href="#olymp-settings-icon"></use>
					</svg>
				</a>

				<a href="#" class="js-sidebar-open">
					<svg class="olymp-close-icon">
						<use xlink:href="#olymp-close-icon"></use>
					</svg>
				</a>
			</div>

			<a href="#" class="olympus-chat inline-items js-chat-open">

				<h6 class="olympus-chat-title">نمایش همه گروهها</h6>
				<svg class="olymp-chat---messages-icon">
					<use xlink:href="#olymp-chat---messages-icon"></use>
				</svg>
			</a>
		</div>

	</div>

	<!-- ... end Fixed Sidebar left-Responsive -->


	<!-- Header-BP -->

	<header class="header" id="site-header">
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

		<div class="page-title">
			<h6>گروهها</h6>
		</div>

		<div class="header-content-wrapper">
			<form class="search-bar w-search notification-list friend-requests">
				<div class="form-group with-button">
					<input class="form-control js-user-search" placeholder="برای جستجوی گروهها اینجا را کلیک کنید..." type="text">
					<button>
						<svg class="olymp-magnifying-glass-icon">
							<use xlink:href="#olymp-magnifying-glass-icon"></use>
						</svg>
					</button>
				</div>
			</form>

			<a href="#" class="link-find-friend">جستجوی گروهها</a>

			<div class="control-block">

				<div id="show_notifications" class="control-icon more has-items">
					<svg class="olymp-chat---messages-icon">
						<use xlink:href="#olymp-chat---messages-icon"></use>
					</svg>

					<div id="totoal_unvisited_notifications" class="label-avatar bg-purple totoal-unvisited-notifications">0</div>

					<div id="notifications_list" class="more-dropdown more-with-triangle triangle-top-center ">
						<!-- <div class="ui-block-title ui-block-title-small">
							<h6 class="title">Notifications</h6>
							<a href="#">Mark all as read</a>
							<a href="#">Settings</a>
						</div> -->

						<div class="mCustomScrollbar" data-mcs-theme="dark">
							<ul id="notification_list" class="notification-list notifications-result-list">

							</ul>
						</div>

						<a href="<?= $HOST_NAME ?>/users/notifications" class="view-all bg-purple">نمایش همه اعلانها</a>
					</div>
				</div>

				<!-- <div class="control-icon more has-items">
					<svg class="olymp-happy-face-icon">
						<use xlink:href="#olymp-happy-face-icon"></use>
					</svg>
					<div class="label-avatar bg-blue">6</div>

					<div class="more-dropdown more-with-triangle triangle-top-center">
						<div class="ui-block-title ui-block-title-small">
							<h6 class="title">FRIEND REQUESTS</h6>
							<a href="#">Find Friends</a>
							<a href="#">Settings</a>
						</div>

						<div class="mCustomScrollbar" data-mcs-theme="dark">
							<ul class="notification-list friend-requests">
								<li>
									<div class="author-thumb">
										<img src="img/avatar55-sm.jpg" alt="author">
									</div>
									<div class="notification-event">
										<a href="#" class="h6 notification-friend">Tamara Romanoff</a>
										<span class="chat-message-item">Mutual Friend: Sarah Hetfield</span>
									</div>
									<span class="notification-icon">
										<a href="#" class="accept-request">
											<span class="icon-add without-text">
												<svg class="olymp-happy-face-icon">
													<use xlink:href="#olymp-happy-face-icon"></use>
												</svg>
											</span>
										</a>

										<a href="#" class="accept-request request-del">
											<span class="icon-minus">
												<svg class="olymp-happy-face-icon">
													<use xlink:href="#olymp-happy-face-icon"></use>
												</svg>
											</span>
										</a>

									</span>

									<div class="more">
										<svg class="olymp-three-dots-icon">
											<use xlink:href="#olymp-three-dots-icon"></use>
										</svg>
									</div>
								</li>

								<li class="accepted">
									<div class="author-thumb">
										<img src="img/avatar57-sm.jpg" alt="author">
									</div>
									<div class="notification-event">
										You and <a href="#" class="h6 notification-friend">Mary Jane Stark</a> just became friends. Write on <a href="#" class="notification-link">her wall</a>.
									</div>
									<span class="notification-icon">
										<svg class="olymp-happy-face-icon">
											<use xlink:href="#olymp-happy-face-icon"></use>
										</svg>
									</span>

									<div class="more">
										<svg class="olymp-three-dots-icon">
											<use xlink:href="#olymp-three-dots-icon"></use>
										</svg>
										<svg class="olymp-little-delete">
											<use xlink:href="#olymp-little-delete"></use>
										</svg>
									</div>
								</li>

							</ul>
						</div>

						<a href="#" class="view-all bg-blue">Check all your Events</a>
					</div>
				</div> -->

				<!-- <div class="control-icon more has-items">
					<svg class="olymp-chat---messages-icon">
						<use xlink:href="#olymp-chat---messages-icon"></use>
					</svg>
					<div class="label-avatar bg-purple">2</div>

					<div class="more-dropdown more-with-triangle triangle-top-center">
						<div class="ui-block-title ui-block-title-small">
							<h6 class="title">Chat / Messages</h6>
							<a href="#">Mark all as read</a>
							<a href="#">Settings</a>
						</div>

						<div class="mCustomScrollbar" data-mcs-theme="dark">
							<ul class="notification-list chat-message">
								<li class="message-unread">
									<div class="author-thumb">
										<img src="img/avatar59-sm.jpg" alt="author">
									</div>
									<div class="notification-event">
										<a href="#" class="h6 notification-friend">Diana Jameson</a>
										<span class="chat-message-item">Hi James! It’s Diana, I just wanted to let you know that we have to reschedule...</span>
										<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">4 hours ago</time></span>
									</div>
									<span class="notification-icon">
										<svg class="olymp-chat---messages-icon">
											<use xlink:href="#olymp-chat---messages-icon"></use>
										</svg>
									</span>
									<div class="more">
										<svg class="olymp-three-dots-icon">
											<use xlink:href="#olymp-three-dots-icon"></use>
										</svg>
									</div>
								</li>
								<li class="chat-group">
									<div class="author-thumb">
										<img src="img/avatar11-sm.jpg" alt="author">
										<img src="img/avatar12-sm.jpg" alt="author">
										<img src="img/avatar13-sm.jpg" alt="author">
										<img src="img/avatar10-sm.jpg" alt="author">
									</div>
									<div class="notification-event">
										<a href="#" class="h6 notification-friend">You, Faye, Ed &amp; Jet +3</a>
										<span class="last-message-author">Ed:</span>
										<span class="chat-message-item">Yeah! Seems fine by me!</span>
										<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">March 16th at 10:23am</time></span>
									</div>
									<span class="notification-icon">
										<svg class="olymp-chat---messages-icon">
											<use xlink:href="#olymp-chat---messages-icon"></use>
										</svg>
									</span>
									<div class="more">
										<svg class="olymp-three-dots-icon">
											<use xlink:href="#olymp-three-dots-icon"></use>
										</svg>
									</div>
								</li>
							</ul>
						</div>

						<a href="#" class="view-all bg-purple">View All Messages</a>
					</div>
				</div> -->

				<div class="author-page author vcard inline-items more">
					<div class="author-thumb">
						<img alt="<?= $_SESSION["full_name"] ?>" src="<?= $HOST_NAME ?><?php if (isset($_SESSION["user_photo"])) echo $_SESSION["user_photo"]; ?>" class="avatar" style="height:50px" />
						<span class="icon-status online"></span>
						<div class="more-dropdown more-with-triangle">
							<div class="mCustomScrollbar" data-mcs-theme="dark">
								<div class="ui-block-title ui-block-title-small">
									<h6 class="title">اطلاعات کاربری</h6>
								</div>

								<ul class="account-settings">
									<li>
										<a href="<?= $HOST_NAME ?>users/profile/">

											<svg class="olymp-menu-icon">
												<use xlink:href="#olymp-menu-icon"></use>
											</svg>

											<span>پروفایل کاربر</span>
										</a>
									</li>
									<li>
										<a href="<?= $HOST_NAME ?>users/user_groups/">
											<svg class="olymp-star-icon right-menu-icon" data-toggle="tooltip" data-placement="left" data-original-title="FAV PAGE">
												<use xlink:href="#olymp-star-icon"></use>
											</svg>

											<span>گروههای من</span>
										</a>
									</li>
									<li>
										<a href="<?= $HOST_NAME ?>users/signout/">
											<svg class="olymp-logout-icon">
												<use xlink:href="#olymp-logout-icon"></use>
											</svg>

											<span>خروج</span>
										</a>
									</li>
								</ul>


							</div>

						</div>
					</div>
					<a href="02-ProfilePage.html" class="author-name fn">
						<div class="author-title">
							<?= $_SESSION["full_name"]  ?> <svg class="olymp-dropdown-arrow-icon">
								<use xlink:href="#olymp-dropdown-arrow-icon"></use>
							</svg>
						</div>
						<span class="author-subtitle"><?= $_SESSION["user_name"]  ?></span>
					</a>
				</div>

			</div>
		</div>

	</header>

	<!-- ... end Header-BP -->


	<!-- Responsive Header-BP -->

	<header class="header header-responsive" id="site-header-responsive">
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

		<div class="header-content-wrapper">
			<ul class="nav nav-tabs mobile-app-tabs" role="tablist">

				<!-- 
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#request" role="tab">
						<div class="control-icon has-items">
							<svg class="olymp-happy-face-icon">
								<use xlink:href="#olymp-happy-face-icon"></use>
							</svg>
							<div class="label-avatar bg-blue">6</div>
						</div>
					</a>
				</li> -->

				<!-- <li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#chat" role="tab">
						<div class="control-icon has-items">
							<svg class="olymp-chat---messages-icon">
								<use xlink:href="#olymp-chat---messages-icon"></use>
							</svg>
							<div class="label-avatar bg-purple">2</div>
						</div>
					</a>
				</li> -->

				<li class="nav-item show-notifications">
					<a class="nav-link" data-toggle="tab" href="#notification" role="tab">
						<div class="control-icon has-items">
							<svg class="olymp-chat---messages-icon">
								<use xlink:href="#olymp-chat---messages-icon"></use>
							</svg>
							<div class="label-avatar bg-purple totoal-unvisited-notifications">0</div>
						</div>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#search" role="tab">
						<svg class="olymp-magnifying-glass-icon">
							<use xlink:href="#olymp-magnifying-glass-icon"></use>
						</svg>
						<svg class="olymp-close-icon">
							<use xlink:href="#olymp-close-icon"></use>
						</svg>
					</a>
				</li>
			</ul>
		</div>

		<!-- Tab panes -->
		<div class="tab-content tab-content-responsive">


			<!-- <div class="tab-pane " id="request" role="tabpanel">

				<div class="mCustomScrollbar" data-mcs-theme="dark">
					<div class="ui-block-title ui-block-title-small">
						<h6 class="title">FRIEND REQUESTS</h6>
						<a href="#">Find Friends</a>
						<a href="#">Settings</a>
					</div>
					<ul class="notification-list friend-requests">
						<li>
							<div class="author-thumb">
								<img src="img/avatar55-sm.jpg" alt="author">
							</div>
							<div class="notification-event">
								<a href="#" class="h6 notification-friend">Tamara Romanoff</a>
								<span class="chat-message-item">Mutual Friend: Sarah Hetfield</span>
							</div>
							<span class="notification-icon">
								<a href="#" class="accept-request">
									<span class="icon-add without-text">
										<svg class="olymp-happy-face-icon">
											<use xlink:href="#olymp-happy-face-icon"></use>
										</svg>
									</span>
								</a>

								<a href="#" class="accept-request request-del">
									<span class="icon-minus">
										<svg class="olymp-happy-face-icon">
											<use xlink:href="#olymp-happy-face-icon"></use>
										</svg>
									</span>
								</a>

							</span>

							<div class="more">
								<svg class="olymp-three-dots-icon">
									<use xlink:href="#olymp-three-dots-icon"></use>
								</svg>
							</div>
						</li>
					</ul>
					<a href="#" class="view-all bg-blue">Check all your Events</a>
				</div>

			</div> -->

			<!-- <div class="tab-pane " id="chat" role="tabpanel">

				<div class="mCustomScrollbar" data-mcs-theme="dark">
					<div class="ui-block-title ui-block-title-small">
						<h6 class="title">Chat / Messages</h6>
						<a href="#">Mark all as read</a>
						<a href="#">Settings</a>
					</div>

					<ul class="notification-list chat-message">
						<li class="message-unread">
							<div class="author-thumb">
								<img src="img/avatar59-sm.jpg" alt="author">
							</div>
							<div class="notification-event">
								<a href="#" class="h6 notification-friend">Diana Jameson</a>
								<span class="chat-message-item">Hi James! It’s Diana, I just wanted to let you know that we have to reschedule...</span>
								<span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">4 hours ago</time></span>
							</div>
							<span class="notification-icon">
								<svg class="olymp-chat---messages-icon">
									<use xlink:href="#olymp-chat---messages-icon"></use>
								</svg>
							</span>
							<div class="more">
								<svg class="olymp-three-dots-icon">
									<use xlink:href="#olymp-three-dots-icon"></use>
								</svg>
							</div>
						</li>
					</ul>

					<a href="#" class="view-all bg-purple">View All Messages</a>
				</div>

			</div> -->

			<div class="tab-pane " id="notification" role="tabpanel">

				<div class="mCustomScrollbar" data-mcs-theme="dark">
					<div class="ui-block-title ui-block-title-small">
						<h6 class="title">اعلانها</h6>
						<a href="#">خوانده شده</a>
						<a href="#">تنظیمات</a>
					</div>

					<ul class="notification-list notifications-result-list">

					</ul>

					<a href="#" class="view-all bg-purple">نمایش همه اعلانها</a>
				</div>

			</div>

			<div class="tab-pane " id="search" role="tabpanel">


				<form class="search-bar w-search notification-list friend-requests">
					<div class="form-group with-button">
						<input class="form-control js-user-search" placeholder="Search here people or pages..." type="text">
					</div>
				</form>


			</div>

		</div>
		<!-- ... end  Tab panes -->

	</header>

	<!-- ... end Responsive Header-BP -->
	<!-- <div class="header-spacer header-spacer-small"></div> -->
	<div class="header-spacer"></div>


	<!-- Page Content -->
	<?php include $page_content ?>

	<!-- Footer Full Width -->

	<div class="footer footer-full-width" id="footer">
		<div class="container">
			<div class="row">
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

								<ul class="more-dropdown more-with-triangle triangle-bottom-left">
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

	<!-- OP Codes -->
	<?php include_once(sanitize_output($ROOT_DIR . "app/shared/views/_partials/_admin_op_codes_input.php")); ?>
	<?php //include_once $ROOT_DIR . "app/shared/views/_partials/_admin_op_codes.php"; 
	?>
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
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/moment.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/daterangepicker.js"></script>
	<script src="<?= $HOST_NAME . "resources/assets/" ?>js/libs/swiper.jquery.js"></script>
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

	<script src="<?php echo $HOST_NAME ?>resources/shared/bootstrap/js/jquery.confirm.js"></script>
	<script src="<?php echo $HOST_NAME ?>resources/plugins/datatable/datatables.min.js"></script>
	<script src="<?php echo $HOST_NAME ?>/app/scripts/shared/datatableConfig.js"></script>
	<script src="<?php echo $HOST_NAME ?>resources/plugins/masks/jquery.mask.js"></script>
	<script src="<?php echo $HOST_NAME ?>resources/plugins/animations/animations.js"></script>
	<script src="<?php echo $HOST_NAME ?>resources/plugins/selects/bootstrap_multiselect.js"></script>
	<script src="<?php echo $HOST_NAME ?>resources/plugins/jquery-validate/jquery.validate.js?v.d.001"></script>
	<script src="<?php echo $HOST_NAME ?>/app/shared/scripts/jqueryValidatoinConfig.js?v.d.001"></script>
	<script src="<?php echo $HOST_NAME ?>/app/shared/scripts/admin.js"></script>

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

<!-- Mirrored from html.crumina.net/html-olympus/42-ForumsOpenTopic.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 03 Aug 2020 16:03:54 GMT -->

</html>
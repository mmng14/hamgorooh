<style>
	.user-photo {
		width: 130px;
	}

	.author-thumb img {
		max-width: 50px;
	}

	.chat-message-item-current {
		background-color: #7c5ac2;
		color: #fff;
		float: left;
		direction: ltr;
	}

	.chat-message-item {
		padding: 13px;
		background-color: #f0f4f9;
		margin-top: 0;
		border-radius: 10px;
		margin-bottom: 5px;
		font-size: 12px;
	}

	.chat-others-li {
		text-align: right;
		direction: ltr;
		margin-right: 20px
	}

	.chat-others-div {
		direction: ltr;
	}

	.chat-others-span {
		margin-right: 25px;
		background: #7c5ac2;
		color: #f0f4f9;
	}

	.chat-message-field .notification-event {
		width: 90% !important;
	}
</style>



<div class="main-header">
	<div class="content-bg-wrap bg-group"></div>
	<div class="container">
		<div class="row">
			<div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
				<div class="main-header-content">
					<h3>پیامهای من</h1>
				</div>
			</div>
		</div>
	</div>
	<!--
	<img class="img-bottom" src="img/group-bottom.png" alt="friends"> -->

</div>

<div class="container">
	<div class="row">
		<div class="col col-xl-12 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">پیامهای من</h6>
					<a href="#" class="more"><svg class="olymp-three-dots-icon">
							<use xlink:href="#olymp-three-dots-icon"></use>
						</svg></a>
				</div>

				<div class="row">



					<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding-l-0">


						<div class="row">
							<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

								<div class="ui-block">


									<div class="birthday-item inline-items badges">
										<div class="author-thumb">
											<img src="<?= $HOST_NAME?>resources/assets/img/badge1.png" alt="author">
											<div class="label-avatar bg-primary">2</div>
										</div>
										<div class="birthday-author-name">
											<a href="#" class="h6 author-name">Olympian User</a>
											<div class="birthday-date">Congratulations! You have been in the Olympus community for 2 years.</div>
										</div>

										<div class="skills-item">
											<div class="skills-item-meter">
												<span class="skills-item-meter-active skills-animate" style="width: 76%; opacity: 1;"></span>
											</div>
										</div>

									</div>

								</div>

								<div class="ui-block">


									<div class="birthday-item inline-items badges">
										<div class="author-thumb">
											<img src="<?= $HOST_NAME?>resources/assets/img/badge2.png" alt="author">
										</div>
										<div class="birthday-author-name">
											<a href="#" class="h6 author-name">Favourite Creator</a>
											<div class="birthday-date">You created a favourite page.</div>
										</div>

										<div class="skills-item">
											<div class="skills-item-meter">
												<span class="skills-item-meter-active skills-animate" style="width: 100%; opacity: 1;"></span>
											</div>
										</div>

									</div>

								</div>

								<div class="ui-block">


									<div class="birthday-item inline-items badges">
										<div class="author-thumb">
											<img src="<?= $HOST_NAME?>resources/assets/img/badge3.png" alt="author">
											<div class="label-avatar bg-blue">4</div>
										</div>
										<div class="birthday-author-name">
											<a href="#" class="h6 author-name">Friendly User</a>
											<div class="birthday-date">You have more than 80 friends. Next Tier: 150 Friends. </div>
										</div>

										<div class="skills-item">
											<div class="skills-item-meter">
												<span class="skills-item-meter-active skills-animate" style="width: 52%; opacity: 1;"></span>
											</div>
										</div>

									</div>

								</div>

								<div class="ui-block">


									<div class="birthday-item inline-items badges">
										<div class="author-thumb">
											<img src="<?= $HOST_NAME?>resources/assets/img/badge4.png" alt="author">
										</div>
										<div class="birthday-author-name">
											<a href="#" class="h6 author-name">Professional Photographer</a>
											<div class="birthday-date">You have uploaded more than 500 images to your profile.</div>
										</div>

										<div class="skills-item">
											<div class="skills-item-meter">
												<span class="skills-item-meter-active skills-animate" style="width: 100%; opacity: 1;"></span>
											</div>
										</div>

									</div>

								</div>
								
							</div>
						</div>

					</div>
				</div>

			</div>

			<!-- Pagination -->

			<nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1">Previous</a>
					</li>
					<li class="page-item"><a class="page-link" href="#">1<div class="ripple-container">
								<div class="ripple ripple-on ripple-out" style="left: -10.3833px; top: -16.8333px; background-color: rgb(255, 255, 255); transform: scale(16.7857);"></div>
							</div></a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">...</a></li>
					<li class="page-item"><a class="page-link" href="#">12</a></li>
					<li class="page-item">
						<a class="page-link" href="#">Next</a>
					</li>
				</ul>
			</nav>

			<!-- ... end Pagination -->

		</div>




	</div>
</div>

<!-- ... end Your Account Personal Information -->


<script>
	var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?= $HOST_NAME  ?>app/users/scripts/notifications.js"></script>
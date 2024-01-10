<section class="mt-0">
	<style>
		#map {
			width: 100%;
			height: 400px;
		}
	</style>
	<div class="section">
		<div id="map" ></div>
	</div>


	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
	<div id="map"></div>

	<script>
		// config map
		let config = {
			minZoom: 7,
			maxZoom: 18,
		};
		// magnification with which the map will start
		const zoom = 16;
		// co-ordinates
		const lat = <?= $contact_info["latitude"] ?>;
		const lng = <?= $contact_info["longitude"] ?>;

		// calling map
		const map = L.map("map", config).setView([lat, lng], zoom);

		// Used to load and display tile layers on the map
		// Most tile servers require attribution, which you can set under `Layer`
		L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
			attribution: '&copy; <a href="https://www.hamgorooh.com">hamgorooh.com</a>',
		}).addTo(map);

		// one marker
		L.marker([<?= $contact_info["latitude"] ?>, <?= $contact_info["longitude"] ?>]).addTo(map).bindPopup("شبکه اجتماعی همگروه");
	</script>
</section>

<section class="medium-padding120">
	<div class="container">
		<div class="row">
			<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">


				<!-- Contact Item -->

				<div class="contact-item-wrap">
					<h4 class="contact-title">آدرس</h4>
					<div class="contact-item">
						<h6 class="sub-title">آدرس:</h6>
						<a href="#"><?= $contact_info["address"] ?></a>
					</div>

				</div>

				<!-- ... end Contact Item -->
			</div>

			<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">


				<!-- Contact Item -->

				<div class="contact-item-wrap">
					<h4 class="contact-title">تلفن</h4>

					<div class="contact-item">
						<h6 class="sub-title">تلفن:</h6>
						<a href="#"><?= $contact_info["telephones"] ?></a>
					</div>
				</div>

				<!-- ... end Contact Item -->

			</div>
			<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">


				<!-- Contact Item -->

				<div class="contact-item-wrap">
					<h4 class="contact-title">فکس</h4>
					<div class="contact-item">
						<h6 class="sub-title">فکس:</h6>
						<a href="#"><?= $contact_info["fax"] ?></a>
					</div>

				</div>

				<!-- ... end Contact Item -->

			</div>
			<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">


				<!-- Contact Item -->

				<div class="contact-item-wrap">
					<h4 class="contact-title">پست الکترونیکی</h4>
					<div class="contact-item">
						<h6 class="sub-title">پست الکترونیکی:</h6>
						<a href="mailto:"><?= $contact_info["email"] ?></a>
					</div>

				</div>

				<!-- ... end Contact Item -->

			</div>
		</div>
	</div>
</section>

<section class="medium-padding120 bg-body contact-form-animation scrollme">
	<div class="container">
		<div class="row">
			<div class="col col-xl-10 col-lg-10 col-md-12 col-sm-12  m-auto">


				<!-- Contacts Form -->

				<div class="contact-form-wrap">
					<div class="contact-form-thumb">
						<h2 class="title"> نظرات خود را برای ما ارسال نمایید</h2>
						<p>هر گونه سوال یا نظر خاصی در مورد سایت را باما به اشاراک بگذارید </p>
						<img src="<?= $HOST_NAME ?>resources/assets/img/crew.png" alt="crew" class="crew">
					</div>
					<form class="contact-form">
						<div class="row">
							<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="form-group label-floating">
									<label class="control-label">نام</label>
									<input id="fname" required class="form-control" placeholder="" type="text" value="">
								</div>
							</div>
							<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="form-group label-floating">
									<label class="control-label">نام خانوادگی</label>
									<input id="lname" required class="form-control" placeholder="" type="text" value="">
								</div>
							</div>
							<div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="form-group label-floating">
									<label class="control-label">آدرس ایمیل</label>
									<input id="email" required class="form-control" style="direction: ltr;text-align: center;" placeholder="" type="email" value="">
								</div>

								<div class="form-group label-floating is-select">
									<label class="control-label">موضوع</label>
									<select id="subject" required class="selectpicker form-control">
										<option value="">انتخاب نمایید</option>
										<option value="CS">انتقادات و پیشنهادات</option>
										<option value="WI">اطلاعات نا معتبر</option>
									    <option value="OT">سایر موارد</option>
									</select>
								</div>

								<div class="form-group">
									<textarea id="message" required class="form-control" placeholder="متن پیام"></textarea>
								</div>

								<button type="submit" class="btn btn-purple btn-lg full-width">ارسال پیام</button>
							</div>
						</div>
					</form>
				</div>

				<!-- ... end Contacts Form -->

			</div>
		</div>
	</div>

	<div class="half-height-bg bg-white"></div>
</section>



<!-- Section Call To Action Animation -->

<section class="align-right pt160 pb80 section-move-bg call-to-action-animation scrollme">
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
</section>

<!-- ... end Section Call To Action Animation -->

<script src="<?php echo $HOST_NAME; ?>app/home/scripts/contact.js"></script>
<section class="medium-padding100">
	<div class="container">
		<div class="row mb60">
			<div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 m-auto">
				<div class="crumina-module crumina-heading align-center">
					<!-- <div class="heading-sup-title">JOIN THE TEAM</div> -->
					<h2 class="heading-title">تبلیغ در سایت</h2>
					<p class="heading-text">برای تبلیغات در سایت با ما تماس بگیرید 
						<br/>
						<a href="mailto:info@hamgorooh.com">info@hamgorooh.com</a>
					</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 m-auto">

				
				<ul class="table-careers">
					<li class="head">
						<span>عنوان</span>
						<span>مکان</span>
						<span>تصویر مکان</span>
						<span>قیمت برای هر روز</span>
						<span></span>
					</li>
				 <?php foreach($ads_types as $ads_type) : ?>
					<li>
						<span class="town-place"><?= $ads_type["title"] ?></span>
						<span class="type bold"><?= $ads_type["position"] ?></span>
						<span class="position bold"><?= $ads_type["position_photo"] ?></span>
						<span class="date"><?= $ads_type["price_per_day"] ?></span>
						<span><a href="<?= $HOST_NAME ?>users/ads_request/" class="btn btn-primary btn-sm full-width" >در خواست تبلیغات</a></span>
						<!-- <span><a href="<?= $HOST_NAME ?>users/ads_request/" class="btn btn-primary btn-sm full-width" data-toggle="modal" data-target="#edit-my-poll-popup">در خواست تبلیغات</a></span> -->
					</li>
				<?php endforeach;  ?>
					
				</ul>

			</div>
		</div>
	</div>
</section>
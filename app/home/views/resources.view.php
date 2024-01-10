<style>
	/* css overides */

	@media only screen and (min-device-width: 640px) {
		.blog-post-v3 .post-thumb {
			border-radius: 5px 0 0 5px;
			width: 30%;
		}

		.blog-post-v3 .post-content {
			width: 70%;
			padding: 25px 30px;
		}
	}

	@media only screen and (max-device-width: 768px) {
		/* Styles */
	}

	.post-category {
		display: inline-block;
		border-radius: 3px;
		padding: 4px 9px;
		color: #fff;
		font-size: 12px !important;
		text-transform: uppercase;
		margin-bottom: 20px;
	}
</style>
<section class="negative-margin-top50">
	<div class="container">
		<div class="row">
			<div class="col col-xl-10 m-auto col-lg-10 col-md-12 col-sm-12 col-12">


				<!-- Search Form  -->

				<form id="resourceSearchForm" class="form-inline search-form">
					<div class="form-group label-floating">
						<label class="control-label">عبارت جستجو را وارد نمایید</label>
						<input id="searchQuery" name="searchQuery" class="form-control bg-white" placeholder="" type="text" value="<?php if (isset($search_exp)) {
																																		echo $search_exp;
																																	} ?>">
					</div>
					<input type="hidden" id="resource_base_url" name="resource_base_url" value="<?php if (isset($resource_base_url)) {
																									echo $resource_base_url;
																								} ?>" />
					<button id="resource-search" name="resource-search" class="btn btn-purple btn-lg">جستجو</button>
				</form>

				<!-- ... end Search Form  -->
			</div>
		</div>
	</div>
</section>

<section class="pt120">
	<div class="container">
		<div class="col-12">
			<h4 class="title">لیست منابع <?= $subject_name ?></h6>
		</div>
		<hr />
		<div class="row">
			<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<?php foreach ($resources as $resource) : ?>

					<div class="ui-block">

						<!-- Post -->
						<?php
						$resource_link =  $HOST_NAME . "resource/" . strlen($resource['id']) . $resource['id'] . "/" .  preg_replace('#[ -]+#', '-', $resource['title']);
						?>
						<article class="hentry blog-post blog-post-v3">

							<div class="post-thumb">
								<a href="<?= $resource_link ?>">
									<img src="<?= $HOST_NAME . $resource['photo_address']  ?>" alt="photo">
								</a>
								<a href="<?= $resource_link ?>" class="post-category bg-blue-light"><?= $resource['title']  ?></a>
							</div>

							<div class="post-content">

								<!-- <div class="author-date">
									by
									<a class="h6 post__author-name fn" href="#">Maddy Simmons</a>
									<div class="post__date">
										<time class="published" datetime="2017-03-24T18:18">
											- 7 hours ago
										</time>
									</div>
								</div> -->

								<a href="<?= $resource_link ?>" class="h5 post-title"><?= $resource['title']  ?></a>
								<ul class="rait-stars">
									<?php for ($i = 1; $i <= $resource['importance']; $i++) : ?>
										<li>
											<i class="fa fa-star star-icon c-primary" aria-hidden="true"></i>
										</li>
									<?php endfor ?>

									<?php for ($j = $i; $j <= 5; $j++) : ?>
										<li>
											<i class="far fa-star star-icon  c-primary" aria-hidden="true"></i>
										</li>
									<?php endfor ?>
								</ul>
								<p><?=  htmlspecialchars_decode($resource['brief_description'])  ?></p>

								<div class="inline-items" style="text-align: right;">

									<a class="btn btn-primary" href="<?= $resource_link ?>">ادامه و دانلود فایلهای ضمیمه
										<i class="fa fa-2x fa-download   right-menu-icon" style="padding:4px"></i>
									</a>
									<!-- <div class="friends-harmonic-wrap">
										<ul class="friends-harmonic">
											<li>
												<a href="#">
													<img src="img/icon-chat27.png" alt="icon">
												</a>
											</li>
											<li>
												<a href="#">
													<img src="img/icon-chat2.png" alt="icon">
												</a>
											</li>
										</ul>
										<div class="names-people-likes">
											26
										</div>
									</div>

									<div class="comments-shared">
										<a href="#" class="post-add-icon inline-items">
											<svg class="olymp-speech-balloon-icon">
												<use xlink:href="#olymp-speech-balloon-icon"></use>
											</svg>
											<span>0</span>
										</a>
									</div> -->

								</div>
							</div>

						</article>

						<!-- ... end Post -->

					</div>
					<hr />
				<?php endforeach ?>
			</div>
			<hr/>							
		</div>
	</div>
</section>

<!-- Pagination -->

<nav aria-label="Page navigation">
	<ul class="pagination justify-content-center">

		<?php
		$searchQuery = "";
		if (isset($search_exp) && $search_exp != "") {
			$searchQuery = "/$search_exp";
		}
		?>
		<?php $paging_info = get_paging_info($total_items, $page_size, $page, $base_url); ?>

		<?php

		$max = 16;
		if ($paging_info['curr_page'] < $max)
			$sp = 1;
		elseif ($paging_info['curr_page'] >= ($paging_info['pages'] - floor($max / 2)))
			$sp = $paging_info['pages'] - $max + 1;
		elseif ($paging_info['curr_page'] >= $max)
			$sp = $paging_info['curr_page']  - floor($max / 2);
		?>


		<?php if ($paging_info['curr_page'] >= $max) : ?>

			<li class="page-item"><a class="page-link" href="<?php echo $paging_info['curr_url'] .  '1' . $searchQuery; ?>" title='Page 1'>1</a></li>
			<li class="page-item"><a class="page-link" href="<?php echo $paging_info['curr_url'] .  '2' . $searchQuery; ?>" title='Page 2'>2</a></li>
			<li class="page-item"><a class="page-link">.. </a></li>

		<?php endif; ?>


		<?php for ($i = $sp; $i <= ($sp + $max - 1); $i++) : ?>

			<?php
			if ($i > $paging_info['pages'])
				continue;
			?>

			<?php if ($paging_info['curr_page'] == $i) : ?>

				<li class="page-item  active"><a class="page-link" href="#"><?php echo $i; ?></a></li>

			<?php else : ?>

				<li class="page-item"><a class="page-link" href="<?php echo $paging_info['curr_url'] .  $i . $searchQuery; ?>" title='Page <?php echo $i; ?>'><?php echo $i; ?></a></li>

			<?php endif; ?>

		<?php endfor; ?>



		<?php if ($paging_info['curr_page'] < ($paging_info['pages'] - floor($max / 2))) : ?>

			<li class="page-item"><a class="page-link">.. </a></li>
			<li class="page-item"><a class="page-link" href="<?php echo $paging_info['curr_url'] . ($paging_info['pages'] - 1) . $searchQuery; ?>" title='Page <?php echo ($paging_info['pages'] - 1); ?>'><?php echo ($paging_info['pages'] - 1); ?></a></li>
			<li class="page-item"><a class="page-link" href="<?php echo $paging_info['curr_url'] .  $paging_info['pages'] . $searchQuery; ?>" title='Page <?php echo $paging_info['pages']; ?>'><?php echo $paging_info['pages']; ?></a></li>

		<?php endif; ?>


		<?php if ($paging_info['curr_page'] < $paging_info['pages']) : ?>


		<?php endif; ?>
	</ul>
</nav>

<!-- ... end Pagination -->
<script src="<?php echo $HOST_NAME; ?>app/home/scripts/resources.js"></script>
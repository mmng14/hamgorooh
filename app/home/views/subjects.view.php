<section class="negative-margin-top50">
	<div class="container">
		<div class="row">
			<div class="col col-xl-10 m-auto col-lg-10 col-md-12 col-sm-12 col-12">


				<!-- Search Form  -->

				<form class="form-inline search-form" method="post">
					<div class="form-group label-floating">
						<label class="control-label">عبارت جستجو را وارد نمایید</label>
						<input class="form-control bg-white" placeholder="" type="text" value="">
					</div>

					<button id="group-search" name="group-search" class="btn btn-purple btn-lg">جستجو</button>
				</form>

				<!-- ... end Search Form  -->
			</div>
		</div>
	</div>
</section>

<section class="blog-post-wrap medium-padding80">

	<div class="container">
		<div class="col-12">
			<h6 class="title">لیست گروهها</h6>
		</div>
		<hr />
		<div class="row sorting-container" id="groups-grid" data-layout="masonry">

			<?php foreach ($subjects as $subject) : ?>
				<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 sorting-item community">
					<div class="ui-block">

						<?php
						$subject_link =  $HOST_NAME . "subject/" . strlen($subject['id']) . $subject['id'] . "/" . $subject['url_name'];
						$resource_link =  $HOST_NAME . "resources/" . strlen($subject['id']) . $subject['id'] . "/" . $subject['url_name'];
						?>
						<!-- Post -->

						<article class="hentry blog-post blog-post-v2">

							<div class="post-thumb">
								<a href="<?= $subject_link ?>">
									<img src="<?= $HOST_NAME . $subject['photo']  ?>" alt="<?= $subject['name'] ?>">
								</a>
							</div>

							<div class="post-content">
								<a href="<?= $subject_link ?>" class="post-category text-center full-width bg-blue-light" style="font-size:14px;font-weight:bold;"><?= $subject['name']  ?></a>
								<a href="<?= $subject_link ?>" class="h6 post-title"><?= $subject['description']  ?> </a>

								<div class="author-date">
									مدیر گروه
									<a class="h6 post__author-name fn" href="">نام مدیر</a>
									<div class="post__date">
										<time class="published" datetime="">
											زمان شروع : <b></b>
										</time>
									</div>
	
								</div>
								<?php if ($subject['has_resource'] != null && $subject['has_resource'] == 1) : ?>
									<div class="post-additional-info inline-items">

										<a href="<?= $resource_link ?>" class="post-add-icon inline-items">
											<i class="fa fa-2x fa-download"></i>
											<span>منابع</span>
										</a>

									</div>
								<?php endif ?>
							</div>

						</article>

						<!-- ... end Post -->

					</div>
				</div>
			<?php endforeach ?>


		</div>
		<a id="load-more-groups-button" href="#" class="btn btn-control btn-more" data-load-link="" data-container="">
			<svg class="olymp-three-dots-icon">
				<use xlink:href="#olymp-three-dots-icon"></use>
			</svg>
		</a>
	</div>
</section>
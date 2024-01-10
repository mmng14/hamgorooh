<div class="container">
	<div class="row">
		<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div id="homeFilterContainer" class="ui-block responsive-flex1200 ">
				<div class="ui-block-title">
					<ul class="filter-icons">
						<li>
							<input type="hidden" name="homeSubjectId" id="homeSubjectId" value="<?= $subject_id ?>" />
							<input type="hidden" name="homeSubjectBaseURL" id="homeSubjectBaseURL" value="<?= $subject_base_url ?>" />
							<input type="hidden" name="homeSubjectName" id="homeSubjectName" value="<?= $subject_name ?>" />

							<a href="<?= $subject_base_url ?>">
								<?= $subject_name ?>
							</a>

						</li>
						<!-- <li>
							<a href="#">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat15.png" alt="icon">
							</a>
						</li>
						<li>
							<a href="#">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat9.png" alt="icon">
							</a>
						</li>
						<li>
							<a href="#">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat4.png" alt="icon">
							</a>
						</li>
						<li>
							<a href="#">
								<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat6.png" alt="icon">
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
						</li> -->
					</ul>
					<div class="w-select">
						<div class="title">فیلتر کردن داد ها :</div>
						<fieldset class="form-group">
							<select id="homeCategoryFilter" class="selectpicker form-control">
								<option value="0">همه دسته بندی ها</option>
								<?php foreach ($categories as $category) : ?>
									<option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
								<?php endforeach; ?>
								<!-- <option value="NU">Likes</option> -->
							</select>
						</fieldset>
					</div>

					<div class="w-select">
						<fieldset class="form-group">
							<select id="homeSubCategoryFilter" class="selectpicker form-control">

							</select>
						</fieldset>
					</div>

					<button id="homeFilterButton" onclick="homeFilterData();" class="btn btn-primary btn-md-2">نمایش با فیلتر</button>

					<div class="w-search">
						<div class="form-group with-button">
							<input id="searchQuery" name="searchQuery" class="form-control" type="text" value="<?php if (isset($search_exp)) {
																													echo $search_exp;
																												} ?>" placeholder="عبارت جستجو را وارد نمایید">
							<button onclick="homeFilterData();">
								<svg class="olymp-magnifying-glass-icon">
									<use xlink:href="#olymp-magnifying-glass-icon"></use>
								</svg>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<section class="blog-post-wrap medium-padding80">

	<div class="container">

		<!-- <div class="row">
			<?php foreach ($posts as $post) : ?>
				<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
					<div class="ui-block">

						<?php
						$strPosts = "";
						$post_id_length =  strlen($post['id']);
						$category_id_length = strlen($post['category_id']);
						$category_id = $post['category_id'];
						$photo_address = htmlspecialchars(strip_tags($post['thumb_address']));
						if (strpos(strtolower($photo_address), 'http') === false) {
							$photo_address = $HOST_NAME . $photo_address;
						}

						if ($photo_address == "" || $photo_address == $HOST_NAME) {
							$photo_address = $HOST_NAME . "resources/shared/images/no_pic_image.jpg";
						}
						$photo_address = str_replace("http://www.hamgorooh.com", "https://www.hamgorooh.com", $photo_address);
						$link_address = "";
						if ($subject_id == 16) {
							$link_address = $HOST_NAME . "news/{$current_year}{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}{$post_id_length}{$post["id"]}/{$post["post_name"]}";
						} else {
							$link_address = $HOST_NAME . "post/{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}{$post_id_length}{$post["id"]}/{$post["post_name"]}";
						}
						?>
						

						<article class="hentry blog-post">

							<div class="post-thumb">
								<img src="<?= $photo_address ?>" alt="<?= $post["title"] ?>">
							</div>

							<div class="post-content">
								<a href="<?= $post["category_id"] ?>" class="post-category bg-blue-light"><?= "عنوان دسته بندی" ?></a>
								<a href="<?= $link_address ?>" class="h4 post-title"><?= $post["title"] ?> </a>
								<p><?= $post["brief_description"] ?></p>

								<div class="author-date">
									نویسنده
									<a class="h6 post__author-name fn" href="<?= $post["user_id"] ?>"><?= $post["user_full_name"] ?></a>
									<div class="post__date">
										<time class="published" datetime="<?= $post["reg_date"] ?>">
											- <?= $post["reg_date"] ?>
										</time>
									</div>
								</div>

								<div class="post-additional-info inline-items">
									<div class="friends-harmonic-wrap">
										<ul class="friends-harmonic">
											<li>
												<a href="#">
													<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat27.png" alt="icon">
												</a>
											</li>
											<li>
												<a href="#">
													<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat2.png" alt="icon">
												</a>
											</li>
										</ul>
										<div class="names-people-likes">
											<?= $post["like_count"] ?>
										</div>
									</div>

									<div class="comments-shared">
										<a href="#" class="post-add-icon inline-items">
											<svg class="olymp-speech-balloon-icon">
												<use xlink:href="#olymp-speech-balloon-icon"></use>
											</svg>
											<span><?= $post["comment_count"] ?></span>
										</a>
									</div>

								</div>
							</div>

						</article>

					

					</div>
				</div>
			<?php endforeach ?>
		</div> -->

		<div class="row sorting-container" id="posts-grid-1" data-layout="masonry">

			<?php foreach ($posts as $post) : ?>
				<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 sorting-item community">
					<div class="ui-block">

						<?php
						$strPosts = "";
						$post_id_length =  strlen($post['id']);
						$category_id_length = strlen($post['category_id']);
						$category_id = $post['category_id'];
						$photo_address = htmlspecialchars(strip_tags($post['thumb_address']));
						if (strpos(strtolower($photo_address), 'http') === false) {
							$photo_address = $HOST_NAME . $photo_address;
						}

						if ($photo_address == "" || $photo_address == $HOST_NAME) {
							$photo_address = $HOST_NAME . "resources/shared/images/no_pic_image.jpg";
						}
						$photo_address = str_replace("http://www.hamgorooh.com", "https://www.hamgorooh.com", $photo_address);
						$link_address = "";
						if ($subject_id == 16) {
							$link_address = $HOST_NAME . "news/{$current_year}{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}{$post_id_length}{$post["id"]}/{$post["post_name"]}";
						} else {
							$link_address = $HOST_NAME . "post/{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}{$post_id_length}{$post["id"]}/{$post["post_name"]}";
						}
						?>
						<!-- Post -->

						<article class="hentry blog-post blog-post-v2">

							<div class="post-thumb">
								<a href="<?= $link_address ?>">
									<img src="<?= $photo_address ?>" alt="<?= $post["title"] ?>">
								</a>
							</div>

							<div class="post-content">
								<a href="<?= $post["category_id"] ?>" class="post-category bg-blue-light"><?= "عنوان دسته بندی" ?></a>
								<a href="<?= $link_address ?>" class="h6 post-title"><?= $post["title"] ?> </a>
								<p><?= $post["brief_description"] ?></p>

								<div class="author-date">
									نویسنده
									<a class="h6 post__author-name fn" href="<?= $post["user_id"] ?>"><?= $post["user_full_name"] ?></a>
									<div class="post__date">
										<time class="published" datetime="<?= $post["reg_date"] ?>">
											زمان انتشار : <b><?= $post["reg_date"] ?></b>
										</time>
									</div>
								</div>

							</div>

						</article>

						<!-- ... end Post -->

					</div>
				</div>
			<?php endforeach ?>
		</div>


	</div>


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

</section>
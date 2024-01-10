<section class="negative-margin-top50">
	<div class="container">
		<div class="row">
			<div class="col col-xl-10 m-auto col-lg-10 col-md-12 col-sm-12 col-12">


				<!-- Search Form  -->

				<form id="resourceSearchForm" class="form-inline search-form"  >
					<div class="form-group label-floating">
						<label class="control-label">عبارت جستجو را وارد نمایید</label>
						<input id="searchQuery" name="searchQuery" class="form-control bg-white" placeholder="" type="text" value="<?php if(isset($search_exp)){ echo $search_exp;} ?>">
					</div>
					<input type="hidden" id="resource_base_url" name="resource_base_url" value="<?php if(isset($resource_base_url)){echo $resource_base_url;} ?>" />
					<button  id="resource-search" name="resource-search" class="btn btn-purple btn-lg">جستجو</button>
				</form>

				<!-- ... end Search Form  -->
			</div>
		</div>
	</div>
</section>

<section class="blog-post-wrap medium-padding80">

	<div class="container">
		<div class="col-12">
			<h6 class="title">لیست منابع <?= $subject_name ?></h6>
		</div>
		<hr />
		<div class="row sorting-container" id="groups-grid" data-layout="masonry" >

			<?php foreach ($resources as $resource) : ?>
				<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 sorting-item community">
					<div class="ui-block">

						<?php
						$resource_link =  $HOST_NAME . "resource/" . strlen($resource['id']) . $resource['id'] . "/" .  preg_replace('#[ -]+#', '-', $resource['title']);
						?>
						<!-- Post -->

						<article class="hentry blog-post blog-post-v2">

							<div class="post-thumb">
								<a href="<?= $resource_link ?>">
									<img src="<?= $HOST_NAME . $resource['photo_address']  ?>" alt="<?= $resource['title'] ?>">
								</a>
							</div>

							<div class="post-content">
								<a href="<?= $resource_link ?>" class="post-category text-center full-width bg-purple" style="font-size:14px;font-weight:bold;"><?= $resource['title']  ?></a>
								<!-- <a href="<?= $resource_link ?>" class="h6 post-title"><?= htmlspecialchars_decode($resource['description'])  ?> </a> -->

								<!-- <div class="author-date">
									مدیر گروه
									<a class="h6 post__author-name fn" href="">نام مدیر</a>
									<div class="post__date">
										<time class="published" datetime="">
											زمان شروع : <b></b>
										</time>
									</div>
								</div> -->
								<!-- <div class="post-additional-info inline-items">
										<div class="comments-shared">
											<a href="#" class="post-add-icon inline-items">
												<svg class="olymp-speech-balloon-icon">
													<use xlink:href="#olymp-speech-balloon-icon"></use>
												</svg>
												<span>39</span>
											</a>
										</div>
									</div> -->
							</div>

						</article>

						<!-- ... end Post -->

					</div>
				</div>
			<?php endforeach ?>



		</div>
		<!-- <a id="load-more-groups-button" href="#" class="btn btn-control btn-more" data-load-link="" data-container="">
			<svg class="olymp-three-dots-icon">
				<use xlink:href="#olymp-three-dots-icon"></use>
			</svg>
		</a> -->
	</div>
</section>

<!-- Pagination -->

<nav aria-label="Page navigation">
	<ul class="pagination justify-content-center">

		<?php
		  $searchQuery = "";
		  if(isset($search_exp) && $search_exp !=""){
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
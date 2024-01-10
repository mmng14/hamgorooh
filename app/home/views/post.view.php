<div class="container">
	<div class="row mt50">

		<div class="col col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
			<div class="ui-block mb60">

				<!-- Single Post -->
				<form id="visit_form">
					<input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
					<input type="hidden" id="afid" value="" />
					<input type="hidden" id="sid" value="<?php echo $post['subject_id'];  ?>" />
					<input type="hidden" id="cid" value="<?php echo $post['category_id'];  ?>" />
					<input type="hidden" id="scid" value="<?php echo $post['sub_category_id'];  ?>" />
					<input type="hidden" id="pid" value="<?php echo $post['id'];  ?>" />
					<input type="hidden" id="puid" value="<?php echo $post['user_id'];  ?>" />
				</form>

				<article class="hentry blog-post single-post single-post-v3">

					<ul class="filter-icons">

						<?php if (isset($subject_name)) : ?>
							<li><a class="post-add-icon inline-items" href="<?php echo $HOST_NAME . "subject/" . "{$subject_id_length}{$subject_id}/" . $subject_url_name;   ?>"><?php if (isset($subject_name)) echo $subject_name;   ?></a></li>
						<?php endif; ?> /
						<?php if (isset($category_name)) : ?>
							<li><a class="post-add-icon inline-items" href="<?php echo $HOST_NAME . "category/" .  "{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}/" . $category_url_name;   ?>"><?php if (isset($category_name)) echo $category_name;   ?></a></li>
						<?php endif; ?> /
						<?php if (isset($subcategory_name)) : ?>
							<li><a class="post-add-icon inline-items" href="<?php echo $HOST_NAME . "subcategory/" . "{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}{$subcategory_length}{$subcategory_id}/" . $subcategory_url_name;   ?>"><?php if (isset($subcategory_name)) echo $subcategory_name;   ?></a></li>
						<?php endif; ?>
						<li class="active"><a href="<?php echo $share_link   ?>" rel="<?php echo $post['title'];   ?>"><?php echo $post['title'];   ?></a></li>
					</ul>

					<h1 class="post-title"><?php echo $post['title'];   ?></h1>

					<div class="author-date">
						<div class="author-thumb">
							<img alt="author" src="<?= $HOST_NAME . "resources/assets/" ?>img/friend-harmonic7.jpg" class="avatar">
						</div>
						توسط
						<a class="h6 post__author-name fn" href="#"><?php echo $post['user_full_name'];   ?></a>
						<div class="post__date">
							<time class="published" datetime="2017-03-24T18:18">
								- <?php echo $post['reg_date'];  ?>
							</time>
						</div>
						<span style="margin-right: 20px;"> تعداد بازدید : <b><?php echo $post['visit_count'];  ?></b></span>
					</div>

					<div class="post-thumb">
						<img src="<?php echo $photo_address   ?>" alt="<?php echo $post['title'];   ?>">
					</div>

					<div class="post-content-wrap">

						<div class="control-block-button post-control-button">

							<a href="#" class="post-add-icon inline-items">
								<svg class="olymp-speech--balloon-icon">
									<use xlink:href="#olymp-speech-balloon-icon"></use>
								</svg>
								<span><?= $post['comment_count']; ?></span>
							</a>

							<a href="<?php echo "http://www.facebook.com/share.php?v=4&src=bm&u={$share_link}";   ?>" class="btn btn-control has-i bg-facebook">
								<i class="fab fa-facebook-f" aria-hidden="true"></i>
							</a>
							<a href="<?php echo "http://twitter.com/home?status={$share_link}"; ?>" class="btn btn-control has-i bg-twitter">
								<i class="fab fa-twitter" aria-hidden="true"></i>
							</a>
							<a href="<?php echo "http://plus.google.com/share?url={$share_link}"; ?>" class="btn btn-control has-i bg-warning">
								<i class="fab fa-google-plus" aria-hidden="true"></i>
							</a>
							<a href="<?php echo "https://www.linkedin.com/shareArticle?mini=true&url={$share_link}&title={$page_title}&summary={$page_description}" ?>" class="btn btn-control has-i bg-linkedin">
								<i class="fab fa-linkedin" aria-hidden="true"></i>
							</a>
							<a href="<?php echo "https://t.me/share/url?url={$share_link}"; ?>" class="btn btn-control has-i bg-telegram">
								<i class="fab fa-telegram" aria-hidden="true"></i>
							</a>
						</div>

						<div class="post-content">
							<h6>
								<?php echo $post['brief_description'];   ?>
							</h6>

							<?php echo htmlspecialchars_decode(str_replace("http://www.hamgorooh.com", "https://www.hamgorooh.com", $post_content['content']));   ?>

						</div>
					</div>


					<div id="choose_post_rate" class="choose-reaction reaction-colored">
						<div class="title"><span>رای خود درباره این پست انتخاب کنید </span></div>

						<ul>
							<!-- <li>
								<a style="cursor: pointer;" onclick="userRate(5);">
									<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat4.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="عالی">
								</a>
							</li>
							<li>
								<a style="cursor: pointer;" onclick="userRate(4);">
									<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat13.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="خیلی خوب">
								</a>
							</li>
							<li>
								<a style="cursor: pointer;" onclick="userRate(3);">
									<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat27.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="خوب">
								</a>
							</li>
							<li>
								<a style="cursor: pointer;" onclick="userRate(2);">
									<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat6.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="بد">
								</a>
							</li>
							<li>
								<a style="cursor: pointer;" onclick="userRate(1);">
									<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat9.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="افتضاح">
								</a>
							</li> -->


							<li>
								<a style="cursor: pointer;" onclick="userRate(5);">
									<img width="48" src="<?= $HOST_NAME . "resources/assets/" ?>img/like.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="مثبت">
								</a>
							</li>
							<li>
								<a style="cursor: pointer;" onclick="userRate(1);">
									<img width="48" src="<?= $HOST_NAME . "resources/assets/" ?>img/dislike.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="منفی">
								</a>
							</li>

						</ul>

					</div>

				</article>

				<!-- ... end Single Post -->

			</div>

			<div class="crumina-module crumina-heading with-title-decoration">
				<!-- <h5 class="heading-title">نظرات (<?= $post['comment_count']; ?>)</h5> -->
				<h5 class="heading-title">نظرات </h5>
			</div>


			<!-- Comments -->

			<ul class="comments-list style-3">
				
			<?php if(isset($post_comments)): ?>
			<?php foreach ($post_comments as $post_comment) : ?>			
				<li class="comment-item">
					<div class="post__author-thumb">
						<img src="<?= $HOST_NAME . "resources/assets/" ?>img/avatar1.jpg" alt="author">
					</div>

					<div class="comments-content">
						<div class="post__author author vcard">

							<div class="author-date">
								<a class="h6 post__author-name fn" href="#"><?= $post_comment["author_name"] ?></a>
								<div class="post__date">
									<time class="published" datetime="<?= $post_comment["reg_date"] ?> ">
									<?= $post_comment["reg_date"] ?>
									</time>
									<br/>
									<time class="published" datetime="<?= $post_comment["reg_time"] ?> ">
									<?= $post_comment["reg_time"] ?>
									</time>
								</div>
							</div>

						</div>

						<p>
							<?= $post_comment["content"] ?>
						</p>

						<!-- <a href="#" class="reply">Reply</a>
						<a href="#" class="report">Report</a> -->
					</div>
				</li>
			<?php endforeach ?>
			<?php endif ?>
			</ul>

			<!-- ... end Comments -->

			<!-- <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 align-center">
				<a href="#" class="btn btn-purple btn-md mb60 mt60">Load More Comments...</a>
			</div> -->

			<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<!-- Comment Form -->
				<?php if (isset($_SESSION['user_id'])) : ?>
					<form class="comment-form">
						<div class="crumina-module crumina-heading with-title-decoration">
							<h5 class="heading-title">نظر خود را وارد نمایید</h5>
						</div>
						<div class="row">
							<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="form-group label-floating">
									<label class="control-label">نام</label>
									<input name="fullName" id="fullName" class="form-control" placeholder=""  type="text">
								</div>
							</div>
							<div class="col col-12 col-xl-6 col-lg-6 col-md-6 col-sm-12">
								<div class="form-group label-floating">
									<label class="control-label">آدرس ایمیل</label>
									<input name="userEmail" id="userEmail" class="form-control" placeholder=""  type="email">
								</div>
							</div>
							<div class="col col-12 col-xl-12 col-lg-12 col-md-12 col-sm-12" style="margin-top:20px;">
								<div class="form-group">
									<textarea name="comment" id="comment" class="form-control" placeholder="نظر شما"></textarea>
								</div>
								<button type="submit" class="btn btn-primary btn-lg full-width">نظر خود را ارسال نمایید</button>
							</div>
						</div>
					</form>
				<?php endif ?>
				<!-- ... end Comment Form -->



			</div>

		</div>

		<div class="col col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
			<aside class="blog-post-wrap">

				<div class="crumina-module crumina-heading with-title-decoration">
					<h5 class="heading-title">تبلیغات</h5>
				</div>

				<div class="ui-block">
					<!-- Ads -->
					<?php if (isset($active_ads)) : ?>
						<?php foreach ($active_ads as $ad) : ?>
							<article class="hentry blog-post blog-post-v3 featured-post-item">

								<!-- <div class="post-thumb">
									<img src="<?= $HOST_NAME . "resources/assets/" ?>img/post13.jpg" alt="photo">
									<a href="#" class="post-category bg-purple">INSPIRATION</a>
								</div> -->
								<div class="post-thumb">
									<a target="_blank" href="<?= $ad["link_address"] ?>"><img class="img-responsive" src="<?= $HOST_NAME . $ad["photo"] ?>" alt="<?= $ad["title"] ?>"></a>
								</div>
							</article>
							<br />
						<?php endforeach ?>
					<?php endif ?>

					<!-- ... end Ads -->

				</div>

				<hr />

				<div class="crumina-module crumina-heading with-title-decoration">
					<h5 class="heading-title">رپرتاژ</h5>
				</div>

				<div class="ui-block">

					<!-- Post -->

					<article class="hentry blog-post blog-post-v3 featured-post-item">

						<div class="post-thumb">
							<img src="<?= $HOST_NAME . "resources/assets/" ?>img/post13.jpg" alt="photo">
							<a href="#" class="post-category bg-purple">Reportage</a>
						</div>

						<!-- <div class="post-content">

							<div class="author-date">
								by
								<a class="h6 post__author-name fn" href="#">JACK SCORPIO</a>
								<div class="post__date">
									<time class="published" datetime="2017-03-24T18:18">
										- 5 MONTHS ago
									</time>
								</div>
							</div>

							<a href="#" class="h6 post-title">We went lookhunting in all the California bay area</a>

							<div class="post-additional-info inline-items">

								<div class="friends-harmonic-wrap">
									<ul class="friends-harmonic">
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
										<li>
											<a href="#">
												<img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat2.png" alt="icon">
											</a>
										</li>
									</ul>
									<div class="names-people-likes">
										206
									</div>
								</div>

								<div class="comments-shared">
									<a href="#" class="post-add-icon inline-items">
										<svg class="olymp-speech-balloon-icon">
											<use xlink:href="#olymp-speech-balloon-icon"></use>
										</svg>
										<span>97</span>
									</a>
								</div>

							</div>
						</div> -->

					</article>

					<!-- ... end Post -->

				</div>

			</aside>
		</div>

	</div>

</div>

<section class="medium-padding100">
	<div class="container">
		<div class="related-posts">
			<div class="row">
				<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="crumina-module crumina-heading with-title-decoration">
						<h5 class="heading-title">پستهای مشابه</h5>
					</div>
				</div>
				<?php foreach ($similar_posts as $similar_post) : ?>
					<?php
					$similar_post_id =   $similar_post['id'];
					$similar_post_id_length =  strlen($similar_post['id']);
					$similar_subject_id =   $similar_post['subject_id'];
					$similar_subject_id_length =  strlen($similar_post['subject_id']);
					$similar_category_id =   $similar_post['category_id'];
					$similar_category_id_length =  strlen($similar_post['category_id']);
					$similar_post_name = $similar_post['post_name'];
					$similar_post_title = $similar_post['title'];
					$similar_post_date = $similar_post['reg_date'];
					$similar_post_url = $HOST_NAME . "post/{$similar_subject_id_length}{$similar_subject_id}{$similar_category_id_length}{$similar_category_id}{$similar_post_id_length}{$similar_post_id}/{$similar_post_name}";
					$similar_post_brief_description = trim($similar_post['brief_description']);
					$similar_photo_address = htmlspecialchars(strip_tags($similar_post['thumb_address']));
					if (strpos(strtolower($similar_photo_address), 'http') === false) {
						$similar_photo_address = $HOST_NAME . $similar_photo_address;
					}

					if ($similar_photo_address == "" || $similar_photo_address == $HOST_NAME) {
						$similar_photo_address = $HOST_NAME . "resources/shared/images/no_pic_image.jpg";
					}
					$similar_photo_address = str_replace("http://www.hamgorooh.com", "https://www.hamgorooh.com", $similar_photo_address);

					?>
					<div class="col col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
						<div class="ui-block">

							<!-- Post -->

							<article class="hentry blog-post">

								<div class="post-thumb" style="height:300px;overflow:hidden;">
									<a href="<?=$similar_post_url  ?>"><img src="<?php echo  $similar_photo_address  ?>" alt="<?php echo  $similar_post_title;  ?>"></a>
								</div>

								<div class="post-content">
									<!-- <a href="<?=$similar_post_url  ?>" class="post-category bg-blue-light"><?php echo  $similar_post_title;  ?></a> -->
									<a href="<?=$similar_post_url  ?>" class="h6 post-title"><?php echo  $similar_post_title;  ?> </a>
									<p><?= $similar_post_brief_description ?></p>

									<div class="author-date">
										<!-- توسط 
										<a class="h6 post__author-name fn" href="#">Maddy Simmons</a> -->
										<div class="post__date">
											<time class="published" datetime="2017-03-24T18:18">
												- <?php echo  $similar_post_date;  ?>
											</time>
										</div>
									</div>

									<div class="post-additional-info inline-items">
										<div class="friends-harmonic-wrap">
											<ul class="friends-harmonic">
												<li>
													<a href="<?php echo  $similar_post_url;  ?>">
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
										</div>

									</div>
								</div>

							</article>

							<!-- ... end Post -->
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
</section>
<script>
	var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/shared/scripts/visit.js"></script>
<script src="<?php echo $HOST_NAME; ?>app/home/scripts/post.js"></script>
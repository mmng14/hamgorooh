<?php if (isset($resource)) : ?>
	<div class="container negative-margin-top150 mb60">
		<!-- Single Post -->
		<form id="visit_form">
			<input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
			<input type="hidden" id="afid" value="" />
			<input type="hidden" id="sid" value="<?php echo $subject_resource['subject_id'];  ?>" />
			<input type="hidden" id="cid" value="0" />
			<input type="hidden" id="scid" value="0" />
			<input type="hidden" id="pid" value="<?php echo $subject_resource['resource_id'];  ?>" />
			<input type="hidden" id="puid" value="<?php echo $subject_resource['user_id'];  ?>" />
		</form>
		<div class="row">
			<div class="col col-xl-8 m-auto col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="ui-block">

					<!-- Single Post -->

					<article class="hentry blog-post single-post single-post-v1">

						<div class="control-block-button post-control-button">
							<a href="#" class="btn btn-control has-i bg-facebook">
								<i class="fab fa-facebook-f" aria-hidden="true"></i>
							</a>

							<a href="#" class="btn btn-control has-i bg-twitter">
								<i class="fab fa-twitter" aria-hidden="true"></i>
							</a>
						</div>


						<h1 class="post-title"><?= $resource["title"] ?></h1>


						<div class="post-thumb">
							<img src="<?= $HOST_NAME ?><?= $resource["photo_address"] ?>" alt="author">
						</div>

						<div class="post-content-wrap">
							<ul class="filter-icons">
								<li>
									<a href="#" class="post-add-icon inline-items">
										<svg class="olymp-speech-balloon-icon">
											<use xlink:href="#olymp-speech-balloon-icon"></use>
										</svg>
										<span>0</span>
									</a>
								</li>
								<li>
									<a href="#" class="post-add-icon inline-items">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat1.png" alt="icon">
										<span>58</span>
									</a>
								</li>
								<li>
									<a href="#" class="post-add-icon inline-items">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat26.png" alt="icon">
										<span>21</span>
									</a>
								</li>
								<li>
									<a href="#" class="post-add-icon inline-items">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat15.png" alt="icon">
										<span>3</span>
									</a>
								</li>
							</ul>

							<div class="post-content">
								<h5>
									<?= $resource["brief_description"] ?>
								</h5>

								<p>
									<?= $resource["description"] ?>
								</p>


								<blockquote>

									<h6><span>سال انتشار</span>
										<?= $resource["publish_year"] ?></h6>
									<?php if (isset($author)) : ?>
										<h6><span>نویسنده</span>
											<b><?= $author["full_name"] ?> - </b>
											<i><?= $author["fame_fields"] ?></i>
										</h6>
									<?php endif ?>
								</blockquote>

								<p>

								</p>

							</div>
						</div>


						<!-- <div class="choose-reaction">
							<div class="title"> <span> نظر خود را وارد نمایید </span></div>

							<ul>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat13.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="LOL">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat15.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="Amazed">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat9.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="ANGER">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat4.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="joy">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat6.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="BAD">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat26.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="LIKE">
									</a>
								</li>
								<li>
									<a href="#">
										<img src="<?= $HOST_NAME ?>/resources/assets/img/icon-chat27.png" alt="icon" data-toggle="tooltip" data-placement="top" data-original-title="COOL">
									</a>
								</li>
							</ul>

						</div> -->
					</article>

					<!-- ... end Single Post -->

				</div>



				<div class="crumina-module crumina-heading with-title-decoration">
					<h5 class="heading-title">ضمایم (<?= count($attachments) ?>)</h5>
				</div>


				<!-- Comments -->

				<ul class="comments-list style-3">
					<?php if (isset($attachments)) : ?>

						<?php foreach ($attachments as $attachment) : ?>
							<?php if ($attachment["parent_id"] == null || $attachment["parent_id"] == 0) : ?>
								<li class="comment-item has-children">
									<a href="<?= $attachment["link_address"] ?>" target="_blank">
										<div class="post__author-thumb">
											<img src="<?= $HOST_NAME ?><?= $attachment["photo_address"] ?>" alt="author">
										</div>
									</a>
									<div class="comments-content">
										<div class="post__author author vcard">

											<div class="author-date">
												<a class="h6 post__author-name fn" target="_blank" href="<?= $attachment["link_address"] ?>"><?= $attachment["title"] ?></a>
											</div>

										</div>
										<p><?= $attachment["description"] ?></p>
										<a href="<?= $attachment["link_address"] ?>" target="_blank" class=" btn btn-purple">
											<i class="fa fa-download"></i>
											دانلود
										</a>
									</div>

									<ul class="children">
										<?php foreach ($childAttachments as $childAttachment) : ?>
											<?php if ($childAttachment["parent_id"] == $attachment["id"]) : ?>
												<li class="comment-item">
													<a href="<?= $attachment["link_address"] ?>" target="_blank">
														<div class="post__author-thumb">
															<img src="<?= $HOST_NAME ?><?= $childAttachment["photo_address"] ?>" alt="author">
														</div>
													</a>
													<div class="comments-content">
														<div class="post__author author vcard">

															<div class="author-date">
																<a class="h6 post__author-name fn" href="<?= $attachment["link_address"] ?>" target="_blank"><?= $childAttachment["title"] ?></a>

															</div>

														</div>
														<p><?= $childAttachment["description"] ?></p>
														<a href="<?= $childAttachment["link_address"] ?>" target="_blank" class=" btn btn-blue">
															<i class="fa fa-download"></i>
															دانلود
														</a>
													</div>
												</li>
											<?php endif ?>
										<?php endforeach ?>
									</ul>

								</li>
							<?php endif ?>
						<?php endforeach ?>
					<?php endif ?>

				</ul>

				<!-- ... end Comments -->
			</div>

		</div>
	</div>
<?php endif ?>
<script>
	var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/shared/scripts/visit.js"></script>
<script src="<?php echo $HOST_NAME; ?>app/home/scripts/resource.js"></script>
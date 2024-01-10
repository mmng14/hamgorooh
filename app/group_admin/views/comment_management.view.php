<div class="main-header">
	<div class="content-bg-wrap bg-birthday"></div>
	<div class="container">
		<div class="row">
			<div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
				<div class="main-header-content">
					<h3>مدیریت نظرات</h3>
				</div>
			</div>
		</div>
	</div>
	<!-- <img class="img-bottom" src="img/birthdays-bottom.png" alt="friends"> -->
</div>
<div class="container">
    <div class="row">

		<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

			<div class="ui-block">

				
				<!-- Forums Table -->
				
				<table class="forums-table">
				
					<thead>
				
					<tr>
				
						<th class="forum">
							موضوع
						</th>
				
						<th class="topics">
							تعداد نظرات
						</th>
				
						<th class="freshness">
							مدیریت نظرات
						</th>
				
					</tr>
				
					</thead>
				
					<tbody>
                    <?php foreach ($subject_list as $subject) :  ?>
					<tr>
						<td class="forum">
							<div class="forum-item">
								<img style="height: 50px;border-radius: 30px;" src="<?php echo $HOST_NAME . $subject["photo"]; ?>" alt="<?php echo $subject["name"];  ?>">
								<div class="content">
									<a href="#" class="h6 title"><?php echo $subject["name"];  ?></a>
									<p class="text"><?php echo $subject["description"];  ?></p>
								</div>
							</div>
						</td>
						<td class="topics">
							<a id="new_comment_count_<?= $subject["id"]; ?>"   href="#" class="h6 count">0</a>
						</td>

						<td class="freshness">
                        <a href="<?php echo $HOST_NAME; ?>group_admin/comments/<?= $subject["id"]; ?>" class="btn btn-sm bg-blue">مدیریت<div class="ripple-container"></div></a>
						</td>
					</tr>
                    <?php endforeach; ?>
					
					</tbody>
				</table>
				
				<!-- ... end Forums Table -->

			</div>

			
			<!-- Pagination -->
			
			<!-- <nav aria-label="Page navigation">
				<ul class="pagination justify-content-center">
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1">Previous</a>
					</li>
					<li class="page-item"><a class="page-link" href="#">1<div class="ripple-container"><div class="ripple ripple-on ripple-out" style="left: -10.3833px; top: -16.8333px; background-color: rgb(255, 255, 255); transform: scale(16.7857);"></div></div></a></li>
					<li class="page-item"><a class="page-link" href="#">2</a></li>
					<li class="page-item"><a class="page-link" href="#">3</a></li>
					<li class="page-item"><a class="page-link" href="#">...</a></li>
					<li class="page-item"><a class="page-link" href="#">12</a></li>
					<li class="page-item">
						<a class="page-link" href="#">Next</a>
					</li>
				</ul>
			</nav> -->
			
			<!-- ... end Pagination -->

		</div>

    </div>
</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/group_admin/scripts/comment_management.js"></script>
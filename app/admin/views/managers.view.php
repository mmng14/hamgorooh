<style>
    .user-photo {
        width: 130px;
    }
</style>

<div class="main-header">
	<div class="content-bg-wrap bg-group"></div>
	<div class="container">
		<div class="row">
			<div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
				<div class="main-header-content">
					<h3>لیست مدیران سایت</h1>
				</div>
			</div>
		</div>
	</div>
<!-- 
	<img class="img-bottom" src="img/group-bottom.png" alt="friends"> -->
</div>

<div class="container">
    <div class="row">


        <?php foreach ($managers as $manager) : ?>
            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="ui-block" data-mh="friend-groups-item" style="height: 391px;">

                    <?php
                    $selected_user =  $database->users()
                        ->select("id,name,family,photo,phone")
                        ->where("id = ?", $manager["user_id"])
                        ->fetch();

                    $user_full_name = $selected_user['name'] .  ' ' . $selected_user['family'];
                    $user_photo  = $selected_user['photo'];
                    $user_phone  = $selected_user['phone'];

                    ?>
                    <!-- Friend Item -->
                    <div class="friend-item friend-groups">

                        <div class="friend-item-content">

                            <div class="more">
                                <svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg>
                                <ul class="more-dropdown">
                                    <li>
                                        <a href="#">نمایش جزییات</a>
                                    </li>
                                    <li>
                                        <a href="#">مسدود کردن </a>
                                    </li>
                                    <li>
                                        <a href="#">خاموش کردن نوتیفیکیشن</a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="friend-avatar">
                                <div class="author-thumb">

                                    <?php if (isset($user_photo) && $user_photo != "") : ?>
                                        <img class="user-photo" src="<?= $HOST_NAME; ?><?= $user_photo ?>" alt="<?= $user_full_name  ?>">
                                    <?php else : ?>
                                        <img class="user-photo" src="<?php echo $HOST_NAME;  ?>resources/shared/admin/img/user1-128x128.jpg" alt="<?= $user_full_name  ?>">
                                    <?php endif ?>

                                </div>
                                <div class="author-content">
                                    <a href="#" class="h5 author-name"><?= $user_full_name  ?></a>
                                    <div class="country"><?= $manager['subject_name']  ?></div>
                                </div>
                            </div>

                            <ul class="friends-harmonic">
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic1.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic2.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic3.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic4.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic5.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic6.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic7.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic8.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="<?php echo $HOST_NAME;  ?>resources/assets/img/friend-harmonic9.jpg" alt="friend">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="all-users bg-blue">+15</a>
                                </li>
                            </ul>

                            <div class="control-block-button">
                                <a href="#" class="  btn btn-control bg-blue" data-toggle="modal" data-target="#create-friend-group-add-friends">
                                    <svg class="olymp-happy-faces-icon">
                                        <use xlink:href="#olymp-happy-faces-icon"></use>
                                    </svg>
                                </a>

                                <a href="#" class="btn btn-control btn-grey-lighter">
                                    <svg class="olymp-settings-icon">
                                        <use xlink:href="#olymp-settings-icon"></use>
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- ... end Friend Item -->

                </div>
            </div>
        <?php endforeach;  ?>




    </div>
    
</div>

<div class="modal fade" id="create-friend-group-1" tabindex="-1" role="dialog" aria-labelledby="create-friend-group-1" aria-hidden="true">
	<div class="modal-dialog window-popup create-friend-group create-friend-group-1" role="document">
		<div class="modal-content">
			<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
				<svg class="olymp-close-icon"><use xlink:href="#olymp-close-icon"></use></svg>
			</a>
			<div class="modal-header">
				<h6 class="title">Create Friend Group</h6>
			</div>

			<div class="modal-body">
				<form class="form-group label-floating">
					<label class="control-label">Group Name</label>
					<input class="form-control" placeholder="" value="Highschool Friends" type="text">
				<span class="material-input"></span></form>

				<form class="form-group with-button">
					<input class="form-control" placeholder="" value="Group Avatar (120x120px min)" type="text">

					<button class="bg-grey">
						<svg class="olymp-computer-icon"><use xlink:href="#olymp-computer-icon"></use></svg>
					</button>

				<span class="material-input"></span></form>

				<form class="form-group label-floating is-select is-empty">
					<svg class="olymp-happy-face-icon"><use xlink:href="#olymp-happy-face-icon"></use></svg>

					<div class="btn-group bootstrap-select show-tick form-control style-2"><button type="button" class="btn dropdown-toggle btn-secondary" data-toggle="dropdown" role="button" title="Nothing selected"><span class="filter-option pull-left">Nothing selected</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open" role="combobox"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div><ul class="dropdown-menu inner" role="listbox" aria-expanded="false"><li data-original-index="0"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
											<div class="author-thumb">
												<img src="img/avatar52-sm.jpg" alt="author">
											</div>
												<div class="h6 author-title">Green Goo Rock</div>

											</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
												<div class="author-thumb">
													<img src="img/avatar74-sm.jpg" alt="author">
												</div>
												<div class="h6 author-title">Mathilda Brinker</div>
											</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
												<div class="author-thumb">
													<img src="img/avatar48-sm.jpg" alt="author">
												</div>
												<div class="h6 author-title">Marina Valentine</div>
											</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
												<div class="author-thumb">
													<img src="img/avatar75-sm.jpg" alt="author">
												</div>
												<div class="h6 author-title">Dave Marinara</div>
											</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="4"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
												<div class="author-thumb">
													<img src="img/avatar76-sm.jpg" alt="author">
												</div>
												<div class="h6 author-title">Rachel Howlett</div>
											</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div><select class="selectpicker form-control style-2 show-tick" multiple="" data-max-options="2" data-live-search="true" tabindex="-98">
						<option title="Green Goo Rock" data-content="<div class=&quot;inline-items&quot;>
											<div class=&quot;author-thumb&quot;>
												<img src=&quot;img/avatar52-sm.jpg&quot; alt=&quot;author&quot;>
											</div>
												<div class=&quot;h6 author-title&quot;>Green Goo Rock</div>

											</div>">Green Goo Rock
						</option>

						<option title="Mathilda Brinker" data-content="<div class=&quot;inline-items&quot;>
												<div class=&quot;author-thumb&quot;>
													<img src=&quot;img/avatar74-sm.jpg&quot; alt=&quot;author&quot;>
												</div>
												<div class=&quot;h6 author-title&quot;>Mathilda Brinker</div>
											</div>">Mathilda Brinker
						</option>

						<option title="Marina Valentine" data-content="<div class=&quot;inline-items&quot;>
												<div class=&quot;author-thumb&quot;>
													<img src=&quot;img/avatar48-sm.jpg&quot; alt=&quot;author&quot;>
												</div>
												<div class=&quot;h6 author-title&quot;>Marina Valentine</div>
											</div>">Marina Valentine
						</option>

						<option title="Dave Marinara" data-content="<div class=&quot;inline-items&quot;>
												<div class=&quot;author-thumb&quot;>
													<img src=&quot;img/avatar75-sm.jpg&quot; alt=&quot;author&quot;>
												</div>
												<div class=&quot;h6 author-title&quot;>Dave Marinara</div>
											</div>">Dave Marinara
						</option>

						<option title="Rachel Howlett" data-content="<div class=&quot;inline-items&quot;>
												<div class=&quot;author-thumb&quot;>
													<img src=&quot;img/avatar76-sm.jpg&quot; alt=&quot;author&quot;>
												</div>
												<div class=&quot;h6 author-title&quot;>Rachel Howlett</div>
											</div>">Rachel Howlett
						</option>

					</select></div>
				<span class="material-input"></span><span class="material-input"></span></form>

				<a href="#" class="btn btn-blue btn-lg full-width">Create Group</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="create-friend-group-add-friends" tabindex="-1" role="dialog" aria-labelledby="create-friend-group-add-friends" aria-hidden="true">
	<div class="modal-dialog window-popup create-friend-group create-friend-group-add-friends" role="document">
		<div class="modal-content">
			<a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
				<svg class="olymp-close-icon"><use xlink:href="#olymp-close-icon"></use></svg>
			</a>

			<div class="modal-header">
				<h6 class="title">Add Friends to “Freelance Clients” Group</h6>
			</div>

			<div class="modal-body">
			<form class="form-group label-floating is-select is-empty">

				<div class="btn-group bootstrap-select show-tick form-control style-2"><button type="button" class="btn dropdown-toggle btn-secondary" data-toggle="dropdown" role="button" title="Nothing selected"><span class="filter-option pull-left">Nothing selected</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button><div class="dropdown-menu open" role="combobox"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" role="textbox" aria-label="Search"></div><ul class="dropdown-menu inner" role="listbox" aria-expanded="false"><li data-original-index="0"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
										<div class="author-thumb">
											<img src="img/avatar52-sm.jpg" alt="author">
										</div>
											<div class="h6 author-title">Green Goo Rock</div>

										</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="1"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
											<div class="author-thumb">
												<img src="img/avatar74-sm.jpg" alt="author">
											</div>
											<div class="h6 author-title">Mathilda Brinker</div>
										</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="2"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
											<div class="author-thumb">
												<img src="img/avatar48-sm.jpg" alt="author">
											</div>
											<div class="h6 author-title">Marina Valentine</div>
										</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="3"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
											<div class="author-thumb">
												<img src="img/avatar75-sm.jpg" alt="author">
											</div>
											<div class="h6 author-title">Dave Marinara</div>
										</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li><li data-original-index="4"><a tabindex="0" class=" dropdown-item" style="" data-tokens="null" role="option" aria-disabled="false" aria-selected="false"><div class="inline-items">
											<div class="author-thumb">
												<img src="img/avatar76-sm.jpg" alt="author">
											</div>
											<div class="h6 author-title">Rachel Howlett</div>
										</div><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul></div><select class="selectpicker form-control style-2 show-tick" multiple="" data-max-options="2" data-live-search="true" tabindex="-98">
					<option title="Green Goo Rock" data-content="<div class=&quot;inline-items&quot;>
										<div class=&quot;author-thumb&quot;>
											<img src=&quot;img/avatar52-sm.jpg&quot; alt=&quot;author&quot;>
										</div>
											<div class=&quot;h6 author-title&quot;>Green Goo Rock</div>

										</div>">Green Goo Rock
					</option>

					<option title="Mathilda Brinker" data-content="<div class=&quot;inline-items&quot;>
											<div class=&quot;author-thumb&quot;>
												<img src=&quot;img/avatar74-sm.jpg&quot; alt=&quot;author&quot;>
											</div>
											<div class=&quot;h6 author-title&quot;>Mathilda Brinker</div>
										</div>">Mathilda Brinker
					</option>

					<option title="Marina Valentine" data-content="<div class=&quot;inline-items&quot;>
											<div class=&quot;author-thumb&quot;>
												<img src=&quot;img/avatar48-sm.jpg&quot; alt=&quot;author&quot;>
											</div>
											<div class=&quot;h6 author-title&quot;>Marina Valentine</div>
										</div>">Marina Valentine
					</option>

					<option title="Dave Marinara" data-content="<div class=&quot;inline-items&quot;>
											<div class=&quot;author-thumb&quot;>
												<img src=&quot;img/avatar75-sm.jpg&quot; alt=&quot;author&quot;>
											</div>
											<div class=&quot;h6 author-title&quot;>Dave Marinara</div>
										</div>">Dave Marinara
					</option>

					<option title="Rachel Howlett" data-content="<div class=&quot;inline-items&quot;>
											<div class=&quot;author-thumb&quot;>
												<img src=&quot;img/avatar76-sm.jpg&quot; alt=&quot;author&quot;>
											</div>
											<div class=&quot;h6 author-title&quot;>Rachel Howlett</div>
										</div>">Rachel Howlett
					</option>

				</select></div>
			<span class="material-input"></span><span class="material-input"></span></form>

			<a href="#" class="btn btn-blue btn-lg full-width">Save Changes</a>
		</div>
		</div>
	</div>
</div>
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/managers.js"></script>
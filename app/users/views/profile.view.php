<link rel="stylesheet" href="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker-default.css">
<script src="<?php echo $HOST_NAME ?>resources/plugins/persian-datepicker/persian-datepicker.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="ui-block">
				<div class="top-header">
					<div class="top-header-thumb">
						<img  src="<?php echo $HOST_NAME ?>resources/assets/img/top-header1.jpg" alt="nature">
					</div>
					<div class="profile-section">
				
						<div class="control-block-button">
							<!-- <a href="35-YourAccount-FriendsRequests.html" class="btn btn-control bg-blue">
								<svg class="olymp-happy-face-icon"><use xlink:href="#olymp-happy-face-icon"></use></svg>
							</a>

							<a href="#" class="btn btn-control bg-purple">
								<svg class="olymp-chat---messages-icon"><use xlink:href="#olymp-chat---messages-icon"></use></svg>
							</a> -->

							<div class="btn btn-control bg-primary more">
								<svg class="olymp-settings-icon"><use xlink:href="#olymp-settings-icon"></use></svg>

								<ul class="more-dropdown more-with-triangle triangle-bottom-right">
									<li>
										<a href="#" data-toggle="modal" data-target="#update-header-photo">آپلود تصویر پروفایل</a>
									</li>
									<li>
										<a href="#" data-toggle="modal" data-target="#update-header-photo">آپلود تصویر پس زمینه</a>
									</li>
									<li>
										<a href="29-YourAccount-AccountSettings.html">تنظیمات حساب کاربری</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="top-header-author">
						<a href="02-ProfilePage.html" class="author-thumb">
							<img src="<?= $HOST_NAME ?><?php if (isset($_SESSION["user_photo"])) echo $_SESSION["user_photo"]; ?>" width="120" alt="author">
						</a>
						<div class="author-content">
							<a href="02-ProfilePage.html" class="h4 author-name"><?= $_SESSION['full_name'] ?></a>
							<div class="country"><?= $_SESSION['user_type_name'] ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<!-- ... end Top Header-Profile -->
<div class="container">
    <div class="row">

        <!-- Main Content -->
        <div class="col col-xl-9 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div id="newsfeed-items-grid">

                <div class="ui-block">
                    <!-- Post -->

                    <div class="news-feed-form">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link inline-items" data-toggle="tab" href="#home-1" role="tab" aria-expanded="true" aria-selected="false">

                                    <svg class="olymp-status-icon">
                                        <use xlink:href="#olymp-status-icon"></use>
                                    </svg>

                                    <span>مشخصات کاربر</span>
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link inline-items" data-toggle="tab" href="#profile-1" role="tab" aria-expanded="false" aria-selected="false">

                                    <svg class="olymp-multimedia-icon">
                                        <use xlink:href="#olymp-multimedia-icon"></use>
                                    </svg>

                                    <span>ویرایش مشخصات</span>
                                    <div class="ripple-container"></div>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link inline-items active" data-toggle="tab" href="#blog" role="tab" aria-expanded="false" aria-selected="true">
                                    <svg class="olymp-blog-icon">
                                        <use xlink:href="#olymp-blog-icon"></use>
                                    </svg>

                                    <span>تغییر کلمه عبور</span>
                                    <div class="ripple-container"></div>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane" id="home-1" role="tabpanel" aria-expanded="true">
                                <form>

                                    <div class="form-group with-icon label-floating is-empty">
                                        <!-- Post -->
                                        <div class="post">

                                            <!-- /.user-block -->
                                            <P class="description">
                                                درباره من : <?= $user_info["notes"] ?>
                                            </P>
                                            <hr />
                                            <ul class="list-inline">
                                                <li>
                                                    آدرس : <a href="#" id="aAddress" class="link-black text-sm"><?= $user_info["address"] ?></a>
                                                </li>
                                            </ul>
                                            <hr />
                                            <ul class="list-inline">
                                                <li> تلفن : <a href="#" id="aPhone" class="link-black text-sm"><?= $user_info["phone"] ?></a></li>
                                            </ul>
                                            <hr />
                                            <ul class="list-inline">
                                                <li> ایمیل : <a href="#" class="link-black text-sm"><?= $user_info["email"] ?></a> </li>
                                            </ul>
                                            <hr />
                                            <ul class="list-inline">
                                                <li> تاریخ تولد : <a href="#" id="aBirthDate" class="link-black text-sm"><?= $user_info["birth_date"] ?></a> </li>
                                            </ul>
                                            <hr />
                                            <ul class="list-inline">

                                                <li>جنسیت : <a href="#" id="aGender" class="link-black text-sm"><?= $gender ?></a> </li>
                                            </ul>

                                            <p>

                                            </p>

                                        </div>
                                        <!-- /.post -->
                                    </div>


                                </form>
                            </div>

                            <div class="tab-pane" id="profile-1" role="tabpanel" aria-expanded="true">
                                <form>
                                    <div class="form-group with-icon label-floating is-empty">
                                        <label for="firstName" class="control-label">نام</label>
                                        <input type="text" class="form-control text-center" id="firstName" name="firstName" value="<?= $user_info["name"] ?>">
                                    </div>
                                    <div class="form-group with-icon label-floating is-empty">
                                        <label for="lastName" class="control-label">نام خانوادگی</label>
                                        <input type="text" class="form-control text-center" id="lastName" name="lastName" value="<?= $user_info["family"] ?>">
                                    </div>
                                    <div class="form-group with-icon label-floating is-empty">
                                        <label for="phoneNumber" class="control-label">تلفن همراه</label>
                                        <input type="text" class="form-control text-center" id="phoneNumber" name="phoneNumber" value="<?= $user_info["phone"] ?>">
                                    </div>
                                    <div class="form-group with-icon label-floating is-empty">
                                        <label for="birthDate" class="control-label">تاریخ تولد</label>
                                        <input type="text" class="form-control text-center date-picker" autocomplete="off" id="birthDate" name="birthDate" value="<?= $user_info["birth_date"] ?>">
                                    </div>
                                    <div class="form-group with-icon  is-empty">
                                        <label class="control-label" style="padding-right: 20px;padding-top: 10px;">جنسیت</label>
                                        <?php

                                        $femaleSelected = "";
                                        $maleSelected = "";
                                        $otherGenderSelected = "";

                                        if ($user_info["gender"] == 0) {
                                            $femaleSelected = " selected ";
                                        }
                                        if ($user_info["gender"] == 1) {
                                            $maleSelected = " selected ";
                                        }
                                        if ($user_info["gender"] == 2) {
                                            $otherGenderSelected = " selected ";
                                        }

                                        ?>
                                        <select class="form-control  selectpicker" id="gender" name="gender">
                                            <option <?= $femaleSelected ?> value="0">زن</option>
                                            <option <?= $maleSelected ?> value="1">مرد</option>
                                            <option <?= $otherGenderSelected ?> value="2">سایر</option>
                                        </select>

                                    </div>
                                    <div class="form-group with-icon label-floating is-empty">
                                        <label for="address" class="control-label">آدرس</label>
                                        <input type="text" class="form-control text-center" id="address" name="address" value="<?= $user_info["address"] ?>">
                                    </div>
                                    <div class="form-group with-icon label-floating is-empty">
                                        <label for="notes" class="control-label">یادداشت</label>

                                        <textarea class="form-control" id="notes" name="notes">
                                            <?= $user_info["notes"] ?>
                                        </textarea>
                                    </div>

                                    <div class="add-options-message">
                                        <button id="btnUpdateUserInfo" name="btnUpdateUserInfo" class="btn btn-primary btn-md-2">ذخیره</button>
                                        <button class="btn btn-md-2 btn-border-think btn-transparent c-grey">لغو</button>
                                    </div>

                                </form>
                            </div>

                            <div class="tab-pane active" id="blog" role="tabpanel" aria-expanded="true">
                                <form>

                                    <div class="form-group with-icon label-floating is-empty">
                                        <label class="control-label" for="currentPassword">کلمه عبور فعلی</label>
                                        <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                                        <span class="material-input"></span>
                                    </div>

                                    <div class="form-group with-icon label-floating is-empty">
                                        <label class="control-label" for="currentPassword">کلمه عبور جدید</label>
                                        <input type="password" class="form-control" id="newPassword" id="newPassword">
                                        <span class="material-input"></span>
                                    </div>

                                    <div class="form-group with-icon label-floating is-empty">
                                        <label class="control-label" for="currentPassword">تکرار کلمه عبور</label>
                                        <input type="password" class="form-control" id="repeatNewPassword" name="repeatNewPassword">
                                        <span class="material-input"></span>
                                    </div>

                                    <div class="add-options-message">
                                        <!-- <a href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="ADD PHOTOS">
                                            <svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo">
                                                <use xlink:href="#olymp-camera-icon"></use>
                                            </svg>
                                        </a>
                                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="TAG YOUR FRIENDS">
                                            <svg class="olymp-computer-icon">
                                                <use xlink:href="#olymp-computer-icon"></use>
                                            </svg>
                                        </a>

                                        <a href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="ADD LOCATION">
                                            <svg class="olymp-small-pin-icon">
                                                <use xlink:href="#olymp-small-pin-icon"></use>
                                            </svg>
                                        </a> -->

                                        <button id="btnChangePassword" name="btnChangePassword" class="btn btn-primary btn-md-2">ذخیره</button>
                                        <button class="btn btn-md-2 btn-border-think btn-transparent c-grey">لغو</button>

                                    </div>


                                </form>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- ... end Main Content -->

        <!-- Left Sidebar -->
        <div class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-6 col-12">

            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title">اطلاعات پروفایل</h6>
                </div>
                <div class="ui-block-content">

                    <!-- W-Personal-Info -->
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div id="userThumbnail">
                                <img id="user_photo" class="profile-user-img img-responsive img-circle" src="<?= $HOST_NAME ?><?php if (isset($_SESSION["user_photo"])) echo $_SESSION["user_photo"]; ?>" alt="<?= $_SESSION['full_name'] ?> picture">
                            </div>
                            <h3 id="hFullName" class="profile-username text-center"> <?= $_SESSION['full_name'] ?></h3>
                            <p class="text-muted text-center"><?= $_SESSION['user_type_name'] ?></p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b> تاریخ عضویت : </b><a class="pull-left"><?= $_SESSION['reg_date'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b> ایمیل : </b><a class="pull-left"><?= $_SESSION['user_email'] ?></a>
                                </li>

                            </ul>
                            <hr />
                            <label for="FileUpload" class="btn btn-primary btn-block">ارسال تصویر</label>
                            <input type="file" name="FileUpload" id="FileUpload" class="profile-file-upload" style="display: none;" />

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                    <!-- About Me Box -->
                    <ul class="widget w-personal-info item-block">
                        <li>
                            <span class="title">یاداشت:</span>
                            <span id="pNotes" class="text"><?= $user_info["notes"] ?></span>
                        </li>

                    </ul>

                    <!-- .. end W-Personal-Info -->
                    <!-- W-Socials -->

                    <!-- <div class="widget w-socials">
                        <h6 class="title">Other Social Networks:</h6>
                        <a href="#" class="social-item bg-facebook">
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                            Facebook
                        </a>
                        <a href="#" class="social-item bg-twitter">
                            <i class="fab fa-twitter" aria-hidden="true"></i>
                            Twitter
                        </a>
                        <a href="#" class="social-item bg-dribbble">
                            <i class="fab fa-dribbble" aria-hidden="true"></i>
                            Dribbble
                        </a>
                    </div> -->


                    <!-- ... end W-Socials -->
                </div>
            </div>


        </div>
        <!-- ... end Left Sidebar -->

    </div>
</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/users/scripts/profile.js"></script>
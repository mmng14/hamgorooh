<style>
    .user-photo {
        width: 130px;
    }

    .author-thumb img {
        max-width: 50px;
    }

    .chat-message-item-current {
        background-color: #7c5ac2;
        color: #fff;
        float: left;
        direction: ltr;
    }

    .chat-message-item {
        padding: 13px;
        background-color: #f0f4f9;
        margin-top: 0;
        border-radius: 10px;
        margin-bottom: 5px;
        font-size: 12px;
    }

    .chat-others-li {
        text-align: right;
        direction: ltr;
        margin-right: 20px
    }

    .chat-others-div {
        direction: ltr;
    }

    .chat-others-span {
        margin-right: 25px;
        background: #7c5ac2;
        color: #f0f4f9;
    }

    .chat-message-field .notification-event {
        width: 90% !important;
    }

    .notification-friend-current {}

    .notification-date-current {}

    .notification-friend-others {}

    .notification-date-others {}
</style>



<div class="main-header">
    <div class="content-bg-wrap bg-group"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3 >  پیامهای گروه  <?= $subject_name   ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!--
	<img class="img-bottom" src="img/group-bottom.png" alt="friends"> -->

</div>

<div class="container">
    <div class="row">
        <div class="col col-xl-12 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title"> پیامهای گروه  </h6>
                    <a href="#" class="more"><svg class="olymp-three-dots-icon">
                            <use xlink:href="#olymp-three-dots-icon"></use>
                        </svg></a>
                </div>

                <div class="row">

                    <!-- <div class="col col-xl-3 col-lg-6 col-md-12 col-sm-12 col-12 padding-r-0">

                        <div class="ui-block popup-chat">
                            <div class="ui-block-title">
                                <span class="icon-status online"></span>
                                <h6 class="title">گروه </h6>
                                <div class="more">
                                    <svg class="olymp-three-dots-icon">
                                        <use xlink:href="#olymp-three-dots-icon"></use>
                                    </svg>
                                    <svg class="olymp-little-delete">
                                        <use xlink:href="#olymp-little-delete"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="mCustomScrollbar" data-mcs-theme="dark">
                                <ul class="notification-list chat-message chat-message-field">

                                    <li>
                                        <div class="author-thumb">
                                            <img src="<?= $HOST_NAME . "resources/assets/" ?>img/avatar14-sm.jpg" alt="author">
                                        </div>
                                        <div class="notification-event">
                                            <span class="chat-message-item">سلام . خوبی ؟ پروژه تمام شد ؟</span>
                                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="author-thumb">
                                            <img src="<?= $HOST_NAME . "resources/assets/" ?>img/avatar14-sm.jpg" alt="author">
                                        </div>
                                        <div class="notification-event">
                                            <span class="chat-message-item">سلام . خوبی ؟ پروژه تمام شد ؟</span>
                                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="author-thumb">
                                            <img src="<?= $HOST_NAME . "resources/assets/" ?>img/author-page.jpg" alt="author">
                                        </div>
                                        <div class="notification-event">
                                            <span class="chat-message-item">نگران نباش خدم درستش می کنم</span>
                                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:29pm</time></span>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="author-thumb">
                                            <img src="<?= $HOST_NAME . "resources/assets/" ?>img/avatar14-sm.jpg" alt="author">
                                        </div>
                                        <div class="notification-event">
                                            <span class="chat-message-item">سلام . نمیدونم چیکار باید کرد ؟</span>
                                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
                                        </div>
                                    </li>

                                </ul>
                            </div>

                            <form>

                                <div class="form-group label-floating is-empty">
                                    <textarea class="form-control" placeholder="پیام خود را وارد نمایید ..."></textarea>
                                    <div class="add-options-message">
                                        <a href="#" class="options-message">
                                            <svg class="olymp-computer-icon">
                                                <use xlink:href="#olymp-computer-icon"></use>
                                            </svg>
                                        </a>
                                        <div class="options-message smile-block">

                                            <svg class="olymp-happy-sticker-icon">
                                                <use xlink:href="#olymp-happy-sticker-icon"></use>
                                            </svg>

                                            <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                                <li>
                                                    <a href="#">
                                                        <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat1.png" alt="icon">
                                                    </a>
                                                </li>
                                              
                                                <li>
                                                    <a href="#">
                                                        <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat27.png" alt="icon">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </form>


                        </div>

                    </div>
                    -->


                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 padding-l-0">


                        <!-- Chat Field -->

                        <div class="chat-field">
                            <div class="ui-block-title">
                                <h6 class="title"><?= $subject_name   ?></h6>
                                <a href="#" class="more"><svg class="olymp-three-dots-icon">
                                        <use xlink:href="#olymp-three-dots-icon"></use>
                                    </svg></a>
                            </div>
                            <div class="mCustomScrollbar" data-mcs-theme="dark">
                                <button id="load_more"  class="btn btn-control btn-more"  data-container="">
                                    <svg class="olymp-three-dots-icon">
                                        <use xlink:href="#olymp-three-dots-icon"></use>
                                    </svg>
                                    <div class="ripple-container"></div>
                                </button>
                                <input type="hidden" id="page_number" value="1" />
                                <ul id="chatMessages" class="notification-list chat-message chat-message-field">

                       

                                </ul>
                            </div>

                            <form>
                                <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                                <input type="hidden" id="selected_subject_id" name="selected_subject_id" value="<?php echo $selected_subject_id; ?>" />
                                <div id="userMessageDiv" class="form-group">
                                    <textarea id="userMessage" class="form-control" placeholder="پیام خود را وارد نمایید"></textarea>
                                </div>

                                <div class="add-options-message">

                                    <a href="#" class="options-message">
                                        <svg class="olymp-computer-icon">
                                            <use xlink:href="#olymp-computer-icon"></use>
                                        </svg>
                                    </a>
                                    <div class="options-message smile-block">
                                        <svg class="olymp-happy-sticker-icon">
                                            <use xlink:href="#olymp-happy-sticker-icon"></use>
                                        </svg>

                                        <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat1.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat2.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat3.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat4.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat5.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat6.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat7.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat8.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat9.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat10.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat11.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat12.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat13.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat14.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat15.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat16.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat17.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat18.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat19.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat20.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat21.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat22.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat23.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat24.png" alt="icon">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <img src="<?= $HOST_NAME . "resources/assets/" ?>img/icon-chat25.png" alt="icon">
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
                                            </li>
                                        </ul>
                                    </div>

                                    <button id="sendMessage" id="sendMessage" class="btn btn-primary btn-lg">ارسال</button>
                                </div>

                            </form>

                        </div>

                        <!-- ... end Chat Field -->

                    </div>
                </div>

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

        <!-- <div class="col col-xl-3 order-xl-1 col-lg-3 order-lg-1 col-md-12 order-md-2 col-sm-12 col-12 responsive-display-none">
            <div class="ui-block">

   

                <div class="your-profile">
                    <div class="ui-block-title ui-block-title-small">
                        <h6 class="title">Your PROFILE</h6>
                    </div>

                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h6 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Profile Settings
                                        <svg class="olymp-dropdown-arrow-icon">
                                            <use xlink:href="#olymp-dropdown-arrow-icon"></use>
                                        </svg>
                                    </a>
                                </h6>
                            </div>

                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <ul class="your-profile-menu">
                                    <li>
                                        <a href="28-YourAccount-PersonalInformation.html">Personal Information</a>
                                    </li>
                                    <li>
                                        <a href="29-YourAccount-AccountSettings.html">Account Settings</a>
                                    </li>
                                    <li>
                                        <a href="30-YourAccount-ChangePassword.html">Change Password</a>
                                    </li>
                                    <li>
                                        <a href="31-YourAccount-HobbiesAndInterests.html">Hobbies and Interests</a>
                                    </li>
                                    <li>
                                        <a href="32-YourAccount-EducationAndEmployement.html">Education and Employement</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="ui-block-title">
                        <a href="33-YourAccount-Notifications.html" class="h6 title">Notifications</a>
                        <a href="#" class="items-round-little bg-primary">8</a>
                    </div>
                    <div class="ui-block-title">
                        <a href="34-YourAccount-ChatMessages.html" class="h6 title">Chat / Messages</a>
                    </div>
                    <div class="ui-block-title">
                        <a href="35-YourAccount-FriendsRequests.html" class="h6 title">Friend Requests</a>
                        <a href="#" class="items-round-little bg-blue">4</a>
                    </div>
                    <div class="ui-block-title ui-block-title-small">
                        <h6 class="title">FAVOURITE PAGE</h6>
                    </div>
                    <div class="ui-block-title">
                        <a href="36-FavPage-SettingsAndCreatePopup.html" class="h6 title">Create Fav Page</a>
                    </div>
                    <div class="ui-block-title">
                        <a href="36-FavPage-SettingsAndCreatePopup.html" class="h6 title">Fav Page Settings</a>
                    </div>
                </div>

           

            </div>
        </div> -->


    </div>
</div>

<!-- ... end Your Account Personal Information -->


<!-- Window-popup-CHAT for responsive min-width: 768px -->

<div class="ui-block popup-chat popup-chat-responsive" tabindex="-1" role="dialog" aria-labelledby="popup-chat-responsive" aria-hidden="true">
    <div class="modal-content">
        <div class="modal-header">
            <span class="icon-status online"></span>
            <h6 class="title">Chat</h6>
            <div class="more">
                <svg class="olymp-three-dots-icon">
                    <use xlink:href="#olymp-three-dots-icon"></use>
                </svg>
                <svg class="olymp-little-delete js-chat-open">
                    <use xlink:href="#olymp-little-delete"></use>
                </svg>
            </div>
        </div>
        <div class="modal-body">
            <div class="mCustomScrollbar">
                <ul class="notification-list chat-message chat-message-field">
                    <li>
                        <div class="author-thumb">
                            <img src="img/avatar14-sm.jpg" alt="author" class="mCS_img_loaded">
                        </div>
                        <div class="notification-event">
                            <span class="chat-message-item">Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks</span>
                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
                        </div>
                    </li>

                    <li>
                        <div class="author-thumb">
                            <img src="img/author-page.jpg" alt="author" class="mCS_img_loaded">
                        </div>
                        <div class="notification-event">
                            <span class="chat-message-item">Don’t worry Mathilda!</span>
                            <span class="chat-message-item">I already bought everything</span>
                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:29pm</time></span>
                        </div>
                    </li>

                    <li>
                        <div class="author-thumb">
                            <img src="img/avatar14-sm.jpg" alt="author" class="mCS_img_loaded">
                        </div>
                        <div class="notification-event">
                            <span class="chat-message-item">Hi James! Please remember to buy the food for tomorrow! I’m gonna be handling the gifts and Jake’s gonna get the drinks</span>
                            <span class="notification-date"><time class="entry-date updated" datetime="2004-07-24T18:18">Yesterday at 8:10pm</time></span>
                        </div>
                    </li>
                </ul>
            </div>

            <form class="need-validation">

                <div class="form-group">
                    <textarea class="form-control" placeholder="Press enter to post..."></textarea>
                    <div class="add-options-message">
                        <a href="#" class="options-message">
                            <svg class="olymp-computer-icon">
                                <use xlink:href="#olymp-computer-icon"></use>
                            </svg>
                        </a>
                        <div class="options-message smile-block">

                            <svg class="olymp-happy-sticker-icon">
                                <use xlink:href="#olymp-happy-sticker-icon"></use>
                            </svg>

                            <ul class="more-dropdown more-with-triangle triangle-bottom-right">
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat1.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat2.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat3.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat4.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat5.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat6.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat7.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat8.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat9.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat10.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat11.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat12.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat13.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat14.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat15.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat16.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat17.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat18.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat19.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat20.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat21.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat22.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat23.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat24.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat25.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat26.png" alt="icon">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/icon-chat27.png" alt="icon">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<!-- ... end Window-popup-CHAT for responsive min-width: 768px -->



<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?= $HOST_NAME  ?>app/users/scripts/group_messages.js"></script>
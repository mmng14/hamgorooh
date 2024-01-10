
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
                    <h3>اعضای گروه <?= $subject_name ?></h1>
                </div>
            </div>
        </div>
    </div>
    <!--
	<img class="img-bottom" src="img/group-bottom.png" alt="friends"> -->

</div>

<div class="container">
    <div class="row">
        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title"><?php echo $user_subject["subject_name"];  ?></h6>
                    <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                    <a href="<?php echo $HOST_NAME; ?>users/post_management/<?php echo $user_subject["subject_id"]  ?>" class="btn btn-sm btn-green">پستهای من</a>
                    <a href="<?php echo $HOST_NAME; ?>users/user_groups" class="btn btn-sm btn-purple">بازگشت به گروههای من</a>
                </div>
            </div>
        </div>

        <?php foreach ($user_subjects as $user_subject) : ?>
            <?php
            $selected_user = $database->users()
                ->select("id,name,family,photo,phone")
                ->where("id = ?", $user_subject["user_id"])
                ->fetch();

            $user_full_name = $selected_user['name'] . ' ' . $selected_user['family'];
            $user_photo = $selected_user['photo'];
            $user_phone = $selected_user['phone'];
            $user_role = "";
            if ($user_subject['role'] == 1) {
                $user_role = "مدیر ارشد";
            }
            if ($user_subject['role'] == 2) {
                $user_role = "مدیر گروه";
            }
            if ($user_subject['role'] == 3) {
                $user_role = "عضو ويژه";
            }
            if ($user_subject['role'] == 4) {
                $user_role = "عضو گروه";
            }
            if ($user_subject['role'] == 5) {
                $user_role = "عضو گروه";
            }
            ?>
            <div class="col col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="ui-block" data-mh="friend-groups-item" style="height: 391px;">


                    <!-- Friend Item -->
                    <div class="friend-item friend-groups">

                        <div class="friend-item-content">

                            <!-- <div class="more">
                                <svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg>
                                <ul class="more-dropdown">
                                    <li>
                                        <a href="<?= $HOST_NAME ?>/admin/user_info/<?= $user_subject['user_id'] ?>">نمایش جزییات</a>
                                    </li>
                                    <li>
                                        <a href="#">مسدود کردن </a>
                                    </li>
                                    <li>
                                        <a href="#">خاموش کردن نوتیفیکیشن</a>
                                    </li>
                                </ul>
                            </div> -->

                            <div class="friend-avatar">
                                <div class="author-thumb">

                                    <?php if (isset($user_photo) && $user_photo != "") : ?>
                                        <img class="user-photo" src="<?= $HOST_NAME; ?><?= $user_photo ?>" alt="<?= $user_full_name  ?>">
                                    <?php else : ?>
                                        <img class="user-photo" src="<?php echo $HOST_NAME;  ?>resources/shared/admin/img/user1-128x128.jpg" alt="<?= $user_full_name  ?>">
                                    <?php endif ?>

                                </div>
                                <div class="author-content text-center">
                                    <a href="#" class="h5 author-name"><?= $user_full_name  ?></a>
                                    <div class="country text-center"><?= $user_role  ?></div>
                                </div>
                            </div>

                            <!-- <div class="control-block-button">
                                <a href="#" class="  btn btn-control bg-blue" data-toggle="modal" data-target="#create-friend-group-add-friends">
                                    <svg class="olymp-block-from-chat">
                                        <use xlink:href="#olymp-block-from-chat"></use>
                                    </svg>
                                </a>

                                <a href="#" class="btn btn-control btn-grey-lighter">
                                    <svg class="olymp-settings-icon">
                                        <use xlink:href="#olymp-settings-icon"></use>
                                    </svg>
                                </a>
                                <a href="#" class="btn btn-control bg-blue" onclick="prepareChatForm(<?=$user_subject['user_id']?>)" data-toggle="modal" data-target="#chat-window-with-group-friend">
                                    <svg class="olymp-happy-faces-icon">
                                        <use xlink:href="#olymp-happy-faces-icon"></use>
                                    </svg>
                                    <div class="ripple-container"></div>
                                </a>
                            </div> -->

                        </div>
                    </div>
                    <!-- ... end Friend Item -->

                </div>
            </div>
        <?php endforeach;  ?>


    </div>

</div>

<!-- Window-popup Create Friends Group Add Friends -->

<div class="modal fade" id="chat-window-with-group-friend" tabindex="-1" role="dialog" aria-labelledby="create-friend-group-add-friends" aria-hidden="true">
    <div class="modal-dialog window-popup create-friend-group create-friend-group-add-friends" role="document">
        <div class="modal-content">
            <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                <svg class="olymp-close-icon">
                    <use xlink:href="#olymp-close-icon"></use>
                </svg>
            </a>

            <div class="modal-header">
                <span class="icon-status online"></span>
                <h6 class="title">گفتگو با اعضای گروه</h6>
                <div class="more">
                    <svg class="olymp-three-dots-icon">
                        <use xlink:href="#olymp-three-dots-icon"></use>
                    </svg>
                    <!-- <svg class="olymp-little-delete js-chat-open">
                        <use xlink:href="#olymp-little-delete"></use>
                    </svg> -->
                </div>
            </div>

            <div class="modal-body">

                <div class="chat-field">
                    <div class="ui-block-title">
                        <h6 class="title" id="friend_name">نام همگروه</h6>
                        <a href="#" class="more"><svg class="olymp-three-dots-icon">
                                <use xlink:href="#olymp-three-dots-icon"></use>
                            </svg></a>
                    </div>
                    <div class="mCustomScrollbar" data-mcs-theme="dark">
                        <button id="load_more" class="btn btn-control btn-more" data-container="">
                            <svg class="olymp-three-dots-icon">
                                <use xlink:href="#olymp-three-dots-icon"></use>
                            </svg>
                            <div class="ripple-container"></div>
                        </button>
                        <input type="hidden" id="page_number" value="1" />
                        <ul id="chatMessages" class="notification-list chat-message chat-message-field">



                        </ul>
                    </div>
                    <form class="need-validation">
                        <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                        <input type="hidden" id="selected_subject_id" name="selected_subject_id" value="<?= $user_subject["subject_id"]; ?>" />
                        <input type="hidden" id="selected_friend_id" name="selected_friend_id" value="" />
                        <div class="form-group is-empty">
                            <div id="userMessageDiv" class="form-group">
                                <textarea id="userMessage" class="form-control" rows="2" placeholder="لطفا پیام خود را وارد نمایید..."></textarea>
                            </div>
                        </div>
                        <button id="sendMessage" id="sendMessage" class="btn btn-blue btn-lg full-width">ارسال</a>
                    </form>
                </div>



            </div>
        </div>
    </div>
</div>

<!-- ... end Window-popup Create Friends Group Add Friends -->


<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/users/scripts/teammates.js"></script>
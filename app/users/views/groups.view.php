<style>
    .user-photo {
        width: 130px;
    }
</style>


<div class="container">
    <div class="row">

        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="ui-block responsive-flex">
                <div class="ui-block-title">
                    <div class="h6 title">همه گروهها (<?= count($subject_list_view_model); ?>)</div>
                    <form class="w-search">
                        <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                        <div class="form-group with-button">
                            <input class="form-control" type="text" placeholder="جستجوی در گروها...">
                            <button>
                                <svg class="olymp-magnifying-glass-icon">
                                    <use xlink:href="#olymp-magnifying-glass-icon"></use>
                                </svg>
                            </button>
                        </div>
                    </form>
                    <a href="#" class="more"><svg class="olymp-three-dots-icon">
                            <use xlink:href="#olymp-three-dots-icon"></use>
                        </svg></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- groups start -->
<div class="container">
    <div class="row">
        <?php foreach ($subject_list_view_model as $subject) : ?>
            <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="ui-block">

                    <!-- Friend Item -->

                    <div class="friend-item">
                        <div class="friend-header-thumb">
                            <img src="<?php echo $HOST_NAME . $subject["photo"]; ?>" alt="<?php echo $subject["name"]; ?>">
                        </div>

                        <div class="friend-item-content">

                            <div class="more">
                                <svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg>
                                <ul class="more-dropdown">
                                    <li>
                                        <a href="#">گزارش تخلف</a>
                                    </li>
                                    <li>
                                        <a href="#">نمایش درسایت</a>
                                    </li>
                                    <!-- <li>
                                        <a href="#">خروج از گروه</a>
                                    </li> -->

                                </ul>
                            </div>
                            <div class="friend-avatar" style="text-align: center;">
                                <div class="author-thumb">
                                    <img src="<?= $HOST_NAME ?>/resources/assets/img/avatar1.jpg" alt="author">
                                </div>
                                <div class="author-content">
                                    <a href="#" class="h5 author-name"><?php echo $subject["name"]; ?></a>
                                    <div class="country">همگروه</div>
                                </div>
                            </div>

                            <div class="swiper-container-add_to_disable_class">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">

                                        <div class="control-block-button" data-swiper-parallax="-100">
                                            <div id="membership_status_<?php echo $subject['id'] ?>">
                                                <?php if ($subject["membership_status"] == 0) : ?>
                                                    <button onclick="requestMembershipForSubject(<?php echo $subject['id'] ?>,'<?php echo $subject['name'] ?>');" class="btn  bg-blue full-width">
                                                        درخواست عضویت
                                                        <!-- <svg class="olymp-happy-face-icon">
                                                            <use xlink:href="#olymp-happy-face-icon"></use>
                                                        </svg> -->
                                                        <i class="fa fa-2x fa-user-plus"></i>
                                                    </button>
                                                <?php endif ?>

                                                <?php if ($subject["membership_status"] == 1) : ?>

                                                    <a href="<?php echo $HOST_NAME; ?>users/teammates/<?php echo $subject["id"] ?>" class="btn  bg-green full-width">
                                                        اعضای گروه
                                                        <!-- <svg class="olymp-chat---messages-icon">
                                                            <use xlink:href="#olymp-chat---messages-icon"></use>
                                                        </svg> -->
                                                        <i class="fa fa-2x fa-users"></i>
                                                    </a>
                                                <?php endif ?>

                                                <?php if ($subject["membership_status"] == 2) : ?>

                                                    <a href="<?php echo $HOST_NAME; ?>users/teammates/<?php echo $subject["id"] ?>" class="btn  bg-green full-width">
                                                        اعضای گروه
                                                        <!-- <svg class="olymp-chat---messages-icon">
                                                            <use xlink:href="#olymp-chat---messages-icon"></use>
                                                        </svg> -->
                                                        <i class="fa fa-2x fa-users"></i>
                                                    </a>

                                                <?php endif ?>

                                                <?php if ($subject["membership_status"] == 3) : ?>
                                                    <button class="btn  bg-yellow full-width">
                                                        درخواست ارسال شد
                                                        <!-- <svg class="olymp-happy-face-icon">
                                                            <use xlink:href="#olymp-happy-face-icon"></use>
                                                        </svg> -->
                                                        <i class="fa fa-2x fa fa-user-plus"></i>
                                                    </button>
                                                <?php endif ?>

                                                <?php if ($subject["membership_status"] == 4) : ?>
                                                    <button class="btn  bg-red full-width">
                                                        درخواست رد شد
                                                        <!-- <svg class="olymp-happy-face-icon">
                                                            <use xlink:href="#olymp-happy-face-icon"></use>
                                                        </svg> -->
                                                        <i class="fa fa-2x fa-user-times"></i>
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                            <!-- <a href="<?php echo $HOST_NAME; ?>/subjects/" target="_blank" class="btn  bg-green">
                                                نمایش در سایت
                                                <svg class="olymp-chat---messages-icon">
                                                    <use xlink:href="#olymp-chat---messages-icon"></use>
                                                </svg>
                                            </a> -->

                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- ... end Friend Item -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- groups end -->
    <script>
        var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
    </script>
    <script src="<?php echo $HOST_NAME; ?>app/users/scripts/groups.js"></script>
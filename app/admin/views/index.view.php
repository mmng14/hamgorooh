<style>
    .user-photo {
        width: 130px;
    }

    .friend-item-content {
        padding: 0 5px 15px 5px;
    }
</style>
<div class="main-header">
    <div class="content-bg-wrap bg-account"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3 class="title">پنل مدیر سامانه</h6>
                        <p></p>
                </div>
            </div>
        </div>
    </div>
    <!-- <img class="img-bottom" src="img/account-bottom.png" alt="friends"> -->
</div>

<!-- Main Content -->

<div class="container">

    <div class="row">


        <div class="col col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="ui-block">
                <div class="available-widget">

                    <a href="<?= $HOST_NAME ?>/users/user_groups/" class="btn btn-primary btn-md-2">
                        <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                        <span style="font-size: large;margin-right:5px">
                            گروههای من
                        </span>
                    </a>

                </div>
            </div>
        </div>
        <div class="col col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="ui-block">
                <div class="available-widget">

                    <a href="<?= $HOST_NAME ?>/users/groups/" class="btn bg-purple btn-md-2">
                        <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                        <span style="font-size: large;margin-right:5px">
                            همه گروهها
                        </span>
                    </a>

                </div>
            </div>
        </div>
        <div class="col col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="ui-block">
                <div class="available-widget">

                    <a href="<?= $HOST_NAME ?>/users/ads_request/" class="btn bg-breez btn-md-2">
                        <i class="fa fa-anchor fa-2x" aria-hidden="true"></i>
                        <span style="font-size: large;margin-right:5px">
                            در خواست تبلیغات
                        </span>
                    </a>

                </div>
            </div>
        </div>
        <div class="col col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="ui-block">
                <div class="available-widget">

                    <a href="<?= $HOST_NAME ?>/users/profile/" class="btn btn-blue btn-md-2">

                        <i class="fa fa-address-card fa-2x" aria-hidden="true"></i>
                        <span style="font-size: large;margin-right:5px">
                            اطلاعات کاربر
                        </span>
                    </a>

                </div>
            </div>
        </div>


    </div>

</div>



<div class="container">
    <div class="row">

        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="ui-block responsive-flex">
                <div class="ui-block-title" style="background-color: #ddd;">
                    <div class="h6 title"> گروههای من(<?= count($subject_list); ?>)</div>
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

<!--user groups start -->
<div class="container">
    <div class="row">
        <?php foreach ($subject_list as $subject) : ?>
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
                                    <li>
                                        <a href="#">خروج از گروه</a>
                                    </li>

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

                                            <a href="<?php echo $HOST_NAME; ?>users/post_management/<?php echo $subject["id"] ?>" class="btn  bg-green text-middle">
                                                <!-- <svg class="olymp-blog-icon right-menu-icon">
                                                <use xlink:href="#olymp-blog-icon"></use>
                                            </svg> -->
                                                <i class="fa  fa-file" style="font-size:16px;margin-right:5px"></i>
                                                <span style="font-size:14px;margin-right:5px">
                                                پستهای من
                                                </span>
                                            </a>
                                            <!-- <a href="<?php echo $HOST_NAME; ?>/subjects/" target="_blank" class="btn  bg-blue">
                                                نمایش در سایت
                                                <svg class="olymp-chat---messages-icon">
                                                    <use xlink:href="#olymp-chat---messages-icon"></use>
                                                </svg>
                                            </a> -->
                                            <a href="<?php echo $HOST_NAME; ?>users/teammates/<?php echo $subject["id"] ?>" class="btn  bg-purple">
                                                <!-- <svg class="olymp-happy-faces-icon right-menu-icon">
                                                    <use xlink:href="#olymp-happy-faces-icon"></use>
                                                </svg> -->
                                                <i class="fa  fa-users" aria-hidden="true" style="font-size:16px;margin-right:5px"></i>

                                                <span style="font-size:14px;margin-right:5px">
                                                    اعضای گروه
                                                </span>
                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>users/group_messages/<?php echo $subject["id"] ?>" class="btn  bg-blue">
                                                <!-- <svg class="olymp-happy-faces-icon right-menu-icon">
                                                    <use xlink:href="#olymp-happy-faces-icon"></use>
                                                </svg> -->
                                                <i class="fa  fa-comments" aria-hidden="true" style="font-size:16px;margin-right:5px"></i>

                                                <span style="font-size:14px;margin-right:5px">
                                                    پیامهای گروه
                                                </span>
                                            </a>
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
    <!--user groups end -->
</div>


<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/users/scripts/user_groups.js"></script>

<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/index.js"></script>
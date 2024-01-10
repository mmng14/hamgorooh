<style>
    .friend-item-content{
        padding: 10px !important;
    }
</style>
<div class="main-header">
    <div class="content-bg-wrap bg-birthday"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3>مدیریت گروهها</h3>
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
                    <div class="ui-block-title">
                        <h6 class="title">گروههای تحت مدیریت من</h6>
                    </div>
                </div>
            </div>
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
                                        <a href="<?php echo $HOST_NAME; ?>users/messages/<?php echo $subject["id"]  ?>">پیامهای گروه</a>
                                    </li>
                                    <li>
                                        <a href="#">نمایش درسایت</a>
                                    </li>
                                    <li>
                                        <a href="#">درخواست استعفا از مدیریت</a>
                                    </li>

                                </ul>
                            </div>
                            <div class="friend-avatar" style="text-align: center;">
                                <div class="author-thumb">
                                    <?php
                                        $group_admin_image =  $HOST_NAME . "/resources/assets/img/avatar1.jpg";
                                        if (isset($_SESSION["user_photo"])){ 
                                            $group_admin_image = $HOST_NAME . $_SESSION["user_photo"];
                                        }
                                    ?>
                                    <img src="<?= $group_admin_image ?>" style="height:100px" alt="author">
                                </div>
                                <div class="author-content">
                                    <a href="#" class="h5 author-name"><?php echo $subject["name"]; ?></a>
                                    <div class="country"> کد گروه : <?php echo $subject["id"]  ?></div>
                                </div>
                            </div>

                            <div class="swiper-container-add_to_disable_class">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">

                                        <div class="control-block-button" data-swiper-parallax="-100">
                                            <!-- <a href="<?php echo $HOST_NAME; ?>users/post_management/<?php echo $subject["id"] ?>" class="btn  bg-green"> -->
                                            <a style="margin-right: 4px;" href="<?php echo $HOST_NAME; ?>group_admin/posts/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-primary" target="_blank">  
                                                 پستها
                                                 <i class="fa fa-file"></i>
                                                <!-- <svg class="olymp-blog-icon right-menu-icon">
                                                    <use xlink:href="#olymp-blog-icon"></use>
                                                </svg> -->
                                            </a>
                                     
                                            <a href="<?php echo $HOST_NAME; ?>group_admin/user_management/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-green" target="_blank"> 
                                                 کاربران
                                                 <i class="fa fa-users"></i>
                                                <!-- <svg class="olymp-happy-faces-icon right-menu-icon">
                                                    <use xlink:href="#olymp-happy-faces-icon"></use>
                                                </svg> -->
                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>/group_admin/statistics/<?php echo $subject["id"]  ?>" target="_blank" class="btn  bg-blue">
                                                آمار
                                                <i class="fa fa-tachometer" aria-hidden="true"></i>
                                                <!-- <svg class="olymp-stats-icon">
                                                    <use xlink:href="#olymp-stats-icon"></use>
                                                </svg> -->
                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>group_admin/subject_resources/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-blue" target="_blank"> 
                                                 منابع
                                                 <i class="fa fa-database"></i>
                                                <!-- <svg class="olymp-happy-faces-icon right-menu-icon">
                                                    <use xlink:href="#olymp-happy-faces-icon"></use>
                                                </svg> -->
                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>group_admin/crawler-sources/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-purple" target="_blank"> 
                                                 ربات
                                                 <i class="fa fa-cogs" aria-hidden="true"></i>
                                                <!-- <svg class="olymp-happy-faces-icon right-menu-icon">
                                                    <use xlink:href="#olymp-happy-faces-icon"></use>
                                                </svg> -->
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
</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
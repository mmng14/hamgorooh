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
					<h3>مدیریت گروهها و  پستها</h3>
				</div>
			</div>
		</div>
	</div>
	<!-- <img class="img-bottom" src="img/birthdays-bottom.png" alt="friends"> -->
</div>

<!-- <div class="container">
    <div class="row">
    <?php foreach ($subject_list as $subject) :  ?>
            <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="ui-block">
                    <div class="ui-block-title">
                        <h6 class="title"><?php echo $subject["name"];  ?></h6>
                    </div>
                </div>
            </div>
            <?php foreach ($category_list as $category) :   ?>
                <?php if ($category["subject_id"] == $subject["id"]) : ?>
                    <div class="col col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="ui-block">


               

                            <div class="birthday-item inline-items">
                                <div class="author-thumb">
                                    <img src="<?php echo $HOST_NAME . $category["photo"]  ?>" alt="<?php echo $category["name"]  ?>" width="50">
                                </div>
                                <div class="birthday-author-name">
                                    <a href="#" class="h6 author-name"><?php echo $category["name"]  ?> </a>
                                    <div class="birthday-date">کد : <?php echo $category["id"]  ?>, تعداد پست :<?php echo $category["post_count"]  ?></div>
                                </div>
                                <a href="<?php echo $HOST_NAME; ?>admin/posts/<?php echo $category["id"]  ?>" class="btn btn-sm bg-blue">مدیریت پستها</a>
                            </div>

        

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </div>
</div> -->


<div class="container">
    <div class="row">
        <?php foreach ($subject_list as $subject) : ?>
            <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="ui-block">

              

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
                                        <a href="#">گزارشات تخلف</a>
                                    </li>
                                    <li>
                                        <a href="#">نمایش درسایت</a>
                                    </li>
                         
                                </ul>
                            </div>
                            <div class="friend-avatar" style="text-align: center;">
                                <div class="author-thumb">
                                    <?php
                                        if (!isset($group_admin_image)){ 
                                            $group_admin_image =  $HOST_NAME . "/resources/assets/img/avatar1.jpg";
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
                                            <a style="margin-right: 4px;" href="<?php echo $HOST_NAME; ?>group_admin/posts/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-primary" target="_blank">  
                                                 پستها
                                                 <i class="fa fa-file"></i>

                                            </a>
                                     
                                            <a href="<?php echo $HOST_NAME; ?>group_admin/user_management/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-green" target="_blank"> 
                                                 کاربران
                                                 <i class="fa fa-users"></i>

                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>/group_admin/statistics/<?php echo $subject["id"]  ?>" target="_blank" class="btn  bg-blue">
                                                آمار
                                                <i class="fa fa-tachometer" aria-hidden="true"></i>

                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>admin/resources/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-blue" target="_blank"> 
                                                 منابع
                                                 <i class="fa fa-database"></i>

                                            </a>
                                            <a href="<?php echo $HOST_NAME; ?>admin/crawler-sources/<?php echo $subject["id"]  ?>" class="btn btn-xs btn-purple" target="_blank"> 
                                                 ربات
                                                 <i class="fa fa-cogs" aria-hidden="true"></i>

                                            </a>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

      
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/post_management.js"></script>
<div class="main-header">
    <div class="content-bg-wrap bg-birthday"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3>مدیریت پستها و کاربران</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- <img class="img-bottom" src="img/birthdays-bottom.png" alt="friends"> -->
</div>
<div class="container">
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


                            <!-- Birthday Item -->

                            <div class="birthday-item inline-items">
                                <div class="author-thumb">
                                    <img src="<?php echo $HOST_NAME . $category["photo"]  ?>" alt="<?php echo $category["name"]  ?>" width="50">
                                </div>
                                <div class="birthday-author-name">
                                    <a href="#" class="h6 author-name"><?php echo $category["name"]  ?> </a>
                                    <div class="birthday-date">کد : <?php echo $category["id"]  ?>, تعداد پست :<?php echo $category["post_count"]  ?></div>
                                </div>
                                <!-- <a href="<?php echo $HOST_NAME; ?>admin/posts/<?php echo $category["id"]  ?>" class="btn btn-sm bg-blue">مدیریت پستها</a> -->
                                <div  style="float: left;margin-top: -50px;">
                                    <a style="margin-right: 4px;" href="<?php echo $HOST_NAME; ?>group_admin/posts/<?php echo $category["id"]  ?>" class="btn btn-xs btn-primary" target="_blank"> مدیریت پستها </a>
                                    <a href="<?php echo $HOST_NAME; ?>group_admin/user_management/<?php echo $category["id"]  ?>" class="btn btn-xs btn-green" target="_blank"> مدیریت کاربران </a>
                                </div>

                            </div>

                            <!-- ... end Birthday Item -->

                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </div>
</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
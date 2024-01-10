<style>
    .user-photo {
        width: 130px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="main-header">
    <div class="content-bg-wrap bg-birthday"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3>مدیریت پستها من</h3>
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
                    <h6 class="title"><?php echo $user_subject["subject_name"];  ?></h6>
                    <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                    <a href="<?php echo $HOST_NAME; ?>users/teammates/<?php echo $user_subject["subject_id"]  ?>" class="btn btn-sm btn-green">اعضای گروه</a>
                    <a href="<?php echo $HOST_NAME; ?>users/user_groups" class="btn btn-sm btn-purple">بازگشت به گروههای من</a>
                </div>
            </div>
        </div>
        <?php foreach ($category_list as $category) :   ?>
     
                <div class="col col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="ui-block">
                        <?php
                        $user_role = 0;
                        foreach ($user_groups as $user_group_item) {

                            if ($user_group_item["group_id"] == $category["id"]) {
                                $user_role = $user_group_item["role"];
                            }
                        }
                        if ($user_role == 0) {
                            $role_name = " بدون دسترسی";
                        }
                        if ($user_role == 3) {
                            $role_name = " مدیر";
                        }
                        if ($user_role == 4) {
                            $role_name = " کاربر ویژه";
                        }
                        if ($user_role == 5) {
                            $role_name = " کاربر ساده";
                        }
                        ?>

                        <!-- Birthday Item -->

                        <div class="birthday-item inline-items">
                            <div class="author-thumb">
                                <img src="<?php echo $HOST_NAME . $category["photo"]  ?>" alt="<?php echo $category["name"]  ?>" width="50">
                            </div>
                            <div class="birthday-author-name">
                                <a href="#" class="h6 author-name"><?php echo $role_name  ?> </a>
                                <div class="birthday-date">کد : <?php echo $category["id"]  ?>, تعداد پست :<?php echo $category["post_count"]  ?></div>
                            </div>
                            <a href="<?php echo $HOST_NAME; ?>users/posts/<?php echo $category["id"]  ?>" class="btn btn-sm bg-blue" >پستهای من</a>

                        </div>

                        <!-- ... end Birthday Item -->

                    </div>
                </div>

        <?php endforeach; ?>
    </div>
</div>
<!-- /Content Wrapper. Contains page content -->
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/users/scripts/post_management.js"></script>
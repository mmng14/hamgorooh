<style>
    .user-photo {
        width: 130px;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 class="site-header"></h1>
        <ol class="breadcrumb">
            <li class="active"><a href="<?php echo $HOST_NAME ?>/index.php"><i class="fa fa-dashboard"></i>صفحه اصلی</a>
            </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Your Page Content Here -->
            <div class="col-md-12">
                <!-- USERS LIST -->
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"> اعضای گروه <?= $subject_name ?></h3>

                        <div class="box-tools pull-right">
                            <span class="label label-danger"><?= count($user_subjects) ?>  :  تعداد  </span>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding" style="display: block;">
                        <ul class="users-list clearfix">
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
                                    $user_role = "عضو ساده";
                                }

                                ?>
                                <li>
                                    <a class="users-list-name" href="<?= $HOST_NAME ?>/admin/user_info/<?= $user_subject['user_id'] ?>">
                                    <?php if (isset($user_photo) && $user_photo != ""): ?>
                                        <img class="user-photo" src="<?= $HOST_NAME; ?><?= $user_photo ?>"
                                             alt="<?= $user_full_name ?>">
                                    <?php else: ?>
                                        <img class="user-photo"
                                             src="<?php echo $HOST_NAME; ?>resources/shared/admin/img/user1-128x128.jpg"
                                             alt="<?= $user_full_name ?>">
                                    <?php endif ?>
                                    </a>

                                    <a class="users-list-name" href="<?= $HOST_NAME ?>/admin/user_info/<?= $user_subject['user_id'] ?>"><?= $user_full_name ?></a>
                                    <span class="users-list-date"><?= $user_role ?></span>
                                    <?php if($user_subject['user_id'] != $_SESSION["user_id"]): ?>
                                        <a href="<?= $HOST_NAME ?>/admin/user_chat/<?= $user_subject['user_id'] ?>">
                                        <span class="btn btn-success"><i class="fa fa-lg  fa-envelope-o"></i>   ارسال پیام  </span>
                                        </a>
                                    <?php  endif; ?>
                                </li>
                            <?php endforeach; ?>


                        </ul>
                        <!-- /.users-list -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-center" style="display: block;">
                        <a href="javascript:void(0)" class="uppercase">... </a>
                    </div>
                    <!-- /.box-footer -->
                </div>
                <!--/.box -->
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<!--<script src="--><?php //echo $HOST_NAME;  ?><!--app/admin/scripts/teammates.js"></script>-->
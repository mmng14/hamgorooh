<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Your Page Content Here -->
            <div class="row">

                <div class="col-md-6 col-md-offset-3">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header bg-aqua-active">
                            <h3 class="widget-user-username"><?= $user_full_name ?></h3>
                            <h5 class="widget-user-desc"><?= $user_type ?></h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" src="<?=  $HOST_NAME . $user_photo ?>" alt="<?= $user_full_name ?>">
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">120</h5>
                                        <span class="description-text">Posts</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5 class="description-header">5</h5>
                                        <span class="description-text">Groups</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5 class="description-header">35</h5>
                                        <span class="description-text">Rates</span>
                                    </div>
                                    <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                            <ul class="nav nav-stacked">
                                <li><a href="#"><span class="pull-left badge bg-blue"><?= $user_email ?></span>   ایمیل : </a></li>
                                <li><a href="#"> <span class="pull-left badge bg-aqua"><?= $user_phone ?></span>تلفن :</a></li>
                                <li><a href="#"> <span class="pull-left badge bg-green"><?= $user_mobile ?></span>موبایل :</a></li>
                                <li><a href="#"> <span class="pull-left badge bg-red"><?= $user_address ?></span>آدرس : </a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>
            </div>
        </div>
    </section>
    <br />

</div><!-- /.content-wrapper -->
<!-- page end-->
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/user_groups.js"></script>
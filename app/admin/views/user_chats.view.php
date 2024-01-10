<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Your Page Content Here -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <!-- DIRECT CHAT PRIMARY -->
                    <div class="box box-primary direct-chat direct-chat-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">چت</h3>

                            <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title=" پیغام جدید <?= $user_id ?>"
                                      class="badge bg-light-blue"><?= $logged_in_user ?></span>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="مخاطب"
                                        data-widget="chat-pane-toggle">
                                    <i class="fa fa-comments"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <!-- Conversations are loaded here -->
                            <div class="direct-chat-messages">
                                <?php foreach ($user_chats as $chat) : ?>
                                    <?php if ($chat["user_id"] == $logged_in_user) : ?>
                                        <!-- Message to the right -->
                                        <div class="direct-chat-msg right">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-right"><?= $chat['record_time']   ?></span>
                                                <span class="direct-chat-timestamp pull-left"><?= $logged_in_full_name   ?></span>
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img class="direct-chat-img" src="<?= $HOST_NAME . $logged_in_user_photo   ?>"
                                                 alt="User Image"><!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                <?= $chat['message']   ?>
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->
                                    <?php endif; ?>

                                    <?php if ($chat["user_id"] == $user_id) : ?>
                                        <!-- Message. Default to the left -->
                                        <div class="direct-chat-msg">
                                            <div class="direct-chat-info clearfix">
                                                <span class="direct-chat-name pull-left"><?= $chat['record_time']   ?></span>
                                                <span class="direct-chat-timestamp pull-right"><?= $user_full_name   ?></span>
                                            </div>
                                            <!-- /.direct-chat-info -->
                                            <img class="direct-chat-img" src="<?= $HOST_NAME . $user_photo ?>"
                                                 alt="User Image"><!-- /.direct-chat-img -->
                                            <div class="direct-chat-text">
                                                <?= $chat['message']   ?>
                                            </div>
                                            <!-- /.direct-chat-text -->
                                        </div>
                                        <!-- /.direct-chat-msg -->
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <!--/.direct-chat-messages-->

                            <!-- Contacts are loaded here -->
                            <div class="direct-chat-contacts">
                                <ul class="contacts-list">
                                    <li>
                                        <a href="#">
                                            <img class="contacts-list-img" src="<?= $HOST_NAME . $user_photo ?>"
                                                 alt="<?= $user_full_name ?>">

                                            <div class="contacts-list-info">
                                            <span class="contacts-list-name">
                                              <?= $user_full_name ?>
                                              <small class="contacts-list-date pull-right"></small>
                                            </span>
                                                <span class="contacts-list-msg"></span>
                                            </div>
                                            <!-- /.contacts-list-info -->
                                        </a>
                                    </li>
                                    <!-- End Contact Item -->
                                </ul>
                                <!-- /.contatcts-list -->
                            </div>
                            <!-- /.direct-chat-pane -->


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <form action="#" method="post">
                                <div class="input-group">
                                    <input type="text" id="chatMessage" name="chatMessage"
                                           placeholder="پیام خود را وارد نمایید ..." class="form-control">
                                    <span class="input-group-btn">
                        <button type="button" id="sendMessage" class="btn btn-primary btn-flat">ارسال</button>
                      </span>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-footer-->
                    </div>
                    <!--/.direct-chat -->
                </div>
            </div>
        </div>
    </section>
    <br/>

</div><!-- /.content-wrapper -->
<!-- page end-->
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/user_chats.js"></script>
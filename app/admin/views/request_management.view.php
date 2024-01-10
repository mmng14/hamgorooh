<div class="main-header">
    <div class="content-bg-wrap bg-birthday"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3>مدیریت درخواستهای عضویت</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- <img class="img-bottom" src="img/birthdays-bottom.png" alt="friends"> -->
</div>
<div class="container">
    <div class="row">
        <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />

        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title">لیست درخواستها</h6>
                </div>
            </div>
        </div>
        <?php foreach ($userSubjectViewModel as $user_subject_view) :   ?>

                <div class="col col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="ui-block">

                        <!-- Birthday Item -->

                        <div class="birthday-item inline-items" id="request_item_<?= $user_subject_view["id"]  ?>">
                            <div class="author-thumb">
                                <img src="<?php echo $HOST_NAME . $user_subject_view["photo"]  ?>" alt="<?php echo $user_subject_view["full_name"]  ?>" width="40">
                            </div>
                            <div class="birthday-author-name">
                                <a href="#" class="h6 author-name"><?php echo $user_subject_view["full_name"]  ?> </a>
                                <div class="birthday-date">گروه : <?php echo $user_subject_view["subject_name"]  ?> </div>
                                <!-- <div class="birthday-date">ایمیل : <?php echo $user_subject_view["email"]  ?> </div> -->
                            </div>

                            <div style="float: left;margin-top: 0px;">

                                <!-- <span class="notification-icon"> -->
                                <button onclick="acceptRequest(<?= $user_subject_view['id']  ?>)" data-request-id="<?= $user_subject_view["id"]  ?>" title="تایید درخواست" class="accept-request">
                                    <span class="icon-add without-text">
                                        <svg class="olymp-happy-face-icon">
                                            <use xlink:href="#olymp-happy-face-icon"></use>
                                        </svg>
                                    </span>
                                </button>

                                <button onclick="rejectRequest(<?= $user_subject_view['id']  ?>)" data-request-id="<?= $user_subject_view["id"]  ?>" title="رد درخواست" class="accept-request request-del">
                                    <span class="icon-minus">
                                        <svg class="olymp-happy-face-icon">
                                            <use xlink:href="#olymp-happy-face-icon"></use>
                                        </svg>
                                    </span>
                                </button>

                                <!-- </span> -->
                            </div>


                        </div>

                        <!-- ... end Birthday Item -->

                    </div>
                </div>
      
        <?php endforeach; ?>


    </div>
</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/request_management.js"></script>
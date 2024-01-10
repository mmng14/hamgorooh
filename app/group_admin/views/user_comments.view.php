<div class="main-header">
    <div class="content-bg-wrap bg-birthday"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                <h3>مدیریت نظرات کاربران</h3>
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
            <?php foreach ($viewModel as $item) :   ?>
                <?php if ($item["subject_id"] == $subject["id"]) : ?>
                    <div class="col col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="ui-block">

                            <!-- Birthday Item -->

                            <div class="birthday-item inline-items" id="post_item_<?= $item["subject_id"]  ?>_<?= $item["id"]  ?>">
                                <?php
                                $link_post_id =   $item['post_id'];
                                $link_post_id_length =  strlen($item['post_id']);
                                $link_subject_id =   $item['subject_id'];
                                $link_subject_id_length =  strlen($item['subject_id']);
                                $link_category_id =   $item['category_id'];
                                $link_category_id_length =  strlen($item['category_id']);
                                $link_post_name = "post-title";
                                $link_post_url = $HOST_NAME . "group_admin/show_post/{$link_subject_id_length}{$link_subject_id}{$link_category_id_length}{$link_category_id}{$link_post_id_length}{$link_post_id}/{$link_post_name}";
                                ?>
                                <div class="author-thumb">
                                    <img src="<?= $HOST_NAME ?>resources/assets/img/unknown_user.png" alt="<?php echo $item["author_name"]  ?>" width="40">
                                </div>
                                <div class="birthday-author-name">
                                    <a href="<?= $link_post_url ?>" class="h6 author-name"><?php echo $item["author_name"]  ?> </a>
                                    <div class="birthday-date"> <?php echo $item["content"]  ?> </div>
                                </div>

                                <div style="float: left;margin-top: 0px;">
                                    <a href="<?= $link_post_url ?>" title="نمایش پست" class="accept-request request-del" style="min-width: 40px;" >
                                      
                                           <i class="fa fa-2x fa-file"></i>
                                       
                                    </a>
                                    <!-- <span class="notification-icon"> -->
                                    <button onclick="acceptComment(<?= $item['subject_id']  ?>,<?= $item['id']  ?>)" data-subject-post-id="<?= $item['subject_id']  ?>_<?= $item['id']  ?>" title="تایید نظر" class="accept-request">
                                        <span class="icon-add without-text">
                                            <svg class="olymp-add-to-conversation-icon">
                                                <use xlink:href="#olymp-add-to-conversation-icon"></use>
                                            </svg>
                                        </span>
                                    </button>

                                    <button onclick="rejectComment(<?= $item['subject_id']  ?>,<?= $item['id']  ?>)" data-subject-post-id="<?= $item['subject_id']  ?>_<?= $item['id']  ?>" title="رد نظر" class="accept-request request-del">
                                        <span class="icon-minus">
                                            <svg class="olymp-block-from-chat-icon">
                                                <use xlink:href="#olymp-block-from-chat-icon"></use>
                                            </svg>
                                        </span>
                                    </button>

                                    <!-- </span> -->
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

<script src="<?php echo $HOST_NAME; ?>app/group_admin/scripts/user_comments.js"></script>
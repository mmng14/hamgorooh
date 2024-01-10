<div class="main-header">
    <div class="content-bg-wrap bg-birthday"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3>نمایش پست</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- <img class="img-bottom" src="img/birthdays-bottom.png" alt="friends"> -->
</div>

<div class="container">
    <div class="row">
        <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />

        <div class="col col-xl-12 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">
            <div id="newsfeed-items-grid">

                <div class="ui-block">
                    <!-- Post -->

                    <article class="hentry post">

                        <div class="post__author author vcard inline-items">
                            <img alt="author" src="<?= $HOST_NAME . "resources/assets/" ?>img/friend-harmonic7.jpg" class="avatar">
                            <div class="author-date">
                                <a class="h6 post__author-name fn" href="#"> <?= $post['user_full_name'] ?></a>
                                <div class="post__date">
                                    <time class="published" datetime=" <?= $post['reg_date'] ?>">
                                    <?= $post['reg_date'] ?>
                                    </time>
                                </div>
                            </div>

                            <div class="more">
                                <svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg>
                                <ul class="more-dropdown">
                                    <li>
                                        <a href="<?php echo $HOST_NAME; ?>group_admin/post_add/<?= $post['category_id'] ?>/<?= $post['id'] ?>">ویرایش پست</a>
                                    </li>
                                    <li>
                                        <a  style="cursor:pointer ;" onclick="deletePost(<?= $post['subject_id']  ?>,<?= $post['id']  ?>)">حذف پست</a>
                                    </li>
                                    <li>
                                        <a style="cursor:pointer ;" onclick="acceptPost(<?= $post['subject_id']  ?>,<?= $post['id']  ?>)" >تایید پست</a>
                                    </li>
                                    <li>
                                        <a style="cursor:pointer ;" onclick="rejectPost(<?= $post['subject_id']  ?>,<?= $post['id']  ?>)">رد پست</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $HOST_NAME; ?>group_admin/user_posts/">بازگشت به پستهای کاربران</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <h4> <?= $post['title'] ?> </h4>
                        <p> <?= $post['brief_description'] ?> </p>
                        <div class="post-thumb">
								<img src="<?= $photo_address ?>" alt="photo">
							</div>
                        <p>
                        <?php echo htmlspecialchars_decode(str_replace("http://www.hamgorooh.com", "https://www.hamgorooh.com", $post_content['content']));   ?>
                        </p>

           

                    </article>

                    <!-- .. end Post -->
                </div>


                <a id="load-more-button" href="#" class="btn btn-control btn-more" data-load-link="items-to-load.html" data-container="newsfeed-items-grid">
                    <svg class="olymp-three-dots-icon">
                        <use xlink:href="#olymp-three-dots-icon"></use>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
    </script>
    <script src="<?php echo $HOST_NAME; ?>app/group_admin/scripts/show_post.js"></script>
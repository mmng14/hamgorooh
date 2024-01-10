<div class="container">

    <div class="page-breadcrumbs" >
        <h1 class="section-title">

                <ul class="list-inline " >
                    <?php  if(isset($subject_name)) : ?>
                        <li><a href="<?php echo $HOST_NAME. "subject/". "{$subject_id_length}{$subject_id}/" . $subject_url_name;   ?>"><?php if(isset($subject_name)) echo $subject_name;   ?></a></li>
                    <?php  endif; ?> /
                    <?php  if(isset($category_name)) : ?>
                        <li><a href="<?php echo $HOST_NAME. "category/" .  "{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}/". $category_url_name;   ?>" ><?php if(isset($category_name)) echo $category_name;   ?></a></li>
                    <?php  endif; ?> /
                    <?php  if(isset($subcategory_name)) : ?>
                        <li><a href="<?php echo $HOST_NAME. "subcategory/" . "{$subject_id_length}{$subject_id}{$category_id_length}{$category_id}{$subcategory_length}{$subcategory_id}/". $subcategory_url_name;   ?>"><?php if(isset($subcategory_name)) echo $subcategory_name;   ?></a></li>
                    <?php  endif; ?>
                    <li class="active"><a href="<?php  echo $share_link   ?>" rel="<?php  echo $post['title'];   ?>"><?php  echo $post['title'];   ?></a></li>

                </ul>


        </h1>

    </div>

    <form id="visit_form">
        <input type="hidden" id="afid" value="" />
        <input type="hidden" id="sid" value="<?php echo $post['subject_id'];  ?>" />
        <input type="hidden" id="cid" value="<?php echo $post['category_id'];  ?>" />
        <input type="hidden" id="scid" value="<?php echo $post['sub_category_id'];  ?>" />
        <input type="hidden" id="pid" value="<?php echo $post['id'];  ?>" />
        <input type="hidden" id="puid" value="<?php echo $post['user_id'];  ?>" />
    </form>

    <div class="section">
        <div class="row">
            <div class="col-sm-9">
                <div id="site-content" class="site-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="left-content">
                                <div class="details-news">
                                    <div class="post">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="<?php  echo $photo_address   ?>" alt="<?php  echo $post['title'];   ?>"/>
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <div class="entry-meta">
                                                <ul class="list-inline">
                                                    <li class="posted-by"><i class="fa fa-user"></i> <a></a><?php  echo $post['user_full_name'];   ?></a></li>
                                                    <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i>
                                                            <?php echo $post['reg_date'];  ?> </a></li>
                                                    <li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>
                                                    <li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a>
                                                    </li>
                                                    <li class="comments"><i class="fa fa-comment-o"></i><a
                                                                href="#">189</a></li>
                                                </ul>
                                            </div>
                                            <h2 class="entry-title">
                                                <?php  echo $post['title'];   ?>
                                            </h2>
                                            <div class="entry-content">

                                                <?php  echo htmlspecialchars_decode(str_replace("http://www.hamgorooh.com","https://www.hamgorooh.com",$post_content['content']));   ?>

                                                <ul class="list-inline share-link">

                                                    <li><a class="facebook" href="<?php  echo "http://www.facebook.com/share.php?v=4&src=bm&u={$share_link}";   ?>"><i class="fa fa-facebook"></i>Facebook</a> </li>
                                                    <li><a class="twitter" href="<?php  echo "http://twitter.com/home?status={$share_link}"; ?>"><i class="fa fa-twitter"></i>Twitter</a></li>
                                                    <li><a class="googleplus" href="<?php  echo "http://plus.google.com/share?url={$share_link}"; ?>"><i class="fa fa-google-plus"></i>Google+</a></li>
                                                    <li><a class="linkedin" href="<?php  echo "https://www.linkedin.com/shareArticle?mini=true&url={$share_link}&title={$page_title}&summary={$page_description}"; ?>"><i class="fa fa-linkedin"></i>LinkedIn</a></li>
                                                    <li><a class="twitter" href="<?php  echo "https://t.me/share/url?url={$share_link}"; ?>"><i class="fa fa-send-o"></i>Telegram</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div><!--/post-->
                                </div><!--/.section-->
                            </div><!--/.left-content-->
                        </div>


                    </div>
                </div><!--/#site-content-->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="post google-add">

                                <div class="row ads">
                                    <div class="col-sm-3">
                                        <div style="height: 200px;width: 100%;overflow: hidden;">
                                            <?php echo $home_page["ads1"]; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div style="height: 200px;width: 100%;overflow: hidden;">
                                            <?php echo $home_page["ads2"]; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div style="height: 200px;width: 100%;overflow: hidden;">
                                            <?php echo $home_page["ads3"]; ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div style="height: 200px;width: 100%;overflow: hidden;">
                                            <?php echo $home_page["ads4"]; ?>
                                        </div>
                                    </div>
                                </div>

                        </div><!--/.google-add-->



                        <div class="section " >
                            <h1 class="section-title">مطالب بیشتر</h1>
                            <div class="row items-right-side">
                                <?php foreach($similar_posts as $similar_post) : ?>
                                <?php
                                $similar_post_id =   $similar_post['id'];
                                $similar_post_id_length =  strlen($similar_post['id']);
                                $similar_subject_id =   $similar_post['subject_id'];
                                $similar_subject_id_length =  strlen($similar_post['subject_id']);
                                $similar_category_id =   $similar_post['category_id'];
                                $similar_category_id_length =  strlen($similar_post['category_id']);
                                $similar_post_name = $similar_post['post_name'];
                                $similar_post_title = $similar_post['title'];
                                $similar_post_date= $similar_post['reg_date'];
                                if($similar_subject_id==16) {
                                    $similar_post_url = $HOST_NAME . "news/{$requested_year}{$similar_subject_id_length}{$similar_subject_id}{$similar_category_id_length}{$similar_category_id}{$similar_post_id_length}{$similar_post_id}/{$similar_post_name}";
                                }
                                else
                                {
                                    $similar_post_url = $HOST_NAME . "news/{$similar_subject_id_length}{$similar_subject_id}{$similar_category_id_length}{$similar_category_id}{$similar_post_id_length}{$similar_post_id}/{$similar_post_name}";
                                }
                                $similar_post_brief_description = trim($similar_post['brief_description']);
                                $similar_photo_address = htmlspecialchars(strip_tags($similar_post['thumb_address']));
                                if(strpos(strtolower($similar_photo_address), 'http')=== false) {
                                    $similar_photo_address = $HOST_NAME.$similar_photo_address;
                                }

                                if ($similar_photo_address=="" || $similar_photo_address==$HOST_NAME)
                                {
                                    $similar_photo_address = $HOST_NAME. "resources/shared/images/no_pic_image.jpg";
                                }
                                $similar_photo_address = str_replace("http://www.hamgorooh.com","https://www.hamgorooh.com",$similar_photo_address);

                                ?>
                                <div class="col-sm-4">
                                    <div class="post medium-post">
                                        <div class="entry-header">
                                            <div class="entry-thumbnail">
                                                <img class="img-responsive" src="<?php echo  $similar_photo_address  ?>" alt="<?php echo  $similar_post_title;  ?>"/>
                                            </div>
                                        </div>
                                        <div class="post-content">
                                            <div class="entry-meta">
                                                <ul class="list-inline">
                                                    <li class="publish-date"><a href="#"><i class="fa fa-clock-o"></i>
                                                            <?php echo  $similar_post_date;  ?></a></li>
<!--                                                    <li class="views"><a href="#"><i class="fa fa-eye"></i>15k</a></li>-->
<!--                                                    <li class="loves"><a href="#"><i class="fa fa-heart-o"></i>278</a>-->
                                                    </li>
                                                </ul>
                                            </div>

                                            <h2 class="entry-title">
                                                <a href="<?php echo  $similar_post_url;  ?>"><?php echo  $similar_post_title;  ?></a>
                                            </h2>
                                        </div>
                                    </div><!--/post-->
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div><!--/.section -->
                    </div>
                </div>
            </div><!--/.col-sm-9 -->

            <div class="col-sm-3">
                <div id="sitebar">
                    <div class="widget">
                        <div class="add featured-add">
                            <?php echo $home_page["ads"]; ?>
                        </div>
                    </div><!--/#widget-->

                    <div class="widget follow-us">
                        <h1 class="section-title title"> شبکه های اجتماعی </h1>
                        <ul class="list-inline social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div><!--/#widget-->

                    <div class="widget">
                        <h1 class="section-title title">آخرین اخبار</h1>
                        <ul class="post-list">
                            <?php echo $home_page["popular_posts"]; ?>
                        </ul>
                    </div><!--/#widget-->
                </div><!--/#sitebar-->
            </div>
        </div>
    </div><!--/.section-->
</div><!--/.container-->


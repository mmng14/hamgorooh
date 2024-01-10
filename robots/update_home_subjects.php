<?php
include_once '../core/dblayer_mysqli.php';
include_once '../libraries/phpfunction.php';
include_once '../libraries/jdf.php';
include_once '../libraries/sanitize_title.php';
include_once '../libraries/telegram.class.php';
include_once '../libraries/image_resize.class.php';

//Connect to the DataBase
Connect();
$today = jdate('Y/m/d');
//Create Main Page Subjects Posts
$subject = select('subject', '*', "status=1 AND update_date <> '{$today}' AND id <> 16 AND top_menu=1", "LIMIT 1");
$subject_name = "";
if (isset($_SESSION["dblayer_error"])) {
    echo $_SESSION["dblayer_error"];
}

if ($subject) {

    $subj_id = $subject[0]["id"];
    $subj_name = $subject[0]["name"];
    $url_name = $subject[0]["url_name"];
    $subject_link =  $HOST_NAME . "subject/". strlen($subj_id) . $subj_id . "/" . $url_name;
    echo $subj_id . "<br/>";
    echo $subj_name . "<br/>";

    $msg = Delete("home_subjects", "subject_id={$subj_id}");
    $search = select('home_subjects', '*', "subject_id={$subj_id}", "LIMIT 1");
    if (!$search) {
        $subject_posts = "";
        $top_post = "";
        list($top_post, $subject_posts,$top_post_title,$top_post_reg_date,$top_post_brief_description,$top_post_photo_address,$top_post_link_address,$top_post_comment_count,$top_post_like_count) = create_subject_posts($subj_id, $HOST_NAME, $subj_name,$subject_link);
        $top_post = htmlspecialchars($top_post);
        $subject_posts = htmlspecialchars($subject_posts);
        $property = array('NULL', $subj_id, $subject[0]['name'], $subject_posts, $top_post, "$today", $subject[0]['url_name'],$top_post_title,$top_post_reg_date,$top_post_brief_description,$top_post_photo_address,$top_post_link_address,$top_post_comment_count,$top_post_like_count, $subject[0]['ordering'], 1);
        $new_id = insert('home_subjects', $property);
        $msg = update("subject", "update_date='{$today}'", "id={$subj_id}");
        echo $new_id . "<br/>";
    }


    if (isset($_SESSION["dblayer_error"])) {
        echo $_SESSION["dblayer_error"];
    } else {

        echo "Done !";
    }
} else {
    $msg = update("subject", "update_date='1358/07/20'", "id <> 16");
}


//functions 
function create_subject_posts($subjectId, $HOST_NAME, $subject_name,$subject_link)
{
    include "../core/config.php";
    include "../core/NotORM.php";
    Connect();
    $top_post = "";

    $subject_id = $subjectId;

    $item_comment_count = "0";
    $item_photo_address = $item_title = $item_brief_description = $item_reg_date = "";
    if (isset($HCD_DB_ARR[$subjectId])) {
        $SUBJECT_SERVER = $HCD_DB_ARR[$subjectId][0];
        $SUBJECT_DB_NAME = $HCD_DB_ARR[$subjectId][1];
        $SUBJECT_DB_USER = $HCD_DB_ARR[$subjectId][2];
        $SUBJECT_DB_PASS = $HCD_DB_ARR[$subjectId][3];

        echo $SUBJECT_DB_NAME . "<br/>";
        $dsn_subject = "mysql:dbname=$SUBJECT_DB_NAME;host=$SUBJECT_SERVER;charset=utf8";
        $GLOBALS["db_pdo_subject"] = new PDO($dsn_subject, "$SUBJECT_DB_USER", "$SUBJECT_DB_PASS");

        function db_subject()
        {
            return new NotORM($GLOBALS["db_pdo_subject"]);
        }

    }

    $posts = db_subject()->post()
        ->select("id,subject_id,category_id,sub_category_id,title,post_name,photo_address,thumb_address,brief_description,reg_date,user_full_name,comment_count,like_count")
        ->where("subject_id = ?", $subject_id)
        ->where("status = ?", 1)
        ->order("id desc")
        ->limit(3);

    $item = array();
    $x = 0;
    foreach ($posts as $post) {
        echo "YES" . "<br/>";
        $item[$x] = $post;
        echo $item[$x]["title"] . "<br/>";
        $x++;
    }

    $group_posts = "";
    if ( isset($item) && count($item))
    {


        $group_posts .= "<div class=\"col-md-6 col-sm-6\">
                            <div class=\"section health-section\">
											<h3 class=\"section-title\">{$subject_name}</h3>
											<div class=\"cat-menu\">         
												<a href=\"{$subject_link}\">نمایش همه</a>					
											</div>
						  <div class=\"health-feature\">";

        if (isset($item[0]["id"])) {
            $item_photo_address = htmlspecialchars(strip_tags($item[0]['photo_address']));
            $slider_photo_address = $item_photo_address;
            if (strpos(strtolower($item_photo_address), 'http') === false) {
                $item_photo_address = $HOST_NAME . $item_photo_address;
                $slider_photo_address =  $item_photo_address;
            }

            if (@getimagesize($item_photo_address) === false) {
                $item_photo_address = $HOST_NAME . "resources/shared/images/no_pic_image.jpg";
                $slider_photo_address =  $item_photo_address;
            } else {
                //--Resizing the photo for firstpage-----
                $photoGUID = GUIDv4();

                $image = new ResizeImage();
                $image->load($item_photo_address);
                $image->resizeToWidth(350);
                $firstpage_photo = "uploads/firstpage/firstpage_{$photoGUID}.jpg";
                $image->save("../{$firstpage_photo}");
                $item_photo_address = $HOST_NAME . $firstpage_photo;

                //This code dose not work
                $image_slider = new ResizeImage();
                $image_slider->load($slider_photo_address);
                $image_slider->resizeToHeight(400);
                $firstpage_slider_photo = "uploads/firstpage/firstpage_slider_{$photoGUID}.jpg";
                $image_slider->save("../{$firstpage_slider_photo}");
                $slider_photo_address =  $HOST_NAME . $firstpage_slider_photo;

            }
            $main_subj_id = $item[1]["subject_id"];
            $main_cat_id = $item[1]["category_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);

            $post_id_length = strlen($item[0]['id']);
            $subcategory_id_length = 0;
            $subcategory_id = "";
            if ($item[0]['sub_category_id'] != null && $item[0]['sub_category_id'] != 0) {
                $subcategory_id_length = strlen($item[0]['sub_category_id']);
                $subcategory_id = $item[0]['sub_category_id'];
            }

            $item_link_address = $HOST_NAME . "post/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$item[0]["id"]}/" . $item[0]["post_name"];
            $item_title = $item[0]["title"];
            $item_brief_description = $item[0]["brief_description"];
            $item_reg_date = $item[0]["reg_date"];
            $item_comment_count = $item[0]["comment_count"];
            $item_like_count = $item[0]["like_count"];
            
            $top_post_photo_address=$slider_photo_address;
            $top_post_link_address=$item_link_address ;
            $top_post_title=$item_title;
            $top_post_brief_description=$item_brief_description;
            $top_post_reg_date=$item_reg_date;
            $top_post_comment_count=$item_comment_count;
            $top_post_like_count=$item_like_count;


            $group_posts .= "	<div class=\"post main-subject\">
													<div class=\"entry-header\">
														<div class=\"entry-thumbnail\">
														<a href=\"{$item_link_address}\">
															<img class=\"img-responsive\" src=\"{$item_photo_address}\" alt=\"{$item_title}\">
														</a>	
														</div>
													</div>
													<div class=\"post-content\">								
														<div class=\"entry-meta\">
															<ul class=\"list-inline\">
																<li class=\"publish-date\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i> {$item_reg_date}</a></li>

															</ul>
														</div>
														<h2 class=\"entry-title\">
															<a href=\"{$item_link_address}\">{$item_title}</a>
														</h2>
													</div>
												</div><!--/post--> ";

            $top_post .= "<div class=\"post medium-post\">
                <div class=\"entry-header\">
                    <div class=\"entry-thumbnail\">
                        <a href=\"{$item_link_address}\">
                            <img class=\"img-responsive latest-post-image\" src=\"{$item_photo_address}\" alt=\"{$item_title}\" />
                        </a>
                    </div>
                    <div class=\"catagory health\"><span><a href=\"#\">{$subject_name}</a></span></div>
                </div>
                <div class=\"post-content\">
                    <div class=\"entry-meta\">
                        <ul class=\"list-inline\">
                            <li class=\"publish-date\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i> Nov 5, 2015 </a></li>
                            <li class=\"views\"><a href=\"#\"><i class=\"fa fa-eye\"></i>15k</a></li>
                            <li class=\"loves\"><a href=\"#\"><i class=\"fa fa-heart-o\"></i>278</a></li>
                        </ul>
                    </div>
                    <h2 class=\"entry-title\">
                        <a href=\"{$item_link_address}\">
                           {$item_title}
                        </a>
                    </h2>
                </div>
            </div><!--/post-->";
        }

        $group_posts .= " </div>
							<div class=\"row\">";


        if (isset($item[1]["id"])) {
            $item_comment_count = "0";
            $item_photo_address = $item_title = $item_brief_description = $item_reg_date = "";
            $item_photo_address = htmlspecialchars(strip_tags($item[1]['thumb_address']));
            if (strpos(strtolower($item_photo_address), 'http') === false) {
                $item_photo_address = $HOST_NAME . $item_photo_address;
            }

            if (@getimagesize($item_photo_address) === false) {
                $item_photo_address = $HOST_NAME . "resources/shared/images/no_pic_image.jpg";
            }

            $main_subj_id = $item[1]["subject_id"];
            $main_cat_id = $item[1]["category_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);
            $post_id_length = strlen($item[1]['id']);
            $subcategory_id_length = 0;
            $subcategory_id = "";
            if ($item[1]['sub_category_id'] != null && $item[1]['sub_category_id'] != 0) {
                $subcategory_id_length = strlen($item[1]['sub_category_id']);
                $subcategory_id = $item[1]['sub_category_id'];
            }

            $item_link_address = $HOST_NAME . "post/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$item[1]["id"]}/" . $item[1]["post_name"];
            $item_title = $item[1]["title"];
            $item_brief_description = $item[1]["brief_description"];
            $item_reg_date = $item[1]["reg_date"];
            $item_comment_count = $item[1]["comment_count"];


            $group_posts .= " <div class=\"col-sm-12 col-md-6\">
													<div class=\"post small-post small-post-subject \">
														<div class=\"entry-header\">
															<div class=\"entry-thumbnail\">
																<a href=\"{$item_link_address}\">
																    <img class=\"img-responsive\" src=\"{$item_photo_address}\" alt=\"{$item_title}\">
																</a>
															</div>
														</div>
														<div class=\"post-content\">								
															<div class=\"entry-meta\">
																<ul class=\"list-inline\">
																	<li class=\"publish-date small-font\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i>{$item_reg_date} </a></li>
																</ul>
															</div>
															<h2 class=\"entry-title small-post-entry-title\">
																<a href=\"{$item_link_address}\">{$item_title}</a>
															</h2>
														</div>
													</div><!--/post--> 									
												</div>";

        }

        if (isset($item[2]["id"])) {
            $item_comment_count = "0";
            $item_photo_address = $item_title = $item_brief_description = $item_reg_date = "";
            $item_photo_address = htmlspecialchars(strip_tags($item[2]['thumb_address']));
            if (strpos(strtolower($item_photo_address), 'http') === false) {
                $item_photo_address = $HOST_NAME . $item_photo_address;
            }
            if (@getimagesize($item_photo_address) === false) {
                $item_photo_address = $HOST_NAME . "resources/shared/images/no_pic_image.jpg";
            }
            $main_subj_id = $item[2]["subject_id"];
            $main_cat_id = $item[2]["category_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);
            $post_id_length = strlen($item[2]['id']);
            $subcategory_id_length = 0;
            $subcategory_id = "";
            if ($item[2]['sub_category_id'] != null && $item[2]['sub_category_id'] != 0) {
                $subcategory_id_length = strlen($item[2]['sub_category_id']);
                $subcategory_id = $item[2]['sub_category_id'];
            }

            $item_link_address = $HOST_NAME . "post/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$item[2]["id"]}/" . $item[2]["post_name"];
            $item_title = $item[2]["title"];
            $item_brief_description = $item[2]["brief_description"];
            $item_reg_date = $item[2]["reg_date"];
            $item_comment_count = $item[2]["comment_count"];

            $group_posts .= " <div class=\"col-sm-12 col-md-6\">
													<div class=\"post small-post small-post-subject\">
														<div class=\"entry-header\">
															<div class=\"entry-thumbnail\">
															    <a href=\"{$item_link_address}\">
																    <img class=\"img-responsive\" src=\"{$item_photo_address}\" alt=\"{$item_title}\">
																</a>
															</div>
														</div>
														<div class=\"post-content\">								
															<div class=\"entry-meta\">
																<ul class=\"list-inline\">
																	<li class=\"publish-date small-font\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i> {$item_reg_date} </a></li>
																</ul>
															</div>
															<h2 class=\"entry-title small-post-entry-title\">
																<a href=\"{$item_link_address}\">{$item_title}</a>
															</h2>
														</div>
													</div><!--/post--> 									
												</div>";


        }


        $group_posts .= " 	</div>
						</div>
				   </div>";

    }


    $test_posts = "<div class=\"col-md-6 col-sm-6\">
                            <div class=\"section health-section\">
											<h1 class=\"section-title\">Health</h1>
											<div class=\"cat-menu\">         
												<a href=\"listing-life-style.html\">See all</a>					
											</div>
											<div class=\"health-feature\">
												<div class=\"post\">
													<div class=\"entry-header\">
														<div class=\"entry-thumbnail\">
															<img class=\"img-responsive\" src=\"http://localhost:8080/hamgorooh/resources/public/images/post/health/1.jpg\" alt=\"\">
														</div>
													</div>
													<div class=\"post-content\">								
														<div class=\"entry-meta\">
															<ul class=\"list-inline\">
																<li class=\"publish-date\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i> Nov 15, 2015 </a></li>
																<li class=\"views\"><a href=\"#\"><i class=\"fa fa-eye\"></i>15k</a></li>
																<li class=\"loves\"><a href=\"#\"><i class=\"fa fa-heart-o\"></i>278</a></li>
															</ul>
														</div>
														<h2 class=\"entry-title\">
															<a href=\"news-details.html\">HealthNews Salutes: Direct Relief International</a>
														</h2>
													</div>
												</div><!--/post--> 
											</div>
											<div class=\"row\">
												<div class=\"col-sm-12 col-md-6\">
													<div class=\"post small-post\">
														<div class=\"entry-header\">
															<div class=\"entry-thumbnail\">
																<img class=\"img-responsive\" src=\"http://localhost:8080/hamgorooh/resources/public/images/post/health/2.jpg\" alt=\"\">
															</div>
														</div>
														<div class=\"post-content\">								
															<div class=\"entry-meta\">
																<ul class=\"list-inline\">
																	<li class=\"publish-date\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i> Nov 15, 2015 </a></li>
																</ul>
															</div>
															<h2 class=\"entry-title\">
																<a href=\"news-details.html\">EBreakfast Cereal: The Marketing of Sugar</a>
															</h2>
														</div>
													</div><!--/post--> 									
												</div>
												<div class=\"col-sm-12 col-md-6\">
													<div class=\"post small-post\">
														<div class=\"entry-header\">
															<div class=\"entry-thumbnail\">
																<img class=\"img-responsive\" src=\"http://localhost:8080/hamgorooh/resources/public/images/post/health/4.jpg\" alt=\"\">
															</div>
														</div>
														<div class=\"post-content\">								
															<div class=\"entry-meta\">
																<ul class=\"list-inline\">
																	<li class=\"publish-date\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i> Nov 15, 2015 </a></li>
																</ul>
															</div>
															<h2 class=\"entry-title\">
																<a href=\"news-details.html\">Aerobic Exercise: The Best Weapon</a>
															</h2>
														</div>
													</div><!--/post--> 											
												</div>
											</div>
										</div>
								</div>";
//   return $test_posts;

    return array($top_post, $group_posts,$top_post_title,$top_post_reg_date,$top_post_brief_description,$top_post_photo_address,$top_post_link_address,$top_post_comment_count,$top_post_like_count);
    // return $group_posts;
}





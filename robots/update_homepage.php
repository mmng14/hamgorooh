<?php
include_once '../core/dblayer_mysqli.php';
include_once '../libraries/phpfunction.php';
include_once '../libraries/jdf.php';
include_once '../libraries/sanitize_title.php';
include_once '../libraries/telegram.class.php';


//Connect to the DataBase
Connect();

/******* Get Categories AND SubCategories ******/
$subject_list = select('subject', 'id,name,url_name,photo,has_category,top_menu,has_header,is_custom', "status=1", "order by ordering ASC");
$category_list = select('category', 'id,name,url_name,photo,subject_id,has_sub,sub_count,has_header,data_name,is_custom,telegram_link', "status=1", "order by sub_count desc");
$sub_category_list = select('sub_category', 'id,name,url_name,photo,subject_id,category_id', "status=1", "order by name ASC");


//region Menus
$menus = "<nav id=\"mainmenu\" class=\"navbar-left collapse navbar-collapse\">
                    <ul class=\"nav navbar-nav\">";
foreach ($subject_list as $subject) {
    //    $menus .="<li class=\"dropdown\"> <a href=\"#\" class=\"\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">" .$subject['name'] . "</a>
    //              <ul class=\"dropdown-menu\" role=\"menu\">";

    $menus .= " <li class=\"home dropdown\"><a href=\"javascript:void(0);\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">" . $subject['name'] . "</a>
                  <ul class=\"dropdown-menu\">";

    foreach ($category_list as $category) {
        if ($category["subject_id"] == $subject["id"]) {
            $main_cat_id = $category["id"];
            $main_subj_id = $category["subject_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);
            //            $menus .="<li><a href=\"". $HOST_NAME. "category/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}/{$category['url_name']}" ."\">". $category["name"]  . "</a></li>";
            $menus .= "<li><a href=\"" . $HOST_NAME . "category/{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}/{$category['url_name']}" . "\">" . $category["name"] . "</a></li>";
        }
    }
    $menus .= "</ul></li>";
}
$menus .= " </ul></nav>";
//endregion Menus

//region SubjectContent
$subject_contents = "";
$recent_posts = "";

$home_subject_list = select('home_subjects', 'id,subject_id,subject_title,content,top_post', "status=1", "");
foreach ($home_subject_list as $home_subject) {
    $subject_contents .= $home_subject["content"];
    //$recent_posts.= $home_subject["top_post"];
}
//endregion SubjectContent

//region Reportage
$home_reportage_list = select('reportage', 'id,subject_id,category_id,sub_category_id,post_code,title,thumb_address,photo_address,link_address,post_date', "status=1", " ORDER BY id");
$recent_posts="";
foreach ($home_reportage_list as $home_reportage) {
    $subject_name = "";
    $item_title = $home_reportage["title"];
    $item_link_address = $home_reportage["link_address"];
    $item_photo_address = $home_reportage["photo_address"];
    $item_date = $home_reportage["post_date"];
    foreach ($subject_list as $subject) {
        if ($subject["id"] == $home_reportage["subject_id"]) {
            $subject_name = $subject["name"];
        }
    }

    $recent_posts .= "<div class=\"post medium-post\">
                <div class=\"entry-header\">
                    <div class=\"entry-thumbnail\">
                        <img class=\"img-responsive latest-post-image\" src=\"{$item_photo_address}\" alt=\"{$item_title}\" />
                    </div>
                    <div class=\"catagory health\"><span><a href=\"#\">{$subject_name}</a></span></div>
                </div>
                <div class=\"post-content\">
                    <div class=\"entry-meta\">
                        <ul class=\"list-inline\">
                            <li class=\"publish-date\"><a href=\"#\"><i class=\"fa fa-clock-o\"></i>{$item_date} </a></li>                        
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

//endregion Reportage

//region Gallery
$gallery_contents = "";
$home_gallery_list = select('gallery', 'id,title,link,photo,ordering', "status=1", " ORDER BY id DESC LIMIT 8");
foreach ($home_gallery_list as $home_gallery) {
    $gallery_contents .= " <li><a href=\"{$HOST_NAME}{$home_gallery['photo']}\" class=\"image-link\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$home_gallery['photo']}\" alt=\"{$home_gallery['title']}\" /></a></li>";
}
//endregion Gallery

//region Ads
$ads1 = "";
date_default_timezone_set('Asia/Tehran');
$today_date = convertPersianToEng(jdate('Y/m/d'));
$today_date_num = (int) str_replace("/", "", $today_date);
$home_ad_type1 = select('ads', '*', "status=1 AND  type=1   ", " ORDER BY id DESC LIMIT 1");
if ($home_ad_type1) {
    $ads1 = "<a  target=\"_blank\" href=\"{$home_ad_type1[0]["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$home_ad_type1[0]["photo"]}\" alt=\"\"></a>";
}
if (isset($_SESSION["dblayer_error"])) {
    echo $_SESSION["dblayer_error"];
} else {
    echo $today_date_num . "<br/>";
    var_dump($home_ad_type1);
}
$ads2 = "";
$home_ad_type2 = select('ads', '*', "status=1 AND  type=2 AND start_date_num <= {$today_date_num}  AND end_date_num >=  {$today_date_num}   ", " ORDER BY id DESC LIMIT 1");
if ($home_ad_type2 && isset($home_ad_type2[0])) {
    $ads2 = "<a target=\"_blank\" href=\"{$home_ad_type2[0]["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$home_ad_type2[0]["photo"]}\" alt=\"\"  ></a>";
}

$ads3 = "";
$home_ad_type3 = select('ads', '*', "status=1 AND  type=3 AND start_date_num <= {$today_date_num}  AND end_date_num >=  {$today_date_num}   ", " ORDER BY id DESC LIMIT 1");
if ($home_ad_type3 && isset($home_ad_type3[0])) {
    $ads3 = "<a  target=\"_blank\" href=\"{$home_ad_type3[0]["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$home_ad_type3[0]["photo"]}\" alt=\"\"></a>";
}

$ads4 = "";
$home_ad_type4 = select('ads', '*', "status=1 AND  type=4 AND start_date_num <= {$today_date_num}  AND end_date_num >=  {$today_date_num}   ", " ORDER BY id DESC LIMIT 1");
if ($home_ad_type4 && isset($home_ad_type4[0])) {
    $ads4 = "<a  target=\"_blank\" href=\"{$home_ad_type4[0]["link_address"]}\"><img class=\"img-responsive\" src=\"{$HOST_NAME}{$home_ad_type4[0]["photo"]}\" alt=\"\"></a>";
}

//endregion Ads

//region Slider


$slider_list = select('home_subjects', 'id,subject_id,subject_title,top_post_title,top_post_date,top_post_brief,top_post_photo,top_post_link,top_post_comments,top_post_likes', "status=1", "order by top_post_date DESC LIMIT 6");

$slider = "";
foreach ($slider_list as $slider_item) {

    $slider_link_address = $slider_item["top_post_link"];
    $slider_photo_address =  $slider_item["top_post_photo"];
    $slider_title = $slider_item["subject_title"];
    $slider_description = $slider_item["top_post_title"];

    $slider .= "<div class=\"post feature-post\">
    <div class=\"entry-header\">
        <div class=\"entry-thumbnail\">
            <div class=\"main-slider-image\">
                <img class=\"img-responsive\" src=\"{$slider_photo_address}\" alt=\"\" />
            </div>
        </div>
        <div class=\"catagory world\"><a href=\"{$slider_link_address}\">{$slider_title}</a></div>
    </div>
    <div class=\"post-content\">
        <div class=\"entry-meta\">
            <ul class=\"list-inline\">
                <li class=\"publish-date\"><i class=\"fa fa-clock-o\"></i><a href=\"#\"> Nov 1, 2015 </a></li>
                <li class=\"views\"><i class=\"fa fa-eye\"></i><a href=\"#\">15k</a></li>
                <li class=\"loves\"><i class=\"fa fa-heart-o\"></i><a href=\"#\">278</a></li>
                <li class=\"comments\"><i class=\"fa fa-comment-o\"></i><a href=\"#\">189</a></li>
            </ul>
        </div>
        <h2 class=\"entry-title\">
            <a href=\"{$slider_link_address}\">{$slider_description}</a>
        </h2>
    </div>
</div><!--/post-->";
}
//endregion Slider

//region Top3Post
$toppost_list = select('reportage', '*', "status=1", " ORDER BY reg_date DESC LIMIT 3");

$top_posts = "";
foreach($toppost_list as $toppost_item) {

    $toppost_link_address = $HOST_NAME . "post/{$toppost_item["post_code"]}/" . $toppost_item["url_name"];
    $toppost_photo_address = $toppost_item["photo_address"];

    if (strpos(strtolower($toppost_photo_address), 'http') === false) {
        $toppost_photo_address = $HOST_NAME . $toppost_photo_address;
    }

    foreach ($subject_list as $subject) {
        if ($subject["id"] == $toppost_item["subject_id"]) {
            $toppost_subject =  $subject["name"];
        }
    }
    $toppost_date = $toppost_item["post_date"];
    $toppost_title = $toppost_item["title"];

    $top_posts .= "<div class=\"col-sm-4\">
    <div class=\"post feature-post top-post\">
        <div class=\"entry-header\">
            <div class=\"entry-thumbnail\">
                <img class=\"img-responsive\" src=\"{$toppost_photo_address}\" alt=\"\" />
            </div>
            <div class=\"catagory technology\"><span><a href=\"#\">{$toppost_subject}</a></span></div>
        </div>
        <div class=\"post-content\">
            <div class=\"entry-meta\">
                <ul class=\"list-inline\">
                    <li class=\"publish-date\"><i class=\"fa fa-clock-o\"></i><a href=\"#\"> {$toppost_date} </a></li>
                    <li class=\"views\"><i class=\"fa fa-eye\"></i><a href=\"#\">15k</a></li>
                    <li class=\"loves\"><i class=\"fa fa-heart-o\"></i><a href=\"#\">278</a></li>
                </ul>
            </div>
            <h2 class=\"entry-title\">
                <a href=\"{$toppost_link_address}\">{$toppost_title}</a>
            </h2>
        </div>
    </div><!--/post-->
</div>";
}

//endregion Top3Post

//region Popular Posts 
$popularpost_list = select('reportage', '*', "status=1", " ORDER BY reg_date DESC LIMIT 12");
$popular_posts = "";
foreach ($popularpost_list as $recentpost_item) {

    $recentpost_link_address = $HOST_NAME . "post/{$recentpost_item["post_code"]}/" . $recentpost_item["url_name"];
    $recentpost_photo_address = htmlspecialchars(strip_tags($recentpost_item['thumb_address']));
    if (strpos(strtolower($recentpost_photo_address), 'http') === false) {
        $recentpost_photo_address = $HOST_NAME . $recentpost_photo_address;
    }
    foreach ($subject_list as $subject) {
        if ($subject["id"] == $recentpost_item["subject_id"]) {
            $recentpost_subject =  $subject["name"];
        }
    }
    $recentpost_title = $recentpost_item["title"];
    $popular_posts .= "<li>
                            <div class=\"post small-post\">
                                <div class=\"entry-header\">
                                    <div class=\"entry-thumbnail\">
                                        <img class=\"img-responsive\" src=\"{$recentpost_photo_address}\" alt=\"{$recentpost_title}\">
                                    </div>
                                </div>
                                <div class=\"post-content\">
                                    <div class=\"video-catagory\"><a href=\"#\">{$recentpost_subject}</a></div>
                                    <h2 class=\"entry-title\">
                                        <a href=\"{$recentpost_link_address}\">{$recentpost_title}</a>
                                    </h2>
                                </div>
                            </div><!--/post-->
                        </li>";
}
//endregion Popular Posts 

$msg = update("home_page", "menu='{$menus}',slider='{$slider}',top_posts='{$top_posts}',popular_posts='{$popular_posts}',recent_posts='{$recent_posts}',ads1='{$ads1}',ads2='{$ads2}',ads3='{$ads3}',ads4='{$ads4}',subject_contents='$subject_contents',galleries='$gallery_contents'", "id=2");


if (isset($_SESSION["dblayer_error"])) {
    echo $_SESSION["dblayer_error"];
} else {
    echo "Done !";
}

//DisConnect to the DataBase
Disconnect();

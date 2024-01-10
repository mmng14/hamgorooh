<?php
include_once '../core/config.php';
$subject_id =  $_POST["subj_id"];
$SUBJECT_INDEX=$subject_id;
include_once '../core/dblayer_mysqli_hcd.php';

Connect();

if(isset($_POST["post_code"] ) && is_numeric($_POST["post_code"])) {

    $category_type = $_POST["category_type"];
    $this_subject_id = $_POST["this_subject_id"];
    $this_category_id = $_POST["this_category_id"];
    $this_sub_category_id = $_POST["this_sub_category_id"];
    $user_id = $_POST["user_id"];
    $user_name = $_POST["user_name"];
    $user_full_name = $_POST["user_full_name"];
    $user_photo = $_POST["user_photo"];
    $keywords = $_POST["keywords"];
    $post_name = $_POST["post_name"];
    $crawler_title = $_POST["crawler_title"];
    $crawler_brief_desc = $_POST["crawler_brief_desc"];
    $featured = $_POST["featured"];
    $post_status = $_POST["post_status"];
    $comment = $_POST["comment"];
    $reg_date = $_POST["reg_date"];
    $update_date = $_POST["update_date"];
    $parent = $_POST["parent"];
    $has_child = $_POST["has_child"];
    $guid = $_POST["guid"];
    $post_type = $_POST["post_type"];
    $attachment = $_POST["attachment"];
    $visit_count = $_POST["visit_count"];
    $comment_count = $_POST["comment_count"];
    $like_count = $_POST["like_count"];
    $dislike_count = $_POST["dislike_count"];
    $photo_address = $_POST["photo_address"];
    $thumb_address = $_POST["thumb_address"];
    $ranking = $_POST["ranking"];
    $total_price = $_POST["total_price"];
    $source_name = $_POST["source_name"];
    $source_link = $_POST["source_link"];
    $user_post = $_POST["user_post"];
    $ordering = $_POST["ordering"];
    $status = $_POST["status"];

    $crawler_desc = $_POST["crawler_desc"];
    $images = $_POST["images"];


    $property = array('NULL', $category_type, $this_subject_id, $this_category_id, $this_sub_category_id,
        $user_id, $user_name, $user_full_name, $user_photo, $keywords, $post_name,
        $crawler_title, $crawler_brief_desc, $featured, $post_status, $comment, $reg_date,
        $update_date, $parent, $has_child, $guid, $post_type, $attachment, $visit_count,
        $comment_count, $like_count, $dislike_count, $photo_address, $thumb_address,
        $ranking, $total_price, $source_name, $source_link, $user_post, $ordering, $status);


    $post_id = insert('post', $property);
    if ($post_id == null || $post_id == '') {
        $error = 'Error adding submitted data.';
        echo $error . "<br/>";
        echo $_SESSION["dblayer_error"] . "<br/>";
        echo $_SESSION["dblayer_query"];
    } else {
        ////Add Content OF post
        $property_content = array('NULL', $post_id, $guid, $reg_date, $crawler_desc, $images);
        $post_content_id = insert('post_content', $property_content);


        echo "New Post Id : " . $post_id . "<br/>";

        if ($post_content_id == null || $post_content_id == '') {
            $error = 'Error adding submitted post content.';
            echo $error . "<br/>";
            echo $_SESSION["dblayer_error"] . "<br/>";
            echo $_SESSION["dblayer_query"];
        } else {
            echo "New Post Content Id : " . $post_content_id . "<br/>";
        }


    }
}
Disconnect();
<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    try {


        $home_page = $database->home_page()
            ->where("status = ?", 1)
            ->order("id desc")
            ->fetch();

        if (isset($news_code)) {
            $requested_year = (int) substr($news_code, 0, 4);
            $subject_id_length = (int) substr($news_code, 4, 1);
            $subject_id = (int) substr($news_code, 5, $subject_id_length);
            $category_id_length = (int) substr($news_code, 5 + $subject_id_length, 1);
            $category_id = (int) substr($news_code, 5 + $subject_id_length + 1, $category_id_length);
            $post_length = (int) substr($news_code, 5 + $subject_id_length + 1 + $category_id_length, 1);
            $subcategory_id = "";
            $post_id = substr($news_code, 5 + $subject_id_length + 1 + $category_id_length + 1, $post_length);
        }

        if (isset($subject_id) && isset($requested_year)) {
            if (is_numeric($subject_id) && is_numeric($requested_year)) {

                //Set Subject Database Connection
                $database_subject = getSubjectDatabase($subject_id, $requested_year);
            }
        }

        if (isset($post_id) && $post_id != -1) {
            $post = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,user_id,post_name,title,brief_description,user_full_name,reg_date,photo_address")
                ->where("id = ?", $post_id)
                ->where("status = ?", 1)
                ->fetch();

            $post_content = $database_subject->post_content()
                ->select("id,content")
                ->where("post_id = ?", $post_id)
                ->fetch();
        }



        /*********** For Breadcrump (Optimize to one query later) **********/

        $subject =  $database->subject()
            ->select("id,name,url_name")
            ->where("id = ?", $subject_id)
            ->where("status = ?", 1)
            ->fetch();

        $subject_name = $subject['name'];
        $subject_url_name = $subject['url_name'];

        $category =  $database->category()
            ->select("id,name,url_name")
            ->where("id = ?", $category_id)
            ->where("status = ?", 1)
            ->fetch();

        $category_name = $category['name'];
        $category_url_name = $category['url_name'];

        if ($subcategory_id != "") {
            $subcategory =  $database->sub_category()
                ->select("id,name,url_name")
                ->where("id = ?", $subcategory_id)
                ->where("status = ?", 1)
                ->fetch();

            $subcategory_name = $subcategory['name'];
            $subcategory_url_name = $subcategory['url_name'];

            /******For Similar Posts***********/
            $similar_posts = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,user_id,post_name,title,brief_description,user_full_name,reg_date,thumb_address,source_name,source_link")
                ->where("sub_category_id = ?", $subcategory_id)
                ->where("id <> ?", $post_id)
                ->where("status = ?", 1)
                ->order("reg_date desc")
                ->limit(6, 1);
        } else {
            $similar_posts = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,user_id,post_name,title,brief_description,user_full_name,reg_date,thumb_address,source_name,source_link")
                ->where("category_id = ?", $category_id)
                ->where("id <> ?", $post_id)
                ->where("status = ?", 1)
                ->order("reg_date desc")
                ->limit(6, 1);
        }


        //SEO
        if (isset($post) && $post) {
            $photo_address = $post['photo_address'];
            if (strpos(strtolower($photo_address), 'http') === false) {
                $photo_address = $HOST_NAME . $photo_address;
            }
            $share_link = $HOST_NAME . "post/{$news_code}/{$post['post_name']}/";
            $page_url = $share_link;
            $page_title = $post['title'] . "-بانک اطلاعات عمومی-";
            $page_keywords = $post['title'] . "-بانک اطلاعات عمومی-";
            $page_description = trim($post['title']);
            $page_og_image = $photo_address;
            $page_og_title = $post['title'] . "-بانک اطلاعات عمومی-";
            $page_og_sitename = $share_link;
        }
    } catch (Exception $e) {
        echo "<h1>" . $e->getMessage() . "</h1>";
        echo "<h1>" . $subject_id . "</h1>";
        echo "<div style='margin: 50px auto;text-align:center'>";

        echo "<img src='"  . $HOST_NAME . "resources/images/broken.jpg' />";
        echo "</div>";
        exit;
    }



    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/news.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}

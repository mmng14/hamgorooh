<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
   try {


        $home_page = $database->home_page()
            ->where("status = ?", 1)
            ->order("id desc")
            ->fetch();


        if (isset($post_code)) {
            $subject_id_length = (int) substr($post_code, 0, 1);
            $subject_id = (int) substr($post_code, 1, $subject_id_length);
            $category_id_length = (int) substr($post_code, 1 + $subject_id_length, 1);
            $category_id = (int) substr($post_code, 1 + $subject_id_length + 1, $category_id_length);
            $post_length = (int) substr($post_code, 1 + $subject_id_length + 1 + $category_id_length, 1);
            $subcategory_id = "";
            $post_id = substr($post_code, 1 + $subject_id_length + 1 + $category_id_length + 1, $post_length);
        }



        if (isset($subject_id)) {
            if (is_numeric($subject_id)) {

                //Set Subject Database Connection
                $database_subject = getSubjectDatabase($subject_id);

            }
        }

        if (isset($post_id) && $post_id != -1) {
            $post = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,user_id,post_name,title,brief_description,user_full_name,reg_date,photo_address,source_name,source_link")
                ->where("id = ?", $post_id)
                ->where("status = ?", 1)
                ->fetch();

            $post_content = $database_subject->post_content()
                ->select("id,content")
                ->where("post_id = ?", $post_id)
                ->fetch();
        }


        //SEO
        if (isset($post) && $post) {
            $photo_address = $post['photo_address'];
            if (strpos(strtolower($photo_address), 'http') === false) {
                $photo_address = $HOST_NAME . $photo_address;
            }
            $photo_address = str_replace("http://www.hamgorooh.com", "https://www.hamgorooh.com", $photo_address);
            $share_link = $HOST_NAME . "post/{$post_code}/{$post['post_name']}/";
            $page_url = $share_link;
            $page_title = trim($post['title'] . "-بانک اطلاعات عمومی-");
            $page_keywords = trim($post['title'] . "-بانک اطلاعات عمومی-");
            $page_description = trim($post['title']);
            $page_og_image = $photo_address;
            $page_og_title = trim($post['title'] . "-بانک اطلاعات عمومی-");
            $page_og_sitename = $share_link;
        }
    } catch (Exception $e) {
       echo "<div style='margin: 50px auto;text-align:center'>";
        echo "<img src='"  . $HOST_NAME . "resources/public/images/broken.jpg' />";
        echo "</div>";
        exit;
    }


    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    include $ROOT_DIR . "app/home/views/iframe.view.php";
}

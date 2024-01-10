<?php
//require_once "core/utility_controller.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $today = jdate('Y/m/d');
    $current_year = jdate('Y');
    $current_year = convertPersianToEng($current_year);

    if (isset($subject_code) && isset($category_code) && isset($subcategory_code)) {
        $subject_id = (int) $subject_code;
        $category_id = (int) $category_code;
        $sub_category_id = (int) $subcategory_code;


        $subject_id_length = strlen($subject_code);
        $category_id_length = strlen($category_code);

        if (isset($subject_id) && isset($current_year)) {
            if (is_numeric($subject_id) && is_numeric($current_year)) {

                //Set Subject Database Connection
                $database_subject = getSubjectDatabase($subject_id, $current_year);
            }
        }


        //------------
        if ($sub_category_id == 0) {
            $posts = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,title,post_name,reg_date,status")
                ->where("category_id = ?", $category_id)
                ->where("status = ?", 1)
                ->order("reg_date desc")
                ->limit(10000);
        } else {
            $posts = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,title,post_name,reg_date,status")
                ->where("category_id = ?", $category_id)
                ->where("sub_category_id = ?", $sub_category_id)
                ->where("status = ?", 1)
                ->order("reg_date desc")
                ->limit(10000);
        }
    }
    //var_dump( $posts);

    header("Content-Type: application/xml; charset=utf-8");
    ///Create XML file
    echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

    function urlElement($url, $date, $freq)
    {
        echo '<url>' . PHP_EOL;
        echo '<loc>' . $url . '</loc>' . PHP_EOL;
        //echo '<lastmod>' .$date.'</lastmod>'.PHP_EOL;
        echo '<changefreq>' . $freq . '</changefreq>' . PHP_EOL;
        echo '<priority>0.9</priority>' . PHP_EOL;
        echo '</url>' . PHP_EOL;
    }

    $subject_id_length = strlen($subject_id);
    $category_id_length = strlen($category_id);
    foreach ($posts as $entry) {
        $post_id_length =  strlen($entry['id']);
        $subcategory_id_length = 0;
        $subcategory_id = "";
        //Creating single url node
        $pubDate = date("D, d M Y H:i:s T");
        urlElement($HOST_NAME . 'post/' . $subject_id_length . $subject_id . $category_id_length . $category_id . $post_id_length . $entry['id'] . "/" . $entry['post_name'] . "/", $pubDate, 'daily');
    }
    echo '</urlset>';
}

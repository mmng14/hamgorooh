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
                ->select("id,subject_id,category_id,sub_category_id,title,brief_description,post_name,reg_date,status")
                ->where("category_id = ?", $category_id)
                ->where("status = ?", 1)
                ->order("reg_date desc")
                ->limit(10000);
        } else {
            $posts = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,title,brief_description,post_name,reg_date,status")
                ->where("category_id = ?", $category_id)
                ->where("sub_category_id = ?", $sub_category_id)
                ->where("status = ?", 1)
                ->order("reg_date desc")
                ->limit(10000);
        }
    }

    header("Content-Type: text/xml;charset=utf-8");
    ///Create XML file
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
<channel>
<title>hamgorooh</title>
<description>Hamgorooh News Feed</description>
<link>https://www.hamgorooh.com/</link>';

    $pubDate = date("D, d M Y H:i:s T");
    $subject_id_length = strlen($subject_id);
    $category_id_length = strlen($category_id);
    foreach ($posts as $entry) {
        $post_id_length =  strlen($entry['id']);

        echo "
       <item>
          <title>{$entry['title']}</title>
          <description><![CDATA[{$entry['brief_description']}]]></description>
          <link>" . $HOST_NAME . 'news/' . $current_year . $subject_id_length . $subject_id . $category_id_length . $category_id . $post_id_length . $entry['id'] . "/" . $entry['post_name'] . "/" . "</link>
          <pubDate>{$pubDate} GMT</pubDate>
      </item>";
    }

    echo "</channel>
</rss>";
}

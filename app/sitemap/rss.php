<?php
include_once "includes/config.php";
include_once 'libraries/phpfunction.php';
include_once 'libraries/jdf.php';
include_once 'libraries/smily.php';
include_once 'libraries/sanitize_title.php';

$subject_id = 4;
$category_id = 15; //food

if(isset($subject_code) && isset($category_code) && isset($subcategory_code))
{
    $subject_id = (int)$subject_code;
    $category_id = (int)$category_code;
    $sub_category_id = (int)$subcategory_code;

}

$SUBJECT_INDEX=$subject_id;
include_once 'includes/dblayer_mysql_hcd.php';


Connect();
if($sub_category_id !=0)
{
    $posts = select('post','id,subject_id,category_id,sub_category_id,title,brief_description,post_name,reg_date',"subject_id='$subject_id' AND category_id='$category_id' AND sub_category_id='$sub_category_id' AND status=1","ORDER BY id DESC LIMIT 100");
}
else
{
    $posts = select('post','id,subject_id,category_id,sub_category_id,title,brief_description,post_name,reg_date',"subject_id='$subject_id' AND category_id='$category_id'  AND status=1","ORDER BY id DESC LIMIT 100");
}

echo '<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
<channel>
<title>hamgorooh</title>
<description>Hamgorooh News Feed</description>
<link>https://www.hamgorooh.com/</link>';


$base_url = "https://www.hamgorooh.com/";
$pubDate= date("D, d M Y H:i:s T");
$subject_id_length = strlen($subject_id);
$category_id_length = strlen($category_id);
foreach($posts as $entry)
{
    $post_id_length =  strlen($entry['id']);
    $subcategory_id_length = 0;
    $subcategory_id="";


    echo "
       <item>
          <title>{$entry['title']}</title>
          <description><![CDATA[{$entry['brief_description']}]]></description>
          <link>" .$base_url. 'post/' .$subject_id_length .$subject_id.$category_id_length.$category_id.$post_id_length . $entry['id'] ."/". $entry['post_name']."/" ."</link>
          <pubDate>{$pubDate} GMT</pubDate>
      </item>";
}

echo "</channel>
</rss>";

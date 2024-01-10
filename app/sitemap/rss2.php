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
    $posts = select('post','id,subject_id,category_id,sub_category_id,post_name,reg_date',"subject_id='$subject_id' AND category_id='$category_id' AND sub_category_id='$sub_category_id' AND status=1","ORDER BY id DESC");
}
else
{
    $posts = select('post','id,subject_id,category_id,sub_category_id,post_name,reg_date',"subject_id='$subject_id' AND category_id='$category_id'  AND status=1","ORDER BY id DESC");
}


header("Content-Type: text/xml;charset=utf-8");
echo '<?xml version="1.0" encoding="ISO-8859-1"?>
<rss version="2.0">
<channel>
<title>hamgorooh</title>
<description>Hamgorooh News Feed</description>
<link>https://www.hamgorooh.com/</link>';

while($row = @mysql_fetch_array($result,MYSQL_ASSOC))
{
    $pubDate= date("D, d M Y H:i:s T");
    $loc = "{$HOST_NAME}rss_detail/" . $row["rss_name"] . "/";
    echo "
       <item>
          <title>{$row['title']}</title>
          <description><![CDATA[{$row['summary']}]]></description>
          <link>{$loc}</link>
          <pubDate>{$pubDate} GMT</pubDate>
      </item>";
}
echo "</channel>
</rss>";
?>
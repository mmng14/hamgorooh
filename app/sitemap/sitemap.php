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
    $posts = select('post','id,subject_id,category_id,sub_category_id,post_name,reg_date',"subject_id='$subject_id' AND category_id='$category_id' AND sub_category_id='$sub_category_id' AND status=1","ORDER BY id DESC LIMIT 10000");
}
else
{
    $posts = select('post','id,subject_id,category_id,sub_category_id,post_name,reg_date',"subject_id='$subject_id' AND category_id='$category_id'  AND status=1","ORDER BY id DESC LIMIT 10000");
}
///Create XML file

echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL; 
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' .PHP_EOL; 

function urlElement($url,$date,$freq) {
    echo '<url>'.PHP_EOL; 
    echo '<loc>'.$url.'</loc>'. PHP_EOL; 
    //echo '<lastmod>' .$date.'</lastmod>'.PHP_EOL;
    echo '<changefreq>' . $freq .'</changefreq>'.PHP_EOL; 
    echo '<priority>0.9</priority>'.PHP_EOL; 
    echo '</url>'.PHP_EOL;
} 

$base_url = "https://www.hamgorooh.com/";

$subject_id_length = strlen($subject_id);
$category_id_length = strlen($category_id);
foreach($posts as $entry)
{
    $post_id_length =  strlen($entry['id']);
    $subcategory_id_length = 0;
    $subcategory_id="";
    //Creating single url node
    $pubDate= date("D, d M Y H:i:s T");
    urlElement($base_url. 'post/' .$subject_id_length .$subject_id.$category_id_length.$category_id.$post_id_length . $entry['id'] ."/". $entry['post_name']."/",$pubDate,'daily');
}
echo '</urlset>'; 

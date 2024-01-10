<?php 
date_default_timezone_set('Asia/Tehran');
$now = date('H:i:s', time());
//if($now >= "01:01:01" && $now <= "12:01:01")
if(true)
{

    include_once '../core/config.php';
    $SUBJECT_INDEX=4; //cooking
    include_once '../core/dblayer_mysqli_hcd.php';
    include_once '../libraries/phpfunction.php';
    include_once '../libraries/jdf.php';
    include_once '../libraries/sanitize_title.php';
    include_once '../libraries/telegram.class.php'; 
    include_once '../libraries/image_resize.class.php';
    Connect();

    include_once 'crawl_functions.php';

    echo '<!DOCTYPE html><html lang="fa"><head><meta charset="UTF-8"></head><body>';

    $crawler_items = select("crawler_items","*","status=0 AND subject_id=4","order by id desc limit 1");
    if($crawler_items)
    {
        $crawler = $crawler_items[0]["crawler"];
        $source_id = $crawler_items[0]["source_id"];
        $crawler_source = select("crawler_source","*","id={$source_id}","limit 1");

        
        if (strpos($crawler_source[0]["source_link"], "hamgorooh.com") !== false )
        {
            $site_name = "";
        }
        else
        {
            $site_name = $crawler_source[0]["site_name"];
        }
        echo $site_name . "<br/>";
        $UPLOAD_FOLDER = $UPLOAD_ARR[$SUBJECT_INDEX];
        include_once "crawlers/{$crawler}";
    }
}
else{
    echo "Not working time";

}
?>
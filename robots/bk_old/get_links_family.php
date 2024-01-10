<?php require_once '../includes/session.php';  ?>
<?php
include_once '../core/config.php';
$SUBJECT_INDEX=11; //family
include_once '../core/dblayer_mysqli_hcd.php';
include_once '../libraries/phpfunction.php';
include_once '../libraries/jdf.php';
include_once '../libraries/sanitize_title.php';

Connect();

$rows=select('crawler_source','*',"status='1' AND subject_id=11","limit 1");
if(isset($rows) && $rows !="" && count($rows) >= 1) {
    echo $rows[0]["subject_id"]. '<br/>';
}
if(isset($_SESSION["dblayer_error"])) echo $_SESSION["dblayer_error"];
if(isset($rows) && $rows !="" && count($rows) >= 1) {
    foreach ($rows as $row) {
        //$msg = update("crawler_source", "status=0", "id={$row['id']}");
        if(isset($_SESSION["dblayer_error"])) echo $_SESSION["dblayer_error"];

        echo $row['source_link']."<br/><hr/>";
        echo $row['site_name']."<br/><hr/>";

        $res = fill_crawler_items($row['id'], $row['category_type'],$row['subject_id'], $row['category_id'], $row['sub_category_id'],$row['site_name'],$row['crawler'], $row['source_name'], $row['source_link']);
        if($res)
        {
            $msg = update("crawler_source", "status=0", "id={$row['id']}");
            //Delete duplate items
            $sql_query = "DELETE n1 FROM crawler_items n1, crawler_items n2 WHERE n1.id > n2.id AND n1.item_link = n2.item_link";
            $del = delete_by_sql("{$sql_query}","142GJgkjkloiepqepopqwe[w");
        }
    }
}
else
{
    //set status of links to 1
    $msg = update("crawler_source", "status=1", "subject_id=11  AND status=0");
}

//*************************************************************************************
//************************************* Fill Crawler items ****************************
//*************************************************************************************

function fill_crawler_items($sourceId,$category_type,$subject_id,$category_id,$sub_category_id,$crawler_get_items,$crawler,$source_name,$source_link)
{

    if($sourceId != '0')
    {
        $ret = '';
        try{
            if($crawler==null){$crawler="";}
            Connect();
            $html = file_get_contents($source_link);
            //echo $html;
            //Create a new DOM document
            $dom = new DomDocument();
            //@$dom->loadHTML($html);
            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            $output = array();
            foreach ($dom->getElementsByTagName('a') as $item) {
                $output[] = array (
                   'str' => $dom->saveHTML($item),
                   'href' => $item->getAttribute('href'),
                   'anchorText' => $item->nodeValue
                );
            }
            $i=1;
            $j=1;
            $values = "";
            foreach($output as $link)
            {
                $i++;
                if ((strpos($link["href"], $source_link) !== false || strpos($link["href"], str_replace($crawler_get_items,"",$source_link)) !==false) && $link["href"] != $source_link )
                {
                    $j++;
                    $item_link =$crawler_get_items . trim($link["href"]);
                    $status=0;
                    echo $item_link. "<br/>";
                    $values .= "(NULL," . $sourceId. ",'" . $category_type."'," . $subject_id ."," . $category_id ."," . $sub_category_id . ",'".$crawler ."','". $source_name ."','".$source_link."','" . $item_link."','',''," . $status ."),";
                }
                if($j==10) { break;} //get just 10
            }

            $values = rtrim($values,",");
            echo "<br/><hr/>";


            $file_id=InsertMultiRows('crawler_items',$values);
            echo "<br/><hr/>";
            echo $i . "/". $j;

            if(isset($_SESSION["dblayer_error"]))
            {
                echo '<hr/>' .  $_SESSION["dblayer_error"].'<hr/>';
            }

            return true;
        }
        catch (Exception $e) {return false;}
    }
}



?>
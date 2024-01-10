<?php 

require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql_statistics.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';



$subject_id=$_POST['sid'];
$category_id=$_POST['cid'];
$post_id=$_POST['pid'];;

if( isset($subject_id) && isset($category_id) && isset($post_id) ) 
{

    $newAFID = GUIDv4(true);
    $session_name = $subject_id . $category_id . $post_id ;
    $_SESSION["$$session_name"]= $newAFID;
    
         echo json_encode(
             array(
                 "status" => '1',
                 "newafid" => $newAFID,
             )
         );
}


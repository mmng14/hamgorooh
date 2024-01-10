<?php 
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql_statistics.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';


$afid = $_POST['afid']; // antiforgery token
$ftime = intval( intval($_POST['ftime']) / 1000); // convert to second
$subject_id=$_POST['sid'];
$category_id=$_POST['cid'];
$sub_category_id=$_POST['scid'];
$post_id=$_POST['pid'];;
$post_user_id=$_POST['puid'];


//Anti Forgery Token  Check
$session_name = $subject_id . $category_id . $post_id ;
$session_afid = $_SESSION["$$session_name"];

//if visit time is more than 1 minute 
if(isset($post_id) && $ftime > 60  && $session_afid==$afid) 
{
    Connect();

    //Store Visitor in data base And Update Post Visit Count
    if(!isset($sub_category_id))  $sub_category_id = "";
    $visitor_session_time = $ftime;
    if($visitor_session_time > 600)
    {
        $visitor_session_time = 600;
    }
    $visit_date=jdate('Y/m/d');
    $visit_time = date('H:i:s');
    $user_ip= $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $referer = "";
    if(isset($_SERVER['HTTP_REFERER']))
    {
        $referer =  $_SERVER['HTTP_REFERER'];
    }    
    
    $ua=getBrowser();
    $device = detectDevice();
    $user_browser= $device . "---". $ua['name'] . " " . $ua['version'] ;
    
    $status=0;
    $visitor_user_id=0;
    if(isset($_SESSION["user_id"])) $visitor_user_id = $_SESSION["user_id"];
    //Get Cookie
    $cookie_name = "vcid";
    if(isset($_COOKIE[$cookie_name]))
    {
        $visitor_cookie_id=$_COOKIE[$cookie_name];
    }
    else {
        $visitor_cookie_id = GUIDv4(true);
        setcookie($cookie_name, $visitor_cookie_id, time() + (86400 * 30), "/");
    }
    
    $property = array('', $subject_id, $category_id, $sub_category_id, $post_id, $visit_date, $visit_time, $user_ip,$user_agent,$referer, $post_user_id,$visitor_user_id,$visitor_cookie_id,$visitor_session_time, $status);
    $file_id = insert('statistics_visitors', $property);
    
    //if($file_id !=null && $file_id > 0) {
    //    $msg = update("post", "visit_count = visit_count + 1", "id={$post_id}");
    //}

    Disconnect();
    echo json_encode(
             array(
                 "valid" => '0',
                 "message" => 'test',
             )
         );
}


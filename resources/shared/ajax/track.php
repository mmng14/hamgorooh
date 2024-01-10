<?php 
require_once 'libraries/session.php';
include_once 'includes/dblayer_mysql.php';
include_once 'libraries/phpfunction.php';
include_once 'libraries/jdf.php';

//Anti Forgery Token Dose Not Work Properly Now --- I Should Work On it Later

$afid = "123456"; // antiforgery token
$ftime = 1000; // convert to second
$subject_id="0";
$category_id="0";
$sub_category_id="0";
$post_id="0";
$post_user_id="0";

/********************************/

Connect();
$site_name = "";
if(isset($_GET["site"]))
{
    $site_name = "www.naw3.com";
}

if(!isset($sub_category_id))  $sub_category_id = "";
$visitor_session_time = $ftime;
$visit_date=jdate('Y/m/d');
$visit_time = date('H:i:s');
$user_ip= $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$referer = "";
if(isset($_GET["referer"]))
{
    $referer =  $_GET["referer"];
}    
$ua=getBrowser();
$device = detectDevice();
$user_browser= $site_name . "---" .  $referer. "---" . $device . "---". $ua['name'] . " " . $ua['version'] ;
$status=0;

$visitor_user_id=0;
if(isset($_SESSION["user_id"])) $visitor_user_id = $_SESSION["user_id"];
$cookie_name = "vcid";
$visitor_cookie_id = GUIDv4(true);


$property = array('', $subject_id, $category_id, $sub_category_id, $post_id, $visit_date, $visit_time, $user_ip,$user_browser, $post_user_id,$visitor_user_id,$visitor_cookie_id,$visitor_session_time, $status);
$file_id = insert('statistics_visitors', $property);

Disconnect();


echo  "<h1>Done !</h1>";

?>



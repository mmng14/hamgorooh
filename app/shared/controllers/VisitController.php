<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['check']) && $_POST['check'] == "VISIT_OP_CODE") {

    csrf_validation_ajax($_POST["_csrf"]);



    $database_statistics = getStatisticsDatabase();

    $afid = $_POST['afid']; // antiforgery token
    $ftime = intval(intval($_POST['ftime']) / 1000); // convert to second
    $subject_id = $_POST['sid'];
    $category_id = $_POST['cid'];
    $sub_category_id = $_POST['scid'];
    $post_id = $_POST['pid'];;
    $post_user_id = $_POST['puid'];

 

    //if visit time is more than 1 minute 
    if (isset($post_id) && $ftime >= 5  ) {


        //Store Visitor in data base And Update Post Visit Count
        if (!isset($sub_category_id))  $sub_category_id = "";
        $visitor_session_time = $ftime;
        if ($visitor_session_time > 600) {
            $visitor_session_time = 600;
        }

        date_default_timezone_set('Asia/Tehran'); 
        $visit_date= date("Y/m/d"); 
        $visit_time =date('H:i:s');

        $visit_date_j =jdate("Y/m/d");
        $visit_date_j = convertPersianToEng($visit_date_j);
        $visit_date_no_slash = str_replace('/', '', $visit_date_j);
        $year_month = substr($visit_date_no_slash,0,6);

        $user_ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $referer = "";
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = htmlentities($_SERVER['HTTP_REFERER']);
        }
      
        $ua = getBrowser();
        $device_type = detectDevice();
        $device_name="";

        $user_browser =  $ua['name'] . " " . $ua['version'];
        $browser_name= get_browser_name($user_agent); //$ua['name'];
        $browser_version=$ua['version'];
        $status = 0;
        $visit_type=1;
        $visitor_user_id = 0;
        if (isset($_SESSION["user_id"])) $visitor_user_id = $_SESSION["user_id"];
        //Get Cookie
        $cookie_name = "vcid";
        if (isset($_COOKIE[$cookie_name])) {
            $visitor_cookie_id = $_COOKIE[$cookie_name];
        } else {
            $visitor_cookie_id = GUIDv4(true);
            setcookie($cookie_name, $visitor_cookie_id, time() + (86400 * 30), "/");
        }

        //Add to visit database 
        $visit_array = array(
            "id" => null, "subject_id" => $subject_id, "category_id" => $category_id,
            "sub_category_id" => $sub_category_id, "post_id" => $post_id,
            "visit_date" => $visit_date,"visit_time"=>$visit_time,"user_ip" => $user_ip,
            "yearmonth" => $year_month, "browser_name" => $browser_name, 
            "browser_version" => $browser_version, "device_type" => $device_type, "device_name" => $device_name,
            "visit_type" => $visit_type, "user_id" => $post_user_id, "visitor_user_id" => $visitor_user_id,
            "visitor_cookie_id" => $visitor_cookie_id, "visitor_session_time" => $visitor_session_time,
            "status" => $status
        );

         $visit = $database_statistics->statistics_visits()->insert($visit_array);
         $visit_id = $visit['id'];
     
        echo json_encode(
            array(
                "visit_id"=>$visit_id,
                "visit_date"=>$visit_date,
                "user_ip"=>$user_ip,
                "referer"=>$referer,
                "visitor_user_id"=>$visitor_user_id,
                "device"=>$visit_type,
                "user_browser"=>$user_browser,
                "year_month"=>$year_month,
                "browser"=>$browser_name
            )
        );

        exit;
    }
}

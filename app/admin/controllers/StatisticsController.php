<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
     page_access_check(array(1), $HOST_NAME);
     //-------CSRF Check----------
     include 'libraries/csrf_validation.php';

     $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
     $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
     //and then call a template:
     $page_title = "همگروه - بانک اطلاعات عمومی";
     $page_content = $ROOT_DIR . "app/admin/views/statistics.view.php";
     include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Get Statistics Data **********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&   isset($_POST["check"]) && $_POST["check"] == "admin_statistics_op_code") {


     page_access_check_ajax(array(1), $HOST_NAME);
     csrf_validation_ajax($_POST["_csrf"]);
     //Set Subject Database Connection
     $database_statistics = getStatisticsDatabase();

     $user_id = 0;
     $user_id = $_SESSION["user_id"];

     //--------------------------- subject -----------------------------
     $subject_id = $_POST["s_id"];

     $current_date = date('Y/m/d');
     $date = date_create($current_date);
     date_add($date, date_interval_create_from_date_string("-7 days"));
     $week_ago = date_format($date, "Y/m/d");

     $visits = $database_statistics->statistics_visits()->select("*")
          ->where("status = ?", 0)
          ->where("visit_date <= ?", $current_date)
          ->where("visit_date >= ?", $week_ago);

     $browsers =  _group_by($visits, "browser_name");
     $browserData = array();
     foreach ($browsers as $key => $value) {
          array_push($browserData, [$key, count($value)]);
     }

     // $browserData =  [
     //      ['Chrome', 8],
     //      ['Firefox', 3],
     //      ['Edge', 1],
     //      ['Safari', 6],
     //   ];

     $devices =  _group_by($visits, "device_type");
     $deviceData = array();
     foreach ($devices as $key => $value) {
          array_push($deviceData, [$key, count($value)]);
     }

     // $deviceData =  [
     //      ['PC', 8],
     //      ['Mobile', 3],
     //      ['Tablet', 1],
     //   ];

     //بازدید در هفته اخیر     
     $dailyVisits =  _group_by($visits, "visit_date");
     $dailyVisitData = array();
     $dailyVisitCategories = array();
     $start_date = date_create($week_ago);

     for ($i = 0; $i <= 6; $i++) {
          date_add($start_date, date_interval_create_from_date_string("1 days"));
          $c_date = date_format($start_date, "Y/m/d");
          $val = 0;
          foreach ($dailyVisits as $key => $value) {
               if ($key == $c_date) {
                    $val =   count($value);
               }
          }
          array_push($dailyVisitData, $val);
          $day = date('l', strtotime($c_date));
          $persian_day =  convertEnWeekdayToFa($day);
          array_push($dailyVisitCategories, $persian_day);
     }


     //بازدید در 6 ماه اخیر
     $visit_date_j = jdate("Y/m/d");
     $visit_date_j = convertPersianToEng($visit_date_j);
     $visit_date_no_slash = str_replace('/', '', $visit_date_j);
     $year_month = substr($visit_date_no_slash, 0, 6);
     $year_month_int = (int)$year_month;
     $year_month_6month_before = addMonthToYearMonth($year_month_int, -5);

     $month_visits = $database_statistics->statistics_monthly_visit()->select("*")
          ->where("status = ?", 1)
          ->where("yearmonth >= ?", $year_month_6month_before)
          ->where("yearmonth <= ?", $year_month_int);


     $monthlyVisitData = array();
     $uniqueMonthlyVisitData = array();
     $sessionTimeData = array();
     $postCountData = array();

     $categoriesData = array();

     for ($i = 5; $i >= 0; $i--) {

          $c_year_month = addMonthToYearMonth($year_month_int, -$i);
          $val = 0;
          $val_unique = 0;
          $val_session_time = 0;
          $val_total_post = 0;
          foreach ($month_visits as $monthly_visit) {
               if ($monthly_visit["yearmonth"] == $c_year_month) {
                    $val +=  $monthly_visit["total_visit"];
                    $val_unique +=  $monthly_visit["unique_visit"];
                    $val_session_time +=  $monthly_visit["total_session_time"];
                    $val_total_post +=  $monthly_visit["total_post"];
               }
          }
          array_push($monthlyVisitData, $val);
          array_push($uniqueMonthlyVisitData, $val_unique);
          array_push($sessionTimeData, $val_session_time);
          array_push($postCountData, $val_total_post);

          //$c_year_month = "";
          array_push($categoriesData, convertYearMonthToYearMonthName($c_year_month));
     }

     //$categoriesData = ['مهر', 'آبان', 'آذر', 'دی', 'بهمن'];
     $seriesData = array(
          array(
               'name' => 'بازدید',
               'data' => $monthlyVisitData,
               'stack' => 'visit'
          ),
          array(
               'name' => 'بازدید منحصر بفرد',
               'data' => $uniqueMonthlyVisitData,
               'stack' => 'unique_visit'
          )
     );

     $last_month_post_count = $postCountData[5];
     $last_month_post_changes = $postCountData[5] - $postCountData[4];
     $last_month_post_changes_type =  $last_month_post_changes > 0 ? ' positive' : ' negative';
     $last_month_post_changes =  $last_month_post_changes > 0 ? ('+' . $last_month_post_changes) : ('-' . $last_month_post_changes);
     $last_6_month_post_count =  array_sum($postCountData);

     $last_month_visit_count = $monthlyVisitData[5];
     $last_month_visit_changes = $monthlyVisitData[5] - $monthlyVisitData[4];
     $last_month_visit_changes_type =  $last_month_visit_changes > 0 ? ' positive' : ' negative';
     $last_month_visit_changes =  $last_month_visit_changes > 0 ? ('+' . $last_month_visit_changes) : ('-' . $last_month_visit_changes);
     $last_6_month_visit_count =  array_sum($monthlyVisitData);


     //Subject Visit
     $subjects = $database->subject()
          ->select("*");

     $subjectsWeeklyVisit =  _group_by($visits, "subject_id");
     $subjectsWeeklyVisitData = array();
     foreach ($subjectsWeeklyVisit as $key => $value) {
          $keyName = getSubjectName($subjects, $key);
          array_push($subjectsWeeklyVisitData, [$keyName, count($value)]);
     }




     $subjectsMonthlyVisitData = array();

     foreach ($month_visits as $month_visit) {

          if ($month_visit["yearmonth"] == $year_month_int) {
               $keyId =  $month_visit["subject_id"]; // subject id                    
               $keyName = getSubjectName($subjects, $keyId);
               $keyValue = $month_visit["total_visit"]; 
               array_push($subjectsMonthlyVisitData, [$keyName, (int)$keyValue]);
          }
     }



     echo json_encode(
          array(

               "categoriesData" => $categoriesData,
               "seriesData" => $seriesData,

               "dailyVisits" => $dailyVisits,
               "dailyVisitData" => $dailyVisitData,
               "dailyVisitCategories" => $dailyVisitCategories,

               "deviceData" => $deviceData,
               "browserData" => $browserData,
               "subjectsWeeklyVisitData"=>$subjectsWeeklyVisitData,
               "subjectsMonthlyVisitData"=>$subjectsMonthlyVisitData,
               "visits" => $visits,
               "current_date" => $current_date,
               "week_ago" => $week_ago,
               "browsers" => $browsers,
               "postCountData" => $postCountData,
               "last_month_post_count" => $last_month_post_count,
               "last_month_post_changes" => $last_month_post_changes,
               "last_month_post_changes_type" => $last_month_post_changes_type,
               "last_6_month_post_count" => $last_6_month_post_count,
               "last_month_visit_count" => $last_month_visit_count,
               "last_month_visit_changes" => $last_month_visit_changes,
               "last_month_visit_changes_type" => $last_month_visit_changes_type,
               "last_6_month_visit_count" => $last_6_month_visit_count,

          )
     );

     exit;
}

function getSubjectName($subjects, $subjectId)
{
     $subjectName = "";

     foreach ($subjects as $subject) {
          if ($subject["id"] == $subjectId) {
               $subjectName = $subject["name"];
               return $subjectName;
          }
     }

     return $subjectName;
}


function addMonthToYearMonth($year_month, $month_to_add)
{

     //Validation Check
     if ($month_to_add > 12 || $month_to_add < -12) {
          return $year_month;
     }

     $year_part = substr($year_month, 0, 4);
     $month_part = substr($year_month, 4, 2);

     if ($month_to_add > 0) {
          $month_add_res = (int)$month_part + $month_to_add;
          if ($month_add_res > 12) {
               $month_part = $month_add_res - 12;
               $year_part = $year_part + 1;
          } else {
               $month_part = $month_add_res;
          }
          if (strlen($month_part) < 2) {
               $month_part = "0" . $month_part;
          }
     }

     if ($month_to_add < 0) {
          $month_add_res = (int)$month_part + $month_to_add;
          if ($month_add_res < 1) {
               $month_part =  12 - abs($month_add_res);

               $year_part = $year_part - 1;
          } else {
               $month_part = $month_add_res;
          }
          if (strlen($month_part) < 2) {
               $month_part = "0" . $month_part;
          }
     }

     $new_year_month = $year_part . $month_part;

     return $new_year_month;
}

function convertYearMonthToYearMonthName($year_month)
{



     $year_part = substr($year_month, 0, 4);
     $month_part = substr($year_month, 4, 2);

     $month_part_name = "";

     if ($month_part == "01") {
          $month_part_name = "فروردین";
     }
     if ($month_part == "02") {
          $month_part_name = "اردیبهشت";
     }
     if ($month_part == "03") {
          $month_part_name = "خرداد";
     }
     if ($month_part == "04") {
          $month_part_name = "تیر";
     }
     if ($month_part == "05") {
          $month_part_name = "مرداد";
     }
     if ($month_part == "06") {
          $month_part_name = "شهریور";
     }
     if ($month_part == "07") {
          $month_part_name = "مهر";
     }
     if ($month_part == "08") {
          $month_part_name = "آبان";
     }
     if ($month_part == "09") {
          $month_part_name = "آذر";
     }
     if ($month_part == "10") {
          $month_part_name = "دی";
     }
     if ($month_part == "11") {
          $month_part_name = "بهمن";
     }
     if ($month_part == "12") {
          $month_part_name = "اسفند";
     }

     $year_month_name = $year_part . " - " . $month_part_name;

     return $year_month_name;
}

function convertEnWeekdayToFa($day)
{
     $persian_week_day  = "";

     if (strtolower($day) == "saturday") {
          $persian_week_day = "شنبه";
     }
     if (strtolower($day) == "sunday") {
          $persian_week_day = " یکشنبه";
     }
     if (strtolower($day) == "monday") {
          $persian_week_day = "دوشنبه";
     }
     if (strtolower($day) == "tuesday") {
          $persian_week_day = "سه شنبه";
     }
     if (strtolower($day) == "wednesday") {
          $persian_week_day = "چهارشنبه";
     }
     if (strtolower($day) == "thursday") {
          $persian_week_day = "پنج شنبه";
     }
     if (strtolower($day) == "friday") {
          $persian_week_day = "جمعه";
     }

     return $persian_week_day;
}

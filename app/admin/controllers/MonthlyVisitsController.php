<?php

//*************************************************************************************
//*****************************   Show monthly visits page   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    page_access_check(array(1), $HOST_NAME);
    $active_menu = "monthly_visits";
    //-------CSRF Check----------
    include 'libraries/csrf_validation.php';

    $this_subject_id = "";

    if (isset($url_subject_id)) {
        $this_subject_id = $url_subject_id;
    }

    $subject_list = $database->subject()
        ->select("*")
        ->where("status = ?", 1)
        ->order("ordering asc");

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/monthly_visits.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*****************************   Delete monthly visits row   ************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $tblId = test_input($_POST["obj"]);

    try {
        if ($tblId != "") {

            $database_statistics = getStatisticsDatabase();
            $delete_row = $database_statistics->statistics_monthly_visit[$tblId];
            $affected = $delete_row->delete();

            echo json_encode(
                array(

                    "result" => "1",
                    "redirect" => "",
                    "message" => "رکورد با موفقیت حذف شد",
                    "status" => "1",
                )
            );
        }
    } catch (Exception $ex) {
        echo json_encode(
            array(

                "result" => "0",
                "redirect" => "",
                "message" => $ex->getMessage(),
                "status" => "0",
            )
        );
    }
}


//*************************************************************************************
//**********************************   Activate  monthly visits row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $database_statistics = getStatisticsDatabase();
        $update_row = $database_statistics->statistics_monthly_visit[$tblId];
        $status = 1;
        $property = array("id" => $tblId, "status" => $status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  De Activate  monthly visits row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $tblId = test_input($_POST["obj"]);

    if ($tblId != "") {
        $database_statistics = getStatisticsDatabase();
        $update_row = $database_statistics->statistics_monthly_visit[$tblId];
        $status = 0;
        $property = array("id" => $tblId, "status" => $status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}


//*************************************************************************************
//*****************************   Add  monthly visits    ************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        $subject_id = $_POST["subjectId"];
        $calc_year = $_POST["calcYear"];
        $calc_month = $_POST["calcMonth"];
        $year_month =  (int)($calc_year . $calc_month);

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($subject_id);
    
        $start_date = convertEngToPersian($calc_year ."/". $calc_month ."/". "01");
        $end_date = convertEngToPersian($calc_year ."/". $calc_month ."/". "31");
        
        $post_count = $database_subject->post()
              ->select(" count(id) as c")
              ->where("status = ?", 1)
              ->where("reg_date >= ?", $start_date)
              ->where("reg_date <= ?", $end_date)
              ->fetch();

         $post_count = $post_count["c"];
         
        $database_statistics = getStatisticsDatabase();

        $visits = $database_statistics->statistics_visits()->select("*")
            ->where("status = ?", 0)
            ->where("yearmonth = ?", $year_month)
            ->where("subject_id = ?", $subject_id);


        $categories =  _group_by($visits, "category_id");
        $categoriesStr = "";
        foreach ($categories as $key => $value) {
            $categoriesStr =  $categoriesStr . $key . ":" . count($value) . ",";
        }

        $browsers =  _group_by($visits, "browser_name");
        $browsersStr = "";
        //$browserData = array();
        foreach ($browsers as $key => $value) {
            //array_push($browserData, [$key, count($value)]);
            $browsersStr =  $browsersStr . $key . ":" . count($value) . ",";
        }


        $devices =  _group_by($visits, "device_type");
        $devicesStr = "";
        //$deviceData = array();
        foreach ($devices as $key => $value) {
            //array_push($deviceData, [$key, count($value)]);
            $devicesStr =  $devicesStr . $key . ":" . count($value) . ",";
        }

        $totalVisitCount = count($visits);
        $uniqueVisits =  _group_by($visits, "user_ip");
        $totalUniqeVisitCount = count($uniqueVisits);

        //TODO calculate later
        $total_session_time=0;
        $total_users=0;
        $total_points=0;
        $rank=0;
        $status=0;    

        $calculate_date = date('Y/m/d H:i:s');

            $monthly_visit_id=0;
            $id=null; //for insert

            $visits_monthly_search = $database_statistics->statistics_monthly_visit()->select("id")
                //->where("status = ?", 0)
                ->where("yearmonth = ?", $year_month)
                ->where("subject_id = ?", $subject_id)
                ->fetch();

            if($visits_monthly_search !=null){
                $id=$visits_monthly_search['id'];
            }    

            //Add/Update to visit monthly visit table 
            $monthly_visit_array = array(
                "id" => $id,"subject_id" => $subject_id, "month" => $calc_month,
                "year" => $calc_year, "yearmonth" => $year_month,
                "total_visit" => $totalVisitCount,"unique_visit" => $totalUniqeVisitCount,
                "total_session_time" => $total_session_time, "total_post" => $post_count,
                "categories" => $categoriesStr, "browsers" => $browsersStr,
                "devices" => $devicesStr, "total_points" => $total_points, "rank" => $rank,
                "calculate_date" => $calculate_date,"status" => $status
            );
    
            $monthly_visit_id =0;

            if($id==null){
                $monthly_visit = $database_statistics-> statistics_monthly_visit()->insert($monthly_visit_array);             
                $monthly_visit_id = $monthly_visit['id'];
            }else{
                $monthly_visit = $database_statistics->statistics_monthly_visit[$id];
                $affected_monthly_visit = $monthly_visit->update($monthly_visit_array);
                $monthly_visit_id = $id; 
            }



        if ($monthly_visit_id == null || $monthly_visit_id == '' || $monthly_visit_id == 0) {
            $msg = "خطا در ثبت دادهد";
            echo json_encode(
                array(
                    "status" => '0',
                    "message" => $msg,
                    "id" => $id,"subject_id" => $subject_id, "month" => $calc_month,
                    "year" => $calc_year, "yearmonth" => $year_month,
                    "total_visit" => $totalVisitCount,"unique_visit" => $totalUniqeVisitCount,
                    "total_session_time" => $total_session_time, "total_post" => $post_count,
                    "categories" => $categoriesStr, "browsers" => $browsersStr,
                    "devices" => $devicesStr, "total_points" => $total_points, "rank" => $rank,
                    "calculate_date" => $calculate_date,"status" => $status
                )
            );
            exit;
        } else {
            $msg = "داده ها با موفقیت ثبت شد";
            echo json_encode(
                array(
                    "monthly_visit_id" => $monthly_visit_id,
                    "status" => '1',
                    "message" => $msg,
                    "subject_id" => $subject_id,
                    "calc_year" => $calc_year,
                    "calc_month" => $calc_month,
                    "year_month" => $year_month,
                    "post_count" => $post_count,
                    "categoriesStr" => $categoriesStr,
                    "browsersStr" => $browsersStr,
                    "devicesStr" => $devicesStr,
                    "totalVisitCount" => $totalVisitCount,
                    "totalUniqeVisitCount" => $totalUniqeVisitCount,
                )
            );
            exit;
        }
    } catch (PDOException $ex) {

        $msg = $ex->getMessage();
        echo json_encode(
            array(
                "status" => '0',
                "message" => $msg,

            )
        );
        exit;
    }
}


//*************************************************************************************
//*****************************    monthly visits  List   *****************************
//*************************************************************************************
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $database_statistics = getStatisticsDatabase();
    //-------filters --------

    $subject_filter = 0;
    if (isset($_POST['subject_id'])) {
        $subject_filter = $_POST['subject_id'];
    }
    $subject_check = "subject_id = ?";
    if ($subject_filter == 0) {
        $subject_filter = 1;
        $subject_check = " 1 = ?";
    }

    $year_filter = 0;
    if (isset($_POST['calc_year'])) {
        $year_filter = $_POST['calc_year'];
    }
    $year_check = "year = ?";
    if ($year_filter == 0) {
        $year_filter = 1;
        $year_check = " 1 = ?";
    }

    $month_filter = 0;
    if (isset($_POST['calc_month'])) {
        $month_filter = $_POST['calc_month'];
    }
    $month_check = "month = ?";
    if ($month_filter == 0) {
        $month_filter = 1;
        $month_check = " 1 = ?";
    }

    //--------------------------- page -----------------------------
    //Get page number from Ajax POST
    if (isset($_POST["page"])) {
        $page_number = filter_var(mysql_escape_mimic($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if (!is_numeric($page_number)) {
            die('Invalid page number!');
        } //incase of invalid page number
    } else {
        $page_number = 1; //if there's no page number, set it to 1
    }
    //------------------------------------------------------------
    //-------------------------- perpage -------------------------
    if (isset($_POST['perpage'])) {
        $item_per_page = mysql_escape_mimic($_POST['perpage']);
    } else
        $item_per_page = 10;
    //---------------------------------------------------------------
    //-------------------------- order -------------------------------
    if (isset($_POST['order'])) {
        $orderBy = mysql_escape_mimic($_POST['order']);
        if ($orderBy == 1) $order = 'id DESC';
        else if ($orderBy == 2) $order = 'id ASC';
    } else {
        $orderBy = 2;
        $order = 'id DESC';
    }
    //-----------------------------------------------------------------
    $count = $database_statistics->statistics_monthly_visit()
        ->select(" count(id) as c")
        ->where($subject_check, $subject_filter)
        ->where($year_check, $year_filter)
        ->where($month_check, $month_filter)
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database_statistics->statistics_monthly_visit()
        ->select("*")
        ->where($subject_check, $subject_filter)
        ->where($year_check, $year_filter)
        ->where($month_check, $month_filter)
        ->order($order)
        ->limit($item_per_page, $page_position);

    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );

    $data = array();
    $data['list'] = $rows;
    $data['pagination'] = $pagination;
    //echo json_encode($data);

    $html = view_to_string("_monthly_visit.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

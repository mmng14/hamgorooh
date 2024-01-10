<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {



    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();


    ////////////////////////////////

    if (isset($resource_page)) {
        $page = (int) substr($resource_page, 1, strlen($resource_page) - 1);
        if($page < 1){
            $page = 1; 
        }
    } else {
        $page = 1;
    }

    if (isset($subject_code)) {

        $subject_id_length = (int) substr($subject_code, 0, 1);
        $subject_id = (int) substr($subject_code, 1, $subject_id_length);

        $subject = $database->subject()
            ->select("*")
            ->where("id = ?", $subject_id)
            ->where("status = ?", 1)
            ->fetch();

        $search_exp = "";
        // Define variables and set to empty values
        if (isset($searchQuery)) {
            $search_exp = mysql_escape_mimic($searchQuery);
          
        }

        $subject_id = $subject["id"];
        $subject_name = $subject["name"];
        $subject_url = $subject["url_name"];


        $count = $database->subject_resources()
            ->select(" count(id) as c")
            ->where("subject_id = ?", $subject_id)
            ->where("status = ?", 1)
            ->where("title LIKE ?", "%{$search_exp}%")
            ->fetch();

        //------------
        $total_items =  $count["c"] !=null ? $count["c"] : 0;
        $page_size = 12;
        $resource_base_url = $HOST_NAME . "resources/" . $subject_code . "/{$subject["url_name"]}";
        $base_url = $HOST_NAME . "resources/" . $subject_code . "/{$subject["url_name"]}/" . "p";
        
        $skip_size =  ($page - 1) * $page_size; 
        


        $resources = $database->subject_resources()
            ->select("*")
            ->where("subject_id = ?", $subject_id)
            ->where("status = ?", 1)
            ->where("title LIKE ?", "%{$search_exp}%")
            ->order("ordering asc")
            ->limit($page_size, $skip_size);

    }


    function get_paging_info($total_rows, $pp, $curr_page, $url)
    {
        $pages = ceil($total_rows / $pp); // calc pages

        $data = array(); // start out array
        $data['si']        = ($curr_page * $pp) - $pp; // what row to start at
        $data['pages']     = $pages;                   // add the pages
        $data['curr_page'] = $curr_page;
        $data['curr_url'] = $url; // Whats the current page

        return $data; //return the paging data
    }


    $show_header = false;
    $header_title = "منابع";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/resources.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}

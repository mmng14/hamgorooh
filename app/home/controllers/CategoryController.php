<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();


    ////////////////////////////////

    if (isset($category_page)) {
        $page = (int) substr($category_page, 1, strlen($category_page) - 1);
        if($page < 1){
            $page = 1; 
        }
    } else {
        $page = 1;
    }

    $today = jdate('Y/m/d');
    $current_year = jdate('Y');
    $current_year = convertPersianToEng($current_year);


    if (isset($category_code)) {

        $subject_id_length = (int) substr($category_code, 0, 1);
        $subject_id = (int) substr($category_code, 1, $subject_id_length);
        $category_id_length = (int) substr($category_code, 1 + $subject_id_length, 1);
        $category_id = (int) substr($category_code, 1 + $subject_id_length + 1, $category_id_length);



        $subject = $database->subject()
            ->select("*")
            ->where("id = ?", $subject_id)
            ->where("status = ?", 1)
            ->fetch();

        $categories = $database->category()
            ->select("*")
            ->where("subject_id = ?", $subject_id)
            ->where("status = ?", 1);


        foreach ($categories as $category_item) {
            if ($category_item["id"] == $category_id) {
                $category =   $category_item;
            }
        }

        $subcategories = $database->sub_category()
            ->select("*")
            ->where("category_id = ?", $category_id)
            ->where("status = ?", 1)
            ->order("name asc");



        $category_name =  $category["name"];
        $category_url = $category["url_name"];
        $subject_name = $subject["name"];
        $subject_url = $subject["url_name"];

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($subject_id);

        $search_exp = "";
        // Define variables and set to empty values
        if (isset($searchQuery)) {
            $search_exp = mysql_escape_mimic($searchQuery);
          
        }

        $count = $database_subject->post()
            ->select(" count(id) as c")
            ->where("category_id = ?", $category_id)
            ->where("title LIKE ?", "%{$search_exp}%")
            ->where("status = ?", 1)
            ->fetch();

        //------------
        $total_items =  $count["c"];
        $page_size = 24;
        // $page_counts = ceil($total_items/$page_size);
        $subject_code = strlen($subject_id) . $subject_id;
        $subject_base_url = $HOST_NAME . "subject/" . $subject_code . "/{$subject["url_name"]}/";
        $base_url = $HOST_NAME . "category/" . $category_code . "/{$category["url_name"]}/" . "p";
        
        $skip_size =  ($page - 1) * $page_size;
        //------------
        $posts = $database_subject->post()
            ->select("id,subject_id,category_id,sub_category_id,user_id,user_full_name,title,post_name,thumb_address,photo_address,brief_description,reg_date,like_count,comment_count,status")
            ->where("category_id = ?", $category_id)
            ->where("title LIKE ?", "%{$search_exp}%")
            ->where("status = ?", 1)
            ->order("reg_date desc")
            ->limit($page_size, $skip_size);
    }


    function get_paging_info($total_rows, $pp, $curr_page, $url)
    {
        $pages = floor($total_rows / $pp); // calc pages

        $data = array(); // start out array
        $data['si']        = ($curr_page * $pp) - $pp; // what row to start at
        $data['pages']     = $pages;                   // add the pages
        $data['curr_page'] = $curr_page;
        $data['curr_url'] = $url; // Whats the current page

        return $data; //return the paging data
    }

    $show_header = false;
    $header_title = "موضوع";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/category.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}

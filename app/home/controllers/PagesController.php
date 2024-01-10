<?php

class PagesController
{
    
    public function about()
    {
        
        require_once "includes/utility_controller.php";
        
        $home_page = $database->home_page()
            ->where("status = ?", 1)
            ->order("id desc")
            ->fetch();

        $about = $database->about_us()
            ->where("status = ?", 1)
            ->order("id asc")
            ->fetch();

        $users = $database->users()
            ->where("status = ?", 1)
            ->order("id asc")
            ->limit(12, 1);

        //get post counts    
        $post_count = $database->post()
            ->select(" count(id) as post_count")
            // ->where("status = ?", 1)
            ->fetch();

        $total_posts =  $post_count["post_count"];
        //-----------------


        //and then call a template:
        $page_title = "همگروه - بانک اطلاعات عمومی";
        $page_content = "app/home/views/about.view.php";
        require "app/shared/views/_layout_home.php";
    }
}

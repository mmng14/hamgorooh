<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['check']) && $_POST['check'] == "RATE_OP_CODE") {

    csrf_validation_ajax($_POST["_csrf"]);


    $afid = test_input($_POST['afid']); // antiforgery token
    $subject_id = test_input($_POST['sid']);
    $category_id = test_input($_POST['cid']);
    $sub_category_id = test_input($_POST['scid']);
    $post_id = test_input($_POST['pid']);
    $post_user_id = test_input($_POST['puid']);
    $user_rate = test_input($_POST['rate']);

    $database_subject = getSubjectDatabase($subject_id);

    $user_ip = $_SERVER['REMOTE_ADDR'];
    $user_id =0;
    if(isset($_SESSION["user_id"])){
        $user_id = $_SESSION["user_id"];
    }

    //if visit time is more than 1 minute 
    if (isset($post_id) && $user_rate <= 5  ) {

        $select_rate = $database_subject->post_rate()
            ->select("*")
            ->where("user_id=?", $user_id)
            ->where("user_ip=?", $user_ip)
            ->where("post_id=?", $post_id)
            ->fetch();

        if($select_rate){
            echo json_encode(
                array(
                    "rate_id"=>0,
                    "status"=>"0",
                    "message"=>"شما قبلا به این پست رای داده اید"
                )
            );
            exit;
        }   

        date_default_timezone_set('Asia/Tehran'); 
        $reg_date= date("Y/m/d"); 
        $reg_time =date('H:i:s');

 
        //Add to rate table 
        $rate_array = array(
            "id" => null,"post_id" => $post_id, "post_subject_id" => $subject_id,
             "post_category_id" => $category_id,"post_user_id" => $post_user_id,
             "user_id" => $user_id,"rate" => $user_rate,"user_ip" => $user_ip,
             "reg_date" => $reg_date,"reg_time"=>$reg_time
        );

         $rate = $database_subject->post_rate()->insert($rate_array);
         $rate_id = $rate['id'];
     
        echo json_encode(
            array(
                "rate_id"=>$rate_id,
                "status"=>"1",
                "message"=>"با تشکر - رای شما با موفقیت ثبت شده است"
            )
        );

        exit;
    }
}

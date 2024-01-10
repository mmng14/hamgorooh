<?php
//require_once "includes/utility_services.php";

// if (isset($_POST["token"])) {
if(true){

    $subjects = $database->subject()
        ->where("status = ?", 1)
        ->order("id asc");

   $jsonResponse = array(
        'subjects' => $subjects,
        'totalCount'=>16
    );

    echo json_encode($jsonResponse,JSON_UNESCAPED_UNICODE);

}
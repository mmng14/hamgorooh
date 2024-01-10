<?php
// require_once "includes/utility_controller.php";
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
    //Clear cookie
    if (isset($_COOKIE['hamgorooh'])) {         
        setcookie ("hamgorooh", null, time() - 3600);
        unset($_COOKIE['hamgorooh']);
    } 
  
    if (!isset($_SESSION["user_name"])) {
        redirect_to($HOST_NAME);
    }
    session_destroy();
    header("location: {$HOST_NAME}");
}

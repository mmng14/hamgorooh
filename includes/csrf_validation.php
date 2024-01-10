<?php
//[GET]
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_csrf =  GUIDv4();
    $_SESSION[$_csrf]=$_csrf;
}
//[POST]
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(!isset($_POST['_csrf']) || !isset($_SESSION[$_POST['_csrf']])) {
        redirect_to($HOST_NAME);
    }
    else
    {
        $_csrf = $_POST['_csrf'];
    }
}
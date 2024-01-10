<?php
///// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}
/////echo "You have CORS!";

require_once "includes/utility_controller.php";

if (isset($_GET['url'])) {

    $url = strip_tags($_GET['url']);
    if (mb_substr($url, -1, 1) == '/') {
        $url = mb_substr($url, 0, -1);
    }
    $params = explode('/', $url);


    if (isset($params[0])) {
        include_once 'routes/routes.php';
    } else {
        include_once 'app/home/controllers/IndexController.php';
    }
} else {
    include_once 'app/home/controllers/IndexController.php';
}

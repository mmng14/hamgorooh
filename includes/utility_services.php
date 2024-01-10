<?php
require_once 'session.php';
include_once 'security.php';
include_once 'user_access.php';
require_once "core/config.php";
require_once "core/NotORM.php";
include_once 'libraries/phpfunction.php';
include_once 'libraries/jdf.php';
include_once 'libraries/sanitize_title.php';
include_once 'libraries/image_resize.class.php';

//------main DB Connection------
$dsn = "mysql:dbname=$DB_NAME;host=$DB_SERVER;charset=utf8";
$pdo=  new PDO($dsn, "$DB_USER", "$DB_PASS"); //$GLOBALS["db_pdo"]
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Disable on publish
$database =  new NotORM($pdo);
$database->debug = true;
//-----------------------------
#region database_util
function  debugSql($exit = 0) {
    global $database;
    $database->debug = function($query, $parameters) use ($exit) {
        toScreen($query);
        toScreen($parameters, $exit);
    };
}
function iteratorToArray($notormResultSet) {
    $assocArray = array();
    if (!empty($notormResultSet)) {
        if ($notormResultSet instanceof NotORM_Result) {
            $assocArray = array_map('iterator_to_array', iterator_to_array($notormResultSet));
        } else {
            $assocArray = iterator_to_array($notormResultSet);
        }
    }
    return $assocArray;
}
function toScreen($data, $exit = 0, $escape = 0) {
    echo '<pre>';

    if (is_array($data)) {
        print_r($data);
    } else {
        if ($escape) {
            echo nl2br($data);
        } else {
            echo $data;
        }
    }

    echo '</pre>';
    ob_flush();
    flush();

    if ($exit) {
        exit;
    }
}
#endregion database_util
//-----------------------------
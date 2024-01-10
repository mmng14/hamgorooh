<?php
require_once '../../../libraries/session.php';
include "../../../core/config.php";
include "../../../core/NotORM.php";
include_once '../../../libraries/phpfunction.php';
include_once '../../../libraries/jdf.php';
include_once '../../../libraries/sanitize_title.php';
include '../../../libraries/image_resize.class.php';
include '../../../libraries/project/security.php';
include '../../../libraries/project/user_access.php';
//------main DB Connection------
$dsn = "mysql:dbname=$DB_NAME;host=$DB_SERVER;charset=utf8";
$GLOBALS["db_pdo"] = new PDO($dsn, "$DB_USER", "$DB_PASS");
$database =  new NotORM($GLOBALS["db_pdo"]);
$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
function getSubjectDatabase($request_subject_id){
    include "../../../core/config.php";
    if (is_numeric($request_subject_id)) {


        $SUBJECT_INDEX = $request_subject_id;

        if ($SUBJECT_INDEX != 16) {
            $SUBJECT_SERVER = $HCD_DB_ARR[$request_subject_id][0];
            $SUBJECT_DB_NAME = $HCD_DB_ARR[$request_subject_id][1];
            $SUBJECT_DB_USER = $HCD_DB_ARR[$request_subject_id][2];
            $SUBJECT_DB_PASS = $HCD_DB_ARR[$request_subject_id][3];
        } else // if is news
        {
            $current_year = jdate('Y');
            $current_year = convertPersianToEng($current_year);
            $REQUEST_YEAR = $current_year;

            $SUBJECT_SERVER = $HCD_DB_ARR[$request_subject_id][0];
            $SUBJECT_DB_NAME = $HCD_DB_ARR[$request_subject_id][1] . $REQUEST_YEAR;
            $SUBJECT_DB_USER = $HCD_DB_ARR[$request_subject_id][2];
            $SUBJECT_DB_PASS = $HCD_DB_ARR[$request_subject_id][3];
        }


        //crate subject database connection
        $dsn_subject = "mysql:dbname={$SUBJECT_DB_NAME};host={$SUBJECT_SERVER};charset=utf8";
        $GLOBALS["db_pdo_subject"] = new PDO($dsn_subject, "{$SUBJECT_DB_USER}", "{$SUBJECT_DB_PASS}");
        $database_subject = new NotORM($GLOBALS["db_pdo_subject"]);
        $database_subject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database_subject->debug = true;

        $UPLOAD_FOLDER = $UPLOAD_ARR[$request_subject_id];
        $_SESSION["upload_folder"] = $UPLOAD_FOLDER;

        return $database_subject;

    }
}

<?php
require_once 'session.php';
require_once "core/config.php";
require_once "core/NotORM.php";
include_once 'security.php';
include_once 'user_access.php';
include_once 'libraries/phpfunction.php';
include_once 'libraries/jdf.php';
include_once 'libraries/sanitize_title.php';
include_once 'libraries/image_resize.class.php';

//------main DB Connection------
$dsn = "mysql:dbname=$DB_NAME;host=$DB_SERVER;charset=utf8";
$pdo = new PDO($dsn, "$DB_USER", "$DB_PASS"); //$GLOBALS["db_pdo"]
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Disable on publish
$database = new NotORM($pdo);
$database->debug = true;
//-----------------------------

#region database_util
function debugSql($exit = 0)
{
    global $database;
    $database->debug = function ($query, $parameters) use ($exit) {
        toScreen($query);
        toScreen($parameters, $exit);
    };
}

function iteratorToArray($notormResultSet)
{
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

function toScreen($data, $exit = 0, $escape = 0)
{
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


function getMainDatabase()
{
    include "core/config.php";


    //crate main_database database connection
    $dsn_main_database = "mysql:dbname={$DB_NAME};host={$DB_SERVER};charset=utf8";
    $GLOBALS["db_pdo_main_database"] = new PDO($dsn_main_database, "{$DB_USER}", "{$DB_PASS}");
    $main_database = new NotORM($GLOBALS["db_pdo_main_database"]);
    $main_database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $main_database->debug = true;


    return $main_database;
}

function getSubjectDatabase($request_subject_id, $requested_year = "")
{
    include "core/config.php";
    if (is_numeric($request_subject_id)) {


        $SUBJECT_INDEX = $request_subject_id;

        if ($SUBJECT_INDEX != 16) {
            $SUBJECT_SERVER = $HCD_DB_ARR[$request_subject_id][0];
            $SUBJECT_DB_NAME = $HCD_DB_ARR[$request_subject_id][1];
            $SUBJECT_DB_USER = $HCD_DB_ARR[$request_subject_id][2];
            $SUBJECT_DB_PASS = $HCD_DB_ARR[$request_subject_id][3];
        } else // if is news
        {
            if ($requested_year == "") {
                $current_year = jdate('Y');
                $current_year = convertPersianToEng($current_year);
                $REQUEST_YEAR = $current_year;
            } else {
                $REQUEST_YEAR = $requested_year;
            }

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

function getStatisticsDatabase()
{
    include "core/config.php";


    //crate statistics database connection
    $dsn_subject = "mysql:dbname={$STATISTICS_DB};host={$STATISTICS_SERVER};charset=utf8";
    $GLOBALS["db_pdo_statistics"] = new PDO($dsn_subject, "{$STATISTICS_USER}", "{$STATISTICS_PASS}");
    $database_statistics = new NotORM($GLOBALS["db_pdo_statistics"]);
    $database_statistics->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database_statistics->debug = true;


    return $database_statistics;
}


#region Notification DataBase And Operations

function getNotificationsDatabase()
{
    include "core/config.php";


    //crate notifications database connection
    $dsn_notifications = "mysql:dbname={$NOTIFICATIONS_DB};host={$NOTIFICATIONS_SERVER};charset=utf8";
    $GLOBALS["db_pdo_notifications"] = new PDO($dsn_notifications, "{$NOTIFICATIONS_USER}", "{$NOTIFICATIONS_PASS}");
    $database_notifications = new NotORM($GLOBALS["db_pdo_notifications"]);
    $database_notifications->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database_notifications->debug = true;


    return $database_notifications;
}

function addNotification($notification_type, $user_id, $subject_id, $item_id)
{
    $database_notifications = getNotificationsDatabase();
    $main_database = getMainDatabase();

    if (($notification_type == 1 || $notification_type == 2 || $notification_type == 3) && ($user_id == null || $user_id == 0)) {
        $subject_admin = $main_database->user_subjects()
            ->select("id,user_id")
            ->where("role = ?", 2)
            ->where("subject_id = ?", $subject_id)
            ->fetch();
        if (isset($subject_admin["user_id"])) {
            $user_id = $subject_admin["user_id"];
        }
    }

    $notification_id = 0;
    if ($user_id != null && $user_id != 0) {
        $user = $main_database->users()
            ->select("id,phone,email")
            ->where("id = ?", $user_id)
            ->fetch();

        $user_phone = $user["phone"];
        $user_email = $user["email"];

        $register_date = date('Y/m/d H:i:s');

        date_default_timezone_set('Asia/Tehran');
        $notification_time = date('H:i:s');
        $notification_date = jdate("Y/m/d");
        $notification_date = convertPersianToEng($notification_date);
        $visit_date_no_slash = str_replace('/', '', $notification_date);

        $title = "notification";
        $description = getNotificationMessage($notification_type);
        $link_address = getNotificationUrl($notification_type);

        $status = 0;
        $visited = 0;

        //Add to notifications database 
        $notification_array = array(
            "id" => null, "user_id" => $user_id, "user_phone" => $user_phone,
            "user_email" => $user_email, "notification_type" => $notification_type,
            "subject_id" => $subject_id, "item_id" => $item_id,
            "title" => $title, "description" => $description, "link_address" => $link_address,
            "visited" => $visited, "notification_date" => $notification_date,
            "notification_time" => $notification_time, "register_date" => $register_date,
            "status" => $status
        );

        $notification = $database_notifications->notifications()->insert($notification_array);
        $notification_id = $notification['id'];
    }
    return $notification_id;
}

function getNotificationMessage($notification_type)
{
    $notification_message = "یک رویداد جدید رخ داده است";

    if ($notification_type == 1) {
        $notification_message = "درخواست عضویت جدید ثبت و منتظر تایید می باشد";
    }
    if ($notification_type == 2) {
        $notification_message = "یک مطلب جدید ثبت و منتظر تایید می باشد";
    }
    if ($notification_type == 3) {
        $notification_message = "یک نظر جدید ثبت و منتظر تایید می باشد";
    }

    return $notification_message;
}

function getNotificationUrl($notification_type)
{
    include "core/config.php";

    $notification_url = "";
    if ($notification_type == 1) {
        $notification_url = $HOST_NAME . "/group_admin/request_management/";
    }
    if ($notification_type == 2) {
        $notification_url = $HOST_NAME . "/group_admin/user_posts/";
    }
    if ($notification_type == 3) {
        $notification_url =  $HOST_NAME . "/group_admin/user_comments/";
    }
    return $notification_url;
}

#endregion


#region Messaging DataBase And Operations

function getMessagingDatabase()
{
    include "core/config.php";

    //crate messaging database connection
    $dsn_messaging = "mysql:dbname={$MESSAGING_DB};host={$MESSAGING_SERVER};charset=utf8";
    $GLOBALS["db_pdo_messaging"] = new PDO($dsn_messaging, "{$MESSAGING_USER}", "{$MESSAGING_PASS}");
    $database_messaging = new NotORM($GLOBALS["db_pdo_messaging"]);
    $database_messaging->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database_messaging->debug = true;

    return $database_messaging;
}


function sendMessage($subject_id, $message_type, $sender_id, $sender_full_name, $sender_photo, $reciever_id, $message)
{
    try {

        $message_id = 0;

        if ($subject_id != null && $sender_id != 0) {

            $register_date = date('Y/m/d H:i:s');

            date_default_timezone_set('Asia/Tehran');
            $message_time = date('H:i:s');
            $message_date = jdate("Y/m/d");
            $message_date = convertPersianToEng($message_date);
            $visit_date_no_slash = str_replace('/', '', $message_date);

            $status = 0;

            $property = array(
                "id" => null,
                "subject_id" => $subject_id,
                "sender_user_id" => $sender_id,
                "sender_full_name" => $sender_full_name,
                "sender_photo" => $sender_photo,
                "message_type" => $message_type,
                "reciever_user_id" => $reciever_id,
                "message" => $message,
                "register_date_fa" => $message_date,
                "register_time_fa" => $message_time,
                "status" => $status
            );

            $database_messaging = getMessagingDatabase();
            $newMessage = $database_messaging->messages()->insert($property);

            $message_id = $newMessage['id'];
        }

        return   $message_id;
    } catch (PDOException $e) {
        return    $e->getMessage();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
}

function groupMessageSeen($subject_id, $user_id, $last_seen_message_id)
{
    try {
        $database_messaging = getMessagingDatabase();

        $user_group_message_id = 0;

        if ($subject_id != null && $user_id != 0 && $last_seen_message_id != 0) {

            $register_date = date('Y/m/d H:i:s');
            $status = 1;

            $database_messaging = getMessagingDatabase();
            $id = null;
            $is_update = false;
            $has_been_saved_already = false;


            $search_result =  $database_messaging->user_group_messages()
                ->select("*")
                ->where("subject_id=?", $subject_id)
                ->where("user_id=?", $user_id)
                ->fetch();

            if ($search_result) {
                $id = $search_result['id'];
                $is_update = true;
                if ($search_result['last_seen_message_id'] == $last_seen_message_id) {

                    $has_been_saved_already = true;
                }
            }
 
            if ($has_been_saved_already == false) {
                $property = array(
                    "id" => $id,
                    "subject_id" => $subject_id,
                    "user_id" => $user_id,
                    "last_seen_message_id" => $last_seen_message_id,
                    "register_date" => $register_date,
                    "status" => $status
                );


                if ($is_update == true) {
                    $updateRes = $search_result->update($property);
                    if($updateRes){
                        $user_group_message_id = $id;
                    }
                } else {
                    $newUserGroupMessage = $database_messaging->user_group_messages()->insert($property);
                    $user_group_message_id = $newUserGroupMessage['id'];
                }
            }
        }

        return   $user_group_message_id;
    } catch (PDOException $e) {
        return    $e->getMessage();
    } catch (Exception $ex) {
        return $ex->getMessage();
    }
}
#endregion
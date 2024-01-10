<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['check']) && $_POST['check'] ==$_SESSION["NOTOFICATIONS_LIST_OP_CODE"]) {

    //csrf_validation_ajax($_POST["_csrf"]);
    $database_notifications = getNotificationsDatabase();

    $notification_type_filter = 0;

    //if notification_type filter is set
    if (isset($_POST["notification_type"])); {
        if (is_numeric($_POST["notification_type"]) && $_POST["notification_type"] != 0) {
            $notification_type_filter = mysql_escape_mimic($_POST["notification_type"]);
        }
    }

    $notification_type_check = "notification_type = ?";
    if ($notification_type_filter == 0) {
        $notification_type_filter = 1;
        $notification_type_check = " 1 = ?";
    }

    $rows = $database_notifications->notifications()
        ->select("*")
        ->where("user_id=?", $_SESSION["user_id"])
        ->where($notification_type_check, $notification_type_filter)
        ->order("id DESC")
        ->limit(10);

        $html= "";    
        foreach($rows as $row){

            $unread_class="";
            if($row["visited"]==0){$unread_class="class=\"un-read\"";}

            $html.="<li " . $unread_class . " >";
            $html.="<div class=\"author-thumb\" >";
            $html.="<img src=\"" . $HOST_NAME . "resources/assets/"  . "img/avatar63-sm.jpg\" alt=\"author\">";
            $html.="</div>";
            $html.="<div class=\"notification-event\">";
            $html.="<div><a href=\"" . $row["link_address"] . "\" class=\"notification-link\">" . $row["description"] . "</a></div>";
            $html.="<span class=\"notification-date\"><time class=\"entry-date updated\" datetime=\"2004-07-24T18:18\">" . $row["notification_date"]. "  " .$row["notification_time"] . "</time></span>";
            $html.="</div>";
            $html.="<span class=\"notification-icon\">";
            $html.="<svg class=\"olymp-happy-face-icon\">";
            $html.="<use xlink:href=\"#olymp-happy-face-icon\"></use>";
            $html.="</svg>";
            $html.="</span>";
            // $html.="<div class=\"more\">";
            // $html.="<svg class=\"olymp-three-dots-icon\">";
            // $html.="<use xlink:href=\"#olymp-three-dots-icon\"></use>";
            // $html.="</svg>";
            // $html.="<svg class=\"olymp-little-delete\">";
            // $html.="<use xlink:href=\"#olymp-little-delete\"></use>";
            // $html.="</svg>";
            // $html.="</div>";
            $html.="</li>";   

        }
    	
							 
        echo json_encode(
            array(
                "status" => "1",
                "html" =>$html,
            )
        );

    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['check']) && $_POST['check'] ==  $_SESSION["NOTOFICATIONS_COUNT_OP_CODE"]) {

    //csrf_validation_ajax($_POST["_csrf"]);
    $database_notifications = getNotificationsDatabase();

    $notification_type_filter = 0;
    
    //if notification_type filter is set
    if (isset($_POST["notification_type"])); {
        if (is_numeric($_POST["notification_type"]) && $_POST["notification_type"] != 0) {
            $notification_type_filter = mysql_escape_mimic($_POST["notification_type"]);
        }
    }

    $notification_type_check = "notification_type = ?";
    if ($notification_type_filter == 0) {
        $notification_type_filter = 1;
        $notification_type_check = " 1 = ?";
    }

    $count = $database_notifications->notifications()
        ->select(" count(id) as c")
        ->where("user_id=?", $_SESSION["user_id"])
        ->where($notification_type_check, $notification_type_filter)
        ->where("visited=?", 0)
        ->fetch();
 
    $get_total_rows = $count["c"];


    echo json_encode(
        array(
            "result" => "1",
            "total_rows" => $get_total_rows,
            "message" => "عملیات موفق",
            "status" => "1",
        )
    );

    exit;
}





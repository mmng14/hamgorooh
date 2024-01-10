<?php
#region layout_select

switch ($_SESSION['user_type']){
    //admin layout
    case "1":
        include $ROOT_DIR . "app/shared/views/_partials/_sidebar_admin.php";
        break;
    //admin subject layout
    case "2":
        include $ROOT_DIR . "app/shared/views/_partials/_sidebar_group_admin.php";
        break;
    //group admin layout
    case "3":
        include $ROOT_DIR . "app/shared/views/_partials/_sidebar_group_admin.php";
        break;
    //group user layout
    case "4":
        include $ROOT_DIR . "app/shared/views/_partials/_sidebar_users.php";
        break;
    //group user layout
    case "5":
        include $ROOT_DIR . "app/shared/views/_partials/_sidebar_users.php";
        break;
    default:
        include $ROOT_DIR . "app/shared/views/_partials/_sidebar_users.php";
        break;

}
#endregion layout_select
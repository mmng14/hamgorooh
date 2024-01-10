<?php

//region page_access_check
function page_access_check_ajax($valid_user_types, $redirect_page)
{
    if (isset($_SESSION['user_type'])) {
        $user_type = $_SESSION['user_type'];
        if (!in_array($user_type, $valid_user_types)) {
            $error = "Access Denied !";
            echo json_encode(
                array(
                    "status" => '0',
                    "redirect" => $redirect_page,
                    "message" => $error,
                )
            );
            http_response_code(403);
            exit;
        }
    } else {
        $error = "Access Denied !";
        echo json_encode(
            array(
                "status" => '0',
                "redirect" => $redirect_page,
                "message" => $error,
            )
        );
        http_response_code(403);
        exit;
    }
}

function page_access_check($valid_user_types, $redirect_page)
{
    $user_type = $_SESSION['user_type'];
    if (!in_array($user_type, $valid_user_types)) {
        http_response_code(403);
        header("Location: {$redirect_page}");
        exit;
    }
}

//endregion page_access_check


//region subject_access_check
function subject_access_check_ajax($subject_id, $valid_roles, $redirect_page)
{
    $access = false;

    $user_type = $_SESSION['user_type'];
    if ($user_type == 1) { //if user is admin
        $access = true;
    } else {

        $user_subjects = $_SESSION["user_subjects"];
        foreach ($user_subjects as $user_subject) {
            if ($user_subject["subject_id"] === $subject_id && ($valid_roles == null || in_array($user_subject["role"], $valid_roles))) {
                $access = true;
            }
        }
    }

    if (!$access) {
        $error = "Access Denied !";
        echo json_encode(
            array(
                "status" => '0',
                "redirect" => $redirect_page,
                "message" => $error,
            )
        );
        http_response_code(403);
        exit;
    }
}

function subject_access_check($subject_id, $valid_roles, $redirect_page)
{


    $access = false;
    $user_type = $_SESSION['user_type'];
    if ($user_type == 1) { //if user is admin
        $access = true;
    } else {
        $user_subjects = $_SESSION["user_subjects"];
        foreach ($user_subjects as $user_subject) {
            if ($user_subject["subject_id"] == $subject_id && ($valid_roles == null || in_array($user_subject["role"], $valid_roles))) {

                $access = true;
            }
        }
    }
    if (!$access) {
        http_response_code(403);
        header("Location: {$redirect_page}");
        exit;
    }
}
//endregion subject_access_check


//region group_access_check
function group_access_check_ajax($group_id, $valid_roles, $redirect_page)
{
    $access = false;
    $user_type = $_SESSION['user_type'];
    if ($user_type == 1) { //if user is admin
        $access = true;
    } else {
        $user_groups = $_SESSION["user_groups"];
        foreach ($user_groups as  $user_group) {
            if ($user_group["group_id"] === $group_id && ($valid_roles == null || in_array($user_group["role"], $valid_roles))) {
                $access = true;
            }
        }
    }
    if (!$access) {
        $error = "Access Denied !";
        echo json_encode(
            array(
                "status" => '0',
                "redirect" => $redirect_page,
                "message" => $error,
            )
        );
        http_response_code(403);
        exit;
    }
}

function group_access_check($group_id, $valid_roles, $redirect_page)
{
    $access = false;
    $user_type = $_SESSION['user_type'];
    if ($user_type == 1) { //if user is admin
        $access = true;
    } else {
        $user_groups = $_SESSION["user_groups"];
        foreach ($user_groups as  $user_group) {
            if ($user_group["group_id"] === $group_id && ($valid_roles == null || in_array($user_group["role"], $valid_roles))) {

                $access = true;
            }
        }
    }
    if (!$access) {
        http_response_code(403);
        header("Location: {$redirect_page}");
        exit;
    }
}
//endregion group_access_check
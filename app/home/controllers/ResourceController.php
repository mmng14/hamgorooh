<?php
//require_once "core/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    include 'libraries/csrf_validation.php';

    $home_page = $database->home_page()
        ->where("status = ?", 1)
        ->order("id desc")
        ->fetch();


    ////////////////////////////////


    if (isset($resource_code)) {

        $subject_resource_id_length = (int) substr($resource_code, 0, 1);
        $subject_resource_id = (int) substr($resource_code, 1, $subject_resource_id_length);

        $subject_resource = $database->subject_resources()
            ->select("*")
            ->where("id = ?", $subject_resource_id)
            ->where("status = ?", 1)
            ->fetch();

        $resource_id = $subject_resource["resource_id"];

        $resource = $database->resources()
            ->select("*")
            ->where("id = ?", $resource_id)
            ->where("status = ?", 1)
            ->fetch();

        $author = $database->authors()
            ->select("*")
            ->where("id = ?", $resource["author_id"])
            ->where("status = ?", 1)
            ->fetch();

        $attachments = $database->resource_attachments()
            ->select("*")
            ->where("resource_id = ?", $resource["id"])
            ->where("status = ?", 1);

        $childAttachments = [];

        if (isset($attachments)) {
            foreach ($attachments as $row) {
                if ($row["parent_id"] != null && $row["parent_id"] != 0) {
                    $childAttachments[] = [
                        "id" =>  $row['id'],
                        "parent_id" =>  $row['parent_id'],
                        "resource_id" =>  $row['resource_id'],
                        "attachment_type" =>  $row['attachment_type'],
                        "photo_address" => $row['photo_address'],
                        "link_address" => $row['link_address'],
                        "title" => $row['title'],
                        "description" => $row['description'],
                        "ordering" => $row['ordering'],
                        "status" =>  $row['status']
                    ];
                }
            }
        }
    }

    $show_header = false;
    $header_title = $resource["title"];

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/home/views/resource.view.php";
    include $ROOT_DIR . "app/shared/views/_layout_home.php";
}

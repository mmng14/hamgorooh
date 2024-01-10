<?php
require_once('../../../libraries/session.php');
require_once('../../../libraries/phpfunction.php');
require_once('../../../core/config.php');
require_once('../../../libraries/image_resize.class.php');


if(isset($_FILES["upload"]["name"]) && isset($_SESSION["upload_folder"]))
{
    $str_store_file_name = GUIDv4();
    $str_store_file_name .= "_" . $_FILES["upload"]["name"];
    $upload_folder = $_SESSION["upload_folder"];
    try{

        $image = new ResizeImage();
        $image->load($_FILES['upload']['tmp_name']);
        $image_width =  $image->getWidth();
        if($image_width > 1000)
        {
            $image->resizeToWidth(1000);
            $save_address = "../../../uploads/{$upload_folder}/" . $str_store_file_name;
            $image->save($save_address);
        }
        else
        {
            move_uploaded_file($_FILES["upload"]["tmp_name"],  "../../../uploads/{$upload_folder}/" . $str_store_file_name);
        }
        // Required: anonymous function reference number as explained above.
        $funcNum = $_GET['CKEditorFuncNum'];
        // Optional: instance name (might be used to load a specific configuration file or anything else).
        $CKEditor = $_GET['CKEditor'];
        // Optional: might be used to provide localized messages.
        $langCode = $_GET['langCode'];
        // Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
        $url = $HOST_NAME . "uploads/{$upload_folder}/" . $str_store_file_name;
        // Usually you will only assign something here if the file could not be uploaded.
        $message = '';

        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";

    }
    catch(Exception $e) {
        echo 'Message: error happend ' .$e->getMessage();
    }
}
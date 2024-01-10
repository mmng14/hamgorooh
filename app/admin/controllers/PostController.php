<?php
 //require_once  "includes/utility_controller.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   

    page_access_check(array(1), $HOST_NAME);
    include 'libraries/csrf_validation.php';

    $active_menu = "post";

    $pagetitle = "پست";
    $pagedesc = "";
    $keywords = "";


    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_full_name = $_SESSION['full_name'];
    $user_photo = $_SESSION['user_photo'];

    $page_number = 1;
    $post_sub_category = 0;

    if (isset($url_cat_id)) {
        $request_category_string = $url_cat_id; //$_GET['cat'];
        $request_category_id = $request_category_string; //decode_url($request_category_string);

        if (is_numeric($request_category_id)) {
            $selected_category_id = (int) $request_category_id;
            $selected_category = $database->category()
                ->select("id,name,subject_id")
                ->where("id = ?", $selected_category_id)
                ->fetch();

            $this_category_id = $selected_category["id"];
            $this_category_name = $selected_category["name"];
            $this_subject_id = $selected_category["subject_id"];

            $SUBJECT_INDEX = $this_subject_id;

            $sub_category_filter_rows = $database->sub_category()
                ->select("*")
                ->where("category_id = ?", $this_category_id)
                ->where("status = ?", 1);


            $UPLOAD_FOLDER = $UPLOAD_ARR[$this_subject_id];;
            $_SESSION["upload_folder"] = $UPLOAD_FOLDER;
        } else {
            echo "<h1>" . $request_category_id . "</h1>";
        }
    }


    if (isset($url_page_number)) {
        if (is_numeric($url_page_number)) {
            $page_number = $url_page_number;
        }
    }

    $category_filter = "";
    $sub_category_filter = "";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;

    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/admin/views/post.view.php";
    return   include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}

//*************************************************************************************
//*********************************   Delete post row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    try {

        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["s_id"]);


        $post_id = test_input($_POST["obj"]);

        $delete_row = $database_subject->post[$post_id];
        $post_thumb = $delete_row['thumb_address'];
        $post_photo = $delete_row['photo_address'];
        $post_type = $delete_row['post_type'];

        if (strpos($post_photo, $HOST_NAME) !== false) {
            $photo_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $post_photo);
            $thumb_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $post_thumb);
        } else {
            $photo_path =$RELATIVE_UPLOAD_FOLDER_PREFIX . $post_photo;
            $thumb_path =$RELATIVE_UPLOAD_FOLDER_PREFIX . $post_thumb;
        }

        if (is_file($thumb_path) && $post_type == '0') // if post type is photo
        {
            unlink($thumb_path);
        }
        if (is_file($photo_path)) {
            unlink($photo_path);
        }

        //Delete content images
        $post_content = $database_subject->post_content()
            ->select("id,content")
            ->where("post_id=?", $post_id)
            ->fetch();

        if ($post_content) {
            $delete_content_row = $database_subject->post_content[$post_content['id']];;

            $content = $delete_content_row['content'];

            $content_photo_path = "";
            $doc = new DOMDocument();
            $doc->loadHTML(htmlspecialchars_decode($content));
            $image_tags = $doc->getElementsByTagName('img');
            foreach ($image_tags as $image_tag) {
                $content_photo_path = $image_tag->getAttribute('src');
                $real_content_photo_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $content_photo_path);
                if (is_file($real_content_photo_path)) {
                    unlink($real_content_photo_path);
                }
            }

            //End delete content images
            $affected = $delete_content_row->delete();
        }

        $affected = $delete_row->delete();

        echo json_encode(
            array(

                "result" => "1",
                "redirect" => "",
                "message" => "رکورد با موفقیت حذف شد",
                "status" => "1",
            )
        );
    } catch (Exception $ex) {
        echo json_encode(
            array(

                "result" => "0",
                "redirect" => "",
                "message" => $ex->getMessage(),
                "status" => "0",
            )
        );
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["MULTI_DELETE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $res = "1";

    try {


        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["s_id"]);

        if (isset($_POST["btndelete"])) {
            $post_ids = $_POST['chk'];
            foreach ($post_ids as $post_id) {
                $post_id = test_input($_POST["obj"]);
                //First Delete Post File
                $delete_row = $database_subject->post[$post_id];
                $post_thumb = $delete_row['thumb_address'];
                $post_photo = $delete_row['photo_address'];
                $post_type = $delete_row['post_type'];

                if (strpos($post_photo, $HOST_NAME) !== false) {
                    $photo_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $post_photo);
                    $thumb_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $post_thumb);
                } else {
                    $photo_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $post_photo;
                    $thumb_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $post_thumb;
                }

                if (is_file($photo_path) && $post_type == '0') {
                    unlink($photo_path);
                }
                if (is_file($thumb_path) && $post_type == '0') // if post type is photo
                {
                    unlink($thumb_path);
                }

                //Delete content images
                $post_content = $database_subject->post_content()
                    ->select("id,content")
                    ->where("post_id=?", $post_id)
                    ->fetch();

                if ($post_content) {
                    $delete_content_row = $database_subject->post_content[$post_content['id']];;

                    $content = $delete_content_row['content'];

                    $content_photo_path = "";
                    $doc = new DOMDocument();
                    $doc->loadHTML(htmlspecialchars_decode($content));
                    $image_tags = $doc->getElementsByTagName('img');
                    foreach ($image_tags as $image_tag) {
                        $content_photo_path = $image_tag->getAttribute('src');
                        $real_content_photo_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $content_photo_path);
                        if (is_file($real_content_photo_path)) {
                            unlink($real_content_photo_path);
                        }
                    }

                    //End delete content images
                    $affected = $delete_content_row->delete();
                }

                $affected = $delete_row->delete();
            }

            echo json_encode(
                array(

                    "result" => "1",
                    "redirect" => "",
                    "message" => "داده ها با موفقیت حذف شد",
                    "status" => "1",
                )
            );
        } else if (isset($_POST["check"])) {
            $post_id = test_input($_POST["obj"]);

            $delete_row = $database_subject->post[$post_id];
            $post_thumb = $delete_row[0]['thumb_address'];
            $post_photo = $delete_row[0]['photo_address'];
            $post_type = $delete_row[0]['post_type'];

            if (strpos($post_photo, $HOST_NAME) !== false) {
                $photo_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $post_photo);
                $thumb_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $post_thumb);
            } else {
                $photo_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $post_photo;
                $thumb_path = $RELATIVE_UPLOAD_FOLDER_PREFIX . $post_thumb;
            }

            if (is_file($thumb_path) && $post_type == '0') // if post type is photo
            {
                unlink($thumb_path);
            }
            if (is_file($photo_path)) {
                unlink($photo_path);
            }

            //Delete content images
            $post_content = $database_subject->post_content()
                ->select("id,content")
                ->where("post_id=?", $post_id)
                ->fetch();

            if ($post_content) {
                $delete_content_row = $database_subject->post_content[$post_content['id']];;

                $content = $delete_content_row['content'];

                $content_photo_path = "";
                $doc = new DOMDocument();
                $doc->loadHTML(htmlspecialchars_decode($content));
                $image_tags = $doc->getElementsByTagName('img');
                foreach ($image_tags as $image_tag) {
                    $content_photo_path = $image_tag->getAttribute('src');
                    $real_content_photo_path = str_replace($HOST_NAME, $RELATIVE_UPLOAD_FOLDER_PREFIX, $content_photo_path);
                    if (is_file($real_content_photo_path)) {
                        unlink($real_content_photo_path);
                    }
                }

                //End delete content images
                $affected = $delete_content_row->delete();
            }

            $affected = $delete_row->delete();

            echo json_encode(
                array(

                    "result" => "1",
                    "redirect" => "",
                    "message" => "رکورد با موفقیت حذف شد",
                    "status" => "1",
                )
            );
        }
    } catch (Exception $ex) {
        echo json_encode(
            array(

                "result" => "0",
                "redirect" => "",
                "message" => $ex->getMessage(),
                "status" => "0",
            )
        );
    }
}
//*************************************************************************************
//**********************************   Activate post row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["ACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $post_id = test_input($_POST["obj"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    if ($post_id != "") {
        $update_row = $database_subject->post[$post_id];
        $post_status = 1;
        $property = array("id" => $post_id, "post_status" => $post_status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}

//*************************************************************************************
//**********************************  DeActivate post row   *******************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["DEACTIVATE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $post_id = test_input($_POST["obj"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    if ($post_id != "") {
        $update_row = $database_subject->post[$post_id];
        $post_status = 0;
        $property = array("id" => $post_id, "post_status" => $post_status);
        $affected = $update_row->update($property);
        echo json_encode(
            array(
                "state" => '1',
            )
        );
    }
}


//*************************************************************************************
//*****************************   Select post row   ***********************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["EDIT_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    // Define variables and set to empty values
    $subject = $category = $sub_category = $user = $keyword = $title = $desc = $status = $comment = $parent = $guid = $ordering = $type = "";
    $attachment = $photo_address = $thumb_address = $ranking = $source_name = $source_link = $total_price = $brief_desc = "";
    $tblId = test_input($_POST["obj"]);

    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    if ($tblId != "") {

        $result = $database_subject->post()
            ->select("*")
            ->where("id=?", $tblId)
            ->fetch();

        $post_content = $database_subject->post_content()
            ->select("id,content")
            ->where("post_id=?", $tblId)
            ->fetch();


        $category = $result['category_id'];
        $sub_category = $result['sub_category_id'];
        $user = $result['user_id'];
        $keywords = $result['keywords'];
        $title = $result['title'];
        $brief_desc = $result['brief_description'];
        $featured = $result['featured'];
        $post_status = $result['post_status'];
        $comment = $result['comment_status'];
        $guid = $result['guid'];
        $ordering = $result['ordering'];
        $post_type = $result['post_type'];
        $attachment = $result['has_attachment'];
        $photo_address = $result['photo_address'];
        $thumb_address = $result['thumb_address'];
        $ranking = $result['ranking'];
        $user_post = $result['user_post'];
        $total_price = $result['total_price'];
        $source_name = $result['source_name'];
        $source_link = $result['source_link'];
        $status = $result['status'];


        $desc = "";

        $desc = $post_content['content'];


        echo json_encode(
            array(
                "category" => $category,
                "sub_category" => $sub_category,
                "user" => $user,
                "keywords" => html_entity_decode($keywords, ENT_COMPAT, 'UTF-8'),
                "title" => $title,
                "brief_desc" => html_entity_decode($brief_desc, ENT_COMPAT, 'UTF-8'),
                "desc" => $desc,
                "featured" => $featured,
                "post_status" => $post_status,
                "comment" => $comment,
                "guid" => $guid,
                "seq" => $ordering,
                "post_type" => $post_type,
                "attachment" => $attachment,
                "photo" => $photo_address,
                "thumb" => $thumb_address,
                "ranking" => $ranking,
                "total_price" => $total_price,
                "source_name" => $source_name,
                "source_link" => $source_link,
                "status" => $status,
            )
        );
    }
}

//*************************************************************************************
//*********************************  Send to telegram   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_TELEGRAM_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    //Get the post
    try {


        $post_id = $_POST["obj"];
        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["s_id"]);
        $post = $database_subject->post()
            ->select("*")
            ->where("id=?", $post_id)
            ->fetch();

        $category_id = $post["category_id"];


        //find this category token and Id
        $telegram_token = "254709733:AAH1XT0BvBynhGEG3tWPap3BCHtKs46KxqQ";
        $telegram_id = "@hamgorooh";

        $category = $database->category()
            ->select("id,name,url_name,telegram_token,telegram_id")
            ->where("id = ?", $category_id)
            ->where("status = ?", 1)
            ->fetch();

        if ($category) {
            if (isset($category["telegram_token"]) && $category["telegram_token"] != "") $telegram_token = $category["telegram_token"];
            if (isset($category["telegram_id"]) && $category["telegram_id"] != "") $telegram_id = $category["telegram_id"];
        }
        //-------------------------------
        $subj_id = $post["subject_id"];
        $cat_id = $post["category_id"];
        $subj_id_length = strlen($subj_id);
        $cat_id_length = strlen($cat_id);
        $post_id_length = strlen($post_id);
        $photo_address = $post["photo_address"];
        if (strpos(strtolower($photo_address), 'http') === false) {
            $photo_address = $HOST_NAME . $photo_address;
        }
        $title = $post['title'];
        //--------------------------------
        $telegeram_link = $HOST_NAME . "post/{$subj_id_length}{$subj_id}{$cat_id_length}{$cat_id}{$post_id_length}{$post_id}/{$post[0]["post_name"]}";

        if (isset($photo_address) && $photo_address != "") { // There is  Photo
            $telegram_photo = $photo_address;
        } else // There is no type selected
        {
            $telegram_photo = $HOST_NAME . "resources/admin/img/hg.png";
        }
        $telegram_caption = $title . urlencode("\r\n") . $telegeram_link . urlencode("\r\n\r\n") . $telegram_id;
        Telegram::SendPhoto($telegram_token, $telegram_id, $telegram_photo, $telegram_caption);

        Disconnect();
        echo json_encode(
            array(
                "status" => "1",
                "message" => $telegram_token . " ---- " . $telegram_id . " ---- " . $telegram_photo . " ---- " . $telegram_caption,
                // "message" =>"پست با موفقیت  به تلگرام ارسال شد",
            )
        );
    } catch (exception $ex) {
        echo json_encode(
            array(
                "status" => "0",
                "message" => "خطا در ارسال پست به تلگرام",
            )
        );
    }
}

//*************************************************************************************
//*********************************  Send to reportage   *******************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_REPORTAGE_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    //Get the post
    try {

        $post_id = $_POST["obj"];
        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["s_id"]);

        $post = $database_subject->post()
            ->select("*")
            ->where("id=?", $post_id)
            ->fetch();

        $category_id = $post["category_id"];
        //-------------------------------
        $subj_id = $post["subject_id"];
        $cat_id = $post["category_id"];
        $sub_cat_id = $post["sub_category_id"];
        $subj_id_length = strlen($subj_id);
        $cat_id_length = strlen($cat_id);
        $post_id_length = strlen($post_id);

        $title = $post['title'];
        $post_name = $post["post_name"];
        $keywords = $post["keywords"];
        $post_date = $post["reg_date"];

        date_default_timezone_set('Asia/Tehran');
        $today_date = convertPersianToEng(jdate('Y/m/d'));
        $reg_date = $today_date;
        $reportage_photo_address = $post["photo_address"];
        $reportage_thumb_address = $post["thumb_address"];

        if (strpos(strtolower($reportage_photo_address), 'http') === false) {
            $reportage_photo_address = $HOST_NAME . $reportage_photo_address;
            $reportage_thumb_address = $HOST_NAME . $reportage_thumb_address;
        }

        //--------------------------------
        $post_code = "{$subj_id_length}{$subj_id}{$cat_id_length}{$cat_id}{$post_id_length}{$post_id}";
        $reportage_link = $HOST_NAME . "post/{$post_code}/{$post_name}";


        $reportage_find = $database->reportage()
            ->select("id")
            ->where("post_code = ?", $post_code)
            ->fetch();

        //Insert
        if ($reportage_find) {
            $reportage_id = $reportage_find["id"];

            $reportage_post = array(
                "subject_id" => $subj_id, "category_id" => $cat_id,
                "sub_category_id" => $sub_cat_id, "post_code" => $post_code, "title" => $title, "author" => "همگروه", "post_type" => "12", "url_name" => $post_name,
                "photo_address" => $reportage_photo_address, "thumb_address" => $reportage_thumb_address, "link_address" => $reportage_link, "post_date" => $post_date, "reg_date" => $reg_date, "featured" => "1", "visit" => "0", "keywords" => $keywords
            );
            $reportage = $database->reportage[$reportage_id];
            $affected_post = $reportage->update($reportage_post);

            //Update
        } else {


            $reportage_post = array(
                "id" => null, "subject_id" => $subj_id, "category_id" => $cat_id,
                "sub_category_id" => $sub_cat_id, "post_code" => $post_code, "title" => $title, "author" => "همگروه",
                "post_type" => 12, "url_name" => $post_name, "photo_address" => $reportage_photo_address,
                "thumb_address" => $reportage_thumb_address, "link_address" => $reportage_link,
                "post_date" => $post_date, "reg_date" => $reg_date, "featured" => 1, "visit" => 0,
                "status" => 0, "keywords" => $keywords
            );


            $reportage = $database->reportage()->insert($reportage_post);
            $reportage_id = $reportage['id'];
        }


        echo json_encode(
            array(
                "status" => "1",
                "result" => $reportage_id,
                "message" => "ارسال به ریپورتاژ با موفقیت",

            )
        );
    } catch (PDOException $ex) {
        echo json_encode(
            array(
                "status" => "0",
                "result" => $ex->getMessage(),
                "message" => "خطا در ارسال ریپورتاژ",
            )
        );
    }
}

//*************************************************************************************
//*********************************  Send to Subject Site   ***************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["SEND_TO_SUBJECTS_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    //Get the post
    try {
        //Set Subject Database Connection
        $database_subject = getSubjectDatabase($_POST["s_id"]);

        $post_id = $_POST["obj"];
        $post = $database_subject->post()
            ->select("*")
            ->where("id=?", $post_id)
            ->fetch();

        //-------------------------------
        if ($post) {
            $main_subj_id = $post["subject_id"];
            $main_cat_id = $post["category_id"];
            $main_sub_cat_id = $post["sub_category_id"];
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);
            $post_id_length = strlen($post_id);
            $subcategory_id_length = 0;
            $photo_address = $post['photo_address'];
            $thumb_address = $post['thumb_address'];
            $title = $post['title'];
            $post_name = $post["post_name"];
            $keywords = $post["keywords"];
            $reg_date = $post["reg_date"];
            $status = $post["status"];

            $post_code = "{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$post_id}";
            $item_link_address = $HOST_NAME . "iframe/{$post_code}/" . $post_name;

            $referal_photo_address = $HOST_NAME . $photo_address;
            $referal_thumb_address = $HOST_NAME . $thumb_address;


            $datatopost = array(
                "post_code" => "$post_code", "subject_id" => "$main_subj_id", "category_id" => "$main_cat_id",
                "sub_category_id" => "$main_sub_cat_id", "title" => "$title", "url_name" => "$post_name", "keywords" => $keywords,
                "photo_address" => "$referal_photo_address", "thumb_address" => "$referal_thumb_address", "link_address" => "$item_link_address", "post_date" => "$reg_date", "reg_date" => "$reg_date", "post_type" => "1", "status" => $status
            );


            $return_data = "failed";
            $remote_url = "not found";


            $subject_site = $database->subject_sites()
                ->select("id,subject_id,recieve_link")
                ->where("subject_id = ?", $main_subj_id)
                ->fetch();

            if ($subject_site) {

                $remote_url = $subject_site["recieve_link"] . "insert/post";
                $ch = curl_init($remote_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $return_data = curl_exec($ch);


                echo json_encode(
                    array(
                        "status" => "1",
                        "result" => $return_data,
                        "message" => " ارسال به سایت " . $subject_site["recieve_link"],

                    )
                );
            } else {
                echo json_encode(
                    array(
                        "status" => "0",
                        "result" => "failed",
                        "message" => " سایت مورد نظر یافت نشد ",

                    )
                );
            }
        } else {
            echo json_encode(
                array(
                    "status" => "0",
                    "result" => "failed",
                    "message" => " پست مورد نظر یافت نشد ",

                )
            );
        }
    } catch (PDOException $ex) {
        echo json_encode(
            array(
                "status" => "0",
                "result" => $ex->getMessage(),
                "message" => "خطا در ارسال به سایت",
            )
        );
    }
}

//*************************************************************************************
//*****************************   sub_category List for combobox   ********************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_SUBCATEGORY_LIST_CODE"]) {

    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $categoryId = $sub_category_id = 0;


    $user_id = $_SESSION["user_id"];
    // Define variables and set to empty values
    $txtsub_category = "";
    $categoryId = test_input($_POST['c']);
    $sub_category_id = test_input($_POST['sc']);

    if ($categoryId != "") {
        $rows = $database->sub_category()
            ->select("*")
            ->where("status=?", 1)
            ->where("category_id=?", $categoryId);


        $txtsub_category .= "<option value='0' />انتخاب کنید";
        foreach ($rows as $result) {
            if ($sub_category_id != 0 && $sub_category_id == $result["id"])
                $txtsub_category .= "<option value='" . $result["id"] . "' selected />" . $result["name"];
            else
                $txtsub_category .= "<option value='" . $result["id"] . "' />" . $result["name"];
        }
    }
    echo $txtsub_category;
}

//*************************************************************************************
//********************************   post  List   *************************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && 
    isset($_POST["cmd"]) && $_POST["cmd"] == $_SESSION["LISTING_CODE"] && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
) {
    
    page_access_check_ajax(array(1), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    $user_id = 0;
    $user_id = $_SESSION["user_id"];

    $cat_filter = 0;

    //if category filter is set
    if (isset($_POST["cf"])); {
        if (is_numeric($_POST["cf"]) && $_POST["cf"] != 0) {
            $cat_filter = mysql_escape_mimic($_POST["cf"]);
        }
    }

    //if sub category filter is set
    $sub_category_filter_where = "";
    $sub_cat_filter = 0;
    if (isset($_POST["scf"])); {
        if (is_numeric($_POST["scf"]) && $_POST["scf"] != 0) {
            $sub_cat_filter = mysql_escape_mimic($_POST["scf"]);
        }
    }
    //------------------
    $search_exp = "";
    // Define variables and set to empty values
    if (isset($_POST["exp"])) {
        $search_exp = mysql_escape_mimic($_POST["exp"]);
    }

    //--------------------------- page -----------------------------
    //Get page number from Ajax POST
    if (isset($_POST["page"])) {
        $page_number = filter_var(mysql_escape_mimic($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if (!is_numeric($page_number)) {
            die('Invalid page number!');
        } //incase of invalid page number
    } else {
        $page_number = 1; //if there's no page number, set it to 1
    }
    //------------------------------------------------------------
    //-------------------------- perpage -------------------------
    if (isset($_POST['perpage'])) {
        $item_per_page = mysql_escape_mimic($_POST['perpage']);
    } else
        $item_per_page = 10;
    //---------------------------------------------------------------
    //-------------------------- order -------------------------------
    if (isset($_POST['order'])) {
        $orderBy = mysql_escape_mimic($_POST['order']);
        if ($orderBy == 1) $order = 'id DESC';
        else if ($orderBy == 2) $order = 'id ASC';
    } else {
        $orderBy = 2;
        $order = 'id DESC';
    }


    $category_check = "category_id = ?";
    if ($cat_filter == 0) {
        $cat_filter = 1;
        $category_check = " 1 = ?";
    }

    $subcategory_check = "sub_category_id = ?";
    if ($sub_cat_filter == 0) {
        $sub_cat_filter = 1;
        $subcategory_check = " 1 = ?";
    }

    $count = $database_subject->post()
        ->select(" count(id) as c")
        ->where($category_check, $cat_filter)
        ->where($subcategory_check, $sub_cat_filter)
        ->where("title LIKE ?", "%{$search_exp}%")
        ->fetch();

    //------------
    $get_total_rows = $count["c"] !=null ? $count["c"] : 0;
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    if ($total_pages < $page_number)
        $page_number = 1;

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);


    $rows = $database_subject->post()
        ->select("*")
        ->where($category_check, $cat_filter)
        ->where($subcategory_check, $sub_cat_filter)
        ->where("title LIKE ?", "%{$search_exp}%")
        ->order($order)
        ->limit($item_per_page, $page_position);

    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );

    $data = array();
    $data['list'] = $rows;
    $data['pagination'] = $pagination;
    //echo json_encode($data);

    $html = view_to_string("_posts.php", "app/admin/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);
    echo $html;
    exit;
}

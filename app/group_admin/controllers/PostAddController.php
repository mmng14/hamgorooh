<?php



if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    page_access_check(array(1,2), $HOST_NAME);
    include 'libraries/csrf_validation.php';

    $active_menu = "post";

    $pagetitle = "پست";
    $pagedesc = "";
    $keywords = "";

    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_full_name = $_SESSION['full_name'];
    $user_photo = $_SESSION['user_photo'];

    $page_number = '0';

    $post_sub_category = 0;

    $add_update = "add";
    $form_title = "فرم افزودن پست";

    $edit_id = "";
    $edit_subject_id = "";
    $edit_category_id = "";
    $selected_category_id = "0";
    $edit_sub_category_id = "";
    $selected_subcategory_id = "0";
    $edit_keywords = "";
    $edit_post_name = "";
    $edit_title = "";
    $edit_brief_description = "";
    $edit_user_full_name = "";
    $edit_photo_address = "";
    $edit_source_name = "";
    $edit_source_link = "";
    $edit_content = "";
    $edit_comment_status="0";
    $edit_post_status="1";

    if (isset($url_subject_id) && is_numeric($url_subject_id)) {

        $selected_subject_id = (int)$url_subject_id;
        //Check Subject Access
        subject_access_check($selected_subject_id, array(1,2), $HOST_NAME);

        $SUBJECT_INDEX = $selected_subject_id;

        $category_filter_rows = $database->category()
            ->select("*")
            ->where("subject_id = ?", $selected_subject_id)
            ->where("status = ?", 1);

        $database_subject = getSubjectDatabase($selected_subject_id);
        //--------------------

        $UPLOAD_FOLDER = $UPLOAD_ARR[$selected_subject_id];
        $upload_folder_session_name = GUIDv4();
        $_SESSION[$upload_folder_session_name] = $UPLOAD_FOLDER;

        if (isset($url_post_id)) {

            $post_id = $url_post_id;


            $post = $database_subject->post()
                ->select("id,subject_id,category_id,sub_category_id,user_id,post_name,title,keywords,brief_description,user_full_name,reg_date,photo_address,thumb_address,source_name,source_link,comment_status,post_status")
                ->where("id = ?", $post_id)
                //->where("status = ?", 1)
                ->fetch();

            if (isset($post) && $post) {

                $post_content = $database_subject->post_content()
                    ->select("id,content")
                    ->where("post_id = ?", $post_id)
                    ->fetch();

                $edit_id = $post["id"];
                $edit_subject_id = $post["subject_id"];
                $edit_category_id = $post["category_id"];
                $selected_category_id = $edit_category_id;
                $edit_sub_category_id = $post["sub_category_id"];
                $selected_subcategory_id = $edit_sub_category_id;
                $edit_keywords = $post["keywords"];
                $edit_post_name = $post["post_name"];
                $edit_title = $post["title"];
                $edit_brief_description = $post["brief_description"];
                $edit_user_full_name = $post["user_full_name"];
                $edit_photo_address = $post["photo_address"];
                $edit_thumb_address = $post["thumb_address"];
                $edit_source_name = $post["source_name"];
                $edit_source_link = $post["source_link"];
                $edit_content = $post_content["content"];
                $edit_comment_status= $post["comment_status"];
                $edit_post_status= $post["post_status"];
                
                $add_update = "update";
                $form_title = "فرم ویرایش پست";

                $selected_subcategory_rows = $database->sub_category()
                    ->select("*")
                    ->where("category_id = ?", $edit_category_id)
                    ->where("status = ?", 1);
            }
        }
    } else {
        redirect_to($HOST_NAME);
    }


    //default page number
    $page_number = 1;

    if (isset($url_page_number)) {

        $page_number_string = $url_page_number;

        if (is_numeric($page_number_string)) {
            $page_number = (int) $page_number_string;
        }
    }

    $category_filter = "";
    $sub_category_filter = "";

    $HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
    $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'] . $SUBFOLDER_NAME;
    //and then call a template:
    $page_title = "همگروه - بانک اطلاعات عمومی";
    $page_content = $ROOT_DIR . "app/group_admin/views/post_add.view.php";
    return include $ROOT_DIR . "app/shared/views/_layout_admin.php";
}


//*************************************************************************************
//*****************************   Set upload folder   ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == "S2p5kk82XzrTP") {
    page_access_check_ajax(array(1,2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    $folder_subject_id = test_input($_POST["s_id"]);
    $folder_category_id = test_input($_POST["c_id"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);

    $UPLOAD_FOLDER = $UPLOAD_ARR[$folder_subject_id];
    $_SESSION["upload_folder"] = $UPLOAD_FOLDER;
    echo json_encode(
        array(
            "state" => '1',
            "message" => 'عملیات موفقیت آمیز',
        )
    );
}
//*************************************************************************************
//*****************************   upload post image  **********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["POST_IMAGE_UPLOAD_CODE"]) {


    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);


    //todo check validation later
    $upload_folder_name = test_input($_POST["upload_folder"]);
    $this_subject_id = test_input($_POST["s_id"]);
    $this_category_id = test_input($_POST["c_id"]);
    $UPLOAD_FOLDER = $UPLOAD_ARR[$this_subject_id];
    $_SESSION["upload_folder"] = $UPLOAD_FOLDER;

    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($this_subject_id);
    //TODO Save image to folder and  database
    //-----------UPLOAD FILE-----------------
    $thumb_address = "";
    $photo_address = "";



    if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $uploadfile = $_FILES['upload']['tmp_name'];
        $uploadname = $_FILES['upload']['name'];
        $uploadtype = $_FILES['upload']['type'];
        $extension = getExtension($uploadname);

        //--for image files

        if (isValidPhotoExtension($extension)) {
            //upload the file in services folder
            $extension = '.' . $extension;


            //--Resizing the photo for thumb-----
            $image = new ResizeImage();
            $image->load($_FILES['upload']['tmp_name']);
            $image->resizeToWidth(240);

            $guid = GUIDv4();
            //-----Save the thumb Size file-------
            $thumb_save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . "uploads/{$UPLOAD_FOLDER}/thumb_{$guid}{$extension}";
            $thumb_address = "uploads/{$UPLOAD_FOLDER}/thumb_{$guid}{$extension}";
            $image->save($thumb_save_address);
            unset($image);

            //-----Save the real Size file-------
            $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . "uploads/{$UPLOAD_FOLDER}/{$guid}{$extension}";
            $photo_address = "uploads/{$UPLOAD_FOLDER}/{$guid}{$extension}";
            move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
        } else {
            $msg = "نوع فایل معتبر نمی باشد";
        }
    }

    //----------------------------
    if ($thumb_address == "" || $photo_address == "") {
        $error = 'هیچ فایلی انتخاب نشده است';
        echo json_encode(
            array(
                "status" => '0',
                "message" => $error,
            )
        );
        exit;
    }

    try {

        $reg_date = date("Y-m-d H:i:s");
        $status = 1;
        $title = $uploadname;
        $user_id = $_SESSION['user_id'];

        $image_array = array(
            "id" => null,
            "title" => $title,
            "photo_address" => $photo_address, "thumb_address" => $thumb_address,
            "user_id" => $user_id,
            "subject_id" => $this_subject_id, "category_id" => $this_category_id,
            "register_date" => $reg_date,
            "status" => $status
        );

        $image_row = $database_subject->images()->insert($image_array);
    } catch (PDOException $ex) {
        echo json_encode(
            array(
                "status" => '0',
                "message" => $ex->getMessage(),
                "data" => $image_array
            )
        );
    }

    $image_id = $image_row['id'];

    if ($image_id == null || $image_id == '') {
        $error = 'خطا در افزودن داده ها.';
        echo json_encode(
            array(
                "status" => '0',
                "message" => $error,
                "data" => $image_array
            )
        );
        exit;
    } else {

        echo json_encode(
            array(
                "state" => '1',
                "image_id" => $image_id,
                "image_address" => $HOST_NAME . $photo_address, // "https://www.hamgorooh.com/uploads/sport/389cf0cf-572d-41f4-8fd0-d29efe957b22__va4-754.jpg",
                "message" => 'عملیات موفقیت آمیز',
            )
        );
    }
}

//*************************************************************************************
//*****************************   List Images ***********************************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&   isset($_POST["check"]) && $_POST["check"] == $_SESSION["POST_IMAGE_LIST_CODE"]) {


    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["s_id"]);
    $user_id = 0;
    $user_id = $_SESSION["user_id"];

    //--------------------------- user -----------------------------
    $user_check = "user_id = ?";
    $user_filter = $user_id;

    //--------------------------- subject -----------------------------
    $subject_check = "subject_id = ?";
    $subject_filter = $_POST["s_id"];

    //--------------------------- category -----------------------------
    $cat_filter = 0;
    //if category filter is set
    if (isset($_POST["cf"])); {
        if (is_numeric($_POST["cf"]) && $_POST["cf"] != 0) {
            $cat_filter = mysql_escape_mimic($_POST["cf"]);
        }
    }
    $category_check = "category_id = ?";
    if ($cat_filter == 0) {
        $cat_filter = 1;
        $category_check = " 1 = ?";
    }


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
        $item_per_page = 9;
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



    $count = $database_subject->images()
        ->select(" count(id) as c")
        ->where($user_check, $user_filter)
        ->where($subject_check, $subject_filter)
        ->where($category_check, $cat_filter)
        ->where("title LIKE ?", "%{$search_exp}%")
        ->fetch();

    //------------
    $get_total_rows = $count["c"];
    //break records into pages

    $total_pages = ceil($get_total_rows / $item_per_page);

    //get starting position to fetch the records
    $page_position = (($page_number - 1) * $item_per_page);

    $rows = $database_subject->images()
        ->select("*")
        ->where($user_check, $user_filter)
        ->where($subject_check, $subject_filter)
        ->where($category_check, $cat_filter)
        ->where("title LIKE ?", "%{$search_exp}%")
        ->order($order)
        ->limit($item_per_page, $page_position);

    $page_number++;

    $pagination = array(
        "item_per_page" => $item_per_page,
        "page_number" => $page_number,
        "total_rows" => $get_total_rows,
        "total_pages" => $total_pages,
    );

    $data = array();
    $data['list'] = $rows;
    $data['pagination'] = $pagination;


    $html = view_to_string("_photoList.php", "app/users/views/partial/", $rows, $pagination, $SUBFOLDER_NAME, $HOST_NAME);

    echo json_encode(
        array(
            "status" => '1',
            "html" => $html,
            "page_number" => $page_number,
            "message" => 'عملیات موفقیت آمیز',
        )
    );
    exit;
}

//*************************************************************************************
//*****************************   sub_category List for combobox   ********************
//*************************************************************************************
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["check"]) && $_POST["check"] == $_SESSION["GET_SUBCATEGORY_LIST_CODE"]) {

    page_access_check(array(1, 2), $HOST_NAME);
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


        $txtsub_category .= '<option value="0" >انتخاب کنید</option>';
        foreach ($rows as $result) {
            if ($sub_category_id != 0 && $sub_category_id == $result["id"])
                $txtsub_category .= '<option value="' . $result["id"] . '" selected >' . $result["name"] . '</option>';
            else
                $txtsub_category .= '<option value="' . $result["id"] . '" >' . $result["name"] . '</option>';
        }
    }

    echo json_encode(
        array(
            "status" => "1",
            "html" =>  $txtsub_category,
            "message" => "عملیات با موفقیت  انجام شد",
        )
    );
    //echo $txtsub_category;
}


//*************************************************************************************
//**************************************** Add post ***********************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["INSERT_CODE"]) {


    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $this_subject_id = 0;
    $this_subject_id = mysql_escape_mimic($_POST['subject_id']);
    $this_category_id = mysql_escape_mimic($_POST['category_id']);

    subject_access_check_ajax($this_subject_id, array(1, 2), $HOST_NAME);
    //group_access_check_ajax($this_category_id, null, $HOST_NAME);


    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_full_name = $_SESSION['full_name'];
    $user_photo = $_SESSION['user_photo'];


    $post_sub_category = 0;
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["subject_id"]);

    //default page number
    $page_number = 1;
    if (isset($_POST["page_number"])) {

        $page_number_string = $_POST["page_number"];

        if (is_numeric($page_number_string)) {
            $page_number = (int) $page_number_string;
        }
    }


    $post_status = 0;
    $featured = 0;
    $this_sub_category_id = 0;

    //--Get  Group Folder

    $group_data_name = "others";
    $category_type = "1";

    $category = $database->category()
        ->select("id,data_name,subject_id,category_type")
        ->where("id=?", $this_category_id)
        ->fetch();

    $group_data_name = $category['data_name'];
    $category_type = $category['category_type'];

    //---------------

    if (isset($_POST['sub_category_id']))
        $this_sub_category_id = mysql_escape_mimic($_POST['sub_category_id']);
    else
        $this_sub_category_id = 0;
    $keywords = mysql_escape_mimic($_POST['keywords']);
    $title = mysql_escape_mimic($_POST['title']);
    $brief_desc = mysql_escape_mimic($_POST['brief_description']);
    //$desc = $_POST['description'];
    $desc =  base64_decode($_POST['description']);
    $attachment = 0;
    $visit_count = 0;
    $comment_count = 0;
    $like_count = 0;
    $dislike_count = 0;
    $photo_address = '';
    $thumb_address = '';
    $ranking = 0;
    $total_price = 0;
    $source_name = mysql_escape_mimic($_POST['source_name']);
    $source_link = mysql_escape_mimic($_POST['source_link']);
    $comment_status = mysql_escape_mimic($_POST['comment_status']);
    $post_status = mysql_escape_mimic($_POST['post_status']);
    $reg_date = jdate('Y/m/d');
    $update_date = '';
    $parent = 0;
    $has_child = 0;
    $guid = GUIDv4();
    $post_type = 0;

    $user_post = 1;
    $ordering = 1;

    $status = 0;
    $register_date = date('Y/m/d H:i:s');
    //-----------

    $post_name = sanitize(clean($title));

    //-----------UPLOAD FILE-----------------
    $UPLOAD_FOLDER = $UPLOAD_ARR[$this_subject_id];
    if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $uploadfile = $_FILES['upload']['tmp_name'];
        $uploadname = $_FILES['upload']['name'];
        $uploadtype = $_FILES['upload']['type'];
        $extension = getExtension($uploadname);

        //--for image files
        if ($post_type == '0') {
            if (isValidPhotoExtension($extension)) {
                //upload the file in services folder
                $extension = '.' . $extension;


                //--Resizing the photo for thumb-----
                $image = new ResizeImage();
                $image->load($_FILES['upload']['tmp_name']);
                $image->resizeToWidth(240);

                //-----Save the thumb Size file-------
                $thumb_save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . "uploads/{$UPLOAD_FOLDER}/thumb_{$guid}{$extension}";
                $thumb_address = "uploads/{$UPLOAD_FOLDER}/thumb_{$guid}{$extension}";
                $image->save($thumb_save_address);
                unset($image);

                //-----Save the real Size file-------
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . "uploads/{$UPLOAD_FOLDER}/{$guid}{$extension}";
                $photo_address = "uploads/{$UPLOAD_FOLDER}/{$guid}{$extension}";
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            } else {
                $msg = "<div class='error'>نوع فایل معتبر نمی باشد</div>";
            }
        }

        //----End for Photo
    }
    //----------------------------
    $post_array = array(
        "id" => null, "category_type" => $category_type, "subject_id" => $this_subject_id,
        "category_id" => $this_category_id, "sub_category_id" => $this_sub_category_id,
        "user_id" => $user_id, "user_name" => $user_name, "user_full_name" => $user_full_name,
        "user_photo" => $user_photo, "keywords" => $keywords, "post_name" => $post_name,
        "title" => $title, "brief_description" => $brief_desc, "featured" => $featured, "post_status" => $post_status,
        "comment_status" => $comment_status, "reg_date" => $reg_date,
        "update_date" => $update_date, "guid" => $guid,
        "post_type" => $post_type, "has_attachment" => $attachment, "visit_count" => $visit_count,
        "comment_count" => $comment_count, "like_count" => $like_count, "dislike_count" => $dislike_count,
        "photo_address" => $photo_address, "thumb_address" => $thumb_address,
        "ranking" => $ranking, "total_price" => $total_price, "source_name" => $source_name, "source_link" => $source_link,
        "user_post" => $user_post, "ordering" => $ordering, "status" => $status
    );


    $post = $database_subject->post()->insert($post_array);
    $post_id = $post['id'];

    if ($post_id == null || $post_id == '') {
        $error = 'خطا در افزودن داده ها.';
        echo json_encode(
            array(
                "status" => '0',
                "message" => $error,
            )
        );
        exit;
    } else {
        $content_images = "";
        $content = $desc;
        $doc = new DOMDocument();
        $doc->loadHTML($content);
        $image_tags = $doc->getElementsByTagName('img');

        foreach ($image_tags as $image_tag) {
            $content_images .= $image_tag->getAttribute('src') . ",";
        }

        $post_content_array = array("id" => null, "post_id" => $post_id, "post_guid" => $guid, "post_date" => $reg_date, "content" => $desc, "content_photos" => $content_images);
        $post_content_result = $database_subject->post_content()->insert($post_content_array);
        $post_content_id = $post_content_result["id"];
        $msg_ok = "<div class='success'>افزودن داده ها با موفقیت انجام شد </div> ";

        //Start Notifications
        $notification_type = $NOTIFICATION_TYPE_USER_POST; //Add user post      
        $notification_id = addNotification($notification_type, 0, $this_subject_id, $post_id);
        //End Notification  

        ////////////SEO(Send to Referal Sites)///////

        if ($post_content_id != null && $post_content_id != '') {

            $main_subj_id = $this_subject_id;
            $main_cat_id = $this_category_id;
            $subj_id_length = strlen($main_subj_id);
            $cat_id_length = strlen($main_cat_id);
            $post_id_length = strlen($post_id);
            $subcategory_id_length = 0;
            $subcategory_id = "";

            $post_code = "{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$post_id}";
            $item_link_address = $HOST_NAME . "iframe/{$post_code}/" . $post_name;


            $referal_photo_address = $HOST_NAME . $photo_address;
            $referal_thumb_address = $HOST_NAME . $thumb_address;
            $datatopost = array(
                "post_code" => "$post_code", "subject_id" => "$this_subject_id", "category_id" => "$this_category_id",
                "sub_category_id" => "$this_sub_category_id", "title" => "$title", "url_name" => "$post_name", "keywords" => $keywords,
                "photo_address" => "$referal_photo_address", "thumb_address" => "$referal_thumb_address", "link_address" => "$item_link_address", "post_date" => "$reg_date", "reg_date" => "$reg_date", "post_type" => "1", "status" => $status
            );


            $subject_site = $database->subject_sites()
                ->select("id,subject_id,recieve_link")
                ->where("subject_id = ?", $this_subject_id)
                ->order("id asc")
                ->fetch();

            $remote_url = "";
            if ($subject_site) {
                $remote_url = $subject_site["recieve_link"] . "insert/post";
            }

            //insert to main db post table
            $main_db_post_property = array(
                "id" => null, "subject_id" => $this_subject_id, "category_id" => $this_category_id,
                "sub_category_id" => $this_sub_category_id, "post_code" => $post_code, "title" => $title, "url_name" => $post_name,
                "photo_address" => $referal_photo_address, "thumb_address" => $referal_thumb_address, "link_address" => $item_link_address, "post_date" => $reg_date, "register_date" => $register_date, "robot_status" => 0, "subject_address" => $remote_url, "status" => 0
            );


            $database->post()->insert($main_db_post_property);
        }

        /////////////////////////////////////////////
        //header("Location: {$HOST_NAME}/admin/posts/{$this_category_id}");
        $msg = "عملیات با موفقیت به پایان رسید";
        ///{$page_number
        $redirect =  "{$HOST_NAME}group_admin/posts/{$this_subject_id}";
        echo json_encode(
            array(
                "status" => '1',
                "message" => $msg_ok,
                "redirect" => $redirect,
            )
        );
        exit;
    }
}

//*************************************************************************************
//************************************* Update post ***********************************
//*************************************************************************************

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check']) && $_POST['check'] == $_SESSION["UPDATE_CODE"]) {


    page_access_check_ajax(array(1, 2), $HOST_NAME);
    csrf_validation_ajax($_POST["_csrf"]);

    $this_subject_id = 0;
    $this_subject_id = mysql_escape_mimic($_POST['subject_id']);
    $this_category_id = mysql_escape_mimic($_POST['category_id']);


    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
    $user_full_name = $_SESSION['full_name'];
    $user_photo = $_SESSION['user_photo'];


    $post_sub_category = 0;
    //Set Subject Database Connection
    $database_subject = getSubjectDatabase($_POST["subject_id"]);


    subject_access_check_ajax($this_subject_id, array(1, 2), $HOST_NAME);
    //group_access_check_ajax($this_category_id, null, $HOST_NAME);


    //default page number
    $page_number = 1;
    if (isset($_POST['page_num'])) {

        $page_number_string = mysql_escape_mimic($_POST['page_num']);

        if (is_numeric($page_number_string)) {
            $page_number = $page_number_string;
        }
    }


    //TODO hash later
    $post_id = mysql_escape_mimic($_POST['hashId']);

    $category = $database->category()
        ->select("id,data_name,subject_id,category_type")
        ->where("id=?", $this_category_id)
        ->fetch();

    $group_data_name = $category['data_name'];
    $category_type = $category['category_type'];
    //---------------
    if (isset($_POST['sub_category_id']))
        $this_sub_category_id = mysql_escape_mimic($_POST['sub_category_id']);
    else
        $this_sub_category_id = 0;

    $keywords = mysql_escape_mimic($_POST['keywords']);
    $title = mysql_escape_mimic($_POST['title']);
    $brief_desc = mysql_escape_mimic($_POST['brief_description']);

    $desc =  base64_decode($_POST['description']);

    $attachment = 0;
    $ranking = 0;
    $total_price = 0;
    $source_name = mysql_escape_mimic($_POST['source_name']);
    $source_link = mysql_escape_mimic($_POST['source_link']);
    $comment_status = mysql_escape_mimic($_POST['comment_status']);
    $post_status = mysql_escape_mimic($_POST['post_status']);
    $post_type = 0;
    $status = 0;

    $update_date = jdate('Y/m/d');


    $post = $database_subject->post[$post_id];



    $photo_address = $post["photo_address"];
    $thumb_address = $post["thumb_address"];


    //-----------UPLOAD FILE-----------------
    $UPLOAD_FOLDER = $UPLOAD_ARR[$this_subject_id];
    if (isset($_FILES['upload']) && $_FILES['upload']['error'] != UPLOAD_ERR_NO_FILE && is_uploaded_file($_FILES['upload']['tmp_name'])) {
        $uploadfile = $_FILES['upload']['tmp_name'];
        $uploadname = $_FILES['upload']['name'];
        $uploadtype = $_FILES['upload']['type'];
        $extension = getExtension($uploadname);

        //--for image files
        if ($post_type == '0') {
            if (isValidPhotoExtension($extension)) {
                //upload the file in services folder
                $extension = '.' . $extension;
                //Delete Previous Photo
                $post_thumb = $post['thumb_address'];
                $post_photo = $post['photo_address'];
                $post_type = $post['post_type'];

                $thumb_path = $post_thumb;
                $photo_path = $post_photo;

                if (is_file($thumb_path) && $post_type == '0') // if post type is photo
                {
                    unlink($thumb_path);
                }
                if (is_file($photo_path)) {
                    unlink($photo_path);
                }
                //Add New Photo
                $guid = GUIDv4();


                //--Resizing the photo for thumb-----
                $image = new ResizeImage();
                $image->load($_FILES['upload']['tmp_name']);
                $image->resizeToWidth(240);

                //-----Save the thumb Size file-------
                $thumb_save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . "uploads/{$UPLOAD_FOLDER}/thumb_{$guid}{$extension}";
                $thumb_address = "uploads/{$UPLOAD_FOLDER}/thumb_{$guid}{$extension}";
                $image->save($thumb_save_address);
                unset($image);


                //-----Save the main Size file-------
                $save_address = $RELATIVE_UPLOAD_FOLDER_PREFIX . "uploads/{$UPLOAD_FOLDER}/{$guid}{$extension}";
                $photo_address = "uploads/{$UPLOAD_FOLDER}/{$guid}{$extension}";
                move_uploaded_file($_FILES["upload"]["tmp_name"], $save_address);
            } else {
                $msg = "<div class='error'>نوع فایل معتبر نمی باشد</div>";
            }
        }
    }
    //----End for Photo
    $post_array = array(
        "sub_category_id" => $this_sub_category_id,
        "keywords" => $keywords,
        "title" => $title, "brief_description" => $brief_desc,
        "comment_status" => $comment_status,"post_status" => $post_status,
        "update_date" => $update_date,
        "post_type" => $post_type, "has_attachment" => $attachment,
        "photo_address" => $photo_address, "thumb_address" => $thumb_address,
        "source_name" => $source_name, "source_link" => $source_link, "status" => $status
    );


    $affected_post = $post->update($post_array);

    $post_content_find = $database_subject->post_content()
        ->select("id")
        ->where("post_id = ?", $post_id)
        ->fetch();

    $post_content_id = $post_content_find['id'];
    $post_content = $database_subject->post_content[$post_content_id];

    $old_content_images = $post_content['content_photos'];

    $content_images = "";
    $content = $desc;
    $doc = new DOMDocument();
    $doc->loadHTML($content);
    $image_tags = $doc->getElementsByTagName('img');
    foreach ($image_tags as $image_tag) {
        $content_images .= $image_tag->getAttribute('src') . ",";
    }

    //Delete images that are not in the newcontent
    //        if($old_content_images != $content_images)
    //        {
    //            $old_images_list = explode(',', $old_content_images);
    //            foreach($old_images_list as $image){
    //                if (strpos($content_images, $image) === false) {
    //
    //                    $real_content_photo_path = str_replace($HOST_NAME,"../",$image);
    //                    if(is_file($real_content_photo_path))
    //                    {
    //                        unlink($real_content_photo_path);
    //                    }
    //                }
    //            }
    //        }
    //------------------------------------------

    $post_content_array = array("content" => $desc, "content_photos" => $content_images);
    $affected_details = $post_content->update($post_content_array);

    if ($affected_post == null && $affected_details == null) {
        $error = "خطا در بروز رسانی داده ها - هیچ سطری بروزرسانی نشد.";
        echo json_encode(
            array(
                "status" => '0',
                "message" => $error,
            )
        );
    } else {
        $msg_ok = "داده ها با موفقیت بروزرسانی شد";
        ///{$page_number}
        $redirect =  "{$HOST_NAME}group_admin/posts/{$this_subject_id}";
        echo json_encode(
            array(
                "status" => '1',
                "message" => $msg_ok,
                "redirect" => $redirect,
            )
        );
        exit;
    }
}


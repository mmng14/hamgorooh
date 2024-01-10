<?php
require_once "../core/config.php";
include "../core/NotORM.php";
$WEB_HOST_NAME = "http://localhost:8080/hamgorooh/";
/////////////////////////////

//------main DB Connection------
$dsn = "mysql:dbname=$DB_NAME;host=$DB_SERVER;charset=utf8";
$pdo=  new PDO($dsn, "$DB_USER", "$DB_PASS"); //$GLOBALS["db_pdo"]
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Disable on publish
$database =  new NotORM($pdo);
$database->debug = true;
//-----------------------------
/////////////////////////////

foreach ($crawler_items as $crawler_item) {
    try {

        $crawler_id = $crawler_item['id'];
        $item_link = $crawler_item["item_link"];
        $msg = update("crawler_items", "status=1", "id=$crawler_id");
        $search_count = countRows("post", "id", "source_link LIKE '%$item_link%'", "");
        echo $item_link . "<br/>";
        echo "<hr>";
        $post_date = "";
        if ($search_count == 0) {
            //----echo link
            $content_images = "";
            $newGUID = GUIDv4();
            $html = file_get_contents($item_link);
            //Create a new DOM document
            $dom = new DomDocument();

            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            $classname = "item-page";
            $finder = new DomXPath($dom);
            $spaner = $finder->query("//*[contains(@class, '$classname')]");
            $main_data = $spaner->item(0);

            //----echo title------//;
            $title = GetDOMinnerHTML($main_data, "tag", "h2");

            $crawler_title = trim($title);
            $crawler_title = strip_tags($crawler_title);


            if ($crawler_title == null || $crawler_title == "") {
                $header_main_data = $dom->getElementById("center");
                $title = GetDOMinnerHTML($header_main_data, "tag", "h2");
                $title = str_replace('-', '', $title);
                $crawler_title = strip_tags(trim($title));
            }
            echo $crawler_title;
            echo "<hr>";

            //Check if this title exsist
            $search_count2 = countRows("post", "id", "title LIKE '%$crawler_title%' ", "");
            if ($search_count2 == 0) {

                //----echo image------//;
                //$crawler_image = GetDOMMainImage($main_data,"tag","img");

                $str_main_data = GetDOMinnerHTML($main_data);
                $main_image = GetMainImage($str_main_data, "img", $site_name);

                //$images =  GetDOMImages($main_data,"tag","img");
                $images = GetDOMImages($main_data, "tag", "img", $newGUID, $UPLOAD_FOLDER, $site_name);
                $images_arr = explode(",", $images);
                $crawler_image = "";
                $photo_address = "";
                $thumb_address = "";

                if (count($images_arr) >= 1) {
                    $crawler_image = $HOST_NAME . $images_arr[0];
                    $photo_address =  $crawler_image;// $WEB_HOST_NAME;
                    echo "main image :" . $photo_address;
                    echo "<hr>";

                    if ($crawler_image != $HOST_NAME) {
                        //--Resizing the photo for thumb-----
                        $image = new ResizeImage();
                        $image->load($crawler_image);
                        $image->resizeToWidth(240);
                        $thumb_local = "uploads/{$UPLOAD_FOLDER}/thumb_{$newGUID}.jpg";
                        $image->save("../{$thumb_local}");
                        $thumb_address =   $WEB_HOST_NAME . $thumb_local;
                        echo "thumb :" . $thumb_address;
                        echo "<hr>";

                    } else {
                        $crawler_image = "";
                    }

                }

                //----echo $desc------//;
                $desc = GetDOMinnerHTML($main_data);

                //$desc =  RemoveTagByClass($desc,"div","path");
                //$desc =  RemoveTagByClass($desc,"p","x");
                $desc = RemoveTagByClass($desc, "dl", "article-info");
                $desc = RemoveByTagName($desc, "h2");
                $desc =  RemoveByTagName($desc,"script");

                $desc = str_replace($crawler_title, '', $desc);


                $desc = AddClassAndRemoveBrokenImages($desc, $main_image, $site_name);
                $desc = replace_img_src($desc, $newGUID, $WEB_HOST_NAME, $UPLOAD_FOLDER);

                $content = htmlspecialchars($desc);

                $content = htmlspecialchars($desc);
                $desc = strip_tags($desc, "<p><span><br><div><table><th><tr><td><ul><li><style><img><strong>");
                $crawler_desc = "<div style='text-align:justify !important;font-family: iransansFa !important;font-size: 14px !important;direction: rtl !important'>";
                $crawler_desc .= $desc;
                $crawler_desc .= "</div>";
                echo($crawler_desc);
                $crawler_desc = htmlspecialchars($crawler_desc);



                //----echo brief  desc------//;
                $crawler_brief_desc = trim(mb_substr(trim(strip_tags($desc)), 0, 450, "utf-8")) . "...";



                //Update item set status to 1 and insert images
                $msg = update("crawler_items", "images='$images',content='',status=1", "id=$crawler_id");

                if (!CheckHTML(htmlspecialchars_decode($crawler_desc))) // First Check if html is valid
                {
                    //Add to Data Base
                    if (strlen($crawler_title) >= 10) {

                        //Check if post name is  uniqe ,if not add a number
                        $post_name = sanitize($crawler_title);

                        //----------------------------
                        $category_type = "6"; // rss_reader
                        $this_subject_id = $crawler_item["subject_id"];
                        $this_category_id = $crawler_item["category_id"];
                        //$this_category_subject = select("category", "subject_id", "id={$this_category_id}");
                        $this_sub_category_id = $crawler_item["sub_category_id"];
                        $user_id = 43; //  for hamgorooh 
                        $user_name = "mmng14@yahoo.com";
                        $user_full_name = "اطلاعات عمومی";
                        $user_photo = "uploads/user/64_1481966849.png";
                        $keywords = $crawler_title;
                        $brief_desc = trim($crawler_brief_desc);
                        $desc .= $crawler_desc;
                        $attachment = "0";
                        $visit_count = 0;
                        $comment_count = 0;
                        $like_count = 0;
                        $dislike_count = 0;
                        //$photo_address = $photo_address;
                        //$thumb_address = $thumb_address;
                        $ranking = 0;
                        $total_price = 0;

                        $comment = 1;
                        $reg_date = jdate('Y/m/d');
                        $register_date = date('Y/m/d H:i:s');
                        $update_date = '';
                        $parent = 0;
                        $has_child = 0;
                        $guid = $newGUID;
                        $post_type = 0;
                        if ($crawler_image != null && $crawler_image != "") {
                            $post_status = 1;
                            $status = 1;
                            $featured = 1;
                        } else {
                            $post_status = 1;
                            $status = 1;
                            $featured = 0;
                        }

                        $user_post = 0;
                        $ordering = 1;
                        $source_name = "بیتوته";
                        $source_link = $item_link;


                        $property = array('NULL', $category_type, $this_subject_id, $this_category_id, $this_sub_category_id,
                            $user_id, $user_name, $user_full_name, $user_photo, $keywords, $post_name,
                            $crawler_title, $crawler_brief_desc, $featured, $post_status, $comment, $reg_date,
                            $update_date, $parent, $has_child, $guid, $post_type, $attachment, $visit_count,
                            $comment_count, $like_count, $dislike_count, $photo_address, $thumb_address,
                            $ranking, $total_price, $source_name, $source_link, $user_post, $ordering, $status);


                        $post_id = insert('post', $property);
                        if ($post_id == null || $post_id == '') {
                            $error = 'Error adding submitted data.';
                            echo $error . "<br/>";
                            echo $_SESSION["dblayer_error"] . "<br/>";
                            echo $_SESSION["dblayer_query"];
                        } else {
                            ////Add Content OF post
                            $property_content = array('NULL', $post_id, $newGUID, $reg_date, $crawler_desc, $images);
                            $post_content_id = insert('post_content', $property_content);


                            echo "New Post Id : " . $post_id . "<br/>";

                            if ($post_content_id == null || $post_content_id == '') {
                                $error = 'Error adding submitted post content.';
                                echo $error . "<br/>";
                                echo $_SESSION["dblayer_error"] . "<br/>";
                                echo $_SESSION["dblayer_query"];
                            } else {
                                echo "New Post Content Id : " . $post_content_id . "<br/>";
                            }
                            if ($crawler_image != "" && $crawler_image != "") {
                                echo "This_Post_Has_Image";
                            }

                        }

         
                        /////////////////////////////////////////////
                    }// end if strlen > 10


                } else {
                    echo "<h1>HTML Error (Is not valid)</h1><br/>";
                }


                echo '</body></html>';

            }
        }
    } catch (Exception $e) {
        //update crawler_items , set status=1
        $crawler_id = $crawler_item['id'];
        $msg = update("crawler_items", "status=1", "id=$crawler_id");
        echo "<h3> Error : ". $e->getMessage()."</h3><br>";
        echo '</body></html>';
    }
}// end for each'

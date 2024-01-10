<?php
include "../core/NotORM.php";
/////////////////////////////
$DB_SERVER_MAIN = "localhost";
$DB_NAME_MAIN = "hamgoroohdb";
$DB_USER_MAIN = "root";
$DB_PASS_MAIN = "";

$dsn = "mysql:dbname=$DB_NAME_MAIN;host=$DB_SERVER_MAIN;charset=utf8";
$GLOBALS["db_pdo"] = new PDO($dsn, "$DB_USER_MAIN", "$DB_PASS_MAIN");

function db()
{
    return new NotORM($GLOBALS["db_pdo"]);
}

/////////////////////////////

foreach($crawler_items as $crawler_item) {
    try {
        $crawler_id = $crawler_item['id'];     
        $item_link = $crawler_item["item_link"];


        //Update item set status to 1 at first
        $msg = update("crawler_items", "status=1", "id=$crawler_id");
        $search_count = countRows("post","id","source_link LIKE '%$item_link%' ","");
        echo $item_link . "<br/>";
        echo "<hr>";
     
        
        if($search_count==0)
        {
            //----echo link

            $newGUID = GUIDv4();
            $html = file_get_contents($item_link);
            //Create a new DOM document
            $dom = new DomDocument();

            @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

            $main_data = $dom->getElementById("mcenter");

            //----echo title------//;
            $title = GetDOMinnerHTML($main_data,"tag","h1");  
            
            $title = str_replace('آکا','', $title);        
            $title = str_replace('-',' ', $title);
            $title = str_replace('»','', $title);
            $crawler_title = trim($title);
            $crawler_title = strip_tags($crawler_title);

            //Check if this title exsist

            $search_count2 = countRows("post","id","title LIKE '%$crawler_title%' ","");
            if(!isset($search_count2) || $search_count2==0)
            {

                if($crawler_title ==null || $crawler_title=="")
                {
                    $header_main_data = $dom->getElementById("center");
                    $title = GetDOMinnerHTML($header_main_data,"tag","h1");
                    $title = str_replace('آکا','', $title);        
                    $title = str_replace('-','', $title);
                    $crawler_title = strip_tags(trim($title));
                }
                echo $crawler_title;
                echo "<hr>";



                //----echo image------//;
                //$crawler_image = GetDOMMainImage($main_data,"tag","img");

                $str_main_data =  GetDOMinnerHTML($main_data);             
//                $main_image = GetMainImage($str_main_data,"img",$site_name);
                $main_image = GetMainImage($str_main_data,"img","");

//                $images =  GetDOMImages($main_data,"tag","img",$newGUID,$UPLOAD_FOLDER,$site_name);
                $images =  GetDOMImages($main_data,"tag","img",$newGUID,$UPLOAD_FOLDER,"");

                $images_arr = explode(",",$images);
                $crawler_image = "";
                $thumb_address="";

                if(count($images_arr)>=1)
                {
                    $crawler_image =  $HOST_NAME. $images_arr[0];
                    
                    echo "<img src='$crawler_image' />";
                    echo "<hr>";
                    echo $images;
                    echo "<hr>";

                    if($crawler_image != $HOST_NAME)
                    {              
                        //--Resizing the photo for thumb-----
                        $image = new ResizeImage();
                        $image->load($crawler_image);
                        $image->resizeToWidth(240);
                        $thumb_local = "uploads/{$UPLOAD_FOLDER}/thumb_{$newGUID}.jpg";
                        $image->save("../{$thumb_local}");
                        $thumb_address = $HOST_NAME . $thumb_local;
                        echo $thumb_address;
                        echo "<hr>";
                    }
                    else{
                        $crawler_image = "";
                    }
                }


                //----echo $desc------//;
                $doc = GetDOMinnerHTML($main_data);
                $desc =  RemoveTagByClass($doc,"div","path");
                $desc =  RemoveTagByClass($desc,"div","src");
                $desc =  RemoveTagByClass($desc,"p","source");
                $desc =  RemoveTagByClass($desc,"ul","mlink");
                $desc =  RemoveTagByClass($desc,"div","alert alertbox hidden-xs hidden-sm");
                $desc =  RemoveByTagName($desc,"h1");
                
                //Remove AKA Sign
                $desc = str_replace($crawler_title,' ', $desc);
                $desc = str_replace('آکاایران:', ' ', $desc);
                $desc = str_replace('آکایران :', ' ', $desc);
                $desc = str_replace('آکاایران', ' ', $desc);
                $desc = str_replace('به گزارش', ' ', $desc); 
                $desc = str_replace('آکاایران:', ' ', $desc);
                $desc = str_replace('آکا', ' ', $desc);
                $desc = str_replace($crawler_title,' ', $desc);
                
                //$desc = AddClassAndRemoveBrokenImages($desc,$main_image,$site_name);
                $desc = AddClassAndRemoveBrokenImages($desc,$main_image,"");
                $desc =  replace_img_src($desc,$newGUID,$HOST_NAME,$UPLOAD_FOLDER);

                $content = htmlspecialchars($desc);
                $desc = strip_tags($desc,"<p><span><br><div><table><th><tr><td><ul><li><style><img><strong>");
                $crawler_desc ="<div style='text-align:justify !important;font-family: iransans !important;font-size: 14px !important;direction: rtl !important'>";
                $crawler_desc .= $desc;
                $crawler_desc .= "</div>";
                $crawler_desc = htmlspecialchars($crawler_desc);
                echo htmlspecialchars_decode($crawler_desc);
                echo "<hr>";

                
                //----echo brief  desc------//;
                $crawler_brief_desc =  trim(mb_substr(trim(strip_tags($desc)),0,450,"utf-8")) . "...";
                echo $crawler_brief_desc;
                echo "<hr>";

                //---echo date -----
                $all_data = $dom->getElementById("center");
                $strAllData = GetDOMinnerHTML($all_data);
                $post_date_html = GetByClassName($strAllData,"vone__date");
                $post_date = GetByTagName($post_date_html,"span");
                $post_date = trim($post_date);
                $post_date = ConvertToPostDate($post_date);
                $post_date = convertPersianToEng(trim($post_date));
                $post_date=str_replace("//","/",$post_date);

                print trim($post_date);
                echo "<hr/>";
                

                if(!CheckHTML(htmlspecialchars_decode($crawler_desc))) // First Check if html is valid
                {
                    //Add to Data Base
                    if (strlen($crawler_title) >= 10) {

                        //Check if post name is  uniqe ,if not add a number
                        $post_name = sanitize($crawler_title);

                        //----------------------------
                        $category_type = "6"; // rss_reader
                        $this_subject_id = $crawler_item["subject_id"];
                        $this_category_id = $crawler_item["category_id"];           
                        $this_sub_category_id = $crawler_item["sub_category_id"];
                        $user_id = 43; //  for hamgorooh 
                        $user_name = "mmng14@yahoo.com";
                        $user_full_name = "اطلاعات عمومی";
                        $user_photo = "uploads/user/64_1481966849.png";
                        $keywords =  $crawler_title;
                        $brief_desc = trim($crawler_brief_desc);
                        $desc .= $crawler_desc;
                        $attachment = "0";
                        $visit_count = 0;
                        $comment_count = 0;
                        $like_count = 0;
                        $dislike_count = 0;
                        $photo_address = $crawler_image;
                        $thumb_address = $thumb_address;
                        $ranking = 0;
                        $total_price = 0;

                        $comment = 1;
                        $reg_date =  $post_date;// jdate('Y/m/d');
                        $update_date = '';
                        $parent = 0;
                        $has_child = 0;
                        $guid = $newGUID;
                        $post_type = 0;
                        if($crawler_image !=null && $crawler_image!="")
                        {
                            $post_status = 1;
                            $status = 1;
                            $featured = 1;
                        }
                        else
                        {
                            $post_status = 1;
                            $status = 1;
                            $featured = 0;
                        }
                        
                        $user_post = 0;
                        $ordering = 1;
                        $source_name = $crawler_item["source_name"];;
                        $source_link = $item_link ;

                        
                        $property = array('NULL', $category_type, $this_subject_id, $this_category_id, $this_sub_category_id,
                            $user_id, $user_name, $user_full_name, $user_photo, $keywords, $post_name,
                            $crawler_title, $crawler_brief_desc, $featured, $post_status, $comment, $reg_date,
                            $update_date, $parent, $has_child, $guid, $post_type, $attachment, $visit_count,
                            $comment_count, $like_count, $dislike_count, $photo_address, $thumb_address,
                            $ranking, $total_price, $source_name, $source_link, $user_post, $ordering, $status);

                        
                        $post_id = insert('post', $property);
                        if ($post_id == null || $post_id == '') {
                            $error = 'Error adding submitted data.';
                            echo  $error . "<br/>";
                            echo $_SESSION["dblayer_error"];
                        }
                        else
                        {
                            echo "post Id : " . $post_id;
                            ////Add Content OF post
                            $property_content = array('NULL',$post_id,$newGUID,$reg_date,$crawler_desc,$images);
                            $post_content_id = insert('post_content', $property_content);
                            if ($post_content_id == null || $post_content_id == '') {
                                $error = 'Error adding submitted post content.';
                                echo $error . "<br/>";
                                echo $_SESSION["dblayer_error"] . "<br/>";
                                echo $_SESSION["dblayer_query"];
                            } else {
                                echo "New Post Content Id : " . $post_content_id . "<br/>";
                            }
                            /////////////////////////
                            ////Add this post to archive 
                            echo  "New Post Id : " .  $post_id . "<br/>";
                            if($crawler_image !="" && $crawler_image!="")
                            {
                                echo  "This_Post_Has_Image";
                            }
                            
                        }
                        
                        //----------------
                        ////////////SEO(Send to Referal Sites)///////
                        if ($post_id != null && $post_id != '') {

                            echo "<h1>Referals</h1>";

                            $main_subj_id=$this_subject_id;
                            $main_cat_id = $this_category_id;
                            $subj_id_length = strlen($main_subj_id);
                            $cat_id_length = strlen($main_cat_id);
                            $post_id_length =  strlen($post_id);
                            $subcategory_id_length = 0;
                            $subcategory_id="";

                            $post_code = "{$subj_id_length}{$main_subj_id}{$cat_id_length}{$main_cat_id}{$post_id_length}{$post_id}";
                            $item_link_address = $HOST_NAME."post/{$post_code}/".$post_name;


                            $urltopost = "http://www.bazzarrooz.ir/services/recieve.php";
                            $datatopost = array ("post_code"=>"$post_code","subj_id"=>"$this_subject_id","cat_id"=>"$this_category_id",
                                "subcat_id"=>"$this_sub_category_id","title" => "$crawler_title","url_name"=>"$post_name",
                                "photo" => "$photo_address","thumb"=>"$thumb_address","link" => "$item_link_address","post_date"=>"$post_date");

                            $ch = curl_init ($urltopost);
                            curl_setopt ($ch, CURLOPT_POST, true);
                            curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
                            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
                            $returndata = curl_exec ($ch);

                            echo $returndata;

                            $datatopost_subjects = array ("post_code"=>"$post_code","subject_id"=>"$this_subject_id","category_id"=>"$this_category_id",
                                "sub_category_id"=>"$this_sub_category_id","title" => "$crawler_title","url_name"=>"$post_name","keywords"=>$keywords,
                                "photo_address" => "$photo_address","thumb_address"=>"$thumb_address","link_address" => "$item_link_address","post_date"=>"$reg_date","reg_date"=>"$reg_date","post_type"=>"1","status"=>$status);
                            echo "<br/>subject_id='{$this_subject_id}'<br/>";

                            $subject_site = db()->subject_sites()
                                ->select("id,subject_id,recieve_link")
                                ->where("subject_id = ?",$this_subject_id)
                                ->order("id asc")
                                ->fetch();

                            echo "subject_sites : ";
                            echo($DB_NAME_MAIN . "-" . $subject_site["recieve_link"]);
                            if ($subject_site) {
                                $remote_url = $subject_site["recieve_link"] . "insert/post";
                                $ch = curl_init($remote_url);
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $datatopost_subjects);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $returndata2 = curl_exec($ch);
                                echo "<h3>cat :" . $this_category_id . " address:" . $remote_url. "result :" . $returndata2 . "</h3>";

                            } else {
                                echo "<h3>" . $this_subject_id . ":Not found</h3>";
                            }

                        }
                        /////////////////////////////////////////////
                    }// end if strlen > 10

                }
                else
                {
                    echo "<h1>HTML Error</h1><br/>";
                    
                }


                
                echo '</body></html>';
            }
        }
        
    }
    catch(Exception $e)
    {
        //update crawler_items , set status=1
        $crawler_id = $crawler_item['id'];
        $msg = update("crawler_items", "status=1", "id=$crawler_id");
        echo "<h3>error</h3><br>";
        echo '</body></html>';
    }
}// end for each'





?>
<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';
//include_once '../../libraries/cache.class.php';
//phpFastCache::$storage = "auto";

//*************************************************************************************
//*********************************   Like AND Dislike   ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="C354c05v6k752I")
{
	// Define variables and set to empty values
	Connect();
	$txtsub_category = $like_count = $dislike_count = $comment_count = "";
	$post_id = mysql_real_escape_string($_POST['p']);
	$icon_type = mysql_real_escape_string($_POST['i']);

	$currentDate=jdate('Y/m/d');
	$serverId=$_SERVER['REMOTE_ADDR'];
	$msg=false;

	if (isset($_SESSION['user_name'])){
		$user_id=$_SESSION['user_id'];
		if ($post_id!="")
		{
			if ($icon_type=='1'){ //plus - like
				$rows=countRows('post_like','user_ip',"user_ip='$serverId'  AND post_id='$post_id' AND user_id='$user_id'");
				if ($rows==0 || $rows=="" || $rows==NULL)
				{
					$property = array('',$post_id,$user_id,'1',$serverId,$currentDate);
					$file_id=insert('post_like',$property);

					if ($file_id!=null || $file_id!='')
						$msg=Update('post',"like_count=like_count+1","id='$post_id'");
				}
				else $return="-1";
			}
			else if ($icon_type=='2'){ //minus - dislike
				$rows=countRows('post_like','user_ip',"user_ip='$serverId'  AND post_id='$post_id' AND user_id='$user_id'");
				if ($rows==0 || $rows=="" || $rows==NULL)
				{
					$property = array('',$post_id,$user_id,'-1',$serverId,$currentDate);
					$file_id=insert('post_like',$property);

					if ($file_id!=null || $file_id!='')
						$msg=Update('post',"dislike_count=dislike_count+1","id='$post_id'");
				}
				else $return="-1"; // user voted before
			}

			if ($msg==true)
			{
				$rows=select('post','like_count,dislike_count,comment_count',"id='$post_id'");
				foreach($rows as $result){
					$like_count=$result["like_count"];
					$dislike_count=$result["dislike_count"];
					$comment_count=$result["comment_count"];
				}
			}

			if ($icon_type=='1') echo $like_count;
			else if ($icon_type=='2') echo $dislike_count;

		}
	}
	else $return="-2"; // user not logged in
	Disconnect();
	echo $return;
}
//*************************************************************************************
//*********************************   Add Comment   ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="I17425v6bf752UC")
{
	Connect();
	// Define variables and set to empty values
	$comment_count =$file_id=$currentDate= $currentTime=$user_comment=$captcha=$captcha_val="";
	$captcha = mysql_real_escape_string($_POST['captcha']);
	$captcha_val = $_SESSION['login'];
    if($captcha==$captcha_val)
    {

		$user_name = mysql_real_escape_string($_POST['n']);
		$user_email = mysql_real_escape_string($_POST['e']);
		$user_comment = mysql_real_escape_string($_POST['c']);

		if (isset($_POST["ci"]))
			$comment_id = mysql_real_escape_string($_POST['ci']);
		else
			$comment_id=0;
		$post_id = mysql_real_escape_string($_POST['p']);

		$currentDate=jdate('Y/m/d');
		$currentTime = date('H:i:s');
		$serverId=$_SERVER['REMOTE_ADDR'];

		$ua=getBrowser();
		$yourbrowser= $ua['name'] . " " . $ua['version'] ;

		if ($user_email!="" && $user_name!="")
		{
			if (isset($_SESSION['user_name'])){
	          if($_SESSION['user_type']=='1')
	             {
				$user_name=$_SESSION['full_name'];
				$user_email=$_SESSION['user_email'];
				$property = array('',$post_id,$_SESSION['user_id'],$user_name,$user_email,$serverId,$currentDate,$currentTime,
			 					  $user_comment,$yourbrowser,'1',$comment_id,'0');
			}
	        else
			{
	            $user_name=$_SESSION['full_name'];
				$user_email=$_SESSION['user_email'];
				$property = array('',$post_id,$_SESSION['user_id'],$user_name,$user_email,$serverId,$currentDate,$currentTime,
			 					  $user_comment,$yourbrowser,'0',$comment_id,'1');
			}

	      }
			else
				$property = array('',$post_id,'0',$user_name,$user_email,$serverId,$currentDate,$currentTime,$user_comment,$yourbrowser,'0',$comment_id,'1');
			$file_id=insert('comment',$property);

			$msg=Update('post',"comment_count=comment_count+1","id='$post_id'");
		}

	echo json_encode(
			array(
				"id" => $file_id,
				"name" => $user_name,
				"date" => $currentDate,
				"time" => $currentTime,
				"comment" => $user_comment,
				"cap" => $captcha,
				"cap_val" => $captcha_val,
			)
		);
    }
    else
    {
	echo json_encode(
			array(
				"cap" => $captcha,
				"cap_val" => $captcha_val,
			)
		);
    }
    Disconnect();
}
//*************************************************************************************
//************************************   post  List   *********************************
//*************************************************************************************
if(isset($_POST["cmd"]) && $_POST["cmd"]=="S271hh248548P" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	Connect();
	$search_exp = mysql_real_escape_string($_POST["exp"]);
	//$search_exp =$_POST["exp"];
	$txtcategory = $txtsubcategory = "";


	// Define variables and set to empty values

	//--------------------------- page -----------------------------
	//Get page number from Ajax POST
	if(isset($_POST["page"])){
		$page_number = filter_var(mysql_real_escape_string($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$item_per_page= 19;

	//------------------------------------------------------------
	//-------------------- category  -------------------------
	if(isset($_POST['c']))
	  {
		$category_id=mysql_real_escape_string($_POST['c']);
		if ($category_id)
			$txtcategory=" AND category_id='$category_id'";
	  }

	//------------------------------------------------------------
	//-------------------- sub_category  -------------------------
	if(isset($_POST['sc']))
	  {
		$sub_category_id=mysql_real_escape_string($_POST['sc']);
		if ($sub_category_id)
			$txtsubcategory=" AND sub_category_id='$sub_category_id'";
	  }


	//get total number of records from database for pagination
	$get_total_rows=countRows('post,users','post.id',"post.title like '%{$search_exp}%' AND post.post_status=1 AND users.id=post.user_id $txtcategory $txtsubcategory");
	//break records into pages
	$total_pages = ceil($get_total_rows/$item_per_page);

	if ($total_pages<$page_number)
		$page_number=1;

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);

	if(!isset($category_id))
	{
		$category_id_cache="0";
	}
	else
	{
		$category_id_cache=$category_id;
	}
	if(!isset($sub_category_id))
	{
		$sub_category_id_cache="0";
	}
	else
	{
		$sub_category_id_cache=$sub_category_id;
	}
	//get chached page name
	 $page_data = "";
	//$cache_page_name = "page_".$category_id_cache."_" . $sub_category_id_cache ."_".$page_number;
	//$page_data = phpFastCache::get($cache_page_name);
	if($page_data=="" && $search_exp !="0" ) // if search box is not empty
	{
		//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
		$rows=select('post,users','post.id,post.post_name,post.title,post.brief_description,post.thumb_address,post.reg_date,post.comment_count,post.like_count,
					  post.dislike_count,users.username',"post.title like '%{$search_exp}%' AND post.post_status=1 AND users.id=post.user_id $txtcategory $txtsubcategory",
					 "order by id DESC LIMIT $page_position, $item_per_page");
		foreach($rows as $result){
			$post_id=encode_url($result["id"]);
			$page_data.= "<div class=\"blog_box\">
					<div class=\"blog_grid\">
					<h3><a target=\"_blank\" href=\"".$HOST_NAME."/". $result["post_name"] ."/\">".$result["title"]."</a></h3><i class=\"document\"> </i>
						  <a href=\"".$HOST_NAME."/". $result["post_name"] ."/\"><img src=\"".$result["thumb_address"]."\" class=\"img-responsive\" alt=\"\"/></a>
						  <div class=\"singe_desc\">
							<P>".$result["brief_description"]."...</p>
							<div class=\"comments\">
								<ul class=\"links\">
									<li>
										<img src=\"resource/images/date.png\" /><br><span>".$result["reg_date"]."</span>
									</li>
									<li>
										<img src=\"resource/images/user_icon.png\" /><br>
										<span id=\"post_user\">".$result["username"]."</span>
									</li>
									<li>
										<img src=\"resource/images/plus.png\" onClick=\"set_change('".$result["id"]."','1');\" style=\"cursor:pointer\"/><br>
										<span id=\"like_".$result["id"]."\">".$result["like_count"]."</span>
									</li>
									<li>
										<img src=\"resource/images/minus.png\" onClick=\"set_change('".$result["id"]."','2');\" style=\"cursor:pointer\" /><br>
										<span id=\"dislike_".$result["id"]."\">".$result["dislike_count"]."</span>
									</li>
									<li>
										<img src=\"resource/images/comment.png\" /><br>
										<span id=\"comment_".$result["id"]."\">".$result["comment_count"]."</span>
									</li>
								</ul>
								<div class=\"btn_blog\"><a target=\"_blank\" href=\"".$HOST_NAME."/". $result["post_name"] ."/\">بیشتر</a></div>
								<div class=\"clear\"></div>
							 </div>
						  </div>
					</div>
				  </div>";
		}

		Disconnect();

		$page_data.= "<div class=\"page_row\">";
		$page_data.= "<div class=\"loading-div\"><img src=\"". $HOST_NAME ."/resource/images/ajax-loader.gif\"></div>";
		$page_data.= paginate_function($item_per_page, $page_number, $get_total_rows, $total_pages);
		$page_data.= "<input type=\"hidden\" id=\"txtpagenum\" name=\"txtpagenum\" style=\"display:none;\"   value=\"".$page_number."\"  />";
		$page_data.= '</div>';
		//phpFastCache::set($cache_page_name,$page_data,30);
	}
	echo $page_data;
}
####################################### pagination function #########################################
function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
        $pagination .= '<ul class="paginationtbl" >';

        $right_links    = $current_page + 3;
        $previous       = $current_page - 1; //previous link
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link

        if($current_page > 1){
			$previous_link = ($previous==0)?1:$previous;
			$pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">صفحه قبل</a></li>'; //previous link
            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">صفحه اول</a></li>'; //first link
                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                    if($i > 0){
                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                    }
                }
            $first_link = false; //set first link to false
        }

        if($first_link){ //if current active page is first link
            $pagination .= '<li class="first active">'.$current_page.'</li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="last active">'.$current_page.'</li>';
        }else{ //regular current link
            $pagination .= '<li class="active">'.$current_page.'</li>';
        }

        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){
				$next_link = ($i > $total_pages)? $total_pages : $i;
                $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">صفحه آخر</a></li>'; //last link
				$pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">صفحه بعد</a></li>'; //next link
        }

        $pagination .= '</ul>';
    }
    return $pagination; //return pagination links
}
?>
<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';


//*************************************************************************************
//*********************************   Delete post row   *******************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="D1p2dd989P")
{
	$post_thumb = $post_photo = "";
	$tblId = test_input($_POST["obj"]);

	if ($tblId!="")
	{
		Connect();

		$rows=select('post','photo_address,thumb_address',"id='$tblId'");
		foreach($rows as $result){
			$post_thumb=$result['thumb_address'];
			$post_photo=$result['photo_address'];
		}

		$extension=substr($post_photo,strrpos($post_photo,"."));
		$thumb_path="../../admin/uploads/post/thumb/".$tblId.$extension;
		$photo_path="../../admin/uploads/post/main/".$tblId.$extension;
		//-------------

		if(is_file($thumb_path))
		{
			unlink($thumb_path);
		}
		if(is_file($photo_path))
		{
			unlink($photo_path);
		}


		Delete('post',"id='$tblId'");
		Disconnect();
	}

}
//*************************************************************************************
//*****************************   Select post row   ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="S2p5kk826P")
{
	// Define variables and set to empty values
	$category=$sub_category = $user = $keyword = $title = $desc = $status = $comment = $parent = $guid = $seq_no = $type = "";
	$attachment = $photo_address = $thumb_address = $price = $discount = $validation = $brif_desc = "";
	$tblId = test_input($_POST["obj"]);

	if ($tblId!="")
	{
		Connect();
		$rows=select('post','*',"id='$tblId'");
		Disconnect();
		foreach($rows as $result){
			$category=$result['category_id'];
			$sub_category=$result['sub_category_id'];
			$user=$result['user_id'];
			$keyword=$result['keyword'];
			$title=$result['title'];
			$brif_desc=$result['brief_description'];
			$desc=$result['content'];
			$feature=$result['featured'];
			$status=$result['post_status'];
			$comment=$result['comment_status'];
			$parent=$result['parent'];
			$guid=$result['guid'];
			$seq_no=$result['seq_no'];
			$type=$result['post_type'];
			$attachment=$result['post_attachment'];
			$photo_address=$result['photo_address'];
			$thumb_address=$result['thumb_address'];
			$price=$result['total_price'];
			$discount=$result['discount'];
			$validation=$result['link_validation'];
		}
		echo json_encode(
			array(
				"category" => $category,
				"sub_category" => $sub_category,
				"user" => $user,
				"keyword" => $keyword,
				"title" => $title,
				"brif_desc" => $brif_desc,
				"desc" => $desc,
				"feature" => $feature,
				"status" => $status,
				"comment" => $comment,
				"parent" => $parent,
				"guid" => $guid,
				"seq" => $seq_no,
				"type" => $type,
				"attachment" => $attachment,
				"photo" => $photo_address,
				"thumb" => $thumb_address,
				"price" => $price,
				"discount" => $discount,
				"validation" => $validation,
			)
		);
	}

}
//*************************************************************************************
//*****************************   sub_category List for combobox   ****************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="Sc345c05c6d9823CS")
{
	// Define variables and set to empty values
	$txtsub_category="";
	$categoryId = test_input($_POST['c']);
	$sub_category_id = test_input($_POST['s']);

	if ($categoryId!="")
	{
		Connect();
		$rows=select('sub_category','id,name',"category_id='$categoryId' AND status=1");
		Disconnect();

		$txtsub_category.= "<option value='0' />انتخاب کنید";
		foreach($rows as $result){
			if ($sub_category_id!=0)
				$txtsub_category.= "<option value='".$result["id"]."' selected />".$result["name"];
			else
				$txtsub_category.= "<option value='".$result["id"]."' />".$result["name"];
		}
	}
	echo $txtsub_category;
}
//*************************************************************************************
//*****************************   about_us  List   *************************************
//*************************************************************************************
if(isset($_POST["cmd"]) && $_POST["cmd"]=="S271hh24818P" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	Connect();

	// Define variables and set to empty values
	$user=$_SESSION['user_id'];

	//--------------------------- page -----------------------------
	//Get page number from Ajax POST
	if(isset($_POST["page"])){
		$page_number = filter_var(mysql_real_escape_string($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}
	//------------------------------------------------------------
	//-------------------------- perpage -------------------------
	if(isset($_POST['perpage']))
	  {
		$item_per_page=mysql_real_escape_string($_POST['perpage']);
	  }
	else
	   $item_per_page= 10;
	//---------------------------------------------------------------
	//-------------------------- order -------------------------------
	if(isset($_POST['order']))
	 {
		$orderBy=mysql_real_escape_string($_POST['order']);
		if($orderBy==1) $order= 'id DESC';
		else if($orderBy==2) $order= 'id ASC';
	}
	else
	{
	  $orderBy=2;
	  $order= 'id DESC';
	}

	//get total number of records from database for pagination
	$get_total_rows=countRows('post','id',"user_id!=1 AND user_id='$user'");//hold total records in variable
	//break records into pages
	$total_pages = ceil($get_total_rows/$item_per_page);

	if ($total_pages<$page_number)
		$page_number=1;

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);

	//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
	$rows=select('post','id,title,thumb_address,discount,seq_no,post_status,post_attachment',"user_id!=1 AND user_id='$user'",
				 "ORDER BY $order LIMIT $page_position, $item_per_page ");

	//Display records fetched from database.
	echo "<table class=\"table table-striped border-top\" id=\"sample_1\">

						<tbody>";
			$counter=0;
			foreach($rows as $result){
				$post_id=encode_url($result["id"]);
				echo "<tr>
						  <td>".++$counter."</td>
						  <td class=\"hidden-480\">".$result['title']."</td>
						  <td class=\"hidden-phone\"><img alt='' src=".$result['thumb_address']." width=\"90px\" height=\"50px\" /></td>
						  <td>";
						  if ($result['post_attachment']==1){
					echo "<a class=\"btn btn-info btn-xs\"  href=\"post_file.php?p=".$post_id."\" >
								<i class=\"icon-file\">ضمیمه</i>
							</a>&nbsp;";
						  }
					  echo "<a class=\"btn btn-primary btn-xs\" href=\"user_post_edit.php?p=$post_id\" >
								<i class=\"icon-pencil\">ویرایش</i>
							</a>

							<button class=\"btn btn-danger btn-xs\" onclick=\"deleteData('".$result['id']."')\">
								<i class=\"icon-trash \">حذف</i>
							</button>
						  </td>
					  </tr>";
			}
	echo   "</tbody>
		</table>";

	Disconnect();

	echo '<div class="form-group">';
	echo '<div class="col-lg-6">';
	/* We call the pagination function here to generate Pagination link for us.
	As you can see I have passed several parameters to the function. */
	echo paginate_function($item_per_page, $page_number, $get_total_rows[0], $total_pages);
	echo "<input type=\"hidden\" id=\"txtpagenum\" name=\"txtpagenum\" style=\"display:none;\"   value=\"".$page_number."\"  />";
	echo '</div>';
	echo '<div class="col-lg-6">';
	//echo "<label style=\"float:left\" >".$get_total_rows." ردیف</label>";
	echo '</div>';
	echo '</div>';
}
################ pagination function #########################################
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
            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
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
                $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
        }

        $pagination .= '</ul>';
    }
    return $pagination; //return pagination links
}
?>
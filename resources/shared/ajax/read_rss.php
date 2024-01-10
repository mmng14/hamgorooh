<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';
include_once '../../libraries/cache.class.php';
phpFastCache::$storage = "auto";
//*************************************************************************************
//************************************   rss  List   *********************************
//*************************************************************************************
if(isset($_POST["cmd"]) && $_POST["cmd"]=="S271hh248548P" && isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
	strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	Connect();

	// Define variables and set to empty values

	//--------------------------- page -----------------------------
	//Get page number from Ajax POST
	if(isset($_POST["page"])){
		$page_number = filter_var(mysql_real_escape_string($_POST["page"]), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$item_per_page= 10;


	//get total number of records from database for pagination
	$get_total_rows=countRows('rss_items','id',"status='1'");
	//break records into pages
	$total_pages = ceil($get_total_rows/$item_per_page);

	if ($total_pages<$page_number)
		$page_number=1;

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);

	//get chached page name
	$page_data = "";
	$cache_page_name = "page_".$page_number;
	$page_data = phpFastCache::get($cache_page_name);
	if($page_data==null)
	{
		//SQL query that will fetch group of records depending on starting position and item per page. See SQL LIMIT clause
		$rows=select('rss_items','id,title,rss_name,summary,link,published',"status='1'",
					 "order by id DESC LIMIT $page_position, $item_per_page");
		foreach($rows as $result){
			$post_id=encode_url($result["id"]);
			$page_data.= "<div class=\"blog_box\">
					<div class=\"blog_grid\">
					<h3><a target=\"_blank\" href=\"".$HOST_NAME."/rss.php?rss=". $result["rss_name"] ."/\">".$result["title"]."</a></h3><i class=\"document\"> </i>
						  <div class=\"singe_desc\">
							<P>".strip_tags($result["summary"])."...</p>
							<div class=\"comments\">
								<div class=\"btn_blog\"><a target=\"_blank\" href=\"".$HOST_NAME."/rss.php?rss=". $result["rss_name"] ."/\">ادامه ...</a></div>
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
		phpFastCache::set($cache_page_name,$page_data,30);
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

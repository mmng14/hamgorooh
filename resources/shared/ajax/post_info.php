<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';
include_once '../../libraries/smily.php';


//*************************************************************************************
//*********************************   Group Request  ***********************************
//*************************************************************************************
if(isset($_POST["check"]) && $_POST["check"]=="I1ReQ5v6bf7GrPUC" && isset($_POST["s"]) && isset($_POST["c"]))
{

       if(isset($_SESSION['user_id']) ) //check if the comment belong to this user
       {
           Connect();
           $user_id = $_SESSION['user_id'];
           $subj_id = $_POST["s"];
           $grp_id= $_POST["c"];
           $request_date=jdate('Y/m/d');
           $join_date = "";
           $role="0";
           $user_rights = "";
           $visited=0;
           $status=0;

           $property = array('', $user_id, $subj_id, $grp_id,$request_date,$join_date,$role,$user_rights,$visited,$status);
           $file_id = insert('user_groups', $property);
           $file_id = '1';
           if($file_id != null && $file_id !="") {
               //Update Session user groups
               $loged_user_groups = select("user_groups", "*", "user_id={$_SESSION['user_id']}");
               $_SESSION['user_groups'] = $loged_user_groups;
               //--------------
               $message = "درخواست شما با موفقیت ارسال گردید";
               echo json_encode(
                   array(
                       "valid" => '1',
                       "message" => $message,
                   )
               );
           }
           else
           {
               $message = "خطا در ارسال درخواست عضویت";
               echo json_encode(
                   array(
                       "valid" => '0',
                       "message" => $message,
                   )
               );
           }
           Disconnect();
    }


}
//*************************************************************************************
//*********************************   Like AND Dislike   ******************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="C354c05v6k752I")
{
    Connect();
    // Define variables and set to empty values
    $post_id = $like_count = $dislike_count =  "";
    $post_id = mysql_real_escape_string($_POST['p']);
    $icon_type = mysql_real_escape_string($_POST['i']);
    $currentDate=jdate('Y/m/d');
    $userIP=$_SERVER["REMOTE_ADDR"];
    $user_first_vote="1";
    $change = '0';
    $msg=false;
    if($icon_type==1){ $user_vote='1';} // Like
    if($icon_type==2){ $user_vote='-1';} // DisLike
    /************Check id user voted before************/
    //------ if user is logged in --------
    if (isset($_SESSION['user_name']) && isset($_SESSION['user_id']) ) {
        $user_id = $_SESSION['user_id'];
        $rows = countRows('post_like', 'id', "post_id='$post_id' AND user_id='$user_id'");
        if ($rows >= 1) {
            $rows2 = countRows('post_like', 'id', "post_id='$post_id' AND user_id='$user_id' AND vote='$user_vote'");
            if ($rows2 >= 1) {
                $user_first_vote = "0";
                $return = -1; // user voted before
            }
            else
            {
                $user_first_vote = "0";
                $change = '1';
            }
        }
    }
    else { // if user is not logged in
        $user_id = 0;
        $rows = countRows('post_like', 'id', "post_id='$post_id' AND user_ip='$userIP'");
        if ($rows >= 1) {
            $user_first_vote=false;
            $return = -1; // user voted before
        }
    }
    //----------------------------------
    /***** if user didn't vote before ********/
    if ($user_first_vote=='1' && $post_id != "" && $change=='0') {

        $property = array('', $post_id, $user_id, $user_vote, $userIP, $currentDate);
        $file_id = insert('post_like', $property);

        if ($icon_type==1 && $file_id != null && $file_id != ''  ) { // if user liked
            $msg = Update('post', "like_count=like_count+1", "id='$post_id'");
        }
        if ( $icon_type==2 && $file_id != null && $file_id != ''  ) { // if user disliked
            $msg = Update('post', "dislike_count=dislike_count+1", "id='$post_id'");
        }

        if($msg )
        {
            $return=1;
        }
        else
        {
            $return = -2;
        }
    }
    /***** if user  vote before and want to change it ********/
    if ( $user_first_vote=='0' && $post_id != "" && $change=='1') {

        $vote = select("post_like","id","post_id='$post_id' AND user_id='$user_id'");
        if($vote !=null  && $vote != '' ) {
            $vote_id = $vote[0]["id"];
            $msg = Update('post_like', "vote='$user_vote'", "id='$vote_id'");

            if ($msg &&  $icon_type == 1) { // if user liked
                $msg = Update('post', "like_count=like_count+1,dislike_count=dislike_count-1", "id='$post_id'");
            }
            if ($msg && $icon_type == 2) { // if user disliked
                $msg = Update('post', "dislike_count=dislike_count+1,like_count=like_count-1", "id='$post_id'");
            }

            if ($msg) {
                $return = 2;
            } else {
                $return = -2;
            }
        }
    }

    Disconnect();
    echo $return;
}
//*************************************************************************************
//*********************************   Add Comment  ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="I17425v6bf752UC")
{
	try{
		Connect();

		    $user_id = $_SESSION["user_id"];
			$user_fullname = $_SESSION["full_name"];
			$user_email = $_SESSION["user_email"];
			$user_comment = htmlspecialchars(mysql_real_escape_string($_POST['c']));
			//$user_comment = strip_tags($_POST['c_h'], '<img><br>');
			$post_subject_id =  mysql_real_escape_string($_POST['sid']);
			$post_category_id =  mysql_real_escape_string($_POST['cid']);
			$post_id = mysql_real_escape_string($_POST['p']);
			$currentDate=jdate('Y/m/d');
			$currentTime = date('H:i:s');
			$serverId=$_SERVER['REMOTE_ADDR'];
			$ua=getBrowser();
			$yourbrowser= $ua['name'] . " " . $ua['version'] ;

			$message = "";
			$comment = "";

		          if($_SESSION['user_type']=='1' || $_SESSION['user_type']=='3' ) // if is admin or power user
		             {
		             	//------------
						$approved = '1';
						$parent = '0';
						$has_child = '0';
						$status = '1';
						//-------------
		             	$user_fullname=$_SESSION['full_name'];
						$user_email=$_SESSION['user_email'];
						$property = array('',$post_subject_id,$post_category_id,$post_id,$user_id,$user_fullname,$user_email,$serverId,$currentDate,$currentTime,
					 					  $user_comment,$yourbrowser,$approved,$parent,$has_child,$status);

					}
		        	else
					{
						//------------
						$approved = '0';
						$parent = '0';
						$has_child = '0';
						$status = '1';
						//-------------
			            $user_fullname=$_SESSION['full_name'];
						$user_email=$_SESSION['user_email'];
						$property = array('',$post_subject_id,$post_category_id,$post_id,$user_id,$user_fullname,$user_email,$serverId,$currentDate,$currentTime,
					 					  $user_comment,$yourbrowser,$approved,$parent,$has_child,$status);
						$message = "<div class='alert alert-success'>". "پیغام شما موقتا ثبت شده است  و پس از تایید مدیر بطور ثابت نمایش داده خواهد شد "."<div>";
					}

				$file_id=insert('comment',$property);
				$msg=Update('post',"comment_count=comment_count+1","id='$post_id'");

			    $comment .="
						<div class='box-comment' id='cmd_box_{$file_id}'>
						<!-- User image -->
						<img class='img-circle img-sm' src='{$HOST_NAME}resources/shared/admin/img/user-comment.png' alt='user image'>

						<span class='username'>
						{$user_fullname}
						</span>";
					    if( isset($_SESSION["user_id"]))
						{
                            $comment .="<div style='float:left;margin-top:-20px;' >
								<button class='btn btn-default btn-xs'  onClick='edit_comment({$file_id},{$_SESSION['user_id']},{$post_id});' ><i class='fa  fa-edit'></i> </button>
								<button class='btn btn-default btn-xs' onClick='confirm_remove({$file_id},{$_SESSION['user_id']},{$post_id});;'  ><i class='fa  fa-remove'></i> </button>
							</div>";
						}
                        $comment .="<span id='cmd_real_txt_{$file_id}' style='display:none'>{$user_comment}</span>";
                        $comment .="<div id='cmd_txt_{$file_id}' class='comment-text'>"
						 . replace_smily_with_image($user_comment, $HOST_NAME) .
						"</div><!-- /.comment-text -->
						<span class='text-muted pull-left'>Date: {$currentDate}  Time: {$currentTime}</span>

						</div><!-- /.box-comment -->";
		   echo json_encode(
				array(
					"valid" => '1',
					"message" => $message,
					"comment" => $comment,

				)
			);

	    Disconnect();
	}
	catch(Exception $e){
		$message = "خطایی رخ داده است ، لطفا چند لحظه دیگر امتحان نمایید";
		echo json_encode(
				array(
						"valid" => '0',
						"message" => $message,
						"comment" => $comment,

				)
				);
	}
}
//*************************************************************************************
//*********************************   Update Comment  ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="I17Edit6bf752UC")
{
    try{
        Connect();

        $user_id = $_SESSION["user_id"];
        $comment_id = mysql_real_escape_string($_POST['cid']);
        $user_comment = htmlspecialchars(mysql_real_escape_string($_POST['c']));
        $post_id = mysql_real_escape_string($_POST['p']);
        $currentDate=jdate('Y/m/d');
        $currentTime = date('H:i:s');
        $serverId=$_SERVER['REMOTE_ADDR'];
        $ua=getBrowser();
        $yourbrowser= $ua['name'] . " " . $ua['version'] ;
        $user_fullname=$_SESSION['full_name'];
        $user_email=$_SESSION['user_email'];
        $message = "";
        $comment = "";

        $msg=Update('comment',"content='$user_comment'","id='$comment_id'");
        $comment = replace_smily_with_image($user_comment, $HOST_NAME);
  
        echo json_encode(
                array(
                    "valid" => '1',
                    "comment" => $comment,
                    "real_comment" => $user_comment,
                )
        );

        Disconnect();
    }
    catch(Exception $e){
        echo json_encode(
            array(
                "valid" => '0',
                "comment" => "",
                "real_comment" => "",
            )
        );
    }
}
//*************************************************************************************
//*********************************   Remove Comment  ***********************************
//*************************************************************************************
if(isset($_POST["check"]) && $_POST["check"]=="I1Rm25v6bf752UC")
{

		Connect();
		$c_id= $_POST["c"];
		$cm_user_id = $_POST["cm_user_id"];
        $post_id = $_POST["cm_post_id"];

		if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $cm_user_id ) //check if the comment belong to this user
        {
            $msg1 = Delete('comment', "id='$c_id'");
            $msg2 = Update('post', "comment_count=comment_count-1", "id='$post_id'");

            $message = "نظر شما با موفقیت حذف گردید";
            echo json_encode(
                array(
                    "valid" => '1',
                    "message" => $message,
                )
            );
         }

         Disconnect();
}

?>
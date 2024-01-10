<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';



//*************************************************************************************
//***********************   comment seen   **************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="Sc345c05c6dXYZcCS")
{
   Connect();
   $_SESSION["unseen_comments_count"]="0";
   $unseen_comments =  $_SESSION['unseen_comments'];
   $unseen_ids = "0";
   //change the status of unseen comments from 1 to 0
   foreach($unseen_comments as $unseen_comment)
   {
		$unseen_ids .=  "," . $unseen_comment['id'] ;
   }
   Update("comment", "status=0","id in ({$unseen_ids})");

   echo json_encode(
   		array(
   				"valid" => '1',
   				"comment_count" => '0',

   		)
   	);
   Disconnect();

}



?>
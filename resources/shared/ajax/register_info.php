<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';

//*************************************************************************************
//*********************************  Email Check    ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="C354c05v6k752I")
{

	Connect();
	// Define variables and set to empty values
	$email = mysql_real_escape_string($_POST['email']);
    if($email !="" && filter_var($email, FILTER_VALIDATE_EMAIL))
    {

       $count=countRows('users','id',"email='{$email}'");
	   if($count >= 1 )
	   {
		   echo json_encode(
				array(
					"status" => 1,
					"data" => 1,
				)
			);
	   }
	   else if($count== 0)
	   {
	   		echo json_encode(
	   			array(
	   					"status" => 1,
	   					"data" => 0,
	   			)
	   	);
	   }

    }
    else //invalid email
    {
	  echo json_encode(
			array(
				"status" => 0,
				"data" => 0,
			)
		);
    }
    Disconnect();

}
//*************************************************************************************
//********************************* UserName Check    ***********************************
//*************************************************************************************
if (isset($_POST["check"]) && $_POST["check"]=="C717c05v6k752I")
{

	Connect();
	// Define variables and set to empty values
	$username = mysql_real_escape_string($_POST['username']);
	if (preg_match('/[^A-Za-z0-9]+/', $username) || strlen($username) > 1) // check if the characyers is in english or the len is smaller that 4
	{

		$count=countRows('users','id',"username='{$username}'");
		if($count >= 1 )
		{
			echo json_encode(
					array(
							"status" => 1,
							"data" => 1,
					)
			);
		}
		else
		{
			echo json_encode(
					array(
							"status" => 1,
							"data" => 0,
					)
			);
		}

	}
	else //invalid username
	{
		echo json_encode(
				array(
						"status" => 0,
						"data" => 0,
				)
		);
	}
	Disconnect();

}
?>
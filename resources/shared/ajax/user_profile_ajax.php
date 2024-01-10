<?php
require_once '../../libraries/session.php';
include_once '../../includes/dblayer_mysql.php';
include_once '../../libraries/phpfunction.php';
include_once '../../libraries/jdf.php';
$date = time();
//----if user is not loged in----

 if(isset($_POST["action"]) && !empty($_POST["action"]) && isset($_SESSION['user_id']))
 {
    Connect();
	$user_id = $_SESSION['user_id'];
	//Save Password Changes
	if($_POST["action"] == "save_pass") //Updating
	{
		$current_pass=$_POST['current_pass'];
		$new_pass = $_POST['new_pass'];
		//--------get current pass----------------

		$sql = "SELECT * FROM users WHERE id=$user_id";
		if (!mysql_query($sql,$link))
		{
			echo json_encode(
					array(
							"success" => "0",
							"message"   => "data base error",
					)
			);
			exit();
		}

		$res=mysql_query($sql,$link);
		$count=mysql_num_rows($res);
		if($count > 0 )
		{
			$row = mysql_fetch_array($res);
			$current_password = $row['user_pass'];
		}

		if($current_pass == $current_password)
		{

			//------------------------
			$sql2 = "UPDATE users SET
			user_pass = '$new_pass'
			WHERE id=$user_id";
			if (!mysql_query($sql2,$link))
			{
				echo json_encode(
						array(
								"success" => "0",
								"message"   => "خطا در ذخیره سازی",
						)
				);
				exit();
			}

			echo json_encode(
					array(
							"success" => "1",
							"message"   => "کلمه عبور با موفقيت تغییر کرد",
					)
			);

	}
		else
		{
			echo json_encode(
					array(
							"success" => "0",
							"message"   => "کلمه عبور فعلی صحیح نمی باشد",
					)
			);
		}

	}

	//Save Profile Changes
	if($_POST["action"] == "save_profile") //Save Profile Changes
	{
	 // code goes here
	}
   Disconnect();
 }


 //Uploading photo
 if(!isset($_POST["action"]) && isset($_SESSION['user_id'])) //uploading photo
 {

 	$uploaddir = '../../admin/uploads/user/';

    Connect();
 	$uploadname   = $_FILES['uploadfile']['name'];
 	$uploadtype   = $_FILES['uploadfile']['type'];
 	$uploadsize   = $_FILES["uploadfile"]["size"] / 1024;

 	$file_ext = getExtension($uploadname);
 	$cur_date = getdate();
 	$file_name = $_SESSION['user_id'] . "_" . $cur_date[0] . "." . $file_ext;
 	$file = $uploaddir . $file_name;

 	//delete previous file if exist
 	$sql_user_photo = "SELECT photo FROM users WHERE id= ". $_SESSION['user_id'] ;
 	$result_user_photo = mysql_query($sql_user_photo,$link);
 	$user_photo= mysql_fetch_array($result_user_photo);
 	$photo_address=$uploaddir . $user_photo['photo'];

 	if(is_file($photo_address))
 	{
 		unlink($photo_address);
 	}
 	//update data base
 	$db_photo_address = "uploads/user/{$file_name}";
 	$sql_user_photo_upload = "UPDATE users SET
 	photo= '$db_photo_address' WHERE id=" . $_SESSION['user_id'];

 	if (!mysql_query($sql_user_photo_upload,$link))
 	{
 		$error = 'Error adding submitted photo.'.mysql_error();
 		include 'error.php';
 		exit();
 	}
 	$_SESSION["user_photo"] = "uploads/user/{$file_name}";
 	//------------------
 	if($uploadsize >= 200)
 	{
 		//--Resizing the photo if its big-----
 		include_once('../../libraries/image_resize.class.php');
 		$image = new ResizeImage();
 		$image->load($_FILES['uploadfile']['tmp_name']);
 		$image->resizeToWidth(600);
 		$image->save($file);
 		echo "success" . "," . $file_name;
 	}
 	else
 	{
 		if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
 			echo "success" . "," . $file_name;
 		}
 		else {
 			echo "error";
 		}
 	}
 	Disconnect();
 }
 //functions
function getExtension($str)
{
	$i = strrpos($str,".");
	if (!$i) {
		return "";
	}
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

?>

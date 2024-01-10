
<?php
/*
 * description: This class containing validation functions for fields of a form.
 * release date: 10/30/2011
 * version: 1.0
 * Distributed under GNU General Public License (GPL)
 */


class validation
{
	function name_validation($name, $field = 'Name', $min_length = 3, $max_length = 33)
	{
		// Full Name must contain letters, dashes and spaces only. We have to eliminate dash at the begining of the name.
		$name = trim($name);
		if (strlen($name) >= $min_length )
		{
			if (strlen($name) <= $max_length )
			{
				if(preg_match("(.*)", $name) === 0)
					$error = $field.' نمی تواند شامل - در ابتدا باشد ';
				else $error = null;
			}else $error = '  فیلد '. $field.' باید حد اکثر'.$max_length.' حرفی باشد ';;
		}else $error ='  فیلد '. $field.' باید حداقل '.$min_length.' حرفی باشد ';
		
		return $error;
		
		/*
		if we want to impose the Full Name to start with upper case letter we have to use that:
		if(preg_match("/^[A-Z][a-zA-Z -]+$/", $name) === 0)
		*/
	}
	
	function email_validation($email, $email_label)
	{
		//E-mail validation: We use regexp to validate email.
		$email = trim($email);
		if (strlen($email) >= 1 )
		{
			if(preg_match("/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is", $email) === 0)
				$error = $email_label . 'نا معتبر می باشد  ';
			else $error = null;
		}else $error = $email_label . ' وارد نشده است  ';
		
		return $error;
	}
	
	function digits_validation($digits, $digits_label)
	{
		//Value must be digits.
		$digits = trim($digits);
		if (strlen($digits) >= 1 )
		{
			if(preg_match("/^[0-9]+$/", $digits) === 0)
				$error = $digits_label .' نا معتبر می باشد ';
			else $error = null;
		}else $error = $digits_label . ' وارد نشده است ';
		
		return $error;
	}
	
	function username_validation($username, $username_label)
	{
		//User must be digits and letters.
		$username = trim($username);
		if (strlen($username) >= 1 )
		{
			if(preg_match("/^[0-9a-zA-Z_-]{3,}.*$/", $username) === 0)
				$error =' باید حداقل 3 حرفی باشد '. $username_label;
			else $error = null;
		}else $error =$username_label . ' وارد نشده است ';				
		return $error;
	}
	
	function date_validation($date, $date_label)
	{
		//Date must be with this form: YYYY/MM/DD.
		$date = trim($date);
		if (strlen($date) >= 1 )
		{
			if(preg_match("/[0-9]{4}\/[0-9]{1,2}\/[0-9]{1,2}/", $date) === 0)
				$error = ' تاریخ باید به این شکل وارد شود: YYYY/MM/DD ';
			else $error = null;
		}else $error = $error = $date_label.' وارد نشده است ';
		
		return $error; 
	}
	
	function address_validation($address, $required, $address_label)
	{
		//Address must be only letters, numbers or one of the following ". , : /"
		$address = trim($address);
		if (strlen($address_label) == 0) $address_label = 'address';
		
		if (strlen($address) >= 1)
		{
			if(preg_match("(.*)", $address) === 0)
				$error =$address_label.' معتبر نمی باشد ';
			else $error = null;
		}elseif ($required == true) 
			$error = $address_label.' وارد نشده است ';
		else $error = null;
		
		return $error;
	}
	//For Requerd Filels
	function required_validation($data_entry,$required,$required_label)
	{
		$data=trim($data_entry);
		
		if (strlen($data) == 0 && $required == true)	
			$error = $required_label.' وارد نشده است ';
		else 
		    $error=null;   
		
		return  $error;    
	}
	
	function password_validation($password, $level, $password_label)
	{
		$password = trim($password);
		
		switch ($level)
		{
			//Password must be at least 6 characters
			case 0:
			if (strlen($password) >= 1 )
			{
				if(preg_match("/^.*(?=.{6,}).*$/", $password) === 0)
					$error = ' کلمه عبور باید حداقل 6 حرفی باشد ';
				else $error = null;
			}else $error = $password_label.' وارد نشده است ';
			
			break;
			
			//Password must be at least 8 characters and at least one digit.
			case 1:
			if (strlen($password) >= 1 )
			{
				if(preg_match("/^.*(?=.{8,})(?=.*[0-9]).*$/", $password) === 0)
					$error = ' کلمه عبور باید حتما 8 حرفی باشد و شامل یک عدد ';
				else $error = null;
			}else $error = $password_label.' وارد نشده است ';
			
			break;
			
			//Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit(alphanumeric).
			case 2:
			if (strlen($password) >= 1 )
			{
				if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0)
					$error = ' کلمه عبور باید حتما 8 حرفی باشد و در آن حداقل یک حرف بزرگ و یک حرف کوچک و یک عدد به کار رفته باشد ';
				else $error = null;
			}else $error = $password_label.' وارد نشده است ';
			
			break;
					
			default:
			$error = null;
			break;			
		}
		return $error;
	}
	
	function password_repeat_validation($password, $password_r, $password_r_label)
	{
		//Password Repeatition must be  math with the first password entry"
		$password = trim($password);
		$password_r = trim($password_r);
		if($password != $password_r)
			$error = $password_r_label . ' با ید با کلمه عبور یکسان باشد ';
		else $error = null;		
		return $error; 
	}
	function security_code_validation($code, $user_code, $security_code_label)
	{
		$login_captcha=null;
		$code = trim($code);
		$user_code = trim($user_code);
		if($code != $user_code)
			$error = $security_code_label . '  اشتباه می باشد ';
		else 
			$error = null;
		return $error;
	}
	
};
?>
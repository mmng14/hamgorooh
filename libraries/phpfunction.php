<?php
//do nothing
function encryptIt( $q  ) {
    return( $q );
}

//do nothing
function decryptIt( $q ) {
    return( $q );
}

function encrypt_data( $q,$secret_key=""  ) {
    $qEncoded = encrypt_decrypt("encrypt", $q,$secret_key);
    return( $qEncoded );
}

function decrypt_data( $q,$secret_key="" ) {
   $qDecoded = encrypt_decrypt("decrypt", $q,$secret_key);
    return( $qDecoded );
}

function encrypt_decrypt($action, $string,$secret_key) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    if($secret_key==""){
        $secret_key = 'This is my secret key';  
    }  
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function encode_url($id){

	$id=encryptIt($id);
	$characters ='*%abcdefghijklmnopqrstuvwxyz123456789';
    $randstring1 = '';
    $maintxt='';

	for ($i = 0; $i < 4; $i++) {
		if ( $randstring1!=''){
			  $randstring1 .= $characters[rand(0, strlen($characters)-1)];
	}
  else{
	 $randstring1 = $characters[rand(0, strlen($characters)-1)];
 }
  }
  $maintxt = $randstring1.$id;
  $maintxt=base64_encode($maintxt);
  return $maintxt;
}

function decode_url($string){
	$string=base64_decode($string);
    $id = substr($string, 4,strlen($string));
	$id=decryptIt($id);
	return $id;
}

function convertEngToPersian($string){
	$arr1 = str_split($string);
	$farsi_array = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", ".");
	$english_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ".");
	$resultArray =str_replace($english_array, $farsi_array, $arr1);
    $result_string = join($resultArray);
	return $result_string;
}

function PerToEng($string){
	$arr1 = str_split($string);
	$farsi_array = array("۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹", ".");
	$english_array = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ".");
	$resultArray =str_replace($farsi_array,$english_array, $arr1);
    $result_string = join($resultArray);
	return $result_string;
}

function convertPersianToEng($string)
{
	  $str=explode("/",$string);
	  $result_string="";
	  $farsi_array = "۱۲۳۴۵۶۷۸۹۰";
	  $english_array = array(1=>"1", 3=>"2",5=> "3",7=> "4",9=> "5", 11=>"6",13=> "7",15=> "8", 17=>"9",19=>"0");
	  $arr_farsi = str_split($farsi_array);
	 for ($i=0;$i<sizeof($str);$i++){
		  $arr_tmp = str_split($str[$i]);
		  for ($j=1;$j<sizeof($arr_tmp);$j+=2){
			 $index=array_search($arr_tmp[$j], $arr_farsi);
             if(isset($english_array[$index]))
			    $result_string.=$english_array[$index];
		  }
		  if ($i!=sizeof($str)-1)
		       $result_string.="/";
	 }
	 return $result_string;
}

function increase_week($classStartDate,$weeknum){
	     $classFinishDate='';
		 $datearr=explode("/",$classStartDate);
		 $day_tmp=$datearr[2];
		 $month_tmp=$datearr[1];
		 $year_tmp=$datearr[0];
		 $day_tmp=intval($datearr[2])+$weeknum*7;
		 if (intval($datearr[1])<=6){
			 $monthnum=floor($day_tmp/31);
			 $month_tmp=intval($datearr[1])+$monthnum;
			 $day_tmp-=31*$monthnum;
		 }
		 else {
			  $monthnum=floor($day_tmp/30);
			  $month_tmp=intval($datearr[1])+$monthnum;
			  $day_tmp-=30*$monthnum;
		 }
		 $month_tmp=intval($month_tmp);
		 if ($month_tmp>12){
		 $yearnum=floor($month_tmp/12);
		 $year_tmp=intval($datearr[0])+$yearnum;
		 }
		 while (intval($month_tmp)>12){
			 $month_tmp=intval($month_tmp);
			 $month_tmp-=12;
			  if ($month_tmp==0) $month_tmp=1;
			 if ($month_tmp<=9)
			    $month_tmp="0".$month_tmp;
		 }
		 //------------------------
	     if (intval($day_tmp)==0)  $day_tmp=1;
		 if (intval($day_tmp)<=9)
		    $day_tmp="0".$day_tmp;
			 if ($month_tmp==0) $month_tmp=1;
			if (intval($month_tmp)<=9)
		    $month_tmp="0".intval($month_tmp);
		 return  $classFinishDate=convertEngToPersian($year_tmp."/".$month_tmp."/".$day_tmp);
}

//--- function for detect device 
function detectDevice(){
	$userAgent = $_SERVER["HTTP_USER_AGENT"];
	$devicesTypes = array(
        "computer" => array("Trident","msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
    foreach($devicesTypes as $deviceType => $devices) {           
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
    return ucfirst($deviceName);
}


//--- function for get user browser name
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {

            if(isset($matches['version'][1]))
                $version= $matches['version'][1];
            else
                $version = "x";
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function get_browser_name($user_agent){
    $t = strtolower($user_agent);
    $t = " " . $t;
    if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
    elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
    elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
    elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
    elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
    elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
    return 'Unkown';
}
// Function for check input security 

function test_input($data)
{
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}

function mysql_escape_mimic($inp) {
    if(is_array($inp))
        return array_map(__METHOD__, $inp);

    if(!empty($inp) && is_string($inp)) {
        return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
    }

    return $inp;
}

//------------------------------

function formatDateByZero($input_date){
    
    $array= explode('/', $input_date);
    $year = $array[0];
    $month = $array[1];
    $day = $array[2];

    if(strlen($month)==1){
        $month = "0" .  $month;
    }

    if(strlen($day)==1){
        $day = "0" .  $day;
    }

    return  $year . "/" .   $month . "/" . $day;
}

//get ghamari date in mm-dd-yyyy format and change it to 1394 محرم   12
function  convert_hijri_ghamari($hijri)
{
	$str_day = substr($hijri, 0,2);
	$str_month = substr($hijri, 3,2);
	$str_year = substr($hijri, 6,4);

	switch ($str_month) {
		case "01":
			$str_month_name= "محرم";
			break;
		case "02":
			$str_month_name= "صفر";
			break;
		case "03":
			$str_month_name= "ربيع الاول";
			break;

		case "04":
			$str_month_name= "ربيع الثاني";
			break;
		case "05":
			$str_month_name= "جمادي الاول";
			break;
		case "06":
			$str_month_name= "جمادي الثاني";
			break;

		case "07":
			$str_month_name= "رجب";
			break;
		case "08":
			$str_month_name= "شعبان";
			break;
		case "09":
			$str_month_name= "رمضان";
			break;

		case "10":
			$str_month_name= "شوال";
			break;
		case "11":
			$str_month_name= "ذيقعده";
			break;
		case "12":
			$str_month_name= "ذالحجه";
			break;

	}

	return  $str_day  ." - " . $str_month_name . " - " .  $str_year;
}

/////Get File Type//////
function get_file_type_by_id($id)
{
	$file_type = "unknown";
	switch ($id)
	{
		case 1 : $file_type = "zip";
		break;
		case 2 : $file_type = "rar";
		break;
		case 3 : $file_type = "video";
		break;
		case 4 : $file_type = "audio";
		break;
		case 5 : $file_type = "pdf";
		break;
		case 6 : $file_type = "doc/docx";
		break;
		case 7 : $file_type = "picture";
		break;
		default:
			return $file_type = "unknown";
	}
	return  $file_type;
}

function get_post_type_by_id($id)
{
	$file_type = "unknown";
	switch ($id)
	{
		case 0 : $file_type = "picture";
			break;
		case 1 : $file_type = "audio";
			break;
		case 2 : $file_type = "video";
			break;
		case 3 : $file_type = "aparat";
			break;
		default:
			return $file_type = "unknown";
	}
	return  $file_type;
}

//redirect to a page
function redirect_to( $location = NULL ) {
	if ($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}
//put message in a p tag
function output_message($message="") {
	if (!empty($message)) {
		return "<p class=\"message\">{$message}</p>";
	} else {
		return "";
	}
}


// Function to get the client ip address
function get_client_ip_server() {
	try {
		$ipaddress = '';
		if ($_SERVER['HTTP_CLIENT_IP'])
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if ($_SERVER['HTTP_X_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if ($_SERVER['HTTP_FORWARDED_FOR'])
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if ($_SERVER['HTTP_FORWARDED'])
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if ($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';

		return $ipaddress;
	}
	catch(Exception $e)
	{
		return $e;
	}
}

/**
 * Returns a GUIDv4 string
 *
 * Uses the best cryptographically secure method
 * for all supported pltforms with fallback to an older,
 * less secure version.
 *
 * @param bool $trim
 * @return string
 */
function GUIDv4 ($trim = true)
{
	// Windows
	if (function_exists('com_create_guid') === true) {
		if ($trim === true)
			return trim(com_create_guid(), '{}');
		else
			return com_create_guid();
	}

	// OSX/Linux
	if (function_exists('openssl_random_pseudo_bytes') === true) {
		$data = openssl_random_pseudo_bytes(16);
		$data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	// Fallback (PHP 4.2+)
	mt_srand((double)microtime() * 10000);
	$charid = strtolower(md5(uniqid(rand(), true)));
	$hyphen = chr(45);                  // "-"
	$lbrace = $trim ? "" : chr(123);    // "{"
	$rbrace = $trim ? "" : chr(125);    // "}"
	$guidv4 = $lbrace.
		substr($charid,  0,  8).$hyphen.
		substr($charid,  8,  4).$hyphen.
		substr($charid, 12,  4).$hyphen.
		substr($charid, 16,  4).$hyphen.
		substr($charid, 20, 12).
		$rbrace;
	return $guidv4;
}

function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
        $status = true;
    }else{
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function db_result_to_array($obj)
{
    $arra=array();
    $data =array_map('iterator_to_array', iterator_to_array($obj));
    foreach ($data as $value)
    {
        array_push($arra,$value);
    }
    return $arra;
}

function view_to_string($file,$path,$value=null,$pagination=null,$folder_name=null,$host_name=null)
{
    ob_start();
    if(file_exists($_SERVER["DOCUMENT_ROOT"] ."{$folder_name}{$path}{$file}"))
    {
        $model=$value;
        if($host_name!=null)
        {
            $HOST_NAME = $host_name;
        }
        if($pagination !=null)
        {

            $item_per_page = $pagination["item_per_page"];
            $page_number = $pagination["page_number"];
            $total_rows = $pagination["total_rows"];
            $total_pages=$pagination["total_pages"];

        }
        include_once $_SERVER["DOCUMENT_ROOT"] ."{$folder_name}{$path}{$file}";
    }
    else
        echo "<p> چیزی یافت نشد </p>";
    $view= ob_get_contents();
    ob_end_clean();
    return $view;
}

function view_tostring($file,$path,$value=null,$pagination=null,$host_name=null)
{
    ob_start();
    if(file_exists($_SERVER["DOCUMENT_ROOT"] .rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."{$path}{$file}"))
    {
        $model=$value;
        if($host_name!=null)
        {
            $HOST_NAME = $host_name;
        }
        if($pagination !=null)
        {
            
            $item_per_page = $pagination["item_per_page"];
            $page_number = $pagination["page_number"];
            $total_rows = $pagination["total_rows"];
            $total_pages=$pagination["total_pages"];

        }
        include_once $_SERVER["DOCUMENT_ROOT"] .rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."{$path}{$file}";
    }
    else
        echo "Not Found";
    $view= ob_get_contents();
    ob_end_clean();
    return $view;
}

function partial($file,$path,$value=null)
{
    ob_start();
    if(file_exists($_SERVER["DOCUMENT_ROOT"] .rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."{$path}{$file}"))
    {
        $model=$value;
        include_once $_SERVER["DOCUMENT_ROOT"] .rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."{$path}{$file}";
    }
    else
        echo "Not Found";
    $view= ob_get_contents();
    ob_end_clean();
    echo $view;
}

function getExtension($str)
{
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

//isValidImageExtension
function isValidImageExtension($ext)
{
    $ext = strtolower($ext);
    $valid_types = array("jpg", "jpeg", "bmp", "gif", "ttf", "png");
    if (in_array($ext, $valid_types))
        return 1;
    return 0;
}

function isValidPhotoExtension($ext)
{
    $ext=strtolower($ext);
    $valid_types = array("jpg", "jpeg", "bmp", "gif","ttf","png");
    if (in_array($ext, $valid_types))
        return 1;
    return 0;
}

function isValidAudioExtension($ext)
{
    $ext=strtolower($ext);
    $valid_types = array("mp3");
    if (in_array($ext, $valid_types))
        return 1;
    return 0;
}

function isValidVideoExtension($ext)
{
    $ext=strtolower($ext);
    $valid_types = array("mp4" );
    if (in_array($ext, $valid_types))
        return 1;
    return 0;
}

function isValidCompressedFileExtension($ext)
{
    $ext=strtolower($ext);
    $valid_types = array("zip", "rar", "tar");
    if (in_array($ext, $valid_types))
        return 1;
    return 0;
}


function getTypeName($type){
    $user_type_name = "نا مشخص";
    if ($type == 1) {
        $user_type_name = "مدیر سایت";
    }
    if ($type == 2) {
        $user_type_name = "مدیر گروه اصلی";
    }
    if ($type == 3) {
        $user_type_name = "مدیر گروه";
    }
    if ($type == 4) {
        $user_type_name = "کابر ويژه";
    }
    if ($type == 5) {
        $user_type_name = "کاربر سایت";
    }
    return $user_type_name;
}

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function minifyHtml($html){
  return preg_replace('/\>\s+\</m', '><', $html);
}

function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        '/<!--(.|\s)*?-->/' // Remove HTML comments
    );

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}

function _group_by($array, $key) {
    $return = array();
    foreach($array as $val) {
        $return[$val[$key]][] = $val;
    }
    return $return;
}
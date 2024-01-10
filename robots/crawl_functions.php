<?php

//return node inner html
function DOMinnerHTML(DOMNode $element) 
{	
	$innerHTML = "";	
	$children  = $element->childNodes;	
	foreach ($children as $child) 
	{
		$innerHTML .= $element->ownerDocument->saveHTML($child);
	}
	return $innerHTML;
}


function GetDOMinnerHTML(DOMNode $element,$type="*",$name="*") 
{
	$innerHTML = "";
	$children  = $element->childNodes;
	if($type=="*" && $name=="*")   
	{
		foreach ($children as $child) 
		{
			$innerHTML .= $element->ownerDocument->saveHTML($child);
		}
	}
    
	
	//-	-----------
	
	if($type=="tag" && $name!="*")   
	{
		foreach ($children as $child) 
		{
			if($child->nodeName==$name)
                $innerHTML .= $element->ownerDocument->saveHTML($child);
		}
	}
	return $innerHTML;
}


function RemoveByTagName($html,$tag)
{
	$dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$innerHTML = "";
	$selector = new DOMXPath($dom);

	foreach($selector->query('//' . $tag ) as $e ) {

		$e->parentNode->removeChild($e);       
	}
    
	$innerHTML = $dom->saveHTML($dom->documentElement);
	return $innerHTML ;
}

function GetByTagName($html,$tag)
{
	$dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$htmlString = "";
	$selector = new DOMXPath($dom);
    $nodes = $selector->query('//' . $tag );
    $htmlString = $dom->saveHTML($nodes->item(0));
	return $htmlString ;
}

function AddClassAndRemoveBrokenImages($html,$exception,$site_name,$tag="img",$new_class="img-responsive pad")
{
	$dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$innerHTML = "";
	$selector = new DOMXPath($dom);

	foreach($selector->query('//' . $tag ) as $e ) {
        $imageUrl = $e->getAttribute('src');
        $imageUrl = "{$site_name}" .$imageUrl ;
        echo $imageUrl . "=====" .$exception . "<br/>";
        if ($imageUrl !=$exception && @getimagesize($imageUrl) !== false) 
        {
			$size =@getimagesize($imageUrl);
            if(($size[0] + $size[1] ) >=  300)
			{ 
                $e->setAttribute('class', $new_class);
                $e->setAttribute('src', $imageUrl);
            }
            else
            {
                $e->parentNode->removeChild($e);
            }
        }
        else
        {
            $e->parentNode->removeChild($e);
        }   
        
	}
    
	$innerHTML = $dom->saveHTML($dom->documentElement);
	return $innerHTML ;
}

function RemoveTagByClass($html,$element,$className)
{
	$dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$innerHTML = "";
	$selector = new DOMXPath($dom);

	foreach($selector->query('//' . $element . '[contains(attribute::class,"'.$className.'")]') as $e ) {

		$e->parentNode->removeChild($e);       
	}
    
	$innerHTML = $dom->saveHTML($dom->documentElement);
	return $innerHTML ;
}



function RemoveTagById($html,$element,$id)
{
	$dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$innerHTML = "";
	$selector = new DOMXPath($dom);
	foreach($selector->query('//' . $element . '[contains(attribute::id,"'.$id.'")]') as $e ) {

		$e->parentNode->removeChild($e);       
	}
    
	$innerHTML = $dom->saveHTML($dom->documentElement);
	return $innerHTML ;
}

function add_class_to_images($html,$new_class="img-responsive pad" ) {

    $dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $images = $dom->getElementsByTagName('img');

    foreach ($images as $image) {
        $imageUrl = $image->getAttribute('src');	
        if (@getimagesize($imageUrl) !== false) 
        {
			$size =@getimagesize($imageUrl);
            if(($size[0] + $size[1] ) >=  300)
			{ 
                $image->setAttribute('class', $new_class);
            }
            else
            {
                $image->parentNode->removeChild($image);
            }
        }
        else
        {
            $image->parentNode->removeChild($image);
        }        
    } //end foreach

    $content =$dom->saveHTML($dom->documentElement);
    return $content;
}

function RemoveByClass(DOMNode $domdoc,$class="*") 
{
    $document = "";
    $dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($document, 'HTML-ENTITIES', 'UTF-8'));
	$selector = new DOMXPath($dom);
	foreach($selector->query('//div[contains(attribute::class,"'.$class.'")]') as $e ) {

		$e->parentNode->removeChild($e);        
	}    
	$innerHTML = $dom->saveHTML($dom->documentElement);
	return $innerHTML ;
	
}



function GetDOMImages(DOMNode $element,$type,$name,$postGUID,$upload_folder,$site_name) 
{
	$innerHTML = "";
	$images = $element->getElementsByTagName('img');

	$arrContextOptions=array(
		"ssl"=>array(
			  "verify_peer"=>false,
			  "verify_peer_name"=>false,
		  ),
	  );

	foreach ($images as $image) {
        $imageURL = $image->getAttribute('src');
        $imageURL = "{$site_name}" .$imageURL ;
        if (@getimagesize($imageURL) != false) { 
            $imageName =getImageName($imageURL);
            $local_address = "uploads/{$upload_folder}/{$postGUID}__{$imageName}";
//            echo "<h1>{$local_address}</h1>";
            //copy($imageURL , "../{$local_address}");
            //$data = file_get_contents($imageURL);
			$data = file_get_contents($imageURL, false, stream_context_create($arrContextOptions));
            $new = "../{$local_address}";
            file_put_contents($new, $data);

            $innerHTML.=  $local_address . ","  ;//"tmp/$newId.jpeg" . ",";
        }
        
	}
	return $innerHTML;	
}


function getImageName($img)
{
    $imageName = "";
    $imageArr = explode('/',$img);
    $c = count($imageArr);
    if($c > 3)
    {
        $imageName = $imageArr[$c-1];  
    }
    
    return $imageName;
}

function replace_img_src($html,$postGUID,$host,$upload_folder) {
    $doc = new DOMDocument();
    @$doc->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $tags = $doc->getElementsByTagName('img');
    foreach ($tags as $tag){
        $old_src = $tag->getAttribute('src');
        //////////////////////
        $imageName = "";
        $imageArr = explode('/',$old_src);
        $c = count($imageArr);
        if($c > 3)
        {
            $imageName = $imageArr[$c-1];  
        }
        //////////////////////

        $new_src_url = "{$host}uploads/{$upload_folder}/{$postGUID}__".$imageName;
        echo  $new_src_url . "<br/>";
        $tag->setAttribute('src', $new_src_url);
    }
    return $doc->saveHTML();
}



function GetMainImage($html,$tag="img",$site_name)
{
	$dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$innerHTML = "";
	$selector = new DOMXPath($dom);

	foreach($selector->query('//' . $tag ) as $e ) {
        $imageUrl = $e->getAttribute('src');
        $imageUrl = "{$site_name}" .$imageUrl ;
        if (@getimagesize($imageUrl) !== false) 
        {
			$size =@getimagesize($imageUrl);
            if(($size[0] + $size[1] ) >=  300)
			{ 
                $innerHTML = $imageUrl;
                break;
            }
            
        }        
	}    
	return $innerHTML ;
}

function GetDOMMainImage(DOMNode $element,$type="*",$name="*") 
{
	$innerHTML = "";
	$images = $element->getElementsByTagName('img');
	foreach ($images as $image) {
        $imageUrl = $image->getAttribute('src');	
        if (@getimagesize($imageUrl) !== false) 
        {
			$size =@getimagesize($imageUrl);
            if(($size[0] + $size[1] ) >=  300)
			{
			    echo $size[0]+ $size[1];
                echo "<br/><hr>";
                $innerHTML =  $imageUrl;
                break;
			}                  	
        }
	}
	return $innerHTML;	
}



function GetByClassName($html,$classname)
{
    $htmlString="";
    $dom = new DomDocument();
	@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
	$selector = new DOMXPath($dom);
    $nodes = $selector->query("//*[contains(@class, '$classname')]");
    //$innerHTML = $dom->saveHTML($dom->documentElement);
    $htmlString = $dom->saveHTML($nodes->item(0));
	return $htmlString ;
}



function GetByItemprob(DOMNode $element) 
{
	$xpath = new DOMXpath($element);
    $article = $xpath->query('//div/[@itemprop="articleBody"]')->item(0)->nodeValue;
    echo DOMinnerHTML($article);
}



function getGUID(){
	if (function_exists('com_create_guid')){
		return com_create_guid();
	}
	
	else{
		mt_srand((double)microtime()*10000);
		//o		ptional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);
		// 		"-"
		$uuid = substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12);
		
		return $uuid;
	}
}

function ConvertToPostDate($strDate)
{

    $date = explode(' ',$strDate);

    $day = $date[0];
    $month = getMonthNumberByName($date[1]);
    $year = $date[2];
    if(strlen($day)==1){$day="0".$day;}
    echo $date[0]. "<br/>";
    echo $date[1]. "<br/>";
    echo $date[2]. "<br/>";
    //print_r($date);
    $strdate = "";
    $strdate =  $year . "/". $month . "/" . $day;
    return $strdate;
}
function getMonthNumberByName($strMonthName)
{
    //۱۲۳۴۵۶۷۸۹۰
    $str_month_number="";
	switch ($strMonthName) {
		case "فروردین":
			$str_month_number= "۰۱";
			break;
		case "اردیبهشت":
			$str_month_number= "۰۲";
			break;
		case "خرداد":
			$str_month_number= "۰۳";
			break;
		case "تیر":
			$str_month_number= "۰۴";
			break;
		case "مرداد":
			$str_month_number= "۰۵";
			break;
		case "شهریور":
			$str_month_number= "۰۶";
			break;

		case "مهر":
			$str_month_number= "۰۷";
			break;
		case "آبان":
			$str_month_number= "۰۸";
			break;
		case "آذر":
			$str_month_number= "۰۹";
			break;

		case "دی":
			$str_month_number= "۱۰";
			break;
		case "بهمن":
			$str_month_number= "۱۱";
			break;
		case "اسفند":
			$str_month_number= "۱۲";
			break;

	}
    //('فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند');
	return  $str_month_number;   

}

function CheckHTML($string) {
    $start =strpos($string, '<');
    $end  =strrpos($string, '>',$start);

    $len=strlen($string);

    if ($end !== false) {
        $string = substr($string, $start);
    } else {
        $string = substr($string, $start, $len-$start);
    }
    libxml_use_internal_errors(true);
    libxml_clear_errors();
    $xml = simplexml_load_string($string);
    return count(libxml_get_errors())==0;
}



?>
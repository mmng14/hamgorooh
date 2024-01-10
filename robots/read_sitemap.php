<?php

$urls = array();  

$DomDocument = new DOMDocument();
$DomDocument->preserveWhiteSpace = false;
$DomDocument->load('http://akairan.com/s186/sitemap.xml');
$DomNodeList = $DomDocument->getElementsByTagName('loc');

foreach($DomNodeList as $url) {
    $urls[] = $url->nodeValue;
}

//display it
$i=1;
foreach($urls as $url)
{
    //echo $i . " : " . $url . "<br/>";
    echo  $url . "<br/>";
    $i++;
}

?>
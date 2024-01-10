 <?php
    function url(){
        if(isset($_SERVER['HTTPS'])){
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        }
        else{
            $protocol = 'http';
        }
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']."/";
    }  
    function base_url()
	{
        $base_root =$_SERVER["DOCUMENT_ROOT"] .rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        if(true){
            $base_url = (isset($_SERVER['HTTPS']) &&

                    $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
            
            // get default website root directory

            $tmpURL = dirname(__FILE__);

            // when use dirname(__FILE__) will return value like this "C:\xampp\htdocs\my_website",

            //convert value to http url use string replace,

            // replace any backslashes to slash in this case use chr value "92"

            $tmpURL = str_replace(chr(92), '/', $tmpURL);

            // now replace any same string in $tmpURL value to null or ''

            // and will return value like /localhost/my_website/ or just /my_website/

            $tmpURL = str_replace($_SERVER['DOCUMENT_ROOT'], '', $tmpURL);

            // delete any slash character in first and last of value

            $tmpURL = ltrim($tmpURL, '/');

            $tmpURL = rtrim($tmpURL, '/');


            // check again if we find any slash string in value then we can assume its local machine

            if (strpos($tmpURL, '/')) {

                // explode that value and take only first value

                $tmpURL = explode('/', $tmpURL);

                $tmpURL = $tmpURL[0];

            }

            // now last steps

            // assign protocol in first value

            if ($tmpURL !== $_SERVER['HTTP_HOST'])

                // if protocol its http then like this

                $base_url .= $_SERVER['HTTP_HOST'] . '/' . $tmpURL . '/';

            else

                // else if protocol is https

                $base_url .= $tmpURL . '/';

            // give return value
        }else
        {
            if(isset($_SERVER['HTTPS'])){
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            }
            else{
                $protocol = 'http';
            }
            $base_url= $protocol . "://" . $_SERVER['HTTP_HOST'] ."/";
        }

        unset($at);
        $base_url= str_replace("libraries","",$base_url);
		return $base_url;

	}
?>
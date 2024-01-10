<?php
$HOST_NAME = "http://localhost:8080/hamgorooh/";
$_SESSION["dblayer_query"] =null;
$_SESSION["dblayer_error"]=null;
if(isset($SUBJECT_INDEX))
{
    $GLOBALS['DB_SERVER'] = $HCD_DB_ARR[$SUBJECT_INDEX][0];
    $GLOBALS['DB_NAME'] = $HCD_DB_ARR[$SUBJECT_INDEX][1];
    $GLOBALS['DB_USER'] = $HCD_DB_ARR[$SUBJECT_INDEX][2];
    $GLOBALS['DB_PASS'] = $HCD_DB_ARR[$SUBJECT_INDEX][3];

}

//------------------------------ Function for security --------------------------
//-------------------------------------------------------------------------------

if (get_magic_quotes_gpc())
{
	function stripslashes_deep($value)
	{
		$value = is_array($value) ?
				array_map('stripslashes_deep', $value) :
				stripslashes($value);

		return $value;
	}

	$_POST = array_map('stripslashes_deep', $_POST);
	$_GET = array_map('stripslashes_deep', $_GET);
	$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

//------------------------------ Connect ----------------------------------------
//-------------------------------------------------------------------------------

    function Connect()
	{ 

        $db_host = $GLOBALS['DB_SERVER'];     // Database Host  
        $db_name= $GLOBALS['DB_NAME'];        // Database User  
        $db_user = $GLOBALS['DB_USER'];       // Database password
        $db_pass = $GLOBALS['DB_PASS'];       // Database Name
		
	    $GLOBALS['link'] = mysqli_connect($db_host,$db_user,$db_pass,$db_name); 
		
		if (mysqli_connect_errno())
	  	{
              $_SESSION["dblayer_error"] = "Failed to connect to MySQL : " . mysqli_connect_error();
			return false; 
	  	}
		else {
			mysqli_set_charset($GLOBALS['link'], "utf8");
			return true; 
		}
	}

//------------------------------ DisConnect -------------------------------------
//-------------------------------------------------------------------------------	

	function Disconnect()
	{
		mysqli_close($GLOBALS['link']);   
	}

//------------------------------ Insert ------------------------------------------
//--------------------------------------------------------------------------------	

function Insert($table,array $values)
{

    $insert = 'INSERT INTO '.$table;
    for($i = 0; $i < count($values); $i++)
    {
        if(is_string($values[$i])) {
            if($values[$i] != 'NULL')
            {
                $values[$i] = '"' . $values[$i] . '"';
            }
        }

    }
    $values = implode(',',$values);
    $insert .= ' VALUES ('.$values.')';
    $_SESSION["dblayer_query"]  = $insert;
    $ins = mysqli_query($GLOBALS['link'],$insert);
    if( $ins)
    {
        return mysqli_insert_id($GLOBALS['link']);
    }
    else
    {
        $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
        return null;
    }
}

//------------------------------ Insert Multi Rows----------------------------------
//----------------------------------------------------------------------------------

    function InsertMultiRows($table,$values)
    {
        $insert = 'INSERT INTO '.$table;

        $insert .= ' VALUES '.$values;   
        $_SESSION["dblayer_query"] = $insert;
        $ins = mysqli_query($GLOBALS['link'],$insert);       
        if($ins)
        {
            return true;
        }
        else
        {
            $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
            return null;
        }
    }


//------------------------------ Update --------------------------------------------
//----------------------------------------------------------------------------------	

    function Update($table, $SetValue, $WhereValue = '')
    {
      $update = 'UPDATE '.$table.' SET '.$SetValue ;
	  if ($WhereValue!='') 
	    $update.=' WHERE '.$WhereValue;
      $query = mysqli_query($GLOBALS['link'],$update);  
	  if($query)  
	  {  
		 return true;   
	  }  
	  else  
	  {  
          $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
	     return false;   
	  }     
    }
	
//------------------------------ Delete --------------------------------------------
//----------------------------------------------------------------------------------	

    function Delete($table, $WhereValue = '')
    {
      if($WhereValue=='')   
	  {  
		 $delete = 'DELETE '.$table;   
	  }  
	  else  
	  {  
		 $delete = 'DELETE FROM '.$table.' WHERE '.$WhereValue;   
	  }  
	  $del = mysqli_query($GLOBALS['link'],$delete);  
	  if($del)  
	  {  
		 return true;   
	  }  
	  else  
	  {  
         $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
	     return false;   
	  }   
    }

    //------------------------------ Delete By SQL -------------------------------------
    //----------------------------------------------------------------------------------

    function delete_by_sql($sql, $security_code)
    { 
        $del = mysqli_query($GLOBALS['link'],$sql);  
        if($del)  
        {  
            return true;   
        }  
        else  
        {  
            $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
            return false;   
        }   
    }
//------------------------------ Select --------------------------------------------
//----------------------------------------------------------------------------------	

	function Select($table, $rows = '*', $where = null, $filter = null)
    {
        $q = 'SELECT '.$rows.' FROM '.$table;  
        if($where != null)  
            $q .= ' WHERE '.$where;  
        if($filter != null)  
            $q .= ' '.$filter;  
        $query = mysqli_query($GLOBALS['link'],$q); 
        $_SESSION["dblayer_query"] = $q;

		if($query)
        {
            
            $rows = array();
            $row_data=array();
            while($row = mysqli_fetch_assoc($query))
            {
                foreach($row as $key => $value)
                {
                    $row_data[$key]=$value;
                }
                array_push($rows,$row_data);
                $row_data=null;
            }
            return $rows ; 
        }
        else
        {
            $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
            return null;
        }
    } 


//------------------------------ CountRows -----------------------------------------
//----------------------------------------------------------------------------------
    
	function CountRows($table, $rows = '*', $where = null, $filter = null)
    {
        $q = 'SELECT '.$rows.' FROM '.$table;  
        if($where != null)  
            $q .= ' WHERE '.$where;  
        if($filter != null)  
            $q .= ' '.$filter; 
        $query = mysqli_query($GLOBALS['link'],$q);  
        $_SESSION["dblayer_query"] = $q;

		if($query)  
        {
			$numResults = mysqli_num_rows($query); 
			return $numResults;  
        }  
        else  
        {
            $_SESSION["dblayer_error"] = mysqli_errno($GLOBALS['link']) . " : " . mysqli_error($GLOBALS['link']);
            return false;    
        }
    }
	
?>
<?php require_once '../includes/session.php';  ?>
<?php 
include_once '../core/config.php';
$SUBJECT_INDEX=4; //cooking
include_once '../core/dblayer_mysqli_hcd.php';
include_once '../libraries/phpfunction.php';
include_once '../libraries/jdf.php';
include_once '../libraries/sanitize_title.php';


Connect();

//Delete duplate items
$sql_query = "DELETE n1 FROM crawler_items n1, crawler_items n2 WHERE n1.id > n2.id AND n1.item_link = n2.item_link";
$del = delete_by_sql("{$sql_query}","142GJgkjkloiepqepopqwe[w");
if($del) { echo "Duplicates Deleted";}
if(isset($_SESSION["dblayer_error"])) echo $_SESSION["dblayer_error"];
Disconnect();


?>
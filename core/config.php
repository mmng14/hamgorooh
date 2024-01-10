<?php
$SUBFOLDER_NAME="/hamgorooh/";
$HOST_NAME = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $SUBFOLDER_NAME;
$RELATIVE_UPLOAD_FOLDER_PREFIX = "";


$DB_SERVER = "127.0.0.1";
$DB_NAME = "hamgoroohdb";
$DB_USER = "root";
$DB_PASS = "";

$NEWS_DB="hamgoroohdb_news";
$NEWS_SERVER="127.0.0.1";
$NEWS_USER="root";
$NEWS_PASS="";

//Database for storing statistics
$STATISTICS_DB="hamgoroohdb_statistics";
$STATISTICS_SERVER="127.0.0.1";
$STATISTICS_USER="root";
$STATISTICS_PASS="";

//Database for storing notifications
$NOTIFICATIONS_DB="hamgoroohdb_notifications";
$NOTIFICATIONS_SERVER="127.0.0.1";
$NOTIFICATIONS_USER="root";
$NOTIFICATIONS_PASS="";

//Database for storing messaging
$MESSAGING_DB="hamgoroohdb_messaging";
$MESSAGING_SERVER="127.0.0.1";
$MESSAGING_USER="root";
$MESSAGING_PASS="";



$UPLOAD_ARR = array();
$HCD_DB_ARR = array();
$HCG_DB_ARR = array();

//Subject Data Base
$HCD_DB_ARR[1]=array("127.0.0.1","hamgoroohdb_hcdsuccess","root","");
$HCD_DB_ARR[2]=array("127.0.0.1","hamgoroohdb_hcdautomobile","root","");
$HCD_DB_ARR[3]=array("127.0.0.1","hamgoroohdb_hcdscience","root","");
$HCD_DB_ARR[4]=array("127.0.0.1","hamgoroohdb_hcdcooking","root","");
$HCD_DB_ARR[5]=array("127.0.0.1","hamgoroohdb_hcd","root","");
$HCD_DB_ARR[6]=array("127.0.0.1","hamgoroohdb_hcd","root","");
$HCD_DB_ARR[7]=array("127.0.0.1","hamgoroohdb_hcd","root","");
$HCD_DB_ARR[8]=array("127.0.0.1","hamgoroohdb_hcdsport","root","");
$HCD_DB_ARR[9]=array("127.0.0.1","hamgoroohdb_hcdculture","root","");
$HCD_DB_ARR[10]=array("127.0.0.1","hamgoroohdb_hcdhealth","root","");
$HCD_DB_ARR[11]=array("127.0.0.1","hamgoroohdb_hcdfamily","root","");
$HCD_DB_ARR[12]=array("127.0.0.1","hamgoroohdb_hcdmode","root","");
$HCD_DB_ARR[13]=array("127.0.0.1","hamgoroohdb_hcdtravelling","root","");
$HCD_DB_ARR[14]=array("127.0.0.1","hamgoroohdb_hcdeconomy","root","");
$HCD_DB_ARR[15]=array("127.0.0.1","hamgoroohdb_hcdfun","root","");
$HCD_DB_ARR[16]=array("127.0.0.1","hamgoroohdb_news","root","");
$HCD_DB_ARR[17]=array("127.0.0.1","hamgoroohdb_hcdothers","root","");
$HCD_DB_ARR[18]=array("127.0.0.1","hamgoroohdb_hcdothers","root","");
$HCD_DB_ARR[19]=array("127.0.0.1","hamgoroohdb_hcdothers","root","");
$HCD_DB_ARR[20]=array("127.0.0.1","hamgoroohdb_hcdgeneralinfo","root","");
$HCD_DB_ARR[21]=array("127.0.0.1","hamgoroohdb_hcdit","root","");
$HCD_DB_ARR[22]=array("127.0.0.1","hamgoroohdb_hcdmysticism","root","");

//Category Custom DataBase
$HCG_DB_ARR[127]=array("127.0.0.1","hamgoroohdb_hcgothers","root","");

//Subjects Upload Folder
$UPLOAD_ARR[1]="success";
$UPLOAD_ARR[2]="automobile";
$UPLOAD_ARR[3]="science";
$UPLOAD_ARR[4]="cooking";
$UPLOAD_ARR[5]="";
$UPLOAD_ARR[6]="";
$UPLOAD_ARR[7]="";
$UPLOAD_ARR[8]="sport";
$UPLOAD_ARR[9]="culture";
$UPLOAD_ARR[10]="health";
$UPLOAD_ARR[11]="family";
$UPLOAD_ARR[12]="mode";
$UPLOAD_ARR[13]="travelling";
$UPLOAD_ARR[14]="economy";
$UPLOAD_ARR[15]="fun";
$UPLOAD_ARR[16]="news";
$UPLOAD_ARR[17]="others";
$UPLOAD_ARR[18]="others";
$UPLOAD_ARR[19]="others";
$UPLOAD_ARR[20]="publicinfo";
$UPLOAD_ARR[21]="it";
$UPLOAD_ARR[22]="mysticism";

//NOTIFICATION TYPES
$NOTIFICATION_TYPE_MEMBERSHIP_REQUEST=1;
$NOTIFICATION_TYPE_USER_POST=2;
$NOTIFICATION_TYPE_POST_COMMENT=3;




<?php
//------main DB Connection------
$dsn = "mysql:dbname=$DB_NAME;host=$DB_SERVER;charset=utf8";
$GLOBALS["db_pdo"] = new PDO($dsn, "$DB_USER", "$DB_PASS");
$database =  new NotORM($GLOBALS["db_pdo"]);
//-----------------------------

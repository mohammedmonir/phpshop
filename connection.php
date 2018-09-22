<?php
/* Connection Variables */
$data = "mysql:host=localhost;dbname=mohammed";

$user = "root";

$pw = "";

$option = array (

	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"

);
	
try {
	
	$db = new PDO($data, $user, $pw, $option);
	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}

catch (Exception $e) {
	
	echo "Sorry, Connection To Database Failed!" . $e->getMessage();
	
}
<?php
// connection into our mySQL database
// we will require this in all other files in order to access this
// login: wustl_inst and wustl_pass have all permisions
$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'news');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
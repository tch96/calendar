<?php
// Connect to the database , require this php file in other php file when you need to connect to database

$mysqli = new mysqli('localhost', 'php', 'php_pass', 'module3');
if($mysqli->connect_error) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>

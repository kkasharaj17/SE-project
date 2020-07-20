<?php
define('DB_HOST', 'localhost');
define('USER', 'kkasharaj17');
define('PASS', 'kk707raj');
define('DB', 'web18_kkasharaj17');

//create database connection
$conn = mysqli_connect(DB_HOST, USER, PASS, DB) or die("Opps some thing went wrong");

//check connection
if (!$conn) {
		$error = mysqli_connect_error();
		$errno = mysqli_connect_errno();
		print "$errno: $error\n";
		exit();
	} 
?>
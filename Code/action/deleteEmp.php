<?php
include_once('config.php');
if($_POST) {
	$username = mysqli_real_escape_string($conn, $_POST['delete_us']);
		$query = "DELETE FROM `web20_employee` WHERE `web20_employee`.`username` = '{$username}'";
		mysqli_query($conn, $query);
		
		$query = "DELETE FROM `web20_user` WHERE `web20_user`.`username` = '{$username}'";
		mysqli_query($conn, $query);
}
header ("Location: ../employee.php");
?>
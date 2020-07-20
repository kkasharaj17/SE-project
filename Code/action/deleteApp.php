<?php
include_once('config.php');

if($_POST) {
	$app_id = mysqli_real_escape_string($conn, $_POST['idd']);
		$query = "DELETE FROM `web20_appointment` WHERE `web20_appointment`.`app_id` = '{$app_id}'";
		mysqli_query($conn, $query);
}
header ("Location: ../secretary.php");
?>
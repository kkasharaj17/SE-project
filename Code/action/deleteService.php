<?php
include_once('config.php');

if($_POST) {
	if ($conn) {
		$idd = mysqli_real_escape_string($conn, $_POST['delete_id']);
		$query = "DELETE FROM `web20_services` WHERE `web20_services`.`id` = ?";

		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $query)) {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		} else {
			mysqli_stmt_bind_param($stmt, "i", $idd);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}
header ("Location: ../service.php");

?>
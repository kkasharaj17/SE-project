<?php
include_once('config.php');

if(isset($_GET['id']) && isset($_GET['client_id']) && isset($_GET['user'])) {
	if ($conn) {
		$id = mysqli_real_escape_string($conn, $_GET['id']);
		$client_id = mysqli_real_escape_string($conn, $_GET['client_id']);
		$user = mysqli_real_escape_string($conn, $_GET['user']);
		$query = "UPDATE `web20_client` SET `active` = ? WHERE `web20_client`.`permission` = 'client' AND `web20_client`.`client_id` = ? AND `web20_client`.`username` = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $query)) {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		} else {
			mysqli_stmt_bind_param($stmt, "sis", $id, $client_id, $user);
			mysqli_stmt_execute($stmt);
		}
		mysqli_stmt_close($stmt);
	}
	mysqli_close($conn);
}
header ("Location: ../admin_user.php");
?>
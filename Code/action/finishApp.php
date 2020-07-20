<?php
include_once('config.php');

if($_POST) {
	if ($conn) {
		$app_id = mysqli_real_escape_string($conn, $_POST['app_id']);
		$client = mysqli_real_escape_string($conn, $_POST['client']);
		$price = mysqli_real_escape_string($conn, $_POST['prc']);
		$points = $price;
		
		$query = "UPDATE `web20_appointment` SET `status` = '1' WHERE `web20_appointment`.`app_id` = '{$app_id}'";
		mysqli_query($conn, $query);
		
		$sql ="UPDATE `web20_client` SET `points` = `points`+'{$points}' WHERE `username` = '{$client}'";
		mysqli_query($conn, $sql);
		$qry ="INSERT INTO `web20_sales`(`sales_id`, `app_id`, `revenue`) VALUES (NULL,'{$app_id}', '{$price}')";
		mysqli_query($conn, $qry);
	}
	mysqli_close($conn);
}
header ("Location: ../admin.php");

?>
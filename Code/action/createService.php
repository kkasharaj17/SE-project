<?php
include_once('config.php');

if($_POST){
	$product = mysqli_real_escape_string($conn, $_POST['serviceName']);
	$category = mysqli_real_escape_string($conn, $_POST['serviceCategory']);
	$price = mysqli_real_escape_string($conn, $_POST['price']);
	$duration = mysqli_real_escape_string($conn, $_POST['duration']);
	
	if ($conn) {
					$query = "INSERT INTO `web20_services`(`service_name`, `service_category`, `price`, `duration`) VALUES (?, ?, ?, ?)";

					$stmt = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt, $query)) {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					} else {
						mysqli_stmt_bind_param($stmt, "ssdi", $product, $category, $price, $duration);
						mysqli_stmt_execute($stmt);
					}
					mysqli_stmt_close($stmt);
					mysqli_close($conn);
		header("Location: ../service.php");
	} else echo "Connection not made";
} else echo "everything failed";
?>
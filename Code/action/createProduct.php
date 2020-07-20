<?php
include_once('config.php');

if($_POST){
	$product = mysqli_real_escape_string($conn, $_POST['productName']);
	$code = mysqli_real_escape_string($conn, $_POST['code']);
	$brand = mysqli_real_escape_string($conn, $_POST['brand']);
	$category = mysqli_real_escape_string($conn, $_POST['category']);
	$quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
	$price = mysqli_real_escape_string($conn, $_POST['price']);
	$sold = mysqli_real_escape_string($conn, $_POST['sold']);
	$status = 1;
	
	if ($conn) {
		$type = explode('.', $_FILES['productImage']['name']);
		$type = $type[count($type)-1];
		$url = './img/products/'.$product.'_'.$code.'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
			if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['productImage']['tmp_name'], '.'.$url)) {		
					$query = "INSERT INTO `web20_product`(`product_name`, `product_code`, `product_image`, `brand`, `category`, `quantity`, `price`, `sold_price`, `status`) 
						VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)";

					$stmt = mysqli_stmt_init($conn);
					if(!mysqli_stmt_prepare($stmt, $query)) {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					} else {
						mysqli_stmt_bind_param($stmt, "sssssiddi", $product, $code, $url, $brand, $category, $quantity, $price, $sold, $status);
						mysqli_stmt_execute($stmt);
					}
					mysqli_stmt_close($stmt);
					mysqli_close($conn);
				} else echo "move_upload failed";
			} else echo "is up failed.";
		} else echo "in array failed";
		header("Location: ../product.php");
	} else echo "Connection not made";
} else echo "everything failed";
?>
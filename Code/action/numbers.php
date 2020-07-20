<?php
include_once('config.php');

	$sql= "SELECT * FROM `web20_product` WHERE `status` = 1 ORDER BY `product_id` ASC";
	$result = mysqli_query($conn, $sql);
	$row_products = mysqli_num_rows($result);
	
	$query = "SELECT * FROM `web20_client` WHERE `active` = '1'";
	$res = mysqli_query($conn, $query);
	$rows_users = mysqli_num_rows($res);
	
	$qry = "SELECT * FROM `web20_employee` WHERE `active` = '1'";
	$rest = mysqli_query($conn, $qry);
	$rows_employees = mysqli_num_rows($rest);
	
	$msq = "SELECT * FROM `web20_appointment` WHERE `emp_active` = '1' AND `client_active` = '1' AND `status` ='1'";
	$r = mysqli_query($conn, $msq);
	$rows_app = mysqli_num_rows($r);
?>
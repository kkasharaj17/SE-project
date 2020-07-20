<?php
include_once('config.php');

if($_POST){
	$name = mysqli_real_escape_string($conn, $_POST['empName']);
	$surname = mysqli_real_escape_string($conn, $_POST['empSurname']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$phone = mysqli_real_escape_string($conn, $_POST['phone']);
	$dob = mysqli_real_escape_string($conn, $_POST['dob']);
	$job = mysqli_real_escape_string($conn, $_POST['job']);
	$net = mysqli_real_escape_string($conn, $_POST['net']);
	if (strcasecmp($job, "secretary") == 0) $permision = "secretary";
	else if (strcasecmp($job, "accountant") == 0) $permision = "accountant";
	else $permision = "insider";
	$bruto = $net*1.112;
	
	if ($conn) {
		$type = explode('.', $_FILES['empPhoto']['name']);
		$type = $type[count($type)-1];
		$url = './img/employee/'.$name.'_'.$surname.'.'.$type;
		if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {	
				if(move_uploaded_file($_FILES['empPhoto']['tmp_name'], '.'.$url)) {		
					$query = "INSERT INTO `web20_employee`(`username`, `name`, `surname`, `email`, `photo`, `phone_no`, `dob`, `netto`, `bruto`, `job`) 
					VALUES (?,?,?,?,?,?,?,?,?,?)";
					$query = "INSERT INTO `web20_employee` (`permission`, `emp_id`, `username`, `name`, `surname`, `email`, `photo`, `phone_no`, `dob`, `netto`, `bruto`, `job`, `created`, `active`) 
						VALUES ('{$permision}', NULL, '{$username}', '{$name}', '{$surname}', '{$email}', '{$url}', '{$phone}', '{$dob}', '{$net}', '{$bruto}', '{$job}', CURRENT_TIMESTAMP, '1')";
					$result1 = mysqli_query($conn, $query) or trigger_error("Query Failed! SQL: $query - Error: ".mysqli_error($conn), E_USER_ERROR);
					$sql = "INSERT INTO `web20_user` (`user_id`, `username`, `password`, `permission`) VALUES (NULL, '{$username}', 'User12345', '{$permision}')";
					$result2 = mysqli_query($conn, $sql) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
				} else echo "move_upload failed";
		} else echo "in array failed";
		header("Location: ../employee.php");
	} else echo "Connection not made";
	mysqli_close($conn);
} else echo "everything failed";
?>
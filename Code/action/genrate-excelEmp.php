<?php
session_start();
if($_SESSION['level']=='admin' || $_SESSION['level']=='accountant'){
include('config.php');
?>
    <table border="1">
    <thead>
    
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Date of Birth</th>
            <th>Joining Date</th>
            <th>Nett Salary</th>
            <th>Employee Social & Health Insurance </th>
            <th>Employer Social & Health Insurance </th>
            <th>Bruto Salary</th>
            <th>To be paid</th>
        </tr>
    </thead>
<?php
// File name
$filename="Employees Payroll-".date("Y.m.d");
// Fetching data from data base
	$sql = "SELECT * FROM `web20_employee`";
	$result = mysqli_query($conn, $sql);
$cnt=1;	$totneto=0; $totyee=0; $totyer=0; $totbruto=0; $total=0;

if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) { 
	if ($row['active'] == 1) {
?>
		<tr>
				<td> <?php echo $cnt;  ?> </td>
				<td> <?php echo $row['name']; ?> </td>
				<td> <?php echo $row['surname']; ?> </td>
				<td> <?php echo $row['job']; ?> </td>
				<td> <?php echo $row['email']; ?> </td>
				<td> <?php echo $row['phone_no']; ?> </td>
				<td> <?php echo $row['dob']; ?> </td>
				<td> <?php echo $row['created']; ?> </td>
				<?php $sal=$row['bruto']; $yee=$sal*0.112; $yer=$sal*0.167; $net=$row['netto']; $tot=$sal+$yer;
				$totbruto += $sal; $totyee += $yee; $totyer += $yer; $totneto += $net; $total += ($sal+$yer);
				?>
				<td> $<?php echo $row['netto']; ?> </td>
				<td> $<?php echo $yee; ?> </td>
				<td> $<?php echo $yer; ?> </td>
				<td> $<?php echo $row['bruto']; ?> </td>
				<td> $<?php echo $tot; ?> </td>
		</tr>
<?php 
$cnt++;
} } ?>
		<tr>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> </td>
				<td> <strong> TOTAL </strong> </td>
				<td> <strong> $<?php echo $totneto; ?> </strong> </td>
				<td> <strong> $<?php echo $totyee; ?> </strong> </td>
				<td> <strong> $<?php echo $totyer; ?> </strong> </td>
				<td> <strong> $<?php echo $totbruto; ?> </strong> </td>
				<td> <strong> $<?php echo $total; ?> </strong> </td>
		</tr>
 <?php } ?>
         
    </table>
<?php 
	// Genrating Execel  filess
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$filename."-Report.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
} else {
	header("Location: ../login.php");
}
?>

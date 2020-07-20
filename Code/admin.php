<?php
session_start();
if($_SESSION['level']=='admin'){
include_once('config.php');
include_once('action/numbers.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Admin Dashboard </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	
</head>
<body style="background-color: lightgrey;">

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="text-white navbar-brand"> <?php echo $_SESSION['user']; ?>'s Dashboard </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="admin.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="calendar.php">App Calendar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="employee.php">Employees</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_user.php">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="product.php">Inventory</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Statements</a>
          </li>
        </ul>
		<ul class="nav navbar-nav navbar-right">
			<a type="button" class="btn btn-light" href="logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
		</ul>
      </div>
    </nav>
	
<div class="card" style="margin: 100px 100px 0px 100px; padding: 20px;">
	<div class="row row-cols-1 row-cols-md-4">
	  <div class="col mb-4">
		<div class="card text-white bg-success" style="height: 220px;">
		  <div class="card-body">
			<table> <tr> <th style="width: 50%;"> <center> <h1> <?php echo $row_products; ?> </h1> </center> </th> <th style="width: auto;"> <i class="fas fa-boxes fa-7x"></i> </th> </table>
			<br> 
			<strong> <a href="product.php" class="text-white no-underline"> Total Products in Inventory <i class="far fa-arrow-alt-circle-right"></i> </a></strong>
		  </div>
		</div>
	  </div>
	  <div class="col mb-4">
		<div class="card text-white bg-warning" style="height: 220px;">
		  <div class="card-body">
			<table> <tr> <th style="width: 50%;"> <center> <h1> <?php echo $rows_users; ?> <br>  </h1> </center> </th> <th style="width: auto;"> <i class="fas fa-users fa-7x"></i> </th> </table>
			<br> 
			<strong> <a href="admin_user.php" class="text-white no-underline"> Number of Active Users <i class="far fa-arrow-alt-circle-right"></i> </a></strong>
		  </div>
		</div>
	  </div>
	  <div class="col mb-4">
		<div class="card text-white bg-info" style="height: 220px;">
		  <div class="card-body">
			<table> <tr> <th style="width: 50%;"> <center> <h1> <?php echo $rows_employees; ?> <br>  </h1> </center> </th> <th style="width: auto;"> <i class="fas fa-users-cog fa-7x"></i> </th> </table>
			<br> 
			<strong> <a href="employee.php" class="text-white no-underline"> Number of Employees <i class="far fa-arrow-alt-circle-right"></i> </a></strong>
		  </div>
		</div>
	  </div>
	  <div class="col mb-4">
		<div class="card text-white bg-danger" style="height: 220px;">
		  <div class="card-body">
			<table> <tr> <th style="width: 50%;"> <center> <h1> <?php echo $rows_app; ?> <br>  </h1> </center> </th> <th style="width: auto;"> <i class="fas fa-calendar-alt fa-7x"></i> </th> </table>
			<br> 
			<strong> <a href="#" class="text-white no-underline"> Number of Completed Appointments <i class="far fa-arrow-alt-circle-right"></i> </a></strong>
		  </div>
		</div>
	  </div>
	</div>
</div>
	
	<div class="card" style="margin: 20px 100px 0px 100px; padding: 20px;">
			  <div class="card-header">
			<div class="float-center"> <strong> Incoming Appoinments </strong></div>
			  </div>
			  <div class="card-body">
			  <div class="table-responsive">		
			<table id="schedule" class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Client Username </th>
				  <th> Appointmented Service </th>
				  <th> Appointment date </th>
				  <th> Appointment time </th>
				  <th> Duration </th>
				  <th> Price </th>
				  <th> Vat </th>
				  <th> Total </th>
				  <th> Accept </th>
				  <th> Delete </th>
				</tr>
			  </thead>
			  <tbody>
		<?php $conn2=mysqli_connect(DB_HOST,USER,PASS,DB);
			$qry = "SELECT * FROM `web20_appointment` WHERE `emp_active` = '0' AND `client_active` = '1' AND `status` = '0'";
			$result = mysqli_query($conn2, $qry);
			if (!mysqli_num_rows($result) == 0) {
			while($row2 = mysqli_fetch_assoc($result)) { ?>
					<tr> <td> <?php echo $row2['username']; ?> </td>
							<td> <?php echo $row2['service_name']; ?> </td>
							<td> <?php echo $row2['date']; ?> </td>
							<td> <?php echo $row2['app_time']; ?> </td>
							<td> <?php echo $row2['duration']; ?> </td>
							<td> <?php echo $row2['price']; ?> </td>
							<td> <?php echo $row2['vat']; ?> </td>
							<td> <?php echo $row2['total']; ?> </td>
							<td> 
				<form action="action/acceptApp.php" method="POST">
					<input type="hidden" id="idd" name="idd" value="<?php echo $row2['app_id']; ?>">
					<button type="submit" class="btn btn-success"> <i class="fas fa-calendar-check"></i> </button> </td>
				</form>
				<form action="action/deleteApp.php" method="POST">
					<input type="hidden" id="idd" name="idd" value="<?php echo $row2['app_id']; ?>">
							<td> <button class="btn btn-warning"> <i class="fas fa-calendar-check"></i> </button> </td>
				</form>
			<?php	}
				} else echo "<tr> <td style='width: auto;'> No Pending Appointments yet... </td> </tr>"; ?>
			  </tbody>
			</table>
			</div>
			</div>
			</div>
		  
	<div class="card" style="margin: 20px 100px 0px 100px; padding: 20px;">
			  <div class="card-header">
			<div class="float-center"> <strong> <?php echo date("d/m/Y"); ?>'s Appoinments </strong></div>
			  </div>
			  <div class="card-body">
			  <div class="table-responsive">		
			<table id="schedule" class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Appointment time </th>
				  <th> Client Username </th>
				  <th> Appointmented Service </th>
				  <th> Duration </th>
				  <th> Price </th>
				  <th> Vat </th>
				  <th> Total </th>
				  <th> Complete </th>
				  <th> Report </th>
				</tr>
			  </thead>
			  <tbody>
		<?php $conn2=mysqli_connect(DB_HOST,USER,PASS,DB); $date=date("Y-m-d");
			$qry = "SELECT * FROM `web20_appointment` WHERE `emp_active` = '1' AND `date` = '{$date}' AND `client_active` = '1' AND `status` = '0'";
			$result = mysqli_query($conn2, $qry);
			if (!mysqli_num_rows($result) == 0) {
			while($row = mysqli_fetch_assoc($result)) { $id = $row['app_id'];?>
					<tr> 
							<td> <span id="time<?php echo $row['app_id']; ?>"> <?php echo $row['app_time']; ?> </span></td>
							<td> <span id="client_id<?php echo $row['app_id']; ?>"> <?php echo $row['username']; ?> </span></td>
							<td> <span id="service<?php echo $row['app_id']; ?>"> <?php echo $row['service_name']; ?> </span></td>
							<td> <span id="duration<?php echo $row['app_id']; ?>"> <?php echo $row['duration']; ?> </span></td>
							<td> <span id="price<?php echo $row['app_id']; ?>"> <?php echo $row['price']; ?></span> </td>
							<td> <span id="vat<?php echo $row['app_id']; ?>"><?php echo $row['vat']; ?> </span></td>
							<td> <span id="total<?php echo $row['app_id']; ?>"> <?php echo $row['total']; ?> </span></td>
							<td> <button class="btn btn-success compBtn" value="<?php echo $row['app_id']; ?>"> <i class="fas fa-check-double"></i> Complete </button> </td>
							<td> <a type="button" class="btn btn-primary" href="action/bill_pdf.php?id=<?=$id?>"> <i class="fas fa-file-invoice-dollar"></i> Bill </a> </td>
			<?php	}
				} else echo "<tr> <td style='width: auto;'> No Scheduled Appointments... </td> </tr>"; ?>
			  </tbody>
			</table>
			</div>
			</div>
	</div>
	
	<div class="card rounded-0 text-white" style="margin: 0px 100px 0px 100px; padding: 20px;">
		<a type="button" class="btn btn-primary btn-lg btn-block" href="employee.php"> List of All Employees </a>
		<a type="button" class="btn btn-danger btn-lg btn-block" href="admin_user.php"> List of All Users </a>
		<a type="button" class="btn btn-success btn-lg btn-block" href="product.php"> List of All Products </a>
		<a type="button" class="btn btn-warning btn-lg btn-block" href="#"> Financial Statements </a>
	</div>
	
	<div class="card rounded-bottom" style="margin: 0px 100px 0px 100px; padding: 10px;">
	</div>
	
	<script>
		$(document).ready(function() {
			$('#schedule').DataTable();
		} );
	</script>
	
	<script>
		$(document).ready(function(){		
			$(document).on('click', '.compBtn', function(){
				var id=$(this).val();
				var client=$('#client_id'+id).text();
				var service=$('#service'+id).text();
				var time=$('#time'+id).text();
				var pri=$('#price'+id).text();
				var vat=$('#vat'+id).text();
				var tot=$('#total'+id).text();
		 
				$('#finishModal').modal('show');
				$('#app_id').val(id);
				$('#client').val(client);
				$('#service').val(service);
				$('#time').val(time);
				$('#price').val(pri);
				$('#vat').val(vat);
				$('#total').val(tot);
			});
		});
	</script>
	
</body>
</html>
<?php
} else {
	header("Location: login.php");
}
?>
<?php
session_start();
if($_SESSION['level']=='secretary'){
	include_once('conf.php');
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Secretary Dashboard </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
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
            <a class="nav-link" href="ïnsider.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="calendar.php">Calendar</a>
          </li>
        </ul>
		<ul class="nav navbar-nav navbar-right">
			<a type="button" class="btn btn-light" href="logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
		</ul>
      </div>
    </nav>
	
	
	<div class="container-fluid" style="margin-top: 5%;">
	  <div class="row">
		<div class="col">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page"> <i class="fas fa-address-card"></i> Home</li>
					<li class="breadcrumb-item"><a href="#">Edit Profile</a></li>
				  </ol>
		  <div class="row">
			<div class="col-sm-3">
			<div class="card" style="margin: 10px; border-radius: 5%;">
			  <div class="card-header">
			<div class="float-center"> 
			  <?php $conn1=mysqli_connect(DB_HOST,USER,PASS,DB);
			$sql1 = "SELECT * FROM `web20_employee` WHERE `username` = '{$_SESSION['user']}'";
			$res = mysqli_query($conn1, $sql1); 
			$row = mysqli_fetch_assoc($res); ?>
			<img src='<?php echo $row['photo']; ?>' height='190' width='170' style="border-radius: 20%; display: block; margin-left: auto; margin-right: auto;">
			</div>
			</div>
			<div class="card-body">
				<?php 
			$conn3=mysqli_connect(DB_HOST,USER,PASS,DB);
			$sql2 = "SELECT * FROM `web20_employee` WHERE `username` = '{$_SESSION['user']}'";
			$res2 = mysqli_query($conn3, $sql2);	
			if (!mysqli_num_rows($res2) == 0) {
			while($row1 = mysqli_fetch_assoc($res2)) { ?>
			<p style="margin-left: 20%;">
				<i class='fa fa-user-circle'></i> <span style="margin-left: 5%;"> <?php echo $row1['name']; echo " "; echo $row1['surname']; ?> </span> <br> <br>
				<i class="fas fa-briefcase"></i> <span style="margin-left: 5%;"> <?php echo $row1['job']; ?> </span> <br> <br>
				<i class='fa fa-envelope-square'></i> <span style="margin-left: 5%;"> <?php echo $row1['email']; ?> </span> <br> <br>
				<i class='fa fa-phone'></i> <span style="margin-left: 5%;"> <?php echo $row1['phone_no']; ?> </span> <br> <br>
				<i class='fa fa-birthday-cake'></i> <span style="margin-left: 5%;"> <?php echo $row1['dob']; ?> </span> <br> <br>
				<i class="fas fa-money-check-alt"></i> <span style="margin-left: 5%;"> $<?php echo $row1['netto']; ?> </span> 
			</p>	
			<?php	}
				} else echo "ERROR"; ?>
			</div>
			</div>
			</div>
			<div class="col-sm-9">
			<div class="card" style="margin: 10px;">
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
		  
			<div class="card" style="margin: 10px;">
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
		  </div>
		</div>
	  </div>
	</div>
	</div>
	
	<div class="modal fade" tabindex="-1" role="dialog" id="finishModal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title"> <i class="fas fa-check-double"></i> Finished Appointment </h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<p> Did this appoinment really finish?</p>
		  </div>
		<form action="action/finishApp.php" method="POST">
		<input type="hidden" class="form-control" id="app_id" name="app_id">
		<input type="hidden" class="form-control" id="prc" name="prc">
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="time" name="time" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="client" name="client" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="service" name="service" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="duration" name="duration" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="price" name="price" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="vat" name="vat" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="total" name="total" required disabled> <br>
		  </div>
		  <div class="modal-footer removeProductFooter">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times-circle"></i> Close </button>
			<button type="submit" class="btn btn-success" id="yesBtn" data-loading-text="Loading..." > <i class="far fa-thumbs-up"></i> YES </button>
		  </div>
		</form>
		</div>
	  </div>
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
				var dur=$('#duration'+id).text();
		 
				$('#finishModal').modal('show');
				$('#app_id').val(id);
				$('#client').val(client);
				$('#service').val(service);
				$('#time').val(time);
				$('#price').val(pri);
				$('#vat').val(vat);
				$('#total').val(tot);
				$('#prc').val(pri);
				$('#duration').val(dur);
			});
		});
	</script>
</body>
</html>
<?php
} else {
	header("Location: login.php");
}

<?php
session_start();
if($_SESSION['level']=='client'){
	$row = array();
	include_once('config.php');
	$sql = "SELECT * FROM `web20_client` WHERE 'username' = '{$_SESSION['user']}'";
	$res = mysqli_query($conn, $sql);
	if (mysqli_num_rows($res) == 1) {
		$row = mysqli_fetch_assoc($res);
	} else echo "There was a problem, couldn't load your credentials!";
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Client Dashboard </title>
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
            <a class="nav-link" href="client.php">Home <span class="sr-only">(current)</span></a>
          </li>
        </ul>
		<ul class="nav navbar-nav navbar-right">
			<a type="button" class="btn btn-light" href="logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
		</ul>
      </div>
    </nav>
	
	<div class="card"style="margin: 50px;">
	  <div class="card-header">
		<strong> WELCOME <?php echo $_SESSION['user']; ?> </strong> 
	  </div>
	  
		  <div class="row">
		  <div class="col-sm-9">
	  <div class="card-body">
			<div class="card-header">
				<strong> <h1> My Appointments <i class="far fa-grin-hearts"></i> </h1> </strong> <br><br>
				<a type="button" class="btn btn-primary btn-lg btn-block" href="action/createApp.php"> Create an Appointment </a>
			  <br> <br>
			  </div>
			  <div class="card-body">
			  <div class="table-responsive">		
			<table id="app" class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Appointmented Service </th>
				  <th> Appointment date </th>
				  <th> Appointment time </th>
				  <th> Duration </th>
				  <th> Price </th>
				  <th> Vat </th>
				  <th> Total </th>
				  <th> Status </th>
				</tr>
			  </thead>
			  <tbody>
		<?php 
			$query = "SELECT * FROM `web20_appointment` WHERE `username` = '{$_SESSION['user']}'";
			$result = mysqli_query($conn, $query);
			while($row = mysqli_fetch_assoc($result)) { ?>
					<tr> <td> <?php echo $row['service_name']; ?> </td>
							   <td> <?php echo $row['date']; ?> </td>
							   <td> <?php echo $row['app_time']; ?> </td>
							   <td> <?php echo $row['duration']; ?> </td>
							   <td> <?php echo $row['price']; ?> </td>
							   <td> <?php echo $row['vat']; ?> </td>
							   <td> <?php echo $row['total']; ?> </td>
			<?php if($row['client_active'] == 1 && $row['emp_active'] == 0 && $row['status'] == 0) { ?>
							   <td> <button class="btn btn-secondary" disabled> Pending </button> </td> </tr>
			<?php	} else if ($row['client_active'] == 1 && $row['emp_active'] == 1 && $row['status'] == 0) { ?>
							   <td> <button type="button" class="btn btn-warning"> To be completed </button> 
		<!--		<form action="action/rejectApp.php" method="POST">
					<input type="hidden" id="idd" name="idd" value="<?php echo $row['app_id']; ?>">
					<button class="btn btn-warning"> <i class="fas fa-calendar-check"></i> </button> 
				</form> -->
							   </td> </tr>
			<?php	} else if ($row['client_active'] == 1 && $row['emp_active'] == 1 && $row['status'] == 1) { ?>
							   <td> <button type="button" class="btn btn-success"> Completed </button> </td> </tr>
			<?php	}
			}
		?>
			  </tbody>
			</table>
	  </div>
	</div>
	</div>
	</div>
	<div class="col-sm-3">
			<div class="card" style="margin: 10px; border-radius: 5%;">
			  <div class="card-header">
			<div class="float-center"> 
			  <?php $conn1=mysqli_connect(DB_HOST,USER,PASS,DB);
			$sql1 = "SELECT * FROM `web20_client` WHERE `username` = '{$_SESSION['user']}'";
			$res = mysqli_query($conn1, $sql1); 
			$row = mysqli_fetch_assoc($res); ?>
			<img src='<?php echo $row['photo']; ?>' height='190' width='80%' style="border-radius: 20%; display: block; margin-left: auto; margin-right: auto;">
			</div>
			</div>
			<div class="card-body">
				<?php 
			$conn3=mysqli_connect(DB_HOST,USER,PASS,DB);
			$sql2 = "SELECT * FROM `web20_client` WHERE `username` = '{$_SESSION['user']}'";
			$res2 = mysqli_query($conn3, $sql2);	
			if (!mysqli_num_rows($res2) == 0) {
			while($row1 = mysqli_fetch_assoc($res2)) { 
			if ($row1['active']==1) {?>
			<p style="margin-left: 20%;">
				<i class='fa fa-user-circle'></i> <span class="text-capitalize" style="margin-left: 5%;"> <?php echo $row1['name']; echo " "; echo $row1['surname']; ?> </span> <br> <br>
				<i class='fa fa-envelope-square'></i> <span style="margin-left: 5%;"> <?php echo $row1['email']; ?> </span> <br> <br>
				<i class='fa fa-birthday-cake'></i> <span style="margin-left: 5%;"> <?php echo $row1['dob']; ?> </span> <br> <br>
				<i class="fas fa-award"></i> <span style="margin-left: 5%;"> <?php echo $row1['points']; ?> points </span> 
			</p>	
			<?php	} }
				} else echo "ERROR"; ?>
			</div>
			</div>
			</div>
		</div>
	
	<script>
		$(document).ready(function() {
			$('#app').DataTable();
		} );
	</script>
	
</body>
</html>
<?php
} else {
	header("Location: login.php");
}

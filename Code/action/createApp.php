<?php 
session_start();
if ($_SESSION['level']=='client') {
include_once('config.php');
$err = true;
if(isset($_POST['submit'])) {
		$clnt_id = $_SESSION['id'];
		$user = $_SESSION['user'];
		$serv_id = mysqli_real_escape_string($conn, $_POST['service_id']);
		$serv_name = mysqli_real_escape_string($conn, $_POST['ser_name']);
		$duration = mysqli_real_escape_string($conn, $_POST['ser_dur']);
		$pric = mysqli_real_escape_string($conn, $_POST['ser_price']);
		$VAT=floatval($pric)*0.2; $total=floatval($pric)*1.2;
		$app_date = mysqli_real_escape_string($conn, $_POST['date']);
		$app_time = mysqli_real_escape_string($conn, $_POST['time']);
		if (!empty($_POST['mess'])) $mess = mysqli_real_escape_string($conn, $_POST['mess']);
			else $mess = "No message";
		if ($conn) {
		$query = "INSERT INTO `web20_appointment` (`app_id`, `client_id`, `username`, `service_id`, `service_name`, `created`, `price`, `vat`, `total`, `emp_active`, `client_active`, `status`, `date`, `app_time`, `points`, `mess`, `duration`) VALUES (NULL, '{$clnt_id}', '{$user}', '{$serv_id}', '{$serv_name}', CURRENT_TIMESTAMP, '30', '6', '36', '0', '1', '0', '{$app_date}', '{$app_time}', NULL, '{$mess}', '{$duration}');";
		$result = mysqli_query($conn, $query);
		$msg = "Delivered Successfully! ";
		$err = false;
		} else echo "problem conn";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Booking </title>
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
      <a class="text-white navbar-brand"> <?php echo $_SESSION['user']; ?>: Create Appointment </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="../client.php">Home </a>
          </li>
        </ul>
		<ul class="nav navbar-nav navbar-right">
			<a type="button" class="btn btn-light" href="../logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
		</ul>
      </div>
    </nav>
	
	<nav aria-label="breadcrumb" style="margin-top: 5%;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="../client.php">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Create Appointment</li>
	  </ol>
	</nav>

<?php if($err==false) { ?>
	<div class="alert alert-success" role="alert" style="margin: 50px;">
	  <center> <h4 class="alert-heading"> <?php echo $msg; ?> </h4> </center>
	</div>
<?php } ?>

	  
	  <div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne">
      <a href="#" data-toggle="collapse" data-parent="#accordionExample" aria-expanded="true" aria-controls="collapseOne" class="text-decoration-none">
          Choose the service you want:
	  </a>
    </div>
	<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
			<div class="table-responsive">
			<table class="table table-hover text-justify" id="ser_table" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Service Category </th>
				  <th> Service Description </th>
				  <th> Duration </th>
				  <th> Price </th>
				  <th> Select </th>
				</tr>
			  </thead>
			  <tbody>
			  <tr>
		<?php $sql = "SELECT * FROM `web20_services`";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) { 
		while($row = mysqli_fetch_assoc($result)) { ?>
		<tr>
					  <td> <span id="category<?php echo $row['id']; ?>"><?php echo $row['service_category']; ?></span> </td>
					  <td> <span id="service<?php echo $row['id']; ?>"><?php echo $row['service_name']; ?> </span></td>
					  <td> <span id="duration<?php echo $row['id']; ?>"><?php echo $row['duration']; ?></span> min</td>
					  <td> $<span id="price<?php echo $row['id']; ?>"><?php echo $row['price']; ?> </span></td> 
					  <td> <button class="btn btn-success btn-block text-center selBtn" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne" value="<?php echo $row['id']; ?>">
						Select
					  </button> </td> 
					  </tr>
	<?php } } ?>
			  </tr>
			  </tbody>
			</table>
			</div> 
	  </div> 
	</div>
	</div>
	
		<div class="card">
    <div class="card-header" id="headingTwo">
		<a href="#" class="text-decoration-none"> Select Appointment Info: </a>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
      <div class="card-body">
          <form action="<?=$_SERVER['PHP_SELF'];?>" method="post">
		  <input class="form-control" id="service_id" name="service_id" type="hidden">
		  <input class="form-control" id="ser_dur" name="ser_dur" type="hidden">
		  <input class="form-control" id="ser_name" name="ser_name" type="hidden">
			  <input class="form-control" id="ser_price" name="ser_price" type="hidden">
			<div class="table-responsive">		
			<table class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-dark">
				<tr>
				  <th> Appointment Service </th>
				  <th> Appointment Price (without vat) </th>
				  <th> Appointment Date </th>
				  <th> Appointment Time </th>
				  <th> Message </th>
				</tr>
			  </thead>
			  <tbody>
			  <tr>
			    <td> <input class="form-control" id="s_name" name="s_name" type="text" disabled> </td> 
			    <td> 
			  <input class="form-control" id="s_price" name="s_price" type="text" disabled>
			  </td>
				<td>
					<input class="form-control" id="date" name="date" placeholder="YYYY-MM-DD" type="date">
				</td>
				<td>
					<input class="form-control" id="time" name="time" type="time">
				</td>
				<td>
				<input type="text" class="form-control" id="mess" name="mess" autocomplete="off">
				</td>
			  </tr>
			  </tbody>
			</table><br><div class="float-right">
				<button type="submit" class="btn btn-success" name="submit"> <i class="fas fa-paper-plane"></i> Send </button>
			</div>
			</div>
      </div>
	<br>
		</form>
    </div>
  </div>
	</div>

	<script>
		$(document).ready(function() {
			$('#ser_table').DataTable();
		} );
	</script>

<script>
		$(document).ready(function(){		
			$(document).on('click', '.selBtn', function(){
				var id=$(this).val();
				var name=$('#service'+id).text();
				var dur=$('#duration'+id).text();
				var prc=$('#price'+id).text();
		 
				$('#service_id').val(id);
				$('#ser_name').val(name);
				$('#s_name').val(name);
				$('#ser_dur').val(dur);
				$('#s_price').val(prc);
				$('#ser_price').val(prc);
			});
		});
	</script>

</body>
</html>
<?php
} else {
	header("Location: ../login.php");
}
?>
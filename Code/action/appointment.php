<?php 
session_start();
if($_SESSION['level']=='client'){
include_once('config.php');
	$err = true;
	if(isset($_POST['submit'])) {
		$user = $_SESSION['user'];
		$app_id = mysqli_real_escape_string($conn, $_GET['id']);
		$app_time = mysqli_real_escape_string($conn, $_POST['app_time']);
		if (!empty($_POST['mess'])) $mess = mysqli_real_escape_string($conn, $_POST['mess']);
			else $mess = 'No message';
		
		if ($conn) {
		$query = "UPDATE `web20_appointment` SET `app_time` = '{$app_time}', `mess` = '{$mess}', `emp_active`= '0', `client_active = '1' WHERE `web20_appointment`.`app_id` = '{$app_id}'";
		mysqli_query($conn, $query);
		$msg = "Answer Delivered Successfully!";
		$err = false;
		} else echo "problem conn";
	}	


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Answer </title>
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
      <a class="text-white navbar-brand"> <?php echo $_SESSION['user']; ?>: Answering </a>
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
			<a type="button" class="btn btn-light" href="logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
		</ul>
      </div>
    </nav>
	
	<nav aria-label="breadcrumb" style="margin-top: 60px;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="../client.php">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Answer to Appointment</li>
	  </ol>
	</nav>
	
<?php if($err==false) { ?>
	<div class="alert alert-success" role="alert" style="margin: 50px;">
	  <center> <h4 class="alert-heading"> <?php echo $msg; ?> </h4> </center>
	</div>
<?php } ?>

	<div class="card" style="margin: 50px;">
	  <div class="card-header">
		<strong> Answer </strong> 
	  </div>
	  <div class="card-body">
		<br> <br>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<div class="table-responsive">		
			<table id="user_table" class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Appointment Time </th>
				  <th> Message </th>
				</tr>
			  </thead>
			  <tbody>
			  <tr>
				<td>
				<input type="text" class="form-control" id="app_time" name="app_time" autocomplete="off" required>
				</td>
				<td>
				<input type="textarea" class="form-control" id="mess" name="mess" autocomplete="off">
				</td>
			  </tr>
			  </tbody>
			</table>
			</div>
			<div class="float-right">
				<button type="submit" class="btn btn-success" name="submit"> <i class="fas fa-paper-plane"></i> Send </button>
			</div>
		</form>
	  </div>
	</div>
	
</body>
</html>
<?php } ?>
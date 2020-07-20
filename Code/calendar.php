<?php
session_start();
if($_SESSION['level']=='admin' || $_SESSION['level']=='secretary'){
include_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Inventory </title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

	
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="admin.php">Home </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="calendar.php">Calendar <span class="sr-only">(current)</span></a>
          </li>
    </nav>
	<br>
	<nav aria-label="breadcrumb" style="margin-top: 60px;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="admin.php">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Booking Calendar</li>
	  </ol>
	</nav>
	
	<div class="card" style="margin: 60px;">
	  <div class="card-header">
		Booking Calendar
	  </div>
	  <div class="card-body">
			
<?php include_once('booking/index.php'); ?>
	  </div>
	</div>

</body>
</html>

<?php
} else {
	header("Location: login.php");
}
?>
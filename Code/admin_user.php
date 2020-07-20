<?php
session_start();
if($_SESSION['level']=='admin'){
include_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Users List </title>
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
      <a class="text-white navbar-brand"> Admin Dashboard </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="admin.php">Home </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="employee.php">Employees</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="admin_user.php">Users <span class="sr-only">(current)</span></a>
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
	<br>
	<nav aria-label="breadcrumb" style="margin-top: 60px;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="admin.php">Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Users</li>
	  </ol>
	</nav>
	
	<div class="card" style="margin: 50px;">
	  <div class="card-header">
		<strong> USERS TABLE </strong> 
	  </div>
	  <div class="card-body">
		<br> <br>
		<div class="table-responsive">		
			<table id="user_table" class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Photo </th>
				  <th> Username </th>
				  <th> Name </th>
				  <th> Surname </th>
				  <th> E-mail </th>
				  <th> Date of Birth </th>
				  <th> Points </th>
				  <th> User since </th>
				  <th> Status </th>
				  <th> De-Activate User </th>
				</tr>
			  </thead>
			  <tbody>
<?php 
	$sql = "SELECT * FROM `web20_client`";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) { ?>
			<tr>
				<td> <img src='<?php echo $row['photo']; ?>' height='90' width='70'> </td>
				<td id="username"> <?php echo $row['username']; ?> </td>
				<td id="name"> <?php echo $row['name']; ?> </td>
				<td> <?php echo $row['surname']; ?> </td>
				<td> <?php echo $row['email']; ?> </td>
				<td> <?php echo $row['dob']; ?> </td>
				<td> <?php echo $row['points']; ?> </td>
				<td> <?php echo $row['created']; ?> </td>
				<td>
				<?php if ($row['active']==1) { ?>
					<button class="btn btn-success" disabled> Active </button>
				<?php } else { ?>
					<button class="btn btn-secondary" disabled> Not Active </button>
				<?php } ?>
				</td>
				<td>
				<?php if ($row['active']==1) {
					echo "<a class='btn btn-danger' href='action/deact_client.php?client_id={$row['client_id']}&id=0&user={$row['username']}'> Deactivate </a>";
				} else {
					echo "<a class='btn btn-success' href='action/deact_client.php?client_id={$row['client_id']}&id=1&user={$row['username']}'> Activate </a>";
				} ?>
				</td>
			</tr>
	<?php 	}
	} else {
		echo "0 Users";
	}
	mysqli_close($conn);
?>
			  </tbody>
			</table>
		</div>
	  </div>
	</div>

	<script>
		$(document).ready(function() {
			$('#user_table').DataTable();
		} );
	</script>

</body>
</html>
<?php
} else {
	header("Location: login.php");
}
?>
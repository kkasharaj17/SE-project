<?php
session_start();
if($_SESSION['level']=='admin' || $_SESSION['level']=='accountant'){
include_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Employees List </title>
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
            <a class="nav-link" href="employee.php">Employees<span class="sr-only">(current)</span></a>
          </li>
		<?php if($_SESSION['level']=='admin') { ?>
          <li class="nav-item">
            <a class="nav-link" href="admin_user.php">Users </a>
          </li>
		<?php } ?>
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
		<li class="breadcrumb-item active" aria-current="page">Employees</li>
	  </ol>
	</nav>
	
	<div class="card" style="margin: 50px 50px 0px 50px;">
	  <div class="card-header">
		<strong> EMPLOYEES TABLE </strong> 
	  </div>
	  <div class="card-body">
		<div class="float-right">
            <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#addEmployee"> <i class="fas fa-plus-circle"></i> Add Employee </button>
			<button class="btn btn-info" onclick="window.location.href='action/genrate-excelEmp.php';"> <i class="fas fa-file-excel"></i> Generate Excel </button>
        </div>
		<br> <br>
		<div class="table-responsive">		
			<table id="user_table" class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th> Photo </th>
				  <th> Username </th>
				  <th> Name </th>
				  <th> Surname </th>
				  <th> Job Position </th>
				  <th> E-mail </th>
				  <th> Phone number </th>
				  <th> Date of Birth </th>
				  <th> Employee since </th>
				  <th> Nett Salary </th>
				  <th> Bruto Salary </th>
				  <th> Edit </th>
				  <th> Delete </th>
				</tr>
			  </thead>
			  <tbody>
<?php 
	$sql = "SELECT * FROM `web20_employee`";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) { 
		if ($row['active'] == 1) {?>
		<?php if (!($_SESSION['level']=='accountant' && $_SESSION['user']==$row['username'])) { ?>
			<tr>
				<td> <img src='<?php echo $row['photo']; ?>' height='90' width='70'> </td>
				<td id="username<?php echo $row['emp_id']; ?>"> <?php echo $row['username']; ?> </td>
				<td id="name<?php echo $row['emp_id']; ?>"> <?php echo $row['name']; ?> </td>
				<td id="surname<?php echo $row['emp_id']; ?>"> <?php echo $row['surname']; ?> </td>
				<td> <?php echo $row['job']; ?> </td>
				<td> <?php echo $row['email']; ?> </td>
				<td> <?php echo $row['phone_no']; ?> </td>
				<td> <?php echo $row['dob']; ?> </td>
				<td> <?php echo $row['created']; ?> </td>
				<td> $<?php echo $row['netto']; ?> </td>
				<td> $<?php echo $row['bruto']; ?> </td>
				<form action="" method="post">
				<td>
					<button type="submit" class="btn btn-primary" value="<?php echo $row['emp_id']; ?>"> <i class='far fa-edit'></i> Edit </button>
				</td> </form>
				<td>
					<button type="button" class="btn btn-warning delBtn" value="<?php echo $row['emp_id']; ?>">
					<i class='fas fa-trash-alt'></i> Remove </button>
				</td>
			</tr>
		<?php 	} } }
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
	
	<div class="modal fade" id="addEmployee" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
		<div class="modal-content">
			<form action="action/addEmployee.php" method="POST" enctype="multipart/form-data">
			  <div class="modal-header">
				<h5 class="modal-title" id="addEmployee"> <i class="fas fa-plus-circle"></i> Add Employee</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <?php $err = true; ?>
			  <div class="modal-body">
				<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div id="add-product-messages"></div>

				<div class="form-group row">
					<label for="empPhoto" class="col-sm-3 control-label">Employee Photo: </label>
						<div class="col-sm-8">
							<!-- the avatar markup -->
								<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							<div class="kv-avatar center-block">					        
								<input type="file" class="form-control" id="empPhoto" placeholder="Employee Photo" name="empPhoto" class="file-loading" style="width:auto;" required />
							</div>
						  
						</div>
				</div> <!-- /form-group-->	     	           	       

				<div class="form-group row">
					<label for="empName" class="col-sm-3 control-label">Employee Name: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="empName" placeholder="Employee Name" name="empName" autocomplete="off" required pattern="[a-zA-Z]+">
						</div>
				</div> <!-- /form-group-->
				<div class="form-group row">
					<label for="empSurname" class="col-sm-3 control-label">Employee Surname: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="empSurname" placeholder="Employee Surname" name="empSurname" autocomplete="off" required pattern="[a-zA-Z]+">
						</div>
				</div> <!-- /form-group-->		    

				<div class="form-group row">
					<label for="username" class="col-sm-3 control-label">Username: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="username" placeholder="Username" name="username" autocomplete="off" required pattern="[a-zA-Z][a-zA-Z0-9-_.]{1,20}">
						</div>
				</div> <!-- /form-group-->	

				<div class="form-group row">
					<label for="email" class="col-sm-3 control-label"> E-mail: </label>
						<div class="col-sm-8">
						  <input type="email" class="form-control" id="email" placeholder="E-mail Address" name="email" autocomplete="off" required >
						</div>
				</div> <!-- /form-group-->
				
				<div class="form-group row">
					<label for="phone" class="col-sm-3 control-label"> Phone number: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="phone" placeholder="06..." name="phone" autocomplete="off" required pattern="06[0-9]{8}+">
						</div>
				</div> <!-- /form-group-->	        	 	     	        

				<div class="form-group row">
					<label for="dob" class="col-sm-3 control-label"> Date of birth: </label>
						<div class="col-sm-8">
						  <input type="date" class="form-control" id="dob" name="dob" autocomplete="off" placeholder="YYYY-MM-DD" required>
						</div>
				</div> <!-- /form-group-->	

				<div class="form-group row">
					<label for="job" class="col-sm-3 control-label">Job title: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="job" placeholder="Job title" name="job" autocomplete="off" required pattern="[A-Za-z]+">
						</div>
				</div> <!-- /form-group-->

				<div class="form-group row">
					<label for="net" class="col-sm-3 control-label"> Net Salary: </label>
						<div class="col-sm-8">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
							<span class="input-group-text">$</span>
						  </div>
						  <input type="number" class="form-control" id="net" placeholder="Salary" name="net" autocomplete="off" min="0" min="2500" required aria-label="Amount (to the nearest dollar)">
						</div>
						</div>
				</div>				
			  </div> <!-- /modal-body -->
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times-circle"></i> Close</button>
				<button type="submit" class="btn btn-primary"> <i class="far fa-thumbs-up"></i> Add </button>
			  </div>
			</form>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" tabindex="-1" role="dialog" id="removeEmpModal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title"> <i class='fas fa-trash-alt'></i> Remove Employee </h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<p>Are you sure you want to remove this Employee?</p>
		  </div>
		<form action="action/deleteEmp.php" method="POST">
		<input type="hidden" class="form-control" id="delete_us" name="delete_us">
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="delete_name" name="delete_name" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="delete_surname" name="delete_surname" required disabled> <br>
		  </div>
		  <div class="modal-footer removeEmpFooter">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times-circle"></i> Close </button>
			<button type="submit" class="btn btn-danger" id="removeProductBtn" data-loading-text="Loading..." > <i class="far fa-thumbs-up"></i> YES </button>
		  </div>
		</form>
		</div>
	  </div>
	</div>
	
	<script>
		$(document).ready(function() {
			$('#user_table').DataTable();
		} );
		
		$(document).ready(function(){		
			$(document).on('click', '.delBtn', function(){
				var id=$(this).val();
				var user=$('#username'+id).text();
				var name=$('#name'+id).text();
				var surname=$('#surname'+id).text();
		 
				$('#removeEmpModal').modal('show');
				$('#delete_id').val(id);
				$('#delete_us').val(user);
				$('#delete_name').val(name);
				$('#delete_surname').val(surname);
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
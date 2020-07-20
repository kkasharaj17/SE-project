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
          <li class="nav-item">
            <a class="nav-link" href="employee.php">Employees</a>
          </li>
        <?php if($_SESSION['level']=='admin') { ?>
          <li class="nav-item">
            <a class="nav-link" href="admin_user.php">Users </a>
          </li>
		<?php } ?>
          <li class="nav-item active">
            <a class="nav-link" href="product.php">Inventory <span class="sr-only">(current)</span></a>
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
		<li class="breadcrumb-item"><a href="service.php">Product Inventory</a></li>
		<li class="breadcrumb-item active" aria-current="page">Services List</li>
	  </ol>
	</nav>
	
	<div class="card" style="margin: 60px;">
	  <div class="card-header">
		MANAGE SERVICES LIST
	  </div>
	  <div class="card-body">
		<div class="float-right">
            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#addProduct"> <i class="fas fa-plus-circle"></i> Add Service </button>
        </div>
		<br> <br>
		<div class="table-responsive">
			<table class="table table-hover text-justify" id="prod_data" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th scope="col"> Service Category </th>
				  <th scope="col"> Service Description </th>
				  <th scope="col"> Price in $ </th>
				  <th scope="col"> Duration </th>
				  <th scope="col"> Delete </th>
				</tr>
			  </thead>
			  <tbody>
<?php 
	$sql = "SELECT * FROM `web20_services`";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {?>
				<tr>
						<td><span id="prodCode<?php echo $row['id']; ?>"><?php echo $row['service_category']; ?></span></td>
						<td><span id="prodName<?php echo $row['id']; ?>"><?php echo $row['service_name']; ?></span></td>
						<td><span id="prodSold<?php echo $row['id']; ?>">$<?php echo $row['price']; ?>.00</span></td>
						<td><span id="prodCat<?php echo $row['id']; ?>"><?php echo $row['duration']; ?> min</span></td>
						<td>
							<button type="button" class="btn btn-danger delBtn" value="<?php echo $row['id']; ?>">
							<i class='fas fa-trash-alt'></i>
							Delete </button>
						</td>
				</tr>
		<?php }
	} else {
		echo "0 results";
	}
	mysqli_close($conn);
?>
			  </tbody>
			</table>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="addProduct" tabindex="-1" role="dialog">
	  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
		<div class="modal-content">
			<form action="action/createService.php" method="POST" enctype="multipart/form-data">
			  <div class="modal-header">
				<h5 class="modal-title" id="addProduct"> <i class="fas fa-plus-circle"></i> Add Service</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div id="add-product-messages"></div>
	<input type="hidden" class="form-control" id="hidden" name="hidden" value="Add">
				    	           	      
				<div class="form-group row">
					<label for="serviceCategory" class="col-sm-3 control-label">Service Category: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="serviceCategory" placeholder="Service Category" name="serviceCategory" autocomplete="off" required >
						</div>
				</div> <!-- /form-group--> 
				
				<div class="form-group row">
					<label for="serviceName" class="col-sm-3 control-label">Service description: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="serviceName" placeholder="Service Name" name="serviceName" autocomplete="off" required >
						</div>
				</div> <!-- /form-group-->

				<div class="form-group row">
					<label for="price" class="col-sm-3 control-label"> Price: </label>
						<div class="col-sm-8">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
							<span class="input-group-text">$</span>
						  </div>
						  <input type="number" class="form-control" id="price" placeholder="Price" name="price" autocomplete="off" min="0" required aria-label="Amount (to the nearest dollar)">
						  <div class="input-group-append">
							<span class="input-group-text">.00</span>
						  </div>
						</div>
						</div>
				</div> <!-- /form-group-->
				
				<div class="form-group row">
					<label for="duration" class="col-sm-3 control-label"> Duration: </label>
						<div class="col-sm-8">
						  <input type="number" class="form-control" id="duration" placeholder="Duration" name="duration" autocomplete="off" min="0" max="9999" required >
						</div>
				</div> <!-- /form-group-->	   					        	         	       	         	        
			  </div> <!-- /modal-body -->
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times-circle"></i> Close</button>
				<button type="submit" class="btn btn-danger"> <i class="far fa-thumbs-up"></i> Add </button>
			  </div>
			</form>
		</div>
	  </div>
	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h4 class="modal-title"> <i class='fas fa-trash-alt'></i> Remove Service </h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<p>Are you sure you want to remove this service?</p>
		  </div>
		<form action="action/deleteService.php" method="POST">
		<input type="hidden" class="form-control" id="delete_id" name="delete_id">
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="delete_code" name="delete_code" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="delete_name" name="delete_name" required disabled> <br>
		  </div>
		  <div class="modal-footer removeProductFooter">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times-circle"></i> Close </button>
			<button type="submit" class="btn btn-danger" id="removeProductBtn" data-loading-text="Loading..." > <i class="far fa-thumbs-up"></i> YES </button>
		  </div>
		</form>
		</div>
	  </div>
	</div>


	<script>
		$(document).ready(function() {
			$('#prod_data').DataTable();
		} );
	</script>

	<script>
		$(document).ready(function(){		
			$(document).on('click', '.delBtn', function(){
				var id=$(this).val();
				var code=$('#prodCode'+id).text();
				var name=$('#prodName'+id).text();
		 
				$('#removeProductModal').modal('show');
				$('#delete_id').val(id);
				$('#delete_name').val(name);
				$('#delete_code').val(code);
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
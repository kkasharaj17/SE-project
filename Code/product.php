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
		<li class="breadcrumb-item active" aria-current="page">Inventory</li>
		<li class="breadcrumb-item"><a href="service.php">Services List</a></li>
	  </ol>
	</nav>
	
	<div class="card" style="margin: 60px;">
	  <div class="card-header">
		MANAGE PRODUCT INVENTORY
	  </div>
	  <div class="card-body">
		<div class="float-right">
            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#addProduct"> <i class="fas fa-plus-circle"></i> Add Product </button>
			<a type="button" class="btn btn-success" href="action/invoice.php"><i class="fas fa-file-alt"></i> Invoice </a>
            <a type="button" class="btn btn-warning" href="action/download_pdf_inventory.php"> <i class="fas fa-file-pdf"></i> Print Inventory </a>
        </div>
		<br> <br>
		<div class="table-responsive">
			<table class="table table-hover text-justify" id="prod_data" style="width: 100%;">
			  <thead class="thead-light">
				<tr>
				  <th scope="col"> Image </th>
				  <th scope="col"> Product Name </th>
				  <th scope="col"> Product Code </th>
				  <th scope="col"> Brand </th>
				  <th scope="col"> Category </th>
				  <th scope="col"> Quantity </th>
				  <th scope="col"> Purchase Price in $ </th>				  
				  <th scope="col"> Selling Price in $ </th>
				  <th scope="col"> Edit </th>
				  <th scope="col"> Delete </th>
				  <th scope="col"> Invoice </th>
				</tr>
			  </thead>
			  <tbody>
<?php 
	$sql = "SELECT * FROM `web20_product`";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if ($row['status'] == 1 && !(preg_match('/service\i/', $row['category']))) { ?>
				<tr> <td> <img src='<?php echo $row['product_image']; ?>' height='90' width='70'> 
						<span style="display: none;" id="prodImg<?php echo $row['product_id']; ?>"><?php echo $row['product_image']; ?></span></td>
						<td><span id="prodName<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></span></td>
						<td><span id="prodCode<?php echo $row['product_id']; ?>"><?php echo $row['product_code']; ?></span></td>
						<td><span id="prodBrand<?php echo $row['product_id']; ?>"><?php echo $row['brand']; ?></span></td>
						<td><span id="prodCat<?php echo $row['product_id']; ?>"><?php echo $row['category']; ?></span></td>
						<td><span id="prodQnt<?php echo $row['product_id']; ?>"><?php echo $row['quantity']; ?></span></td>
						<td><span id="prodPrice<?php echo $row['product_id']; ?>">$<?php echo $row['price']; ?>.00</span></td>
						<td><span id="prodSold<?php echo $row['product_id']; ?>">$<?php echo $row['sold_price']; ?>.00</span></td>
						<td>
						<form method="post" action="action/editProduct.php">
							<input type="hidden" id="idd" name="idd" value="<?php echo $row['product_id']; ?>">
							<button type="submit" class="btn btn-primary editbtn">
							<i class='far fa-edit'></i>
							Edit </button>
						</form>
						</td>
						<td>
							<button type="button" class="btn btn-danger delBtn" value="<?php echo $row['product_id']; ?>">
							<i class='fas fa-trash-alt'></i>
							Delete </button>
						</td>
						<?php $id=$row['product_id'];?>
						<td> <a type="button" class="btn btn-success" href="action/invoice_pdf.php?id=<?=$id?>"> <i class="fas fa-file-invoice-dollar"></i> Purchase Inventory </a> </td>
				</tr>
		<?php }
		}
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
			<form action="action/createProduct.php" method="POST" enctype="multipart/form-data">
			  <div class="modal-header">
				<h5 class="modal-title" id="addProduct"> <i class="fas fa-plus-circle"></i> Add Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div class="modal-body" style="max-height:450px; overflow:auto;">

				<div id="add-product-messages"></div>
	<input type="hidden" class="form-control" id="hidden" name="hidden" value="Add">
				<div class="form-group row">
					<label for="productImage" class="col-sm-3 control-label">Product Image: </label>
						<div class="col-sm-8">
							<!-- the avatar markup -->
								<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							<div class="kv-avatar center-block">					        
								<input type="file" class="form-control" id="productImage" placeholder="Product Image" name="productImage" class="file-loading" style="width:auto;" required />
							</div>
						  
						</div>
				</div> <!-- /form-group-->	     	           	       

				<div class="form-group row">
					<label for="productName" class="col-sm-3 control-label">Product Name: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off" required >
						</div>
				</div> <!-- /form-group-->

				<div class="form-group row">
					<label for="code" class="col-sm-3 control-label">Product Code: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="code" placeholder="Product Code" name="code" autocomplete="off" required>
						</div>
				</div> <!-- /form-group-->		    

				<div class="form-group row">
					<label for="brandName" class="col-sm-3 control-label">Brand Name: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="brandName" placeholder="Brand Name" name="brand" autocomplete="off" required >
						</div>
				</div> <!-- /form-group-->	

				<div class="form-group row">
					<label for="categoryName" class="col-sm-3 control-label">Category Name: </label>
						<div class="col-sm-8">
						  <input type="text" class="form-control" id="categoryName" placeholder="Category Name" name="category" autocomplete="off" required >
						</div>
				</div> <!-- /form-group-->

				<div class="form-group row">
					<label for="quantity" class="col-sm-3 control-label"> Quantity: </label>
						<div class="col-sm-8">
						  <input type="number" class="form-control" id="quantity" placeholder="Quantity" name="quantity" autocomplete="off" min="0" max="9999" required >
						</div>
				</div> <!-- /form-group-->	        	 	     	        

				<div class="form-group row">
					<label for="price" class="col-sm-3 control-label">Purchased Price: </label>
						<div class="col-sm-8">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
							<span class="input-group-text">$</span>
						  </div>
						  <input type="number" class="form-control" id="price" placeholder="Purchased Price" name="price" autocomplete="off" min="0" required aria-label="Amount (to the nearest dollar)">
						  <div class="input-group-append">
							<span class="input-group-text">.00</span>
						  </div>
						</div>
						</div>
				</div> <!-- /form-group-->	

				<div class="form-group row">
					<label for="sold" class="col-sm-3 control-label">Selling Price: </label>
						<div class="col-sm-8">
						<div class="input-group mb-3">
						  <div class="input-group-prepend">
							<span class="input-group-text">$</span>
						  </div>
						  <input type="number" class="form-control" id="sold" placeholder="Selling Price" name="sold" autocomplete="off" min="0" required aria-label="Amount (to the nearest dollar)">
						  <div class="input-group-append">
							<span class="input-group-text">.00</span>
						  </div>
						</div>
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
			<h4 class="modal-title"> <i class='fas fa-trash-alt'></i> Remove Product </h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  </div>
		  <div class="modal-body">
			<p>Are you sure you want to delete this product?</p>
		  </div>
		<form action="action/deleteProduct.php" method="POST">
		<input type="hidden" class="form-control" id="delete_id" name="delete_id">
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="delete_name" name="delete_name" required disabled> <br>
		  </div>
		  <div class="col-sm-8">
			 <input type="text" class="form-control" id="delete_code" name="delete_code" required disabled> <br>
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
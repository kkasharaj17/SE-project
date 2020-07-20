<?php
session_start();
if($_SESSION['level']=='admin' || $_SESSION['level']=='accountant'){
include_once('config.php');
	$idd = mysqli_real_escape_string($conn, $_POST['idd']);
	
if(isset($_POST['submit'])) {
	if ($conn) {
		if(isset($_POST['productNameEdit']))
		$product = $_POST['productNameEdit'];
		//$brand = $_POST['brandNameEdit'];
		$category = $_POST['categoryNameEdit'];
		$sold = $_POST['soldEdit'];
		
		$sql="UPDATE `web20_product` SET ".(isset($url)?"`product_image`='{$url}'":"")."".(isset($product)?", `product_name`='{$product}'":"")."".(isset($category)?", `category`='{$category}'":"")."".(isset($sold)?", `sold_price`='{$sold}'":"").", WHERE `web20_product`.`product_id` = '{$idd}';";
		mysqli_query($conn,$sql);
		//mysqli_close($conn);
		
	}
}

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
            <a class="nav-link" href="../admin.php">Home </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../employee.php">Employees</a>
          </li>
        <?php if($_SESSION['level']=='admin') { ?>
          <li class="nav-item">
            <a class="nav-link" href="admin_user.php">Users </a>
          </li>
		<?php } ?>
          <li class="nav-item active">
            <a class="nav-link" href="../product.php">Inventory <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Statements</a>
          </li>
        </ul>
      </div>
    </nav>
	<br>
	<nav aria-label="breadcrumb" style="margin-top: 60px;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="../admin.php">Home</a></li>
		<li class="breadcrumb-item"><a href="../product.php">Inventory</a></li>
		<li class="breadcrumb-item active" aria-current="page">Edit Product</li>
	  </ol>
	</nav>
	
	<div class="card" style="margin: 0px 200px 0px 200px;">
	  <div class="card-body">
	  <div class="float-right">
            <button class="btn btn-secondary" onclick="window.location.href='../product.php';"> <i class="fas fa-angle-double-left"></i> Back </button>
        </div>
		<br> <br>
		<div class="table-responsive">
			<table class="table table-hover text-justify" style="width: 100%;">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col"> Image </th>
				  <th scope="col"> Product Name </th>
				  <th scope="col"> Category </th>				  
				  <th scope="col"> Selling Price in $ </th>
				  <th scope="col"> Product Code </th>
				</tr>
			  </thead>
			  <tbody>
<?php 
	$sql = "SELECT * FROM `web20_product` WHERE `web20_product`.`product_id` = '{$idd}';";
	$result = mysqli_query($conn, $sql);
	
	if (mysqli_num_rows($result) == 1) {
		while($row = mysqli_fetch_assoc($result)) {
			if ($row['status'] == 1 && !(preg_match('/service\i/', $row['category']))) { ?>
				<tr> <td> <img src='.<?php echo $row['product_image']; ?>' height='100'> </td>
						<span style="display: none;" id="prodImg<?php echo $row['product_id']; ?>"><?php echo $row['product_image']; ?></span>
						<td><span id="prodName<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></span></td>
						<td><span id="prodCat<?php echo $row['product_id']; ?>"><?php echo $row['category']; ?></span></td>
						<td><span id="prodSold<?php echo $row['product_id']; ?>"><?php echo $row['sold_price']; ?></span></td>
						<td><span id="prodCode<?php echo $row['product_id']; ?>"><?php echo $row['product_code']; ?></span></td>
				</tr>
		<?php }
		} 
		?>
		<tr>
		<form method="post" action="../product.php" enctype="multipart/form-data" >
		<td> <input type="file" class="form-control" id="productImageEdit" placeholder="Product Image" name="productImageEdit" class="file-loading" style="width:auto;"> </td>
		<td> <input type="text" class="form-control" id="productNameEdit" placeholder="Product Name" name="productNameEdit" autocomplete="off"> </td>
		<td> <input type="text" class="form-control" id="categoryNameEdit" placeholder="Category Name" name="categoryNameEdit" autocomplete="off"> </td>
		<td> 
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
				<span class="input-group-text">$</span>
			  </div>
			  <input type="text" class="form-control" id="soldEdit" placeholder="Selling Price" name="soldEdit" autocomplete="off" min="0" aria-label="Amount (to the nearest dollar)"> 
			  <div class="input-group-append">
				<span class="input-group-text">.00</span>
			  </div>
			</div>
		</td>
		<td><button  type="submit" name="submit" class="btn btn-success" > <i class="far fa-thumbs-up"></i> Edit</button> </td>
		</tr>
	<?php } else {
		echo "No result found";
	}
	//mysqli_close($conn);
?>
			  </tbody>
			</table>
		</div>
	  </div>
	</div>

</body>
</html>

<?php
} else {
	header("Location: ../login.php");
}
?>
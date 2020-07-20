<?php
session_start();
if($_SESSION['level']=='admin' || $_SESSION['level']=='secretary'){
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Bill </title>
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
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="../admin.php">Home <span class="sr-only">(current)</span></a>
          </li>
	<?php if ($_SESSION['level']=='admin') { ?>
		  <li class="nav-item">
            <a class="nav-link" href="../employee.php">Employees</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../admin_user.php">Users</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../product.php">Inventory</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Statements</a>
          </li>
	<?php } else if ($_SESSION['level']=='secretary') { ?>
		  <li class="nav-item">
            <a class="nav-link" href="#">Settings</a>
          </li>
	<?php } ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<a type="button" class="btn btn-light" href="../logout.php"> <i class="fas fa-sign-out-alt"></i> Logout</a>
		</ul>
      </div>
    </nav>
	
	<br>
	<nav aria-label="breadcrumb" style="margin-top: 60px;">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"> <?php if ($_SESSION['level']=='admin') {?><a href="../admin.php"><?php } else { ?> <a href="../secretary.php"> <?php } ?> Home</a></li>
		<li class="breadcrumb-item active" aria-current="page">Bill</li>
	  </ol>
	</nav>
	
	<br>
  <div class="card rounded-top" style="margin: 20px 100px 0px 100px;">
   <div class="card-header">
   <h2 style="margin-left: 6%">Bill</h2>
   </div>
   <div class="card-body">
   <div class="table-responsive">
    <table class="table table-bordered" id="crud_table">
     <tr>
      <th width="4%">No.</th>
      <th width="15%">Category</th>
      <th width="25%">Description</th>
      <th width="15%">Price</th>
      <th width="15%">VAT</th>
      <th width="15%">Value</th>
     </tr>
     <tr>
	  <td> 1 </td>
      <td contenteditable="true" class="category"></td>
      <td contenteditable="true" class="description"></td>
      <td contenteditable="true" class="price"></td>
      <td contenteditable="true" class="vat"></td>
      <td contenteditable="true" class="value"></td>
      <td></td>
     </tr>
    </table>
    <div align="right">
     <button type="button" name="add" id="add" class="btn btn-success btn-xs"><i class="fas fa-plus-square"></i> Add Line</button>
    </div> <br>
    <div align="right">
     <button type="button" name="save" id="save" class="btn btn-info"><i class="fas fa-share-square"></i> Save</button>
    </div>
    <br />
    <div id="inserted_item_data"></div>
   </div>
   </div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 var count = 1;
 $('#add').click(function(){
  count = count + 1;
  var html_code = "<tr id='row"+count+"'>";
   html_code += "<td>"+count+"</td>";
   html_code += "<td contenteditable='true' class='category'></td>";
   html_code += "<td contenteditable='true' class='description'></td>";
   html_code += "<td contenteditable='true' class='price' ></td>";
   html_code += "<td contenteditable='true' class='vat' ></td>";
   html_code += "<td contenteditable='true' class='value' ></td>";
   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>-</button></td>";   
   html_code += "</tr>";
   $('#crud_table').append(html_code);
 });
 
 $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
 
 $('#save').click(function(){
  var category = [];
  var description = [];
  var price = [];
  var vat = [];
  var value = [];
  $('.category').each(function(){
   category.push($(this).text());
  });
  $('.description').each(function(){
   description.push($(this).text());
  });
  $('.price').each(function(){
   price.push($(this).text());
  });
  $('.vat').each(function(){
   vat.push($(this).text());
  });
  $('.value').each(function(){
   value.push($(this).text());
  });
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:{category:category, description:description, price:price, vat:vat, value:value},
   success:function(data){
    alert(data);
    $("td[contentEditable='true']").text("");
    for(var i=2; i<= count; i++)
    {
     $('tr#'+i+'').remove();
    }
   }
  });
 });
});
</script>
<?php } else {
	header("Location: ../login.php");
} ?>
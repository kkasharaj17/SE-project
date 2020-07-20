<?php
session_start();
if(isset($_SESSION['id'])){
	if($_SESSION['level']=='admin')
		header("Location: admin.php");
	else if ($_SESSION['level']=='insider')
	    header("Location: insider.php");
	else if ($_SESSION['level']=='secretary')
	    header("Location: secretary.php");
	else if ($_SESSION['level']=='accountant')
	    header("Location: accountant.php");
	else header("Location: client.php");
} else {
if (isset($_POST['submit'])) { 
	$clean=array();	$msg=array(); $err_user=false; $err_pass=false; $data = array();
	if(isset($_POST['user']) && preg_match("/^[\w\.-]+$/i",$_POST['user'])) {
		$clean['user'] = addslashes($_POST['user']); $err_user=false;
	} else {
		$err_user=true;
		$msg[0]="<label style='color:red'> Wrong Username </label><br><br>";
	}
	if(isset($_POST['pass']) && preg_match("/.*[A-Z].*/",$_POST['pass']) && preg_match("/.*[a-z].*/",$_POST['pass']) && preg_match("/.*[\d].*/",$_POST['pass']) && preg_match("/.{8,16}/",$_POST['pass'])) {
		$clean['pass'] = addslashes($_POST['pass']); $err_pass=false;
	} else {
		$err_pass=true;
		$msg[1]="<label style='color:red'> Wrong Password </label><br><br>";
	}
	if(!$err_user && !$err_pass) {
		include_once('config.php');
		// Check connection
		$query = "SELECT * from web20_user WHERE username = ? AND password = ?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $query)) {
			die("Failed to prepare statement");
		} else {
			mysqli_stmt_bind_param($stmt, "ss", $clean['user'], $clean['pass']);
			mysqli_stmt_execute($stmt);
			$res = mysqli_stmt_get_result($stmt);
			$row = mysqli_num_rows($res);
			if($row==1) {
				while($result = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
					array_push($data, $result);
				}
				$_SESSION['id'] = $data[0]['user_id'];
				$_SESSION['user'] = $data[0]['username'];
				$_SESSION['level'] = $data[0]['permission'];
				if($_SESSION['level']=='admin')
					header("Location: admin.php");
				else if($_SESSION['level']=='insider')
					header("Location: insider.php");
				else if ($_SESSION['level']=='secretary')
					header("Location: secretary.php");
				else if ($_SESSION['level']=='accountant')
					header("Location: accountant.php");
				else if($_SESSION['level']=='client')
					header("Location: client.php");
			} else {
			$msg[2]="<label style='color:red'> Username and Password not found </label><br><br>";
			}
		mysqli_stmt_close($stmt);
		mysqli_close($conn);
		}
	}
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Login </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <div class="hamburger">
        <i class="fas fa-bars"></i>
        <i class="fas fa-times"></i>
    </div>
    <nav class="sidebar">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="index.php" class="nav-link">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-envelope"></i> Contact
                </a>
            </li>
        </ul>
        <div class="social-media">
            <a href="#" class="icon-link">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </nav>
</header>
<main>
    <div class="zoom-content">
        <section id="box">
             <div class="loginBox">
                <img class="user" height="120" src="img/female_user.png" width="120">
                 <h3 class="title"> Sign in here</h3> <br>
                 <?php if(isset($msg[2])) echo $msg[2];?>			 
                 <form  method="post" action="<?=$_SERVER['PHP_SELF']?>">
                     <div class="inputBox">
                         <span> <i class="fas fa-user-lock" aria-hidden="true"></i></span>
                         <label>
                             <input type="text" name="user" placeholder="Username" required autocomplete="off">
                         </label>
                         <?php if(isset($msg[0])) echo $msg[0];?>
                     </div>
                     <div class="inputBox">
                         <span> <i class="fas fa-lock" aria-hidden="true"></i></span>
                         <label>
                             <input type="password" name="pass" placeholder="Password" required autocomplete="off">
                         </label>
                         <?php if(isset($msg[1])) echo $msg[1];?>
                     </div> <br> <br>
                        <input type="submit" name="submit" value="Login">
                 </form> <br>
                 <a href="register.php"> Sign Up </a>
             </div>
        </section>
    </div>
</main>
<script src="js/scripts.js"></script>
</body>
</html>
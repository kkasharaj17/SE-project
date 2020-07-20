<?php
include_once('config.php');
$s=false; $err=false; $out=""; $data = array();
if (isset($_POST['submit'])) {
	
	$msg=array(); $s=true; $clean=array();
	if(isset($_POST['name']) && preg_match("/^[a-z]+$/i",$_POST['name'])){
		$clean['name']=$_POST['name'];
		$base="./upload/";
		if(move_uploaded_file($_FILES['photo']['tmp_name'],$base.$clean['name'].".jpg")){
		$out.= "<h2>Photo is successfully uploaded!!!</h2>";
		$out.= "<img src='".$base.$clean['name'].".jpg"."' />";
		$clean['photo']=$base.$clean['name'].".jpg";
		}
	} else { $err=true; 
		$msg[1]="<label style='color:red'> Name must contain only letters </label><br><br>";
		$msg[7]="<label style='color:red'>Photo can't be uploaded!!!</label><br><br>";
	}
	if(isset($_POST['surname']) && preg_match("/^[a-z]+$/i",$_POST['surname'])){
		$clean['surname']=$_POST['surname'];
	} else { $err=true; 
		$msg[2]="<label style='color:red'>Surname must contain only letters</label><br><br>";
	}
	if(isset($_POST['user']) && preg_match("/^[\w\.-]+$/i",$_POST['user'])){
		$clean['user']=$_POST['user'];
	} else { $err=true;
		$msg[3]="<label style='color:red'>Username must contain Letters, numbers and . - _</label><br><br>";
	}
	if(isset($_POST['email']) && preg_match("/^[\w\.-]+@([a-z\d-]+\.)+[a-z]{2,6}$/i",$_POST['email'])){
		$clean['email']=$_POST['email'];
	} else { $err=true; 
		$msg[4]="<label style='color:red'>Email must be in email format</label><br><br>";
	}
	if(isset($_POST['pass']) && preg_match("/.*[A-Z].*/",$_POST['pass'])
		&& preg_match("/.*[a-z].*/",$_POST['pass'])
		&& preg_match("/.*[\d].*/",$_POST['pass'])
		&& preg_match("/.{8,16}/",$_POST['pass'])){
		$clean['pass']=$_POST['pass'];
	} else { $err=true; 
		$msg[5]="<label style='color:red'>Password must contain 8-16 characters, at least 
		1 uppercase letter, 1 lower case letter and 1 number</label><br><br>";
	}
	if(isset($_POST['dob']) && preg_match("/^[\d\\-]+$/i",$_POST['dob'])){
		$clean['dob']=$_POST['dob'];
	} else { $err=true; 
		$msg[6]="<label style='color:red'>Birthday format not OK!!!</label><br><br>";
	}
}
if(!$err&&$s) {
	$msg[0] = "<label style='color:red'>Submitted Successfully</label><br><br>";
	foreach($clean as $key => $val){
		if($key != 'pass') $out.= $key.": ".$val."<br>";
	}
	$query="INSERT INTO `web20_client`(`permission`, `client_id`, `username`, `name`, `surname`, `email`, `dob`, `points`, `photo`, `created`, `active`)
	VALUES ('client', NULL, '{$clean['user']}', '{$clean['name']}', '{$clean['surname']}', '{$clean['email']}', '{$clean['dob']}', '0', '{$clean['photo']}', CURRENT_TIMESTAMP, '1');";
	mysqli_query($conn, $query);
	$sql = "INSERT INTO `web20_user` (`user_id`, `username`, `password`, `permission`) VALUES (NULL, '{$clean['user']}', '{$clean['pass']}', 'client')";
	mysqli_query($conn, $sql);
	mysqli_close($conn);
	$file=fopen("upload/".$clean['name'].".txt",'w');//Shkrimi ne file...
	fwrite($file,$out);
	fclose($file);
	header("Location: login.php");
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Register </title>
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
                <a href="login.php" class="nav-link">
                    <i class="fas fa-door-closed"></i> Log in
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
                <img class="user" height="100" src="img/female_user.png" width="100">
                <h3 class="title"> Register here </h3> <br>
                <?php if(isset($msg[0])) echo $msg[0];?>
                <form  method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                    <div class="inputBox">
                        <?php if(isset($msg[1])) echo $msg[1];?>
                        <span> <i class="fas fa-user-circle" aria-hidden="true"></i></span>
                        <label>
                            <input type="text" name="name" placeholder="Name" required>
                        </label>
                    </div>
                    <div class="inputBox">
                        <?php if(isset($msg[2])) echo $msg[2];?>
                        <span> <i class="far fa-user-circle" aria-hidden="true"></i></span>
                        <label>
                            <input type="text" name="surname" placeholder="Surname" required>
                        </label>
                    </div>
                    <div class="inputBox">
                        <?php if(isset($msg[3])) echo $msg[3];?>
                        <span> <i class="fas fa-user-lock" aria-hidden="true"></i></span>
                        <label>
                            <input type="text" name="user" placeholder="Username" required>
                        </label>
                    </div>
                    <div class="inputBox">
                        <?php if(isset($msg[4])) echo $msg[4];?>
                        <span> <i class="fas fa-at" aria-hidden="true"></i></span>
                        <label>
                            <input type="email" name="email" placeholder="E-mail address" required>
                        </label>
                    </div>
                    <div class="inputBox">
                        <?php if(isset($msg[5])) echo $msg[5];?>
                        <span> <i class="fas fa-lock" aria-hidden="true"></i></span>
                        <label>
                            <input type="password" name="pass" placeholder="Password" required>
                        </label>
                    </div>
                    <div class="inputBox">
                        <?php if(isset($msg[6])) echo $msg[6];?>
                        <span> <i class="fas fa-birthday-cake" aria-hidden="true"></i></span>
                        <label>
                            <input type="date" name="dob" placeholder="Birthday" required>
                        </label>
                    </div>
                    <div class="inputBox">
                        <?php if(isset($msg[7])) echo $msg[7];?>
                        <label>
                            <input type="file" name="photo" required>
                        </label>
                    </div> <br> <br>
                    <input type="submit" name="submit" value="Register">
                </form> <br>
            </div>
        </section>
    </div>
</main>
<script src="js/scripts.js"></script>
</body>
</html>
<?php } ?>
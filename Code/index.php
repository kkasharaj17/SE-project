<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Home Page </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                <a href="index.php" class="nav-link current">
                    <i class="fas fa-home"></i> Home
                </a>
            </li>
			<li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-briefcase"></i> Showcase
                </a>
            </li>
			<li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-day"></i> Schedule
                </a>
            </li>
<?php 
if(isset($_SESSION['id'])){
	if($_SESSION['level']=='admin')
		header("Location: admin.php");
	else if ($_SESSION['level']=='insider') {
?>
            <li class="nav-item">
                <a href="insider.php" class="nav-link">
                    <i class="fas fa-door-open"></i> Profile
                </a>
            </li>
<?php } else { ?>
			<li class="nav-item">
                <a href="client.php" class="nav-link">
                    <i class="fas fa-door-oprn"></i> My Profile
                </a>
            </li>
<?php } } else { ?>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-envelope"></i> Contact
                </a>
            </li>
			<li class="nav-item">
                <a href="login.php" class="nav-link">
                    <i class="fas fa-door-closed"></i> Log in
                </a>
            </li>
<?php } ?>
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
        <section>
            <div id="hero">
                <video loop muted autoplay poster="">
                    <source src="video.mp4" type="video/mp4">
                </video>
                <div class="content d-flex">
                    <div class="container text-center"> <br>
                        <h1> Welcome to Our Frisuer </h1>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<script src="js/scripts.js"></script>
<script src="js/fit-video.js"></script>
<script>
    objectFitVideos();
</script>
</body>
<?php 
 
require'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");

//this will prevent not logged in user to log in
if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
} else {
	header("Location: register.php");
}
?>

<html>
<head>
	<title>Welcome to Mozetty Social</title>
	<!-- Javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/demo.js"></script>

	<!-- css -->
	<!-- Font awesome -->
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>


<body>
	<div class="top_bar">
		<div class="logo" >
			<a href="index.php">Mozetty Social</a>
		</div>
		
		<nav>
			<a href="#"> <?php echo $userLoggedIn; ?> </i> </a>
			<a href="#"> <i class = "fa fa-home fa-lg"></i> </a>
			<a href="#"><i class = "fa fa-envelope fa-lg"></i> </a>
			<a href="#"><i class = "fa fa-bell-o fa-lg"></i> </a>
			<a href="requests.php"><i class = "fa fa-users fa-lg"></i> </a>
			<a href="#"><i class = "fa fa-cog fa-lg"></i> </a>
			<a href="includes/handlers/logout.php"><i class = "fa fa-sign-out fa-lg"></i> </a>
		</nav>
	</div>

	<div class="wrapper">


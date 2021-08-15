<?php
	session_start();
	if((isset($_SESSION['aloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Institute.php');
	}else {
		$loginid = $_SESSION['aloginid'];
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{
			$query = "SELECT * FROM institute WHERE login_id='$loginid'" ;
			$institute = mysqli_query($link,$query);
			if($institute){
				if(mysqli_num_rows($institute)==0){
					header('location: institute.php');
				}
			}else{
				die(mysqli_error($link));
			}
		}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Admin Home</title>
		<style type="text/css">
			.text-success{
				width:250px;
				padding:10px;
				background-color:#D1E7DD;
				margin:0px auto;
			}
			@media screen and (min-width: 928px){
			.vertical{
				position:relative;
				top:45px;
			}
			}
			@media screen and (min-width: 726px) and (max-width: 927px){
			.vertical{
				position:relative;
				top:40px;
			}
			}
			@media screen and (min-width: 698px) and (max-width: 725px){
			.vertical{
				position:relative;
				top:30px;
			}
			}
			@media screen and (min-width: 576px) and (max-width: 697px){
			.vertical{
				position:relative;
				top:25px;
			}
			}
		</style>
	</head>
	<body>
		<div class="container mb-5">
		<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
		  <div class="container-fluid">
			<span class="navbar-brand mb-0 h1">Online Mentoring System</span>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
				  <a class="nav-link active" aria-current="page" href="">Home</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link text-primary" href="newdept.php">Add departments</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link text-primary" href="newsubject.php">Add subjects</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link text-primary" href="newmentor.php">Add mentors</a>
				</li>
			   </ul>
			   <ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="" id="navbardd" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="userh.png" width="30px" height="30px">
					<?php echo $_SESSION['aloginid'] ?>
				  </a>
				  <ul class="dropdown-menu" aria-labelledby="navbardd">
					<li><a class="dropdown-item" href="institutelogout.php">Logout</a></li>
				  </ul>
				</li>
			  </ul>
			</div>
		  </div>
		</nav>
	</div>
	<?php
		if(isset($_SESSION['success'])){
			echo "<div class='text-success text-center'>".$_SESSION['success']."</div>";
			unset($_SESSION['success']);
		}
		if(isset($_SESSION['sadded'])){
			echo "<div class='text-success text-center'>".$_SESSION['sadded']."</div>";
			unset($_SESSION['sadded']);
		}
		if(isset($_SESSION['snotadded'])){
			echo "<div class='text-danger text-center'>".$_SESSION['snotadded']."</div>";
			unset($_SESSION['snotadded']);
		}
		if(isset($_SESSION['empty'])){
			echo "<div class='text-danger text-center'>".$_SESSION['empty']."</div>";
			unset($_SESSION['empty']);
		}
	?>
	<div class="row">
		<div class="col-sm-6 mx-auto">
			<div class="card text-center vertical">
				<div class="card-body">
					<h5 class="card-title">Register new students</h5>
					<p class="card-text">Enter the login id for students to be added<br>
					This can then be sent to them using which they can login<br>
					(Default password for everyone is '1234')</p>
					<form action="newstudent.php" method="post">
						<textarea class="w-100" rows="7" id="rawsloginid" name="rawsloginid" placeholder="Eg. abcd12, xyz7, pqrs20     (Separate each login id with a comma ',')                                  (***Please add the departments and subjects before adding the mentors and students)"></textarea><br>
						<input id="adds" class="btn btn-primary mt-2" name="adds" type="submit" value="Add students">
					</form>
				</div>
			</div>
		</div>
		<!--<div class="col-sm-6 mb-3">
			<div class="card text-center vertical">
				<div class="card-body">
					<h5 class="card-title">Register new teachers</h5>
					<p class="card-text">Enter the login id for students to be added<br>
					This can then be sent to them using which they can login<br>
					(Default password for everyone is '1234')</p>
					<form method="post">
						<textarea class="w-100" rows="7" id="rawtloginid" name="rawtloginid" placeholder="Eg. abcd12, xyz7, pqrs20     (Separate each login id with a comma ',')                                  (***Please add the departments and subjects before adding the mentors and students)"></textarea><br>
						<input id="addt" class="btn-primary" name="addt" type="submit" value="Add students">
					</form>
				</div>
			</div>
		</div>-->
	</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
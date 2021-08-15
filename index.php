<!doctype html>
<html lang="en">
	<head>
	
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

		<title>Online Mentoring System</title>
		<style type="text/css">
			body{
				margin:0;
				padding:0;
				background:none;
			}
			html { 
				background: url(background.png) no-repeat center center fixed; 
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
			@media screen and (min-width: 616px){
			.middley{
				position: relative;
				top: 160px;
				margin: 0px 20px;
			}
			}
			@media screen and (min-width: 576px) and (max-width: 615px){
			.middley{
				position:relative;
				top:160px;
				
			}
			}
			@media screen and (max-width: 575px){
			.middley{
				margin:20% 25%;
			}
			#admin{
				margin-top: 20px;
			}
			}
			#head{
				height:60px;
				width:700px;
				background-color:#A9CB5A;
				margin:0 auto;
			}
		</style>
	</head>
	<body>
		<div class="text-center">
		<div id="head">
			<h1>Online Mentoring System for Students</h1>
		</div>
		</div>
		<div class="d-flex flex-row flex-wrap middley">
			<div id="login" class="me-auto">
				<div class="card text-center h-100" style="width: 18rem;">
				  <div class="card-body">
					<h5 class="card-title mt-2">Login</h5>
					<p class="card-text">Login for students and mentors</p>
					<a href="Student.php" class="card-link">Student</a>
					<a href="Mentor.php" class="card-link">Mentor</a>
				  </div>
				</div>
			</div>
			<div id="admin">
				<div class="card text-center" style="width: 18rem;">
				  <div class="card-body">
					<h5 class="card-title">Institute Admin</h5>
					<p class="card-text">Register for a new institute or login for existing institutes</p>
					<a href="NewInstitute.php" class="card-link">Register</a>
					<a href="Institute.php" class="card-link">Login</a>
				  </div>
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>

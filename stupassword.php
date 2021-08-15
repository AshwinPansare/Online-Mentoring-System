<?php
	session_start();
	if((isset($_SESSION['sloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Student.php');
	}
	include('updatestupass.php');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Change Password</title>  
		<style type="text/css">   
		body {  
				font-family: Calibri, Helvetica, sans-serif;  
				background-color: #F9F4F4;  
			}  
		#title2{
				text-align:center;
				margin-top:50px;
			}
		#error-msg{
				color:red;
				text-align:center;
			}
		.buttons{   
				margin: 10px 140px;     
			}			
		.container{   
				margin:80px auto;
				width:500px;
				padding: 25px;   
				border: 2px solid #050a9e;
				border-radius: 8px;
				background-color: white;  
			}   
		</style>   
	</head>    
	<body>    
		<h1 id="title2">Change Password</h1> 
		<form action="stupassword.php" method="post">  
			<div class="container">
				<div class="mb-3">
				<label for="opassword" class="form-label">Old Password : </label>   
				<input type="password" class="form-control" placeholder="Enter your old password" name="opassword" id="opassword" required>  
				<span class="text-danger"><?php if(isset($update_errors['op'])){ echo $update_errors['op'];}?></span>
				</div>
				<div class="mb-3">
				<label for="npassword" class="form-label">New Password : </label>   
				<input type="password" class="form-control" placeholder="Enter new password" name="npassword" id="npassword" required> 
				</div>
				<div class="mb-3">
				<label for="cnpassword" class="form-label">Confirm New Password : </label>   
				<input type="password" class="form-control" placeholder="Re-Enter Password" name="cnpassword" id="cnpassword" required> 
				<span class="text-danger"><?php if(isset($update_errors['np'])){ echo $update_errors['np'];}?></span>
				</div>
				<div class="buttons">
				<button type="submit" name="change" class="btn btn-primary">Change</button>   
				<button onclick="location.href='stuviewprofile.php'" type="button" class="btn btn-danger">Cancel</button>   
				</div>
			</div>   
		</form>     
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>     
</html>  

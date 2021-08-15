<?php
	session_start();
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title> Login Page </title>  
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
				margin: 10px 150px;     
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
		<h1 id="title2"> Mentor Login Form </h1> 
		<form action="processmentorlogin.php" method="post">  
			<div class="container">   
				<?php
					if(isset($_SESSION['message'])){
						echo "<div id='error-msg'>".$_SESSION['message']."</div>";
						unset($_SESSION['message']);
					}
				?>
				<div class="mb-3">
				<label for="loginid" class="form-label">Login ID : </label>   
				<input type="text" class="form-control" placeholder="Enter Login ID" name="loginid" id="loginid" autocomplete="off" required>  
				</div>
				<div class="mb-3">
				<label for="password" class="form-label">Password : </label>   
				<input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" required> 
				</div>
				<div class="buttons">
				<button type="submit" name="login" class="btn btn-primary">Login</button>   
				<button onclick="location.href='index.php'" type="button" class="btn btn-danger"> Cancel</button>   
				</div>
			</div>   
		</form>     
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>     
</html>  

<?php
	session_start();
	if((isset($_SESSION['sloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Student.php');
	}
	$loginid=$_SESSION['sloginid'];
	$link = mysqli_connect('localhost','root','root','mentoring_system'); 
	$query = "SELECT * from student where login_id = '$loginid'";
	$student = mysqli_query($link,$query); 
	$srow = mysqli_fetch_assoc($student);
	$i_id = $srow['i_id'];
	$query = "SELECT * FROM institute where i_id='$i_id'";
	$result = mysqli_query($link,$query); 
	$irow=mysqli_fetch_assoc($result);
	$iname=$irow['i_name'];
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Student Profile</title>  
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
				width:600px;
				padding: 25px;   
				border: 2px solid #050a9e;
				border-radius: 8px;
				background-color: white;  
			}   
		a{
			text-decoration:none;
		}
		a:hover{
			text-decoration:underline;
		}
		a:visited{
			color:blue;
		}
		</style>   
	</head>    
	<body>    
		<h1 id="title2">Your Information</h1> 
		<form>  
			<div class="container">   
				<div class="mb-3">
				<label for="loginid" class="form-label">Login ID : </label>   
				<input type="text" class="form-control" id="loginid" <?php echo 'value="'.$loginid.'"' ?>readonly>  
				</div>
				<div class="mb-3">
				<label for="fn" class="form-label">First Name : </label>   
				<input type="text" class="form-control" id="fn" <?php echo 'value="'.$srow['f_name'].'"' ?>readonly>  
				</div>
				<div class="mb-3">
				<label for="ln" class="form-label">Last Name : </label>   
				<input type="text" class="form-control" id="ln" <?php echo 'value="'.$srow['l_name'].'"' ?>readonly>  
				</div>
				<div class="mb-3">
				<label for="iname" class="form-label">Institute Name : </label>   
				<input type="text" class="form-control" id="iname" <?php echo 'value="'.$iname.'"' ?>readonly>  
				</div>
				<div class="mb-3">
				<label for="dept" class="form-label">Department : </label>   
				<input type="text" class="form-control" id="dept" <?php echo 'value="'.$srow['dept'].'"' ?>readonly>  
				</div>
				<div class="mb-3">
				<label for="sem" class="form-label">Semester : </label>   
				<input type="text" class="form-control" id="sem" <?php echo 'value="'.$srow['sem'].'"' ?>readonly>  
				</div>
				<div class="mb-3">
				<label for="email" class="form-label">Email ID : </label>   
				<input type="text" class="form-control" id="email" <?php echo 'value="'.$srow['email'].'"' ?>readonly>  
				</div>
				<div class="mb-3">
					<a href="stupassword.php">Change Password</a>
				</div>
				<div class="text-center text-muted">If there is a mistake, please report it to your college office</div>
			</div>   
		</form>    
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>     
</html>  

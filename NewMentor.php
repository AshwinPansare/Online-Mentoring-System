<?php 
	session_start();
	if((isset($_SESSION['aloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Institute.php');
	}
	$loginid = $_SESSION['aloginid'];
	include('mentorregister.php');
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>New Mentor</title>
		<style type="text/css">
			body {  
				font-family: Calibri, Helvetica, sans-serif;  
				background-color: #F9F4F4;  
			}  
			#title2{
				text-align:center;
				margin-top:50px;
			}
			.container {   
				margin:60px auto;
				width:500px;
				padding: 25px;   
				border: 2px solid #050a9e;   
				border-radius:8px;
				background-color: white;  
			}  
			.buttons{
				margin: 0px 160px;
			}
		</style>
		<script defer src="registrationscript.js"></script>
	</head>
	<body>
		<h1 id="title2">Add New Mentor</h1>   
		<div>
		<form action="NewMentor.php" method="post">  
			<div class="container">   
				<div class="mb-3">
			  <label for="mname" class="form-label">Teacher name</label>
			  <input type="text" class="form-control" id="mname" name="mname" placeholder="Eg. Mrs. XYZ" required autocomplete="off">
			</div>
			<div class="mb-3">
			  <label for="loginid" class="form-label">Login ID</label>
			  <input type="text" class="form-control" id="loginid" name="loginid" placeholder="Eg. xyz12" required autocomplete="off">
			  <span class="text-danger"><?php if(isset($errors['l'])){ echo $errors['l'];}?></span>
			</div>
			<div class="mb-3">
			  <label for="subcode" class="form-label">Subject code</label>
				<select name="subcode" id="subcode" class="form-control" required>
					<option value=" ">-----SELECT-----</option>
					<?php 
						$link = mysqli_connect('localhost','root','root','mentoring_system'); 
						$query = "SELECT * from institute where login_id = '$loginid'";
						$result = mysqli_query($link,$query);
						if($result){
							$row = mysqli_fetch_assoc($result);
							$i_id = $row['i_id'];
						}
						$query = "SELECT sub_code FROM subject,department where i_id='$i_id' and dept=d_abbr";
						$result = mysqli_query($link,$query); 
						while($row=mysqli_fetch_assoc($result)) { 
							echo '<option value="'.$row[sub_code].'">'.$row[sub_code].'</option>'; 
						} 
					?> 
				</select>
				<span class="text-danger"><?php if(isset($errors['s'])){ echo $errors['s'];}?></span>
			</div>
			<div class="buttons">
				<button type="submit" class="btn btn-primary mx-auto" name="add">Add</button>
				<button onclick="location.href='adminhome.php'" type="button" class="cancelbtn btn btn-danger">Cancel</button> 
			</div>  
		</div>
		</form>  
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
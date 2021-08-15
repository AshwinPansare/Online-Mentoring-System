<?php
	session_start();
	if((isset($_SESSION['aloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Institute.php');
	}
	$loginid = $_SESSION['aloginid'];
	$errors = array();
	if(isset($_POST['add'])){
		$dname = $_POST['dname'];
		$dabbr = $_POST['dabbr'];
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{	
			$query = "SELECT * from institute where login_id = '$loginid'";
			$result = mysqli_query($link,$query);
			if($result){
				$row = mysqli_fetch_assoc($result);
				$i_id = $row['i_id'];
			}else{
				die(mysqli_error());
			}
			$dname = mysqli_real_escape_string($link,$dname);
			$d = "SELECT * from department where d_name = '$dname' and i_id = '$i_id'";
			$dd = mysqli_query($link,$d);
			
			if(mysqli_num_rows($dd)>0){
				$errors['d']= "Department has already been added";
			}
			if(count($errors)==0){
				$dabbr = mysqli_real_escape_string($link,$dabbr);
				$query = "INSERT into department(i_id,d_name,d_abbr) VALUES('$i_id','$dname','$dabbr')";
				$result = mysqli_query($link,$query);
				if($result){
					echo "<script>alert('Department added');</script>";
				}else{
					die(mysqli_error($link));
				}
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
		<title>New Department</title>
		
		<style type="text/css">
			body{
				background-color: #F9F4F4;
				font-family: Calibri, Helvetica, sans-serif;  
			}
			#title2{
				text-align:center;
				margin-top:50px;
			}
			@media screen and (min-width: 573px){
				.container{   
					margin:80px auto;
					width:500px;
					padding: 25px;   
					border: 2px solid #050a9e;   
					border-radius: 10px;
					background-color: white;  
				}  
				#add{
					width: auto;   
					margin: 10px 200px;  
				}
				
			}
			@media screen and (max-width: 572px){
				.container{   
					margin:80px auto;
					width:300px;
					padding: 25px;   
					border: 2px solid #050a9e;   
					border-radius: 10px;
					background-color: white;  
				}  
				#add{
					width: auto;   
					margin: 10px 95px;  
				}
			}
		</style>
	</head>
	<body>
		<h1 id="title2"> Add New Department </h1>
		<div class="container">
		<form action="newdept.php" method="post">
		<div class="mb-3">
		  <label for="deptname" class="form-label">Department name</label>
		  <input type="text" class="form-control" id="deptname" name="dname" placeholder="Eg. Computer Science" required autocomplete="off">
		  <span class="text-danger"><?php if(isset($errors['d'])){ echo $errors['d'];}?></span>
		</div>
		<div class="mb-3">
		  <label for="deptabbr" class="form-label">Abbreviation for department name</label>
		  <input type="text" class="form-control" id="deptabbr" name="dabbr" placeholder="Eg. CMPN" required autocomplete="off">
		</div>
		<input id="add" name="add" class="btn btn-primary" type="submit" value="Add">
		</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
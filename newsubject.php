<?php
	session_start();
	if((isset($_SESSION['aloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Institute.php');
	}
	$loginid = $_SESSION['aloginid'];
	if(isset($_POST['add'])){
		$subname = $_POST['subname'];
		$subabbr = $_POST['subabbr'];
		$dept = $_POST['dept'];
		$sem = $_POST['sem'];
		$subcode = $_POST['subcode'];
		$subname = trim($subname);
		$errors = array();
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
			$subname = mysqli_real_escape_string($link,$subname);
			$s = "select * from subject,department,institute where subject.sub_name='$subname' and subject.dept='$dept' and department.i_id='$i_id'";
			$ss = mysqli_query($link,$s);
			
			if(mysqli_num_rows($ss)>0){
				$errors['su']= "Subject has already been added";
			}
			if($dept==" "){
				$errors['d'] = "Please select a department";
			}
			if($sem==" "){
				$errors['se'] = "Please select a semester";
			}
			if(count($errors)==0){
				$subabbr = mysqli_real_escape_string($link,$subabbr);
				$subcode = mysqli_real_escape_string($link,$subcode);
				$query = "INSERT into subject(sub_code,sub_name,abbr,dept,sem) VALUES('$subcode','$subname','$subabbr','$dept','$sem')";
				$result = mysqli_query($link,$query);
				if($result){
					echo "<script>alert('Subject added');</script>";
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
		<title>New Subject</title>
		
		<style type="text/css">
			body{
				font-family: Calibri, Helvetica, sans-serif;  
				background-color: #F9F4F4;  
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
					margin:100px auto;
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
		<h1 id="title2"> Add New Subject</h1>
		<div class="container">
		<form  action="newsubject.php" method="post">
			<div class="mb-3">
			  <label for="subname" class="form-label">Subject name</label>
			  <input type="text" class="form-control" id="subname" name="subname" placeholder="Eg. Engineering Mathematics 4" required autocomplete="off">
			  <span class="text-danger"><?php if(isset($errors['su'])){ echo $errors['su'];}?></span>
			</div>
			<div class="mb-3">
			  <label for="subabbr" class="form-label">Abbreviation for subject name</label>
			  <input type="text" class="form-control" id="subabbr" name="subabbr" placeholder="Eg. EM4" required autocomplete="off">
			</div>
			<div class="mb-3">
			  <label for="dept" class="form-label">Department name</label>
				<select name="dept" id="dept" class="form-control" required>
					<option value=" ">-----SELECT-----</option>
					<?php 
						$link = mysqli_connect('localhost','root','root','mentoring_system'); 
						$query = "SELECT * from institute where login_id = '$loginid'";
						$result = mysqli_query($link,$query);
						if($result){
							$row = mysqli_fetch_assoc($result);
							$i_id = $row['i_id'];
						}
						$query = "SELECT * FROM department where i_id='$i_id'";
						$result = mysqli_query($link,$query); 
						while($row=mysqli_fetch_assoc($result)) { 
							echo '<option value="'.$row[d_abbr].'">'.$row[d_name].'</option>'; 
						} 
					?> 
				</select>
				<span class="text-danger"><?php if(isset($errors['d'])){ echo $errors['d'];}?></span>
			</div>
			<div class="mb-3">
			  <label for="sem" class="form-label">Semester</label>
			  <select name="sem" id="sem" class="form-control" required>
					<option value=" ">-----SELECT-----</option>				
					<option value="1">Semester 1</option>
					<option value="2">Semester 2</option>
					<option value="3">Semester 3</option>
					<option value="4">Semester 4</option>
					<option value="5">Semester 5</option>
					<option value="6">Semester 6</option>
					<option value="7">Semester 7</option>
					<option value="8">Semester 8</option>
				</select>
				<span class="text-danger"><?php if(isset($errors['se'])){ echo $errors['se'];}?></span>
			</div>
			<div class="mb-3">
			  <label for="subcode" class="form-label">Subject code</label>
			  <input type="text" class="form-control" id="subcode" name="subcode" placeholder="Format: DeptSemSub Eg. CMPN41, CMPN42" required autocomplete="off">
			</div>
			<input id="add" name="add" class="btn btn-primary" type="submit" value="Add">
		</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
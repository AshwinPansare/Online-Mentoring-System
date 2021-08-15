<?php
	if(isset($_POST['register'])){
	$in = $_POST['in'];
	$email = $_POST['email'];
	$loginid = $_POST['loginid'];
	$password = $_POST['password'];
	$in = stripcslashes($in);
	$errors = array();
	
	if(!empty($in) && !empty($email) && !empty($loginid) && !empty($password)){
		$host = "localhost";
		$dbUsername = "root";
		$dbPassword = "root";
		$dbName = "mentoring_system";
		$link = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{
			$in = mysqli_real_escape_string($link,$in);
			$email = mysqli_real_escape_string($link,$email);
			$loginid = mysqli_real_escape_string($link,$loginid);
			$password = mysqli_real_escape_string($link,$password);
			$l = "SELECT login_id FROM institute WHERE login_id='$loginid'";
			$ll = mysqli_query($link,$l);
			$e = "SELECT email FROM institute WHERE email='$email'";
			$ee = mysqli_query($link,$e);
			$i = "SELECT i_name FROM institute WHERE i_name='$in'";
			$ii = mysqli_query($link,$i);
			
			if(mysqli_num_rows($ll)>0){
				$errors['l']= "Login id already taken, please use a different login id";
			}
			if(mysqli_num_rows($ee)>0){
				$errors['e']= "There is already an account registered with this email";
			}
			if(mysqli_num_rows($ii)>0){
				$errors['i']= "There is already an account created with this institute name";
			}
			if(count($errors)==0){
				$query = "INSERT INTO institute(i_name,email,login_id,password) VALUES('$in','$email','$loginid','$password')";
				$result = mysqli_query($link,$query);
				if($result){
					echo"<script>alert('Institute Registered');</script>";
				}else{
					die(mysqli_error($link));
				}
			}
		}
	}else{
		echo "<script>alert('All fields are required')</script>";
		die();
	}
	}
?>
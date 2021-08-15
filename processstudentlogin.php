<?php
	session_start();
	$loginid = $_POST['loginid'];
	$password = $_POST['password'];
	
	$loginid = stripcslashes($loginid);
	$password = stripcslashes($password);
	
	$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}else{	
		$loginid = mysqli_real_escape_string($link,$loginid);
		$password = mysqli_real_escape_string($link,$password);
		$query = "SELECT * FROM student WHERE login_id='$loginid' and password='$password'" ;
		$result = mysqli_query($link,$query);
		if($result){
			$row = mysqli_fetch_array($result);
			if($row['login_id'] == $loginid && $row['password'] == $password){
				$_SESSION['success']="You are now logged in";
				$_SESSION['sloginid']=$loginid;
				header('location: studenthome.php');
			}else{
				$_SESSION['message']="Invalid loginid or password";
				header('location: Student.php');
			}
		}else{
			die(mysqli_error());
		}
	}
?>
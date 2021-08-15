<?php
	session_start();
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid=$_SESSION['mloginid'];
	$meet = $_POST['meet'];
	$meet = trim($meet);
	$link = mysqli_connect('localhost','root','root','mentoring_system');
	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}else{	
		$meet = mysqli_real_escape_string($link,$meet);
		$query = "update mentor set meetlink='$meet' where login_id='$loginid'";
		$result = mysqli_query($link,$query);
		if($result){
			header('location: mentorhome.php');
		}else{
			die(mysqli_error($link));
		}
	}
?>
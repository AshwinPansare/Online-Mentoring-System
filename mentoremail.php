<?php
	session_start();
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid=$_SESSION['mloginid'];
	$email = $_POST['email'];
	$email = trim($email);
	$link = mysqli_connect('localhost','root','root','mentoring_system');
	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}else{	
		$email = mysqli_real_escape_string($link,$email);
		$query = "update mentor set email='$email' where login_id='$loginid'";
		$result = mysqli_query($link,$query);
		if($result){
			header('location: menviewprofile.php');
		}else{
			die(mysqli_error($link));
		}
	}
?>
<?php
	session_start();
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}else if((isset($_SESSION['mdid']))==false){
		header('location: mentorhome.php');
	}else{
		$loginid = $_SESSION['mloginid'];
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{
			$query = "SELECT m_id from mentor where login_id='$loginid'";
			$result = mysqli_query($link,$query);
			$mrow = mysqli_fetch_assoc($result);
			$m_id = $mrow['m_id'];
			$ans = $_POST['answer'];
			$ans = trim($ans);
			$ans = mysqli_real_escape_string($link,$ans);
			$d_id = $_SESSION['mdid'];
			$query = "UPDATE doubt set answer='$ans' where d_id='$d_id'";
			$result = mysqli_query($link,$query);
			if(!$result){
				die(mysqli_error($link));
				//$_SESSION['error']="There was a problem submitting";
				//header('location: mviewdoubt.php?d=');
			}else{
				$_SESSION['success']="Submitted";
				sleep(3);
				header('location: mviewdoubt.php?m='.$d_id);
			}
		}
	}
?>
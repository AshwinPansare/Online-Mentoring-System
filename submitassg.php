<?php
	session_start();
	if((isset($_SESSION['sloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Student.php');
	}else if((isset($_SESSION['said']))==false){
		header('location: sassignment.php');
	}else{
		$loginid = $_SESSION['sloginid'];
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{
			$query = "SELECT s_id from student where login_id='$loginid'";
			$result = mysqli_query($link,$query);
			$srow = mysqli_fetch_assoc($result);
			$s_id = $srow['s_id'];
			$ans = $_POST['answer'];
			$ans = trim($ans);
			$sdate = date('Y-m-d');
			$ans = mysqli_real_escape_string($link,$ans);
			$a_id = $_SESSION['said'];
			$query = "UPDATE completes set answer='$ans', sub_date='$sdate' where a_id='$a_id' and s_id='$s_id'";
			$result = mysqli_query($link,$query);
			if(!$result){
				die(mysqli_error($link));
				//$_SESSION['error']="There was a problem submitting";
				//header('location: assgdetails.php');
			}else{
				$_SESSION['success']="Submitted";
				header('location: assgdetails.php');
			}
		}
	}
?>
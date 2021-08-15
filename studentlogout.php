<?php
	session_start();
	session_destroy();
	unset($_SESSION['sloginid']);
	unset($_SESSION['said']);
	$_SESSION['message'] = "Logged out succesfully";
	header('location: Student.php');
?>
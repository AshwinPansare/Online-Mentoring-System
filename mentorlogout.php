<?php
	session_start();
	session_destroy();
	unset($_SESSION['mloginid']);
	unset($_SESSION['maid']);
	$_SESSION['message'] = "Logged out succesfully";
	header('Location: Mentor.php');
?>
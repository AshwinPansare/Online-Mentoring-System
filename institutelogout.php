<?php
	session_start();
	session_destroy();
	unset($_SESSION['aloginid']);
	$_SESSION['success'] = "Logged out succesfully";
	header('Location: institute.php');
?>
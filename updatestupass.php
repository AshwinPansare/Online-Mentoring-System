<?php
	if(isset($_POST['change'])){
		$opassword = $_POST['opassword'];
		$opassword = trim($opassword);
		$npassword = $_POST['npassword'];
		$npassword = trim($npassword);
		$cnpassword = $_POST['cnpassword'];
		$cnpassword = trim($cnpassword);
		$loginid=$_SESSION['sloginid'];
		$update_errors = array();
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{
			$op = "SELECT * from student where login_id = '$loginid'";
			$qop = mysqli_query($link,$op);
			$res = mysqli_fetch_assoc($qop);
			if($opassword!=$res['password']){
				$update_errors['op'] = "Incorrect password";
			}else if($npassword!=$cnpassword){
				$update_errors['np'] = "Passwords do not match";
			}
			if(count($update_errors)==0){
				$npassword = mysqli_real_escape_string($link,$npassword);
				$query = "UPDATE student set password='$npassword' where login_id='$loginid'";
				$result = mysqli_query($link,$query);
				if($result){
					$_SESSION['updatemsg'] = "Password Updated";
					header('location:studenthome.php');
				}else{
					die(mysqli_error($link));
				}
			}
		}			
	}
?>
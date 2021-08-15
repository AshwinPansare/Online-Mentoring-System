<?php
	if(isset($_POST['add'])){
	$name = $_POST['mname'];
	$mloginid = $_POST['loginid'];
	$subcode = $_POST['subcode'];
	$name = trim($name);
	$mloginid = trim($mloginid);
	$errors = array();
	$loginid = $_SESSION['aloginid'];
	$host = "localhost";
	$dbUsername = "root";
	$dbPassword = "root";
	$dbName = "mentoring_system";
	$link = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}else{
		$query = "SELECT * from institute where login_id = '$loginid'";
		$result = mysqli_query($link,$query);
		if($result){
			$row = mysqli_fetch_assoc($result);
			$i_id = $row['i_id'];
		}else{
			die(mysqli_error($link));
		}
		$mloginid = mysqli_real_escape_string($link,$mloginid);
		$l = "SELECT login_id FROM mentor WHERE login_id='$mloginid'";
		$ll = mysqli_query($link,$l);
		
		if($subcode==" "){
			$errors['s']= "Please select the subject code";
		}
		if(mysqli_num_rows($ll)>0){
			$errors['l']= "Login ID already taken, please use a different login id";
		}
		if(count($errors)==0){
			$name = mysqli_real_escape_string($link,$name);
			$query = "INSERT Into mentor(name,login_id,i_id,sub_code) VALUES('$name','$mloginid','$i_id','$subcode')";
			$result = mysqli_query($link,$query);
			if($result){
				echo"<script>alert('Mentor Added');</script>";
			}else{
				die(mysqli_error($link));
			}
		}
	}
	
	}
?>
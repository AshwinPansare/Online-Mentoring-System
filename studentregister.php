<?php
	if(isset($_POST['update'])){
		$loginid=$_SESSION['sloginid'];
		$fn = $_POST['fn'];
		$ln = $_POST['ln'];
		$fn = trim($fn);
		$ln = trim($ln);
		$sem = $_POST['sem'];
		$dept = $_POST['dept'];
		$email = $_POST['email'];
		$opassword = $_POST['opassword'];
		$opassword = trim($opassword);
		$npassword = $_POST['npassword'];
		$npassword = trim($npassword);
		$checkpassword = $_POST['checkpassword'];
		$checkpassword = trim($checkpassword);
		
		
		if(!empty($fn) && !empty($sem) && !empty($dept) && !empty($email)){
			$update_errors = array();
			if((empty($opassword) || ctype_space($opassword)) && ((!empty($npassword))&&(!ctype_space($npassword)))){
				$update_errors['o']="Old password required to change the password";
			}else if((empty($opassword) || ctype_space($opassword)) && ((!empty($checkpassword))&&(!ctype_space($checkpassword)))){
				$update_errors['o']="Old password required to change the password";
			}else if((!empty($opassword) && !ctype_space($opassword)) && (((empty($npassword))||(ctype_space($npassword)))||((empty($checkpassword))||(ctype_space($checkpassword))))){
				$update_errors['n']="Please enter the new password in both the inputs";
			}else if((!empty($opassword) && !ctype_space($opassword))&&((!empty($npassword))&&(!ctype_space($npassword)))&&((empty($checkpassword))||(ctype_space($checkpassword)))){
				$update_errors['c']="Please enter the new password in both the inputs";
			}
			$host = "localhost";
			$dbUsername = "root";
			$dbPassword = "root";
			$dbName = "mentoring_system";
			$link = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
			if(mysqli_connect_error()){
				die("There was an error connecting to the database");
			}else{
				$opassword = mysqli_real_escape_string($link,$opassword);
				$npassword = mysqli_real_escape_string($link,$npassword);
				$checkpassword = mysqli_real_escape_string($link,$checkpassword);
				$fn = mysqli_real_escape_string($link,$fn);
				$ln = mysqli_real_escape_string($link,$ln);
				$email = mysqli_real_escape_string($link,$email);
				
				$e = "SELECT email FROM student WHERE email='$email'";
				$ee = mysqli_query($link,$e);
				if(mysqli_num_rows($ee)>0){
					$update_errors['e']= "There is already an account registered with this email";
				}
				if($sem==" "){
					$update_errors['s']= "Please select a semester";
				}
				if($dept==" "){
					$update_errors['d']= "Please select a department";
				}
				if((!empty($opassword) && !ctype_space($opassword))&&((!empty($npassword))&&(!ctype_space($npassword)))&&((!empty($checkpassword))&&(!ctype_space($checkpassword)))){
					$op = "SELECT * from student where login_id = '$loginid'";
					$qop = mysqli_query($link,$op);
					$res = mysqli_fetch_assoc($qop);
					if($opassword!=$res['password']){
						$update_errors['op'] = "Incorrect password";
					}else if($npassword!=$checkpassword){
						$update_errors['np'] = "Passwords do not match";
					}
					if(count($update_errors)==0){
						$query = "UPDATE student set f_name='$fn',l_name='$ln',sem='$sem', dept='$dept', email='$email',password='$npassword' where login_id='$loginid'";
						$result = mysqli_query($link,$query);
						if($result){
							$_SESSION['updatemsg'] = "Profile Updated";
							sleep(5);
							header('location:studenthome.php');
						}else{
							die(mysqli_error($link));
						}
					}
				}else if(count($update_errors)==0){
					$query = "UPDATE student set f_name='$fn',l_name='$ln',sem='$sem', dept='$dept', email='$email' where login_id='$loginid'";
					$result = mysqli_query($link,$query);
					if($result){
						$_SESSION['updatemsg'] = "Profile Updated";
						sleep(5);
						header('location:studenthome.php');
					}else{
						die(mysqli_error($link));
					}
				}
			}
		}else{
			echo "<script>alert('All fields are required')</script>";
			die();
		}
	}
?>
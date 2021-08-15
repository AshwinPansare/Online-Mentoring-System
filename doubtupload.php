<?php
	session_start();
	if(isset($_POST['upload'])){
		$mid = $_SESSION['dmid'];
		$errors = array();
		$pdate = date('Y-m-d');
		$dt = $_POST['dt'];
		$ques = $_POST['ques'];
		$dt = trim($dt);
		$ques = trim($ques);
		$loginid = $_SESSION['sloginid'];
		
		//checking file errors
		$file = $_FILES['qfile'];
		$fileName = $_FILES["qfile"]["name"];
		$fileTmpName = $_FILES["qfile"]["tmp_name"];
		$fileSize = $_FILES["qfile"]["size"];
		$fileError = $_FILES["qfile"]["error"];
		$fileType = $_FILES["qfile"]["type"];
		
		$fileExt = explode(".",$fileName);
		$fileActualExt = strtolower(end($fileExt));
		
		$allowed = array("jpg","jpeg","png","pdf");
		
		if($fileSize!=0){
			if(in_array($fileActualExt,$allowed)==false){
				$errors['ftype'] = "File type not supported! Please upload an image or pdf";
			}
			if($fileError!=0){
				$errors['u'] = "There was an error uploading your file";
			}
			if($fileSize > 5000000){
				$errors['fsize'] = "File too big! File size upto 500KB allowed";
			}
		}
		
		//input errors
		if(empty($dt)){
			$errors['t'] = "Title is required";
		}else if(empty($ques)&&($fileSize==0)){
			$errors['q'] = "Question either as text or file required";
		}
		if(count($errors)==0){
			$host = "localhost";
			$dbUsername = "root";
			$dbPassword = "root";
			$dbName = "mentoring_system";
			$link = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
			if(mysqli_connect_error()){
				die("There was an error connecting to the database");
			}else{
				$query = "SELECT s_id from student where login_id='$loginid'";
				$result = mysqli_query($link,$query);
				$row = mysqli_fetch_array($result);
				$sid = $row['s_id'];
				if($fileSize!=0){
				$fileNameNew = $sid."_".$mid."_".date('d').date('m').date('Y').".".$fileActualExt;
				$fileDestination = "doubts/".$fileNameNew;
				$fileNameNew = mysqli_real_escape_string($link,$fileNameNew);
				}
				$dt = mysqli_real_escape_string($link,$dt);
				$ques = mysqli_real_escape_string($link,$ques);
				if(isset($fileNameNew)){
					$query = "INSERT Into doubt(title,qfile,ques,s_id,posted,m_id) VALUES('$dt','$fileNameNew','$ques','$sid','$pdate','$mid')";
				}else{
					$query = "INSERT Into doubt(title,ques,s_id,posted,m_id) VALUES('$dt','$ques','$sid','$pdate','$mid')";
				}
				$result = mysqli_query($link,$query);
				if(!$result){
					$errors['u'] = "There was a error uploading the assignment";
				}else{
					if($fileSize!=0){
					move_uploaded_file($fileTmpName,$fileDestination);
					}
					echo '<script>alert("Doubt sent")</script>';
				}
			}
		}	
	}
?>
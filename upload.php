<?php
	session_start();
	if(isset($_POST['upload'])){
		if(isset($_SESSION['sid'])){
			$sid = $_SESSION['sid'];
		}
		$errors = array();
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$pdate = date('Y-m-d');
		$edate = $_POST['deadline'];
		$entered = explode("-",$edate);
		$eyear = $entered[0];
		$emonth = $entered[1];
		$eday = $entered[2];
		$quest = $_POST['quest'];
		$ques = $_POST['ques'];
		$quest = trim($quest);
		$ques = trim($ques);
		$loginid = $_SESSION['mloginid'];
		
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
		if(empty($quest)){
			$errors['t'] = "Title is required";
		}else if(empty($ques)&&($fileSize==0)){
			$errors['q'] = "Assignment question either as text or file required";
		}else if(($eyear<$year)||($eyear==$year && $emonth<$month)||($eyear==$year && $emonth==$month && $eday<$day)){
			$errors['d'] = "You can't enter a deadline before today";
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
				$query = "SELECT m_id from mentor where login_id='$loginid'";
				$result = mysqli_query($link,$query);
				$row = mysqli_fetch_array($result);
				$mid = $row['m_id'];
				if($fileSize!=0){
				$fileNameNew = $_POST['quest']."_".$mid."_".$day.$month.$year.".".$fileActualExt;
				$fileDestination = "questions/".$fileNameNew;
				$fileNameNew = mysqli_real_escape_string($link,$fileNameNew);
				}
				$quest = mysqli_real_escape_string($link,$quest);
				$ques = mysqli_real_escape_string($link,$ques);
				if(isset($fileNameNew)){
					$query = "INSERT Into assignment(title,qfile,ques,m_id,posted,deadline) VALUES('$quest','$fileNameNew','$ques','$mid','$pdate','$edate')";
				}else{
					$query = "INSERT Into assignment(title,ques,m_id,posted,deadline) VALUES('$quest','$ques','$mid','$pdate','$edate')";
				}
				$result = mysqli_query($link,$query);
				if(!$result){
					$errors['u'] = "There was a error uploading the assignment";
				}else{
					if($fileSize!=0){
					move_uploaded_file($fileTmpName,$fileDestination);
					}
					if(isset($fileNameNew)){
						$query = "SELECT a_id from assignment where qfile = '$fileNameNew'";
						$result = mysqli_query($link,$query);
						$row = mysqli_fetch_array($result);
						$aid = $row['a_id'];
					}else{
						$query = "SELECT a_id from assignment where title = '$quest' and posted = '$pdate' and m_id = '$mid'";
						$result = mysqli_query($link,$query);
						$row = mysqli_fetch_array($result);
						$aid = $row['a_id'];
					}
					if(isset($sid)){
						$query = "insert into completes(a_id,s_id) values('$aid','$sid')";
						$result = mysqli_query($link,$query);
						if($result){
							$_SESSION['success'] = "Assignment sent";
							sleep(2);
							header('location: student-info.php?s='.$sid);
						}else{
							die("There was problem sending the assignment");
						}
					}else{
						$_SESSION['maid'] = $aid;
						header('location: sendtostudents.php');
					}
				}
			}
		}	
	}
?>
<?php
/*	if(isset($_POST['upload'])){
		$errors = array();
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$edate = $_POST['deadline'];
		$entered = explode("-",$edate);
		$eyear = $entered[0];
		$emonth = $entered[1];
		$eday = $entered[2];
		$quest = $_POST['quest'];
		$ques = $_POST['ques'];
		
		
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
		if(empty($quest)){
			$errors['t'] = "Title is required";
		}else if(empty($ques)&&($fileSize==0)){
			$errors['q'] = "Assignment question either as text or file required";
		}else if(($eyear<$year)||($eyear==$year && $emonth<$month)||($eyear==$year && $emonth==$month && $eday<$day)){
			$errors['d'] = "You can't enter a deadline before today";
		}
		if(count($errors)==0){
			$host = "localhost";
			$dbUsername = "root";
			$dbPassword = "root";
			$dbName = "mentoring_system";
			$fileNameNew = $_POST['quest'].".".$fileActualExt;
			$fileDestination = "questions/".$fileNameNew;
			$link = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);
			if(mysqli_connect_error()){
				die("There was an error connecting to the database");
			}else{
				$query = "INSERT Into assignment(title,qfile,ques,m_id,deadline) VALUES('$quest','$fileNameNew','$ques','1','$edate')";
				$result = mysqli_query($link,$query);
				if(!$result){
					die(mysqli_error($link));
				}else{
					move_uploaded_file($fileTmpName,$fileDestination);
					echo "Assignment has been created";
				}
			}
		}	
	}*/
?>
<?php	
	session_start();
	$iloginid = $_SESSION['aloginid'];
	if(isset($_POST['adds'])){
		$rawsloginid = $_POST['rawsloginid'];
		$trimmed = trim($rawsloginid);
		$loginidlist = array();
		$loginidlist = explode(",",$trimmed);
		$loginid = array();
		for($i=0;$i<count($loginidlist);$i++){
			$loginid[$i] = trim($loginidlist[$i]);
		}
		//print_r($loginid);
		if(count($loginid)==0||$loginid[0]==" "){
			$_SESSION['empty'] = "Please enter atleast one login id";
			header('location: adminhome.php');
		}else{
			$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
			if(mysqli_connect_error()){
				die("There was an error connecting to the database");
			}else{
				$query = "SELECT * from institute where login_id='$iloginid'";
				$result = mysqli_query($link,$query);
				if($result){
					$row = mysqli_fetch_assoc($result);
					$i_id=$row['i_id'];
					for($i=0;$i<count($loginidlist);$i++){
						if(!ctype_space($loginid[$i])){
							$id = mysqli_real_escape_string($link,$loginid[$i]);
							$query = "INSERT INTO student(login_id,i_id) VALUES('$id','$i_id')";
							$result = mysqli_query($link,$query);
							if($result){
								$_SESSION['sadded'] .= "Added ".$id." ";
							}else{
								$_SESSION['snotadded'] .= "Couldn't add ".$id." ";
							}
						}
					}
					header('location: adminhome.php');
				}else{
					die(mysqli_error($link));
				}
			}
		}
	}
?>
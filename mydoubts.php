<?php 
	session_start();
	if((isset($_SESSION['sloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Student.php');
	}
	$loginid = $_SESSION['sloginid'];
?>
<!doctype html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Doubts</title>
	<style type="text/css">
		body{
			background-color: #F9F4F4;  
		}
		.previcon{
			position:relative;
			top:-2px;
		}
		.list-group{
			width:50%;
		}
		.top{
			width:70%;
			border-radius:10px;
			margin-left: 15%;
			position:fixed;
			top:0px;
			z-index:1;
		}
		.main{
			margin-top:100px;
		}
		.file{
			width:250px;
			height:50px;
			border: 1px black solid;
			border-radius:5px;
		}
		.ext{
			width:50px;
			height:50px;
			background-color:red;
			font-size:130%;
			line-height:50px;
		}
		.question{
			height:1.25em;
			width:90%;
			overflow:hidden;
		}
		.small{
			font-size:80%;
		}
		.list{
			width:50%;
		}
		.block{
			position:relative;
			padding: 20px;
			border-radius:8px;
		}
		.block .overlay{
		  position:absolute;
		  left:0;
		  top:0;
		  bottom:0;
		  right:0;
		  border-radius:8px;
		  background-color:white;
		}
		.block .inner{
			pointer-events: none;
			position:relative;
			z-index:1;
		}
		.block .inner a{
			pointer-events: all;
			text-decoration:none;
			position:relative;
		}
		.block .inner a:hover{
			opacity:0.5;
			text-decoration:none;
		}
		.block .overlay:hover {
		  background-color: #efefef;
		}
		
	</style>
	</head>
	<body>
		<div class="top p-2 text-center text-white mb-2 bg-secondary">
			<p><h3>All Doubts</h3></p>
		</div>
		
		<div class="main">
			<div class="list mx-auto mt-5">
				<?php
					$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
					if(mysqli_connect_error()){
						die("There was an error connecting to the database");
					}else{
						$query = "SELECT * FROM student WHERE login_id='$loginid'" ;
						$student = mysqli_query($link,$query);
						if($student){
							$srow = mysqli_fetch_assoc($student);
							$sid = $srow['s_id'];
							$query = "SELECT * from doubt where s_id='$sid'";
							$result = mysqli_query($link,$query);
							while($drow = mysqli_fetch_assoc($result)){
								$did=$drow['d_id'];
								echo '<div class="block mb-3">';
								echo '<a class="overlay" href="sviewdoubt.php?d='.$did.'"></a>';
								echo '<div class="inner">';
								echo '<div class="d-flex w-100 justify-content-between mb-3">';
								echo '<h5 class="mb-1">'.$drow['title'].'</h5>';
								if(!is_null($drow['answer'])){
									echo '<span class="ms-auto small">Anwered</span>';
								}
								echo '</div><hr>';
								if(!is_null($drow['qfile'])){
								echo '<a href="doubts/'.$drow['qfile'].'" target="_blank" class="mb-1 file d-inline-flex align-items-center">';//open the file
								$fileType = explode(".",$drow['qfile']);//pdf or img
								$fileType = end($fileType);
								if($fileType=="jpg" || $fileType=="jpeg" || $fileType=="png"){
									$fileType="img";
								}
								echo '<div class="ext mx-2 text-white text-center">'.strtoupper($fileType).'</div>';
								echo $drow['title'];
								echo '</a>';
								}
								echo '<div class="question text-truncate mb-1">';
								echo $drow['ques'];
								echo '</div>';
								echo '</div>';
								echo '</div>';
							}
						}else{
							die(mysqli_error());
						}
					}
				?>
				</div>
			</form>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
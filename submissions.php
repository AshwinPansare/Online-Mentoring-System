<?php
	session_start();
	$aid = $_SESSION['mvaid'];
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid = $_SESSION['mloginid'];
	$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
	$query = "select * from completes where a_id='$aid'";
	$student = mysqli_query($link,$query);
	$query = "select count(*) as c from completes where a_id='$aid'";
	$result = mysqli_query($link,$query);
	$crow = mysqli_fetch_assoc($result);
	$c = $crow['c'];
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<title>Assignments</title>
		<style type="text/css">
			.top{
				width:70%;
				border-radius:10px;
			}
			.card{
				height:100px;
			}
			.card-body{
				margin:0 15px;
				padding:0;
			}
			.card-title{
				display:none;
				margin:0;
			}
			.name{
				font-size:150%;
			}
			small{
				font-size:80%;
				margin-top:20px;
			}
			.form-check-input{
				margin-top: 13px;
			}
			h4{
				margin:0;
			}
		</style>
	</head>
	
	<body class="mx-3">
		<div class="top mx-auto text-center text-white bg-secondary p-2">
		<p><h3>Submissions</h3></p>
		</div>
		<hr>
		<div class="main mt-4">
		<div class="d-flex flex-wrap">
			<?php
				for($i=0;$i<$c;$i++)
				{
					$row = mysqli_fetch_assoc($student);
					$sid = $row['s_id'];
					$query = "SELECT * from student where s_id='$sid'";
					$res = mysqli_query($link,$query);
					$srow = mysqli_fetch_assoc($res);
					echo '<div class="col-sm-12 col-md-6 col-lg-4">';
					echo '<div class="card bg-light mb-2 mx-2">';
					echo '<div class="card-title"></div>';
					echo '<div class="card-body">';
					echo '<div class="d-flex">';
					echo '<div class="name d-inline-flex flex-wrap">';
					echo $srow['f_name'].' '.$srow['l_name'];
					echo '</div>';
					
					if(!is_null($row['answer'])){
						echo '<span class="ms-auto small">Submitted on '.date('d-m-Y',strtotime($row['sub_date'])).'</span>';
						echo '</div>';
						echo '<div class="d-flex flex-wrap">';
						echo '<a class="text-truncate" href="'.$row['answer'].'" target="_blank">'.$row['answer'].'</a>';
						echo '</div>';
					}
					else{
						echo '<span class="ms-auto small">Pending</span>';
						echo '</div>';
					}
					echo '<small>'.$srow['dept'].'  Sem'.$srow['sem'].'</small>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
			?>
		</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
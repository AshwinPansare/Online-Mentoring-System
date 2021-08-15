<?php
	session_start();
	$aid = $_SESSION['maid'];
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid = $_SESSION['mloginid'];
	$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
	$query = "SELECT * from mentor where login_id='$loginid'";
	$result = mysqli_query($link,$query);
	$mrow = mysqli_fetch_array($result);
	$mid = $mrow['m_id'];
	$code = $mrow['sub_code'];
	$miid = $mrow['i_id'];
	$query = "select sem,dept from subject where sub_code='$code'";
	$result = mysqli_query($link,$query);
	$row = mysqli_fetch_assoc($result);
	$mdept = $row['dept'];
	$msem = $row['sem'];
	$query = "select * from student where i_id = '$miid' and dept = '$mdept' and sem = '$msem'";
	$student = mysqli_query($link,$query);
	$query = "select count(*) as c from student where i_id = '$miid' and dept = '$mdept' and sem = '$msem'";
	$result = mysqli_query($link,$query);
	$row = mysqli_fetch_assoc($result);
	$c = $row['c'];
	if(isset($_POST['send'])){
		for($i=0;$i<$c;$i++)
		{
			$s = 's'.$i;
			if(isset($_POST[$s])){
				$sid = $_POST[$s];
				$query = "INSERT into completes(s_id,a_id) values('$sid','$aid')";
				$result = mysqli_query($link,$query);
			}
		}
		if($result){
			$_SESSION['success'] = "Assignment sent";
			header('location: assignment.php');
		} else{
			die("There was problem sending the assignment");
		}
	}
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
		<p><h3>Assignment</h3></p>
		</div>
		<?php
			if(isset($_SESSION['success'])){
				echo "<div class='text-center text-success'".$_SESSION['success']."</div>";
				unset($_SESSION['success']);
			}
		?>
		<div class="mx-auto text-center mt-5 mb-3">
		<h4>Add students to assign</h4>
		<br>
		(Select the students to whom the assignment is to be sent)
		</div>
		<hr>
		<form action="sendtostudents.php" method="post">
		<div class="d-flex justify-content-end">
		<input type="submit" class="btn btn-primary" name="send" value="Done">
		</div>
		<div class="main mt-4">
		<div class="d-flex flex-wrap">
			<?php
				for($i=0;$i<$c;$i++)
				{
					$srow = mysqli_fetch_assoc($student);
					echo '<div class="col-sm-12 col-md-6 col-lg-4">';
					echo '<div class="card bg-light mb-2 mx-2">';
					echo '<div class="card-title"></div>';
					echo '<div class="card-body">';
					echo '<div class="d-flex">';
					echo '<div class="name d-inline-flex flex-wrap">';
					echo $srow['f_name'].' '.$srow['l_name'];
					echo '</div>';
					echo '<input class="form-check-input ms-auto" type="checkbox" name="s'.$i.'" value="'.$srow['s_id'].'">';
					echo '</div>';
					echo '<small>'.$srow['dept'].' '.$srow['sem'].'</small>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
			?>
		</div>
		</div>
		</form>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
	
</html>
<?php
	session_start();
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid = $_SESSION['mloginid'];
	if(isset($_SESSION['mdid'])){
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		$did = $_SESSION['mdid'];
	}else if(isset($_GET['d'])){
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{
			$did = $_GET['d'];
			$_SESSION['mdid']=$did;
			//echo $a_id;
		}
	}else{
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<title>Assignment Details</title>
	<style type="text/css">
		.top{
			font-size: 200%;
			font-weight: 400;
			margin-left: 30px;
			width: 600px;
		}
		.left{
			margin-left: 20px;
			width:600px;
		}
		.right{
			margin:40px 60px;
		}
		.right .card{
			width:500px;
		}
		.details{
			font-size:50%;
		}
		.doubt{
			width: 600px;
			margin-left: 30px;
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
		a{
			text-decoration:none;
		}
		a:hover{
			opacity:0.7;
			text-decoration:none;
		}
	</style>
	</head>
	<body>
		<?php
			if(isset($_SESSION['error'])){
				echo "<div class='text-danger text-center'>".$_SESSION['error']."</div>";
				unset($_SESSION['error']);
			}
			if(isset($_SESSION['success'])){
				echo "<div class='text-success text-center'>".$_SESSION['success']."</div>";
				unset($_SESSION['success']);
			}
		?>
		<a class="btn m-3" data-bs-toggle="offcanvas" href="#offcanvasL" role="button" aria-controls="offcanvasL">
		  <span class="material-icons">menu</span>
		</a>
		<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasL" aria-labelledby="offcanvasLabel">
		  <div class="offcanvas-header">
			<h3 class="offcanvas-title" id="offcanvasLabel">Menu</h3>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		  </div>
		  <div class="offcanvas-body text-center mt-5">
			<ul type="none">
			<h5>
			<li class="mb-3"><a href="mentorhome.php">Back to home</a></li>
			<li class="mb-3"><a href="assignment.php">All assignments</a></li>
			</h5>
			</ul>
		  </div>
		</div>
		
		<div class="main d-flex m-3">
			<div class="left">
			<?php
				$query = "SELECT * from doubt where d_id = '$did'";
				$result=mysqli_query($link,$query);
				if(!$result){
					die("Could not find doubt!");
				}else{
					$row=mysqli_fetch_assoc($result);
				}
				$mid = $row['m_id'];
				$sid = $row['s_id'];
				$query = "SELECT * from mentor where m_id = '$mid'";
				$mentor = mysqli_query($link,$query);
				$mrow = mysqli_fetch_assoc($mentor);
				$query = "SELECT f_name,l_name from student where s_id='$sid'";
				$result = mysqli_query($link,$query);
				$srow = mysqli_fetch_assoc($result);
				echo '<div class="top mb-3">';
				echo $row['title'];
				echo '<div class="d-flex details mt-3">';
				echo '<div class="text-muted">'.$srow['f_name'].' '.$srow['l_name'].'<span class="ps-5">'.date('d-m-Y',strtotime($row['posted'])).'</span></div>';
				if(!is_null($row['answer'])){
					echo '<div class="ms-auto">Answered</div>';
				}
				echo '</div>';
				echo '<hr>';
				echo '</div>';
				echo '<div class="doubt">';
				echo '<p>'.nl2br($row['ques']).'</p>';
				if(!is_null($row['qfile'])){
				echo '<a href="doubts/'.$row['qfile'].'" target="_blank" class="mb-1 file d-inline-flex align-items-center">';
				$fileType = explode(".",$row['qfile']);//pdf or img
				$fileType = end($fileType);
				if($fileType=="jpg" || $fileType=="jpeg" || $fileType=="png"){
					$fileType="img";
				}
				echo '<div class="ext mx-2 text-white text-center">'.strtoupper($fileType).'</div>';
				echo $row['title'];
				echo '</a>';
				}
				echo '</div>';
				echo '</div>';
			?>
			
			<div class="right ms-auto">
			<div class="card text-center">
			  <div class="card-body">
				<h5 class="card-title">Reply</h5>
					<?php
					if(is_null($row['answer'])){
						echo '<form action="submitanswer.php" method="post">';
						echo '<div class="card-text">Enter your reply</div>';
						echo '<textarea class="form-control" id="answer" name="answer" rows="7"></textarea>';
						echo '<button id="sub" type="submit" class="btn btn-primary mt-2" name="done">Submit</button>';
						echo '</form>';
					}else{
						echo '<div class="card-text">'.nl2br($row['answer']).'</div>';
					}
				?>
			  </div>
			</div>
			</div>
		</div>
		<?php
			/*if(isset($_POST['assg'])){
				$a_id = $_POST['assg'];
				echo $a_id;
			}*/
		?>
		<script type="text/javascript">
		</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
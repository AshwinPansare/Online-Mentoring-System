<?php
	session_start();
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid = $_SESSION['mloginid'];
	$link = mysqli_connect('localhost','root','root','mentoring_system'); 
	$query = "SELECT * from mentor where login_id = '$loginid'";
	$mentor = mysqli_query($link,$query);
	if($mentor){
		if(mysqli_num_rows($mentor)==0){
			header('location: Mentor.php');
		}else{
			$mrow = mysqli_fetch_assoc($mentor);
		}
	}else{
		die(mysqli_error($link));
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
	<title>Mentoring System</title>
	<style type="text/css">
		.card1{
			display:inline-block;
		}
		@media screen and (max-width: 1206px){
			.card1{
				float:none!important;
			}
		}
		.result{
			height:290px;
			overflow:auto;
			min-width:250px;
			text-align:center;
			position:absolute;
			left:20px;
			z-index:1;
		}
		.text-success{
			width:250px;
			padding:10px;
			background-color:#D1E7DD;
			margin:0px auto;
		}
		.list{
			width:500px;
			display:inline-block;
			position:relative;
			top:-150px;
			left:-90px;
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
		.block .inner a:hover{
			opacity:0.5;
			text-decoration:none;
		}
		.block .overlay:hover {
		  background-color: #efefef;
		}
		.small{
			font-size:80%;
		}
	</style>
	</head>
	<body>
		<div class="container mb-5">
			<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
				<div class="container-fluid">
					<span class="navbar-brand mb-0 h1">Online Mentoring System</span>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav me-auto mb-2 mb-lg-0">
							<li class="nav-item">
							  <a class="nav-link active" aria-current="page" href="">Home</a>
							</li>
							<li class="nav-item">
							  <a class="nav-link text-primary" href="https://vesit.ves.ac.in/" target="_blank">Go to your college website</a>
							</li>
							<li class="nav-item">
							  <a class="nav-link text-primary" href="assignment.php">Assignment</a>
							</li>
						</ul>
						<ul class="navbar-nav ml-auto">
							<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="" id="navbardd" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="userh.png" width="30px" height="30px">
							<?php echo $loginid; ?>
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbardd">
								<li><a class="dropdown-item" href="menviewprofile.php">View profile</a></li>
								<li><a class="dropdown-item" href="mentorlogout.php">Logout</a></li>
							</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		
		<div class="mx-auto text-center">
		<?php
			if(isset($_SESSION['success'])){
				echo "<div class='text-success text-center'>".$_SESSION['success']."</div>";
				unset($_SESSION['success']);
			}
			if(isset($_SESSION['updatemsg'])){
				echo "<div class='text-success text-center'>".$_SESSION['updatemsg']."</div>";
				unset($_SESSION['updatemsg']);
			}
		?>
		</div>
		<div id="cards" class="mx-5">
		
			
			<div class="card text-center card1 float-end mb-3" style="width: 18rem;">
			  <div class="card-body">
				<h5 class="card-title">Search Students</h5>
				<div class="card-text">Enter the name of the student to search</div>
				<input type="text" class="form-control" id="name" name="name" onkeyup="searchnm()" placeholder="Enter name Eg.abc xyz" required autocomplete="off">
			  </div>
			  <div class="list-group result"></div>
			</div>
			<div class="card text-center d-inline-flex mb-3" style="width: 18rem;">
			  <div class="card-body">
				<h5 class="card-title">Chat</h5>
				<p class="card-text">Enter in a chat with a student</p>
				<a href="http://localhost:4000" class="btn btn-primary">Go</a>
			  </div>
			</div>
			<br>
			<div class="card text-center d-inline-flex mb-3" style="width: 18rem;">
			  <div class="card-body">
				<h5 class="card-title">Meet</h5>
				<?php
					if(($mrow['meetlink'])=="https://meet.google.com"){
						echo '<form action="mentormeet.php" method="post">';
						echo '<p class="card-text">Click on the below link to go to the Google Meet home page.<br>Click on <span class="fw-bold">New meeting->Create a meeting for later</span>.<span class="text-info">Copy the link and paste it here.</span><br>(You can then use it as your personal meet link for scheduling meeting with the students.)</p>';
						echo '<a href="https://meet.google.com" target="_blank">Google Meet</a>';
						echo '<input type="text" class="form-control my-2" id="meet" name="meet" autocomplete="off">';
						echo '<button type="submit" name="update" class="btn btn-primary">Update</button>';
						echo '</form>';
					}else{
						echo '<p class="card-text">Start a meeting with a student on Google meet with your personal meet link</p>';
						echo '<a href="'.$mrow['meetlink'].'" class="btn btn-primary">Start</a>';
					}
				?>
			  </div>
			</div>
			
			
			<div class="float-end">
				<div class="list mx-auto">
				<div class="text-center mb-3">
				<h3>Doubts</h3>
				</div>
					<?php
						$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
						if(mysqli_connect_error()){
							die("There was an error connecting to the database");
						}else{
							$query = "SELECT * FROM mentor WHERE login_id='$loginid'" ;
							$mentor = mysqli_query($link,$query);
							if($mentor){
								$mrow = mysqli_fetch_assoc($mentor);
								$mid = $mrow['m_id'];
								$query = "SELECT * from doubt where m_id = '$mid'";
								$assigned = mysqli_query($link,$query);
								while($drow=mysqli_fetch_assoc($assigned)){
									$did = $drow['d_id'];
									$sid = $drow['s_id'];
									$query = "SELECT f_name,l_name from student where s_id='$sid'";
									$result = mysqli_query($link,$query);
									$srow = mysqli_fetch_assoc($result);
									echo '<div class="block mb-3">';
									echo '<a class="overlay" href="mviewdoubt.php?d='.$did.'"></a>';
									echo '<div class="inner">';
									echo '<div class="d-flex w-100 justify-content-between mb-3">';
									echo '<h5 class="mb-1">'.$drow['title'].'</h5>';
									if(isset($drow['answer'])){
										echo '<small class="text-muted">Answered</small>';
									}
									//echo '<small class="text-muted">Due '.date('d-m-Y',strtotime($row[deadline])).'</small>';
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
									echo '<small>'.$srow['f_name'].' '.$srow['l_name'].'<span class="ps-3">'.$drow['posted'].'</span></small>';
									echo '</div>';
									echo '</div>';
								}
							}else{
								die(mysqli_error());
							}
						}
					?>
				</div>
			</div>
			
		</div>
		
			<script type="text/javascript">
				function searchnm(){
					var entered = $("input[name='name']").val();
					if(entered.length){
						$.post("search.php", {enteredTxt : entered},function(data){
							$(".result").html(data);
						});
					}else{
						$(".result").html("");
					}
				}
			</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
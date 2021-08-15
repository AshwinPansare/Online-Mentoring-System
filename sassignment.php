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
	<title>Assignments</title>
	<style type="text/css">
		body{
			background-color: #F9F4F4;  
		}
		#back{
			margin-right:320px;
			margin-left:50px;
			margin-top:10px;
		}
		.previcon{
			position:relative;
			top:-2px;
		}
		@media screen and (min-width: 1076px){
		.controls-top{
			width:800px;
			margin:10px auto;
			position:relative;
			top:-55px;
		}
		}
		@media screen and (min-width: 817px) and (max-width: 1075px){
		.controls-top{
			width:800px;
			margin:10px auto;
		}
		}
		@media screen and (min-width: 615px) and (max-width: 816px){
		.controls-top{
			width:600px;
			margin:10px auto;
		}
		}
		@media screen and (max-width: 614px){
		.controls-top{
			width:495px;
			margin:10px auto;
		}
		}
		.list-group{
				width:50%;
		}
		.top{
			width:70%;
			border-radius:10px;
			margin-left: 15%;
			position:fixed;
			top:70px;
			z-index:1;
		}
		.main{
			margin-top:60px;
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
		a{
			text-decoration:none;
		}
		a:hover{
			background:white;
			opacity:0.7;
			text-decoration:none;
		}
	</style>
	</head>
	<body>
		
		<div id="myCarousel" class="carousel slide carousel-slide" data-bs-interval="false">
			<a class="btn btn-secondary" id="back" href="studenthome.php"><span class="previcon"><img src="previous.png" width="15px" height="15px"></span>Back</a>
                
			<div class="controls-top align-middle text-center bg-light p-3">
				<a class="btn-floating btn-secondry p-2 featured_text" href="#myCarousel" data-bs-slide-to="0" style="background: none 0% 0% repeat scroll rgb(14,23,49);color: rgb(255, 255,255);">To do</a>
                <a class="btn-floating btn-secondry p-2 featured_text" href="#myCarousel" data-bs-slide-to="1" style="background: none 0% 0% repeat scroll rgb(14,23,49);color: rgb(255, 255, 255);">Done</a>
	
            </div>
            <div class="carousel-inner">
				<div class="carousel-item active">
					<div class="top p-2 text-center text-white mb-2 bg-secondary">
					<p><h3>Assigned</h3></p>
					</div>
					
					<div class="main">
					<form action="assgdetails.php" method="post">
					<div class="list-group mx-auto mt-5">
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
									$query = "SELECT * from completes where s_id = '$sid' and sub_date is null";
									$assigned = mysqli_query($link,$query);
									while($row = mysqli_fetch_assoc($assigned)){
										$query = "SELECT * from assignment where a_id = '$row[a_id]'";
										$assg = mysqli_query($link,$query);
										$arow = mysqli_fetch_assoc($assg);
										$query = "SELECT * from mentor where m_id = '$arow[m_id]'";
										$mentor = mysqli_query($link,$query);
										$mrow = mysqli_fetch_assoc($mentor);
										echo '<button type="submit" class="list-group-item list-group-item-action mb-3" name="assg" value="'.$row['a_id'].'">';
										echo '<div class="d-flex w-100 justify-content-between mb-3">';
										echo '<h5 class="mb-1">'.$arow['title'].'</h5>';
										if((date('Y-m-d')>$arow['deadline'])==1){
											echo '<small class="text-danger">Missing</small>';
										}else{
											echo '<small class="text-muted">Due '.date('d-m-Y',strtotime($arow['deadline'])).'</small>';
										}
										echo '</div><hr>';
										if(isset($arow['qfile'])){
										echo '<a href="questions/'.$arow['qfile'].'" target="_blank" class="mb-1 file d-inline-flex align-items-center">';//open the file
										$fileType = explode(".",$arow['qfile']);//pdf or img
										$fileType = end($fileType);
										if($fileType=="jpg" || $fileType=="jpeg" || $fileType=="png"){
											$fileType="img";
										}
										echo '<div class="ext mx-2 text-white text-center">'.strtoupper($fileType).'</div>';
										echo $arow['title'];
										echo '</a>';
										}
										echo '<div class="question text-truncate mb-1">';
										echo $arow['ques'];
										echo '</div>';
										echo '<small>'.$mrow['name'].'<span class="ps-3">'.$arow['posted'].'</span></small>';
										echo '</button>';
									}
								}else{
									die(mysqli_error());
								}
							}
						?>
					</div>
					</form>
					</div>
				</div>
				<div class="carousel-item">
					<div class="top p-2 text-center text-white mb-2 bg-secondary">
					<p><h3>Submissions</h3></p>
					</div>
					
					<div class="main">
					<form action="assgdetails.php" method="post">
					<div class="list-group mx-auto mt-5">
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
									$query = "SELECT * from completes where s_id = '$sid' and sub_date is not null";
									$assigned = mysqli_query($link,$query);
									while($row = mysqli_fetch_assoc($assigned)){
										$query = "SELECT * from assignment where a_id = '$row[a_id]'";
										$assg = mysqli_query($link,$query);
										$arow = mysqli_fetch_assoc($assg);
										$query = "SELECT * from mentor where m_id = '$arow[m_id]'";
										$mentor = mysqli_query($link,$query);
										$mrow = mysqli_fetch_assoc($mentor);
										echo '<button type="submit" class="list-group-item list-group-item-action mb-3" name="assg" value="'.$row['a_id'].'">';
										echo '<div class="d-flex w-100 justify-content-between mb-3">';
										echo '<h5 class="mb-1">'.$arow['title'].'</h5>';
										echo '<small class="text-muted">Done</small>';
										echo '</div><hr>';
										if(isset($arow['qfile'])){
										echo '<a href="questions/'.$arow['qfile'].'" target="_blank" class="mb-1 file d-inline-flex align-items-center">';//open the file
										$fileType = explode(".",$arow['qfile']);//pdf or img
										$fileType = end($fileType);
										if($fileType=="jpg" || $fileType=="jpeg" || $fileType=="png"){
											$fileType="img";
										}
										echo '<div class="ext mx-2 text-white text-center">'.strtoupper($fileType).'</div>';
										echo $arow['title'];
										echo '</a>';
										}
										echo '<div class="question text-truncate mb-1">';
										echo $arow['ques'];
										echo '</div>';
										echo '<small>'.$mrow['name'].'<span class="ps-3">'.$arow['posted'].'</span></small>';
										echo '</button>';
									}
								}else{
									die(mysqli_error());
								}
							}
						?>
					</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(window).scroll(function() {
				if ( $(window).scrollTop() >= 30 &&  $(window).scrollTop() < 60) {
					$('.top').css('top','40px');
				} else if($(window).scrollTop() >= 60) {
					$('.top').css('top','0');
				}else {
					$('.top').attr('style', '');

				}
			});
		</script>
		<!--<button id="w" >Get width</button>
		<script>
			$("#w").click(function(){
				alert($(window).width());
			});
			
		</script>-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
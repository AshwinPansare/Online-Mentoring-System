<?php
	include('upload.php');
	if((isset($_SESSION['mloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Mentor.php');
	}
	$loginid = $_SESSION['mloginid'];
	$sid = $_GET['s'];
	$_SESSION['sid']=$sid;
?>
<!doctype html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Student</title>
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
		.cont{
			border-radius:10px;
			border:blue 1px solid;
			position:relative;
			top:25%;
			left:25%;
		}
		.list-group{
				width:50%;
		}
		.top{
			width:70%;
			border-radius:10px;
			margin-left: 15%;
			position:fixed;
			top:120px;
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
		button a{
			text-decoration:none;
		}
		button a:hover{
			opacity:0.7;
			text-decoration:none;
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
		<?php
			if(isset($_SESSION['success'])){
				echo "<div class='text-center text-success'".$_SESSION['success']."</div>";
				unset($_SESSION['success']);
			}
			$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
			$query = "SELECT * from student where s_id='$sid'";
			$result = mysqli_query($link,$query);
			$row = mysqli_fetch_assoc($result);
			echo '<div class="text-center">';
			echo '<h4 class="text-info fw-normal">'.$row['f_name'].' '.$row['l_name'].'<span class="ps-5">'.$row['dept'].' '.$row['sem'].'</h4>';
			echo '<div class="text-info">'.$row['email'].'</div>';
			echo '</div>';
		?>
		
		<div id="myCarousel" class="carousel slide carousel-slide" data-bs-interval="false">
			<a class="btn btn-secondary" id="back" href="javascript:history.back()"><span class="previcon"><img src="previous.png" width="15px" height="15px"></span>Back</a>
			
			<div class="controls-top align-middle text-center bg-light p-3">
				
                <a class="btn-floating btn-secondry p-2 featured_text" href="#myCarousel" data-bs-slide-to="0" style="background: none 0% 0% repeat scroll rgb(14,23,49);color: rgb(255, 255,255);">View all assignments</a>
                <a class="btn-floating btn-secondry p-2 featured_text" href="#myCarousel" data-bs-slide-to="1" style="background: none 0% 0% repeat scroll rgb(14,23,49);color: rgb(255, 255,255);">View doubts</a>
				<a class="btn-floating btn-secondry p-2 featured_text" href="#myCarousel" data-bs-slide-to="2" style="background: none 0% 0% repeat scroll rgb(14,23,49);color: rgb(255, 255,255);">Send an Assignment</a>
	
            </div>
            <div class="carousel-inner">
				<div class="carousel-item active">
					<div class="top p-2 text-center text-white mb-2 bg-secondary">
					<p><h3>All assignments</h3></p>
					</div>
					
					<div class="main">
					<form action="massgdetails.php" method="post">
					<div class="list-group mx-auto mt-5">
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
									$query = "SELECT * from assignment where m_id = '$mid'";
									$assigned = mysqli_query($link,$query);
									//$arow=mysqli_fetch_assoc($assigned);
									//$aid = $arow['a_id'];
									//$query = "SELECT * from completes where a_id = '$aid' and s_id='$sid'";
									//$assigned = mysqli_query($link,$query);
									while($arow=mysqli_fetch_assoc($assigned)){
										$aid = $arow['a_id'];
										$query = "SELECT * from completes where a_id = '$aid' and s_id='$sid'";
										$result = mysqli_query($link,$query);
										if(mysqli_num_rows($result)>0){
											$row=mysqli_fetch_assoc($result);
											$aid = $row['a_id'];
											$query = "SELECT * from assignment where a_id = '$aid'";
											$result = mysqli_query($link,$query);
											$arow = mysqli_fetch_assoc($result);
											echo '<button type="submit" class="list-group-item list-group-item-action mb-3" name="assg" value="'.$aid.'">';
											echo '<div class="d-flex w-100 justify-content-between mb-3">';
											echo '<h5 class="mb-1">'.$arow['title'].'</h5>';
											//echo '<small class="text-muted">Due '.date('d-m-Y',strtotime($row[deadline])).'</small>';
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
											echo '<small>'.$mrow['name'].'    '.$arow['posted'].'</small>';
											echo '</button>';
										}
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
					<p><h3>All Doubts</h3></p>
					</div>
					
					<div class="main">
					<div class="list mx-auto mt-5">
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
									$query = "SELECT f_name,l_name from student where s_id='$sid'";
									$result = mysqli_query($link,$query);
									$srow = mysqli_fetch_assoc($result);
									$query = "SELECT * from doubt where m_id = '$mid' and s_id='$sid'";
									$assigned = mysqli_query($link,$query);
									while($drow=mysqli_fetch_assoc($assigned)){
										$did = $drow['d_id'];
										echo '<div class="block mb-3">';
										echo '<a class="overlay" href="mviewdoubt.php?d='.$did.'"></a>';
										echo '<div class="inner">';
										echo '<div class="d-flex w-100 justify-content-between mb-3">';
										echo '<h5 class="mb-1">'.$drow['title'].'</h5>';
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
				<div class="carousel-item">
					<div>
					<div class="cont bg-light w-50 text-center">
						<div class="cont-title">
						<p><h3>Assignment</h3></p>
						<hr>
						</div>
						<div class="question m-3">
							<form action="assignment.php" method="post" enctype="multipart/form-data">
								<div class="mb-3">
								  <label for="qt" class="form-label">Enter assignment title:</label>
								  <input type="text" class="form-control" id="qt" name="quest" placeholder="Enter a concise title for the assignment" autocomplete="off" required>
								  <span class="text-danger"><?php if(isset($errors['t'])){ echo $errors['t'];}?></span>
								</div>
								<div class="mb-3">
								  <label for="ques" class="form-label">Enter the assignment question:</label>
								  <textarea class="form-control" id="ques" name="ques" rows="5"></textarea>
								</div>
								<div class="mb-3">
									<label>
										Set deadline:
										<input type="date" name="deadline" min="<?php echo date('Y-m-d');?>" max="2030-12-31" required>
										<span class="text-danger"><?php if(isset($errors['d'])){ echo $errors['d'];}?></span>
									</label>
								</div>
								<div>
									<div class="d-flex justify-content-evenly flex-wrap align-content-between">
									<input type="file" name="qfile" class="mb-2">
									<input type="submit" name="upload" class="mb-2" value="Upload assignment">
									</div>
									<span class="text-danger mx-auto"><?php if(isset($errors['ftype'])){ echo $errors['ftype'];echo "<br>";}?></span>
									<span class="text-danger mx-auto"><?php if(isset($errors['fsize'])){ echo $errors['fsize'];echo "<br>";}?></span>
									<span class="text-danger mx-auto"><?php if(isset($errors['u'])){ echo $errors['u'];echo "<br>";}?></span>
									<span class="text-danger mx-auto"><?php if(isset($errors['q'])){ echo $errors['q'];echo "<br>";}?></span>
								</div>
							</form>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(window).scroll(function() {
				if ( $(window).scrollTop() >= 30 &&  $(window).scrollTop() < 60) {
					$('.top').css('top','80px');
				}else if( $(window).scrollTop() >= 60 &&  $(window).scrollTop() < 90 ){
					$('.top').css('top','60px');
				}else if( $(window).scrollTop() >= 90 &&  $(window).scrollTop() < 120 ){
					$('.top').css('top','30px');
				}else if($(window).scrollTop() >= 120) {
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
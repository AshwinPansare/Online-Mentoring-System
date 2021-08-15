<?php
	include('doubtupload.php');
	if((isset($_SESSION['sloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Student.php');
	}
	$loginid = $_SESSION['sloginid'];
	if(isset($_GET['m'])){
		$mid = $_GET['m'];
		$_SESSION['dmid'] = $mid;
	}else{
		$mid = $_SESSION['dmid'];
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
	<title>Doubt</title>
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
		.cont{
			border-radius:10px;
			border:blue 1px solid;
			margin-top:4%;
		}
	</style>
	</head>
	
	<body>
		
				<a class="btn btn-secondary" id="back" href="javascript:history.back()"><span class="previcon"><img src="previous.png" width="15px" height="15px"></span>Back</a>
			
				<div>
					<div class="cont bg-light w-50 text-center mx-auto">
						<div class="cont-title">
						<p><h3>Doubt</h3></p>
						<hr>
						</div>
						<div class="question m-3">
							<form action="doubt.php" method="post" enctype="multipart/form-data">
								<div class="mb-3">
								  <label for="dt" class="form-label">Enter a title for the doubt:</label>
								  <input type="text" class="form-control" id="dt" name="dt" placeholder="Enter a concise title for the doubt" autocomplete="off" required>
								  <span class="text-danger"><?php if(isset($errors['t'])){ echo $errors['t'];}?></span>
								</div>
								<div class="mb-3">
								  <label for="ques" class="form-label">Enter your question:</label>
								  <textarea class="form-control" id="ques" name="ques" rows="5"></textarea>
								</div>
								<div class="mb-3">
									<div>
								   <label for="qfile" class="form-label ms-5">Add an attachment for reference if required:</label>
								   <input class="mx-auto" type="file" id="qfile" name="qfile">
								   </div>
								   <span class="text-danger mx-auto"><?php if(isset($errors['ftype'])){ echo $errors['ftype'];echo "<br>";}?></span>
								   <span class="text-danger mx-auto"><?php if(isset($errors['fsize'])){ echo $errors['fsize'];echo "<br>";}?></span>
								   <span class="text-danger mx-auto"><?php if(isset($errors['u'])){ echo $errors['u'];echo "<br>";}?></span>
								   <span class="text-danger mx-auto"><?php if(isset($errors['q'])){ echo $errors['q'];echo "<br>";}?></span>
								</div>
								<div class="mb-3">
									<input type="submit" name="upload" value="Send doubt">
								</div>
							</form>
						</div>
					</div>
				</div>
				
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
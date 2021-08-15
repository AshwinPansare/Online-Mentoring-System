<?php
	session_start();
	if((isset($_SESSION['sloginid']))==false){
		$_SESSION['message']="Please enter your login id and password";
		header('location: Student.php');
	}else{
		$loginid = $_SESSION['sloginid'];
		$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
		if(mysqli_connect_error()){
			die("There was an error connecting to the database");
		}else{	
			$query = "SELECT * FROM student WHERE login_id='$loginid'" ;
			$student = mysqli_query($link,$query);
			if($student){
				if(mysqli_num_rows($student)==0){
					header('location: Student.php');
				}else{
					$row = mysqli_fetch_assoc($student);
					if(is_null($row['f_name'])==true){
						header('location: studentprofile.php');
					}
				}
			}else{
				die(mysqli_error($link));
			}
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
		<title>Mentoring System</title>
		<style type="text/css">
			body{
				background-color: #F9F4F4;  
			}
			.hiddentext{
				display:none;
			}
			.hiddentext1{
				display:none;
			}
			.hiddentext2{
				display:none;
			}
			.hiddentext3{
				display:none;
			}
			.hiddentext4{
				display:none;
			}
			.hiddentext5{
				display:none;
			}
			.hiddentext6{
				display:none;
			}
			.hiddentext7{
				display:none;
			}
			.text-success{
				width:250px;
				padding:10px;
				background-color:#D1E7DD;
				margin:0px auto;
			}
			.nav-link{
				color:#907fa4;
			}
			.navbar-brand{
				
			}
		</style>
	</head>
	<body>
		<div class="container-fluid p-0 mb-5">
		<nav class="navbar navbar-expand-md navbar-light" style="background-color: #e3f2fd;">
			<span class="navbar-brand mx-5 mb-0 h1">Online Mentoring System</span>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			  <span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
			  <ul class="navbar-nav me-auto mx-5 mb-2 mb-lg-0">
				<li class="nav-item ms-4 me-2">
				  <a class="nav-link active" aria-current="page" href="">Home</a>
				</li>
				<li class="nav-item mx-2">
				  <a class="nav-link" href="https://vesit.ves.ac.in/" target="_blank">Go to your college website</a>
				</li>
				<li class="nav-item mx-2">
				  <a class="nav-link" href="sassignment.php">Assignment</a>
				</li>
				<li class="nav-item mx-2">
				  <a class="nav-link" href="mydoubts.php">Doubts</a>
				</li>
				<li class="nav-item mx-2">
					<button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Study Material</button>
				</li>
			   </ul>
			   <ul class="navbar-nav ms-auto me-3">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="" id="navbardd" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<img src="userh.png" width="30px" height="30px">
					<?php echo $_SESSION['sloginid'];?>
				  </a>
				  <ul class="dropdown-menu" aria-labelledby="navbardd">
					<li><a class="dropdown-item" href="stuviewprofile.php">View profile</a></li>
					<li><a class="dropdown-item" href="studentlogout.php">Logout</a></li>
				  </ul>
				</li>
			  </ul>
			</div>
		</nav>
	</div>
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
	<br>
	<?php
		$i_id = $row['i_id'];
		$dept = $row['dept'];
		$sem = $row['sem'];
		$query = "select * from subject where sub_code like concat('$dept','$sem','%') order by sub_code";
		$subject = mysqli_query($link,$query);
		$c = 0;
		while($srow = mysqli_fetch_assoc($subject)){
			$c++;
			$subcode = $srow['sub_code'];
			$query = "select * from mentor where i_id = '$i_id' and sub_code = '$subcode'";
			$mentor = mysqli_query($link,$query);
			if(($c%3)==1){
				echo '<div class="row mx-3 mb-3">';
			}
			echo '<div class="col-sm-4">';
			echo '<div class="card text-center border-secondary h-100">';
			echo '<div class="card-body">';
			echo '<div class="d-flex flex-wrap">';
			echo '<button id="back'.$c.'" class="hiddentext'.$c.' me-3" style="background-color:white" class="btn"><img src="backraw.png" height="20px" width="20px">Back</button>';
			echo '<h5 class="card-title mx-auto" id="sub'.$c.'">'.$srow["abbr"].'</h5> </div>';
			echo '<p class="card-text tohide'.$c.'">'.$srow["sub_name"].'</p>';
			$cc = 0;
			while($mrow = mysqli_fetch_assoc($mentor)){
				$cc++;
				echo '<div id="t'.$c.$cc.'" class="hiddentext'.$c.'">';
				echo '<h5 class="mx-auto">'.$mrow['name'].'</h5>';
				echo '<a href="http://localhost:4000">Enter into a chat</a><br>';
				echo '<a href="'.$mrow['meetlink'].'">Join a video call</a><br>';
				echo '<a href="doubt.php?m='.$mrow['m_id'].'">Ask a doubt</a>';
				echo '</div>';
			}
			echo '<div class="tohide'.$c.'">';
			echo '<div class="d-flex justify-content-evenly flex-wrap align-content-between mt-4">';//flex wrap keeps items inside the flex
			echo '<div class="mb-3">';
			echo '<button class="btn  dropdown-toggle" type="button" id="ddb'.$c.'" data-bs-toggle="dropdown" aria-expanded="false">Teachers</button>';
			echo '<ul class="dropdown-menu" aria-labelledby="ddb'.$c.'">';
			$mentor = mysqli_query($link,$query);
			$cc = 0;
			while($mrow = mysqli_fetch_assoc($mentor)){
				$cc++;
				echo '<li><button class="dropdown-item" type="button" id="dt'.$c.$cc.'">'.$mrow["name"].'</button></li>';
			}
			echo '</ul>';
			echo '</div>';
			echo '<div>';
			echo '<form action="studentassignment.php" method="post">';
			echo '<input type="hidden" name="sub" value="'.$srow['abbr'].'">';
			echo '<input type="hidden" name="code" value="'.$subcode.'">';
			echo '<button type="submit" class="btn btn-primary">View assignments</button>';
			echo '</form>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			if(($c%3)==0){
				echo '</div>';
			}
		}
	?>

	<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
	  <div class="offcanvas-header mb-3">
		<h3 id="offcanvasRightLabel">Study Material</h3>
		<img src="study.png"/>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body ml-3 mt-5">
		<ul type="none">
			<h5>
			<li class="mb-3">Semester 1</li>
			<li class="mb-3">Semester 2</li>
			<li class="mb-3"><a href ="https://drive.google.com/drive/folders/1hufWazwFtfty0sogNPEBQzBYLHtK1UNW?usp=sharing" target="_blank">Semester 3</a></li>
			<li class="mb-3"><a href="https://drive.google.com/drive/folders/18gVsaoKzk7I7RzyOpPsqXAfsqV0t36T9?usp=sharing" target="_blank">Semester 4</a></li>
			<li class="mb-3">Semester 5</li>
			<li class="mb-3">Semester 6</li>
			<li class="mb-3">Semester 7</li>
			<li class="mb-3">Semester 8</li>
			</h5>
		</ul>
	  </div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    
	<script>
		$("#dt11").click(function(){
			$(".tohide1").hide();
			$("#back1").show();
			$("#t11").show();
			$("#sub1").parent().css({position: 'relative'});
			$("#sub1").css({left: -42, position:'relative'});
		});
		$("#dt12").click(function(){
			$(".tohide1").hide();
			$("#back1").show();
			$("#t12").show();
			$("#sub1").parent().css({position: 'relative'});
			$("#sub1").css({left: -42, position:'relative'});
		});
		$("#dt13").click(function(){
			$(".tohide1").hide();
			$("#back1").show();
			$("#t13").show();
			$("#sub1").parent().css({position: 'relative'});
			$("#sub1").css({left: -42, position:'relative'});
		});
		$("#back1").click(function(){
			$(".tohide1").show();
			$(".hiddentext1").hide();
			$("#sub1").css({left: 0, position:'relative'});
		});
		
		
		$("#dt21").click(function(){
			$(".tohide2").hide();
			$("#back2").show();
			$("#t21").show();
			$("#sub2").parent().css({position: 'relative'});
			$("#sub2").css({left: -42, position:'relative'});
		});
		$("#dt22").click(function(){
			$(".tohide2").hide();
			$("#back2").show();
			$("#t22").show();
			$("#sub2").parent().css({position: 'relative'});
			$("#sub2").css({left: -42, position:'relative'});
		});
		$("#dt23").click(function(){
			$(".tohide2").hide();
			$("#back2").show();
			$("#t23").show();
			$("#sub2").parent().css({position: 'relative'});
			$("#sub2").css({left: -42, position:'relative'});
		});
		$("#back2").click(function(){
			$(".tohide2").show();
			$(".hiddentext2").hide();
			$("#sub2").css({left: 0, position:'relative'});
		});
		
		
		$("#dt31").click(function(){
			$(".tohide3").hide();
			$("#back3").show();
			$("#t31").show();
			$("#sub3").parent().css({position: 'relative'});
			$("#sub3").css({left: -42, position:'relative'});
		});
		$("#dt32").click(function(){
			$(".tohide3").hide();
			$("#back3").show();
			$("#t32").show();
			$("#sub3").parent().css({position: 'relative'});
			$("#sub3").css({left: -42, position:'relative'});
		});
		$("#dt33").click(function(){
			$(".tohide3").hide();
			$("#back3").show();
			$("#t33").show();
			$("#sub3").parent().css({position: 'relative'});
			$("#sub3").css({left: -42, position:'relative'});
		});
		$("#back3").click(function(){
			$(".tohide3").show();
			$(".hiddentext3").hide();
			$("#sub3").css({left: 0, position:'relative'});
		});
		
		
		$("#dt41").click(function(){
			$(".tohide4").hide();
			$("#back4").show();
			$("#t41").show();
			$("#sub4").parent().css({position: 'relative'});
			$("#sub4").css({left: -42, position:'relative'});
		});
		$("#dt42").click(function(){
			$(".tohide4").hide();
			$("#back4").show();
			$("#t42").show();
			$("#sub4").parent().css({position: 'relative'});
			$("#sub4").css({left: -42, position:'relative'});
		});
		$("#dt43").click(function(){
			$(".tohide4").hide();
			$("#back4").show();
			$("#t43").show();
			$("#sub4").parent().css({position: 'relative'});
			$("#sub4").css({left: -42, position:'relative'});
		});
		$("#back4").click(function(){
			$(".tohide4").show();
			$(".hiddentext4").hide();
			$("#sub4").css({left: 0, position:'relative'});
		});
		
		
		$("#dt51").click(function(){
			$(".tohide5").hide();
			$("#back5").show();
			$("#t51").show();
			$("#sub5").parent().css({position: 'relative'});
			$("#sub5").css({left: -42, position:'relative'});
		});
		$("#dt52").click(function(){
			$(".tohide5").hide();
			$("#back5").show();
			$("#t52").show();
			$("#sub5").parent().css({position: 'relative'});
			$("#sub5").css({left: -42, position:'relative'});
		});
		$("#dt53").click(function(){
			$(".tohide5").hide();
			$("#back5").show();
			$("#t53").show();
			$("#sub5").parent().css({position: 'relative'});
			$("#sub5").css({left: -42, position:'relative'});
		});
		$("#back5").click(function(){
			$(".tohide5").show();
			$(".hiddentext5").hide();
			$("#sub5").css({left: 0, position:'relative'});
		});
		
		
		$("#dt61").click(function(){
			$(".tohide6").hide();
			$("#back6").show();
			$("#t61").show();
			$("#sub6").parent().css({position: 'relative'});
			$("#sub6").css({left: -42, position:'relative'});
		});
		$("#dt62").click(function(){
			$(".tohide6").hide();
			$("#back6").show();
			$("#t62").show();
			$("#sub6").parent().css({position: 'relative'});
			$("#sub6").css({left: -42, position:'relative'});
		});
		$("#dt63").click(function(){
			$(".tohide6").hide();
			$("#back6").show();
			$("#t63").show();
			$("#sub6").parent().css({position: 'relative'});
			$("#sub6").css({left: -42, position:'relative'});
		});
		$("#back6").click(function(){
			$(".tohide6").show();
			$(".hiddentext6").hide();
			$("#sub6").css({left: 0, position:'relative'});
		});
		
		$("#dt71").click(function(){
			$(".tohide7").hide();
			$("#back7").show();
			$("#t71").show();
			$("#sub7").parent().css({position: 'relative'});
			$("#sub7").css({left: -42, position:'relative'});
		});
		$("#dt72").click(function(){
			$(".tohide7").hide();
			$("#back7").show();
			$("#t72").show();
			$("#sub7").parent().css({position: 'relative'});
			$("#sub7").css({left: -42, position:'relative'});
		});
		$("#dt73").click(function(){
			$(".tohide7").hide();
			$("#back7").show();
			$("#t73").show();
			$("#sub7").parent().css({position: 'relative'});
			$("#sub7").css({left: -42, position:'relative'});
		});
		$("#back7").click(function(){
			$(".tohide7").show();
			$(".hiddentext7").hide();
			$("#sub7").css({left: 0, position:'relative'});
		});
	</script>
	
		<!--<div id="head">
			<div id="subheading">
				Home
			</div>
			<div id="profile">
			</div>
		</div>
		<div class="container">
				<button onclick="location.href='http://localhost:4000'" type="button" class="chatbtn">Enter into a chat with mentor</button> <br>
				<p><a href="https://vesit.ves.ac.in/">Go to your college website</a></p>
				<button onclick="location.href='studentlogout.php'" type="button" class="logoutbtn">Logout</button> 
		</div>-->
	</body>
</html>
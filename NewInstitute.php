<?php include('institutionregister.php'); ?>
<html>
	<head>
		<title></title>
		<style type="text/css">
			body {  
				font-family: Calibri, Helvetica, sans-serif;  
				background-color: #F9F4F4;  
			}  
			#title2{
				text-align:center;
				margin-top:50px;
			}
			.container {   
				margin:60px auto;
				width:500px;
				padding: 25px;   
				border: 2px solid #050a9e;   
				border-radius:8px;
				background-color: white;  
			}  
			button {   
				background-color: #88ff54;   
				width: 50%;  
				color: orange;   
				padding: 15px;   
				margin: 10px 0px 10px 110px;   
				border: none;   
				cursor: pointer;   
			}  
			button:hover {   
				opacity: 0.7;   
			}   
			.cancelbtn {   
				width: auto;   
				padding: 10px 18px;  
				margin: 10px 5px;  
			}
			.text-danger{
				color:red;
			}
			input[type=text], input[type=password], input[type=email], select {   
				width: 100%;   
				margin: 8px 0;  
				padding: 12px 20px;     
				border: 2px solid #bfff00;   
				box-sizing: border-box;   
			}
		</style>
	</head>
	<body>
		<h1 id="title2"> Institute Registration </h1>   
		<?php
			if(isset($_SESSION['message'])){
				echo "<div id='error-msg'>".$_SESSION['message']."</div>";
				unset($_SESSION['message']);
			}
		?>
		<div id="error">
		<form action="NewInstitute.php" method="post" id="collegeregister_form">  
			<div class="container">   
				<div>
				<label for="in">Institute name :</label>
				<input type="text" placeholder="Enter full name of the institute" name="in" id="in" required>
				<span class="text-danger"><?php if(isset($errors['i'])){ echo $errors['i'];}?></span>
				</div>
				<div>
				<label for="email">Email id :</label>
				<input type="email" placeholder="Enter your email id" name="email" id="email" required>
				<span class="text-danger"><?php if(isset($errors['e'])){ echo $errors['e'];}?></span>		
				</div>
				<div>
				<label for="loginid">Create Admin login id : </label>  
				<input type="text" placeholder="Enter loginid" name="loginid" required>  
				<span class="text-danger"><?php if(isset($errors['l'])){ echo $errors['l'];}?></span>
				</div>
				<label for="password">Create Admin Password : </label>   
				<input type="password" placeholder="Enter Password" name="password" id="password" required>  
				<button type="submit" name="register">Register</button>   
				<button onclick="location.href='index.php'" type="button" class="cancelbtn"> Cancel</button> 
			</div>  
		</form>     
		</div>
	</body>
</html>
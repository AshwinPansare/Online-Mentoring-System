
<!doctype html>
<html lang="en">
	<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Search</title>	
	<style type="text/css">
		.card{
			position:relative;
			display:inline-block;
		}
		.result{
			min-width:250px;
			text-align:center;
			position:absolute;
			left:20px;
			z-index:1;
		}

	</style>
	</head>
	
	<body>
		
		<div class="card text-center" style="width: 18rem;">
		  <div class="card-body">
			<h5 class="card-title">Search Students</h5>
			<div class="card-text">Enter the name of the student to search</div>
			<input type="text" class="form-control" id="name" name="name" onkeyup="searchnm()" placeholder="Enter name Eg.abc xyz" required autocomplete="off">
		  </div>
		</div>
		<div class="list-group result"></div>
			
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
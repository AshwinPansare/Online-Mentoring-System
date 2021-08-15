<?php
	session_start();
	$loginid = $_SESSION['mloginid'];
	$link = mysqli_connect("localhost", "root", "root", "mentoring_system");
	$query = "SELECT * from mentor where login_id='$loginid'";
	$result = mysqli_query($link,$query);
	$mrow = mysqli_fetch_assoc($result);
	$mid = $mrow['m_id'];
	$code = $mrow['sub_code'];
	$miid = $mrow['i_id'];
	$query = "select sem,dept from subject where sub_code='$code'";
	$result = mysqli_query($link,$query);
	$row = mysqli_fetch_assoc($result);
	$mdept = $row['dept'];
	$msem = $row['sem']; 
	$output="";
	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}else{ 
		if (isset($_POST['enteredTxt'])){
			$searchq = $_POST['enteredTxt'];
			if(!ctype_space($searchq)){
				$searchq = trim($searchq);
				$searchq = mysqli_real_escape_string($link,$searchq);
				//$query = "SELECT * FROM `trial` WHERE `name` LIKE '%".$searchq."%' order by name";
				$query = "select concat(f_name,' ',l_name) as name,s_id from student where concat(f_name,' ',l_name) like '%".$searchq."%' and i_id='$miid' and dept='$mdept' and sem='$msem' order by f_name";
				$result = mysqli_query($link,$query);
				if(!$result){
					die(mysqli_error($link));
					//die("Could not search!");
				}else{
					if(mysqli_num_rows($result) > 0){
						while($row = mysqli_fetch_array($result)){
							$output .= "<a href='student-info.php?s=".$row['s_id']."' class='list-group-item list-group-item-action'>" . $row['name'] . "</a>";
						}
						echo $output;
					} else{
						echo "<div>No matches found</div>";
					}
				}
			}
		}
	}
?>
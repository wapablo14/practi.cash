<?php
include "db.php";
	
	if(isset($_POST['update']))
	{
		$numero=$_POST['numero'];
		$name=$_POST['name'];
		$fullname=$_POST['fullname'];
		$password=$_POST['password'];
		$q=mysqli_query($con,"UPDATE `loginPrueba` SET `name`='$name',`fullname`='$fullname',`password`='$password' where `loginPrueba`.`id_num`='$numero'");
		if($q)
			echo "success";
		else
			echo "error";
	}	
?>
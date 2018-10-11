<?php
include "db.php";

if(isset($_POST['insertDatos']))
{ 
	$nombre=$_POST['nombre'];
	$tipo=$_POST['tipo'];
	$numero=$_POST['numero'];
	$date=$_POST['date'];
	$cv=$_POST['cv'];
	$numVal = $_POST['numVal'];
	$insert = mysqli_query($con,"INSERT INTO `tablaPrueba` (`numeroId`,`name`,`tipo`,`numero`,`cv`) VALUES ('$numVal','$nombre','$tipo','$numero','$cv')");
	if($insert)
		echo "success";
	else
		echo "error";
 
}
?>
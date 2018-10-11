<?php
include "db.php";

if(isset($_POST['selectDatos']))
{ 
	$numVal = $_POST['numVal'];
	$data = array();
	
	$select = mysqli_query($con,"Select * from `tablaPrueba` where `numeroId` = '$numVal'");
		while ($row=mysqli_fetch_object($select)){
		$data[]=$row;
		}
		echo json_encode($data);
}
?>
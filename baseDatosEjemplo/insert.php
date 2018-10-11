<?php
 include "db.php";
 if(isset($_POST['insert']))
 {
 $titulo=$_POST['titulo'];
 $cantidad=$_POST['cantidad'];
 $valor=$_POST['valor'];
 $q=mysqli_query($con,"INSERT INTO `tablaEjemplo` (`titulo`,`cantidad`,`valor`) VALUES ('$titulo','$cantidad','$valor')");
 if($q)
  echo "success";
 else
  echo "error";
 }
 
 ?>
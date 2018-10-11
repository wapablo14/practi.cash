<?php 
	$nuevaCoor = "";
	require_once("datos.php");
	$ct = $_REQUEST["tipo"];
	
  	$con = mysqli_connect($host, $user, $pass, $db_name) or die('Error con la conexion de la base de datos');
      $query = "select * from Marcador where Categoria = $ct";
      $result = mysqli_query($con, $query);   
    $i = 0;
    $rows = $result->num_rows;

	while($row = mysqli_fetch_array($result)){
      extract($row);
      $resultado[$i][0] = $Nombre;
      $resultado[$i][1] = $Descripcion;
      $resultado[$i][2] = $Coordenadas;
      $i++;
    }
    $resultado = json_encode($resultado);

    mysqli_close($con);

    echo $resultado;

 ?>
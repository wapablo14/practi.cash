<?php 

  $con="host=localhost port=5432 dbname=prueba password=123456 user=postgres";
  $cone=pg_connect($con);



        $respuesta = array(
        0=>array('id' => 'success', 'men' => 'se cargo la imagen correctamente'),
        1=>array('id' => 'error_bd', 'men' => 'Hubo un problema al cargar la imagen en base de datos'),
        2=>array('id' => 'error_formato', 'men' => 'Los formatos permitidos son JPG, JPEG Y PNG')
        );


  $nom_imagen = $_POST['nombre_imagen'];
  //$ima = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
  $imagen = $_FILES['imagen'];

//echo $imagen['type'];

  if($imagen['type'] == "image/jpg" OR $imagen['type'] == "image/jpeg" OR $imagen['type'] == "image/png")
  {
    if ($imagen['type'] == "image/jpg") {
        
      $ruta = "../img/imagen_usuario/".md5($imagen['tmp_name']).".jpg";
      $sql ="INSERT INTO subir_imagen(nombre_imagen,imagen) VALUES('$nom_imagen','$ruta')";

      if ($resultado=pg_query($cone,$sql))
      {
        move_uploaded_file($imagen["tmp_name"], $ruta);
        //echo "se cargo";
        echo json_encode($respuesta[0]);
      }else{
        //echo "Nose cargo";
        echo json_encode($respuesta[1]);
      }
    }
    


if ($imagen['type'] == "image/jpeg") {
        
      $ruta = "../img/imagen_usuario/".md5($imagen['tmp_name']).".jpeg";

      $sql ="INSERT INTO subir_imagen(nombre_imagen,imagen) VALUES('$nom_imagen','$ruta')";

      if ($resultado=pg_query($cone,$sql))
      {
        move_uploaded_file($imagen["tmp_name"], $ruta);
        //echo "se cargo";
        echo json_encode($respuesta[0]);
      }else{
        //echo "Nose cargo";
        echo json_encode($respuesta[1]);
      }
    }

if ($imagen['type'] == "image/png") {
        
      $ruta = "../img/imagen_usuario/".md5($imagen['tmp_name']).".png";
      $sql ="INSERT INTO subir_imagen(nombre_imagen,imagen) VALUES('$nom_imagen','$ruta')";

      if ($resultado=pg_query($cone,$sql))
      {
        move_uploaded_file($imagen["tmp_name"], $ruta);
        //echo "se cargo";
        echo json_encode($respuesta[0]);
      }else{
        //echo "Nose cargo";
        echo json_encode($respuesta[1]);
      }
    }


  }else{
    echo json_encode($respuesta[2]);
  }
  


/*
  foreach ($ima as $key => $value) {
    echo $key." : ".$value."<br>";
  }*/
 

 /*
if ($ima['type']=="image/jpg" OR $ima['type']=="image/jpeg") {
   echo "si cumple con el formate";
}else{
  echo "no cumple con  el formato";
}
*/

//echo "string";
//phpinfo();
/*
  $con="host=localhost port=5432 dbname=prueba password=123456 user=postgres";
  $cone=pg_connect($con);
	$sql_saldo = "SELECT c.id, c.nombre_cliente, c.apellido_cliente, t.descripcion FROM clientes c INNER JOIN transacciones t ON c.id = t.id_cliente WHERE t.id_cliente ='$par'";


	$sql = "INSERT INTO tabla(nombre) VALUES('sergio')";

	$resultado=pg_query($cone,$sql);

	if($resultado)
 	{
  		echo "success7";
 	}
 	else
  	{
  		echo "er";
  	}
*/

?>
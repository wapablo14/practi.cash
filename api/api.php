<?php 
  include "bd.php";
  error_reporting(0);

//require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
include '../librerias/twilio-php-master/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;


////////////////////////////////
//$_POST['nombre_funcion']="a_transaccion";

		//$_POST['numero']=2132;
		//$_POST['clave']=22322;
		//$_POST['fecha_entrada']="sdsd";
///////////////////

if(isset($_POST['nombre_funcion']))
{

	$caso_funcion = $_POST['nombre_funcion'];

//************************************** funcion para Suscribir

//*************************************

	if ($caso_funcion == "a_suscribir")
	{

	 if(isset($_POST['numero']) && isset($_POST['clave']) && isset($_POST['fecha_entrada']))
	 {
		$numero_suscribir1 = $_POST['numero'];
		$numero_suscribir = "+".$numero_suscribir1;

		$clave_suscribir = $_POST['clave'];
		$fecha_entrada = $_POST['fecha_entrada'];

		$caso = $_POST['caso'];

		

//aqui se verifica si el usuario ya estaba previamente registrado en el sistema
		$sql_estaba_usuario = "SELECT count(cli.id) as cantidad FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";

			$resultado_sql_estaba_usuario = pg_query($cone,$sql_estaba_usuario);

			$fila4=pg_fetch_assoc($resultado_sql_estaba_usuario);

			$estaba_usuario = $fila4['cantidad'];



		if($caso == "generar_codigo_val" && $estaba_usuario==0) 
		{
			//aqui se genera el codigo de validacion
			$codigo_val1 = rand(10001,99999);
			$codigo_val = $codigo_val1." ";



			$codigo_ramdom = rand(100001,999999);
			$fecha_clave = date("Y-m-d");
			$valor_tem_clave_i = date("Y-m-d H:i:s");

				$fecha_clave =  $valor_tem_clave_i." ";
				$partes_fecha = explode(" ",$fecha_clave);
				$fecha_sin_es = $partes_fecha[0].$partes_fecha[1];
				$fecha_sin_p_a = explode(":",$fecha_sin_es);
				$fecha_sin_p = $fecha_sin_p_a[0].$fecha_sin_p_a[1].$fecha_sin_p_a[2];

				$fecha_sin_g_a = explode("-",$fecha_sin_p);
				$fecha_sin_g = $fecha_sin_g_a[0].$fecha_sin_g_a[1].$fecha_sin_g_a[2];
			    $apikey = $fecha_sin_g."-".$codigo_ramdom;


			//aqui registra en la tabla clientes
			$sql_registro_cliente_t ="INSERT INTO clientes(nombre_cliente,telefono,activo,keyt,imagen,pin,correo, fecha_nacimiento,sexo) VALUES('nombre_temporal','$numero_suscribir1','0','$apikey','no_imagen','11111','correo_tem','fecha_n_tem','temporal')";
			$resultado_sql_registro_cliente_t=pg_query($cone,$sql_registro_cliente_t);


			//aqui registra en la tabla claves

			$sql_obtener_id = "SELECT cli.id, cli.nombre_cliente,cli.telefono,cli.activo,cli.keyt FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";

			$resultado_sql_obtener_id=pg_query($cone,$sql_obtener_id);

			$fila2=pg_fetch_assoc($resultado_sql_obtener_id);

			$id_cliente = $fila2['id'];

//aqui se registra la fecha de caducidad, tiene 5 minutos de mas
			$f_caducidad_t = date("Y-m-d H:i:s");

			$f_caducidad_t2 = strtotime("+1 minute",strtotime($f_caducidad_t));

			$f_caducidad = date("Y-m-d H:i:s",$f_caducidad_t2);

			
			$sql_registro_clave ="INSERT INTO claves(clave, fecha_caducidad,id_cliente) VALUES('$codigo_val1','$f_caducidad','$id_cliente')";
			$resultado_sql_registro_clave=pg_query($cone,$sql_registro_clave);





			$respuestas_suscribir = array(
					0=>array('mensaje' => 'Codigo SMS enviado a tu telefono (tienes hasta 5 minutos para colocarlo)', 'id' => 'success'),
					1=>array('mensaje' => 'Hubo un problema con la base de datos',
						'id' =>'error')
					);

			if ($resultado_sql_registro_cliente_t==true) 
			{
	//aqui se crea la parametrizacion para usar twilio

				$client1 = new Client($sid1, $token1); 
				try {
					// Use the client to do fun stuff like send text messages!
					$client1->messages->create(
						//aqui se coloca el numero de telefono alque llegara el codigo de validacion generado por twilio
						$numero_suscribir, //activa este si quieres que funcione para todos los numeros de telefonos
						//'+584268210636', //activa este si solo quieres que funcione para el telefono de pablo
						array(
						//aqui se coloca el numero de telefono que twilio genera para que desde aqui envie los mensajes	
						'from' => $telefono_twilio,
						//aqui se coloca el mensaje que le llegara al telefono del usuario
						'body' => $codigo_val//$codigo_val

					)); 
											
						echo json_encode($respuestas_suscribir[0]); 
						//echo "bien";
				}
				catch (Services_Twilio_RestException $e){
						//$respuestas_suscribir[1]['mensaje'] = $e.get_code();
					  	echo json_encode($respuestas_suscribir[1]);
				}

					
			}
			if ($resultado_sql_registro_cliente_t==false) 
			{
								//echo "error al insertar en base de datos";
				echo json_encode($respuestas_suscribir[1]);
			}

			//echo "llego ".$caso." ".$numero_suscribir." ".$codigo_val;
		}
//ESTA PARTE ES CUANDO SE VALIDA EL CODIGO DE SEGURIDAD INGRESADO POR EL USUARIO
		if($caso == "validar_t_c")
		{
			

			$sql_obtener_id2 = "SELECT cli.id, cli.nombre_cliente,cli.telefono,cli.activo,cli.keyt FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";

			$resultado_sql_obtener_id2 = pg_query($cone,$sql_obtener_id2);

			$fila2=pg_fetch_assoc($resultado_sql_obtener_id2);

			$id_cliente2 = $fila2['id'];


///////////codigo para hacer pruebas
			$respuestas_pruebas = array(
					0=>array('mensaje' => 'Codigo SMS enviado a tu telefono (tienes hasta 5 minutos para colocarlo)', 'id' => 'success'),
					1=>array('mensaje' => $id_cliente2,
						'id' =>'prueba')
					);
			echo json_encode($respuestas_pruebas[1]);
/////////////////////////////////////////


			$sql_repetir_validar_codigo = "SELECT cla.id, cla.clave, cla.fecha_caducidad FROM claves cla WHERE cla.id_cliente = '$id_cliente2' ORDER BY cla.id DESC LIMIT 1";

			$resultado_sql_repetir_validar_codigo=pg_query($cone,$sql_repetir_validar_codigo);

			$fila5=pg_fetch_assoc($resultado_sql_repetir_validar_codigo);

			$codigo_dentro2 = $fila5['clave'];
			$fecha_caducidad_anterior = $fila5['fecha_caducidad'];


/*
			if($codigo_dentro2 == "111") 
			{				
				$respuestas_suscribir = array(
					0=>array('mensaje' => 'Codigo SMS enviado a tu telefono (tienes hasta 5 minutos para colocarlo)', 'id' => 'success'),
					1=>array('mensaje' => 'Hubo un problema con la base de datos',
						'id' =>'error')
					);

				$codigo_val1 = rand(10001,99999);
				$codigo_val = $codigo_val1." ";



				$codigo_ramdom = rand(100001,999999);
				$fecha_clave = date("Y-m-d");
				$valor_tem_clave_i = date("Y-m-d H:i:s");

				$fecha_clave =  $valor_tem_clave_i." ";
				$partes_fecha = explode(" ",$fecha_clave);
				$fecha_sin_es = $partes_fecha[0].$partes_fecha[1];
				$fecha_sin_p_a = explode(":",$fecha_sin_es);
				$fecha_sin_p = $fecha_sin_p_a[0].$fecha_sin_p_a[1].$fecha_sin_p_a[2];

				$fecha_sin_g_a = explode("-",$fecha_sin_p);
				$fecha_sin_g = $fecha_sin_g_a[0].$fecha_sin_g_a[1].$fecha_sin_g_a[2];
			    $apikey2 = $fecha_sin_g."-".$codigo_ramdom;


			//aqui modifica la tabla clientes
				$sql_registro_cliente_t ="UPDATE clientes SET keyt ='$apikey2' WHERE id='$id_cliente2'";
				
				$resultado_sql_registro_cliente_t=pg_query($cone,$sql_registro_cliente_t);
//echo $apikey2." ".$id_cliente2."<br>";

			//aqui registra en la tabla claves

				$sql_obtener_id = "SELECT cli.id, cli.nombre_cliente,cli.telefono,cli.activo,cli.keyt FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";

				$resultado_sql_obtener_id=pg_query($cone,$sql_obtener_id);

				$fila2=pg_fetch_assoc($resultado_sql_obtener_id);

				$id_cliente = $fila2['id'];



	//aqui se registra la fecha de caducidad, tiene 5 minutos de mas
				$f_caducidad_t = date("Y-m-d H:i:s");

				$f_caducidad_t2 = strtotime("+1 minute",strtotime($f_caducidad_t));

				$f_caducidad = date("Y-m-d H:i:s",$f_caducidad_t2);

				
				$sql_registro_clave ="UPDATE claves SET clave ='$codigo_val1', fecha_caducidad = '$f_caducidad' WHERE id_cliente='$id_cliente2' AND fecha_caducidad ='$fecha_caducidad_anterior'";
				$resultado_sql_registro_clave2=pg_query($cone,$sql_registro_clave);

				if ($resultado_sql_registro_cliente2==true) 
				{
				$client1 = new Client($sid1, $token1); 
					try {
						// Use the client to do fun stuff like send text messages!
						$client1->messages->create(
							//aqui se coloca el numero de telefono alque llegara el codigo de validacion generado por twilio
							$numero_suscribir, //activa este si quieres que funcione para todos los numeros de telefonos
							//'+584268210636', //activa este si solo quieres que funcione para el telefono de pablo
							array(
							//aqui se coloca el numero de telefono que twilio genera para que desde aqui envie los mensajes	
							'from' => $telefono_twilio,
							//aqui se coloca el mensaje que le llegara al telefono del usuario
							'body' => $codigo_val//$codigo_val

						)); 
												
							echo json_encode($respuestas_suscribir[0]); 
							//echo "bien";
					}
					catch (Services_Twilio_RestException $e){
							//$respuestas_suscribir[1]['mensaje'] = $e.get_code();
						  	echo json_encode($respuestas_suscribir[1]);
					}
			    }

				if ($resultado_sql_registro_cliente2==false) 
				{
					//echo "error al insertar en base de datos";
					echo json_encode($respuestas_suscribir[1]);
				}
			}*/




			if($codigo_dentro2 != "111") 
			{			
				$sql_obtener_id2 = "SELECT cli.id, cli.nombre_cliente,cli.telefono,cli.activo,cli.keyt FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";

				$resultado_sql_obtener_id2 = pg_query($cone,$sql_obtener_id2);

				$fila2=pg_fetch_assoc($resultado_sql_obtener_id2);

				$id_cliente2 = $fila2['id'];


				$sql_validar_codigo = "SELECT cla.id, cla.clave, cla.fecha_caducidad FROM claves cla WHERE cla.id_cliente = '$id_cliente2'";

				$resultado_sql_validar_codigo=pg_query($cone,$sql_validar_codigo);

				$fila=pg_fetch_assoc($resultado_sql_validar_codigo);

				$codigo_dentro = $fila['clave'];
				$f_ca = $fila['fecha_caducidad'];


				$f_actual = date("Y-m-d H:i:s");

				$fecha_ca = strtotime($f_ca);

				$fecha_actual = strtotime($f_actual);



				$respuestas_suscribir2 = array(
						0=>array('mensaje' => 'validacion de telefono correcta', 'id' => 'success'),
						1=>array('mensaje' => 'Codigo de Seguridad Incorrecto',
							'id' =>'error_c'),
						2=>array('mensaje' => 'Tiempo expirado',
							'id' =>'error_t'),
						);

	//echo "llego ".$codigo_dentro." ".$clave_suscribir;
				if($fecha_actual > $fecha_ca)
				{
					//$ind_val_t_c == 1;
					//echo $id_cliente2." ".$f_ca;
					$sql_cambio_clave ="UPDATE claves SET clave ='111' WHERE id_cliente='$id_cliente2' AND fecha_caducidad = '$f_ca'";
					$resultado_sql_registro_cliente=pg_query($cone,$sql_cambio_clave);



					echo json_encode($respuestas_suscribir2[2]);
				}			
				if($codigo_dentro == $clave_suscribir && $fecha_actual <= $fecha_ca)
				{
					echo json_encode($respuestas_suscribir2[0]);
					//$sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";
				}
				if($codigo_dentro != $clave_suscribir)
				{
					echo json_encode($respuestas_suscribir2[1]);
				}


			}







////debes comentar desde aqui
			if($codigo_dentro2 == "111") 
			{				
				$respuestas_suscribir = array(
					0=>array('mensaje' => 'Codigo SMS enviado a tu telefono (tienes hasta 5 minutos para colocarlo)', 'id' => 'success'),
					1=>array('mensaje' => 'Hubo un problema con la base de datos',
						'id' =>'error')
					);

				$codigo_val1 = rand(10001,99999);
				$codigo_val = $codigo_val1." ";



				$codigo_ramdom = rand(100001,999999);
				$fecha_clave = date("Y-m-d");
				$valor_tem_clave_i = date("Y-m-d H:i:s");

				$fecha_clave =  $valor_tem_clave_i." ";
				$partes_fecha = explode(" ",$fecha_clave);
				$fecha_sin_es = $partes_fecha[0].$partes_fecha[1];
				$fecha_sin_p_a = explode(":",$fecha_sin_es);
				$fecha_sin_p = $fecha_sin_p_a[0].$fecha_sin_p_a[1].$fecha_sin_p_a[2];

				$fecha_sin_g_a = explode("-",$fecha_sin_p);
				$fecha_sin_g = $fecha_sin_g_a[0].$fecha_sin_g_a[1].$fecha_sin_g_a[2];
			    $apikey2 = $fecha_sin_g."-".$codigo_ramdom;


			//aqui modifica la tabla clientes
				$sql_registro_cliente_t ="UPDATE clientes SET keyt ='$apikey2' WHERE id='$id_cliente2'";
				
				$resultado_sql_registro_cliente_t=pg_query($cone,$sql_registro_cliente_t);
//echo $apikey2." ".$id_cliente2."<br>";

			//aqui registra en la tabla claves

				$sql_obtener_id = "SELECT cli.id, cli.nombre_cliente,cli.telefono,cli.activo,cli.keyt FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";

				$resultado_sql_obtener_id=pg_query($cone,$sql_obtener_id);

				$fila2=pg_fetch_assoc($resultado_sql_obtener_id);

				$id_cliente = $fila2['id'];



	//aqui se registra la fecha de caducidad, tiene 5 minutos de mas
				$f_caducidad_t = date("Y-m-d H:i:s");

				$f_caducidad_t2 = strtotime("+1 minute",strtotime($f_caducidad_t));

				$f_caducidad = date("Y-m-d H:i:s",$f_caducidad_t2);

				
				$sql_registro_clave ="UPDATE claves SET clave ='$codigo_val1', fecha_caducidad = '$f_caducidad' WHERE id_cliente='$id_cliente2' AND fecha_caducidad ='$fecha_caducidad_anterior'";
				$resultado_sql_registro_clave2=pg_query($cone,$sql_registro_clave);

				if ($resultado_sql_registro_cliente2==true) 
				{
				$client1 = new Client($sid1, $token1); 
					try {
						// Use the client to do fun stuff like send text messages!
						$client1->messages->create(
							//aqui se coloca el numero de telefono alque llegara el codigo de validacion generado por twilio
							$numero_suscribir, //activa este si quieres que funcione para todos los numeros de telefonos
							//'+584268210636', //activa este si solo quieres que funcione para el telefono de pablo
							array(
							//aqui se coloca el numero de telefono que twilio genera para que desde aqui envie los mensajes	
							'from' => $telefono_twilio,
							//aqui se coloca el mensaje que le llegara al telefono del usuario
							'body' => $codigo_val//$codigo_val

						)); 
												
							echo json_encode($respuestas_suscribir[0]); 
							//echo "bien";
					}
					catch (Services_Twilio_RestException $e){
							//$respuestas_suscribir[1]['mensaje'] = $e.get_code();
						  	echo json_encode($respuestas_suscribir[1]);
					}
			    }

				if ($resultado_sql_registro_cliente2==false) 
				{
					//echo "error al insertar en base de datos";
					echo json_encode($respuestas_suscribir[1]);
				}
			}






			//echo "llego ".$codigo_dentro." ".$status_usuario;
		}
//ESTA ES LA PARTE DE REGISTRAR COMPLETAMENTE AL USUARIO
		if($caso == "registrar_u")
		{
			$respuestas_suscribir4 = array(
				0=>array('mensaje' => 'El Formato de la imagen no es valido, solo estan permitidos los formatos: JPG, JPEG y PNG', 'id' => 'e_imagen'),
			);


			$numero_pin = $_POST['numero_pin'];
			$correo = $_POST['correo'];
			$f_nacimiento = $_POST['f_nacimiento'];
			$sexo = $_POST['sexo'];

			$imagen = $_FILES['foto'];
		//echo $imagen['type']." ".$imagen['tmp_name'];
			if($imagen['type']=="")
			{
				
				$sql_registro_cliente ="UPDATE clientes SET activo ='1', pin ='$numero_pin', correo ='$correo', fecha_nacimiento = '$f_nacimiento', sexo = '$sexo' WHERE telefono='$numero_suscribir1'";
				$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

				$respuestas_suscribir3 = array(
						0=>array('mensaje' => 'Usuario registrado correctamente', 'id' => 'success'),
						1=>array('mensaje' => 'Hubo un problema al registrar usuario',
							'id' =>'error')
						);
				
				if($resultado_sql_registro_cliente==true) 
				{			
					echo json_encode($respuestas_suscribir3[0]);
				}


				if($resultado_sql_registro_cliente==false) 
				{			
					echo json_encode($respuestas_suscribir3[1]);
				}

			}
			if($imagen['type']!="")
			{
				//echo "si hay imagen";
				//aqui se obtiene el id del cliente utilizado el numero de telefono

				$sql_id_cliente = "SELECT cli.id, cli.telefono, cli.imagen FROM clientes cli WHERE cli.telefono = '$numero_suscribir1'";
				
				$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

				$fila=pg_fetch_assoc($resultado_sql_id_cliente);

				$id_cli = $fila['id'];


				$nuevo_nombre = $id_cli."-2019-03-05-03-04-56".".2";	

		//aqui valida las extensiones y hace el update
				  if($imagen['type'] == "image/jpg" OR $imagen['type'] == "image/jpeg" OR $imagen['type'] == "image/png")
				  {
				    if ($imagen['type'] == "image/jpg") 
				    {       
				      $ruta = "../img/imagen_usuario/".$nuevo_nombre.".jpg";
				      $sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";

				      if ($resultado=pg_query($cone,$sql))
				      {
				      	$respuestas_suscribir[4]['ima'] = $ruta;
				        move_uploaded_file($imagen["tmp_name"], $ruta);
				        //echo "se cargo";
				        //echo json_encode($respuestas_suscribir[4]);
				      }
				      //else{
				        //echo "Nose cargo";
				        //echo json_encode($respuestas_suscribir[5]);
				      //}


						$sql_registro_cliente ="UPDATE clientes SET activo ='1', pin ='$numero_pin', correo ='$correo', fecha_nacimiento = '$f_nacimiento', sexo = '$sexo' WHERE telefono='$numero_suscribir1'";
						$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

						$respuestas_suscribir3 = array(
								0=>array('mensaje' => 'Usuario registrado correctamente', 'id' => 'success'),
								1=>array('mensaje' => 'Hubo un problema al registrar usuario',
									'id' =>'error')
								);
						
						if($resultado_sql_registro_cliente==true) 
						{			
							echo json_encode($respuestas_suscribir3[0]);
						}


						if($resultado_sql_registro_cliente==false) 
						{			
							echo json_encode($respuestas_suscribir3[1]);
						}
				      }
				    


					if ($imagen['type'] == "image/jpeg") 
					{        
				      $ruta = "../img/imagen_usuario/".$nuevo_nombre.".jpeg";

				      $sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";

				      if ($resultado=pg_query($cone,$sql))
				      {
				      	$respuestas_suscribir[4]['ima'] = $ruta;
				        move_uploaded_file($imagen["tmp_name"], $ruta);
				        //echo "se cargo";
				       // echo json_encode($respuestas_suscribir[4]);
				      }
				      //else{
				        //echo "Nose cargo";
				        //echo json_encode($respuestas_suscribir[5]);
				      //}
				    

						$sql_registro_cliente ="UPDATE clientes SET activo ='1', pin ='$numero_pin', correo ='$correo', fecha_nacimiento = '$f_nacimiento', sexo = '$sexo' WHERE telefono='$numero_suscribir1'";
						$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

						$respuestas_suscribir3 = array(
								0=>array('mensaje' => 'Usuario registrado correctamente', 'id' => 'success'),
								1=>array('mensaje' => 'Hubo un problema al registrar usuario',
									'id' =>'error')
								);
						
						if($resultado_sql_registro_cliente==true) 
						{			
							echo json_encode($respuestas_suscribir3[0]);
						}


						if($resultado_sql_registro_cliente==false) 
						{			
							echo json_encode($respuestas_suscribir3[1]);
						}

				    }

					if ($imagen['type'] == "image/png") 
					{       
					      $ruta = "../img/imagen_usuario/".$nuevo_nombre.".png";
					      $sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";

					      if ($resultado=pg_query($cone,$sql))
					      {
					      	$respuestas_suscribir[4]['ima'] = $ruta;

					        move_uploaded_file($imagen["tmp_name"], $ruta);
					        //echo "se cargo";
					        //echo json_encode($respuestas_suscribir[4]);
					      }
					      //else{
					        //echo "Nose cargo";
					        //echo json_encode($respuestas_suscribir[5]);
					      //}

						$sql_registro_cliente ="UPDATE clientes SET activo ='1', pin ='$numero_pin', correo ='$correo', fecha_nacimiento = '$f_nacimiento', sexo = '$sexo' WHERE telefono='$numero_suscribir1'";
						$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

						$respuestas_suscribir3 = array(
								0=>array('mensaje' => 'Usuario registrado correctamente', 'id' => 'success'),
								1=>array('mensaje' => 'Hubo un problema al registrar usuario',
									'id' =>'error')
								);
						
						if($resultado_sql_registro_cliente==true) 
						{			
							echo json_encode($respuestas_suscribir3[0]);
						}


						if($resultado_sql_registro_cliente==false) 
						{			
							echo json_encode($respuestas_suscribir3[1]);
						}
					      
					 }

				}else{
					echo json_encode($respuestas_suscribir4[0]);
				}


			}
			//echo $numero_suscribir1." ".$numero_pin." ".$correo." ".$f_nacimiento." ".$sexo;
			
/*
			$sql_registro_cliente ="UPDATE clientes SET activo ='1', pin ='$numero_pin', correo ='$correo', fecha_nacimiento = '$f_nacimiento', sexo = '$sexo' WHERE telefono='$numero_suscribir1'";
			$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

			$respuestas_suscribir3 = array(
					0=>array('mensaje' => 'Usuario registrado correctamente', 'id' => 'success'),
					1=>array('mensaje' => 'Hubo un problema al registrar usuario',
						'id' =>'error')
					);
			
			if($resultado_sql_registro_cliente==true) 
			{			
				echo json_encode($respuestas_suscribir3[0]);
			}


			if($resultado_sql_registro_cliente==false) 
			{			
				echo json_encode($respuestas_suscribir3[1]);
			}

			*/
		}
		//echo "numero suscribir: ".$numero_suscribir." clave suscribir: ".$clave_suscribir." fecha entrada: ".$fecha_entrada;


/*
		$sql_validar_clave = "SELECT cla.id, cla.clave, cla.fecha_caducidad, cla.id_cliente FROM claves cla WHERE cla.clave = '$clave_suscribir'";

		$resultado_sql_validar_clave=pg_query($cone,$sql_validar_clave);
		$ind_clave=0;
		$ind_mensaje_cad_fe =0;



		$respuestas_suscribir = array(
			0=>array('error_clave' => 'error, la clave ya caduco'),
			1=>array('bien' => 'success'),
			2=>array('error_bd' => 'error al insertar en base de datos'),
			3=>array('error_no_clave' => 'error no se encontro la clave'),
	        4=>array('id' => 'success', 'men' => 'Se Actualizo la Imagen Correctamente', 'ima'=>$ruta_ima),
	        5=>array('id' => 'error_bd', 'men' => 'Hubo un problema al cargar la imagen en base de datos'),
	        6=>array('id' => 'error_formato', 'men' => 'Los formatos permitidos son JPG, JPEG Y PNG')			
			);

		$imagen = $_FILES['imagen'];
//		echo $imagen['type']." ".$imagen['tmp_name'];

		//aqui se obtiene el id del cliente utilizado el numero de telefono

			$sql_id_cliente = "SELECT cli.id, cli.telefono, cli.imagen FROM clientes cli WHERE cli.telefono = '$numero_suscribir'";
			
			$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

			$fila=pg_fetch_assoc($resultado_sql_id_cliente);

			$id_cli = $fila['id'];

			$nom_imagen = $fila['imagen'];

			if($nom_imagen!="no_imagen") 
			{
				$ind_n_i = explode(".",$nom_imagen);
				if ($ind_n_i[3]=='1')
				{
					$nuevo_nombre = $id_cli."-2019-03-05-03-04-56".".2";
				}
				if ($ind_n_i[3]=='2')
				{
					$nuevo_nombre = $id_cli."-2019-03-05-03-04-56".".1";
				}
			}
			if($nom_imagen=="no_imagen") 
			{
				$nuevo_nombre = $id_cli."-2019-03-05-03-04-56".".2";	
			}

//			$nuevo_nombre = $id_cli."-2019-03-05-03-04-56";
			//$nuevo_nombre = $nuevo_nombre."-8";


//aqui valida las extensiones y hace el update
		  if($imagen['type'] == "image/jpg" OR $imagen['type'] == "image/jpeg" OR $imagen['type'] == "image/png")
		  {
		    if ($imagen['type'] == "image/jpg") 
		    {       
		      $ruta = "../img/imagen_usuario/".$nuevo_nombre.".jpg";
		      $sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";

		      if ($resultado=pg_query($cone,$sql))
		      {
		      	$respuestas_suscribir[4]['ima'] = $ruta;
		        move_uploaded_file($imagen["tmp_name"], $ruta);
		        //echo "se cargo";
		        echo json_encode($respuestas_suscribir[4]);
		      }else{
		        //echo "Nose cargo";
		        echo json_encode($respuestas_suscribir[5]);
		      }
		    }
		    


		if ($imagen['type'] == "image/jpeg") 
		{        
		      $ruta = "../img/imagen_usuario/".$nuevo_nombre.".jpeg";

		      $sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";

		      if ($resultado=pg_query($cone,$sql))
		      {
		      	$respuestas_suscribir[4]['ima'] = $ruta;
		        move_uploaded_file($imagen["tmp_name"], $ruta);
		        //echo "se cargo";
		        echo json_encode($respuestas_suscribir[4]);
		      }else{
		        //echo "Nose cargo";
		        echo json_encode($respuestas_suscribir[5]);
		      }
		    }

		if ($imagen['type'] == "image/png") 
		{       
		      $ruta = "../img/imagen_usuario/".$nuevo_nombre.".png";
		      $sql ="UPDATE clientes SET imagen ='$ruta' WHERE id='$id_cli'";

		      if ($resultado=pg_query($cone,$sql))
		      {
		      	$respuestas_suscribir[4]['ima'] = $ruta;

		        move_uploaded_file($imagen["tmp_name"], $ruta);
		        //echo "se cargo";
		        echo json_encode($respuestas_suscribir[4]);
		      }else{
		        //echo "Nose cargo";
		        echo json_encode($respuestas_suscribir[5]);
		      }
		 }


	}else{
	    echo json_encode($respuestas_suscribir[6]);
    }

		 */
/*
		if()
		{ 
		//si encuentra la clave, se verifica la fecha si es menor que la de caducidad
		//datos de prueba:
	
			$fecha_p = "2019-08-01"; //formato aaaa-mm-dd

			//formato de fecha aaaa-mm-dd
			$fecha_entrada2 = strtotime($fecha_p);//strtotime($fecha_entrada_a_m_d)

			$nombre_cliente = "ramon";
			$es_activo ="1";
			$key_rand = rand(187,900);

				while ($row1=pg_fetch_assoc($resultado_sql_validar_clave))
				{
					if($clave_suscribir == $row1['clave']) 
					{
					$fecha_en_tabla = strtotime($row1['fecha_caducidad']);

						if($fecha_entrada2 > $fecha_en_tabla)
						{
							//echo "error. la clave ya caduco";
							$ind_mensaje_cad_fe =1;
							echo json_encode($respuestas_suscribir[0]);
							break;
						}	

						$ind_clave=1;


						if($fecha_entrada2 <= $fecha_en_tabla)
						{

							$sql_registro_cliente ="INSERT  INTO clientes(nombre_cliente,telefono,activo,keyt) VALUES('$nombre_cliente',$numero_suscribir,'$es_activo','$key_rand')";
							$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

							if ($resultado_sql_registro_cliente==true) 
							{
								//echo "success";
								echo json_encode($respuestas_suscribir[1]);
							}
							if ($resultado_sql_registro_cliente==false) 
							{
								//echo "error al insertar en base de datos";
								echo json_encode($respuestas_suscribir[2]);
							}
							
							$ind_mensaje_cad_fe =1;
							break;
						}
						
					}

				}
			//si no se encuentra la clave, se envia mensaje de error


				if($ind_clave==0 && $ind_mensaje_cad_fe ==0) 
				{
					//echo "error. no se encontro la clave";
					echo json_encode($respuestas_suscribir[3]);
				}
				
				$accion_suscribir = "";
				$numero_suscribir = "";
				$clave_suscribir = ""; 
			}	 */

		}
	} 

	//************************************funcion para el saldo

	/*
	$accion_saldo="verSaldo";
	$telefono_saldo=123213; 
	$key_saldo=343;
	*/
	if($caso_funcion == "ver_saldo")
	{
		if(isset($_POST['telefono']) && isset($_POST['key']) )
		{
		$telefono_saldo=$_POST['telefono'];
		$key_saldo = $_POST['key'];



		//echo "telefono saldo: ".$telefono_saldo." key saldo: ".$key_saldo;

		//aqui se obtiene el id del cliente utilizado el numero de telefono

			$sql_id_cliente = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_saldo'";
			
			$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

			$fila=pg_fetch_assoc($resultado_sql_id_cliente);

			$id_cli = $fila['id'];

		//aqui se obtiene el saldo total del cliente
			$sql_saldo_cliente = "SELECT sum(tr.valor) AS total_valor FROM transacciones tr WHERE tr.id_cliente = '$id_cli'";

			$resultado_sql_saldo_cliente=pg_query($cone,$sql_saldo_cliente);
			

			while($row=pg_fetch_assoc($resultado_sql_saldo_cliente))
			{
				$tabla_saldo[]=$row;
			}
				
			echo json_encode($tabla_saldo);

			$accion_saldo="";
			$accion_saldo="" ;
			$telefono_saldo = "";
			$key_saldo = "";
		}
	}



	//********************************funciones para la transaccion

	//este es el caso para hacer consultas
/*	
		$_POST['telefono_transaccion']=10002;
		$_POST['key_transaccion']=3232;
		$_POST['fecha_inicial'] = '2019-02-03';
		$_POST['fecha_final'] = '2019-03-01';

*/
	
	if($caso_funcion == "a_transaccion")
	{
		if(isset($_POST['telefono_transaccion']) && isset($_POST['key_transaccion']) )
	    {
			$telefono_transaccion = $_POST['telefono_transaccion'];
			$key_transaccion = $_POST['key_transaccion'];
			$df =0;

//Aqui se confirma si el cliente envio la fecha
			if($_POST['fecha_inicial']!="" && $_POST['fecha_final']!="")
			{ 	
				$fecha_inicial = $_POST['fecha_inicial'];
				$fecha_final = $_POST['fecha_final'];
//echo json_encode($fecha_final);
				//aqui se obtiene el id del cliente utilizando el numero de telefono

					$sql_id_cliente = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_transaccion'";
					
					$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

					$fila=pg_fetch_assoc($resultado_sql_id_cliente);

					$id_cli_transa = $fila['id'];

					$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion,t.observacion, t.valor, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id DESC";

					$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
					$cadena ="";

					while ($row1=pg_fetch_assoc($resultado_sql_transaccion))
					{
						$cadena = $cadena.$row1['valor']."i";
					}

					$arreglo_valor_c = explode("i",$cadena);
					//			echo $cadena;
					//var_dump($arreglo_valor_c);
					$tam = sizeof($arreglo_valor_c);
					$tam2 = $tam-1;
					//echo "<br>".$tam;

					$arreglo_valor_c = array_diff($arreglo_valor_c, array($arreglo_valor_c[$tam2]));
					//$tam3 = sizeof($arreglo_valor_c);
					//echo "<br>".$tam3."<br>";
					//$tam4 = $tam3-1;
					//var_dump($arreglo_valor_c);


					$arreglo_valor = array_reverse($arreglo_valor_c);
					//echo "<br>";
					//var_dump($arreglo_valor);

					$arreglo_valor2 = $arreglo_valor;
					//echo "<br>";
					//var_dump($arreglo_valor2);
					$cant_saldo_po2 = $cant_saldo_po;


					
					foreach($arreglo_valor as $indice=> $valor) 
					{
						if ($indice>0) 
						{
							foreach($arreglo_valor2 as $key => $value) 
							{
								if($key<$indice) 
								{

									$arreglo_valor[$indice] = $arreglo_valor[$indice]+$value;
									
								}
							}
						}
					}

				//aqui se agregan los saldos calculados a la tabla transaccion
					$sql_transaccion2 = "SELECT t.id, t.fecha, t.descripcion, t.valor,t.observacion, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id DESC";
					


					$resultado_sql_transaccion2=pg_query($cone,$sql_transaccion2);
					$ind_t =0;
					$fin_bucle =0;
					while($row_t = pg_fetch_assoc($resultado_sql_transaccion2))
					{
						$tabla_total[]=$row_t;
						$ind_t = $ind_t+1;
						$d = $d+1;
					}

					$tabla_total2 = array_reverse($tabla_total);
					$tabla_total = $tabla_total2;

					//sql de la suma total del saldo
					$sql_saldo_total = "SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = '$id_cli_transa'"; 
					$resultado_sql_saldo_total=pg_query($cone,$sql_saldo_total);

					while ($row2=pg_fetch_assoc($resultado_sql_saldo_total))
					{
						$cant2[] = $row2['saldo_total'];
					}
					$cant_saldo_total = $cant2[0];


				 	$c=0;
				 	$d = $d-1;
				 	$ind_t =$ind_t-1;


					foreach ($tabla_total as $key1 => $value1)
					{
						foreach ($arreglo_valor as $key => $value) 
						{
							
							if ($c == $key) 
							{
								
								if ($ind_t == $c) 
								{
									$tabla_total[$key]['saldo']= $cant_saldo_total;
									$c = $c+1;
									$fin_bucle =1;
									break;
								}

								if ($fin_bucle==0) 
								{	
									$tabla_total[$key]['saldo'] = $arreglo_valor[$key];
									$c = $c+1;
									break;	
								}
							}
						}
				    }


					
					$tabla_total2 = array_reverse($tabla_total);

					$sql_tabla_fecha = "SELECT t.id, t.fecha, t.descripcion FROM transacciones t WHERE t.id_cliente ='$id_cli_transa' AND t.fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";

					$resultado_sql_tabla_fecha=pg_query($cone,$sql_tabla_fecha);


					while($row5=pg_fetch_assoc($resultado_sql_tabla_fecha))
					{
						$tabla_fecha_in[] = $row5;
					}


					foreach ($tabla_total2 as $key1 => $value1)
					{
						foreach ($tabla_fecha_in as $key => $value) 
						{
								if ($tabla_total2[$key1]['id'] == $tabla_fecha_in[$key]['id']) 
								{
									$tabla_total3[] = $tabla_total2[$key1];
								}
						}
				    }


//echo json_encode($tabla_total3);

				    $df =1;
					echo json_encode($tabla_total3);

					$accion_transaccion="";
					$telefono_transaccion="";
					$key_transaccion= "";

			}
			if ($df ==0)
			{

				//aqui se obtiene el id del cliente utilizado el numero de telefono

					$sql_id_cliente = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_transaccion'";
					
					$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

					$fila=pg_fetch_assoc($resultado_sql_id_cliente);

					$id_cli_transa = $fila['id'];
		/*
				//aqui se obtiene la tabla transaccion para luego calcularle el saldo

		  		$sql_suma_positivos="SELECT sum(valor) AS saldo_po FROM (SELECT tr.id_cliente, tr.descripcion, tr.valor FROM transacciones tr WHERE tr.id_cliente ='$id_cli_transa' ORDER BY tr.id DESC) AS sub_tran  WHERE id_cliente = '$id_cli_transa' AND valor >0";
					$resultado_sql_suma_positivos=pg_query($cone,$sql_suma_positivos);

				//aqui obtengo el saldo que es positivo
					while ($row1=pg_fetch_assoc($resultado_sql_suma_positivos))
					{
						$cant[] = $row1['saldo_po'];
					}
					$cant_saldo_po = $cant[0];
		//echo $cant_saldo_po."<br>";
		*/
					$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion,t.observacion, t.valor, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id DESC";

					$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
					$cadena ="";

					while ($row1=pg_fetch_assoc($resultado_sql_transaccion))
					{
						$cadena = $cadena.$row1['valor']."i";
					}

					$arreglo_valor_c = explode("i",$cadena);
					//			echo $cadena;
					//var_dump($arreglo_valor_c);
					$tam = sizeof($arreglo_valor_c);
					$tam2 = $tam-1;
					//echo "<br>".$tam;

					$arreglo_valor_c = array_diff($arreglo_valor_c, array($arreglo_valor_c[$tam2]));
					//$tam3 = sizeof($arreglo_valor_c);
					//echo "<br>".$tam3."<br>";
					//$tam4 = $tam3-1;
					//var_dump($arreglo_valor_c);


					$arreglo_valor = array_reverse($arreglo_valor_c);
					//echo "<br>";
					//var_dump($arreglo_valor);

					$arreglo_valor2 = $arreglo_valor;
					//echo "<br>";
					//var_dump($arreglo_valor2);
					$cant_saldo_po2 = $cant_saldo_po;


					
					foreach($arreglo_valor as $indice=> $valor) 
					{
						if ($indice>0) 
						{
							foreach($arreglo_valor2 as $key => $value) 
							{
								if($key<$indice) 
								{

									$arreglo_valor[$indice] = $arreglo_valor[$indice]+$value;
									
									//$value = $value+$value;
								}
							}
						}
					}


		/*			
					foreach($arreglo_valor as $indice=> $valor) 
					{
						if($valor<0) 
						{
							$arreglo_valor[$indice] = $arreglo_valor[$indice]+$cant_saldo_po;
							$cant_saldo_po = $arreglo_valor[$indice];			
						}
						if($valor>=0) 
						{
							if ($cant_saldo_po2 != $cant_saldo_po) 
							{
								$arreglo_valor[$indice] = $cant_saldo_po;
							}
						}
					}

		//echo "<br>";
		//var_dump($arreglo_valor);
		*/

				//aqui se agregan los saldos calculados a la tabla transaccion
					$sql_transaccion2 = "SELECT t.id, t.fecha, t.descripcion, t.valor,t.observacion, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id DESC";
					


					$resultado_sql_transaccion2=pg_query($cone,$sql_transaccion2);
					$ind_t =0;
					$fin_bucle =0;
					while($row_t = pg_fetch_assoc($resultado_sql_transaccion2))
					{
						$tabla_total[]=$row_t;
						$ind_t = $ind_t+1;
						$d = $d+1;
					}

					$tabla_total2 = array_reverse($tabla_total);
					$tabla_total = $tabla_total2;

					//sql de la suma total del saldo
					$sql_saldo_total = "SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = '$id_cli_transa'"; 
					$resultado_sql_saldo_total=pg_query($cone,$sql_saldo_total);

					while ($row2=pg_fetch_assoc($resultado_sql_saldo_total))
					{
						$cant2[] = $row2['saldo_total'];
					}
					$cant_saldo_total = $cant2[0];


				 	$c=0;
				 	$d = $d-1;
				 	$ind_t =$ind_t-1;


					foreach ($tabla_total as $key1 => $value1)
					{
						foreach ($arreglo_valor as $key => $value) 
						{
							
							if ($c == $key) 
							{
								
								if ($ind_t == $c) 
								{
									$tabla_total[$key]['saldo']= $cant_saldo_total;
									$c = $c+1;
									$fin_bucle =1;
									break;
								}

								if ($fin_bucle==0) 
								{	
									//echo $arreglo_valor[$key]."-";
									$tabla_total[$key]['saldo'] = $arreglo_valor[$key];
									$c = $c+1;
									break;	
								}
							}
						}
				    }

		//echo "<br>";

		//var_dump($tabla_total);
					
					$tabla_total2 = array_reverse($tabla_total);


		/*			$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion,t.observacion, t.valor, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id DESC limit 10";

					$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
					$cadena ="";

					while ($row1=pg_fetch_assoc($resultado_sql_transaccion))
					{
						$cadena = $cadena.$row1['valor']."i";
					}
				//aqui se crea el el arreglo del saldo calculado
					$arreglo_valor_c = explode("i",$cadena);
					$arreglo_valor[0] = $arreglo_valor_c[9];
					$arreglo_valor[1] = $arreglo_valor_c[8];
					$arreglo_valor[2] = $arreglo_valor_c[7];
					$arreglo_valor[3] = $arreglo_valor_c[6];
					$arreglo_valor[4] = $arreglo_valor_c[5];
					$arreglo_valor[5] = $arreglo_valor_c[4];
					$arreglo_valor[6] = $arreglo_valor_c[3];
					$arreglo_valor[7] = $arreglo_valor_c[2];
					$arreglo_valor[8] = $arreglo_valor_c[1];
					$arreglo_valor[9] = $arreglo_valor_c[0];
					
					$arreglo_valor2[0] = $arreglo_valor[0];
					$arreglo_valor2[1] = $arreglo_valor[1];
					$arreglo_valor2[2] = $arreglo_valor[2];
					$arreglo_valor2[3] = $arreglo_valor[3];
					$arreglo_valor2[4] = $arreglo_valor[4];
					$arreglo_valor2[5] = $arreglo_valor[5];
					$arreglo_valor2[6] = $arreglo_valor[6];
					$arreglo_valor2[7] = $arreglo_valor[7];
					$arreglo_valor2[8] = $arreglo_valor[8];
					$arreglo_valor2[9] = $arreglo_valor[9];


					//$a =sizeof($arreglo_valor); esto no hace falta
					
					foreach($arreglo_valor as $indice=> $valor) 
					{
						if ($indice>0) 
						{
							foreach($arreglo_valor2 as $key => $value) 
							{
								if($key<$indice) 
								{

									$arreglo_valor[$indice] = $arreglo_valor[$indice]+$value;
									
									//$value = $value+$value;
								}
							}
						}
					}



				//aqui se agregan los saldos calculados a la tabla transaccion
					$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion, t.valor,t.observacion, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id DESC limit 10";
					


					$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
					$ind_t =0;
					$fin_bucle =0;
					while($row_t = pg_fetch_assoc($resultado_sql_transaccion))
					{
						$tabla_total[]=$row_t;
						$ind_t = $ind_t+1;
						$d = $d+1;
					}

					$tabla_total2 = array_reverse($tabla_total);
					$tabla_total = $tabla_total2;

					//sql de la suma total del saldo
					$sql_saldo_total = "SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = '$id_cli_transa'"; 
					$resultado_sql_saldo_total=pg_query($cone,$sql_saldo_total);

					$fila_s=pg_fetch_assoc($resultado_sql_saldo_total);

					$cant_saldo = $fila_s['saldo_total'];

				 	$c=0;
				 	$d = $d-1;
				 	$ind_t =9;

					foreach ($tabla_total as $key1 => $value1)
					{
						foreach ($arreglo_valor as $key => $value) 
						{
							
							if ($c == $key) 
							{
								
								if ($ind_t == $c) 
								{
									$tabla_total[$key]['saldo']= $cant_saldo;
									$c = $c+1;
									$fin_bucle =1;
									break;
								}

								if ($fin_bucle==0) 
								{	
									//echo $arreglo_valor[$key]."-";
									$tabla_total[$key]['saldo'] = $arreglo_valor[$key];
									$c = $c+1;
									break;	
								}
							}
						}
				    }

					
					$tabla_total2 = array_reverse($tabla_total);
		*/
					echo json_encode($tabla_total2);

					$accion_transaccion="";
					$telefono_transaccion="";
					$key_transaccion= "";



				/*
					$sql_trans = "SELECT c.id, c.nombre_cliente, c.apellido_cliente, t.descripcion FROM clientes c INNER JOIN transacciones t ON c.id = t.id_cliente WHERE t.id_cliente ='$id_cliente_trans'";

				*/
			}
		}		
	} 
	//*********************************************



	//*************esta es la parte de tarjeta de credito 
	/*
	$accion_tarjeta="accionTarjeta";
	$telefono_cliente_tarjeta =123213;
	$key_tarjeta= "123";
	*/
	if($caso_funcion == "a_tarjeta")
	{
		if(isset($_POST['telefono_cliente_tarjeta']) && isset($_POST['key_tarjeta']) )
	    {


			$telefono_cliente_tarjeta =$_POST['telefono_cliente_tarjeta'];
			$key_tarjeta= $_POST['key_tarjeta'];

		//aqui se obtiene el id del cliente utilizado el numero de telefono

			$sql_id_cliente_t = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_cliente_tarjeta'";
			
			$resultado_sql_id_cliente_t=pg_query($cone,$sql_id_cliente_t);

			$fila_t=pg_fetch_assoc($resultado_sql_id_cliente_t);

			$id_cli_t = $fila_t['id'];

		//aqui se obtiene la tabla de la Tarjeta Stripe

			$sql_tabla_tarjetas = "SELECT ta.tipo, ta.ultimos_digitos, ta.stripe_code FROM tarjetas_stripe ta WHERE ta.id_cliente = '$id_cli_t' AND ta.activo=true";

			$resultado_sql_tabla_tarjetas=pg_query($cone,$sql_tabla_tarjetas);
			

			while($row_t=pg_fetch_assoc($resultado_sql_tabla_tarjetas))
			{
				$tabla_tarjetas[]=$row_t;
			}
				
			echo json_encode($tabla_tarjetas);

			$accion_tarjeta="";
			$telefono_cliente_tarjeta ="";
			$key_tarjeta= "";
		}		
	}


	//*********************************************



	//*************esta es la parte de PERFIL 

	/*
	$accion_perfil="accionPerfil";
	$telefono_cliente_perfil =123213;
	$key_perfil= "123";
	*/
	if ($caso_funcion == "a_perfil")
	{
			if(isset($_POST['telefono_cliente_perfil']) && isset($_POST['key_perfil']) )
		    {

			$telefono_cliente_perfil =$_POST['telefono_cliente_perfil'];
			$key_perfil= $_POST['key_perfil'];
			//aqui se obtiene el id del cliente utilizado el numero de telefono

				$sql_id_cliente_p = "SELECT cli.id, cli.telefono, cli.nombre_cliente, cli.imagen FROM clientes cli WHERE cli.telefono = '$telefono_cliente_perfil'
			";
				
				$resultado_sql_id_cliente_p=pg_query($cone,$sql_id_cliente_p);

			//	$id_cli_p = $fila_p['telefono'];
			//echo $id_cli_p;
			//aqui se obtiene la tabla del PERFIL


				while($row_p = pg_fetch_assoc($resultado_sql_id_cliente_p))
				{
					$tabla_perfil[]=$row_p;
				}
					
				echo json_encode($tabla_perfil);

			$accion_perfil="";
			$telefono_cliente_perfil ="";
			$key_perfil= "";
		}	
	}

	//*********************************************************


	//***********************esta es la parte del Pago
	

/*
			$_POST['telefono_paga']=10001;
			$_POST['key_pagar'] ="123";
			$_POST['valor_de_pago'] = 50;
			$_POST['telefono_recibe']=10002;
	*/
	if ($caso_funcion == "a_pago")
	{
		if(isset($_POST['telefono_paga']) && isset($_POST['key_pagar']) && isset($_POST['valor_de_pago']) && isset($_POST['telefono_recibe']))
	    {

			$telefono_paga = $_POST['telefono_paga'];
			$key_pagar = $_POST['key_pagar'];
			$valor_de_pago = $_POST['valor_de_pago'];
			$telefono_recibe = $_POST['telefono_recibe'];
			$concepto ="";
			$concepto = $_POST['concepto'];	
			$de =0;
//aqui se valida que el saldo este igual o por encima de lo que van a transferir
		//aqui se obtiene el id del cliente que paga

			$sql_id_cliente_pa2 = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_paga'";
			

			$resultado_sql_id_cliente_pa2=pg_query($cone,$sql_id_cliente_pa2);

			$fila_pa2=pg_fetch_assoc($resultado_sql_id_cliente_pa2);

			$id_cli_pa2 = $fila_pa2['id'];

			$sql_saldo_total3 = "SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = '$id_cli_pa2'";
			$resultado_sql_saldo_total3=pg_query($cone,$sql_saldo_total3);



			while($row_pa_s = pg_fetch_assoc($resultado_sql_saldo_total3))
			{
				$sald_to[]=$row_pa_s;
			}

			$no_saldo = array(

			  0=>array('id' => 'no_saldo', 'cabecera' => 'Saldo Insuficiente', 'cuerpo' => 'Pago no realizado')
				);

			if ($sald_to[0]['saldo_total'] < $valor_de_pago) 
			{
				$de =1;
			echo json_encode($no_saldo);


			}



//aqui se valida si el numero del que paga es igual al numero del que recibe


			elseif($telefono_paga == $telefono_recibe && $de==0) 
			{
				$telefono_igual = array(
				0=>array('id' => 'telefono_igual', 'cabecera' => 'El Numero registrado es el suyo', 'cuerpo' => 'Marque el Numero al que desee pagar correctamente')
				);
				$de =1;
				echo json_encode($telefono_igual);
			}
	


//aqui se valida si el usuario a pagar existe en el sistema

			$sql_validar_recibe2 ="SELECT count(c.id) AS cant_total FROM clientes c WHERE c.telefono = '$telefono_recibe'";
			$resultado_validar_recibe2=pg_query($cone,$sql_validar_recibe2);

			while($row_pa2 = pg_fetch_assoc($resultado_validar_recibe2))
			{
				$val_usuario_recibe[]=$row_pa2;
			}



			if($val_usuario_recibe[0]['cant_total']==0 && $de == 0) 
			{
				$de =1;
				$no_usuario = array(
				0=>array('id' => 'no_usuario', 'cabecera' => 'Transaccion Fallida','cuerpo' => 'Numero de telefono o usuario no registrado, si desea invitarlo a Practic Cash, pulsa')
				);

				echo json_encode($no_usuario); 
			}

			elseif($val_usuario_recibe[0]['cant_total']>0 && $de==0) 
			{
				//$de =2;
		
		//aqui se obtiene el id del cliente que paga

			$sql_id_cliente_pa = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_paga'";
			

			$resultado_sql_id_cliente_pa=pg_query($cone,$sql_id_cliente_pa);

			$fila_pa=pg_fetch_assoc($resultado_sql_id_cliente_pa);

			$id_cli_pa = $fila_pa['id'];

		
			//aqui se obtiene el id del cliente que recibe

				$sql_id_cliente_re = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_recibe'";
				
				$resultado_sql_id_cliente_re=pg_query($cone,$sql_id_cliente_re);

				$fila_re=pg_fetch_assoc($resultado_sql_id_cliente_re);

				$id_cli_re = $fila_re['id'];


				$fecha_recibe = date("Y-m-d");
				$valor_tem_re_i = date("Y-m-d H:i:s");
				$valor_tem_re = $valor_tem_re_i." ";
			//aqui se inserta el registro de recibe dinero

				$descripcion_cli_re ="me pagaron";
				
				if($concepto=="") 
				{
					$concepto = "Sin informacion";
				}
				//$observacion_cli_re ="se hizo";
				
				$id_tarjeta_recibe =1;
				$stripe_id = "1";
				//$transaccion_id ="1";

				$sql_cliente_recibe = "INSERT INTO transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta, stripe_id,transaccion_id) VALUES('$fecha_recibe','$id_cli_re','$valor_de_pago','$descripcion_cli_re','$concepto','$id_tarjeta_recibe','$stripe_id','$valor_tem_re') 
			";

				$resultado_insertar_recibe=pg_query($cone,$sql_cliente_recibe);

			//aqui se obtiene el id despues de recibir el pago
				$sql_id_recibe = "SELECT tra.id FROM transacciones tra WHERE tra.transaccion_id = '$valor_tem_re' AND tra.id_cliente = '$id_cli_re'";

				$resultado_sql_id_recibe=pg_query($cone,$sql_id_recibe);

				$fila_recibe=pg_fetch_assoc($resultado_sql_id_recibe);

				$id_recibe = $fila_recibe['id'];
				
				//echo "id recibe: ".$id_recibe;



			//aqui se obtiene el id del cliente que paga

				$sql_id_cliente_pa = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_paga'";
				
				$resultado_sql_id_cliente_pa=pg_query($cone,$sql_id_cliente_pa);

				$fila_pa=pg_fetch_assoc($resultado_sql_id_cliente_pa);

				$id_cli_pa = $fila_pa['id'];

				$fecha_paga = date("Y-m-d");
				$valor_tem_paga_i = date("Y-m-d H:i:s");
				$valor_tem_paga = $valor_tem_paga_i." ";
			//aqui se inserta el registro de pagar dinero

				$descripcion_cli_pa ="yo pague";
				
				if($concepto=="") 
				{
					$concepto = "Sin informacion";
				}
				//$observacion_cli_pa ="se hizo";
				$id_tarjeta_paga =1;
				$stripe_id_paga = "1";
				$transaccion_id_paga ="1";


	
				$sql_cliente_paga = "INSERT INTO transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta, stripe_id,transaccion_id) VALUES('$fecha_paga','$id_cli_pa','-$valor_de_pago','$descripcion_cli_pa','$concepto','$id_tarjeta_paga','$stripe_id_paga','$valor_tem_paga') 
			";


				$resultado_insertar_pago=pg_query($cone,$sql_cliente_paga);

			//aqui se obtiene el id despues de registrar el pago
				
				$sql_id_pago = "SELECT tra.id FROM transacciones tra WHERE tra.transaccion_id = '$valor_tem_paga' AND tra.id_cliente = '$id_cli_pa'";

				$resultado_sql_id_pago=pg_query($cone,$sql_id_pago);

				$fila_pago=pg_fetch_assoc($resultado_sql_id_pago);

				$id_pago = $fila_pago['id'];
				
				//aqui se crea el hash de transaccion_id


				$fecha_paga =  $valor_tem_paga_i." ";
				$partes_fecha = explode(" ",$fecha_paga);
				$fecha_sin_es = $partes_fecha[0].$partes_fecha[1];
				$fecha_sin_p_a = explode(":",$fecha_sin_es);
				$fecha_sin_p = $fecha_sin_p_a[0].$fecha_sin_p_a[1].$fecha_sin_p_a[2];

				$fecha_sin_g_a = explode("-",$fecha_sin_p);
				$fecha_sin_g = $fecha_sin_g_a[0].$fecha_sin_g_a[1].$fecha_sin_g_a[2];
			    $fecha_limpia = $fecha_sin_g;

				$transaccion_id = $fecha_limpia.$id_cli_pa.$id_cli_re;

			//aqui se modifican los valores temporales registrados en la tabla transacciones
				$sql_guardar_transaccion_id_re ="UPDATE transacciones SET transaccion_id = '$transaccion_id' WHERE id='$id_recibe'";
				$resultado_sql_guardar_transaccion_id_re=pg_query($cone,$sql_guardar_transaccion_id_re);

				$sql_guardar_transaccion_id_pa ="UPDATE transacciones SET transaccion_id = '$transaccion_id' WHERE id = '$id_pago'";	
				$resultado_sql_guardar_transaccion_id_pa=pg_query($cone,$sql_guardar_transaccion_id_pa);


	//aqui se crea el mensaje de error en caso de que no se inserto el pago o el incremento
			$respuestas_pago = array(
				0=>array('id' => 'error_pago', 'cabecera' => 'Pago no Realizado','cuerpo' => 'Hubo un problema al conectar con la base de datos')
				);				


				$respuesta = array(
				0=>array('id' => 'success', 'cabecera' => 'Transaccion Exitosa','cuerpo' => 'Pago realizado con Exito')
				);		

			 	if($resultado_insertar_recibe==true && $resultado_insertar_pago==true)
			 	{
			  		echo json_encode($respuesta);
			 	} 
			 	else{
			  		//echo "error";
			  		echo json_encode($respuestas_pago);
			  	}

				$accion_pago = "";
				$telefono_paga = "";
				$key_pagar = "";
				$valor_de_pago ="";
				$telefono_recibe ="";

			}
		}
		

	}
	}

?>

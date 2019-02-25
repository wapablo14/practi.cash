<?php 
  include "bd.php";
  error_reporting(0);

if(isset($_POST['nombre_funcion']))
{

	$caso_funcion = $_POST['nombre_funcion'];

	if ($caso_funcion == "a_suscribir")
	{
	 if(isset($_POST['numero']) && isset($_POST['clave']) && isset($_POST['fecha_entrada']) )
		 {
		$numero_suscribir = $_POST['numero'];
		$clave_suscribir = $_POST['clave'];
		$fecha_entrada = $_POST['fecha_entrada'];

		//echo "numero suscribir: ".$numero_suscribir." clave suscribir: ".$clave_suscribir." fecha entrada: ".$fecha_entrada;


			$sql_validar_clave = "SELECT cla.id, cla.clave, cla.fecha_caducidad, cla.id_cliente FROM claves cla WHERE cla.clave = '$clave_suscribir'";

			$resultado_sql_validar_clave=pg_query($cone,$sql_validar_clave);
			$ind_clave=0;
			$ind_mensaje_cad_fe =0;

		//si encuentra la clave, se verifica la fecha si es menor que la de caducidad
		//datos de prueba:

		$fecha_p = "2019-09-01"; //formato aaaa-mm-dd

		//formato de fecha aaaa-mm-dd
		$fecha_entrada= strtotime($fecha_p);

		$nombre_cliente = "ramon";
		$es_activo ="1";
		$key_rand = rand(187,900);

			while ($row1=pg_fetch_assoc($resultado_sql_validar_clave))
			{
				if($clave_suscribir == $row1['clave']) 
				{
				$fecha_en_tabla = strtotime($row1['fecha_caducidad']);

					if($fecha_entrada > $fecha_en_tabla)
					{
						echo "error. la clave ya caduco";
						$ind_mensaje_cad_fe =1;
						break;
					}	

					$ind_clave=1;


					if($fecha_entrada <= $fecha_en_tabla)
					{

						$sql_registro_cliente ="INSERT  INTO clientes(nombre_cliente,telefono,activo,keyt) VALUES('$nombre_cliente',$numero_suscribir,'$es_activo','$key_rand')
		";
						$resultado_sql_registro_cliente=pg_query($cone,$sql_registro_cliente);

						if ($resultado_sql_registro_cliente==true) 
						{
							echo "success";
						}
						if ($resultado_sql_registro_cliente==false) 
						{
							echo "error al insertar en base de datos";
						}
						
						$ind_mensaje_cad_fe =1;
						break;
					}
					
				}

			}
		//si no se encuentra la clave, se envia mensaje de error


			if($ind_clave==0 && $ind_mensaje_cad_fe ==0) 
			{
				echo "error. no se encontro la clave";
			}
			
			$accion_suscribir = "";
			$numero_suscribir = "";
			$clave_suscribir = "";  
		}
	} 

	//************************************funcion para el saldo

	/*
	$accion_saldo="verSaldo";
	$telefono_saldo=123213; 
	$key_saldo=343;
	*/
	elseif($caso_funcion == "ver_saldo")
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
	$accion_transaccion="consultar";
	$telefono_transaccion = 4323;
	$key_transaccion = "qwe";
	*/
	elseif($caso_funcion == "a_transaccion")
	{
		if(isset($_POST['telefono_transaccion']) && isset($_POST['key_transaccion']) )
	    {


		$telefono_transaccion = $_POST['telefono_transaccion'];
		$key_transaccion = $_POST['key_transaccion'];

		//aqui se obtiene el id del cliente utilizado el numero de telefono

			$sql_id_cliente = "SELECT cli.id, cli.telefono FROM clientes cli WHERE cli.telefono = '$telefono_transaccion'";
			
			$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

			$fila=pg_fetch_assoc($resultado_sql_id_cliente);

			$id_cli_transa = $fila['id'];

		//aqui se obtiene la tabla transaccion para luego calcularle el saldo

			$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion, t.valor, t.id_cliente AS saldo FROM transacciones t WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id limit 10";
			$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
			$cadena ="";

			while ($row1=pg_fetch_assoc($resultado_sql_transaccion))
			{
				$cadena = $cadena.$row1['valor']."i";
			}
		//aqui se crea el el arreglo del saldo calculado
			$arreglo_valor_c = explode("i",$cadena);
			$arreglo_valor[0] = $arreglo_valor_c[0];
			$arreglo_valor[1] = $arreglo_valor_c[1];
			$arreglo_valor[2] = $arreglo_valor_c[2];
			$arreglo_valor[3] = $arreglo_valor_c[3];
			$arreglo_valor[4] = $arreglo_valor_c[4];
			$arreglo_valor[5] = $arreglo_valor_c[5];
			$arreglo_valor[6] = $arreglo_valor_c[6];
			$arreglo_valor[7] = $arreglo_valor_c[7];
			$arreglo_valor[8] = $arreglo_valor_c[8];
			$arreglo_valor[9] = $arreglo_valor_c[9];
			
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


			$a =sizeof($arreglo_valor);

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
			$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion, t.valor, t.id_cliente AS saldo FROM transacciones t WHERE t.id_cliente = '$id_cli_transa' ORDER BY t.id limit 10";
			


			$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
			$ind_t =0;
			$fin_bucle =0;
			while($row_t = pg_fetch_assoc($resultado_sql_transaccion))
			{
				$tabla_total[]=$row_t;
				$ind_t = $ind_t+1;
				$d = $d+1;
			}

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



			echo json_encode($tabla_total);

			$accion_transaccion="";
			$telefono_transaccion="";
			$key_transaccion= "";



		/*
			$sql_trans = "SELECT c.id, c.nombre_cliente, c.apellido_cliente, t.descripcion FROM clientes c INNER JOIN transacciones t ON c.id = t.id_cliente WHERE t.id_cliente ='$id_cliente_trans'";

		*/
		}		
	} 
	//*********************************************



	//*************esta es la parte de tarjeta de credito 
	/*
	$accion_tarjeta="accionTarjeta";
	$telefono_cliente_tarjeta =123213;
	$key_tarjeta= "123";
	*/
	elseif($caso_funcion == "a_tarjeta")
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

			$sql_tabla_tarjetas = "SELECT ta.tipo, ta.ultimos_digitos FROM tarjetas_stripe ta WHERE ta.id_cliente = '$id_cli_t' AND ta.activo=true";

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
	elseif ($caso_funcion == "a_perfil")
	{
			if(isset($_POST['telefono_cliente_perfil']) && isset($_POST['key_perfil']) )
		    {

			$telefono_cliente_perfil =$_POST['telefono_cliente_perfil'];
			$key_perfil= $_POST['key_perfil'];
			//aqui se obtiene el id del cliente utilizado el numero de telefono

				$sql_id_cliente_p = "SELECT cli.id, cli.telefono, cli.nombre_cliente, cli.apellido_cliente FROM clientes cli WHERE cli.telefono = '$telefono_cliente_perfil'
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
	$accion_pago = "pagar";
	$telefono_paga = 123213;
	$key_pagar = "123";
	$valor_de_pago =5200;
	$telefono_recibe = 4323;
	*/
	elseif ($caso_funcion == "a_pago")
	{
		if(isset($_POST['telefono_paga']) && isset($_POST['key_pagar']) && isset($_POST['valor_de_pago']) && isset($_POST['telefono_recibe']))
	    {

			$telefono_paga = $_POST['telefono_paga'];
			$key_pagar = $_POST['key_pagar'];
			$valor_de_pago = $_POST['valor_de_pago'];
			$telefono_recibe = $_POST['telefono_recibe'];
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
			$observacion_cli_re ="se hizo";
			$id_tarjeta_recibe =1;
			$stripe_id = "1";
			//$transaccion_id ="1";

			$sql_cliente_recibe = "INSERT INTO transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta, stripe_id,transaccion_id) VALUES('$fecha_recibe','$id_cli_re','$valor_de_pago','$descripcion_cli_re','$observacion_cli_re','$id_tarjeta_recibe','$stripe_id','$valor_tem_re') 
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
			$observacion_cli_pa ="se hizo";
			$id_tarjeta_paga =1;
			$stripe_id_paga = "1";
			$transaccion_id_paga ="1";

			$sql_cliente_paga = "INSERT INTO transacciones(fecha,id_cliente,valor,descripcion,observacion,id_tarjeta, stripe_id,transaccion_id) VALUES('$fecha_paga','$id_cli_pa','-$valor_de_pago','$descripcion_cli_pa','$observacion_cli_pa','$id_tarjeta_paga','$stripe_id_paga','$valor_tem_paga') 
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



echo $valor_tem_paga." ".$valor_tem_re;
		//echo $transaccion_id;
		//aqui se construye el arreglo que despues sera convertido en json
			$respuesta = array('id_transaccion' => $transaccion_id, 'mensa' => 'ok');

		 	if($resultado_insertar_recibe==true && $resultado_insertar_pago==true)
		 	{
		  		//echo json_encode($respuesta);
		 	}
		 	else
		  	{
		  		echo "error";
		  	}

			$accion_pago = "";
			$telefono_paga = "";
			$key_pagar = "";
			$valor_de_pago ="";
			$telefono_recibe ="";

		}
		

	}
	}

?>

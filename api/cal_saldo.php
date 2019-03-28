<?php 





ini_set('display_errors', 1);
error_reporting(E_ALL);

//require __DIR__ . '/twilio-php-master/Twilio/autoload.php';
  include "bd.php";

include '../librerias/twilio-php-master/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'ACe204ca84c384c61b2bd93e34b2c3ff8b';
$token = 'f092612038e50ee2a558b1695e273d5d';
$client = new Client($sid, $token);

try {
// Use the client to do fun stuff like send text messages!
$client->messages->create('+580426821063',array(
	'from' => '+14245433110','body' => "jajajajaja1"));

} catch (Services_Twilio_RestException $exception) {
	$exception->getCode(); 
    // Unhandled exception:
    throw $exception;
}

echo "ffffttt";


/*
include "bd.php";

$numero_suscribir ="10002";
			$sql_id_cliente = "SELECT cli.id, cli.telefono, cli.imagen FROM clientes cli WHERE cli.telefono = '$numero_suscribir'";
			
			$resultado_sql_id_cliente=pg_query($cone,$sql_id_cliente);

			$fila=pg_fetch_assoc($resultado_sql_id_cliente);

			$id_cli = $fila['id'];



			$nom_imagen = $fila['imagen'];




			if($nom_imagen!="no_imagen") 
			{
				$ind_n_i = explode("#",$nom_imagen);


				if ($ind_n_i[1]=='1')
				{
					$nuevo_nombre = $id_cli."-2019-03-05-03-04-56"."#2#";
				}
				if ($ind_n_i[1]=='2')
				{
					$nuevo_nombre = $id_cli."-2019-03-05-03-04-56"."#1#";
				}
			}
			if($nom_imagen=="no_imagen") 
			{
				$nuevo_nombre = $id_cli."-2019-03-05-03-04-56"."#2#";	
			}
			echo $nuevo_nombre;
			*/
/*
$nuevo_nombre = date("Y-m-d-H-i-s");
//$nuevo_nombre = explode(" ",$nuevo_nombre);
//$tam = sizeof($nuevo_nombre);
echo $nuevo_nombre;

var_dump($nuevo_nombre);
*/



/*
include "bd.php";

				$fecha_inicial = '2019-02-03'; 
				$fecha_final = '2019-03-01';
				$telefono_transaccion = 10002;

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

//AQUI SE CREA LA TABLA QUE ESTA FILTRADA POR LA FECHA
					$sql_tabla_fecha = "SELECT t.id, t.fecha, t.descripcion FROM transacciones t WHERE t.id_cliente ='$id_cli_transa' AND t.fecha BETWEEN '$fecha_inicial' AND '$fecha_final' limit 10";

					$resultado_sql_tabla_fecha=pg_query($cone,$sql_tabla_fecha);


					while($row4=pg_fetch_assoc($resultado_sql_tabla_fecha))
					{
						$tabla_fecha_in[] = $row4;
					}



					foreach ($tabla_total2 as $key1 => $value1)
					{
						foreach ($tabla_fecha_in as $key => $value) 
						{
								if ($tabla_total[$key1]['id'] == $tabla_fecha_in[$key]['id']) 
								{
									$tabla_total3[] = $tabla_total2[$key];
								}
						}
				    }

					
//var_dump($tabla_fecha_in);
*/
?>
<!--
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>


<div class="container">
	<div>
		<form action="cal_saldo.php" id="insertar_pelicula" enctype="multipart/form-data">
			<input type="text" name="nombre_imagen" placeholder="nombre de la imagen">
			<input type="file" name="imagen">
		<input type="submit" value="Insertar imagen">	
		</form>
		
	</div>
	

	<div id="respuesta">
		
	</div>
</div>

-->
<!--
	<div class="container">
		<h4>Selecciona el Numero de Filas</h4>
		<div class="form-group">
			<select name="state" id="maxRows" class="form-control" style="width:150px;">
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				
			</select>
			

		<div class="Tabla">
			<br><br><br><br>
            
          <table  id="mitabla" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Movimiento</th>
                <th>Cantidad</th>
                <th>Saldo</th>
              </tr>
            </thead>
            <tbody id="tabla_general_movimientos">

			</tbody>
		</table>


		<div class="pagination-container">
			<nav>
				<ul class="pagination"></ul>
			</nav>
		</div>
	</div>

-->
<script type="text/javascript">
/*	$(document).ready(function(){

		$("#insertar_pelicula").submit(insertarPelicula)
		function insertarPelicula(event){
			event.preventDefault();
			//alert("sssss");
			
			var datos = new FormData($("#insertar_pelicula")[0]);
			alert(datos);
			$.ajax({
				url:'primero.php',
				type: 'POST',
				data: datos,
				contentType: false, /*para no permitir envio de datos get*/
/*				processData: false,/*para no convertir los datos en forma de texto*/
/*				success: function(data){
					$("#respuesta").html(data);
				}
			}); 
		}


	}); */
/*	$(document).ready(function(){

	var dataString5="nombre_funcion="+"a_transaccion"+"&telefono_transaccion="+"10002"+"&key_transaccion="+"232";

	$.ajax({
			type: "POST",
			url:"../api/api.php",
			data: dataString5,
			crossDomain: true,
			cache: false,

			success: function(data){

				var datos_tabla_general_m =$('#tabla_general_movimientos');
				var datosString5 = $.parseJSON(data);
				console.log(datosString5);
				$.each(datosString5,function(i,field){

				var fecha=field.fecha;
				var descripcion=field.descripcion;
				var valor = field.valor;
				var saldo=field.saldo;
				var concepto = field.nombre_cliente;

				var dia_ini = fecha.substring(8,10);
    			var mes_ini = fecha.substring(5,7);
    			var anio_ini = fecha.substring(0,4);
    			var fecha2 =dia_ini+'-'+mes_ini+'-'+anio_ini;
			
				
			if(valor <0)
			{ 
				datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td style="color:red;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');
			}
			if(valor>=0)
			{
				datos_tabla_general_m.append('<tr><td>'+fecha2+'</td><td>'+concepto+'</td><td style="color:#00FF00;">'+valor+'</td><td>'+'$'+saldo+'</td></tr>');	
			}


//////////////////

			$('.pagination').html('');
			var trnum = 0;
			//aqui obtiene el valor de la lista de numeros de registros
			var maxRows = 10;
//aqui calcula la cantidad de registros que hay en la tabla			
			var totalRows = $(table+' tbody tr').length;
			//alert(totalRows);
			$(table+' tr:gt(0)').each(function(){
				trnum++;
				if(trnum > maxRows)
				{
					$(this).hide();
				}
				if (trnum <= maxRows)
				{
					$(this).show();
				}
			});

			if (totalRows > maxRows)
			{
				var pagenum = Math.ceil(totalRows/maxRows);
				for(var i = 1; i <=pagenum;)
				{
					$('.pagination').append('<li data-page="'+i+'" >\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
				}
			}
//aqui se pone en activo la primera casilla de la paginacion			
			$('.pagination li:first-child').addClass('active');
				
				$('.pagination li').on('click', function(){
					var pageNum = $(this).attr('data-page');
					var trIndex = 0;
					$('.pagination li').removeClass('active');
					$(this).addClass('active');
				
						$(table+' tr:gt(0)').each(function(){
							trIndex++;
							if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows))
							{
								$(this).hide();
							}else{
								$(this).show();
							}
						});

				});
		




//////////////////////
			});


			}



		})	


///////////////////////////////////////////


		var table = "#mitabla";
		$('#maxRows').on('change', function(){
			//alert("rrrr");
			$('.pagination').html('');
			var trnum = 0;
			//aqui obtiene el valor de la lista de numeros de registros
			var maxRows = parseInt($(this).val());
//aqui calcula la cantidad de registros que hay en la tabla			
			var totalRows = $(table+' tbody tr').length;
			//alert(totalRows);
			$(table+' tr:gt(0)').each(function(){
				trnum++;
				if(trnum > maxRows)
				{
					$(this).hide();
				}
				if (trnum <= maxRows)
				{
					$(this).show();
				}
			});
			if (totalRows > maxRows)
			{
				var pagenum = Math.ceil(totalRows/maxRows);
				for(var i = 1; i <=pagenum;)
				{
					$('.pagination').append('<li data-page="'+i+'" >\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show();
				}
			}
//aqui se pone en activo la primera casilla de la paginacion			
			$('.pagination li:first-child').addClass('active');
			$('.pagination li').on('click', function(){
				var pageNum = $(this).attr('data-page');
				var trIndex = 0;
				$('.pagination li').removeClass('active');
				$(this).addClass('active');
				$(table+' tr:gt(0)').each(function(){
					trIndex++;
					if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows))
					{
						$(this).hide();
					}else{
						$(this).show();
					}
				});
			});
		}); */

	/*	$(function(){
			$('table tr:eq(0)').prepend('<th>10</th>');
			var id =0;
			//$('table tr:gt(0)')..prepend('<td>'+id+'</td>');
			$('table tr:gt(0)').each(function(){
				id++;
				$(this).prepend('<td>'+id+'</td>');

			});*/
		/*});*/ 
	//});
</script>
<!--
	<div class="container-fluid">
		<br>
		<nav>
			<ul class="pagination pagination-lg">
				<li class="disabled"><a href="#">&laquo;</a></li>
				<li class="active"><a href="">1</a></li>
				<li><a href="">2</a></li>
				<li><a href="">3</a></li>
				<li><a href="">4</a></li>
				<li><a href="">5</a></li>
				<li><a href="#">&raquo;</a></li>
			</ul>
		</nav>
	</div>
-->
<!--
</body>
</html>
-->

<?php

/*


  		$sql_suma_positivos="SELECT sum(valor) AS saldo_po FROM (SELECT tr.id_cliente, tr.descripcion, tr.valor FROM transacciones tr WHERE tr.id_cliente =6 ORDER BY tr.id DESC limit 10) AS sub_tran  WHERE id_cliente = 6 AND valor >0";
			$resultado_sql_suma_positivos=pg_query($cone,$sql_suma_positivos);

		//aqui obtengo el saldo que es positivo
			while ($row1=pg_fetch_assoc($resultado_sql_suma_positivos))
			{
				$cant[] = $row1['saldo_po'];
			}
			$cant_saldo_po = $cant[0];
echo $cant_saldo_po."<br>";


			$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion,t.observacion, t.valor, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '6' ORDER BY t.id DESC limit 10";

			$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
			$cadena ="";

			while ($row1=pg_fetch_assoc($resultado_sql_transaccion))
			{
				$cadena = $cadena.$row1['valor']."i";
			}

$arreglo_valor_c = explode("i",$cadena);
			echo $cadena;
var_dump($arreglo_valor_c);
$tam = sizeof($arreglo_valor_c);
$tam2 = $tam-1;
echo "<br>".$tam;

$arreglo_valor_c = array_diff($arreglo_valor_c, array($arreglo_valor_c[$tam2]));
$tam3 = sizeof($arreglo_valor_c);
echo "<br>".$tam3."<br>";
$tam4 = $tam3-1;
var_dump($arreglo_valor_c);


$arreglo_valor = array_reverse($arreglo_valor_c);
echo "<br>";
var_dump($arreglo_valor);

$arreglo_valor2 = $arreglo_valor;
echo "<br>";
var_dump($arreglo_valor2);

$cant_saldo_po2 = $cant_saldo_po;

			foreach($arreglo_valor as $indice=> $valor) 
			{
					//foreach($arreglo_valor2 as $key => $value) 
					//{
						if($valor<0) 
						{

							$arreglo_valor[$indice] = $arreglo_valor[$indice]+$cant_saldo_po;
							$cant_saldo_po = $arreglo_valor[$indice];
							
							//$value = $value+$value;
						}
						if($valor>=0) 
						{
							if ($cant_saldo_po2 != $cant_saldo_po) 
							{
								$arreglo_valor[$indice] = $cant_saldo_po;
							}
						}						
					//}
				
			}

echo "<br>";
var_dump($arreglo_valor);


		//aqui se agregan los saldos calculados a la tabla transaccion
			$sql_transaccion2 = "SELECT t.id, t.fecha, t.descripcion, t.valor,t.observacion, c.nombre_cliente, t.id_cliente AS saldo FROM transacciones t INNER JOIN clientes c ON t.id_cliente = c.id WHERE t.id_cliente = '6' ORDER BY t.id DESC limit 10";
			


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
			$sql_saldo_total = "SELECT sum(t.valor) AS saldo_total FROM transacciones t WHERE t.id_cliente = '6'"; 
			$resultado_sql_saldo_total=pg_query($cone,$sql_saldo_total);

			while ($row2=pg_fetch_assoc($resultado_sql_saldo_total))
			{
				$cant2[] = $row2['saldo_total'];
			}
			$cant_saldo_total = $cant2[0];


		 	$c=0;
		 	$d = $d-1;
		 	$ind_t =$ind_t-1;


//echo "<br>".$cant_saldo_total."<br>".$ind_t."<br>".$d."<br>";

//var_dump($tabla_total);


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

*/
/*	}
	echo $cadena."<br>"."<br>";

	$arreglo_valor = explode("i",$cadena);
	$arreglo_valor2 = $arreglo_valor;
	
	$a =sizeof($arreglo_valor);
	$a = $a-1;
	foreach($arreglo_valor as $indice=> $valor) 
	{
		if ($indice>0 && $indice!=$a) 
		{
			foreach($arreglo_valor2 as $key => $value) 
			{
				if($key<$indice) 
				{
					$arreglo_valor[$indice] = $arreglo_valor[$indice]+$value;
				}
			}
		}

    	//echo $indice."<br>";
	}


				foreach($arreglo_valor2 as $key => $value) 
			{
				echo $value."<br>";
			}

	$sql_transaccion = "SELECT t.id, t.fecha, t.descripcion, t.valor, t.id_cliente AS saldo FROM transacciones t WHERE t.id_cliente = 1";
	
	$resultado_sql_transaccion=pg_query($cone,$sql_transaccion);
 	//$tabla_total=pg_fetch_assoc($resultado_sql_transaccion);
 	
	while($row_p = pg_fetch_assoc($resultado_sql_transaccion))
	{
		$tabla_total[]=$row_p;
	}


 	$c=0;
	//while ($tabla_total)
	
	foreach ($tabla_total as $key1 => $value1)
	{
		//echo $tabla_total['valor'];
		foreach ($arreglo_valor as $key => $value) 
		{
			if ($c == $key) 
			{
				$tabla_total['valor']= $arreglo_valor[$key];
				//echo $tabla_total['valor'];
				$c = $c+1;
				break;
			}
			//echo $value."<br>";
		}
    }
*/
/*
		foreach ($arreglo_valor as $key => $value) 
		{
				echo $arreglo_valor[$key];
				
			}

*/
//var_dump($tabla_total);

//echo json_encode($tabla_total);

/*
	foreach($tabla_total as $indice=> $valor)
	{
		echo $tabla_total[$indice]."<br>";
	}
*/
/*	foreach($arreglo_valor as $indice=> $valor)
	{
		echo $valor."<br>";
	}
*/
?>
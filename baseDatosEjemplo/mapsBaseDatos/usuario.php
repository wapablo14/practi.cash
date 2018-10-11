<?php
  session_start();
  require_once("datos.php");
  $con = mysqli_connect($host, $user, $pass, $db_name) or die('Error con la conexion de la base de datos');

  if (isset($_POST['Categoria']) && !empty($_POST['Categoria'])) {
    $ct = $_POST['Categoria'];
      $query = "select * from Marcador where Categoria = $ct";
      $result = mysqli_query($con, $query);   
      $rows = $result->num_rows;
      if($rows == 0){
          $_SESSION['busqVac'] = "No se ha encontrado ningun marcador con esta categoria";
          
      }
  } else {
      $_SESSION['busqError'] = "Selecciona una categoria por favor";

  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>plantilla para phonegap</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- touchSwipe library -->
	<script src="http://labs.rampinteractive.co.uk/touchSwipe/jquery.touchSwipe.min.js"></script>
	<!-- Sliding swipe menu javascript file -->
	<script src="js/menuDesplegable/jquery.slideandswipe.js"></script>
	<link rel="stylesheet" href="css/styleMenu.css" type="text/css" media="all">
	
<style>
	#div{
	    width: 100%;
	    font-size: 5px; font-weight:bold; text-align:center;
	    padding-top: 5px; word-wrap:break-word;
	}
	
	#map {
        height: 510px;
        width: 100%;
	}
	
	@media screen and (max-width: 767px) {
		.sidenav {
        height: auto;
        padding: 15px;
		}
		.row.content {height:auto;} 
    }
	
	button[type=submit] {
		height: 30px;
		width: 100%;
		margin: 10px auto;
		border: 25px ;
		border-radius: 25px;
		background-color: #0174DF;
		color: white;
	}
</style>
</head>
<body>

<div class="caja">
	<div id="div" style="background: linear-gradient( 90deg, #77C32A, #1F73B4,  #54358B); "></div>
</div>  
<div class="container-fluid">
	<div class="row">
		<div class="topnav">
		<!-- Centered link -->
		<div class="topnav-centered">
			<a href="#home" class="active">Inicio</a>
		</div> 
		
		<!-- Left-aligned links (default) -->
  
		<!-- Right-aligned links -->
		<div class="topnav-right">
			<main>
				<a href="#" id="menu" class="ssm-toggle-nav" title="open nav"><i class="fas fa-bars"></i></a>
			</main>
		</div>
		</div>
	</div>
	
<nav class="nav">
	<div id="mySidenav" class="contenedor-menu" data-status="disabled">
		<div class="row menu-lateral">
			<div class="col-xs-6">
				<a>Nombre Usuario </a>
			</div>
			<div class="col-xs-6">
				<img src="img/fotoUsuario.png">
			</div>
		</div>
		<div class="row">
			<ul class="nav menu" role="tablist">
				<li><a href="#" id="botonMapa">Categoria</a></li>
				</br>
				<li><a>
				<form method="POST" action="usuario.php" name="form-select">
				
                <?php
                  $query = "select * from Categoria";
                  $rows = mysqli_query($con, $query);
                  echo "<select class='form-control' name='Categoria'><option value=''>Seleccion.</option>";
                  while($row = mysqli_fetch_array($rows)){
                      extract($row);
                      echo "<option value='$idCategoria'>$Nombre</option>";
                  }
                  echo "</select>";
                  mysqli_close($con);
                ?>  
				</br>
                <button type="submit" class="" name="buscar_cat" >Buscar</button>
				
			</form>
            <?php
                if (isset($_SESSION['busqError'])) {
                    echo $_SESSION['busqError'];
                    unset($_SESSION['busqError']);
                }
                if (isset($_SESSION['busqVac'])) {
                    echo $_SESSION['busqVac'];
                    unset($_SESSION['busqVac']);
                }
            ?>
			</a>
			</li>
			<li><a href="#">Cerrar Sesion<i class="icono derecha fas fa-angle-right"></i></a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="row-content">
	<div class="ssm-overlay ssm-toggle-nav"></div>
</div>

<div class="row">
	</br>
    <div id="map"></div>
</div>
</div>
<script src="js/menuLateral.js"></script>
<script type="text/javascript" src="../cordova.js"></script>
<script>
      function initMap() {
        	var divMapa = document.getElementById('map');
          var xhttp;
          var resultado = [];
          var markers = [];
          var infowindowActivo = false;

          xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
              resultado = xhttp.responseText;
              var objeto_json = JSON.parse(resultado);

              for (var i = 0; i < objeto_json.length; i ++) {
                var latlong = objeto_json[i][2].split(',');
                myLatLng = { 
                    lat: Number(latlong[0]),
                    lng: Number(latlong[1])
                };
                markers[i] = new google.maps.Marker({
                  position: myLatLng,
                  map: map,
                  title: objeto_json[i][0]
                });
                
                var contentString = '<h1 id="firstHeading" class="firstHeading">' + 
                    objeto_json[i][0] + '</h1>'+ '<div id="bodyContent">'+
                    '<p><b>' + objeto_json[i][0] + '</b></p><p>' + objeto_json[i][1] +
                    '</p></div>';

                markers[i].infoWindow = new google.maps.InfoWindow({
                  content: contentString
                });

                google.maps.event.addListener(markers[i], 'click', function(){      
                  if(infowindowActivo){
                    infowindowActivo.close();
                  }                  
                  infowindowActivo = this.infoWindow;
                  infowindowActivo.open(map, this);
                });
              }
            }
          };
          
          var myLatLng = { 
              lat: -0.1969833,
              lng: -78.4808664
          };

          var map = new google.maps.Map(divMapa,{
            zoom: 15,
            center: myLatLng
          });

          var tipo = <?php echo $ct; ?>;
          var url = "marcador.php?tipo="+tipo;
          xhttp.open("POST", url, true);
          xhttp.send();
      }   
    </script>
	<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXTM8tcD_fVL09AEKUKhFyundS8el6C70&callback=initMap"></script>
</body>
</html>

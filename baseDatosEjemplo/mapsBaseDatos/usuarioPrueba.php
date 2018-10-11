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
<html>
  <head>
    <title>Mapa Ejemplo</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      #map {
        height: 400px;
        width: 100%;
      }
    </style>
  </head>
  <body>
	<form method="POST" action="usuario.php" name="form-select">
             <p>ELIGE UNA CATEGORIA</p>
             <p>Categoria:</p> 
                <?php
                  $query = "select * from Categoria";
                  $rows = mysqli_query($con, $query);
                  echo "<select name='Categoria'><option value=''></option>";
                  while($row = mysqli_fetch_array($rows)){
                      extract($row);
                      echo "<option value='$idCategoria'>$Nombre</option>";
                  }
                  echo "</select>";
                  mysqli_close($con);
                ?>
                </br></br>
                <input type="submit" value="Buscar" name="buscar_cat" >
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
    <h1>Mapa Ejemplo</h1>
    <div id="map"></div>
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
    <a href="usuario.php">Volver</a>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXTM8tcD_fVL09AEKUKhFyundS8el6C70&callback=initMap"></script>
  </body>
</html>
<?php 
//para servidor practic.cash:
  $con="host=ticketfacil.ec port=5432 dbname=practic password=practicash@2019 user=pabloreyes";

  //para servidor local:
  //$con="host=localhost port=5432 dbname=practic password=123456 user=postgres";
  
  $cone=pg_connect($con);

/***********PARAMETROS PARA CONFIGURAR OTRA CUENTA DE TWILIO************/
  //$sid1 = '';//aqui colocar el sid de la cuenta de twilio, esto aparece en la pantalla principal al ingresar usuario en twilio
  //$token1 = '';//aqui colocar el token de la cuenta twilio,  esto aparece en la pantalla principal al ingresar usuario en twilio
  //$telefono_twilio = '';//aqui colocar el numero de telefono que genera twilio, esta en la parte de "Phone Numbers"
	//si usan esta parte descomenten las variables correspondientes y comenten las variables de la cuenta de Pablo
/***********************************************************************/
  /********PARAMETROS DE LA CUENTA TWILIO DE PABLO********/
  $sid1 = 'ACe204ca84c384c61b2bd93e34b2c3ff8b';
  $token1 = 'f092612038e50ee2a558b1695e273d5d';
  $telefono_twilio = '+14245433110';//este es numero de telefono de la cuenta twilio de pablo que enviara los mensajes

  /********************************************************/
?>

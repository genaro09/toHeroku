<?php
include '../php/funciones.php';
date_default_timezone_set('America/El_Salvador');
$dateTime = date("Y-m-d H:i:s");
//Cerremos todos los dias que estan entre las dos fechas y eliminemos los que no estan cerrados o aprobados
$data=CloseAllExtraTime("2017-04-01","2017-04-30","222");
if($data[0]==1){
  //$data= setIfExtraTimePayMore("2017-04-01","2017-04-30",350.00,"99999999-9","99999999-9","222",$dateTime);
}
echo "1:".$data[0]." 2:".$data[1];
 ?>

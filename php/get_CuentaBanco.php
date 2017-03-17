<?php
include '../php/funciones.php';
$idCuenta=$_POST["id"];
$NumeroDocumento=$_POST["NumeroDocumento"];
$cuentasBanco=getCuentaBanco($NumeroDocumento,$idCuenta);
if($cuentasBanco[1]==0){
  echo '<input id="CuentaBanco" type="number" class="form-control" placeholder="NO TIEN CUENTA" >';
}else{
  echo '<input id="CuentaBanco" type="number" class="form-control" placeholder="KHE" value="'.$cuentasBanco[0].'">';
}
 ?>

<?php
include '../php/funciones.php';
$cnx=cnx();
$Fecha="2017-04-14";
$NitEmpresa="222";

$query=sprintf("SELECT * FROM dias_asueto_codigo_trabajo WHERE tipoDiaAsueto=0");
$resul=mysqli_query($cnx,$query);
$fechaVacacion= explode("-", $Fecha);
while($row=mysqli_fetch_array($resul)){
  if ((strcmp($row["Dia"], (string)$fechaVacacion[2])== 0)&&(strcmp($row["Mes"], (string)$fechaVacacion[1])== 0)) {
    $DiaEsDeVacacion=1;
    echo "es un dia";
  }
}
mysqli_close($cnx);
 ?>

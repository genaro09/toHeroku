<?php
include '../php/funciones.php';
//getIfExtraTimePayMore($FechaIni,$FechaFin,$SalarioNominal,$NumeroDocumento,$year);
//DiscountsTimeEmploy($FechaIni,$FechaFin,"99999999-9");
//giveSemanalTimeAndIfDiurnOrNoctu($NumeroDocumento,$Semana,$annio);

$cnx = cnx();
$AreSomething=0;//Si vamos a mostrar la alerta de que alguien se paso
$FechaInicio = "2017-3-1";
$FechaFin = "2017-3-31";
$TPago = "10";
$FPago = 0;
$NitEmpresa="222";
$NombrePor = "Genaro Alberto";
$NumeroDocumentoPor="99999999-9";
date_default_timezone_set('America/El_Salvador');
$dateTime = date("Y-m-d H:i:s");
//$NDocumentoArray = '{"0":"99999999-9","1":"02335971-1","2":"03107931-7"}';
$NDocumentoArray = '{"0":"99999999-9"}';
$NDocumentoArray = json_decode("$NDocumentoArray", true);
//nombrePor
$str="";
for($i=0;$i<count($NDocumentoArray);$i++){
  //el valor de los DUI's esta en $NDocumentoArray[$i]
  $empleado=getInfoEmpleado($NDocumentoArray[$i]);
  $data=getIfExtraTimePayMore($FechaInicio,$FechaFin,$empleado->getSalarionominal(),$NDocumentoArray[$i]);
  if($data[0]==1){
    $AreSomething=1;
    for($j=0;$j<count($data[1]);$j++){
      $str=$str.$data[1][$j]["NombreEmpleado"]." tiene un exeso de ".$data[1][$j]["TotaPagar"]." en la semana ".$data[1][$j]["Semana"]."<br>";
    }
  }
}
echo $AreSomething." %&$ ".$str;
 ?>

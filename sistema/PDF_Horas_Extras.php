<?php
include_once '../php/cn.php';
$FechaHotasExtras=$_POST['FechaHorasExtras'];
$NitEmpresa=$_POST['NitEmpresa'];
$cnx=cnx();
//Nombre Empresa
$query=sprintf("SELECT * FROM empresa where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
$result=mysqli_query($cnx,$query);
$row=mysqli_fetch_array($result);
$NombreEmpresa=$row["NombreEmpresa"];
//FIN N EMpresa

$query=sprintf("SELECT horas_extras.*,emp1.PrimerNombre AS PrimerNombre1,emp1.PrimerApellido AS PrimerApellido1,emp1.SegundoApellido AS SegundoApellido1,emp2.PrimerNombre AS PrimerNombre2,emp2.PrimerApellido AS PrimerApellido2,emp2.SegundoApellido AS SegundoApellido2 FROM horas_extras INNER JOIN empleado emp1 INNER JOIN empleado emp2 WHERE horas_extras.NumeroDocumentoPor=emp2.NumeroDocumento AND horas_extras.NumeroDocumentoPara=emp1.NumeroDocumento AND horas_extras.Fecha='%s' AND horas_extras.NitEmpresa='%s' ORDER BY horas_extras.NumeroDocumentoPor ASC",mysqli_real_escape_string($cnx,$FechaHotasExtras),mysqli_real_escape_string($cnx,$NitEmpresa));
$result=mysqli_query($cnx,$query);
$NumeroDeS=0;//Cambio de Supervisor??
$NumeroColAux=0;
$data;
//Sacar datos de la BD
$row=mysqli_fetch_array($result);
$NumeroDocumentoPor=$row["NumeroDocumentoPor"];
$nombreAux=$row["PrimerNombre2"]." ".$row["PrimerApellido2"]." ".$row["SegundoApellido2"];
$data[$NumeroDeS][$NumeroColAux]=array("Nombre" => $nombreAux, "NHD" => 0, "NHN" => 0,"D" =>0,"H"=>0);
$NumeroColAux++;
$n=0;
do{
  if($NumeroDocumentoPor!=$row["NumeroDocumentoPor"]){
    $NumeroDocumentoPor=$row["NumeroDocumentoPor"];
    $NumeroDeS++;
    $NumeroColAux=0;
    $nombreAux=$row["PrimerNombre2"]." ".$row["PrimerApellido2"]." ".$row["SegundoApellido2"];
    $data[$NumeroDeS][$NumeroColAux]=array("Nombre" => $nombreAux, "NHD" => 0, "NHN" => 0,"D" =>0,"H"=>0);
    $NumeroColAux++;
  }
  $nombreAux=$row["PrimerNombre1"]." ".$row["PrimerApellido1"]." ".$row["SegundoApellido1"];
  $data[$NumeroDeS][$NumeroColAux]=array("Nombre" => $nombreAux, "NHD" => $row["NHorasDiurnas"], "NHN" => $row["NHorasNocturnas"],"D" =>$row["Desde"],"H"=>$row["Hasta"]);
  $NumeroColAux++;
} while($row=mysqli_fetch_array($result));
mysqli_close($cnx);
//IMPRIMIR LA DATA
$str="";
$n=0;
$encabezado="";
$bloque="";
$NumeroDePagina=1;
$tiempoTotalD=0;//tiempo total Diurno
$tiempoTotalN=0;//Tiempo total Nocturno
$numeroPaginas=contarCuantasPaginas($data);
for($i=0;$i<sizeof($data);$i++){
  $j=0;
  $encabezado=generarEncabezado($data[$i][$j]["Nombre"],$FechaHotasExtras,$NombreEmpresa);
  $str="";
  $n=0;
  $j++;
  for($j;$j<sizeof($data[$i]);$j++){
    $nAUX=$n+1;
    $str=$str.'
     <tr>
       <td style="width:5%"><font size="3">'.$nAUX.'</font></td>
       <td style="width:27%"><font size="2">'.$data[$i][$j]["Nombre"].'</font></td>
       <td style="width:11%"><font size="3">'.$data[$i][$j]["NHD"].'</font></td>
       <td style="width:11%"><font size="3">'.$data[$i][$j]["NHN"].'</font></td>
       <td style="width:10%"><font size="3">'.$data[$i][$j]["D"].'</font></td>
       <td style="width:10%"><font size="3">'.$data[$i][$j]["H"].'</font></td>
       <td style="width:24%"><font size="3"></font></td>
     </tr>
    ';
    $tiempoTotalD += toSeconds($data[$i][$j]["NHD"]);
    $tiempoTotalN += toSeconds($data[$i][$j]["NHN"]);
    $n++;
    if(($n % 35 == 0)&&$n!=0){
      $str=$str.'
      <tr>
        <td style="width:5%"><font size="3"></font></td>
        <td style="width:27%"><font size="2">Total</font></td>
        <td style="width:11%"><font size="3">'.toTime($tiempoTotalD).'</font></td>
        <td style="width:11%"><font size="3">'.toTime($tiempoTotalN).'</font></td>
        <td style="width:10%"><font size="3"></font></td>
        <td style="width:10%"><font size="3"></font></td>
        <td style="width:24%"><font size="3"></font></td>
      </tr>
      ';
      $bloque=$bloque.$encabezado.$str.'</table></div><div style="margin-top: 70px;">Pagina: '.$NumeroDePagina.' de '.$numeroPaginas.'</div></div>';
      $tiempoTotalD=0;//tiempo total Diurno
      $tiempoTotalN=0;//Tiempo total Nocturno
      $str="";
      $NumeroDePagina++;
    }
  }
  //LLenar el cuadro
  if(!($n % 35 == 0)&&$n!=0){
    for($k=0;$k<36-$n;$k++){
      $str=$str.'
      <tr>
        <td style="width:5%"><font size="3"><br></font></td>
        <td style="width:27%"><font size="2"></font></td>
        <td style="width:11%"><font size="3"></font></td>
        <td style="width:11%"><font size="3"></font></td>
        <td style="width:10%"><font size="3"></font></td>
        <td style="width:10%"><font size="3"></font></td>
        <td style="width:24%"><font size="3"></font></td>
      </tr>
      ';
    }
  }
  //Fin de llenado del cuadro
  $str=$str.'
    <tr>
      <td style="width:5%"><font size="3"></font></td>
      <td style="width:27%"><font size="2">Total</font></td>
      <td style="width:11%"><font size="3">'.toTime($tiempoTotalD).'</font></td>
      <td style="width:11%"><font size="3">'.toTime($tiempoTotalN).'</font></td>
      <td style="width:10%"><font size="3"></font></td>
      <td style="width:10%"><font size="3"></font></td>
      <td style="width:24%"><font size="3"></font></td>
    </tr>
  ';
  $bloque=$bloque.$encabezado.$str.'</table></div><div style="margin-top: 70px;">Pagina: '.$NumeroDePagina.' de '.$numeroPaginas.'</div></div>';
  $NumeroDePagina++;
  $tiempoTotalD=0;//tiempo total Diurno
  $tiempoTotalN=0;//Tiempo total Nocturno
}
//Para hacer el PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <title>ASCAS, S.A. DE C.V.</title>
    <style>
    #cuerpo{
      height:100%
    }
    #encabezado{
      width :100%;
      text-align:center;
    }
    #texCuadro{
      width :100%;
      text-align:center;
      border:1px solid black;
      padding: 3px;
    }
    #SaF_Cuadro{
      width :100%;
      text-align:left;
      border:1px solid black;
      border-top:0px;
    }
    table{
      width :100%;
      text-align:center;
    }
    table, th, td{
      border: 1px solid black;
      border-top:0px;
      border-collapse: collapse;
    }
    </style>
</head>
<body>
'.$bloque.'
</body>
</html>

';


//==============================================================
//==============================================================
//==============================================================
include("../MPDF/mpdf.php");
$mpdf=new mPDF('c');
$mpdf->WriteHTML($html);
$NombreArchivo="REF.pdf";
$mpdf->Output($NombreArchivo, 'I');
exit;

//==============================================================
//==============================================================
//==============================================================
function generarEncabezado($Nombre,$FechaHotasExtras,$NombreEmpresa){
  $encabezado='
  <div id="cuerpo">
    <div id="encabezado">
    <h3 style="margin-top:0px;">
    '.$NombreEmpresa.'
    </h3>
    </div>
    <div id="texCuadro">
    <font size="4">
    Documento para el control de horas en jornadas extraordinaria laboradas por los trabajadores de manera voluntaria
    </font>
    </div>
    <div id="SaF_Cuadro"><font size="4">
    Supervisor: '. $Nombre.'
    </font></div>
    <div id="SaF_Cuadro"><font size="4">
    Fecha:'. $FechaHotasExtras.'
    </font></div>
    <div>
      <table>
        <tr>
          <td style="width:5%"><font size="3">#</font></td>
          <td style="width:27%"><font size="3">Nombre del trabajador</font></td>
          <td style="width:11%"><font size="3">Numero de horas diurnas</font></td>
          <td style="width:11%"><font size="3">Numero de horas nocturnas</font></td>
          <td style="width:10%"><font size="3">Desde</font></td>
          <td style="width:10%"><font size="3">Hasta</font></td>
          <td style="width:24%"><font size="3">Firma</font></td>
        </tr>
  ';
  return $encabezado;
}
function toSeconds($time) {
   $parts = explode(':', $time);
   return 3600*$parts[0] + 60*$parts[1] + $parts[2];
}

function toTime($seconds) {
    $hours = floor($seconds/3600);
    $hoursTP=$hours;
    if($hoursTP<10){
      $hoursTP="0".$hoursTP;
    }
    $seconds -= $hours * 3600;
    $minutes = floor($seconds/60);
    $minutesTP=$minutes;
    if($minutesTP<10){
      $minutesTP="0".$minutesTP;
    }
    $seconds -= $minutes * 60;
    $secondsTP=$seconds;
    if($secondsTP<10){
      $secondsTP="0".$secondsTP;
    }
    return $hoursTP . ':' . $minutesTP . ':' . $secondsTP;
}

 function contarCuantasPaginas($data){
   $numeroPaginas=0;
   for($i=0;$i<sizeof($data);$i++){
    $j=1;
    $n=0;
    for($j;$j<sizeof($data[$i]);$j++){
      if(($n % 35 == 0)&&$n!=0){
        $numeroPaginas++;
      }
    }
    $numeroPaginas++;
  }
  return $numeroPaginas;
 }

?>

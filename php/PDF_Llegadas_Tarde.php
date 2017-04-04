<?php
include_once '../php/cn.php';
$cnx=cnx();
if(trim($_POST['idLlegadasTarde']) == ""){
  header('Location: ../sistema/Reporte_Llegadas_Tarde.php');
  exit();
}
//Datos de las horas extras
$idLlegadasTarde =$_POST["idLlegadasTarde"];
$query=sprintf("SELECT * FROM llegadas_tarde  where idLlegadasTarde='%s'",mysqli_real_escape_string($cnx,$idLlegadasTarde));
$result=mysqli_query($cnx,$query);
$row=mysqli_fetch_array($result);
$FechaHotasExtras=$row["Fecha"];
$NitEmpresa=$row["NitEmpresa"];
//Nombre Empresa
$query=sprintf("SELECT * FROM empresa where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
$result=mysqli_query($cnx,$query);
$row=mysqli_fetch_array($result);
$NombreEmpresa=$row["NombreEmpresa"];
//FIN N EMpresa

$query=sprintf("SELECT col_llegadas_tarde.*,emp1.PrimerNombre AS PrimerNombre1,emp1.PrimerApellido AS PrimerApellido1,emp1.SegundoApellido AS SegundoApellido1,emp2.PrimerNombre AS PrimerNombre2,emp2.PrimerApellido AS PrimerApellido2,emp2.SegundoApellido AS SegundoApellido2 FROM col_llegadas_tarde INNER JOIN llegadas_tarde INNER JOIN empleado emp1 INNER JOIN empleado emp2 WHERE col_llegadas_tarde.idLlegadasTarde=llegadas_tarde.idLlegadasTarde AND col_llegadas_tarde.NumeroDocumentoPor=emp2.NumeroDocumento AND col_llegadas_tarde.NumeroDocumento=emp1.NumeroDocumento AND llegadas_tarde.idLlegadasTarde='%s' ORDER BY col_llegadas_tarde.idLlegadasTarde ASC",mysqli_real_escape_string($cnx,$idLlegadasTarde));
$result=mysqli_query($cnx,$query);
$NumeroDeS=0;//Cambio de Supervisor??
$NumeroColAux=0;
$data;
//Sacar datos de la BD
$row=mysqli_fetch_array($result);
$NumeroDocumentoPor=$row["NumeroDocumentoPor"];
$nombreAux=$row["PrimerNombre2"]." ".$row["PrimerApellido2"]." ".$row["SegundoApellido2"];
$data[$NumeroDeS][$NumeroColAux]=array("Nombre" => $nombreAux, "HSD" => 0, "HSH" => 0,"D" =>0,"H"=>0,"T"=>0);
$NumeroColAux++;
$n=0;
do{
  if($NumeroDocumentoPor!=$row["NumeroDocumentoPor"]){
    $NumeroDocumentoPor=$row["NumeroDocumentoPor"];
    $NumeroDeS++;
    $NumeroColAux=0;
    $nombreAux=$row["PrimerNombre2"]." ".$row["PrimerApellido2"]." ".$row["SegundoApellido2"];
    $data[$NumeroDeS][$NumeroColAux]=array("Nombre" => $nombreAux, "HSD" => 0, "HSH" => 0,"D" =>0,"H"=>0,"T"=>0);
    $NumeroColAux++;
  }
  $nombreAux=$row["PrimerNombre1"]." ".$row["PrimerApellido1"]." ".$row["SegundoApellido1"];
  $data[$NumeroDeS][$NumeroColAux]=array("Nombre" => $nombreAux, "HSD" => $row["HSDesde"], "HSH" => $row["HSHasta"],"D" =>$row["Desde"],"H"=>$row["Hasta"],"T"=>$row["Tiempo"]);
  $NumeroColAux++;
} while($row=mysqli_fetch_array($result));
mysqli_close($cnx);
//IMPRIMIR LA DATA
$str="";
$n=0;
$encabezado="";
$bloque="";
$NumeroDePagina=1;
$tiempoTotal=0;//tiempo total
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
       <td style="width:11%"><font size="3">'.$data[$i][$j]["HSD"].'</font></td>
       <td style="width:11%"><font size="3">'.$data[$i][$j]["HSH"].'</font></td>
       <td style="width:10%"><font size="3">'.$data[$i][$j]["D"].'</font></td>
       <td style="width:10%"><font size="3">'.$data[$i][$j]["H"].'</font></td>
       <td style="width:24%"><font size="3">'.$data[$i][$j]["T"].'</font></td>
     </tr>
    ';
    $tiempoTotal += toSeconds($data[$i][$j]["T"]);
    $n++;
    if(($n % 35 == 0)&&$n!=0){
      $str=$str.'
      <tr>
        <td style="width:5%"><font size="3"></font></td>
        <td style="width:27%"><font size="2">Total</font></td>
        <td style="width:11%"><font size="3"></font></td>
        <td style="width:11%"><font size="3"></font></td>
        <td style="width:10%"><font size="3"></font></td>
        <td style="width:10%"><font size="3"></font></td>
        <td style="width:24%"><font size="3">'.toTime($tiempoTotal).'</font></td>
      </tr>
      ';
      $bloque=$bloque.$encabezado.$str.'</table></div><div style="margin-top: 70px;">Pagina: '.$NumeroDePagina.' de '.$numeroPaginas.'</div></div>';
      $tiempoTotal=0;//tiempo total
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
      <td style="width:11%"><font size="3"></font></td>
      <td style="width:11%"><font size="3"></font></td>
      <td style="width:10%"><font size="3"></font></td>
      <td style="width:10%"><font size="3"></font></td>
      <td style="width:24%"><font size="3">'.toTime($tiempoTotal).'</font></td>
    </tr>
  ';
  $bloque=$bloque.$encabezado.$str.'</table></div><div style="margin-top: 70px;">Pagina: '.$NumeroDePagina.' de '.$numeroPaginas.'</div></div>';
  $NumeroDePagina++;
  $tiempoTotal=0;//tiempo total
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
$NombreArchivo=$FechaHotasExtras.".pdf";
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
    Documento para el control de horas horas tarde
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
          <td style="width:11%"><font size="3">Horario Entrada</font></td>
          <td style="width:11%"><font size="3">Horario Salida</font></td>
          <td style="width:10%"><font size="3">Llegada Tarde Desde</font></td>
          <td style="width:10%"><font size="3">Llegada Tarde Hasta</font></td>
          <td style="width:24%"><font size="3">Tiempo</font></td>
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

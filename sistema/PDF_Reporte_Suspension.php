<?php
include '../php/funciones.php';
include '../php/verificar_sesion.php';
if((trim($_POST['opc']) == "")){
  header('Location: Reporte_Suspension.php');
  exit();
}
if($_POST["opc"]==0){
  if(!(empty($_POST["DiaInicio"])||empty($_POST["DiaFin"]))){
    $flag=1;//1 todo bien
    if($flag==1){
      $fechaIni=$_POST["DiaInicio"];
      list($dd,$mm,$yyyy) = explode('/',$fechaIni);
      if (checkdate($mm,$dd,$yyyy)) {
        $fechaIni = str_replace('/', '-', $fechaIni);
        $fechaIni  = date('Y-m-d', strtotime($fechaIni));
        if(verify_date_format($fechaIni)){
        }else $flag=0;
      }else $flag=0;
    }
    if($flag==1){
      $fechaFin=$_POST["DiaFin"];
      list($dd,$mm,$yyyy) = explode('/',$fechaFin);
      if (checkdate($mm,$dd,$yyyy)) {
        $fechaFin = str_replace('/', '-', $fechaFin);
        $fechaFin  = date('Y-m-d', strtotime($fechaFin));
        if(verify_date_format($fechaFin)){
        }else $flag=0;
      }else $flag=0;
    }
    if($flag==0){
      echo "0, El formato de las fechas es incorrecto";
    }
    if($flag==1){
      if(($fechaIni>$fechaFin)){
        echo "0, La fecha de inicio no puede ser mayor a la de fin";
        $flag=0;
      }
    }
    if($flag==1){
      echo "1,";
    }
  }else {
    echo "0, Primero ingrese fechas";
  }
}elseif ($_POST["opc"]==1) {
  //vamos a imprimir el PDF
  $cnx = cnx();
  $NitEmpresa=$_SESSION["empresa"];
  $empresa=getInfoEmpresa($NitEmpresa);
  $FechaIni=$_POST["FechaInicio"];
  $FechaFin=$_POST["FechaFinal"];
  $FechaIni = str_replace('/', '-', $FechaIni);
  $FechaIni  = date('Y-m-d', strtotime($FechaIni));
  $FechaFin = str_replace('/', '-', $FechaFin);
  $FechaFin  = date('Y-m-d', strtotime($FechaFin));
  //Sacar datos

  $query=sprintf("SELECT suspension.*,empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM suspension INNER JOIN departamento INNER JOIN cargos INNER JOIN empleado WHERE departamento.NitEmpresa='%s' AND cargos.idDepartamento=departamento.idDepartamento AND cargos.idCargos=empleado.idCargos AND empleado.NumeroDocumento=suspension.NumeroDocumento AND suspension.EstadoSuspension!=0 AND suspension.Fecha BETWEEN '%s' AND '%s' ORDER BY suspension.Fecha ASC",mysqli_real_escape_string($cnx,(string)$NitEmpresa),mysqli_real_escape_string($cnx,(string)$FechaIni),mysqli_real_escape_string($cnx,(string)$FechaFin));

  $result=mysqli_query($cnx,$query);
  $count=0;
  $data = array('');
  while($row=mysqli_fetch_array($result)){
    if($row["TipoSuspension"]==1){
      $TipoSuspension="Descontar 1 Dia";
    }else{
      $TipoSuspension="ERROR";
    }
    $data[$count]=array('Nombre' => $row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"],'Fecha' => $row["Fecha"] ,'TipoSuspension' => $TipoSuspension,'Descripcion' => $row["Descripcion"]);
    $count++;
  }
  $numeroPaginas=contarCuantasPaginas($data);
  $encabezado="";
  $bloque="";
  $user = $_SESSION['usuario_sesion'];
  $NombreGenerdoPor=$user->getPrimernombre()." ".$user->getSegundonombre()." ".$user->getPrimerapellido()." ".$user->getSegundoapellido();
  $empresa=getInfoEmpresa($NitEmpresa);
  $NombreEmpresa=$empresa->getNombreempresa();
  $encabezado=generarEncabezado($NombreGenerdoPor,$FechaIni,$FechaFin,$NombreEmpresa);
  $NumeroDePagina=1;
  $str="";
  $nAUX=0;
  $i=0;
  if($count>0){
    for($i=0;$i<sizeof($data);$i++){
      $nAUX++;
      $str=$str.'
         <tr>
           <td style="width:5%";height:25px;><font size="3">'.$nAUX.'</font></td>
           <td style="width:35%;height:25px;"><p style="font-size:10px;overflow-x: scroll;white-space: nowrap;width:100%;">'.$data[$i]["Nombre"].'</p></td>
           <td style="width:10%;height:25px;"><font size="3">'.$data[$i]["Fecha"].'</font></td>
           <td style="width:20%;height:25px;"><font size="3">'.$data[$i]["TipoSuspension"].'</font></td>
           <td style="width:30%;height:25px;"><p style="font-size:9px;overflow-x: scroll;white-space: nowrap;width:100%;">'.$data[$i]["Descripcion"].'</p></td>
         </tr>
        ';
      if(($i % 25 == 0)&&$i!=0){
        $bloque=$bloque.$encabezado.$str.'</table></div><div style="margin-top: 70px;">Pagina: '.$NumeroDePagina.' de '.$numeroPaginas.'</div></div>';
        $str="";
        $NumeroDePagina++;
        $encabezado=generarEncabezado($NombreGenerdoPor,$FechaIni,$FechaFin,$NombreEmpresa);
      }
    }
  }else{
    $i=1;
  }
  //LLenar el cuadro
  if(!($i % 25 == 0)&&$i!=0){
    for($k=0;$k<26-$i;$k++){
      $str=$str.'
      <tr>
        <td style="width:5%;height:25px;"><font size="3"><br></font></td>
        <td style="width:35%height:25px;"><font size="2"></font></td>
        <td style="width:10%height:25px;"><font size="3"></font></td>
        <td style="width:20%height:25px;"><font size="3"></font></td>
        <td style="width:30%height:25px;"><font size="3"></font></td>
      </tr>
      ';
    }
  }
  //Fin de llenado del cuadro
  $bloque=$bloque.$encabezado.$str.'</table></div><div style="margin-top: 70px;">Pagina: '.$NumeroDePagina.' de '.$numeroPaginas.'</div></div>';

  //FIN
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


  mysqli_close($cnx);
  include("../MPDF/mpdf.php");
  $mpdf=new mPDF('c');
  $mpdf->WriteHTML($html);
  $NombreArchivo="Suspension-".$FechaIni."-".$FechaFin.".pdf";
  $mpdf->Output($NombreArchivo, 'I');
  exit;
}else{
  echo "2, ERROR intento de inyeccion de js. Informando...";
}
function contarCuantasPaginas($data){
  $numeroPaginas=1;
  for($i=0;$i<sizeof($data);$i++){
     if(($i % 25 == 0)&&$i!=0){
       $numeroPaginas=$numeroPaginas+1;
     }
 }
 return $numeroPaginas;
}
function generarEncabezado($Nombre,$FechaIni,$FechaFin,$NombreEmpresa){
  $encabezado='
  <div id="cuerpo">
    <div id="encabezado">
    <h3 style="margin-top:0px;">
    '.$NombreEmpresa.'
    </h3>
    </div>
    <div id="texCuadro">
    <font size="4">
    Empleados suspendidos
    </font>
    </div>
    <div id="SaF_Cuadro"><font size="4">
    Generado Por: '. $Nombre.'
    </font></div>
    <div id="SaF_Cuadro"><font size="4">
    Desde:'. $FechaIni.' Hasta:'.$FechaFin.'
    </font></div>
    <div>
      <table>
        <tr>
          <td style="width:5%"><font size="3">#</font></td>
          <td style="width:35%"><font size="3">Nombre del trabajador</font></td>
          <td style="width:10%"><font size="3">Fecha</font></td>
          <td style="width:20%"><font size="3">Suspension</font></td>
          <td style="width:30%"><font size="3">Descripcion</font></td>
        </tr>
  ';
  return $encabezado;
}

?>

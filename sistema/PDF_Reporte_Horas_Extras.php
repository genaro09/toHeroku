<?php
include '../php/funciones.php';
include '../php/verificar_sesion.php';
if((trim($_POST['opc']) == "")){
  header('Location: Reporte_Horas_Extras.php');
  exit();
}
$NitEmpresa = $_SESSION['empresa'];
$empresa=getInfoEmpresa($NitEmpresa);
$opc = $_POST['opc'];
if($opc==0){
  if((trim($_POST['FechaInicio']) == "")||(trim($_POST['Departamento']) == "")||(trim($_POST['TipoReporte']) == "")){
    header('Location: Reporte_Horas_Extras.php');
    exit();
  }
    $Fecha = $_POST['FechaInicio'];
    $Departamento = $_POST['Departamento'];
    $TipoReporte = $_POST['TipoReporte'];
    //Revisar el Tipo de Reporte
    $Fecha=explode("/",$Fecha);
    $days=cal_days_in_month(CAL_GREGORIAN,$Fecha[0],$Fecha[1]);
    $TipoReporte = str_split($TipoReporte);
    if($TipoReporte[0]==1){
      $FechaInicio=$Fecha[1]."-".$Fecha[0]."-"."1";//Y-M-D
      $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$days;//Y-M-D
    }elseif ($TipoReporte[0]==2) {
      //Catorcenal
      $dayI=($TipoReporte[1]-1)*14;
      $dayF=($TipoReporte[1])*14;
      if($dayI==0){
        $dayI=1;
      }else $dayI=$dayI+1;
      if($dayF>$days){
        $dayF=$days;
      }
      $FechaInicio=$Fecha[1]."-".$Fecha[0]."-".$dayI;//Y-M-D
      $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$dayF;//Y-M-D
    }elseif ($TipoReporte[0]==3) {
        //quincenal
        $dayI=($TipoReporte[1]-1)*15;
        $dayF=($TipoReporte[1])*15;
        if($dayI==0){
          $dayI=1;
        }else $dayI=$dayI+1;
        if($dayF>16){
          $dayF=$days;
        }
        $FechaInicio=$Fecha[1]."-".$Fecha[0]."-".$dayI;//Y-M-D
        $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$dayF;//Y-M-D
    }elseif ($TipoReporte[0]==4) {
        //Semanal
        $dayI=($TipoReporte[1]-1)*7;
        $dayF=($TipoReporte[1])*7;
        if($dayI==0){
          $dayI=1;
        }else $dayI=$dayI+1;
        if($dayF>$days){
          $dayF=$days;
        }
        $FechaInicio=$Fecha[1]."-".$Fecha[0]."-".$dayI;//Y-M-D
        $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$dayF;//Y-M-D
      }else{
        echo "2,'','',''";
        break;
      }

    //FIN
    $str="";
    $cnx=cnx();
    $query=sprintf("SELECT * FROM horas_extras WHERE horas_extras.EstadoHorasExternas=1 AND horas_extras.NitEmpresa='%s' AND horas_extras.Fecha BETWEEN '%s' AND '%s'",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
    $result=mysqli_query($cnx,$query);
    while ($row=mysqli_fetch_array($result)) {
      $str=$str."<div class='col-md-6'>".$row["Fecha"]."</div>";
    }
    echo "3,".$str.",".$FechaInicio.",".$FechaFin;
}
if($opc==1){
  date_default_timezone_set('America/El_Salvador');
  $thisDateTime=date('m/d/Y h:i:s a', time());
  $cnx=cnx();
  if((trim($_POST['FechaInicio']) == "")||(trim($_POST['FechaFin']) == "")||(trim($_POST['Departamento']) == "")||(trim($_POST['TPago']) == "")){
    header('Location: Reporte_Horas_Extras.php');
    exit();
  }
  $Nombre= $_SESSION['usuario_sesion']->getPrimernombre()." ".$_SESSION['usuario_sesion']->getPrimerapellido()." ".$_SESSION['usuario_sesion']->getSegundoapellido();
  $TipoPago=$_POST['TPago'];//1 Mensual, 2 y 3 quincenal, 4 semanal
  $TipoPago=str_split($TipoPago);
  //Tipo de Pago para tomar en consideracion para la RENTA
  if($TipoPago[0]==1){//mensual
    $tipoRenta=1;
  }elseif(($TipoPago[0]==2) || ($TipoPago[0]==3)){
    # code...
    $tipoRenta=2;
  }elseif(($TipoPago[0]==2) || ($TipoPago[0]==3)){
    # code...
    $tipoRenta=3;
  }
  $TRAMO1= array();
  $TRAMO2= array();
  $TRAMO3= array();
  $TRAMO4= array();
  //array('' => , )
  $query=sprintf("SELECT * FROM renta WHERE tipo_pago='%s' ",mysqli_real_escape_string($cnx,$tipoRenta));
  $result=mysqli_query($cnx,$query);
  $j=1;
  while($row=mysqli_fetch_array($result)) {
    if(strcmp($row["nombre_tramo"],"I Tramo")==0){
      $TRAMO1=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
    }
    elseif(strcmp($row["nombre_tramo"],"II Tramo")==0){
      $TRAMO2=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
    }
    elseif(strcmp($row["nombre_tramo"],"III Tramo")==0){
      $TRAMO3=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
    }
    elseif(strcmp($row["nombre_tramo"],"IV Tramo")==0){
      $TRAMO4=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
    }else{
      $RENTA=99999999;
    }
  }
  $j=0;
  //FIN
  $TipoPago=$TipoPago[0]."0";
  $FechaInicio  = $_POST['FechaInicio'];
  $FechaFin  = $_POST['FechaFin'];
  $Departamento = $_POST['Departamento'];
  if($Departamento==0){
    $NombreDepartamentoArray;
    $idDepartamentoArray;
    $i=0;
    $query=sprintf("SELECT * FROM departamento WHERE NitEmpresa='%s' ",mysqli_real_escape_string($cnx,$NitEmpresa));
    $result=mysqli_query($cnx,$query);
    while ($row=mysqli_fetch_array($result)) {
      $idDepartamentoArray[$i]=$row["idDepartamento"];
      $NombreDepartamento=getInfoDepartamentos($row["idDepartamento"]);
      $NombreDepartamentoArray[$i]=$NombreDepartamento->getNombredepartamento();
      $i++;
    }
  }else{
    $NombreDepartamentoArray;
    $idDepartamentoArray[0]=$Departamento;
    $NombreDepartamento =getInfoDepartamentos($Departamento);
    $NombreDepartamentoArray[0]=$NombreDepartamento->getNombredepartamento();
  }
  $i=0;
  $flagHayFechas=0;
  $str="";
  $query=sprintf("SELECT * FROM horas_extras WHERE horas_extras.EstadoHorasExternas=1 AND horas_extras.NitEmpresa='%s' AND horas_extras.Fecha BETWEEN '%s' AND '%s'",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $str=$str."idHorasExtras=".$row["idHorasExtras"]."-";
    $flagHayFechas=1;
  }
  $strAux=explode("-",$str);
  $str="";
  if($flagHayFechas==0){
    $str="idHorasExtras=0";
  }else{
    for($i=0;$i<sizeof($strAux)-1;$i++){
      if($i==sizeof($strAux)-2){
        $str=$str." ".$strAux[$i];
      }else $str=$str.$strAux[$i]." OR ";
    }
  }

  //Buscamos todos los documentos para poder buscar si tienen horas extras en vacacion o no
  //SELECT NumeroDocumentoPara FROM col_horas_extras WHERE (idHorasExtras=2 or idHorasExtras=3 OR idHorasExtras=10 OR idHorasExtras=15) GROUP BY NumeroDocumentoPara

  //Desde aqui hay que ver cuantos Departamentos hay
  $htmlFinal="";
  for($m=0;$m<sizeof($idDepartamentoArray);$m++){
      $i=0;
      $NumeroDocumentosArray= array();
      $NombresArray= array();
      $SalarioNominalArray= array();
      $query=sprintf("SELECT NumeroDocumentoPara, empleado.SalarioNominal, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM col_horas_extras INNER JOIN empleado INNER JOIN cargos INNER JOIN htrabajo INNER JOIN turno WHERE empleado.NumeroDocumento=htrabajo.NumeroDocumento AND htrabajo.idTurno=turno.idTurno AND turno.Periodo_Pago='%s' AND empleado.idCargos=cargos.idCargos AND cargos.idDepartamento='%s' AND empleado.NumeroDocumento=col_horas_extras.NumeroDocumentoPara AND  (".$str.") GROUP BY NumeroDocumentoPara",mysqli_real_escape_string($cnx,$TipoPago),mysqli_real_escape_string($cnx,$idDepartamentoArray[$m]));
      $result=mysqli_query($cnx,$query);
      while ($row=mysqli_fetch_array($result)) {
        $NumeroDocumentosArray[$i]=$row["NumeroDocumentoPara"];
        $NombresArray[$i]=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
        $SalarioNominalArray[$i]=$row["SalarioNominal"];
        $i++;
      }
      //Calculo total de minutos trabajados guardar en un array
      $HorasDiurnasArray= array();
      $HorasDiurnasVacaArray= array();
      $HorasNocturnasArray= array();
      $HorasNocturnasVacaArray= array();
      $tabla="";
      //SELECT  SEC_TO_TIME( SUM( TIME_TO_SEC( NHorasNocturnas ) ) ) AS timeSum FROM col_horas_extras WHERE NumeroDocumentoPara="99999999-9"
      for($i=0;$i<sizeof($NumeroDocumentosArray);$i++){
        //Sin vacacion
        $query=sprintf("SELECT NumeroDocumentoPara,SEC_TO_TIME(SUM(TIME_TO_SEC(NHorasDiurnas))) AS SHD,SEC_TO_TIME(SUM(TIME_TO_SEC(NHorasNocturnas)))AS SHN  FROM col_horas_extras WHERE col_horas_extras.DiaVacacion=0 AND (".$str.") AND NumeroDocumentoPara='%s'",mysqli_real_escape_string($cnx,$NumeroDocumentosArray[$i]));
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_array($result);
        if($row[0]!=""){
          $HorasDiurnasArray[$i]=$row["SHD"];
          $HorasNocturnasArray[$i]=$row["SHN"];
          //HAY
        }else{
          $HorasDiurnasArray[$i]="00:00:00";
          $HorasNocturnasArray[$i]="00:00:00";
        }
        //Con vacacion
        $query=sprintf("SELECT NumeroDocumentoPara,SEC_TO_TIME(SUM(TIME_TO_SEC(NHorasDiurnas))) AS SHD,SEC_TO_TIME(SUM(TIME_TO_SEC(NHorasNocturnas)))AS SHN  FROM col_horas_extras WHERE col_horas_extras.DiaVacacion=1 AND (".$str.") AND NumeroDocumentoPara='%s'",mysqli_real_escape_string($cnx,$NumeroDocumentosArray[$i]));
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_array($result);
        if($row[0]!=""){
          $HorasDiurnasVacaArray[$i]=$row["SHD"];
          $HorasNocturnasVacaArray[$i]=$row["SHN"];
          //HAY
        }else{
          $HorasDiurnasVacaArray[$i]="00:00:00";
          $HorasNocturnasVacaArray[$i]="00:00:00";
        }
      }
      $NPAGINA=1;
      $body="";
      $bodyAux='
        <div class="row">
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
            <h3 style="text-align: center;font-weight: bold;">
              '.$empresa->getNombreempresa().'
              <br>
              PLANTILLA DE HORAS EXTRAS ORDINARIAS Y EXTRAORDINARIAS
              <br>
              '.$NombreDepartamentoArray[$m].'
              <br>
              PERIODO DESDE '.$FechaInicio.' AL '.$FechaFin.'
            </h3>
          </div>
          <div class="col-md-4">
          </div>
        </div>
        <br>
        <div class="row" style="height:72%">
          <div class="col-md-12">
            <table>
              <tr>
                <th width="2%"><span style="font-size:10px;">N*</span></th>
                <th width="12%"><span style="font-size:10px;">NOMBRE DEL EMPLEADO</span></th>
                <th width="5%"><span style="font-size:10px;">SUELDO MENSUAL</span></th>
                <th width="5%"><span style="font-size:10px;">MINUTOS DIURNOS </span></th>
                <th width="5%"><span style="font-size:10px;">VALOR MINUTOS DIURNOS </span></th>
                <th width="5%"><span style="font-size:10px;">MINUTOS NOCTURNOS</span></th>
                <th width="5%"><span style="font-size:10px;">VALOR MINUTOS NOCTURNOS</span></th>
                <th width="5%"><span style="font-size:10px;">MINUTOS DIURNOS EN VACACION</span></th>
                <th width="5%"><span style="font-size:10px;">VALOR MINUTOS DIURNOS EN VACACION</span></th>
                <th width="5%"><span style="font-size:10px;">MINUTOS NOCTURNOS EN VACACION</span></th>
                <th width="5%"><span style="font-size:10px;">VALOR MINUTOS NOCTURNOS EN VACACION</span></th>
                <th width="5%"><span style="font-size:10px;">TOTAL GENERAL</span></th>
                <th width="5%"><span style="font-size:10px;">ISS</span></th>
                <th width="5%"><span style="font-size:10px;">AFPS</span></th>
                <th width="5%"><span style="font-size:10px;">RENTA</span></th>
                <th width="5%"><span style="font-size:10px;">TOTAL DEDUCIBLE</span></th>
                <th width="5%"><span style="font-size:10px;">LIQUIDO A RECIBOR</span></th>
                <th width="11%"><span style="font-size:10px;">FIRMA</span></th>
              </tr>
              <tr>
      ';
      $bodyAuxFin="
            </tr>
            </table>
            </div>
          </div>
          <div class='row'>
                          <div id='textbox'>
                          <p class='alignleft' style='float:left;font-weight: bold;'>Pagina N.".$NPAGINA."<br>".$thisDateTime."</p>
                          </div>
                          <div style='clear: both;'></div>
                          <div class='col-md-4'>
                            <h5 style='text-align: center;font-weight: bold;'>
                              ELABORADO POR: <br>".$Nombre."
                            </h5>
                          </div>
                        </div>
      ";
      $body=$bodyAux;
      $TMD=0;
      $TMN=0;
      $TVMD=0;
      $TVMN=0;
      $VTMD=0.00;
      $VTMN=0.00;
      $VTVMD=0.00;
      $VTVMN=0.00;
      $VTG=0.00;
      $TISS=0.00;
      $TAFP=0.00;
      $TTDD=0.00;
      $TLRC=0.00;
      $iAUX=0;
      for($i=0;$i<sizeof($NumeroDocumentosArray);$i++){
        //TimeToMinut
        $MD=TimeToMinut($HorasDiurnasArray[$i]);
        $MN=TimeToMinut($HorasNocturnasArray[$i] );
        $MVD=TimeToMinut($HorasDiurnasVacaArray[$i]);
        $MVN=TimeToMinut($HorasNocturnasVacaArray[$i]);
        $SalarioN=number_format((float)$SalarioNominalArray[$i], 2, '.', '');
        $ValorMinuto=number_format(((float)$SalarioNominalArray[$i])/30/8/60, 4, '.', '');
        $ValorMD=number_format($ValorMinuto*2*$MD, 2, '.', '');
        $ValorMN=number_format($ValorMinuto*2.25*$MN, 2, '.', '');
        $ValorMVD=number_format($ValorMinuto*4*$MVD, 2, '.', '');
        $ValorMVN=number_format($ValorMinuto*4.5*$MVN, 2, '.', '');
        $TG=$ValorMD+$ValorMN+$ValorMVD+$ValorMVN;
        $ISS=number_format($TG*0.03, 2, '.', '');
        $AFP=number_format($TG*0.0625, 2, '.', '');
        $RENTA=calculoDeRentaHE($TG,$TRAMO1,$TRAMO2,$TRAMO3,$TRAMO4);
        $TOTD=$ISS+$AFP+$RENTA;
        $LR=$TG-$TOTD;
        //Valores totales
        $TMD=$TMD+$MD;
        $TMN=$TMN+$MN;
        $TVMD=$TVMD+$MVD;
        $TVMN=$TVMN+$MVN;
        $VTMD=number_format($VTMD+$ValorMD, 2, '.', '');
        $VTMN=number_format($VTMN+$ValorMN, 2, '.', '');
        $VTVMD=number_format($VTVMD+$ValorMVD, 2, '.', '');
        $VTVMN=number_format($VTVMN+$ValorMVN, 2, '.', '');
        $VTG=number_format($VTG+$TG, 2, '.', '');
        $TISS=number_format($TISS+$ISS, 2, '.', '');
        $TAFP=number_format($TAFP+$AFP, 2, '.', '');
        $TTDD=number_format($TTDD+$TOTD, 2, '.', '');
        $TLRC=number_format($TLRC+$LR, 2, '.', '');

        //FIN valores totales
        if($iAUX>12){
          $iAUX=0;
          $NPAGINA++;
          $body=$body.$bodyAuxFin;
          $body=$body.$bodyAux;
        }
        $j=$i+1;
        $body=$body."<tr><td width='2%'>".$j."</td><td width='12%'>".$NombresArray[$i]."</td><td width='5%'>$<span class='monto'>".$SalarioN."</p></td><td width='5%'>".$MD." </td><td width='5%'>$<span class='monto'>".$ValorMD."</p></td><td width='5%'>".$MN."</td><td width='5%'>$<span class='monto'>".$ValorMN."</p></td><td width='5%'>".$MVD."</td><td width='5%'>$<span class='monto'>".$ValorMVD."</p></td><td width='5%'>".$MVN."</td><td width='5%'>$<span class='monto'>".$ValorMVN."</p></td><td  width='5%'>$<span class='monto'>".$TG."</p></td><td width='5%'>$<span class='monto'>".$ISS."</p></td><td width='5%'>$<span class='monto'>".$AFP."</p></td><td width='5%'>$<span class='monto'>".$RENTA."</p></td><td width='5%'>$<span class='monto'>".$TOTD."</p></td><td width='5%'>$<span class='monto'>".$LR."</p></td><td width='11%'></td></tr>";
        $iAUX++;
      }
          $body=$body."<tr bgcolor='#e2e2e2'><td width='2%'></td><td width='12%'>Total</td><td width='5%'><span class='monto'></p></td><td width='5%'>".$TMD." </td><td width='5%'>$<span class='monto'>".$VTMD."</p></td><td width='5%'>".$TMN."</td><td width='5%'>$<span class='monto'>".$VTMN."</p></td><td width='5%'>".$TVMD."</td><td width='5%'>$<span class='monto'>".$VTVMD."</p></td><td width='5%'>".$TVMN."</td><td width='5%'>$<span class='monto'>".$VTVMN."</p></td><td  width='5%'>$<span class='monto'>".$VTG."</p></td><td width='5%'>$<span class='monto'>".$TISS."</p></td><td width='5%'>$<span class='monto'>".$TAFP."</p></td><td width='5%'>$<span class='monto'>".$RENTA."</p></td><td width='5%'>$<span class='monto'>".$TTDD."</p></td><td width='5%'>$<span class='monto'>".$TLRC."</p></td><td width='11%'></td></tr>";
          $body=$body.'
                    </tr>
                  </table>
                  </div>
                </div>';
          $body=$body."<div class='row'>
                        <div class=class='row'>
                          <div id='textbox'>
                            <p class='alignleft' style='float:left;font-weight: bold;'>Pagina N.".$NPAGINA."<br>".$thisDateTime."</p>
                          </div>
                        </div>
                          <div style='clear: both;'></div>
                          <div class='col-md-4'>
                            <h5 style='text-align: center;font-weight: bold;'>
                              ELABORADO POR: <br>".$Nombre."
                            </h5>
                          </div>
                        </div>";

      $htmlFinal=$htmlFinal.$body;
      $body="";

  }
//SELECT NumeroDocumentoPara,SUM(NHorasDiurnas),SUM(NHorasNocturnas) FROM col_horas_extras WHERE col_horas_extras.DiaVacacion=0 AND (idHorasExtras=2 or idHorasExtras=3 OR idHorasExtras=10 OR idHorasExtras=15) GROUP BY NumeroDocumentoPara
//Vamos a IMPRIMIR
$html='
<html>
<head>
<title>ASCAS, S.A. DE C.V.</title>
<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  table {
      width: 100%;
      border-collapse: collapse;
  }

  table, th, td {
      border: 1px solid black;
  }
  th,td{
    padding:5px;
  }
  th{
    text-align: center;
  }
  span.monto{
    padding-left: 5px;
  }
  body {
    height: 100%;
  }

</style>
</head>
  <body>
'.$htmlFinal.'
  </body>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/material.min.js" type="text/javascript"></script>
<script src="../js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!--  Plugin for the Wizard -->
<script src="../js/jquery.bootstrap-wizard.js"></script>
</html>
';


//==============================================================
//==============================================================
//==============================================================
mysqli_close($cnx);
include("../MPDF/mpdf.php");
$mpdf = new mPDF('utf-8', 'A3-L');
$mpdf->WriteHTML($html);
$NombreArchivo="REF-".$row["RefNumero"]."-".$row["RefYear"].".pdf";
$mpdf->Output($NombreArchivo, 'I');
exit;
//==============================================================
//==============================================================
//==============================================================
}//FIN IMPRIMIR DOC
function TimeToMinut($Time){
  $Time=(string)$Time;
  $Time= explode(":",$Time);
  $Second=((float)$Time[0]*60)+((float)$Time[1])+(round((float)$Time[2]/60));
  return floor((float)$Second);
}
function calculoDeRentaHE($TG,$TRAMO1,$TRAMO2,$TRAMO3,$TRAMO4){
  //$TRAMO1=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
  if(((float)$TG>(float)$TRAMO1["Desde"])&&((float)$TG<(float)$TRAMO1["Hasta"])){
    $RENTA=(($TG-$TRAMO1["sobre_exceso"])*$TRAMO1["porcentaje_aplicar"])+$TRAMO1["Cuota_fija"];
  }elseif(((float)$TG>(float)$TRAMO2["Desde"])&&((float)$TG<(float)$TRAMO2["Hasta"])) {
    # code...
    $RENTA=(($TG-$TRAMO2["sobre_exceso"])*$TRAMO2["porcentaje_aplicar"])+$TRAMO2["Cuota_fija"];
  }elseif(((float)$TG>(float)$TRAMO3["Desde"])&&((float)$TG<(float)$TRAMO3["Hasta"])) {
    # code...
    $RENTA=(($TG-$TRAMO3["sobre_exceso"])*$TRAMO3["porcentaje_aplicar"])+$TRAMO3["Cuota_fija"];
  }else{
    $RENTA=(($TG-$TRAMO4["sobre_exceso"])*$TRAMO4["porcentaje_aplicar"])+$TRAMO4["Cuota_fija"];
  }
  return number_format($RENTA, 2, '.', '');
}
?>

<?php
include '../php/verificar_sesion.php';
if((trim($_POST['FFechaInicio']) == "")||(trim($_POST['FFechaFin']) == "")||(trim($_POST['TTPago']) == "")||(trim($_POST['FFPago']) == "")||(trim($_POST['NDocumentoArray']) == "")){
  header('Location: Pagos_Horas_Extras.php');
  exit();
}
include '../php/funciones.php';
$cnx = cnx();
$FechaInicio = $_POST["FFechaInicio"];
$FechaFin = $_POST["FFechaFin"];
$TPago = $_POST["TTPago"]."0";
$FPago = $_POST["FFPago"];
$NDocumentoArray = $_POST["NDocumentoArray"];
$NDocumentoArray = json_decode("$NDocumentoArray", true);
//nombrePor
$str="";
for($i=0;$i<count($NDocumentoArray);$i++){
  $str=$str." ".$NDocumentoArray[$i];
}
//alistnado los valores a usuar
$NitEmpresa=$_SESSION["empresa"];
$NombrePor = $_POST["nombrePor"];
$NumeroDocumentoPor=$_POST["NumeroDocumentoPor"];
date_default_timezone_set('America/El_Salvador');
$dateTime = date("Y-m-d H:i:s");
//Sacar datos de la RENTA
  $TipoPago=str_split($TPago);
  //Tipo de Pago para tomar en consideracion para la RENTA
  if($TipoPago[0]==1){//mensual
    $tipoRenta=1;
  }elseif(($TipoPago[0]==2) || ($TipoPago[0]==3)){
    //Quincenal, catorcenal
    $tipoRenta=2;
  }elseif(($TipoPago[0]==4)){
    //Semanal
    $tipoRenta=3;
  }
  $TRAMO1= array();
  $TRAMO2= array();
  $TRAMO3= array();
  $TRAMO4= array();
  $query=sprintf("SELECT * FROM renta WHERE tipo_pago='%s' ",mysqli_real_escape_string($cnx,$tipoRenta));
  $result=mysqli_query($cnx,$query);
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
  $TipoPago=$TipoPago[0]."0";
//FIN
  $NameDataBase=NameDataBase();
  $query=sprintf("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '%s' AND   TABLE_NAME   = 'pagos_horas_extras'",mysqli_real_escape_string($cnx,$NameDataBase));
  $result=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($result);
  $NumeroDeRecibo=$row["AUTO_INCREMENT"];
//INSERTAR EN LA BD
  $flag=1;//1 todo bien
  $idBanco=$FPago;
  $estado=GuardarPagosHorasExtras($NumeroDeRecibo,$NitEmpresa, $NumeroDocumentoPor,$NombrePor,$dateTime," ",$TPago,$FPago,$idBanco,1,$FechaInicio,$FechaFin);
  if($estado==1){
    //Guardar por empleado
    //FFPago banco  TTPAGO es el tiempoL:mensual,etc
    $FormaPago=$FPago;
    $PeriodoPago=$TPago;
    for($i=0;$i<count($NDocumentoArray);$i++){
      $NumeroDocumento=$NDocumentoArray[$i];
      if($FormaPago!=0){
        $idBanco=$FPago;
        $CuentaBanco=getCuentaBanco($NumeroDocumento,$idBanco);
      }else{
        $idBanco="";
        $CuentaBanco="";
      }
      $empleado=getInfoUser($NumeroDocumento);
      $isFPagoCorrecto=checkCuentaBanco($NumeroDocumento,$FormaPago);
      if(($isFPagoCorrecto)||($FormaPago==0)){
        $isFPagoCorrecto=getCuentaBanco($NumeroDocumento,$FormaPago);
        if((($isFPagoCorrecto[0]!="")&&($FormaPago!=0)) || (($FormaPago==0)&&($isFPagoCorrecto[0]==""))){
          //ahora que tenemos todos los numero de documento vamos a ver los totales de horas trabajadas
          $SalarioNominal=$empleado->getSalarionominal();
          $queryTotCalSinVaca=sprintf("SELECT col_horas_extras.NumeroDocumentoPara ,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasDiurnas))) AS SHD,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasNocturnas)))AS SHN FROM col_horas_extras INNER JOIN horas_extras WHERE col_horas_extras.NumeroDocumentoPara='%s' AND horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND  col_horas_extras.DiaVacacion='0' AND horas_extras.Fecha BETWEEN '%s' AND '%s' GROUP BY col_horas_extras.NumeroDocumentoPara",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
          $resultTotCalSinVaca=mysqli_query($cnx,$queryTotCalSinVaca);
          $rowTotCalSinVaca=mysqli_fetch_array($resultTotCalSinVaca);
          if($rowTotCalSinVaca[0]!=""){
            $TotSinVacaD=$rowTotCalSinVaca["SHD"];
            $TotSinVacaN=$rowTotCalSinVaca["SHN"];
          }else {
            $TotSinVacaD="00:00:00";
            $TotSinVacaN="00:00:00";
          }
          $queryTotCalSinVaca=sprintf("SELECT col_horas_extras.NumeroDocumentoPara ,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasDiurnas))) AS SHD,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasNocturnas)))AS SHN FROM col_horas_extras INNER JOIN horas_extras INNER JOIN htrabajo INNER JOIN turno WHERE col_horas_extras.NumeroDocumentoPara='%s' AND horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND col_horas_extras.NumeroDocumentoPara=htrabajo.NumeroDocumento AND htrabajo.idTurno=turno.idTurno AND turno.Periodo_Pago='%s' AND col_horas_extras.DiaVacacion='1' AND horas_extras.Fecha BETWEEN '%s' AND '%s' GROUP BY col_horas_extras.NumeroDocumentoPara",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$PeriodoPago),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
          $resultTotCalSinVaca=mysqli_query($cnx,$queryTotCalSinVaca);
          $rowTotCalSinVaca=mysqli_fetch_array($resultTotCalSinVaca);
          if($rowTotCalSinVaca[0]!=""){
            $TotConVacaD=$rowTotCalSinVaca["SHD"];
            $TotConVacaN=$rowTotCalSinVaca["SHN"];
          }else {
            $TotConVacaD="00:00:00";
            $TotConVacaN="00:00:00";
          }
          //Ya tenemos las horas del empleado a CALCULAR
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
            $MD=TimeToMinut($TotSinVacaD);
            $MN=TimeToMinut($TotSinVacaN);
            $MVD=TimeToMinut($TotConVacaD);
            $MVN=TimeToMinut($TotConVacaN);
            $SalarioN=number_format((float)$SalarioNominal, 2, '.', '');
            $ValorMinuto=number_format(((float)$SalarioNominal)/30/8/60, 4, '.', '');
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
            $NombreCompleto="".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
            $Cargo= getInfoCargos($empleado->getIdcargos());
            $Departamento = getInfoDepartamentos($Cargo->getIddepartamento());
          //FIN CALCULAR
          //IMPRIMAMOS
            $estadoPorEmpleado=GuardarColPagosHorasExtras($NumeroDeRecibo,$empleado->getNit(),$empleado->getNumeroDocumento(),$NombreCompleto,$LR,$ISS,$AFP,$RENTA,$CuentaBanco);
            if(!$estadoPorEmpleado){
              $flag=0;
              echo "0, ERROR al tratar de insertar el empleado(llame al administrador)";
              break;
            }
          //FIN IMPRIMIR
        }
      }
    }

  }else{
    echo "0, ERROR al tratar de insertar el recibo (intente de nuevo o llame al administrador)";
    $flag=0;
  }
  //Si todo bien
  if($flag==1){
    echo "1, Recibo correctamente agregado";
  }



 ?>

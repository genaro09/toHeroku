<?php
//variables a necesitar
include '../php/funciones.php';
include '../php/Funciones_Para_PDF.php';
include '../php/verificar_sesion.php';
require_once('../php/clases/NumberToLetterConverter.class.php');
$user = $_SESSION['usuario_sesion'];
$NumeroDocumento=$_POST["NumeroDeDocumento"];
//$NumeroDocumento=$_POST["numDoc"];
$cnx=cnx();
$empleado=new empleado_class();
$empleado=getInfoEmpleado($NumeroDocumento);
$salario_mensual=number_format((double)$empleado->getSalarionominal(), 2, '.', '');
$salario_diario=number_format(($salario_mensual/30), 2, '.', '');
$cargoNE=getInfoCargos($empleado->getIdcargos());
$Nitempresa=getNitEmpresa($empleado);
$query=sprintf("SELECT * FROM empresa where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$Nitempresa));
$result=mysqli_query($cnx,$query);
$row=mysqli_fetch_array($result);
//$row["idDepartamento"]
$cod=json_decode($_POST["CODACCESS"], true);//ya se pueden obtener por [V]||S||A||L||RV
$NumeroDeRecibo=Realizar_Recibo($user,$NumeroDocumento,$cod["V"],$cod["S"],$cod["A"],$cod["L"],$cod["RV"]);
//Sacar el TOTAL a pagar
$Tot_a_pagar=0;//Total a Pagar
$Tot_ISS=0;//Total ISS
$Tot_AFP=0;//Total APF
$Tot_SinD=0;//Total sin descuentos
$Tot_D=0;//Total de descuentos
$Tot_R=0;//Total de Renta
$disp_tabla_resultados="";//lo que se va a imprimir en el concepto
//FIN
//Solo para escribir bien
$count=0;
$Recibo_de_Nombres="";
$str="";
if($cod["V"]==1){
  $FEV=$_POST["FEV"];
  $FSV=$_POST["FSV"];
  //Calcular valores vacacion
  $Array_valores=array("opc"=>1,
                   "salario_mensual"=>$salario_mensual,
                   "d1"=>$FEV,
                   "d2"=>$FSV
                 );
  $result_F_P_PDF=funcion_validar_PDF($Array_valores);
  $Tot_SinD=$Tot_SinD+$result_F_P_PDF["0"];//Tot sin Descuentos
  $Tot_R=$Tot_R+$result_F_P_PDF["1"];//Renta
  $Tot_AFP=$Tot_AFP+number_format((float)($result_F_P_PDF["0"]*0.0625), 2, '.', '');//AFP
  $Tot_ISS=$Tot_ISS+number_format((float)($result_F_P_PDF["0"]*0.03), 2, '.', '');//ISS
  $Salario_quincenal_vaca=number_format((float)($result_F_P_PDF["0"]/1.3), 2, '.', '');//SALARIO quincenal
  $Vacacion_proporcional=number_format((float)$result_F_P_PDF["0"]-(float)($result_F_P_PDF["0"]/1.3), 2, '.', '');
  //INSERTAR EN VACACION
  $Desde=formatDatePD((string)$FEV);
  $Hasta=formatDatePD((string)$FSV);
  $Desde=str_replace('/', '-', $Desde);
  $Hasta=str_replace('/', '-', $Hasta);
  $Desde=date('Y-m-d', strtotime($Desde));
  $Hasta=date('Y-m-d', strtotime($Hasta));
  $query = sprintf("INSERT INTO pagos_empleados(Tipo_Pago,idRecibo,Desde,Hasta,Monto,ISS,AFP,Renta) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
    mysqli_real_escape_string($cnx,1),
    mysqli_real_escape_string($cnx,$NumeroDeRecibo),
    mysqli_real_escape_string($cnx,$Desde),
    mysqli_real_escape_string($cnx,$Hasta),
    mysqli_real_escape_string($cnx,$result_F_P_PDF["0"]),
    mysqli_real_escape_string($cnx,number_format((float)($result_F_P_PDF["0"]*0.03), 2, '.', '')),
    mysqli_real_escape_string($cnx,number_format((float)($result_F_P_PDF["0"]*0.0625), 2, '.', '')),
    mysqli_real_escape_string($cnx,$result_F_P_PDF["1"])
    );
  $estado = mysqli_query($cnx,$query);

  //FIN
  $disp_tabla_resultados=$disp_tabla_resultados.'
                        <tr>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FEV).'</span></td>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FSV).'</span></td>
                          <td style="width:10%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.$result_F_P_PDF["4"].'</span></td>
                          <td style="width:45%;font-size:9pt;padding:0mm;margin:0;">
                            <table cellspacing="0" cellpadding="0" style="padding:0mm;margin:0;border:0;">
                              <tr>
                              <td align="left"><span style="float:left;font-size: 12px;"> SALARIO QUINCENAL</span></td>
                              </tr><tr>
                              <td align="left"><span style="float:left;font-size: 12px;"> VACACION PROPORCIONAL</span></td>
                              </tr>
                            </table>
                          </td>
                          <td style="width:15%;font-size:9pt;padding:0mm;margin:0;">
                            <table cellspacing="0" cellpadding="0" style="padding:0mm;margin:0;">
                              <tr>
                                <td align="right"><span style="font-size: 12px;">$'.$Salario_quincenal_vaca.'</span></td>
                                </tr><tr>
                                <td align="right"><span style="font-size: 12px;">$'.$Vacacion_proporcional.'</span></td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                          ';
  //FIN
  $str=$str."-Vacacion";
}
if($cod["S"]==1){
  $FES=$_POST["FES"];
  $FSS=$_POST["FSS"];
  $str=$str."-Salario";
  //Calcular valores Salario
  $Array_valores=array("opc"=>2,
                   "salario_mensual"=>$salario_mensual,
                   "d1"=>$FES,
                   "d2"=>$FSS
                 );
  $result_F_P_PDF=funcion_validar_PDF($Array_valores);
  $Tot_SinD=$Tot_SinD+$result_F_P_PDF["0"];//Tot sin Descuentos
  $Tot_R=$Tot_R+$result_F_P_PDF["1"];//Renta
  $Tot_AFP=$Tot_AFP+number_format((float)($result_F_P_PDF["0"]*0.0625), 2, '.', '');//AFP
  $Tot_ISS=$Tot_ISS+number_format((float)($result_F_P_PDF["0"]*0.03), 2, '.', '');//ISS
  $disp_tabla_resultados=$disp_tabla_resultados.'
                        <tr>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FES).'</span></td>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FSS).'</span></td>
                          <td style="width:10%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.$result_F_P_PDF["3"].'</span></td>
                          <td align="left" style="width:45%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"> SALARIO</span></td>
                          <td align="right" style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">$'.$result_F_P_PDF["0"].'</span></td>
                        </tr>
                          ';
  //FIN
}
if($cod["A"]==1){
  $FContra=$_POST["FCONT"];
  $FEA=$_POST["FEA"];
  $FSA=$_POST["FSA"];
  $str=$str."-Aguinaldo";
  //Calcular valores Aguinaldo
  $Array_valores=array("opc"=>4,
                   "salario_mensual"=>$salario_mensual,
                   "d1"=>$FEA,
                   "d2"=>$FSA,
                   "fecha_contratacion"=>$FContra
                 );
  $result_F_P_PDF=funcion_validar_PDF($Array_valores);
  $Tot_SinD=$Tot_SinD+$result_F_P_PDF["0"];//Tot sin Descuentos
  $disp_tabla_resultados=$disp_tabla_resultados.'
                        <tr>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FEA).'</span></td>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FSA).'</span></td>
                          <td style="width:10%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.$result_F_P_PDF["1"].'</span></td>
                          <td align="left" style="width:45%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"> AGUINALDO</span></td>
                          <td align="right" style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">$'.$result_F_P_PDF["0"].'</span></td>
                        </tr>
                          ';
  //FIN
}
if($cod["RV"]==1){
  $SMin=$_POST["SMin"];
  $FERV=$_POST["FERV"];
  $FSRV=$_POST["FSRV"];
  $str=$str."-RetiroVoluntario";
  //Calcular valores Liquidacion
  $Array_valores=array("opc"=>5,
                   "salario_mensual"=>$salario_mensual,
                   "d1"=>$FERV,
                   "d2"=>$FSRV,
                   "salario_minimo_mensual"=>$SMin
                 );
  $result_F_P_PDF=funcion_validar_PDF($Array_valores);
  $Tot_SinD=$Tot_SinD+$result_F_P_PDF["0"];//Tot sin Descuentos
  $disp_tabla_resultados=$disp_tabla_resultados.'
                        <tr>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FERV).'</span></td>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FSRV).'</span></td>
                          <td style="width:10%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.$result_F_P_PDF["1"].'</span></td>
                          <td align="left" style="width:45%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"> RETIRO VOLUNTARIO</span></td>
                          <td align="right" style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">$'.$result_F_P_PDF["0"].'</span></td>
                        </tr>
                          ';
  //FIN
}
if($cod["L"]==1){
  $SMin=$_POST["SMin"];
  $FEL=$_POST["FEL"];
  $FSL=$_POST["FSL"];
  $str=$str."-Indemnizacion";
  //Calcular valores Liquidacion
  $Array_valores=array("opc"=>3,
                   "salario_mensual"=>$salario_mensual,
                   "d1"=>$FEL,
                   "d2"=>$FSL,
                   "salario_minimo_mensual"=>$SMin
                 );
  $result_F_P_PDF=funcion_validar_PDF($Array_valores);
  $Tot_SinD=$Tot_SinD+$result_F_P_PDF["0"];//Tot sin Descuentos
  $disp_tabla_resultados=$disp_tabla_resultados.'
                        <tr>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FEL).'</span></td>
                          <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.formatDatePD((string)$FSL).'</span></td>
                          <td style="width:10%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">'.$result_F_P_PDF["1"].'</span></td>
                          <td align="left" style="width:45%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"> INDEMNIZACION</span></td>
                          <td align="right" style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">$'.$result_F_P_PDF["0"].'</span></td>
                        </tr>
                          ';
  //FIN
}
$str=split("-", $str);
if(count($str)==2){
  $Recibo_de_Nombres=$str["1"];
}else if(count($str)==3){
  if($str["2"]=="Indemnizacion"){
    $Recibo_de_Nombres=$str["1"]." e ".$str["2"];
  }else {
    $Recibo_de_Nombres=$str["1"]." y ".$str["2"];
  }
}else{
  while($count<count($str)-1){
    if(($count+1)==count($str)-1){
      if($str[$count+1]=="Indemnizacion"){
        $Recibo_de_Nombres=$Recibo_de_Nombres." e ".$str[$count+1];
      }else {
        $Recibo_de_Nombres=$Recibo_de_Nombres." y ".$str[$count+1];
      }
    }else if(($count==0)){
        $Recibo_de_Nombres=$Recibo_de_Nombres.$str["1"];
    }else{
      $Recibo_de_Nombres=$Recibo_de_Nombres.", ".$str[$count+1];
    }
    $count++;
  }
}
//fin de escribir bien
//arrays para Aplicaciones legal del PAGO
$arreglo_de_ART=array("S"=>"ART. Salario",
                 "V"=>"ART. #177 DEL CODIGO DE TRABAJO",
                 "A"=>"ART. Vacacion",
                 "L"=>"ART. Liquidacion",
                 "RV"=>"ART. #58 DEL CODIGO DE TRABAJO <br> ART. #08 DE LEY DE RETIRO VOLUNTARIO"
);
$count=0;
$count2=0;
$str_ALDP="<tr>";
while($count<count($str)-1){
  if($count2!=2){
    if($str[$count+1]=="Vacacion"){
      $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;font-weight: bold;'><span style='font-size: 11px;'>VACACION</span></td>";
      $count2++;
    }else if($str[$count+1]=="Salario"){
      $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;font-weight: bold;'><span style='font-size: 11px;'>SALARIO</span></td>";
      $count2++;
    }else if($str[$count+1]=="Aguinaldo"){
      $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;font-weight: bold;'><span style='font-size: 11px;'>AGUINALDO</span></td>";
      $count2++;
    }else if($str[$count+1]=="Indemnizacion"){
      $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;font-weight: bold;'><span style='font-size: 11px;'>INDEMNIZACION</span></td>";
      $count2++;
    }else if($str[$count+1]=="RetiroVoluntario"){
      $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;font-weight: bold;'><span style='font-size: 11px;'>RETIRO VOLUNTARIO</span></td>";
      $count2++;
    }
  }
    $count++;
  if($count2==2){
    $str_ALDP=$str_ALDP."</tr>";
    $str_ALDP=$str_ALDP."<tr>";
    $str_ALDP=Revisar_ALDP($str,$count-1,$str_ALDP,$arreglo_de_ART);
    if($count==count($str)){
      $str_ALDP=Revisar_ALDP($str,$count,$str_ALDP,$arreglo_de_ART);
      $str_ALDP=$str_ALDP."</tr>";
      $str_ALDP=$str_ALDP."</tr>";
    }else{
      $str_ALDP=Revisar_ALDP($str,$count,$str_ALDP,$arreglo_de_ART);
      $str_ALDP=$str_ALDP."</tr>";
      $str_ALDP=$str_ALDP."<tr>";
    }
    $count2=0;
  }else if($count==count($str)-1){
    $str_ALDP=$str_ALDP."</tr>";
    $str_ALDP=$str_ALDP."<tr>";
    $str_ALDP=Revisar_ALDP($str,$count,$str_ALDP,$arreglo_de_ART);
    $str_ALDP=$str_ALDP."</tr>";
    $count2=0;
  }
}
//Fin de Aplicaciones legales del pago
//Tiempo LABORALES
$queryHT=sprintf("SELECT * FROM htrabajo where  NumeroDocumento='%s' ",mysqli_real_escape_string($cnx,$NumeroDocumento));
$resultHT=mysqli_query($cnx,$queryHT);
$rowHT=mysqli_fetch_array($resultHT);

$queryNT=sprintf("SELECT * FROM turno where  idTurno='%s' ",mysqli_real_escape_string($cnx,$rowHT["idTurno"]));
$resultNT=mysqli_query($cnx,$queryNT);
$rowNT=mysqli_fetch_array($resultNT);

$tiempo_laboral=RevisarTiempo(1,$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);

//Fin tiempo laboral



$Tot_D=$Tot_ISS+$Tot_AFP+$Tot_R;
$Tot_a_pagar=$Tot_SinD-$Tot_D;
//Tot a pagar a textdomain
$whole = floor($Tot_SinD);      // 1
$fraction = $Tot_SinD - $whole; // .25
$fraction=number_format((float)$fraction, 2, '.', '')*100;
if($fraction==0){
  $fraction="00";
}
$Tot_a_pagar_en_texto=$whole;
//Fin
//Fecha a mostrar del dia
$meses_espa=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha_de_ahora=date('d/m/Y ', time());
$fecha_de_ahora = split("/", $fecha_de_ahora);
$MesDeAhora=floatval($fecha_de_ahora[1]);
$fecha_de_ahora=$fecha_de_ahora[0]." de ".$meses_espa[$MesDeAhora]." del ".$fecha_de_ahora[2];
//FIN
$NumberToLetterConverter = new NumberToLetterConverter;
$Nombre_Completo=$empleado->getPrimernombre().' '.$empleado->getSegundonombre().' '.$empleado->getPrimerapellido().' '.$empleado->getSegundoapellido();
$html = '

<!DOCTYPE html>
<html>
<head>
    <title>ASCAS, S.A. DE C.V.</title>
    <style>
        *
        {
            margin:0;
            padding:0;
            font-family:Arial;
            font-size:10pt;
            color:#000;
        }
        body
        {
            width:100%;
            font-family:Arial;
            font-size:10pt;
            margin:0;
            padding:0;
        }

        p
        {
            margin:0;
            padding:0;
        }

        #wrapper
        {
            width:180mm;
            margin:0 15mm;
        }

        .page
        {
            height:297mm;
            width:210mm;
            page-break-after:always;
        }

        table
        {
            border-left: 1px solid #000;
            border-top: 1px solid #000;

            border-spacing:0;
            border-collapse: collapse;

        }

        table td
        {
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 2mm;
        }

        table.heading
        {
            height:50mm;
        }

        h1.heading
        {
            font-size:14pt;
            color:#000;
            font-weight:normal;
        }

        h2.heading
        {
            font-size:9pt;
            color:#000;
            font-weight:normal;
        }

        hr
        {
            color:#000;
            background:#000;
        }

        #invoice_body
        {
            height: 100mm;
        }

        #invoice_body , #invoice_total
        {
            width:100%;
        }
        #invoice_body table , #invoice_total table
        {
            width:100%;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            border-top: 1px solid #000;

            border-spacing:0;
            border-collapse: collapse;

            margin-top:5mm;
        }

        #invoice_body table td , #invoice_total table td
        {
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            padding:2mm 0;
        }

        #invoice_body table td.mono  , #invoice_total table td.mono
        {
            font-family:monospace;
            text-align:right;
            padding-right:3mm;
            font-size:10pt;
        }

        #footer
        {
            width:130mm;
            margin:0 15mm;
            padding-bottom:3mm;
        }
        #footer table
        {
            width:100%;
            border-left: 1px solid #000;
            border-top: 1px solid #000;

            background:#eee;

            border-spacing:0;
            border-collapse: collapse;
        }
        #footer table td
        {
            width:25%;
            text-align:center;
            font-size:9pt;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <br />
    <table class="heading" style="border:none;width:100%;border-collapse:collapse;" cellspacing="0" cellpadding="0">
        <tr style="border:0;">
            <td style="border:none;width:80mm;">

            </td>
            <td rowspan="2" valign="top" align="right" style="border:none;padding:3mm;">
                <table cellspacing="0" cellpadding="0" style="border:none;">
                    <tr style=" border:0;"><td style="border:none;"><pre><span style="font-size: 11px">'.$row["Direccion"].' Telefono: '.$row["Telefono"].'</span></pre></td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" style="border:none;border-collapse:collapse;">
      <tr style=" border:0;">
        <td style="width:140mm;border:none;"><h3>RECIBO</h3></td>
        <td rowspan="2" valign="top" align="right" style="border:none;padding:3mm;">
            <h3>REF.U91-2015</h3>
        </td>
      </tr>
    </table>

    <table style="border:none;border-collapse:collapse;">
      <tr style=" border:0;">
        <td style="width:55mm;border:none;"></td>
        <td rowspan="2" valign="top" align="right" style="border:none;padding:3mm;">
            <h3>Por $'.number_format((float)$Tot_SinD, 2, '.', '').'</h3>
        </td>
      </tr>
    </table>

    <div id="content">
        <div>
        Yo, <span style="font-weight:bold;">'.strtoupper($Nombre_Completo).'</span>, recibi de '.$row["NombreEmpresa"].'; la cantidad de '.$NumberToLetterConverter->to_word($Tot_a_pagar_en_texto).' CON '.$fraction.'/100 DOLARES en concepto de pago de '.$Recibo_de_Nombres.', segun el siguiente detalle:
        <br>
        <br>
        Politica de goce de '.$Recibo_de_Nombres.': Anual
        <br>
        Cargo que desempeña:'.$cargoNE->getNombrecargo().'
        </div>
        <div id="invoice_body">

            <table>
              <tr>
                <th>APLICACION LEGAL DEL PAGO</th>
              </tr>
            </table>
            <table style="margin-top:0mm;width=400px;">
              '.$str_ALDP.'
            </table>


            <table>
              <tr>
                <th>APLICACION DEL CALCULO</th>
              </tr>
            </table>
            <table style="margin-top:0mm;">
            <tr>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">SALARIO MENSUAL</span></td>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">SALARIO DIARIO</span></td>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">HORAS LABORALES</span></td>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">FECHA DE INGRESO</span></td>
            </tr>
            <tr>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">$'.$salario_mensual.'</span></td>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">$'.$salario_diario.'</span></td>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">'.$tiempo_laboral.' horas</span></td>
                <td style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px">'.$empleado->getFechaingreso().'</span></td>
            </tr>
            </table>

            <table>
              <tr>
                <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;">DESDE</span></td>
                <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;">HASTA</span></td>
                <td style="width:10%;font-size:9pt;padding:0.5mm;"><span style="font-size: 9px;font-weight:bold;">DIAS LABORALES</span></td>
                <td style="width:45%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;">CONCEPTO</span></td>
                <td style="width:15%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;">VALOR</span></td>
              </tr>
            </table>
            <table style="margin-top:0mm;">
              '.$disp_tabla_resultados.'
            </table>
            <table align="right" style="width:60%;margin-top:0mm;">
              <tr>
                <td align="left" style="width:75%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;"> Sub Total.......</span></td>
                <td align="right" style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;">$'.$Tot_SinD.'</span></td>
              </tr>
              <tr>
                <td align="left" style="width:75%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"> Menos<br> ISS... 3%<br> AFPS... 6.25%</span></td>
                <td align="right" style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"><br>$'.$Tot_ISS.'<br>$'.$Tot_AFP.'</span></td>
              </tr>
              <tr>
                <td align="left" style="width:75%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;"> Sub total...</span></td>
                <td align="right" style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;">$'.$Tot_D.'</span></td>
              </tr>
              <tr>
                <td align="left" style="width:75%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;"> Total a recibir.......</span></td>
                <td align="right" style="width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px;font-weight:bold;">$'.$Tot_a_pagar.'</span></td>
              </tr>
            </table>
        </div>
        <br />
        <div>
          <span style="font-weight:bold;">DINERO QUE RECIBO A MI ENTERA SATISFACCION Y POR LO TANTO, LIBERO A LA EMPRESA DE TODA RESPONSABILIDAD LEGAL Y LABORAL PARA CON MI PERSONA</span>
        </div>
        <br>
        <div>
          <span>El Salvador, '.$fecha_de_ahora.'<span>
        </div>
        <br>
        <table style="width:100%;border-right: 1px solid #000;">
          <tr>
            <th><span style="font-weight:bold;">RECIBE CONFORME</span></th>
          </tr>
        </table>
        <table style="margin-top:0mm;width:100%;">
        <tr>
            <td style="text-align:center;width:35%;font-size:9pt;padding:0.5mm;"><span align="center" style="font-size: 12px">NOMBRE</span></td>
            <td style="text-align:center;width:20%;font-size:9pt;padding:0.5mm;"><span align="center" style="font-size: 12px">DUI</span></td>
            <td style="text-align:center;width:20%;font-size:9pt;padding:0.5mm;"><span align="center" style="font-size: 12px">NIT</span></td>
            <td style="text-align:center;width:25%;font-size:9pt;padding:0.5mm;"><span align="center" style="font-size: 12px">FIRMA</span></td>
        </tr>
        <tr>
            <td style="text-align:center;width:35%;font-size:9pt;padding:0.5mm;"><span style="font-weight:bold;font-size: 12px;">'.strtoupper($Nombre_Completo).'</span></td>
            <td style="text-align:center;width:20%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px">'.$empleado->getNumerodocumento().'</span></td>
            <td style="text-align:center;width:20%;font-size:9pt;padding:0.5mm;"><span style="font-size: 12px">'.$empleado->getNit().'</span></td>
            <td style="text-align:center;width:25%;font-size:9pt;padding:0.5mm;"><span style="font-size: 10px"></span></td>
        </tr>
        </table>
    </div>

    <br />

    </div>



</body>
</html>

';


//==============================================================
//==============================================================
//==============================================================
mysqli_close($cnx);
include("../MPDF/mpdf.php");
$mpdf=new mPDF('c');

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================
//FUNCiONES
function Revisar_ALDP($str,$n,$str_ALDP,$arreglo_de_ART){
  if($str[$n]=="Vacacion"){
    $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;'><span style='font-size: 11px;'>".$arreglo_de_ART["V"]."</span></td>";
  }else if($str[$n]=="Salario"){
    $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;'><span style='font-size: 11px;'>".$arreglo_de_ART["S"]."</span></td>";
  }else if($str[$n]=="Aguinaldo"){
    $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;'><span style='font-size: 11px;'>".$arreglo_de_ART["A"]."</span></td>";
  }else if($str[$n]=="Liquidacion"){
    $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;'><span style='font-size: 11px;'>".$arreglo_de_ART["L"]."</span></td>";
  }else if($str[$n]=="Indemnizacion"){
    $str_ALDP= $str_ALDP."<td style='width:50%;font-size:9pt;padding:0.5mm;'><span style='font-size: 11px;'>".$arreglo_de_ART["RV"]."</span></td>";
  }
  return $str_ALDP;
}
function RevisarTiempo($valor,$HIni,$HFin,$Des){
  $HFin=new DateTime($HFin);
  $HIni=new DateTime($HIni);
  $Des=new DateTime($Des);
  $interval = $HFin->diff($HIni);
  $nvalor=$interval->format('%H:%I:%S');
  $NDate= new DateTime($nvalor);
  $intervalf = $NDate->diff($Des);
  $workduration = $intervalf->format('%H:%I:%S');
  $time_array = explode(':',$workduration);
  $hours = (int)$time_array[0];
  $minutes = (int)$time_array[1];
  $seconds = (int)$time_array[2];
  $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
  $average = floor($total_seconds/2);
  $hours = floor($average / 3600);
  $mins = floor($average / 60 % 60);
  $secs = floor($average % 60);
  $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
  if($valor==1){
    $valorN=(String)($workduration);
  }else if($valor==2){
    $valorN=(String)($timeFormat);
  }else{
    $valorN="D";
  }

return $valorN;

}



?>

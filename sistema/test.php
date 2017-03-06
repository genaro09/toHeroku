<?php

$encabezado='
<div id="cuerpo">
  <div id="encabezado">
  <h3 style="margin-top:0px;">
  ACOPES DE RL
  </h3>
  </div>
  <div id="texCuadro">
  <font size="4">
  Documento para el control de horas en jornadas extraordinaria laboradas por los trabajadores de manera voluntaria
  </font>
  </div>
  <div id="SaF_Cuadro"><font size="4">
  Supervisor:
  </font></div>
  <div id="SaF_Cuadro"><font size="4">
  Fecha:
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
$str="";
$n=0;
$bloque="";
while($n<2){
  $str=$str.'
  <tr>
    <td style="width:5%"><font size="3">'.$n.'</font></td>
    <td style="width:27%"><font size="2">GENARO ALVARENGA RODRIGUEZ</font></td>
    <td style="width:11%"><font size="3">00:00</font></td>
    <td style="width:11%"><font size="3">00:30</font></td>
    <td style="width:10%"><font size="3">01:00</font></td>
    <td style="width:10%"><font size="3">01:30</font></td>
    <td style="width:24%"><font size="3"></font></td>
  </tr>
  ';
  if(($n % 24 == 0)&&$n!=0){
    $bloque=$bloque.$encabezado.$str.'</table></div></div>';
    $str="";
  }
  $n++;
}
$bloque=$bloque.$encabezado.$str.'</table></div></div>';

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
mysqli_close($cnx);
include("../MPDF/mpdf.php");
$mpdf=new mPDF('c');
$mpdf->WriteHTML($html);
$NombreArchivo="REF.pdf";
$mpdf->Output($NombreArchivo, 'I');
exit;

//==============================================================
//==============================================================
//==============================================================



?>

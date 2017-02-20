<?php
include_once '../php/cn.php';
$Tp=$_POST['Tp'];
$d1=$_POST['d1'];
$d2=$_POST['d2'];
$flag=1;
$d_mala=0;
$d_rango1=0;
$d_rango2=0;
$d1=str_replace('/', '-', $d1);
$d2=str_replace('/', '-', $d2);
$NumeroDocumento=$_POST['NumeroDocumento'];
$cnx=cnx();
if(validateDate($d1)&&validateDate($d2)){
  $query=sprintf("SELECT * FROM recibo INNER JOIN pagos_empleados ON recibo.idRecibo=pagos_empleados.idRecibo WHERE recibo.NumeroDocumento_Para='%s' AND pagos_empleados.Tipo_Pago='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$Tp));
  $result=mysqli_query($cnx,$query);
  while(($row=mysqli_fetch_array($result))){
    if(( ( $d1 >= $row["Desde"] ) && ( $d1 <= $row["Hasta"] ) )){
      $flag=0;
      $d_mala=$d1;
      $d_rango1=$row["Desde"];
      $d_rango2=$row["Hasta"];
    }
    if(( ( $d2 >= $row["Desde"] )  && ( $d2 <= $row["Hasta"] ) )){
      $flag=0;
      $d_mala=$d2;
      $d_rango1=$row["Desde"];
      $d_rango2=$row["Hasta"];
    }
  }
  mysqli_close($cnx);
}else{
  $flag=0;
  $d_mala="ERROR EN FECHAS";
  $d_rango1="ERROR EN FECHAS";
  $d_rango2="ERROR EN FECHAS";
}
$array = array($flag,$d_mala,$d_rango1,$d_rango2);//Aqui vamos a enviar todos los valores
echo json_encode($array);

function validateDate($date){
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

 ?>

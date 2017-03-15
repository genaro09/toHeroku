<?php
include '../php/funciones.php';
if($_POST['id']){
	$date=$_POST['id'];
  $date=explode("/",$date);
  $days=cal_days_in_month(CAL_GREGORIAN,$date[0],$date[1]);
  echo "<option value='10'>Mensual</option>";
    //Los value 20 catorcenal
  for($i=0;$i<ceil($days/14);$i++){
    $j=$i+1;
    echo "<option value='2".$j."'>".$j." Catorcena</option>";
  }
    //Los value 30 quincenal
  echo "<option value='31'>1 Quincena</option>";
  echo "<option value='32'>2 Quincena</option>";

  //Los value 40 semanal
  for($i=0;$i<ceil($days/7);$i++){
    $j=$i+1;
    echo "<option value='4".$j."'>".$j." Semana</option>";
  }
}

?>

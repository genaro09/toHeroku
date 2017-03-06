<?php

$HDiurnoMX="19:00:00";
$HDiurnoMN="06:00:00";
$HNocturnoMX="06:00:00";
$HNocturnoMN="19:00:00";
$HEntradaEs=RevisarNocDiu("05:57:00","19:00:00","06:00:00");
$HSalidaEs=RevisarNocDiu("08:45:00","19:00:00","06:00:00");
echo "----------------------------<br>";
echo "Horario de Entrada:".$HEntradaEs."<br>";
echo "Horario de Salida:".$HSalidaEs;
echo "<br>";
if(strcmp($HEntradaEs, "D")==0){
  $Tot=subsTwoTimes("05:57",$HDiurnoMX);
  $NHorasDiurnas=gmdate("H:i:s", (int)$Tot);
  echo "Numero de Horas Diurnas:".$NHorasDiurnas."<br>";
  $Tot=subsTwoTimes($HNocturnoMN,"08:45");
  $NHorasNocturnas=gmdate("H:i:s", (int)$Tot);
  echo "Numero de Horas Nocturnas:".$NHorasNocturnas."<br>";
}else{
  $Tot=subsTwoTimes("05:57",$HNocturnoMX);
  $NHorasNocturnas=gmdate("H:i:s", (int)$Tot);
  echo "Numero de Horas Nocturnas:".$NHorasNocturnas."<br>";
  $Tot=subsTwoTimes($HDiurnoMN,"08:45");
  $NHorasDiurnas=gmdate("H:i:s", (int)$Tot);
  echo "Numero de Horas Diurnas:".$NHorasDiurnas."<br>";
}




function RevisarNocDiu($Hour,$HDiurnoMX,$HDiurnoMN){
  if((HourToNum($HDiurnoMN)<=HourToNum($Hour))&&(HourToNum($Hour)<HourToNum($HDiurnoMX))){
    return  "D";
  }else
    return  "N";
}
function subsTwoTimes($First,$End){
  $str_time = (string)$First.":00";
  sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
  $FirstTimeSeconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
  $str_time = (string)$End.":00";
  sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
  $EndTimeSeconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
  return abs($EndTimeSeconds-$FirstTimeSeconds);
}
function HourToNum($Hour){
  $Hour=(string)$Hour;
  $Hour= explode(":",$Hour);
  $Hour=$Hour[0].".".$Hour[1];
  return (float)$Hour;
}
?>

<?php
include '../php/funciones.php';
$HoraIni="04:45";
$HoraFin = "10:45";
$Ttotal=subsTwoTimes($HoraIni,$HoraFin);
$Ttotal=gmdate("H:i:s", (int)$Ttotal);
echo " Ini:".$HoraIni." Fin:".$HoraFin." <br>";
echo " Tiempo total:".$Ttotal."<br> NoD?:  ";
echo isBetwenNightTime($HoraIni,$HoraFin);
echo "<br>--------------------<br>";
echo "Tini-6: ".gmdate("H:i:s", (int)subsTwoTimes($HoraIni,"06:00"));
echo "<br>19-Tfinal: ".gmdate("H:i:s", (int)subsTwoTimes("19:00",$HoraFin));
echo "<br>Tot:".abs(HourToNum($HoraFin)-HourToNum($HoraIni));
echo "<br> Tiempo total sin segundos:".date('H:i', strtotime($Ttotal));
echo "<br>--------------------<br>";
echo "<br>";
//valores
$idTurno=1;
$lunes=1;
$martes=1;
$miercoles=1;
$jueves=1;
$viernes=1;
$sabado=1;
$domingo=1;
//fin
$cnx=cnx();
$flag=0;//0 es que no hay empleados que se pasen
$str="";
$query = sprintf("SELECT empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido,htrabajo.Desde,htrabajo.Hasta,htrabajo.H_Descanso from turno INNER JOIN htrabajo INNER JOIN empleado WHERE turno.idTurno='%s' and turno.idTurno=htrabajo.idTurno and htrabajo.NumeroDocumento=empleado.NumeroDocumento",mysqli_real_escape_string($cnx,$idTurno));
$result=mysqli_query($cnx,$query);
while ($row=mysqli_fetch_array($result)) {
  $tot=0;
  $HoraInicio=$row["Desde"];
  $HoraInicio=explode(":",$HoraInicio);
  $HoraInicio=$HoraInicio[0].":".$HoraInicio[1];
  $HoraFin=$row["Hasta"];
  $HoraFin=explode(":",$HoraFin);
  $HoraFin=$HoraFin[0].":".$HoraFin[1];
  $HoraDescanso=$row["H_Descanso"];
  $HoraDescanso=explode(":",$HoraDescanso);
  $HoraDescanso=$HoraDescanso[0].":".$HoraDescanso[1];
  //Cuantos dias trabaja horario completo o mysqlnd_ms_get_last_used_connection
  $totHorasLaborales=  array();
  $LunesT=RevisarTiempo($lunes,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$LunesT)!=0){
    $totHorasLaborales[]=$LunesT;
  }
  $MartesT=RevisarTiempo($martes,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$MartesT)!=0){
    $totHorasLaborales[]=$MartesT;
  }
  $MiercolesT=RevisarTiempo($miercoles,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$MiercolesT)!=0){
    $totHorasLaborales[]=$MiercolesT;
  }
  $JuevesT=RevisarTiempo($jueves,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$JuevesT)!=0){
    $totHorasLaborales[]=$JuevesT;
  }
  $ViernesT=RevisarTiempo($viernes,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$ViernesT)!=0){
    $totHorasLaborales[]=$ViernesT;
  }
  $SabadoT=RevisarTiempo($sabado,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$SabadoT)!=0){
    $totHorasLaborales[]=$SabadoT;
  }
  $DomingoT=RevisarTiempo($domingo,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
  if(strcmp("D",(string)$DomingoT)!=0){
    $totHorasLaborales[]=$DomingoT;
  }
  //diurna 6-19
  //tot horas ->
  $totHorasLaborales=AddArrTime($totHorasLaborales);
  echo "Empleado:".$row["PrimerNombre"]." Total:".$totHorasLaborales."<br>";
  //is hornada is D or N
  echo "Jornada de tipo".isBetwenNightTime($HoraInicio,$HoraFin)."<br>";
  if (strcmp("D",isBetwenNightTime($HoraInicio,$HoraFin))==0) {
    $MaxHoursWeek=44;//Max diurno
    $tipoSemanaL="Diurna";
  }else {
    $MaxHoursWeek=39;//MAX nocturna
    $tipoSemanaL="Nocturna";
  }
  $totHorasLaborales=explode(":",$totHorasLaborales);
  $totHorasLaborales=$totHorasLaborales[0].":".$totHorasLaborales[1];
  echo "Total de horas semanales:".$totHorasLaborales."<br> compare:".HourToNum($totHorasLaborales)." > ".$MaxHoursWeek;
  echo "<br>";
  if(HourToNum($totHorasLaborales)>$MaxHoursWeek){
    //Si se pasa el total de horas semanales al permitido
    $flag=1;
    $str=$str."".$row["PrimerNombre"].$row["SegundoNombre"].$row["PrimerApellido"].$row["SegundoApellido"]." tipo de semana laboral ".$tipoSemanaL." Exede en:".gmdate("H:i:s", (int)subsTwoTimes($totHorasLaborales.":00",$MaxHoursWeek.":00"))."<br>";
  }

}
mysqli_close($cnx);
echo $str;

 ?>

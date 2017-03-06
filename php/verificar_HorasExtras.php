<?php
include_once 'funciones.php';
include '../php/verificar_sesion.php';
$user = $_SESSION['usuario_sesion'];
$Nitempresa=getNitEmpresa($user);
$Fecha = $_POST["Fecha"];
$IdArray    = $_POST["IdArray"];
$IdArray    = json_decode("$IdArray", true);
$NombresArray = $_POST["NombresArray"];
$NombresArray    = json_decode("$NombresArray", true);
$HoraEntradaArray    = $_POST["HoraEntradaArray"];
$HoraEntradaArray    = json_decode("$HoraEntradaArray", true);
$HoraSalidaArray    = $_POST["HoraSalidaArray"];
$HoraSalidaArray    = json_decode("$HoraSalidaArray", true);
$i=0;
$flag=0;//Si hay error poner 1
//Bucle
$cnx=cnx();
if(empty($Fecha)){
  echo "1, Coloque una Fecha";
  $flag=1;
}else{
  $Fecha = str_replace('/', '-', $Fecha);
  $Fecha  = date('Y-m-d', strtotime($Fecha));
  $date = new DateTime($Fecha);
  $week = $date->format("W");
  foreach ($IdArray as &$value) {
      $value = $value;
      //Revisar que las horas vengan en el formato
      if($flag==0){
        if(empty($HoraEntradaArray[$i])||empty($HoraSalidaArray[$i])){
          echo "1, Faltan las horas de: ".$NombresArray[$i];
          $flag=1;
          break;
        }
        if(!(verify_time_format($HoraEntradaArray[$i].":00") && verify_time_format($HoraSalidaArray[$i].":00"))){
          echo "1, Error en Formato de las horas de: ".$NombresArray[$i]." (Formato 00:00 23:59)";
          $flag=1;
          break;
        }
        if($HoraEntradaArray[$i]>$HoraSalidaArray[$i]){
          echo "1, Desde tiene que ser menor que Hasta en las horas de: ".$NombresArray[$i];
          $flag=1;
          break;
        }
      }
      //Revisar los horarios a ver si no esta lejos de ellos
      if($flag==0){
        $query=sprintf("SELECT * FROM col_semanal INNER JOIN semanal INNER JOIN htrabajo WHERE htrabajo.idTurno=semanal.idTurno AND col_semanal.NumeroDocumento=htrabajo.NumeroDocumento AND col_semanal.idSemanal=semanal.idSemanal AND htrabajo.NumeroDocumento='%s' AND semanal.nSemana='%s'",mysqli_real_escape_string($cnx,$value),mysqli_real_escape_string($cnx,$week));
    		$resul=mysqli_query($cnx,$query);
    		$row=mysqli_fetch_array($resul);
        if(empty($row["NumeroDocumento"])){
          echo "1, No se ha generado el semanal de ".$NombresArray[$i];
          $flag=1;
          break;
        }else{
          $dia = (string)date("D",strtotime($Fecha));
          $HoraEntrada=HourToNum($HoraEntradaArray[$i]);
          $HoraSalida=HourToNum($HoraSalidaArray[$i]);
          $Desde=HourToNum($row["Desde"]);//Hora a que entra a trabajar
          $Hasta=HourToNum($row["Hasta"]);//Hora que sale de trabajar
          //Revisar si ya esta Guardado
          $query2=sprintf("SELECT Desde, Hasta FROM `horas_extras` WHERE Fecha='%s' AND NumeroDocumentoPara='%s'",mysqli_real_escape_string($cnx,$Fecha),mysqli_real_escape_string($cnx,$value));
          $resul2=mysqli_query($cnx,$query2);
          $row2=mysqli_fetch_array($resul2);
          if($row2[0]!=""){//Encontro algo
            do {
                //Obtengo $row["Desde"] $row["Hasta"]
                //HourToNum($row["Desde"])
                //$Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)
                if((HourToNum($row2["Desde"])<=$HoraEntrada)&&($HoraEntrada<HourToNum($row2["Hasta"]))){
                  echo "1, Error ".$NombresArray[$i]." ya tiene horas extas en este dia de ".$row2["Desde"]."-".$row2["Hasta"];
                  $flag=1;
                  break;
                }
                if((HourToNum($row2["Desde"])<=$HoraSalida)&&($HoraSalida<HourToNum($row2["Hasta"]))){
                  echo "1, Error ".$NombresArray[$i]." ya tiene horas extas en este dia de ".$row2["Desde"]."-".$row2["Hasta"];
                  $flag=1;
                  break;
                }
            } while ($row2=mysqli_fetch_array($resul2));
          }
          //Fin
          if($flag==0){
            if(strcmp($dia,"Sun")==0){
              if($row["Domingo"]==1){
                if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                  echo "1, Error el Domingo ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                  $flag=1;
                  break;
                }
                if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                  echo "1, Error el Domingo ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                  $flag=1;
                  break;
                }
              }
            }elseif(strcmp($dia,"Mon")==0){
                        if($row["Lunes"]==1){
                          if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                            echo "1, Error el Lunes ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                            $flag=1;
                            break;
                          }
                          if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                            echo "1, Error el Lunes ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                            $flag=1;
                            break;
                          }
                        }
              }elseif(strcmp($dia,"Tue")==0){
                          if($row["Martes"]==1){
                            if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                              echo "1, Error el Martes ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                            if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                              echo "1, Error el Martes ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Wed")==0){
                          if($row["Miercoles"]==1){
                            //$Desde."<".$HoraEntrada."<=".$Hasta;
                            if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                              echo "1, Error el Miercoles ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                            if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                              echo "1, Error el Miercoles ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Thu")==0){
                          if($row["Jueves"]==1){
                            if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                              echo "1, Error el Jueves ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                            if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                              echo "1, Error el Jueves ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Fri")==0){
                          if($row["Viernes"]==1){
                            if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                              echo "1, Error el Viernes ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                            if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                              echo "1, Error el Viernes ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Sat")==0){
                          if($row["Sabado"]==1){
                            if(($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)){
                              echo "1, Error el Sabado ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                            if(($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)){
                              echo "1, Error el Sabado ".$NombresArray[$i]." su horario laboral fue: ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
            }
        }
      }

  		//$query=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$user));
  		//$resul=mysqli_query($cnx,$query);
  		//$row=mysqli_fetch_array($resul);
    }
  $i++;
  }
}
//Si $flag==0 guardar Horas Extras
//echo "1, El ND es".$user->getNumerodocumento()." Empresa:".$Nitempresa;
if($flag==0){
  $i=0;
  //Definimos las variables de MAX y Min para no abrir a cada rato la base
  $query3=sprintf("SELECT * FROM `horario_jornada` WHERE DiurnoNocturno='Diurno'");
  $result3=mysqli_query($cnx,$query3);
  $row3=mysqli_fetch_array($result3);
  $HDiurnoMX=$row3["Max"].":00";//Hora Max
  $HDiurnoMN=$row3["Min"].":00";//Hora Min
  $query3=sprintf("SELECT * FROM `horario_jornada` WHERE DiurnoNocturno='Nocturno'");
  $result3=mysqli_query($cnx,$query3);
  $row3=mysqli_fetch_array($result3);
  $HNocturnoMX=$row3["Max"].":00";//Hora Max
  $HNocturnoMN=$row3["Min"].":00";//Hora Min
  foreach ($IdArray as &$value) {
  //$HoraEntradaArray[$i]   y $HoraSalidaArray[$i] para pasar a numero HourToNum
    //revisemos si es HD o HN
    $NumeroDocumentoPor=$user->getNumerodocumento();
    $NumeroDocumentoPara=$value;
    $Desde=$HoraEntradaArray[$i];
    $Hasta=$HoraSalidaArray[$i];
    $Fecha=$Fecha;
    $NitEmpresa=$Nitempresa;

    $HEntradaEs=RevisarNocDiu($HoraEntradaArray[$i],$HDiurnoMX,$HDiurnoMN);
    $HSalidaEs=RevisarNocDiu($HoraSalidaArray[$i],$HDiurnoMX,$HDiurnoMN);
    if(strcmp($HEntradaEs,$HSalidaEs)==0){//son iguales
      $Tot=subsTwoTimes($HoraEntradaArray[$i],$HoraSalidaArray[$i]);
      if(strcmp($HEntradaEs, "D")==0){
        $NHorasDiurnas=gmdate("H:i:s", (int)$Tot);
        $NHorasNocturnas="00:00:00";
      }else{
        $NHorasNocturnas=gmdate("H:i:s", (int)$Tot);
        $NHorasDiurnas="00:00:00";
      }
    }else{
      if(strcmp($HEntradaEs, "D")==0){
        $Tot=subsTwoTimes($HoraEntradaArray[$i],$HDiurnoMX);
        $NHorasDiurnas=gmdate("H:i:s", (int)$Tot);
        $Tot=subsTwoTimes($HNocturnoMN,$HoraSalidaArray[$i]);
        $NHorasNocturnas=gmdate("H:i:s", (int)$Tot);
      }else{
        $Tot=subsTwoTimes($HoraEntradaArray[$i],$HNocturnoMX);
        $NHorasNocturnas=gmdate("H:i:s", (int)$Tot);
        $Tot=subsTwoTimes($HDiurnoMN,$HoraSalidaArray[$i]);
        $NHorasDiurnas=gmdate("H:i:s", (int)$Tot);
      }
    }
    $query = sprintf("INSERT INTO horas_extras(NumeroDocumentoPor,NumeroDocumentoPara,NHorasDiurnas,NHorasNocturnas,Desde,Hasta,Fecha,NitEmpresa) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
			mysqli_real_escape_string($cnx,$NumeroDocumentoPara),
			mysqli_real_escape_string($cnx,$NHorasDiurnas),
			mysqli_real_escape_string($cnx,$NHorasNocturnas),
      mysqli_real_escape_string($cnx,$Desde),
			mysqli_real_escape_string($cnx,$Hasta),
			mysqli_real_escape_string($cnx,$Fecha),
			mysqli_real_escape_string($cnx,$Nitempresa)
			);
		$estado = mysqli_query($cnx,$query);
    if(!$estado){
      $flag=1;
      echo "1, ERROR no se pudo insertar en la base desde ".$NombresArray[$i]."hacia abajo";
      break;
    }
    $i++;
  }
}
//fin
mysqli_close($cnx);
if($flag==0){
  echo "0, Guardado Exitoso";
}
function HourToNum($Hour){
  $Hour=(string)$Hour;
  $Hour= explode(":",$Hour);
  $Hour=$Hour[0].".".$Hour[1];
  return (float)$Hour;
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
 ?>

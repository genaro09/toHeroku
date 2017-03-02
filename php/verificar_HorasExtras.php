<?php
include_once 'funciones.php';
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
          $Desde=HourToNum($row["Desde"]);
          $Hasta=HourToNum($row["Hasta"]);
          //Revisar si ya esta Guardado
          $query2=sprintf("SELECT Desde, Hasta FROM `horas_extras` WHERE Fecha='%s' AND NumeroDocumentoPara='%s'",mysqli_real_escape_string($cnx,$Fecha),mysqli_real_escape_string($cnx,$value));
          $resul2=mysqli_query($cnx,$query2);
          $row2=mysqli_fetch_array($resul2);
          if($row2[0]!=""){//Encontro algo
            //do {
            //    if()
            //} while ($row2=mysqli_fetch_array($resul2));
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

//fin
mysqli_close($cnx);
if($flag==0){
  echo "0, Guardado Exitoso".$HoraEntradaArray[$i-1].$row["Desde"];
}
function HourToNum($Hour){
  $Hour=(string)$Hour;
  $Hour= explode(":",$Hour);
  $Hour=$Hour[0].".".$Hour[1];
  return (float)$Hour;
}
 ?>

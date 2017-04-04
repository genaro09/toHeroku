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
$TipoJornadaArray;//Todos los tipos de jornada de cada empleado
$DiaEsDeVacacion=0;//Se pone en 1 si cae en un dia de vacacion
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
  if(!verify_date_format($Fecha)){
    echo "1, el formato de la fecha es incorrecto. Recargue la pagina";
    break;
  }
  if(!isEmpresaExist($Nitempresa)){
    echo "1, la empresa que intenta ingresar es incorrecta. Recargue la pagina";
    break;
  }
  //Sabes si no se ha cerrado este dia ya
  $query=sprintf("SELECT * FROM llegadas_tarde where NitEmpresa='%s' AND Fecha='%s'",mysqli_real_escape_string($cnx,$Nitempresa),mysqli_real_escape_string($cnx,$Fecha));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    if($row["EstadoLlegadasTarde"]==1){
      echo "1, La fecha ".$Fecha." ya ha sido validada y cerrada!";
      $flag=1;
    }
  }

  //Fin
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
        $rowDeDiasPP=$row;
        if(empty($row["NumeroDocumento"])){
          echo "1, No se ha generado el semanal de ".$NombresArray[$i];
          $flag=1;
          break;
        }else{
          $dia = (string)date("D",strtotime($Fecha));
          $HoraEntrada=HourToNum($HoraEntradaArray[$i]);
          $HoraSalida=HourToNum($HoraSalidaArray[$i]);
          $arrayHorariosSemanal[$value] = array('Desde' => $row["Desde"], 'Hasta' => $row["Hasta"] );
          $Desde=HourToNum($row["Desde"]);//Hora a que entra a trabajar
          $Hasta=HourToNum($row["Hasta"]);//Hora que sale de trabajar
          //Revisar si ya esta Guardado
          $query2=sprintf("SELECT col_llegadas_tarde.Desde , col_llegadas_tarde.Hasta FROM col_llegadas_tarde INNER JOIN llegadas_tarde WHERE llegadas_tarde.Fecha='%s' AND llegadas_tarde.idLlegadasTarde=col_llegadas_tarde.idLlegadasTarde AND col_llegadas_tarde.NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$Fecha),mysqli_real_escape_string($cnx,$value));
          $resul2=mysqli_query($cnx,$query2);
          $row2=mysqli_fetch_array($resul2);
          if($row2[0]!=""){//Encontro algo
            do {
                //Obtengo $row["Desde"] $row["Hasta"]
                //HourToNum($row["Desde"])
                //$Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)
                if((HourToNum($row2["Desde"])<=$HoraEntrada)&&($HoraEntrada<HourToNum($row2["Hasta"]))){
                  echo "1, Error ".$NombresArray[$i]." ya tiene llegada tarde en este dia de ".$row2["Desde"]."-".$row2["Hasta"];
                  $flag=1;
                  break;
                }
                if((HourToNum($row2["Desde"])<=$HoraSalida)&&($HoraSalida<HourToNum($row2["Hasta"]))){
                  echo "1, Error ".$NombresArray[$i]." ya tiene llegada tarde en este dia de ".$row2["Desde"]."-".$row2["Hasta"];
                  $flag=1;
                  break;
                }
            } while ($row2=mysqli_fetch_array($resul2));
          }
          //Fin
          //LLENar el array de cada empleado pasa saber en que tipo de jornada callo
          if($flag==0){
            if(strcmp($dia,"Sun")==0){
              $TipoJornadaArray[$i]=$rowDeDiasPP["Domingo"];
                    if($row["Domingo"]==3){
                      echo "1, Error el Domingo ".$NombresArray[$i]."No trabajo";
                      $flag=1;
                      break;
                    }
                    if($row["Domingo"]==1){
                      if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                        echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del domingo ".$row["Desde"]."-".$row["Hasta"];
                        $flag=1;
                        break;
                      }
                    }
            }elseif(strcmp($dia,"Mon")==0){
              $TipoJornadaArray[$i]=$rowDeDiasPP["Lunes"];
                        if($row["Lunes"]==3){
                          echo "1, Error el Lunes ".$NombresArray[$i]."No trabajo";
                          $flag=1;
                          break;
                        }
                        if($row["Lunes"]==1){
                          if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                            echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del lunes ".$row["Desde"]."-".$row["Hasta"];
                            $flag=1;
                            break;
                          }
                        }
              }elseif(strcmp($dia,"Tue")==0){
                $TipoJornadaArray[$i]=$rowDeDiasPP["Martes"];
                          if($row["Martes"]==3){
                            echo "1, Error el Martes ".$NombresArray[$i]."No trabajo";
                            $flag=1;
                            break;
                          }
                          if($row["Martes"]==1){
                            if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                              echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del martes ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Wed")==0){
                $TipoJornadaArray[$i]=$rowDeDiasPP["Miercoles"];
                          if($row["Miercoles"]==3){
                            echo "1, Error el Miercoles ".$NombresArray[$i]."No trabajo";
                            $flag=1;
                            break;
                          }
                          if($row["Miercoles"]==1){
                            //$Desde."<".$HoraEntrada."<=".$Hasta;
                            if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                              echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del miercoles ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Thu")==0){
                $TipoJornadaArray[$i]=$rowDeDiasPP["Jueves"];
                          if($row["Jueves"]==3){
                            echo "1, Error el Jueves ".$NombresArray[$i]."No trabajo";
                            $flag=1;
                            break;
                          }
                          if($row["Jueves"]==1){
                            if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                              echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del jueves ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Fri")==0){
                $TipoJornadaArray[$i]=$rowDeDiasPP["Viernes"];
                          if($row["Viernes"]==3){
                            echo "1, Error el Viernes ".$NombresArray[$i]."No trabajo";
                            $flag=1;
                            break;
                          }
                          if($row["Viernes"]==1){
                            if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                              echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del viernes ".$row["Desde"]."-".$row["Hasta"];
                              $flag=1;
                              break;
                            }
                          }
              }elseif(strcmp($dia,"Sat")==0){
                $TipoJornadaArray[$i]=$rowDeDiasPP["Sabado"];
                          if($row["Sabado"]==3){
                            echo "1, Error el Sabado ".$NombresArray[$i]."No trabajo";
                            $flag=1;
                            break;
                          }
                          if($row["Sabado"]==1){
                            if(!(($HoraEntrada>=$Desde)&&($HoraSalida<=$Hasta))){
                              echo "1, Error: las horas tarde de ".$NombresArray[$i]." tienen que estar en su horario laboral del sabado ".$row["Desde"]."-".$row["Hasta"];
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
//Revisar si no existen horas similares de la misma persona
//$HoraEntradaArray[$i]>$HoraSalidaArray[$i]
$k=0;
foreach ($IdArray as &$value) {
    $countAuxR=0;//Contador de recurrencia
    $j=0;
    $contadorParaArraysRepetidos=0;
    //Revisar que las horas vengan en el formato
    foreach ($IdArray as &$valueAux) {
      if($value==$valueAux){
        //($Desde<=$HoraEntrada)&&($HoraEntrada<$Hasta)
        if(($HoraEntradaArray[$j]<=$HoraEntradaArray[$k])&&($HoraEntradaArray[$k]<$HoraSalidaArray[$j])){
          $countAuxR++;
        }
        //($Desde<$HoraSalida)&&($HoraSalida<=$Hasta)
        if(($HoraEntradaArray[$j]<$HoraSalidaArray[$k])&&($HoraSalidaArray[$k]<=$HoraSalidaArray[$j])){
          $countAuxR++;
        }

      }
      if($countAuxR>2){
        echo "1, Error: las horas tarde de ".$NombresArray[$k]." desde ".$HoraEntradaArray[$k]."-".$HoraSalidaArray[$k]." se encuentran 2 veces revisar las horas colocadas,";
        $flag=1;
        break;
      }
      $j++;
    }
    $k++;
  }


//FIN Revisar si una hora esta dentro de otra

//Si $flag==0 guardar Horas Tarde
//echo "1, El ND es".$user->getNumerodocumento()." Empresa:".$Nitempresa;
if($flag==0){
  $query=sprintf("SELECT * FROM llegadas_tarde where NitEmpresa='%s' AND Fecha='%s'",mysqli_real_escape_string($cnx,$Nitempresa),mysqli_real_escape_string($cnx,$Fecha));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    $IsHEExist=TRUE;
    $idLlegadasTarde=$row["idLlegadasTarde"];
  }else
    $IsHEExist=FALSE;
  if(!$IsHEExist){
    $query = sprintf("INSERT INTO llegadas_tarde(NitEmpresa,Fecha,EstadoLlegadasTarde) VALUES ('%s','%s','%s')",
      mysqli_real_escape_string($cnx,$Nitempresa),
      mysqli_real_escape_string($cnx,$Fecha),
      mysqli_real_escape_string($cnx,"0")
      );
    $estado = mysqli_query($cnx,$query);
    if(!$estado){
      $flag=1;
      echo "1, ERROR no se pudo insertar en la base desde La las llegadas tarde. Recargue  la pagina para ver su conexion ";
      break;
    }
    if($flag==0){
      $query=sprintf("SELECT * FROM llegadas_tarde where NitEmpresa='%s' AND Fecha='%s'",mysqli_real_escape_string($cnx,$Nitempresa),mysqli_real_escape_string($cnx,$Fecha));
      $resul=mysqli_query($cnx,$query);
      $row=mysqli_fetch_array($resul);
      $idLlegadasTarde=$row["idLlegadasTarde"];
    }
  }

}
//revisar si tiene mismas horas un empleado en dia anterior
if($flag==0){
  $i=0;
  $prev_date = date('Y-m-d', strtotime($Fecha .' -1 day'));
  $query=sprintf("SELECT * FROM llegadas_tarde where NitEmpresa='%s' AND Fecha='%s'",mysqli_real_escape_string($cnx,$Nitempresa),mysqli_real_escape_string($cnx,$prev_date));
  $resul=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($resul);
  if($row[0]!=""){
    foreach ($IdArray as &$value) {
      $queryAux=sprintf("SELECT * FROM col_llegadas_tarde WHERE idLlegadasTarde='%s' AND NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$row["idLlegadasTarde"]),mysqli_real_escape_string($cnx,$value));
      $resulAux=mysqli_query($cnx,$queryAux);
      $rowAux=mysqli_fetch_array($resulAux);
      if($rowAux[0]!=""){
        $DesdeAux=$HoraEntradaArray[$i].":00";
        $HastaAux=$HoraSalidaArray[$i].":00";
        if(($rowAux["Desde"]==$DesdeAux)&&($rowAux["Hasta"]==$HastaAux)){
          $flag=1;
          echo "2,".$NombresArray[$i]."-".$HoraEntradaArray[$i]."-".$HoraSalidaArray[$i];
          break;
        }

      }
      $i++;
    }
  }
}
//FIN

if($flag==0){
  $i=0;
  foreach ($IdArray as &$value) {
  //$HoraEntradaArray[$i]   y $HoraSalidaArray[$i] para pasar a numero HourToNum
    //revisemos si es HD o HN
    $NumeroDocumentoPor=$user->getNumerodocumento();
    $NumeroDocumentoPara=$value;
    $Desde=$HoraEntradaArray[$i];
    $Hasta=$HoraSalidaArray[$i];
    $Fecha=$Fecha;
    $NitEmpresa=$Nitempresa;
    $TipoJornada=$TipoJornadaArray[$i];
    //Ver si su departamento esta en vacacion
    $DiaEsDeVacacionPD=$DiaEsDeVacacion;
    if($DiaEsDeVacacion==0){
      $DiaEsDeVacacionPD=0;
      $idCod_Municipio=obtFromEmployDepart($NumeroDocumentoPara);
      $query=sprintf("SELECT * FROM `dias_asueto_codigo_trabajo` WHERE idCod_Municipio='%s'",mysqli_real_escape_string($cnx,$idCod_Municipio));
      $resul=mysqli_query($cnx,$query);
      $fechaVacacion= explode("-", $Fecha);
      while($row=mysqli_fetch_array($resul)){
        if ((strcmp($row["Dia"], (string)$fechaVacacion[2])== 0)&&(strcmp($row["Mes"], (string)$fechaVacacion[1])== 0)) {
          $DiaEsDeVacacionPD=1;
        }
      }
    }
    if($DiaEsDeVacacionPD==1){
      echo "1, Error. Este dia era de vacacion: ".$row["Descripcion"];
      $flag=1;
      break;
    }



    //FIN
    //$idLlegadasTarde
    
    if($flag==0){
      date_default_timezone_set('America/El_Salvador');
      $dateTime = date("Y-m-d H:i:s");
      $query = sprintf("INSERT INTO col_llegadas_tarde(idLlegadasTarde,NumeroDocumentoPor,NumeroDocumento,HSDesde,HSHasta,Desde,Hasta,Tiempo) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
        mysqli_real_escape_string($cnx,$idLlegadasTarde),
        mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
        mysqli_real_escape_string($cnx,$NumeroDocumentoPara),
        mysqli_real_escape_string($cnx,$arrayHorariosSemanal[$NumeroDocumentoPara]["Desde"]),
        mysqli_real_escape_string($cnx,$arrayHorariosSemanal[$NumeroDocumentoPara]["Hasta"]),
        mysqli_real_escape_string($cnx,$Desde),
        mysqli_real_escape_string($cnx,$Hasta),
        mysqli_real_escape_string($cnx,gmdate("H:i:s", (int)subsTwoTimes($Desde,$Hasta)))
        );
      $estado = mysqli_query($cnx,$query);
      if(!$estado){
        $flag=1;
        echo "1, ERROR no se pudo insertar en la base desde ".$NombresArray[$i]."hacia abajo";
        break;
      }
    }
    $i++;
  }
}
//fin
mysqli_close($cnx);
if($flag==0){
  echo "0, Guardado Exitoso";
}

function RevisarNocDiu($Hour,$HDiurnoMX,$HDiurnoMN){
  if((HourToNum($HDiurnoMN)<=HourToNum($Hour))&&(HourToNum($Hour)<HourToNum($HDiurnoMX))){
    return  "D";
  }else
    return  "N";
}

 ?>

<?php
function Realizar_Recibo($user,$NumeroDocumento,$V,$S,$A,$L,$RV,$Salario_Mensual,$Cargo_Empleado,$Nitempresa){
  $cnx=cnx();
  $NameDataBase=NameDataBase();
  //Obtener el RefNumero
  $query=sprintf("SELECT MAX(recibo.RefNumero) FROM recibo where RefNitEmpresa='%s' and RefYear='%s'",mysqli_real_escape_string($cnx,$Nitempresa),mysqli_real_escape_string($cnx,date('Y')));
  $result=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($result);
  if($row[0]==NULL){
    $RefNumero=0;
  }else $RefNumero=$row[0]+1;
  //El proximo ID
  $query=sprintf("SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '%s' AND   TABLE_NAME   = 'recibo'",mysqli_real_escape_string($cnx,$NameDataBase));
  $result=mysqli_query($cnx,$query);
  $row=mysqli_fetch_array($result);
  $NumeroDeRecibo=$row["AUTO_INCREMENT"];
  $query = sprintf("INSERT INTO recibo(idRecibo,RefYear,RefNitEmpresa,RefNumero,Fecha_Generado,NumeroDocumento_Para,NumeroDocumento_Por,Vacacion,Indemnizacion,Aguinaldo,Salario,Retiro_Voluntario,Salario_Mensual,Cargo_Empleado) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
    mysqli_real_escape_string($cnx,$NumeroDeRecibo),
    mysqli_real_escape_string($cnx,(string)date('Y')),
    mysqli_real_escape_string($cnx,(string)$Nitempresa),
    mysqli_real_escape_string($cnx,$RefNumero),
    mysqli_real_escape_string($cnx,date('Y/m/d h:i:s', time())),
    mysqli_real_escape_string($cnx,$NumeroDocumento),
    mysqli_real_escape_string($cnx,$user->getNumerodocumento()),
    mysqli_real_escape_string($cnx,$V),
    mysqli_real_escape_string($cnx,$L),
    mysqli_real_escape_string($cnx,$A),
    mysqli_real_escape_string($cnx,$S),
    mysqli_real_escape_string($cnx,$RV),
    mysqli_real_escape_string($cnx,$Salario_Mensual),
    mysqli_real_escape_string($cnx,$Cargo_Empleado)
    );
  $estado = mysqli_query($cnx,$query);
  if(!($estado)){
    $NumeroDeRecibo=0;
  }
  $valoresAReturn[0]=$NumeroDeRecibo;
  $valoresAReturn[1]=$RefNumero;
  return $valoresAReturn;
}


function funcion_validar_PDF($Array_valores){
  $opc=$Array_valores["opc"];
    if($opc==1){
      //vacacion
      $error=0;
      $flag=0;
      $salario_mensual = $Array_valores['salario_mensual'];
      $diasT2= calcular_dias_anio($Array_valores['d1'],$Array_valores['d2']);
      $Tot_a_pagar=0.00;
      $Tot_dias=0;
      $salario_anual_vaca=(($salario_mensual/30)*15)+((($salario_mensual/30)*15)*0.3);
      $por_dias_restantes=0.00;
      $Meses=$diasT2[0];
      $Dias=$diasT2[1];
      $valor_diario=0;
      $valor_Aux=0.00;
      $tot_renta=0.00;
      $Tot_dias=($Meses*30)+$Dias;
      //Calcular dias
      $d2=formatDate((string)$Array_valores['d2']);
      $d1=formatDate((string)$Array_valores['d1']);
      $datetime1 = new DateTime((string)$d1);
      $datetime2 = new DateTime((string)$d2);
      $interval = $datetime1->diff($datetime2);
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      $Tot_dias_P_A=$diasTotal;
      //FIN
      while($Meses>12){
        $Tot_a_pagar=$salario_anual_vaca+$Tot_a_pagar;
        $Meses=$Meses-12;
      }
      $por_dias_restantes=(($Meses*30)+$Dias)/(30*12);
      $Tot_a_pagar=(($salario_anual_vaca)*$por_dias_restantes)+$Tot_a_pagar;
      $Tot_a_pagar=number_format((float)$Tot_a_pagar, 2, '.', '');

      //Calcular Renta
      $aux_total_renta=$Tot_a_pagar-($Tot_a_pagar*0.03)-($Tot_a_pagar*0.0625);
      $valor_diario=(1*$aux_total_renta)/$Tot_dias;
      //la renta de la vacacion se calcula de forma quincenal
      //Se calcula la renta mensual
      while($Meses>=12){
        $valor_Aux=$valor_diario*(12*30);
        $tot_renta=$tot_renta+quitarrRenta($valor_Aux,2);//1 significa mensual, 2 quincenal
        $Meses=$Meses-12;
      }
      $por_dias_restantes=(($Meses*30)+$Dias)/(30*12);
      if($por_dias_restantes>0){
        $valor_Aux=$valor_diario*$por_dias_restantes;
        $tot_renta=$tot_renta+quitarrRenta($valor_Aux,2);//1 significa mensual, 2 quincenal
      }

        if($Tot_dias<=0){
          $flag=1;
        }
      $tot_renta=number_format((float)$tot_renta, 2, '.', '');
      $array = array($Tot_a_pagar,$tot_renta,$error,$diasT2,$Tot_dias_P_A);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error


    }else if($opc==2){
      //salario
      $error=0;
      $flag=0;
      $salario_mensual = $Array_valores['salario_mensual'];
      $dias_a_cobrar= calcular_dias_anio($Array_valores['d1'],$Array_valores['d2']);
      $Tot_a_pagar=0.00;
      //
      $Meses=$dias_a_cobrar[0];
      $Dias=$dias_a_cobrar[1];
      $Tot_a_pagar=($Meses*$salario_mensual)+(($salario_mensual/30)*$Dias);
      //
      $Tot_dias=0;
      $salario_anual_vaca=(($salario_mensual/30)*15)+((($salario_mensual/30)*15)*0.3);
      $por_dias_restantes=0.00;
      $valor_diario=0;
      $valor_Aux=0.00;
      $tot_renta=0.00;
      $Tot_dias=($Meses*30)+$Dias;
      //Calcular dias
      $d2=formatDate((string)$Array_valores['d2']);
      $d1=formatDate((string)$Array_valores['d1']);
      $datetime1 = new DateTime((string)$d1);
      $datetime2 = new DateTime((string)$d2);
      $interval = $datetime1->diff($datetime2);
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      $Tot_dias_P_A=$diasTotal;
      //FIN
      $Tot_a_pagar=number_format((float)$Tot_a_pagar, 2, '.', '');
      $aux_total_renta=$Tot_a_pagar-($Tot_a_pagar*0.03)-($Tot_a_pagar*0.0625);
      $valor_diario=$aux_total_renta/$Tot_dias;
      while($flag==0){
        if($Meses>=1){
          $valor_Aux=$valor_diario*(30);
          $tot_renta=$tot_renta+quitarrRenta($valor_Aux,1);//1 significa mensual, 2 quincenal
          $Meses=$Meses-1;
          $Tot_dias=$Tot_dias-30;
        }else if($Tot_dias>15){
          //Se calcula la renta mensual
          $valor_Aux=$valor_diario*$Tot_dias;
          $tot_renta=$tot_renta+quitarrRenta($valor_Aux,1);//1 significa mensual
          if(quitarrRenta($valor_Aux,1)<0){
            $error=1;
          }
          $Tot_dias=$Tot_dias-30;
        }else if($Tot_dias>7){
          //Se calcula la renta quincenal
          $valor_Aux=$valor_diario*$Tot_dias;
          $tot_renta=$tot_renta+quitarrRenta($valor_Aux,2);//1 significa mensual
          if(quitarrRenta($valor_Aux,1)<0){
            $error=1;
          }
          $Tot_dias=$Tot_dias-15;
        }else if($Tot_dias>0){
          //Se calcula la renta semanal
          $valor_Aux=$valor_diario*$Tot_dias;
          $tot_renta=$tot_renta+quitarrRenta($valor_Aux,3);//1 significa mensual
          if(quitarrRenta($valor_Aux,1)<0){
            $error=1;
          }
          $Tot_dias=$Tot_dias-7;
        }

        if($Tot_dias<=0){
          $flag=1;
        }
      }
      $tot_renta=number_format((float)$tot_renta, 2, '.', '');
      $array = array($Tot_a_pagar,$tot_renta,$error,$Tot_dias_P_A);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error

    }else if($opc==3){
      //Liquidacion
      $salario_mensual = $Array_valores['salario_mensual'];
      $dias_a_cobrar= calcular_dias_anio($Array_valores['d1'],$Array_valores['d2']);
      $Tot_a_pagar=0.00;
      $Meses=$dias_a_cobrar[0];
      $Dias=$dias_a_cobrar[1];
      $salario_minimo_mensual=$Array_valores["salario_minimo_mensual"];
      $por_dias_restantes=0.00;
      $Meses=$dias_a_cobrar[0];
      $Dias=$dias_a_cobrar[1];
      //Calcular dias
      $d2=formatDate((string)$Array_valores['d2']);
      $d1=formatDate((string)$Array_valores['d1']);
      $datetime1 = new DateTime((string)$d1);
      $datetime2 = new DateTime((string)$d2);
      $interval = $datetime1->diff($datetime2);
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      $Tot_dias_P_A=$diasTotal;
      //FIN
      while($Meses>12){
        $Tot_a_pagar=$salario_mensual+$Tot_a_pagar;
        $Meses=$Meses-12;
      }
      $por_dias_restantes=(($Meses*30)+$Dias)/(30*12);
      $Tot_a_pagar=(($salario_mensual)*$por_dias_restantes)+$Tot_a_pagar;
      if($Tot_a_pagar>($salario_minimo_mensual*4)){
        $Tot_a_pagar=$salario_minimo_mensual*4;
      }

      $Tot_a_pagar=number_format((float)$Tot_a_pagar, 2, '.', '');
      $array = array($Tot_a_pagar,$Tot_dias_P_A);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error

    }else if($opc==4){
      //Aguinaldo
      $salario_mensual = $Array_valores['salario_mensual'];
      $d2=formatDate((string)$Array_valores['d1']);
      $d1=formatDate((string)$Array_valores['d2']);
      $datetime1 = new DateTime((string)$d1);
      $datetime2 = new DateTime((string)$d2);
      $interval = $datetime1->diff($datetime2);
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      $dias_a_cobrar= $diasTotal;
      $dias_toda_la_vida=calcular_dias_anio($Array_valores['fecha_contratacion'],$Array_valores['d2']);
      $Tot_a_pagar=0.00;
      $Tot_anios=0;
      $dias_aguinaldo=0;
      $Meses=$dias_toda_la_vida[0];
      $Dias=$dias_toda_la_vida[1];
      //Calcular dias
      $Tot_dias_P_A=$diasTotal;
      //FIN
      $DiasDC=$dias_a_cobrar;
      while($Meses>12){
        $Tot_anios++;
        $Meses=$Meses-12;
      }
      if($Tot_anios<3){
        $dias_aguinaldo=15;
      }else if($Tot_anios>=3&&$Tot_anios<10){
        $dias_aguinaldo=19;
      }else{
        $dias_aguinaldo=21;
      }
      $Tot_a_pagar=$Tot_a_pagar+((($DiasDC)/(365))*(($salario_mensual/30)*$dias_aguinaldo));
      $Tot_a_pagar=number_format((float)$Tot_a_pagar, 2, '.', '');
      $array = array($Tot_a_pagar,$Tot_dias_P_A);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error

    }else if($opc==5){
      //Retiro Voluntario
      $salario_mensual = $Array_valores['salario_mensual'];
      $dias_a_cobrar= calcular_dias_anio($Array_valores['d1'],$Array_valores['d2']);
      $Tot_a_pagar=0.00;
      $Meses=$dias_a_cobrar[0];
      $Dias=$dias_a_cobrar[1];
      $salario_minimo_mensual=$Array_valores["salario_minimo_mensual"];
      $por_dias_restantes=0.00;
      $Meses=$dias_a_cobrar[0];
      $Dias=$dias_a_cobrar[1];
      //Calcular dias
      $d2=formatDate((string)$Array_valores['d2']);
      $d1=formatDate((string)$Array_valores['d1']);
      $datetime1 = new DateTime((string)$d1);
      $datetime2 = new DateTime((string)$d2);
      $interval = $datetime1->diff($datetime2);
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      $Tot_dias_P_A=$diasTotal;
      //FIN
      while($Meses>12){
        $Tot_a_pagar=$salario_mensual+$Tot_a_pagar;
        $Meses=$Meses-12;
      }
      $por_dias_restantes=(($Meses*30)+$Dias)/(30*12);
      $Tot_a_pagar=(($salario_mensual)*$por_dias_restantes)+$Tot_a_pagar;
      if($Tot_a_pagar>($salario_minimo_mensual*4)){
        $Tot_a_pagar=$salario_minimo_mensual*4;
      }
      $Tot_a_pagar=$Tot_a_pagar/2;
      $Tot_a_pagar=number_format((float)$Tot_a_pagar, 2, '.', '');
      $array = array($Tot_a_pagar,$Tot_dias_P_A);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error
    }
    return $array;
  }//fin funcione

  //Para encontrar el Desde y Hasta de la tabla de renta_total
  function quitarrRenta($total,$tipoRenta){
    $flag=0;
    $valor=0.00;
    $cnx=cnx();
    $query=sprintf("SELECT * FROM `renta` WHERE tipo_pago ='%s'",mysqli_real_escape_string($cnx,$tipoRenta));
    $result=mysqli_query($cnx,$query);
    while(($row=mysqli_fetch_array($result))){
			if($row["Hasta"]==0){
				if($total>=$row["Desde"]){
          $valor=(($total-$row["sobre_exceso"])*$row["porcentaje_aplicar"])+$row["Cuota_fija"];
          $flag=1;
        }
			}else if(($row["Hasta"]>$total)&&($total>=$row["Desde"])){
        $valor=(($total-$row["sobre_exceso"])*$row["porcentaje_aplicar"])+$row["Cuota_fija"];
        $flag=1;
      }
		}
    mysqli_close($cnx);
    if($flag==0){
      $valor=0;
    }
    return $valor;
  }
  function formatDate($date) {
    $monthNames = array(
      "Jan"=> 1, "Feb"=> 2, "Mar"=> 3,
      "Apr"=> 4, "May"=> 5, "Jun"=> 6, "Jul"=> 7,
      "Aug"=> 8, "Sep"=> 9, "Oct"=> 10,
      "Nov"=> 11, "Dec"=> 12,
    );
    $str = split(" ", $date);
    //return $str[3];
    return $str[3]."-".$monthNames[$str[1]]."-".$str[2];
  }
  function formatDatePD($date) {
    $monthNames = array(
      "Jan"=> 1, "Feb"=> 2, "Mar"=> 3,
      "Apr"=> 4, "May"=> 5, "Jun"=> 6, "Jul"=> 7,
      "Aug"=> 8, "Sep"=> 9, "Oct"=> 10,
      "Nov"=> 11, "Dec"=> 12,
    );
    $str = split(" ", $date);
    //return $str[3];
    return $str[2]."/".$monthNames[$str[1]]."/".$str[3];
  }

  function getDaysInMonth($m,$y) {
     return cal_days_in_month(CAL_GREGORIAN, ($m+0), ($y+0));
  }
  function calcular_dias_anio($d1,$d2){
    $mes=0;
    $diasR=0;
    $d2=formatDate((string)$d2);
    $d1=formatDate((string)$d1);
    //sacar el primer dia para saber cuando se ha pasado 1 mes
      $dateAux = split("-", $d1);
      $daux=floatval($dateAux[2]);
      $maux=$dateAux[1];
      $yaux=$dateAux[0];
      //Arreglar la fecha
      try {
            $dateAux = new DateTime($yaux.'-'.$maux.'-'.$daux);
      } catch (Exception $e) {
            return $e->getMessage();
            exit(1);
      }
          $dateAux->modify('-1 day');
          $dateAux = $dateAux->format('Y-m-d');
    //fin
    //Calcular Meses
    $d1Aux = strtotime($d1);
    $d2Aux = strtotime($d2);
    $min_date = min($d1Aux, $d2Aux);
    $max_date = max($d1Aux, $d2Aux);
    $i = 0;
    while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
        $i++;
    }
    $mes=$i;
    $d1 = date('Y-m-d', strtotime("+".$i." months", strtotime($d1)));
    //calcular diasT
    $dAUX = date('Y-m-d', strtotime("+1 months", strtotime($d1)));
    $dAUX = date('Y-m-d', strtotime("-1 day", strtotime($dAUX)));
    if(strtotime($dAUX)==strtotime($d2)){
      $mes++;
      $diasR=0;
    }else{
      $datetime1 = new DateTime((string)$d1);
      $datetime2 = new DateTime((string)$d2);
      $interval = $datetime1->diff($datetime2);
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      //Fin
      $diasR=$diasTotal;
    }
    //fin
    return [$mes, $diasR];
  }






 ?>

<?php
include_once '../php/cn.php';

$opc = 2;
  if($opc==1){
    //vacacion
    $error=0;
    $flag=0;
    $salario_mensual = $_POST['salario_mensual'];
    $diasT2= calcular_dias_anio($_POST['d1'],$_POST['d2']);
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
    $array = array($Tot_a_pagar,$tot_renta,$error,$diasT2);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error
    echo json_encode($array)  ;


  }else if($opc==2){
    //salario
    $error=0;
    $flag=0;
    $salario_mensual = 500;
    $dias_a_cobrar= calcular_dias_anio("Mon Feb 15 2016 00:00:00 GMT-0600 (Central America Standard Time)","Tue Feb 14 2017 00:00:00 GMT-0600 (Central America Standard Time)");
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
    $array = array($Tot_a_pagar,$tot_renta,$error);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error
    echo json_encode($array)  ;

  }else if($opc==3){
    //Liquidacion
    $salario_mensual = $_POST['salario_mensual'];
    $dias_a_cobrar= calcular_dias_anio($_POST['d1'],$_POST['d2']);
    $Tot_a_pagar=0.00;
    $Meses=$dias_a_cobrar[0];
    $Dias=$dias_a_cobrar[1];
    $salario_minimo_mensual=$_POST["salario_minimo_mensual"];
    $por_dias_restantes=0.00;
    $Meses=$dias_a_cobrar[0];
    $Dias=$dias_a_cobrar[1];
    $Tot_dias_alertD=$Dias;
    $Tot_dias_alertM=$Meses;
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
    $array = array($Tot_a_pagar,$Tot_dias_alertD,$Tot_dias_alertM);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error
    echo json_encode($array)  ;

  }else if($opc==4){
    //Aguinaldo
    $salario_mensual = $_POST['salario_mensual'];
    $dias_a_cobrar= calcular_dias_anio($_POST['d1'],$_POST['d2']);
    $dias_toda_la_vida=calcular_dias_anio($_POST['fecha_contratacion'],$_POST['d2']);
    $Tot_a_pagar=0.00;
    $Tot_anios=0;
    $dias_aguinaldo=0;
    $Meses=$dias_toda_la_vida[0];
    $Dias=$dias_toda_la_vida[1];
    $MesesDC=$dias_a_cobrar[0];
    $DiasDC=$dias_a_cobrar[1];
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
    while($MesesDC>12){
      $Tot_a_pagar=$Tot_a_pagar+(($salario_mensual/30)*$dias_aguinaldo);
      $MesesDC=$MesesDC-12;
    }
    $Tot_a_pagar=$Tot_a_pagar+(((($MesesDC*30)+$DiasDC)/(30*12))*(($salario_mensual/30)*$dias_aguinaldo));
    $Tot_a_pagar=number_format((float)$Tot_a_pagar, 2, '.', '');
    $array = array($Tot_a_pagar);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error
    echo json_encode($array)  ;

  }else if($opc==5){
    //Retiro Voluntario
    $salario_mensual = $_POST['salario_mensual'];
    $dias_a_cobrar= calcular_dias_anio($_POST['d1'],$_POST['d2']);
    $Tot_a_pagar=0.00;
    $Meses=$dias_a_cobrar[0];
    $Dias=$dias_a_cobrar[1];
    $salario_minimo_mensual=$_POST["salario_minimo_mensual"];
    $por_dias_restantes=0.00;
    $Meses=$dias_a_cobrar[0];
    $Dias=$dias_a_cobrar[1];
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
    $array = array($Tot_a_pagar);//Aqui vamos a enviar todos los valores 1=total, 2=renta, 3=error
    echo json_encode($array)  ;



  }

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
    return $str[3]."/".$monthNames[$str[1]]."/".$str[2];
  }
  function formatDate2($date) {
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

  function getDaysInMonth($m,$y) {
     return cal_days_in_month(CAL_GREGORIAN, ($m+0), ($y+0));
  }
  function calcular_dias_anio2($d1,$d2){
    $mes=0;
    $diasR=0;
    //con guion
    //$d2G=formatDate2((string)$d2);
    //$d1G=formatDate2((string)$d1);
      $countABi=0;
      $d2G="2016/03/31";//FIN
      $d1G="2016/03/01";//INI
      $datetime1 = new DateTime((string)$d1G);
      $datetime2 = new DateTime((string)$d2G);
      $interval = $datetime1->diff($datetime2);
      echo "<br>";
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      //Revisar si paso por año bi
      $begin = $datetime1;
      $end = $datetime2;
      $interval = DateInterval::createFromDateString('1 day');
      $period = new DatePeriod($begin, $interval, $end);
      foreach ( $period as $dt ) {
          if(($dt->format('m') === '02') && ($dt->format('d') === '29')) {
              $countABi++;
          }
      }
      //Fin
      $diasTotal=$diasTotal-$countABi;
      $diasLab=round(($diasTotal*360)/365);
      $diasLab=$diasLab/30;
      $mes = floor($diasLab);      // entera
      $fraction = $diasLab - $mes; // decimal
      $diasR=round($fraction/(1/30));
      echo "MES:".$mes." dias:".$diasR;
    return [$mes, $diasR];
  }
  function calcular_dias_anio3($d1,$d2){
    $dias_del_mes;
    $mes=0;
    $diasAux=0;
    $dateA;
    $m;
    $y;
    $d;
    $flag1=0;
    $flag2=0;
    $d2=formatDate((string)$d2);
    $d1=formatDate((string)$d1);
    //quitar despues
    $d2="2016/03/31";//FIN
    $d1="2016/03/01";//INI
    echo "Dia1:".$d1." Dia2:".$d2;
    echo "<br>";
    //sacar el primer dia para saber cuando se ha pasado 1 mes
      $dateAux = split("/", $d1);
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
          $dateAux = $dateAux->format('Y/m/d');
          echo "Fecha d1 -1:".$dateAux;
          echo "<br>";
          $dateAux = split("/", $dateAux);
          $daux=floatval($dateAux[2]);
          echo "dia ant".$daux;
          echo "<br>";
          $maux=$dateAux[1];
          $yaux=$dateAux[0];
    //fin
    if(strtotime($d1)==strtotime($d2)){
      $diasR=1;
      $mes=0;
    }else{
      $diasR=0;
      //while
      while(strtotime($d1)<=strtotime($d2)){
        $diasR++;
        $dateA = (string)$d1;
        $dateA = split("/", $d1);
        $d=floatval($dateA[2]);
        $m=$dateA[1];
        $y=$dateA[0];
        $dias_del_mes=floatval(getDaysInMonth($m,$y));
        //Arreglar la fecha
        try {
              $dateA = new DateTime($y.'-'.$m.'-'.$d);
        } catch (Exception $e) {
              return $e->getMessage();
              exit(1);
        }
            //calculos si pasa 1 mes
            if($d==$daux){
              $mes++;
              $diasR=0;
            }
            //final
            //Arreglar la fecha
            $dateA->modify('+1 day');
            $dateA = $dateA->format('Y/m/d');
            $d1 = $dateA;
            //final

        //final while
      }
    }
    echo "Mes".$mes." Dias".$diasR;
    echo "<br>";
    return [$mes, $diasR];


  }

  function calcular_dias_anio($d1,$d2){
    $mes=0;
    $diasR=0;
    $d2="2017-02-14";//FIN
    $d1="2016-02-15";//INI
    echo "Dia1:".$d1." Dia2:".$d2;
    echo "<br>";
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
      echo "<br>";
      $diasTotal=$interval->format('%a');
      $diasTotal=$diasTotal+1;
      //Fin
      $diasR=$diasTotal;
    }
    //fin
    echo "Mes: ".$mes." Dias: ".$diasR; // 8
    echo "<br>";
    return [$mes, $diasR];
  }






 ?>

<?PHP
include '../php/funciones.php';
include '../php/verificar_sesion.php';
$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
if (isset($_POST['checkboxvar'])){
    $IDarray=$_POST['checkboxvar'];
  $anio1=$_POST['annio'];
  $anio2=$_POST['annio2'];
  $semana1=$_POST['semana'];
  $semana2=$_POST['semana2'];
  $k=$semana1;
  $flag=0;
  $count=0;
  $info=array();
  $dataTurnos=array();
  if(($anio2>=$anio1)&&($semana2>=$semana1)){
    for($anio1;$anio1<=$anio2;$anio1++){
      if($anio1==$anio2){
        while($k<=$semana2){
          $base=array("Annio" => $anio1, "Semana" => $k);
          $info[$count]= $base;
          $count++;
          $k++;
        }
      }else{
        if($flag==1){
          $k=1;
        }else $k=$semana1;
        $flag=1;
        for($k;$k<=52;$k++){
          $base=array("Annio" => $anio1, "Semana" => $k);
          $info[$count]= $base;
          $count++;
        }
        $k=1;
      }
    }
    //print_r($info[0]["Annio"]);
    $count2=0;
    $cnx=cnx();
    //IDarray tiene los idTurno
    for ($i=0;$i<sizeof($IDarray);$i++){
      //print_r($IDarray[$i]);
      //$NitEmpresa
      $idTurno=$IDarray[$i];
      //count tiene el nuemro de semana annio seleccionado
      for($j=0;$j<$count;$j++){
        $annio=$info[$j]["Annio"];
        $semana=$info[$j]["Semana"];
        $query=sprintf("SELECT * FROM semanal where NitEmpresa='%s' and nSemana='%s' and anno='%s' and idTurno='%s' ",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$semana),mysqli_real_escape_string($cnx,$annio),mysqli_real_escape_string($cnx,$idTurno));
  			$result=mysqli_query($cnx,$query);
  			$row=mysqli_fetch_array($result);
        if($row[0]==""){
          //Cuando no esta creado
          $dataTurnos[$count2]=array("idTurno" => $idTurno, "idSemanal" => "NE", "Semana" => $semana, "annio" => $annio);
        }else $dataTurnos[$count2]=array("idTurno" => $idTurno, "idSemanal" => $row["idSemanal"], "Semana" => $semana, "annio" => $annio);
        //Obtener los empleados
        //$dataTurnos[$count2]=array("idTurno" => $idTurno, "idSemanal" => $row["idSemanal"]);
        $count2++;
      }
    }
    //llenar la data con los usuarios
    $contadorF=0;
    $contadorSemanas=0;
    $dataT=array();//dataFinal
    $arrayAux=array();//Aux
    for ($i=0;$i<sizeof($IDarray);$i++){
      //Nombre Turno
      $queryNT=sprintf("SELECT * FROM turno where idTurno='%s' ",mysqli_real_escape_string($cnx,$IDarray[$i]));
      $resultNT=mysqli_query($cnx,$queryNT);
      $rowNT=mysqli_fetch_array($resultNT);
      //Colocar el nombre del turno y las semanas
      $arrayAux=array("Turno: ".$rowNT["nombreTurno"]);
      for($m=0;$m<$count;$m++){
        $NWeek = $info[$m]["Semana"];
        $NYear=$info[$m]["Annio"];
        $week_array = getStartAndEndDate($NWeek,$NYear);
        foreach($week_array as $key => $value){
            $arrayAux=array_merge($arrayAux,array($key.' '.$value));
        }
       //$arrayAux=array_merge($arrayAux,$key.' '.$value);

      }
      $dataT[$contadorF]=$arrayAux;
      $contadorF++;
      //Fin
      $idTurno=$IDarray[$i];
      $j=0;
      //Obtener todos los empleados
      $queryIT=sprintf("SELECT DISTINCT NumeroDocumento  from htrabajo where idTurno='%s' ",mysqli_real_escape_string($cnx,$IDarray[$i]));
      $resultIT=mysqli_query($cnx,$queryIT);
      while($rowIT=mysqli_fetch_array($resultIT)){//Los usuarios del turno
        $query=sprintf("SELECT * from empleado where NumeroDocumento='%s' ",mysqli_real_escape_string($cnx,$rowIT["NumeroDocumento"]));
        $result=mysqli_query($cnx,$query);
        $row=mysqli_fetch_array($result);
        $k=0;
        $j=$contadorSemanas;
        $nombreEmpleado=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
        $arrayAux=array($nombreEmpleado);
        //echo $row["PrimerNombre"];
        while($k<$count){
          if($dataTurnos[$j]["idSemanal"]=="NE"){
            //print_r("NE-");
            $arrayAux=array_merge($arrayAux,array("NE", "NE", "NE","NE", "NE","NE", "NE"));
          //  print_r($arrayAux);
          }else{
            //obtener si trabajo
            $query2=sprintf("SELECT * FROM col_semanal where idSemanal='%s' and NumeroDocumento='%s' ",mysqli_real_escape_string($cnx,$dataTurnos[$contadorSemanas]["idSemanal"]),mysqli_real_escape_string($cnx,$row["NumeroDocumento"]));
            $result2=mysqli_query($cnx,$query2);
            $row2=mysqli_fetch_array($result2);
            //obtener horario
            $queryHT=sprintf("SELECT * FROM htrabajo where  NumeroDocumento='%s' ",mysqli_real_escape_string($cnx,$row["NumeroDocumento"]));
            $resultHT=mysqli_query($cnx,$queryHT);
            $rowHT=mysqli_fetch_array($resultHT);
            $Lunes=RevisarTiempo($row2["Lunes"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $Martes=RevisarTiempo($row2["Martes"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $Miercoles=RevisarTiempo($row2["Miercoles"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $Jueves=RevisarTiempo($row2["Jueves"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $Viernes=RevisarTiempo($row2["Viernes"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $Sabado=RevisarTiempo($row2["Sabado"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $Domingo=RevisarTiempo($row2["Domingo"],$rowHT["Desde"],$rowHT["Hasta"],$rowNT["H_Descanso"]);
            $arrayAux=array_merge($arrayAux,array( $Lunes, $Martes, $Miercoles, $Jueves, $Viernes, $Sabado,$Domingo));
            //print_r($arrayAux);
          }
          $j++;
          $k++;
        }
        //print_r($arrayAux);
        $dataT[$contadorF]=$arrayAux;
        $contadorF++;
      }
      $contadorSemanas=$contadorSemanas+$count;
      //$count tiene el numero de semanas
    }
    //print_r($dataT);

  }
}

$data = $dataT
//array_merge($info,["firstname" => "Mary", "lastname" => "Johnson", "age" => 25]);
?>
<?PHP

  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "website_data_" . date('Ymd') . ".xls";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  foreach($data as $row) {
    if(!$flag) {
      // display field/column names as first row
      //echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;

?>

<?php
function RevisarTiempo($valor,$HIni,$HFin,$Des){
  $HFin=new DateTime($HFin);
  $HIni=new DateTime($HIni);
  $Des=new DateTime($Des);
  $interval = $HFin->diff($HIni);
  $nvalor=$interval->format('%H:%I:%S');
  $NDate= new DateTime($nvalor);
  $intervalf = $NDate->diff($Des);
  $workduration = $intervalf->format('%H:%I:%S');
  $time_array = explode(':',$workduration);
  $hours = (int)$time_array[0];
  $minutes = (int)$time_array[1];
  $seconds = (int)$time_array[2];
  $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
  $average = floor($total_seconds/2);
  $hours = floor($average / 3600);
  $mins = floor($average / 60 % 60);
  $secs = floor($average % 60);
  $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
  if($valor==1){
    $valorN=(String)($workduration);
  }else if($valor==2){
    $valorN=(String)($timeFormat);
  }else{
    $valorN="D";
  }

return $valorN;

}
function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['Lunes'] = $dto->format('Y-m-d');
  $dto->modify('+1 days');
  $ret['Martes'] = $dto->format('Y-m-d');
  $dto->modify('+1 days');
  $ret['Miercoles'] = $dto->format('Y-m-d');
  $dto->modify('+1 days');
  $ret['Jueves'] = $dto->format('Y-m-d');
  $dto->modify('+1 days');
  $ret['Viernes'] = $dto->format('Y-m-d');
  $dto->modify('+1 days');
  $ret['Sabado'] = $dto->format('Y-m-d');
  $dto->modify('+1 days');
  $ret['Domingo'] = $dto->format('Y-m-d');
  return $ret;
}

 ?>

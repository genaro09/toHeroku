<?PHP
include '../php/funciones.php';
include '../php/verificar_sesion.php';
$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
$dataT= array();
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
    //Todas las fechas
    $DatesArray = array();
    $codToQuery="";
    for($m=0;$m<$count;$m++){
      $NWeek = $info[$m]["Semana"];
      $NYear=$info[$m]["Annio"];
      //to cod to query
        if($m<$count-1){
          $codToQuery=$codToQuery."(semanal.nSemana=".$NWeek." and semanal.anno=".$NYear." ) OR";
        }else{
          $codToQuery=$codToQuery."(semanal.nSemana=".$NWeek." and semanal.anno=".$NYear." )";
        }
      //fin
      $week_array = getStartAndEndDate($NWeek,$NYear);
      foreach($week_array as $key => $value){
          $DatesArray=array_merge($DatesArray,array($key.' '.$value));
      }
    }
    //FIN fechas
    //print_r($info[0]["Annio"]);
    $cnx=cnx();
    $dataT= array();
    $contT=0;
    //vamos a ordenar por turnos
    for($i=0;$i<sizeof($IDarray);$i++){
      $idTurno=$IDarray[$i];
      $queryEmpleados=sprintf("SELECT col_semanal.NumeroDocumento,empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido from semanal  INNER JOIN  col_semanal INNER JOIN empleado WHERE idTurno='%s' and ( ".$codToQuery." )  and semanal.idSemanal=col_semanal.idSemanal and col_semanal.NumeroDocumento=empleado.NumeroDocumento GROUP BY col_semanal.NumeroDocumento",mysqli_real_escape_string($cnx,$idTurno));
      $resultEmpleados=mysqli_query($cnx,$queryEmpleados);
      $nombresEmpArray = array();
      $idEmpleadosTurno = array();
      $k=0;
      $Turno=getInfoTurnor($idTurno);
      $dataT[$contT]=array("Turno: ".$Turno->getNombreturno());
      $contT++;
      $dataT[$contT]=array_merge(array('Empleados'),$DatesArray);
      $contT++;
      while($rowEmpleados=mysqli_fetch_array($resultEmpleados)){
        //Los usuarios del turno
        $idEmpleadosTurno[$k]=$rowEmpleados['NumeroDocumento'];
        $nombresEmpArray[$rowEmpleados['NumeroDocumento']]=$rowEmpleados['PrimerNombre']." ".$rowEmpleados['SegundoNombre']." ".$rowEmpleados['PrimerApellido']." ".$rowEmpleados['SegundoApellido'];
        $k++;
      }
      //de cada empleado
      for($k=0;$k<sizeof($idEmpleadosTurno);$k++){
        $NumeroDocumento=$idEmpleadosTurno[$k];
        $arrayAux = array();
        $arrayAux=array($nombresEmpArray[$NumeroDocumento]);
        for($j=0;$j<sizeof($info);$j++){
          //Obtenemos la semana y annio2
          $NWeek = $info[$j]["Semana"];
          $NYear=$info[$j]["Annio"];
          //aqui ya vamos a tener todas las fechas en todos los turnos

          $query2=sprintf("SELECT turno.idTurno,empleado.NumeroDocumento,turno.nombreTurno,htrabajo.Descanso,htrabajo.H_Descanso,htrabajo.Desde,htrabajo.Hasta,col_semanal.Lunes,col_semanal.Martes,col_semanal.Miercoles,col_semanal.Jueves,col_semanal.Viernes,col_semanal.Sabado,col_semanal.Domingo FROM turno INNER JOIN semanal INNER JOIN col_semanal INNER JOIN empleado INNER JOIN htrabajo WHERE turno.idTurno ='%s' AND semanal.nSemana='%s' AND semanal.anno='%s' AND turno.idTurno=semanal.idTurno AND semanal.idSemanal=col_semanal.idSemanal AND col_semanal.NumeroDocumento=empleado.NumeroDocumento AND empleado.NumeroDocumento=htrabajo.NumeroDocumento AND empleado.NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$idTurno),mysqli_real_escape_string($cnx,$NWeek),mysqli_real_escape_string($cnx,$NYear),mysqli_real_escape_string($cnx,$NumeroDocumento));

          $result2=mysqli_query($cnx,$query2);
          $row2=mysqli_fetch_array($result2);
          if($row2[0]!=""){
            //hay semanal
              if($row2["Descanso"]==0){
                $HDescanso="00:00:00";
              }else{
                $HDescanso=$row2["H_Descanso"];
              }
              $Lunes=RevisarTiempo($row2["Lunes"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $Martes=RevisarTiempo($row2["Martes"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $Miercoles=RevisarTiempo($row2["Miercoles"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $Jueves=RevisarTiempo($row2["Jueves"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $Viernes=RevisarTiempo($row2["Viernes"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $Sabado=RevisarTiempo($row2["Sabado"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $Domingo=RevisarTiempo($row2["Domingo"],$row2["Desde"],$row2["Hasta"],$HDescanso);
              $arrayAux=array_merge($arrayAux,array( $Lunes, $Martes, $Miercoles, $Jueves, $Viernes, $Sabado,$Domingo));
          }else{
            //No hay semanal :(
            $arrayAux=array_merge($arrayAux,array("NE", "NE", "NE","NE", "NE","NE", "NE"));
          }

        }
        $dataT[$contT]=$arrayAux;
        $contT++;
      }
      //Salto de linea
      $dataT[$contT]=array("");
      $contT++;
    }

  }
}
$data=array();
$data = $dataT;
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

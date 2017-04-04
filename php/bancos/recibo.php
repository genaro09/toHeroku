<?php
    include '../../php/funciones.php';
    header('Content-type: text/plain');
    header('Content-Disposition: attachment; filename="banco.txt"');
    $idPagos_Horas_Extras=$_POST["idPagos_Horas_Extras"];
    $cnx = cnx();
		$query=sprintf("SELECT * FROM col_pago_horas_extras  WHERE idPago_HorasExtras='%s'",mysqli_real_escape_string($cnx,$idPagos_Horas_Extras));
		$result=mysqli_query($cnx,$query);
		$totAPagar=0.00;
    $arrayName = array();
    $MAXName=0;
    $arrayNit = array();
    $MAXNit=0;
    $arrayNDocument = array();
    $MAXNDocument=0;
    $arrayMontoL = array();
    $MAXMontoL=0;
    $i=0;
		while ($row=mysqli_fetch_array($result)) {
			$totAPagar=$totAPagar+$row["MontoLiquido"];
			$empleado= getInfoEmpleado($row["NumeroDocumento"]);
			$Cargo= getInfoCargos($empleado->getIdcargos());
			$Departamento = getInfoDepartamentos($Cargo->getIddepartamento());
      //Valores
      $arrayName[$i] = $row["Nombre"];
      if(strlen($arrayName[$i])>$MAXName) $MAXName=strlen($arrayName[$i]);
      $arrayNit[$i] = $row["NIT"];
      if(strlen($arrayNit[$i])>$MAXNit) $MAXNit=strlen($arrayNit[$i]);
      $arrayNDocument[$i] = $row["NumeroDocumento"];
      if(strlen($arrayNDocument[$i])>$MAXNDocument) $MAXNDocument=strlen($arrayNDocument[$i]);
      $arrayMontoL[$i] = $row["MontoLiquido"];
      if(strlen($arrayMontoL[$i])>$MAXMontoL) $MAXMontoL=strlen($arrayMontoL[$i]);
      $i++;
		}
    for($j=0;$j<$i;$j++){
      echo " ".Tabular((string)$arrayName[$j],$MAXName)." ".Tabular((string)$arrayNit[$j],$MAXNit)." ".Tabular((string)$arrayNDocument[$j],$MAXNDocument)." $".Tabular((string)$arrayMontoL[$j],$MAXMontoL)."\n";
    }
		mysqli_close($cnx);

    function Tabular($string,$MAX){
      if(strlen($string)<$MAX){
        $NSPACE=$MAX-strlen($string);
        $string=$string.str_repeat(" ", $NSPACE);
      }
      return $string;
    }
?>

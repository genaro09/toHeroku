<?php
	include 'funciones.php';
	if(empty($_POST["NitEmpresa"])||empty($_POST["nombreTurno"])||empty($_POST["Desde"])||empty($_POST["Hasta"])||empty($_POST["Periodo_Pago"])||empty($_POST["MJornada"])){
		echo "1";
	}else{
		$NitEmpresa=$_POST["NitEmpresa"];
		$nombreTurno=$_POST["nombreTurno"];
		$Desde=$_POST["Desde"];
		$Hasta=$_POST["Hasta"];
		$Descanso=$_POST["Descanso"];
		$H_Descanso=$_POST["H_Descanso"];
		$Periodo_Pago=$_POST["Periodo_Pago"];
		$MJornada=$_POST["MJornada"];
		if(isEmpresaExist($NitEmpresa)){
			if($nombreTurno!=" " && ($Desde<$Hasta)){
				if($Descanso==0){
					if(!(($_POST["Periodo_Pago"]==10)||($_POST["Periodo_Pago"]==20)||($_POST["Periodo_Pago"]==30)||($_POST["Periodo_Pago"]==40))){
						echo "5";
					}
					$H_Descanso="";
					if(!(verify_time_format($Desde.":00")&&verify_time_format($Hasta.":00")&&verify_time_format($Desde.":00"))){
						echo "4";
					}elseif(agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso,$Periodo_Pago,$MJornada)){
						echo "2";
					}else{
						echo "3";
					}
				}else {
					if(!(($_POST["Periodo_Pago"]==10)||($_POST["Periodo_Pago"]==20)||($_POST["Periodo_Pago"]==30)||($_POST["Periodo_Pago"]==40))){
						echo "5";
					}
					if(!(verify_time_format($Desde.":00")&&verify_time_format($Hasta.":00")&&verify_time_format($Desde.":00"))){
						echo "4";
					}elseif(agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso,$Periodo_Pago,$MJornada)){
						echo "2";
					}else{
						echo "3";
					}
				}
			}else{
				echo "1";
			}
		}else{
			echo "0";
		}
	}

?>

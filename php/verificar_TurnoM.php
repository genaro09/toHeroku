<?php
	include 'funciones.php';
	$idTurno=$_POST["idTurno"];
	$nombreTurno=$_POST["nombreTurno"];
	$Desde=$_POST["Desde"];
	$Hasta=$_POST["Hasta"];
	$Descanso=$_POST["Descanso"];
	$H_Descanso=$_POST["H_Descanso"];
	$Periodo_Pago=$_POST["Periodo_Pago"];
	if(!(($_POST["Periodo_Pago"]==10)||($_POST["Periodo_Pago"]==20)||($_POST["Periodo_Pago"]==30)||($_POST["Periodo_Pago"]==40))){
		echo "5";
	}
	if(isTurnoExist($idTurno)){
		if($nombreTurno!=" " && ($Desde<$Hasta)){
			if($Descanso==0){
				$H_Descanso="";
				if(actualizarTurno($idTurno,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso,$Periodo_Pago)){
					echo "2";
				}else{
					echo "3";
				}
			}else {
				if(actualizarTurno($idTurno,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso,$Periodo_Pago)){
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
?>

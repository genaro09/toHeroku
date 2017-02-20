<?php
	include 'funciones.php';
	$NitEmpresa=$_POST["NitEmpresa"];
	$nombreTurno=$_POST["nombreTurno"];
	$Desde=$_POST["Desde"];
	$Hasta=$_POST["Hasta"];
	$Descanso=$_POST["Descanso"];
	$H_Descanso=$_POST["H_Descanso"];
	if(isEmpresaExist($NitEmpresa)){
		if($nombreTurno!=" " && ($Desde<$Hasta)){
			if($Descanso==0){
				$H_Descanso="";
				if(agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso)){
					echo "2";
				}else{
					echo "3";
				}
			}else {
				if(agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso)){
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

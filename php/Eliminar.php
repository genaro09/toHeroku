<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';

	$opc=$_POST["opc"];
	switch ($opc) {
		case "1":
      $result=eliminarTurno($_POST["idTurno"]);
			if($result==1){
				echo "2";
			}elseif($result==2){
				echo "0";
			}else{
        echo "1";
			}
		break;
		case "2":
      $result=eliminarDepartamento($_POST["idDepartamento"],$_POST["NitEmpresa"]);
			if($result==1){
				echo "1";
			}elseif($result==2){
				echo "2";
			}else{
        echo "0";
			}
		break;
		default:
			# code...
			echo "nada";
		break;
	}

?>

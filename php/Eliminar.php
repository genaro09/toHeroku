<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';

	$opc=$_POST["opc"];
	switch ($opc) {
		case "1":
			//ya existe ese correo
      $result=eliminarTurno($_POST["idTurno"]);
			if($result==1){
				echo "2";
			}elseif($result==2){
				echo "0";
			}else{
        echo "1";
			}
			break;
		  default:
			# code...
			echo "nada";
			break;
	}

?>

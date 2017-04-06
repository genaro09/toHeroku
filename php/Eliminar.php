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
		case "3":
      $result=eliminarCargos($_POST["idCargos"],$_POST["NitEmpresa"]);
			if($result==1){
				echo "1";
			}elseif($result==2){
				echo "2";
			}else{
        echo "0";
			}
		break;
		case "4":
      $result=eliminarHoras_extras($_POST["id"]);
			if($result==1){
				echo "1";
			}else{
        echo "0";
			}
		break;
		case '5':
			# code...
			if(!isIncapExist($_POST["idIncapacidad"])){
				echo "3";
			}else{
				$result=eliminarIncapacidad($_POST["idIncapacidad"]);
				if($result==1){
					echo "1";
				}else{
	        echo "0";
				}
			}
			break;
			case '6':
				# code...
				if(!isAusenExist($_POST["idAusencia"])){
					echo "3";
				}else{
					$result=eliminarAusencia($_POST["idAusencia"]);
					if($result==1){
						echo "1";
					}else{
						echo "0";
					}
				}
				break;
		case '7':
				# code...
				if(!isPermisoExist($_POST["idPermiso"])){
					echo "3";
				}else{
					$result=eliminarPermisos($_POST["idPermiso"]);
					if($result==1){
						echo "1";
					}else{
						echo "0";
					}
				}
			break;
			case "8":
	      $result=eliminarLlegadasTarde($_POST["id"]);
				if($result){
					echo "1";
				}else{
	        echo "0";
				}
			break;
			case "9":
	      $result=eliminarSuspension($_POST["id"]);
				if($result){
					echo "1";
				}else{
	        echo "0";
				}
			break;
	case '10':
					# code...
					if(!isPermisoSeccionalExist($_POST["idPermisoSeccional"])){
						echo "3";
					}else{
						$result=eliminarPermisosSeccional($_POST["idPermisoSeccional"]);
						if($result==1){
							echo "1";
						}else{
							echo "0";
						}
					}
				break;
		default:
			# code...
			echo "nada";
		break;
	}

?>

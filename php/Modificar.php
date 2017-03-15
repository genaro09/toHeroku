<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';

	$opc=$_POST["opc"];
	switch ($opc) {
		case "1":
      if(empty($_POST["NombreDepartamento"])||empty($_POST["CuentaContable"])||empty($_POST["idSalario_Minimo"])){
        echo "0";
      }elseif(checkNombreDepartamentoToModf($_POST["NombreDepartamento"],$_POST["NitEmpresa"],$_POST["idDepartamento"])){
        echo "1";
      }elseif(strcmp($_POST["idCod_Municipio"],"0")==0){
        echo "4";
      }else{
        $estado=UpdateDepartamento($_POST["NombreDepartamento"],$_POST["CuentaContable"],$_POST["idSalario_Minimo"],$_POST["idDepartamento"],$_POST["idCod_Municipio"]);
        if($estado){
          echo "2";
        }else echo "3";
      }
		break;
		case "2":
			if(empty($_POST["NombreCargo"])){
				echo "0";
			}elseif(checkNombreCargos($_POST["NombreCargo"],$_POST["idDepartamento"],$_POST["idCargos"])){
				echo "1";
			}else{
				$estado=UpdateCargos($_POST["NombreCargo"],$_POST["Descripcion"],$_POST["idDepartamento"],$_POST["PEmpleado"],$_POST["PPlanilla"],$_POST["idCargos"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		case "3":
			if(empty($_POST["NombreEmpresa"])||empty($_POST["Direccion"])||empty($_POST["Telefono"])||empty($_POST["RepresentanteLegal"])){
				echo "0";
			}elseif(checkNombreEmpresa($_POST["NombreEmpresa"])){
				echo "1";
			}else{
				$estado=UpdateEmpresa($_POST["NombreEmpresa"],$_POST["Direccion"],$_POST["Telefono"],$_POST["Telefono2"],$_POST["NRegistro"],$_POST["Giro"],$_POST["NPatronalSS"],$_POST["NPatronalAFP"],$_POST["RepresentanteLegal"],$_POST["NitEmpresa"],$_POST["TipeRequest"],$_POST["TipoEmpresa"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		default:
			# code...
			echo "nada";
	  break;
	}

?>

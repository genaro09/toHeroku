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
      }else{
        $estado=UpdateDepartamento($_POST["NombreDepartamento"],$_POST["CuentaContable"],$_POST["idSalario_Minimo"],$_POST["idDepartamento"]);
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

<?php
	function get_Departamentos($Idcargos){
		$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
		$cnx=cnx();
	 	$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
	 	$query2=sprintf("SELECT * FROM cargos where idCargos='%s'",mysqli_real_escape_string($cnx,$Idcargos));
	 	$result=mysqli_query($cnx,$query);
	 	$result2=mysqli_query($cnx,$query2);
	 	$row2=mysqli_fetch_array($result2);
		while ($row=mysqli_fetch_array($result)) {
			if($row2["idDepartamento"]==$row["idDepartamento"]){
				echo "<option selected value='".$row["idDepartamento"]."'>".$row["NombreDepartamento"]."</option>";
			}else
			echo "<option value='".$row["idDepartamento"]."'>".$row["NombreDepartamento"]."</option>";

		}
		mysqli_close($cnx);
	}

	function get_ALLDepartamentos($NitEmpresa){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			echo "<option value='".$row["idDepartamento"]."'>".$row["NombreDepartamento"]."</option>";
		}
		mysqli_close($cnx);
	}

function get_Cargos($idCargo){
	$cnx=cnx();
	$query=sprintf("SELECT * FROM cargos where idCargos='%s'",mysqli_real_escape_string($cnx,$idCargo));
 	$result=mysqli_query($cnx,$query);
 	$row=mysqli_fetch_array($result);
 	$idDepartamento=$row["idDepartamento"];

	$query2=sprintf("SELECT * FROM cargos where idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
 	$result2=mysqli_query($cnx,$query2);
 		while ($rowAux=mysqli_fetch_array($result2)){
 			if($idCargo==$rowAux["idCargos"]){
 				echo "<option selected value='".$rowAux["idCargos"]."'>".$rowAux["NombreCargo"]."</option>";
 			}else
			echo "<option value='".$rowAux["idCargos"]."'>".$rowAux["NombreCargo"]."</option>";

		}
 mysqli_close($cnx);

}
?>

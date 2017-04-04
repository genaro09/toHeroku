<?php
 	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
		$idDepartamento=$row["idDepartamento"];
		$query2=sprintf("SELECT * FROM cargos where idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
 		$result2=mysqli_query($cnx,$query2);
		while ($row2=mysqli_fetch_array($result2)) {
			$idCargos=$row2["idCargos"];
			$query3=sprintf("SELECT * FROM empleado where idCargos='%s'",mysqli_real_escape_string($cnx,$idCargos));
			$result3=mysqli_query($cnx,$query3);
			while ($row3=mysqli_fetch_array($result3)) {
        if($row3["Activo"]==1){
          $activo="Activo";
        }else $activo="Inactivo";
          $salarioNominal=number_format($row3["SalarioNominal"], 2, '.', '');
				 echo "<tr>
						<td>".$row3["NumeroDocumento"]."</td>
						<td>".$row3["PrimerNombre"]." ".$row3["SegundoNombre"]." ".$row3["PrimerApellido"]." ".$row3["SegundoApellido"]."</td>
						<td>".number_format((float)$salarioNominal, 2, '.', '')."</td>
						<td>".$activo."</td>
						<td>".$row["NombreDepartamento"]."</td>
						<td class='text-right'>
							<form method='post' action='Perfil_Empleado.php'>
							<input type='hidden' name='numDoc' value='".$row3["NumeroDocumento"]."'>
							<input type='hidden' name='idcargo' value='".$row2["idCargos"]."'>
							<input type='hidden' name='iddepartamento' value='".$row["idDepartamento"]."'>
							<input type='submit' style='background: url(../img/icons/setting.png);border: 0;margin-right:15px;' value='   '>
							</form>
						</td>
					</tr>";
			}
		}
	}
	mysqli_close($cnx);
?>

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
			$query3=sprintf("SELECT * FROM empleado where Activo=1 and idCargos='%s'",mysqli_real_escape_string($cnx,$idCargos));
			$result3=mysqli_query($cnx,$query3);
			while ($row3=mysqli_fetch_array($result3)) {
				 echo "<tr>
						<td>".$row3["NumeroDocumento"]."</td>
						<td>".$row3["PrimerNombre"]." ".$row3["PrimerApellido"]."</td>
						<td>".$row3["SalarioNominal"]."</td>
						<td>".$row3["Activo"]."</td>
						<td>".$row["NombreDepartamento"]."</td>
						<td class='text-right'>
              <div class='row'>
                <div class='col-md-4'>
    							<form target='_blank' method='post' action='Prestacion_Laboral_Empleado.php'>
      							<input type='hidden' name='numDoc' value='".$row3["NumeroDocumento"]."'>
      							<input type='hidden' name='idcargo' value='".$row2["idCargos"]."'>
      							<input type='hidden' name='iddepartamento' value='".$row["idDepartamento"]."'>
      							<input type='submit' style='background: url(../img/icons/note.png);border: 0;' value='   '>
      					  </form>
                  </div>
                  <div class='col-md-4'>
                  <form method='post' action='Historial_Prestacion_Laboral_Empleado.php'>
      							<input type='hidden' name='numDoc' value='".$row3["NumeroDocumento"]."'>
      							<input type='hidden' name='idcargo' value='".$row2["idCargos"]."'>
      							<input type='hidden' name='iddepartamento' value='".$row["idDepartamento"]."'>
      							<input type='submit' style='background: url(../img/icons/assignment.png);border: 0;' value='   '>
      					  </form>
                  </div>
                </div>
						</td>
					</tr>";
			}
		}
	}
	mysqli_close($cnx);
?>

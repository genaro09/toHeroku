<?php
 	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    $query2=sprintf("SELECT * FROM salarios_minimos where idSalario_Minimo	='%s'",mysqli_real_escape_string($cnx,$row["idSalario_Minimo"]));
    $result2=mysqli_query($cnx,$query2);
    $row2=mysqli_fetch_array($result2);
				 echo "<tr>
						<td>".$row["NombreDepartamento"]."</td>
						<td>".$row["CuentaContable"]."</td>
						<td>".$row2["NombreRubro"]."</td>
						<td class='text-right'>
							<form method='post' action='Perfil_Departamento.php'>
							<input type='hidden' name='idDepartamento' value='".$row["idDepartamento"]."'>
							<input type='submit' style='background: url(../img/icons/setting.png);border: 0;margin-right:15px;' value='   '>
							</form>
						</td>
					</tr>";
	}
	mysqli_close($cnx);
?>

<?php
 	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT * FROM turno where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
		if($row["Descanso"]==0){
			$descansoV="NO";
			$Hdescanso=" ";
		}else{
			$Hdescanso=$row["H_Descanso"];
			$descansoV="SI";
		} 
				 echo "<tr>
						<td>".$row["nombreTurno"]."</td>
						<td>".$row["Desde"]."</td>
						<td>".$row["Hasta"]."</td>
						<td>".$descansoV."</td>
						<td>".$Hdescanso."</td>
						<td class='text-right'>
							<form method='post' action='Perfil_Turno.php'>
							<input type='hidden' name='idTurno' value='".$row["idTurno"]."'>
							<input type='submit' style='background: url(../img/icons/setting.png);border: 0;margin-right:15px;' value='   '>
							</form>
						</td>
					</tr>";
	}
	mysqli_close($cnx);
?>
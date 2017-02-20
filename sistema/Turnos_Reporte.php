<?php
	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT * FROM turno where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
		$query2=sprintf("SELECT * FROM htrabajo where idTurno='%s'",mysqli_real_escape_string($cnx,$row["idTurno"]));
 		$result2=mysqli_query($cnx,$query2);
		$row2=mysqli_fetch_array($result2);
			if($row2[0]!=""){
				echo "
					<div class='checkbox'>
						<label>
						<input id='".$row["idTurno"]."' value='".$row["idTurno"]."' name='checkboxvar[]' type='checkbox' name='optionsCheckboxes'>
						<font color='black'>
						".$row["nombreTurno"]."
						</font>
						</label>
					</div>
				";
			}
	}
?>

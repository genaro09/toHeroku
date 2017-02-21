<?php
function get_SelectTurno($NitEmpresa,$Idturno){
	# code...
	$cnx=cnx();
 	$query=sprintf("SELECT * FROM turno where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
 	$Flag=0;
	while ($row=mysqli_fetch_array($result)) {
		if($row["idTurno"]==$Idturno){
			$Flag=1;
			echo "<option selected value='".$row["idTurno"]."' >".$row["nombreTurno"]."</option>";
		}else{
			echo "<option value='".$row["idTurno"]."' >".$row["nombreTurno"]."</option>";
		}
	}
	if($Flag==0){
		echo "<option selected >Ingrese un Turno</option>";
	}
	mysqli_close($cnx);
}
function get_SelectAllTurnos($NitEmpresa){
	# code...
	$cnx=cnx();
 	$query=sprintf("SELECT * FROM turno where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	$flag=0;
	while ($row=mysqli_fetch_array($result)) {
			$Flag=1;
			echo "<option value='".$row["idTurno"]."' >".$row["nombreTurno"]."</option>";
	}
	if($Flag==0){
		echo "<option value='0' selected >Primero Ingrese un Turno</option>";
	}
	mysqli_close($cnx);
}
function get_SelectTurnoP($NitEmpresa){
	# code...
	$cnx=cnx();
 	$query=sprintf("SELECT * FROM turno where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
			echo "<option value='".$row["idTurno"]."' >".$row["nombreTurno"]."</option>";
	}
	mysqli_close($cnx);
}



?>

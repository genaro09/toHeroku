<?php
include '../php/funciones.php';

if($_POST['id']){
 $id=$_POST['id'];
  
 $cnx=cnx();
 $query=sprintf("SELECT * FROM cargos where idDepartamento='%s'",mysqli_real_escape_string($cnx,$id));
 $result=mysqli_query($cnx,$query);
 		while ($row=mysqli_fetch_array($result)) {
			echo "<option value='".$row["idCargos"]."'>".$row["NombreCargo"]."</option>";

		}
 mysqli_close($cnx);
}

?>
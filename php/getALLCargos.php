<?php

  include '../php/funciones.php';
  $cnx=cnx();
  $idDepartamento=$_POST["id"];
  $query=sprintf("SELECT * FROM cargos where 	idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
  $result=mysqli_query($cnx,$query);
    while ($row=mysqli_fetch_array($result)){
      echo "<option value='".$row["idCargos"]."'>".$row["NombreCargo"]."</option>";

    }
  mysqli_close($cnx);

 ?>

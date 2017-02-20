<?php

if(isset($_POST['id'])&&$_POST['id']!=0){
 $id=$_POST['id'];
 include_once '../php/funciones.php';
 $cnx=cnx();
 $query=sprintf("SELECT * FROM cod_municipio where idCod_Departamento='%s'",mysqli_real_escape_string($cnx,$id));
 $result=mysqli_query($cnx,$query);
 		while ($row=mysqli_fetch_array($result)) {
			echo "<option value='".$row["idCod_Municipio"]."'>".$row["Nombre_Municipio"]."</option>";

		}
 mysqli_close($cnx);
}else{
  echo "<option  value='0'>NINGUNO</option>";
}


function get_Cod_M($departamento){
  if($departamento==0||$departamento==null){
      echo "<option selected value='0'>NINGUNO</option>";
  }else{
    $cnx = cnx();
    $query1=sprintf("SELECT * FROM cod_municipio where idCod_Municipio='%s'",mysqli_real_escape_string($cnx,$departamento));
    $result1=mysqli_query($cnx,$query1);
    $row1=mysqli_fetch_array($result1);
    $query=sprintf("SELECT * FROM cod_municipio where idCod_Departamento='%s'",mysqli_real_escape_string($cnx,$row1["idCod_Departamento"]));
    $result=mysqli_query($cnx,$query);
    while ($row=mysqli_fetch_array($result)) {
      if($row["idCod_Municipio"]==$departamento){
        echo "<option selected value='".$row["idCod_Municipio"]."'>".$row["Nombre_Municipio"]."</option>";
      }else
      echo "<option value='".$row["idCod_Municipio"]."'>".$row["Nombre_Municipio"]."</option>";
    }
    mysqli_close($cnx);
}
}

?>

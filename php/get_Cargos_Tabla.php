<?php
 	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    $query2=sprintf("SELECT * FROM cargos where idDepartamento	='%s'",mysqli_real_escape_string($cnx,$row["idDepartamento"]));
    $result2=mysqli_query($cnx,$query2);
    while ($row2=mysqli_fetch_array($result2)) {
      if($row2["PEmpleado"]){
        $PEmpleado="SI";
      }else   $PEmpleado="NO";
      if($row2["PPlanilla"]){
        $PPlanilla="SI";
      }else   $PPlanilla="NO";
      echo "<tr>
         <td>".$row["NombreDepartamento"]."</td>
         <td>".$row2["NombreCargo"]."</td>
         <td>".$PEmpleado."</td>
         <td>".$PPlanilla."</td>
         <td class='text-right'>
           <form method='post' action='Perfil_Cargo.php'>
           <input type='hidden' name='idCargos' value='".$row2["idCargos"]."'>
           <input type='submit' style='background: url(../img/icons/setting.png);border: 0;margin-right:15px;' value='   '>
           </form>
         </td>
       </tr>";


    }
	}
	mysqli_close($cnx);
?>

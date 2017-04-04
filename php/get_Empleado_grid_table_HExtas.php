<?php
 	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado INNER JOIN cargos INNER JOIN departamento INNER JOIN empresa WHERE empresa.NitEmpresa=departamento.NitEmpresa AND departamento.idDepartamento= cargos.idDepartamento AND cargos.idCargos=empleado.idCargos and empleado.Activo=1 and empresa.NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto="".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      echo "<tr>
         <td>".$row["NumeroDocumento"]."</td>
         <td>".$NombreCompleto."</td>
         <td class='text-right'>
           <a href='#' id='".$row["NumeroDocumento"]."' name='".$NombreCompleto."' class='addScnt'>
            Agregar
           </a>
         </td>
       </tr>";

	}
	mysqli_close($cnx);
?>

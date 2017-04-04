<?php
 	$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
 	$cnx=cnx();
 	$query=sprintf("SELECT empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado INNER JOIN cargos INNER JOIN departamento INNER JOIN empresa WHERE empresa.NitEmpresa=departamento.NitEmpresa AND departamento.idDepartamento= cargos.idDepartamento AND cargos.idCargos=empleado.idCargos and empresa.NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto="".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      echo "<tr>
         <td>".$row["NumeroDocumento"]."</td>
         <td>".$NombreCompleto."</td>
         <td class='text-right'>
           <div class='col-md-12'>
             <form method='post' action='Reporte_Horas_Extras_Empleados.php'>
               <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
               <input type='submit' style='background: url(../img/icons/assignment.png);border: 0;' value='   '>
             </form>
           </div>
         </td>
       </tr>";

	}
	mysqli_close($cnx);
?>

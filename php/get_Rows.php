<?php
function get_Row_Perfil_Turno($idTurno){
  $cnx=cnx();
  $query=sprintf("SELECT empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado INNER JOIN htrabajo WHERE  empleado.NumeroDocumento=htrabajo.NumeroDocumento and  htrabajo.idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto="".$row["PrimerNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      echo "<tr>
         <td>".$row["NumeroDocumento"]."</td>
         <td>".$NombreCompleto."</td>

       </tr>";

  }
  mysqli_close($cnx);
}
function get_Row_Fecha_Reporte_Semana($NitEmpresa){
 	$cnx=cnx();
 	$query=sprintf("select horas_extras.Fecha from horas_extras WHERE NitEmpresa='%s' GROUP BY Fecha ORDER BY Fecha DESC",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
      echo "<tr>
         <td>".$row["Fecha"]."</td>
         <td class='text-right'>
           <div class='col-md-12'>
             <form method='post' action='#'>
               <input type='hidden' name='Fecha' value='".$row["Fecha"]."'>
               <input type='submit' style='background: url(../img/icons/pdf.png);border: 0;' value='   '>
             </form>
           </div>
         </td>
       </tr>";

	}
	mysqli_close($cnx);

}

function get_Row_Empleado_Reporte_Semana($NumeroDocumento){
  $cnx=cnx();
 	$query=sprintf("SELECT horas_extras.*,POR.PrimerNombre,POR.PrimerApellido,POR.SegundoApellido FROM horas_extras INNER JOIN empleado POR WHERE  horas_extras.NumeroDocumentoPor=POR.NumeroDocumento and horas_extras.NumeroDocumentoPara='%s' ORDER BY Fecha DESC",mysqli_real_escape_string($cnx,$NumeroDocumento));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    //CUIDADO CON LA BASE DE HORAS EXTRAS
      $POR=$row["PrimerNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      echo "<tr>
           <td>".$POR."</td>
           <td>".$row["NHorasDiurnas"]."</td>
           <td>".$row["NHorasNocturnas"]."</td>
           <td>".$row["Desde"]."</td>
           <td>".$row["Hasta"]."</td>
           <td>".$row["Fecha"]."</td>
           <td class='text-right'>
             <div class='col-md-12'>
                <button id='".$row["IdHorasExtras"]."' style='background: url(../img/icons/delete.png);border: 0;' onClick='imprimirHE(this.id)'>M</button>
             </div>
           </td>
       </tr>";

	}
	mysqli_close($cnx);


}



 ?>

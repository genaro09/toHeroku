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
 	$query=sprintf("select * from horas_extras WHERE NitEmpresa='%s' GROUP BY Fecha ORDER BY Fecha ASC",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
      $str="";
      $actSN=0;
      if($row["EstadoHorasExternas"]==1){
        $actSN=1;
        $str=$str."<input type='submit' style='background: url(../img/icons/checked.png);border: 0;' value='   '>";
      }else{
        $actSN=0;
        $str=$str."<input type='submit' style='background: url(../img/icons/warning.png);border: 0;' value='   '>";
      }
      echo "<tr>
         <td>".$row["Fecha"]."</td>
         <td><input type='hidden' value'".$actSN."'>
           <div class='col-md-12'>
             <form target='_blank' method='post' action='Comprobacion_Horas_Extras.php'>
               <span style='color:white;opacity: 0.2;' id='idHorasExtras' name='idHorasExtras'>".$row["EstadoHorasExternas"]."</span>
               ".$str."
             </form>
           </div>
         </td>
         <td class='text-right'>
           <div class='col-md-12'>
             <form target='_blank' method='post' action='PDF_Horas_Extras.php'>
               <input type='hidden' name='idHorasExtras' value='".$row["idHorasExtras"]."'>
               <input type='submit' style='background: url(../img/icons/pdf.png);border: 0;' value='   '>
             </form>
           </div>
         </td>
       </tr>";

	}
	mysqli_close($cnx);

}
function get_Row_Comprobacion_Horas_Extras($idHorasExtras){
  $cnx=cnx();
  $query=sprintf("SELECT col_horas_extras.*, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM col_horas_extras INNER JOIN horas_extras INNER JOIN empleado WHERE horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND col_horas_extras.NumeroDocumentoPara=empleado.NumeroDocumento AND horas_extras.idHorasExtras='%s' ORDER BY col_horas_extras.Desde ASC, col_horas_extras.Hasta ASC",mysqli_real_escape_string($cnx,$idHorasExtras));
 	$result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto=$row["PrimerNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
    echo '<tr>
            <td><span style="font-size:12px;">'.$NombreCompleto.'</span>
            </td>
            <td>
              '.$row["NHorasDiurnas"].'
            </td>
            <td>
              '.$row["NHorasNocturnas"].'
            </td>
            <td>
              '.$row["Desde"].'
            </td>
            <td>
              '.$row["Hasta"].'
            </td>
          </tr>';
  }

}
function get_Row_Empleado_Reporte_Semana($NumeroDocumento){
  $cnx=cnx();
 	$query=sprintf("SELECT col_horas_extras.*,horas_extras.EstadoHorasExternas,horas_extras.Fecha,POR.PrimerNombre,POR.PrimerApellido,POR.SegundoApellido FROM col_horas_extras INNER JOIN horas_extras INNER JOIN empleado POR WHERE horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND col_horas_extras.NumeroDocumentoPor=POR.NumeroDocumento and  col_horas_extras.NumeroDocumentoPara='%s' ORDER BY horas_extras.Fecha DESC",mysqli_real_escape_string($cnx,$NumeroDocumento));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    //CUIDADO CON LA BASE DE HORAS EXTRAS
      $POR=$row["PrimerNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      if($row["EstadoHorasExternas"]==0){
        $strAux="
          <div class='col-md-12'>
             <button id='".$row['IdColHorasExtras']."' style='background: url(../img/icons/delete.png);border: 0;' onClick='imprimirHE(this.id)'>M</button>
          </div>";
      }else{
        $strAux="";
      }

      echo "<tr>
           <td>".$POR."</td>
           <td>".$row["NHorasDiurnas"]."</td>
           <td>".$row["NHorasNocturnas"]."</td>
           <td>".$row["Desde"]."</td>
           <td>".$row["Hasta"]."</td>
           <td>".$row["Fecha"]."</td>
           <td class='text-right'>
             ".$strAux."
           </td>
       </tr>";

	}
	mysqli_close($cnx);


}



 ?>

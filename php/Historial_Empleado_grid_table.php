<?php

function disp_historial_grid_table($NumeroDocumento){
  $cnx=cnx();
  $query=sprintf("SELECT * FROM recibo where NumeroDocumento_Para='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $query2=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$row["NumeroDocumento_Por"]));
    $result2=mysqli_query($cnx,$query2);
    $row2=mysqli_fetch_array($result2);
    //Fechas de los pagos
    $queryPE=sprintf("SELECT * FROM pagos_empleados INNER JOIN recibo WHERE pagos_empleados.idRecibo=recibo.idRecibo and recibo.idRecibo='%s'",mysqli_real_escape_string($cnx,$row["idRecibo"]));
    $resultPE=mysqli_query($cnx,$queryPE);
    $datos=array();
      while ($rowPE=mysqli_fetch_array($resultPE)) {
        $datosAux=array($rowPE["Tipo_Pago"],$rowPE["Desde"],$rowPE["Hasta"]);
        $datos=array_merge($datos,$datosAux);
      }
    //Fin
    echo "<tr>
       <td>".$row["Fecha_Generado"]."</td>
       <td>".$row2["PrimerNombre"]." ".$row2["PrimerApellido"]."</td>
       <td class='text-right'>
         <div class='row'>
           <div class='col-md-4'>
           <input type='submit'onclick='myFunction(".json_encode($datos).")' style='background: url(../img/icons/info.png);border: 0;' value='   '>
           </div>
           <div class='col-md-4'>
             <form method='post' action='PDF_Prestacion_Laboral_Empleado.php'>
               <input type='hidden' name='idRecibo' value='".$row["idRecibo"]."'>
               <input type='submit' style='background: url(../img/icons/pdf.png);border: 0;' value='   '>
             </form>
          </div>
        </div>
       </td>
     </tr>";

  }
	mysqli_close($cnx);
}

 ?>
 <script>
function myFunction(datos) {
  var index = 0
  str="";
    while (index < datos.length) {
    // Iterate over numeric indexes from 0 to 5, as everyone expects.
      var TipoDAto=datos[index];
      if(TipoDAto==1){
        str=str+" Vacacion desde: "+datos[index+1]+" - "+datos[index+2];
      }
      if(TipoDAto==2){
        str=str+" Indemnizacion desde: "+datos[index+1]+" - "+datos[index+2];
      }
      if(TipoDAto==3){
        str=str+" Aguinaldo desde: "+datos[index+1]+" - "+datos[index+2];
      }
      if(TipoDAto==4){
        str=str+" Salario desde: "+datos[index+1]+" - "+datos[index+2];
      }
      if(TipoDAto==5){
        str=str+" Retiro Voluntario desde: "+datos[index+1]+" - "+datos[index+2];
      }
      index=index+3;
  }
    alert(str);
}
</script>

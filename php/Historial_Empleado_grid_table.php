<?php

function disp_historial_grid_table($NumeroDocumento){
  $cnx=cnx();
  $query=sprintf("SELECT * FROM recibo where NumeroDocumento_Para='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $query2=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$row["NumeroDocumento_Por"]));
    $result2=mysqli_query($cnx,$query2);
    $row2=mysqli_fetch_array($result2);
    $datos="".$row["Vacacion"].",".$row["Indemnizacion"].",".$row["Aguinaldo"].",".$row["Salario"].",".$row["Retiro_Voluntario"];
    echo "<tr>
       <td>".$row["Fecha_Generado"]."</td>
       <td>".$row2["PrimerNombre"]." ".$row2["PrimerApellido"]."</td>
       <td class='text-right'>
         <div class='row'>
           <div class='col-md-4'>
           <input type='submit'onclick='myFunction(".$datos.")' style='background: url(../img/icons/info.png);border: 0;' value='   '>
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
function myFunction(Vacacion,Indemnizacion,Aguinaldo,Salario,Retiro_Voluntario) {
    var str="";
    if(Vacacion==1){
      str=str+" Vacacion desde";
    }
    if(Indemnizacion==1){
      str=str+" Indemnizacion desde";
    }
    if(Aguinaldo==1){
      str=str+" Aguinaldo desde";
    }
    if(Salario==1){
      str=str+" Salario desde";
    }
    if(Retiro_Voluntario==1){
      str=str+" Retiro Voluntario desde";
    }
    alert(str);
}
</script>

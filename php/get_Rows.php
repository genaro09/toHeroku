<?php
function get_Row_Perfil_Departamento($idDepartamento){
  $cnx=cnx();
  $query=sprintf("SELECT cargos.* FROM cargos INNER JOIN departamento WHERE cargos.idDepartamento=departamento.idDepartamento AND departamento.idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
      echo "<tr>
         <td>".$row["NombreCargo"]."</td>
       </tr>";
  }
  mysqli_close($cnx);
}
function get_Row_Perfil_Cargos($idCargo){
  $cnx=cnx();
  $cargos=getInfoCargos($idCargo);
  $query=sprintf("SELECT empleado.idCargos,empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado WHERE empleado.idCargos='%s'",mysqli_real_escape_string($cnx,$idCargo));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto="".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      echo "<tr>
         <td>".$row["NumeroDocumento"]."</td>
         <td>".$NombreCompleto."</td>
         <td class='text-right'>
           <form method='post' action='Perfil_Empleado.php'>
           <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
           <input type='hidden' name='idcargo' value='".$idCargo."'>
           <input type='hidden' name='iddepartamento' value='".$cargos->getIddepartamento()."'>
           <button name='' id=''  style='background: transparent;border: none;'>
            <div class='icon'>
                 <i class='material-icons'>settings</i>
            </div>
           </button>
           </form>
         </td>
       </tr>";

  }
  mysqli_close($cnx);
}
function get_Row_Perfil_Turno($idTurno){
  $cnx=cnx();
  $query=sprintf("SELECT empleado.idCargos,empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado INNER JOIN htrabajo WHERE  empleado.NumeroDocumento=htrabajo.NumeroDocumento and  htrabajo.idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto="".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
    $query2=sprintf("SELECT cargos.idDepartamento FROM cargos WHERE cargos.idCargos='%s'",mysqli_real_escape_string($cnx,$row["idCargos"]));
    $result2=mysqli_query($cnx,$query2);
    $row2=mysqli_fetch_array($result2);
      echo "<tr>
         <td>".$row["NumeroDocumento"]."</td>
         <td>".$NombreCompleto."</td>
         <td class='text-right'>
           <form method='post' action='Perfil_Empleado.php'>
           <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
           <input type='hidden' name='idcargo' value='".$row["idCargos"]."'>
           <input type='hidden' name='iddepartamento' value='".$row2["idDepartamento"]."'>
           <button name='' id=''  style='background: transparent;border: none;'>
            <div class='icon'>
                 <i class='material-icons'>settings</i>
            </div>
           </button>
           </form>
         </td>
       </tr>";

  }
  mysqli_close($cnx);
}
function get_Row_Empleados_incapacidad(){
  $NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
  $cnx=cnx();
  $query=sprintf("SELECT empleado.* from empleado INNER JOIN cargos INNER JOIN departamento inner JOIN empresa WHERE empresa.NitEmpresa='%s' AND departamento.NitEmpresa=empresa.NitEmpresa and cargos.idDepartamento=departamento.idDepartamento and empleado.idCargos=cargos.idCargos and empleado.Activo='1'",mysqli_real_escape_string($cnx,$NitEmpresa));
  $result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
         echo "
         <tr data-id='".$row['NumeroDocumento']."'>
            <td>".$row["NumeroDocumento"]."</td>
            <td>".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]."</td>
            <td>".number_format((float)$row["SalarioNominal"], 2, '.', '')."</td>
            <td class='text-right'>
              <div class='row'>
                <div class='col-md-12' style='margin-top:5px;'>
                  <div class='col-md-4'>
                      <input type='hidden' class='NumeroDocumento' id='numDoc' name='numDoc' value='".$row["NumeroDocumento"]."'>
                      <input type='button' class='btn btn-primary btn-sm' id='btnIncapacidad' name='btnIncapacidad' value='Incapacidad' style='width:100%;overflow:hidden;font-size: 75%;margin-top:0px;height:100%;'/>
                  </div>
                  <div class='col-md-4'>
                      <input type='button' class='btn btn-info btn-sm' id='btnAusencia' name='btnAusencia' value='Ausencia' style='width:100%;overflow:hidden;font-size: 75%;margin-top:0px;height:100%;'/>
                  </div>
                  <div class='col-md-4'>
                      <input type='button' class='btn btn-warning btn-sm' id='btnPermiso' name='btnPermiso' value='Permisos' style='width:100%;overflow:hidden;font-size: 75%;margin-top:0px;height:100%;'/>
                  </div>
                </div>
              </div>
            </td>
          </tr>";
  }
  /*
  <div class='col-md-3'>
      <input type='hidden' id='numDoc' name='numDoc' value='".$row["NumeroDocumento"]."'>
      <input type='button' class='btn btn-primary btn-sm' id='agregar' name='agregar' value='agregar' />
  </div>
  <div class='col-md-3'>
      <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
      <input type='button' class='btn btn-info btn-sm' id='Ver' name='Ver' value='Ver' />
  </div>
  <div class='col-md-3'>
      <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
      <input type='button' class='btn btn-warning btn-sm' id='Validar' name='Validar' value='Validar' />
  </div>
  */
  mysqli_close($cnx);
}
function get_Row_Fecha_Reporte_Semana_Llegadas_Tarde($NitEmpresa){
 	$cnx=cnx();
 	$query=sprintf("select * from llegadas_tarde WHERE NitEmpresa='%s' GROUP BY Fecha ORDER BY Fecha ASC",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
      $str="";
      $actSN=0;
      if($row["EstadoLlegadasTarde"]==1){
        $actSN=1;
        $str=$str."
        <button name='' id=''  style='background: transparent;border: none;'>
         <div class='icon'>
              <i class='material-icons'>assignment_turned_in</i>
         </div>
        </button>";
      }else{
        $actSN=0;
        $str=$str."
        <button name='' id=''  style='background: transparent;border: none;'>
         <div class='icon'>
              <i class='material-icons'>warning</i>
         </div>
        </button>";
      }
      echo "<tr>
         <td>".$row["Fecha"]."</td>
         <td><input type='hidden' value'".$actSN."'>
           <div class='col-md-12'>
             <form target='_blank' method='post' action='Comprobacion_Llegadas_Tarde.php'>
               <input type='hidden' name='idLlegadasTarde' value='".$row["idLlegadasTarde"]."'>
               <span style='color:white;opacity: 0.2;' id='EstadoLlegadasTarde' name='EstadoLlegadasTarde'>".$row["EstadoLlegadasTarde"]."</span>
               ".$str."
             </form>
           </div>
         </td>
         <td class='text-right'>
           <div class='col-md-12'>
             <form target='_blank' method='post' action='../php/PDF_Llegadas_Tarde.php'>
               <input type='hidden' name='idLlegadasTarde' value='".$row["idLlegadasTarde"]."'>
               <button name='' id=''  style='background: transparent;border: none;'>
                <div class='icon'>
                     <i class='material-icons'>picture_as_pdf</i>
                </div>
               </button>
             </form>
           </div>
         </td>
       </tr>";

	}
	mysqli_close($cnx);

}



function get_Row_Fecha_Reporte_Semana($NitEmpresa){
 	$cnx=cnx();
 	$query=sprintf("select * from horas_extras WHERE NitEmpresa='%s' GROUP BY Fecha ORDER BY horas_extras.Fecha DESC",mysqli_real_escape_string($cnx,$NitEmpresa));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
      $str="";
      $actSN=0;
      if($row["EstadoHorasExternas"]==1){
        $actSN=1;
        $str=$str."
        <button name='' id=''  style='background: transparent;border: none;'>
         <div class='icon'>
              <i class='material-icons'>assignment_turned_in</i>
         </div>
        </button>";
      }else{
        $actSN=0;
        $str=$str."
        <button name='' id=''  style='background: transparent;border: none;'>
         <div class='icon'>
              <i class='material-icons'>warning</i>
         </div>
        </button>";
      }
      echo "<tr>
         <td>".$row["Fecha"]."</td>
         <td><input type='hidden' value'".$actSN."'>
           <div class='col-md-12'>
             <form target='_blank' method='post' action='Comprobacion_Horas_Extras.php'>
               <input type='hidden' name='idHorasExtras' value='".$row["idHorasExtras"]."'>
               <span style='color:white;opacity: 0.2;' id='EstadoHorasExternas' name='EstadoHorasExternas'>".$row["EstadoHorasExternas"]."</span>
               ".$str."
             </form>
           </div>
         </td>
         <td class='text-right'>
           <div class='col-md-12'>
             <form target='_blank' method='post' action='PDF_Horas_Extras.php'>
               <input type='hidden' name='idHorasExtras' value='".$row["idHorasExtras"]."'>
               <button name='' id=''  style='background: transparent;border: none;'>
                <div class='icon'>
                     <i class='material-icons'>picture_as_pdf</i>
                </div>
               </button>
             </form>
           </div>
         </td>
       </tr>";

	}
	mysqli_close($cnx);

}
function get_Row_Comprobacion_Llegadas_Tardes($idLlegadasTarde){
  $cnx=cnx();
  $query=sprintf("SELECT col_llegadas_tarde.*, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM col_llegadas_tarde INNER JOIN empleado WHERE  col_llegadas_tarde.NumeroDocumento=empleado.NumeroDocumento AND col_llegadas_tarde.idLlegadasTarde='%s' ORDER BY col_llegadas_tarde.Desde ASC, col_llegadas_tarde.Hasta ASC",mysqli_real_escape_string($cnx,$idLlegadasTarde));
 	$result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
    echo '<tr>
            <td><span style="font-size:12px;">'.$NombreCompleto.'</span>
            </td>
            <td>
              '.$row["Desde"].'
            </td>
            <td>
              '.$row["Hasta"].'
            </td>
            <td>
              '.$row["Tiempo"].'
            </td>
          </tr>';
  }

}

function get_Row_Comprobacion_Horas_Extras($idHorasExtras){
  $cnx=cnx();
  $query=sprintf("SELECT col_horas_extras.*, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM col_horas_extras INNER JOIN horas_extras INNER JOIN empleado WHERE horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND col_horas_extras.NumeroDocumentoPara=empleado.NumeroDocumento AND horas_extras.idHorasExtras='%s' ORDER BY col_horas_extras.Desde ASC, col_horas_extras.Hasta ASC",mysqli_real_escape_string($cnx,$idHorasExtras));
 	$result=mysqli_query($cnx,$query);
  while ($row=mysqli_fetch_array($result)) {
    $NombreCompleto=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
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
 	$query=sprintf("SELECT col_horas_extras.*,horas_extras.EstadoHorasExternas,horas_extras.Fecha,POR.PrimerNombre,POR.SegundoNombre,POR.PrimerApellido,POR.SegundoApellido FROM col_horas_extras INNER JOIN horas_extras INNER JOIN empleado POR WHERE horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND col_horas_extras.NumeroDocumentoPor=POR.NumeroDocumento and  col_horas_extras.NumeroDocumentoPara='%s' ORDER BY horas_extras.Fecha DESC",mysqli_real_escape_string($cnx,$NumeroDocumento));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    //CUIDADO CON LA BASE DE HORAS EXTRAS
      $POR=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
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

function get_Row_Empleado_Llegadas_Tarde_Semana($NumeroDocumento){
  $cnx=cnx();
 	$query=sprintf("SELECT col_llegadas_tarde.*,llegadas_tarde.EstadoLlegadasTarde,llegadas_tarde.Fecha,POR.PrimerNombre,POR.SegundoNombre,POR.PrimerApellido,POR.SegundoApellido FROM col_llegadas_tarde INNER JOIN llegadas_tarde INNER JOIN empleado POR WHERE llegadas_tarde.idLlegadasTarde=col_llegadas_tarde.idLlegadasTarde AND col_llegadas_tarde.NumeroDocumentoPor=POR.NumeroDocumento and col_llegadas_tarde.NumeroDocumento='%s' ORDER BY llegadas_tarde.Fecha DESC",mysqli_real_escape_string($cnx,$NumeroDocumento));
 	$result=mysqli_query($cnx,$query);
	while ($row=mysqli_fetch_array($result)) {
    //CUIDADO CON LA BASE DE HORAS EXTRAS
      $POR=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
      if($row["EstadoLlegadasTarde"]==0){
        $strAux="
          <div class='col-md-12'>
             <button id='".$row['idColLlegadas_Tarde']."' style='background: url(../img/icons/delete.png);border: 0;' onClick='imprimirHE(this.id)'>M</button>
          </div>";
      }else{
        $strAux="";
      }
      echo "<tr>
           <td>".$POR."</td>
           <td>".$row["Desde"]."</td>
           <td>".$row["Hasta"]."</td>
           <td>".$row["Tiempo"]."</td>
           <td>".$row["Fecha"]."</td>
           <td class='text-right'>
             ".$strAux."
           </td>
       </tr>";
	}
	mysqli_close($cnx);
}


 ?>

<?php
include_once '../php/cn.php';
$NitEmpresa= $_POST["NitEmpresa"];
$aBuscar= $_POST["aBuscar"];//1 Activos, 2 TODOs
$cnx=cnx();
if($aBuscar==1){
  $query=sprintf("SELECT * FROM empleado INNER JOIN htrabajo INNER JOIN cargos INNER JOIN departamento INNER JOIN empresa INNER JOIN turno WHERE empleado.NumeroDocumento=htrabajo.NumeroDocumento AND htrabajo.idTurno=turno.idTurno  AND empleado.idCargos=cargos.idCargos AND cargos.idDepartamento=departamento.idDepartamento AND departamento.NitEmpresa=empresa.NitEmpresa AND empresa.NitEmpresa='%s' AND empleado.Activo=1",mysqli_real_escape_string($cnx,$NitEmpresa));
}else $query=sprintf("SELECT * FROM empleado INNER JOIN htrabajo INNER JOIN cargos INNER JOIN departamento INNER JOIN empresa INNER JOIN turno WHERE empleado.NumeroDocumento=htrabajo.NumeroDocumento AND htrabajo.idTurno=turno.idTurno  AND empleado.idCargos=cargos.idCargos AND cargos.idDepartamento=departamento.idDepartamento AND departamento.NitEmpresa=empresa.NitEmpresa AND empresa.NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
$result=mysqli_query($cnx,$query);
$i=0;
$arrayAux=array("Numero de Documento","Tipo de Documento","Nombre de Cargo","Nup","Institucion Previsional","Primer Nombre","Segundo Nombre","Primer Apellido","Segundo Apellido","Apellido de Casada/o","Conocido Por","Nit","Numero del Isss","Numero de Inpep","Genero","Nacionalidad","Salario Nominal","Fecha de Nacimiento","Estado Civil","Direccion");
//array("Departamento","Municipio","NumeroTelefonico","CorreoElectronico","TipoEmpleado,"FechaIngreso","FechaRetiro","FechaFallecimiento")
$arrayAux=array_merge($arrayAux,array("Departamento","Municipio","Numero Telefonico","Correo Electronico","Tipo de Empleado","Fecha de Ingreso","Fecha de Retiro","Fecha de Fallecimiento","Horario Desde","Horario Hasta","Turno"));
$data[$i]=$arrayAux;
$i++;
while($row=mysqli_fetch_array($result)){
  $arrayAux=array($row["NumeroDocumento"],$row["TipoDocumento"],$row["NombreCargo"],$row["Nup"],$row["InstitucionPrevisional"],$row["PrimerNombre"],$row["SegundoNombre"],$row["PrimerApellido"],$row["SegundoApellido"],$row["ApellidoCasada"],$row["ConocidoPor"]);
  $arrayAux=array_merge($arrayAux,array($row["Nit"],$row["NumeroIsss"],$row["NumeroInpep"],$row["Genero"],$row["Nacionalidad"],$row["SalarioNominal"],$row["FechaNacimiento"],$row["EstadoCivil"],$row["Direccion"],$row["Departamento"],$row["Municipio"]));
  $data[$i]=array_merge($arrayAux,array($row["NumeroTelefonico"],$row["CorreoElectronico"],$row["TipoEmpleado"],$row["FechaIngreso"],$row["FechaRetiro"],$row["FechaFallecimiento"],$row["Desde"],$row["Hasta"],$row["nombreTurno"]));
  $i++;
}
mysqli_close($cnx);
// filename for download
$filename = "website_data.xls";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
foreach($data as $row) {
  if(!$flag) {
    // display field/column names as first row
    //echo implode("\t", array_keys($row)) . "\r\n";
    $flag = true;
  }
  array_walk($row, __NAMESPACE__ . '\cleanData');
  echo implode("\t", array_values($row)) . "\r\n";
}
exit;

function cleanData(&$str){
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}
 ?>

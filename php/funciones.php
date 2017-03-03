<?php
	include_once 'cn.php';
	include_once 'include_classes.php';

	function estadoCnx(){
		return pruebaCnx();
	}

	function isUserExist($user){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$user));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function ExisteSP($semana,$annio,$NitEmpresa,$idTurno){
		$semana=$semana;
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM semanal where NitEmpresa='%s' and nSemana='%s' and anno='%s' and idTurno='%s' ",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$semana),mysqli_real_escape_string($cnx,$annio),mysqli_real_escape_string($cnx,$idTurno));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;

	}
	function isEmpresaExist($NitEmpresa){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM empresa where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function isTurnoExist($idTurno){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM turno where idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function displayDepartamentos($NitEmpresa,$flag){
		if($flag==0){
			$cnx=cnx();
			$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
			$resul=mysqli_query($cnx,$query);
			while($row=mysqli_fetch_array($resul)){
				echo "<option value='".$row["idDepartamento"]."'>".$row["NombreDepartamento"]."</option>";
			}
			mysqli_close($cnx);
		}else{
			$cnx=cnx();
			$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
			$resul=mysqli_query($cnx,$query);
			while($row=mysqli_fetch_array($resul)){
				if($flag==$row["idDepartamento"]){
					echo "<option selected value='".$row["idDepartamento"]."'>".$row["NombreDepartamento"]."</option>";
				}else
				echo "<option value='".$row["idDepartamento"]."'>".$row["NombreDepartamento"]."</option>";
			}
			mysqli_close($cnx);
		}

	}
	function checkNombreCargos($NombreCargo,$idDepartamento,$idCargos){
		if($idCargos==0){
			$cnx=cnx();
			$flag=FALSE;
			$query=sprintf("SELECT * FROM cargos  WHERE idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
			$resul=mysqli_query($cnx,$query);
			while($row=mysqli_fetch_array($resul)){
				if(strcmp($row["NombreCargo"], $NombreCargo) == 0)
					$flag=TRUE;
			}
			mysqli_close($cnx);
			return $flag;
		}else{
			$cnx=cnx();
			$flag=FALSE;
			$query=sprintf("SELECT * FROM cargos  WHERE idDepartamento='%s' and idCargos!='%s'",mysqli_real_escape_string($cnx,$idDepartamento),mysqli_real_escape_string($cnx,$idCargos));
			$resul=mysqli_query($cnx,$query);
			while($row=mysqli_fetch_array($resul)){
				if(strcmp($row["NombreCargo"], $NombreCargo) == 0)
					$flag=TRUE;
			}
			mysqli_close($cnx);
			return $flag;
		}

	}
	function checkNombreDepartamento($NombreDepartamento,$NitEmpresa){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
		$resul=mysqli_query($cnx,$query);
		while($row=mysqli_fetch_array($resul)){
			if(strcmp($row["NombreDepartamento"], $NombreDepartamento) == 0)
				$flag=TRUE;
		}
		mysqli_close($cnx);
		return $flag;
	}
	function checkNombreEmpresa($NombreEmpresa){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM empresa WHERE NombreEmpresa!= '%s'",mysqli_real_escape_string($cnx,$NombreEmpresa));
		$resul=mysqli_query($cnx,$query);
		while($row=mysqli_fetch_array($resul)){
			if(strcmp($row["NombreEmpresa"], $NombreEmpresa) == 0)
				$flag=TRUE;
		}
		mysqli_close($cnx);
		return $flag;
	}
	function checkNombreDepartamentoToModf($NombreDepartamento,$NitEmpresa,$idDepartamento){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM departamento where NitEmpresa='%s' and idDepartamento!='%s'",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$idDepartamento));
		$resul=mysqli_query($cnx,$query);
		while($row=mysqli_fetch_array($resul)){
			if(strcmp($row["NombreDepartamento"], $NombreDepartamento) == 0)
				$flag=TRUE;
		}
		mysqli_close($cnx);
		return $flag;

	}
	function isLoginOk($user,$Pass){
		$cnx=cnx();
		$query=sprintf("SELECT 	Pass FROM empleado where NumeroDocumento='%s'", mysqli_real_escape_string($cnx,$user));
		$result=mysqli_query($cnx,$query);
		$flag=FALSE;
		while($row=mysqli_fetch_array($result)){
			if($row["Pass"]==$Pass){
				$flag=TRUE;
			}
		}
		mysqli_close($cnx);
		return $flag;
	}
	function getInfoUser($user){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$user));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$empleado = new empleado_class();
			$empleado->setNumerodocumento($row["NumeroDocumento"]);
			$empleado->setTipodocumento($row["TipoDocumento"]);
			$empleado->setIdcargos($row["idCargos"]);
			$empleado->setPass($row["Pass"]);
			$empleado->setActivo($row["Activo"]);
			$empleado->setNup($row["Nup"]);
			$empleado->setInstitucionprevisional($row["InstitucionPrevisional"]);
			$empleado->setPrimernombre($row["PrimerNombre"]);
			$empleado->setSegundonombre($row["SegundoNombre"]);
			$empleado->setPrimerapellido($row["PrimerApellido"]);
			$empleado->setSegundoapellido($row["SegundoApellido"]);
			$empleado->setApellidocasada($row["ApellidoCasada"]);
			$empleado->setConocidopor($row["ConocidoPor"]);
			$empleado->setNit($row["Nit"]);
			$empleado->setNumeroisss($row["NumeroIsss"]);
			$empleado->setNumeroinpep($row["NumeroInpep"]);
			$empleado->setGenero($row["Genero"]);
			$empleado->setNacionalidad($row["Nacionalidad"]);
			$empleado->setSalarionominal($row["SalarioNominal"]);
			$empleado->setFechanacimiento($row["FechaNacimiento"]);
			$empleado->setEstadocivil($row["EstadoCivil"]);
			$empleado->setDireccion($row["Direccion"]);
			$empleado->setDepartamento($row["Departamento"]);
			$empleado->setMunicipio($row["Municipio"]);
			$empleado->setNumerotelefonico($row["NumeroTelefonico"]);
			$empleado->setCorreoelectronico($row["CorreoElectronico"]);
			$empleado->setTipoempleado($row["TipoEmpleado"]);
			$empleado->setFechaingreso($row["FechaIngreso"]);
			$empleado->setFecharetiro($row["FechaRetiro"]);
			$empleado->setFechafallecimiento($row["FechaFallecimiento"]);
		}
		mysqli_close($cnx);
		return $empleado;
	}
	function getInfoHTrabajo($NumeroDocumento){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM htrabajo where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$htrabajo = new htrabajo_class();
			$htrabajo->setNumerodocumento($row["NumeroDocumento"]);
			$htrabajo->setDesde($row["Desde"]);
			$htrabajo->setHasta($row["Hasta"]);
			$htrabajo->setIdturno($row["idTurno"]);
		}
		mysqli_close($cnx);
		return $htrabajo;
	}
	function getInfoEmpresa($NitEmpresa){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM empresa where NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$empresa = new empresa_class();
			$empresa->setNombreempresa($row["NombreEmpresa"]);
			$empresa->setDireccion($row["Direccion"]);
			$empresa->setTelefono($row["Telefono"]);
			$empresa->setTelefono2($row["Telefono2"]);
			$empresa->setNregistro($row["NRegistro"]);
			$empresa->setGiro($row["Giro"]);
			$empresa->setNpatronalss($row["NPatronalSS"]);
			$empresa->setNpatronalafp($row["NPatronalAFP"]);
			$empresa->setRepresentantelegal($row["RepresentanteLegal"]);
			$empresa->setTipoempresa($row["TipoEmpresa"]);

		}
		mysqli_close($cnx);
		return $empresa;

	}
	function getInfoTurnor($idTurno){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM turno where idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$turno = new turno_class();
			$turno->setNombreturno($row["nombreTurno"]);
			$turno->setDesde($row["Desde"]);
			$turno->setHasta($row["Hasta"]);
			$turno->setDescanso($row["Descanso"]);
			$turno->setHDescanso($row["H_Descanso"]);
		}
		mysqli_close($cnx);
		return $turno;
	}


		function getInfoEmpleado($idEmpleado){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$idEmpleado));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$empleado = new empleado_class();
			$empleado->setNumerodocumento($row["NumeroDocumento"]);
			$empleado->setTipodocumento($row["TipoDocumento"]);
			$empleado->setIdcargos($row["idCargos"]);
			$empleado->setPass($row["Pass"]);
			$empleado->setActivo($row["Activo"]);
			$empleado->setNup($row["Nup"]);
			$empleado->setInstitucionprevisional($row["InstitucionPrevisional"]);
			$empleado->setPrimernombre($row["PrimerNombre"]);
			$empleado->setSegundonombre($row["SegundoNombre"]);
			$empleado->setPrimerapellido($row["PrimerApellido"]);
			$empleado->setSegundoapellido($row["SegundoApellido"]);
			$empleado->setApellidocasada($row["ApellidoCasada"]);
			$empleado->setConocidopor($row["ConocidoPor"]);
			$empleado->setNit($row["Nit"]);
			$empleado->setNumeroisss($row["NumeroIsss"]);
			$empleado->setNumeroinpep($row["NumeroInpep"]);
			$empleado->setGenero($row["Genero"]);
			$empleado->setNacionalidad($row["Nacionalidad"]);
			$empleado->setSalarionominal($row["SalarioNominal"]);
			$empleado->setFechanacimiento($row["FechaNacimiento"]);
			$empleado->setEstadocivil($row["EstadoCivil"]);
			$empleado->setDireccion($row["Direccion"]);
			$empleado->setDepartamento($row["Departamento"]);
			$empleado->setMunicipio($row["Municipio"]);
			$empleado->setNumerotelefonico($row["NumeroTelefonico"]);
			$empleado->setCorreoelectronico($row["CorreoElectronico"]);
			$empleado->setTipoempleado($row["TipoEmpleado"]);
			$empleado->setFechaingreso($row["FechaIngreso"]);
			$empleado->setFecharetiro($row["FechaRetiro"]);
			$empleado->setFechafallecimiento($row["FechaFallecimiento"]);
		}
		mysqli_close($cnx);
		return $empleado;
	}

	function getSalarioMinimo($Idcargos){
		$cnx=cnx();
		$query=sprintf("SELECT Salario_Mes from salarios_minimos INNER JOIN departamento ON salarios_minimos.idSalario_Minimo=departamento.idSalario_Minimo INNER JOIN cargos ON departamento.idDepartamento=cargos.idDepartamento WHERE departamento.idDepartamento='%s'",mysqli_real_escape_string($cnx,$Idcargos));
		$result=mysqli_query($cnx,$query);
		$Salario_Mes=mysqli_fetch_array($result);
		mysqli_close($cnx);
		return $Salario_Mes[0];

	}
	function getSalariosM($idDepartamento){
		$cnx=cnx();
		$query2=sprintf("SELECT * FROM departamento  WHERE idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
		$result2=mysqli_query($cnx,$query2);
		$row2=mysqli_fetch_array($result2);
		$query=sprintf("SELECT * FROM salarios_minimos ");
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			if($row["idSalario_Minimo"]==$row2["idSalario_Minimo"]){
				echo "<option selected value='".$row["idSalario_Minimo"]."'>".$row["NombreRubro"]."</option>";
			}else
		  echo "<option value='".$row["idSalario_Minimo"]."'>".$row["NombreRubro"]."</option>";
		}
		mysqli_close($cnx);
	}

	function getInfoCargos($user){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM cargos where idCargos='%s'",mysqli_real_escape_string($cnx,$user));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$cargo = new cargos_class();
			$cargo->setIddepartamento($row["idDepartamento"]);
			$cargo->setNombrecargo($row["NombreCargo"]);
			$cargo->setDescripcion($row["Descripcion"]);
			$cargo->setPempleado($row["PEmpleado"]);
			$cargo->setPplanilla($row["PPlanilla"]);
			$cargo->setPjefe($row["PJefe"]);
		}
		mysqli_close($cnx);
		return $cargo;
	}


	function getInfoDepartamentos($depa){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM departamento where idDepartamento='%s'",mysqli_real_escape_string($cnx,$depa));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$departamento = new departamento_class();
			$departamento->setNitempresa($row["NitEmpresa"]);
			$departamento->setNombredepartamento($row["NombreDepartamento"]);
			$departamento->setCuentacontable($row["CuentaContable"]);
		}
		mysqli_close($cnx);
		return $departamento;
	}

	function getNitEmpresa($user){
		$cargo=new cargos_class();
        $cargo=getInfoCargos($user->getIdcargos());
        $departamento=new departamento_class();
        $departamento=getInfoDepartamentos($cargo->getIddepartamento());
        $NitEmpresa=$departamento->getNitempresa();
        return $NitEmpresa;
	}

	function insertarEmpleado($empleado){
		$cnx=cnx();
		$query = sprintf("INSERT INTO usuario(correoUsuario,passUsuario,nombreUsuario,apellidoUsuario,idTipoUsuario,idUnidad,idPuesto,idZona,idEstadoUsuario,fechaRegistroUsuario,fechaModificadoUsuario) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s',now(), null)",
			mysqli_real_escape_string($cnx,$usuario->getCorreoUsuario()),
			mysqli_real_escape_string($cnx,md5($usuario->getPassUsuario())),
			mysqli_real_escape_string($cnx,$usuario->getNombreUsuario()),
			mysqli_real_escape_string($cnx,$usuario->getApellidoUsuario()),
			mysqli_real_escape_string($cnx,$usuario->getIdTipoUsuario()),
			mysqli_real_escape_string($cnx,$usuario->getIdUnidad()),
			mysqli_real_escape_string($cnx,$usuario->getIdPuesto()),
			mysqli_real_escape_string($cnx,$usuario->getIdZona()),
			mysqli_real_escape_string($cnx,$usuario->getIdEstadoUsuario())
			);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}

	function InsertarSemanal($semana,$annio,$NitEmpresa,$idTurno){
		$cnx=cnx();
		$query = sprintf("INSERT INTO semanal(NitEmpresa,idTurno,nSemana,anno) VALUES ('%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$idTurno),
			mysqli_real_escape_string($cnx,$semana),
			mysqli_real_escape_string($cnx,$annio)
			);
		$estado = mysqli_query($cnx,$query);
		if($estado){
			$query3=sprintf("SELECT * FROM semanal where NitEmpresa='%s' and nSemana='%s' and anno='%s' and idTurno='%s' ",mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$semana),mysqli_real_escape_string($cnx,$annio),mysqli_real_escape_string($cnx,$idTurno));
			$result3=mysqli_query($cnx,$query3);
			$row3=mysqli_fetch_array($result3);
			$query=sprintf("SELECT * FROM htrabajo where idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
		 	$result=mysqli_query($cnx,$query);
			while ($row=mysqli_fetch_array($result)) {
				$NumeroDocumento=$row["NumeroDocumento"];
				$query2=sprintf("SELECT * FROM empleado where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento));
		 		$result2=mysqli_query($cnx,$query2);
					$row2=mysqli_fetch_array($result2);
					$valor="1";
					$query = sprintf("INSERT INTO col_semanal(idSemanal,NumeroDocumento,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
					mysqli_real_escape_string($cnx,$row3["idSemanal"]),
					mysqli_real_escape_string($cnx,$row["NumeroDocumento"]),
					mysqli_real_escape_string($cnx,$valor),
					mysqli_real_escape_string($cnx,$valor),
					mysqli_real_escape_string($cnx,$valor),
					mysqli_real_escape_string($cnx,$valor),
					mysqli_real_escape_string($cnx,$valor),
					mysqli_real_escape_string($cnx,$valor),
					mysqli_real_escape_string($cnx,$valor)
					);
					$estado = mysqli_query($cnx,$query);
			}
		}
		mysqli_close($cnx);
		return $estado;

	}
	function UpdateSemanal($idSemana,$Lunes,$Martes,$Miercoles,$Jueves,$Viernes,$Sabado,$Domingo){
		$cnx=cnx();
				$query2=sprintf("SELECT * FROM col_semanal where idSemanal='%s'",mysqli_real_escape_string($cnx,$idSemana));
		 		$result2=mysqli_query($cnx,$query2);
				while ($row2=mysqli_fetch_array($result2)) {
					$query = sprintf("UPDATE col_semanal SET  Lunes = '%s',Martes = '%s',Miercoles = '%s', Jueves = '%s', Viernes = '%s', Sabado = '%s', Domingo = '%s' WHERE idCol_Semanal = '%s'",
					mysqli_real_escape_string($cnx,$Lunes),
					mysqli_real_escape_string($cnx,$Martes),
					mysqli_real_escape_string($cnx,$Miercoles),
					mysqli_real_escape_string($cnx,$Jueves),
					mysqli_real_escape_string($cnx,$Viernes),
					mysqli_real_escape_string($cnx,$Sabado),
					mysqli_real_escape_string($cnx,$Domingo),
					mysqli_real_escape_string($cnx,$row2["idCol_Semanal"])
					);
					$estado = mysqli_query($cnx,$query);
				}
		mysqli_close($cnx);
		return $estado;
	}
	function UpdateDepartamento($NombreDepartamento,$CuentaContable,$idSalario_Minimo,$idDepartamento){
		$cnx=cnx();
		$query = sprintf("UPDATE departamento SET  NombreDepartamento = '%s',idSalario_Minimo = '%s',CuentaContable = '%s' WHERE idDepartamento = '%s'",
		mysqli_real_escape_string($cnx,$NombreDepartamento),
		mysqli_real_escape_string($cnx,$idSalario_Minimo),
		mysqli_real_escape_string($cnx,$CuentaContable),
		mysqli_real_escape_string($cnx,$idDepartamento)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function UpdateEmpresa($NombreEmpresa,$Direccion,$Telefono,$Telefono2,$NRegistro,$Giro,$NPatronalSS,$NPatronalAFP,$RepresentanteLegal,$NitEmpresa,$TipeRequest,$TipoEmpresa){
		$cnx=cnx();
		//Si TipeRequest==0 not update TipoEmpresa
		if($TipeRequest==1){
			$query = sprintf("UPDATE empresa SET  NombreEmpresa	 = '%s',Direccion = '%s',Telefono = '%s',Telefono2 = '%s',NRegistro = '%s',Giro = '%s',NPatronalSS = '%s',NPatronalAFP = '%s',RepresentanteLegal = '%s',TipoEmpresa = '%s' WHERE NitEmpresa = '%s'",
			mysqli_real_escape_string($cnx,$NombreEmpresa),
			mysqli_real_escape_string($cnx,$Direccion),
			mysqli_real_escape_string($cnx,$Telefono),
			mysqli_real_escape_string($cnx,$Telefono2),
			mysqli_real_escape_string($cnx,$NRegistro),
			mysqli_real_escape_string($cnx,$Giro),
			mysqli_real_escape_string($cnx,$NPatronalSS),
			mysqli_real_escape_string($cnx,$NPatronalAFP),
			mysqli_real_escape_string($cnx,$RepresentanteLegal),
			mysqli_real_escape_string($cnx,$TipoEmpresa),
			mysqli_real_escape_string($cnx,$NitEmpresa)
			);
		}else{
			$query = sprintf("UPDATE empresa SET  NombreEmpresa	 = '%s',Direccion = '%s',Telefono = '%s',Telefono2 = '%s',NRegistro = '%s',Giro = '%s',NPatronalSS = '%s',NPatronalAFP = '%s',RepresentanteLegal = '%s' WHERE NitEmpresa = '%s'",
			mysqli_real_escape_string($cnx,$NombreEmpresa),
			mysqli_real_escape_string($cnx,$Direccion),
			mysqli_real_escape_string($cnx,$Telefono),
			mysqli_real_escape_string($cnx,$Telefono2),
			mysqli_real_escape_string($cnx,$NRegistro),
			mysqli_real_escape_string($cnx,$Giro),
			mysqli_real_escape_string($cnx,$NPatronalSS),
			mysqli_real_escape_string($cnx,$NPatronalAFP),
			mysqli_real_escape_string($cnx,$RepresentanteLegal),
			mysqli_real_escape_string($cnx,$NitEmpresa)
			);
		}

		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function UpdateCargos($NombreCargo,$Descripcion,$idDepartamento,$PEmpleado,$PPlanilla,$idCargos){
		$cnx=cnx();
		$query = sprintf("UPDATE cargos SET  idDepartamento = '%s',NombreCargo = '%s',Descripcion = '%s',PEmpleado = '%s',PPlanilla = '%s' WHERE idCargos = '%s'",
		mysqli_real_escape_string($cnx,$idDepartamento),
		mysqli_real_escape_string($cnx,$NombreCargo),
		mysqli_real_escape_string($cnx,$Descripcion),
		mysqli_real_escape_string($cnx,$PEmpleado),
		mysqli_real_escape_string($cnx,$PPlanilla),
		mysqli_real_escape_string($cnx,$idCargos)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
function eliminarTurno($idTurno){
	$cnx=cnx();
	$estado=1;
	$query2=sprintf("SELECT * FROM htrabajo where idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
	$result2=mysqli_query($cnx,$query2);
	while ($row2=mysqli_fetch_array($result2)) {
		$estado=2;
	}
	if($estado==1){
		$query=sprintf("DELETE FROM turno WHERE idTurno='%s'",mysqli_real_escape_string($cnx,$idTurno));
		$estado = mysqli_query($cnx, $query);
	}

	mysqli_close($cnx);
	return $estado;
}

//eliminarDepartamento
function eliminarDepartamento($idDepartamento,$NitEmpresa){
	$cnx=cnx();
	$estado=1;
	$query2=sprintf("SELECT * FROM cargos where idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
	$result2=mysqli_query($cnx,$query2);
	while ($row2=mysqli_fetch_array($result2)) {
		$estado=2;
	}
	if($estado==1){
		$query=sprintf("DELETE FROM departamento WHERE idDepartamento='%s'",mysqli_real_escape_string($cnx,$idDepartamento));
		$estado = mysqli_query($cnx, $query);
	}

	mysqli_close($cnx);
	return $estado;
}
//eliminarHoraExtra
function eliminarHoras_extras($IdHorasExtras){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM horas_extras WHERE IdHorasExtras='%s'",mysqli_real_escape_string($cnx,$IdHorasExtras));
		$estado = mysqli_query($cnx, $query);

	mysqli_close($cnx);
	return $estado;
}
//eliminarCargos
function eliminarCargos($idCargos,$NitEmpresa){
	$cnx=cnx();
	$estado=1;
	$query2=sprintf("SELECT * FROM empleado where idCargos='%s'",mysqli_real_escape_string($cnx,$idCargos));
	$result2=mysqli_query($cnx,$query2);
	while ($row2=mysqli_fetch_array($result2)) {
		$estado=2;
	}
	if($estado==1){
		$query=sprintf("DELETE FROM cargos WHERE idCargos='%s'",mysqli_real_escape_string($cnx,$idCargos));
		$estado = mysqli_query($cnx, $query);
	}

	mysqli_close($cnx);
	return $estado;
}
	function actualizarUsuario($empleado,$htrabajo){
		$cnx = cnx();
		$query = sprintf("UPDATE empleado SET idCargos = '%s', Pass ='%s', Activo = '%s', Nup = '%s', InstitucionPrevisional = '%s', PrimerNombre = '%s',SegundoNombre = '%s' , PrimerApellido = '%s' , SegundoApellido = '%s' , ApellidoCasada = '%s' , ConocidoPor = '%s' , TipoDocumento = '%s' , NumeroDocumento = '%s' , Nit = '%s' , NumeroIsss = '%s' , NumeroInpep = '%s' , Genero = '%s' , Nacionalidad = '%s' , SalarioNominal = '%s' , FechaNacimiento = '%s' , EstadoCivil = '%s' , Direccion = '%s' , Departamento = '%s' , Municipio = '%s' , NumeroTelefonico = '%s' , CorreoElectronico = '%s' , FechaIngreso = '%s' , FechaRetiro = '%s' , FechaFallecimiento = '%s' WHERE NumeroDocumento = '%s'",
			mysqli_real_escape_string($cnx, $empleado->getIdcargos()),
			mysqli_real_escape_string($cnx, $empleado->getPass()),
			mysqli_real_escape_string($cnx, $empleado->getActivo()),
			mysqli_real_escape_string($cnx, $empleado->getNup()),
			mysqli_real_escape_string($cnx, $empleado->getInstitucionprevisional()),
			mysqli_real_escape_string($cnx, $empleado->getPrimernombre()),
			mysqli_real_escape_string($cnx, $empleado->getSegundonombre()),
			mysqli_real_escape_string($cnx, $empleado->getPrimerapellido()),
			mysqli_real_escape_string($cnx, $empleado->getSegundoapellido()),
			mysqli_real_escape_string($cnx, $empleado->getApellidocasada()),
			mysqli_real_escape_string($cnx, $empleado->getConocidopor()),
			mysqli_real_escape_string($cnx, $empleado->getTipodocumento()),
			mysqli_real_escape_string($cnx, $empleado->getNumerodocumento()),
			mysqli_real_escape_string($cnx, $empleado->getNit()),
			mysqli_real_escape_string($cnx, $empleado->getNumeroisss()),
			mysqli_real_escape_string($cnx, $empleado->getNumeroinpep()),
			mysqli_real_escape_string($cnx, $empleado->getGenero()),
			mysqli_real_escape_string($cnx, $empleado->getNacionalidad()),
			mysqli_real_escape_string($cnx, $empleado->getSalarionominal()),
			mysqli_real_escape_string($cnx, $empleado->getFechanacimiento()),
			mysqli_real_escape_string($cnx, $empleado->getEstadocivil()),
			mysqli_real_escape_string($cnx, $empleado->getDireccion()),
			mysqli_real_escape_string($cnx, $empleado->getDepartamento()),
			mysqli_real_escape_string($cnx, $empleado->getMunicipio()),
			mysqli_real_escape_string($cnx, $empleado->getNumerotelefonico()),
			mysqli_real_escape_string($cnx, $empleado->getCorreoelectronico()),
			mysqli_real_escape_string($cnx, $empleado->getFechaingreso()),
			mysqli_real_escape_string($cnx, $empleado->getFecharetiro()),
			mysqli_real_escape_string($cnx, $empleado->getFechafallecimiento()),
			mysqli_real_escape_string($cnx, $empleado->getNumerodocumento())
			);
			$query2 = sprintf("UPDATE htrabajo SET Desde = '%s', Hasta ='%s', idTurno = '%s' WHERE NumeroDocumento = '%s'",
			mysqli_real_escape_string($cnx, $htrabajo->getDesde()),
			mysqli_real_escape_string($cnx, $htrabajo->getHasta()),
			mysqli_real_escape_string($cnx, $htrabajo->getIdturno()),
			mysqli_real_escape_string($cnx, $empleado->getNumerodocumento())
			);
		$estado = mysqli_query($cnx, $query);
		$estado2 = mysqli_query($cnx, $query2);
		$estadoT=$estado+$estado2;
		mysqli_close($cnx);
		return $estadoT;

	}
	function agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso){
		$cnx = cnx();
		$query = sprintf("INSERT INTO turno(NitEmpresa,nombreTurno,Desde,Hasta,Descanso,H_Descanso) VALUES ('%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$nombreTurno),
			mysqli_real_escape_string($cnx,$Desde),
			mysqli_real_escape_string($cnx,$Hasta),
			mysqli_real_escape_string($cnx,$Descanso),
			mysqli_real_escape_string($cnx,$H_Descanso)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;

	}
	function AgregarDepartamento($NombreDepartamento,$CuentaContable,$idSalario_Minimo,$NitEmpresa){
		$cnx = cnx();
		$query = sprintf("INSERT INTO departamento(NitEmpresa,NombreDepartamento,idSalario_Minimo,CuentaContable) VALUES ('%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$NombreDepartamento),
			mysqli_real_escape_string($cnx,$idSalario_Minimo),
			mysqli_real_escape_string($cnx,$CuentaContable)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;

	}
	function AgregarCargos($NombreCargo,$Descripcion,$idDepartamento,$PEmpleado,$PPlanilla){
		$cnx = cnx();
		$query = sprintf("INSERT INTO cargos(idDepartamento,NombreCargo,Descripcion,PEmpleado,PPlanilla,PJefe) VALUES ('%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$idDepartamento),
			mysqli_real_escape_string($cnx,$NombreCargo),
			mysqli_real_escape_string($cnx,$Descripcion),
			mysqli_real_escape_string($cnx,$PEmpleado),
			mysqli_real_escape_string($cnx,$PPlanilla),
			mysqli_real_escape_string($cnx,0)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;

	}
	function AgregarEmpleado($TipoDocumento,$NumeroDocumento,$PrimerNombre,$PrimerApellido,$Pass,$SalarioNominal,$Desde,$Hasta,$FechaIngreso,$idTurno,$Activo,$idCargos){
		$cnx = cnx();
		$query = sprintf("INSERT INTO empleado(NumeroDocumento,TipoDocumento,Pass,Activo,PrimerNombre,PrimerApellido,SalarioNominal,FechaIngreso,idCargos) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$TipoDocumento),
			mysqli_real_escape_string($cnx,$Pass),
			mysqli_real_escape_string($cnx,$Activo),
			mysqli_real_escape_string($cnx,$PrimerNombre),
			mysqli_real_escape_string($cnx,$PrimerApellido),
			mysqli_real_escape_string($cnx,$SalarioNominal),
			mysqli_real_escape_string($cnx,$FechaIngreso),
			mysqli_real_escape_string($cnx,$idCargos)
		);
		$estado = mysqli_query($cnx, $query);
		if($estado){
			$query = sprintf("INSERT INTO htrabajo(NumeroDocumento,Desde,Hasta,idTurno) VALUES ('%s','%s','%s','%s')",
				mysqli_real_escape_string($cnx,$NumeroDocumento),
				mysqli_real_escape_string($cnx,$Desde),
				mysqli_real_escape_string($cnx,$Hasta),
				mysqli_real_escape_string($cnx,$idTurno)
			);
			$estado = mysqli_query($cnx, $query);
		}
		mysqli_close($cnx);
		return $estado;
	}

	function actualizarTurno($idTurno,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso){
		$cnx = cnx();
		$query = sprintf("UPDATE turno SET nombreTurno = '%s', Desde ='%s', Hasta = '%s', Descanso = '%s', H_Descanso = '%s' WHERE idTurno = '%s'",
			mysqli_real_escape_string($cnx, $nombreTurno),
			mysqli_real_escape_string($cnx, $Desde),
			mysqli_real_escape_string($cnx, $Hasta),
			mysqli_real_escape_string($cnx, $Descanso),
			mysqli_real_escape_string($cnx, $H_Descanso),
			mysqli_real_escape_string($cnx, $idTurno)
			);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;

	}

	function imprimirSemana($year){
		for ($i = 1; $i <= 52; $i++) {
	        $j=$i;
	        if($i<10){
	            $j='0'.$i;
	        };
	        echo "<option value='".$i."'";
	        if ($i == date('W')) {
	        	echo "selected='selected' >";
	        }else echo ">";
	        $valor="Semana ".$i."  Lunes:".date('Y-m-d', strtotime($year.'W'.$j.'-'.'1'))."-Domingo:".date('Y-m-d', strtotime($year.'W'.$j.'-'.'7'))."";
	        echo $valor."</option>";
    	}
	}
	function obtToUpdateSemanal($NitEmpresa,$semana,$annio,$idTurno){
		$cnx = cnx();
		$query=sprintf("SELECT * FROM semanal where NitEmpresa='%s' and nSemana='%s' and anno='%s' and idTurno='%s' ",
		mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$semana),mysqli_real_escape_string($cnx,$annio),mysqli_real_escape_string($cnx,$idTurno));
		$result=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($result);
		$query2=sprintf("SELECT * FROM col_semanal where idSemanal='%s' ", mysqli_real_escape_string($cnx,$row["idSemanal"]));
		$result2=mysqli_query($cnx,$query2);
		$row2=mysqli_fetch_array($result2);
		mysqli_close($cnx);
		return $row2;
	}

	function obtCodPaises(){
		$cnx = cnx();
		$i=0;
		$pila= array();
		$pila2= array();
		$query=sprintf("SELECT * FROM cod_pais");
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$pila[$i] = $row["idCod_Pais"];
			$pila2[$row["idCod_Pais"]] = $row["Nombre_Pais"];
			//"Jan"=> 1
		}
		mysqli_close($cnx);
		return [$pila,$pila2];
	}

	function verify_time_format($value) {
	  $pattern1 = '/^(0?\d|1\d|2[0-3]):[0-5]\d:[0-5]\d$/';
	  return preg_match($pattern1, $value);
  }


?>

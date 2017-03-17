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
	function GuardarArchivoHorasExtrasPDF($idHorasExtras,$rutaDocumento){
		$cnx=cnx();
		$query=sprintf("INSERT INTO horas_extras_documentos( idHorasExtras, tipoDocumento, rutaDocumento) VALUES ('%s','%s','%s')",
		mysqli_real_escape_string($cnx,$idHorasExtras),
		mysqli_real_escape_string($cnx,"PDF"),
		mysqli_real_escape_string($cnx,$rutaDocumento)
		);
		$estado = mysqli_query($cnx,$query);

		if($estado==1){
			$query = sprintf("UPDATE horas_extras SET  EstadoHorasExternas = '%s' WHERE idHorasExtras = '%s'",
			mysqli_real_escape_string($cnx,"1"),
			mysqli_real_escape_string($cnx,$idHorasExtras)
			);
			$estado = mysqli_query($cnx,$query);
		}
		mysqli_close($cnx);
		return $estado;
	}
	function getFileHorasExtras($idHorasExtras){
		$cnx=cnx();
		$query=sprintf("SELECT rutaDocumento  FROM horas_extras_documentos where idHorasExtras='%s' ",mysqli_real_escape_string($cnx,$idHorasExtras));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		mysqli_close($cnx);
		return $row["rutaDocumento"];
	}


	function DatosHorasExtras($idHorasExtras){
		$cnx=cnx();
		$data['exist']="0";
		$query=sprintf("SELECT * FROM horas_extras where idHorasExtras='%s'",mysqli_real_escape_string($cnx,$idHorasExtras));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$flag=TRUE;
			$data['exist']="1";
			$data['EstadoHorasExternas']=$row["EstadoHorasExternas"];
			$data['Fecha']=$row["Fecha"];
		}

		mysqli_close($cnx);
		return $data;

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
	function obtFromEmployDepart($NumeroDocumento){
		$cnx=cnx();
		$query=sprintf("SELECT departamento.idCod_Municipio FROM empleado INNER JOIN cargos INNER JOIN departamento where empleado.NumeroDocumento='%s' AND empleado.idCargos=cargos.idCargos AND cargos.idDepartamento=departamento.idDepartamento",mysqli_real_escape_string($cnx,$NumeroDocumento));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		return $row["idCod_Municipio"];
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
			if (password_verify($Pass, $row["Pass"])) {
			    $flag=TRUE;
			}
		}
		mysqli_close($cnx);
		return $flag;
	}
	function obtFechadHorasExtras($idHorasExtras){
		$cnx=cnx();
		$query=sprintf("SELECT * FROM horas_extras where idHorasExtras='%s'",mysqli_real_escape_string($cnx,$idHorasExtras));
		$result=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($result);
		mysqli_close($cnx);
		return $row["Fecha"];
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
			$turno->setperiodo_Pago($row["Periodo_Pago"]);
			$turno->setH_MJornada($row["H_MJornada"]);
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
		$query=sprintf("SELECT Salario_Mes from salarios_minimos INNER JOIN departamento ON salarios_minimos.idSalario_Minimo=departamento.idSalario_Minimo INNER JOIN cargos ON departamento.idDepartamento=cargos.idDepartamento WHERE cargos.idCargos='%s'",mysqli_real_escape_string($cnx,$Idcargos));
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
			$departamento->setIdCod_Municipio($row["idCod_Municipio"]);
			$departamento->setCuentacontable($row["CuentaContable"]);
			$departamento->setidSalario_Minimo($row["idSalario_Minimo"]);
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
	function UpdateDepartamento($NombreDepartamento,$CuentaContable,$idSalario_Minimo,$idDepartamento,$idCod_Municipio){
		$cnx=cnx();
		$query = sprintf("UPDATE departamento SET  NombreDepartamento = '%s',idSalario_Minimo = '%s',CuentaContable = '%s',idCod_Municipio = '%s' WHERE idDepartamento = '%s'",
		mysqli_real_escape_string($cnx,$NombreDepartamento),
		mysqli_real_escape_string($cnx,$idSalario_Minimo),
		mysqli_real_escape_string($cnx,$CuentaContable),
		mysqli_real_escape_string($cnx,$idCod_Municipio),
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
function eliminarHoras_extras($IdColHorasExtras){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM col_horas_extras WHERE IdColHorasExtras='%s'",mysqli_real_escape_string($cnx,$IdColHorasExtras));
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
function checkCuentaBanco($NumeroDocuento,$idBanco){
	$cnx=cnx();
	$flag=FALSE;
	$query=sprintf("SELECT * FROM cuentasbanco WHERE NumeroDocumento= '%s' AND idBanco='%s' ",mysqli_real_escape_string($cnx,$NumeroDocuento),mysqli_real_escape_string($cnx,$idBanco));
	$result=mysqli_query($cnx,$query);
	$row=mysqli_fetch_array($result);
	if($row[0]!=""){
		$flag=TRUE;
	}
	mysqli_close($cnx);
	return $flag;
}
	function actualizarUsuario($empleado,$htrabajo,$idBanco,$NumeroCuenta){
		$cnx = cnx();
		if(checkCuentaBanco($empleado->getNumerodocumento(),$idBanco)){
			$NumeroCuentaEncr=encrypt_decrypt('encrypt', $NumeroCuenta);
			$query3 = sprintf("UPDATE cuentasbanco SET NumeroCuenta = '%s' WHERE idBanco ='%s' AND NumeroDocumento = '%s'",
			mysqli_real_escape_string($cnx, $NumeroCuentaEncr),
			mysqli_real_escape_string($cnx, $idBanco),
			mysqli_real_escape_string($cnx, $empleado->getNumerodocumento())
			);
			$estado3 = mysqli_query($cnx, $query3);
		}else{
			$NumeroCuentaEncr=encrypt_decrypt('encrypt', $NumeroCuenta);
			$query3 = sprintf("INSERT INTO cuentasbanco(NumeroDocumento,idBanco,NumeroCuenta) VALUES ('%s','%s','%s')",
				mysqli_real_escape_string($cnx,$empleado->getNumerodocumento()),
				mysqli_real_escape_string($cnx,$idBanco),
				mysqli_real_escape_string($cnx,$NumeroCuentaEncr)
			);
			$estado3 = mysqli_query($cnx, $query3);

		}
		if(strcmp($empleado->getPass(), "")==0){
			$query = sprintf("UPDATE empleado SET idCargos = '%s',  Activo = '%s', Nup = '%s', InstitucionPrevisional = '%s', PrimerNombre = '%s',SegundoNombre = '%s' , PrimerApellido = '%s' , SegundoApellido = '%s' , ApellidoCasada = '%s' , ConocidoPor = '%s' , TipoDocumento = '%s' , NumeroDocumento = '%s' , Nit = '%s' , NumeroIsss = '%s' , NumeroInpep = '%s' , Genero = '%s' , Nacionalidad = '%s' , SalarioNominal = '%s' , FechaNacimiento = '%s' , EstadoCivil = '%s' , Direccion = '%s' , Departamento = '%s' , Municipio = '%s' , NumeroTelefonico = '%s' , CorreoElectronico = '%s' , FechaIngreso = '%s' , FechaRetiro = '%s' , FechaFallecimiento = '%s' WHERE NumeroDocumento = '%s'",
				mysqli_real_escape_string($cnx, $empleado->getIdcargos()),
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
		}else{
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
		}

			$query2 = sprintf("UPDATE htrabajo SET Desde = '%s', Hasta ='%s', idTurno = '%s' WHERE NumeroDocumento = '%s'",
			mysqli_real_escape_string($cnx, $htrabajo->getDesde()),
			mysqli_real_escape_string($cnx, $htrabajo->getHasta()),
			mysqli_real_escape_string($cnx, $htrabajo->getIdturno()),
			mysqli_real_escape_string($cnx, $empleado->getNumerodocumento())
			);
		$estado = mysqli_query($cnx, $query);
		$estado2 = mysqli_query($cnx, $query2);
		$estadoT=$estado+$estado2+$estado3;
		mysqli_close($cnx);
		return $estadoT;

	}
	function agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso,$Periodo_Pago,$H_MJornada){
		$cnx = cnx();
		$query = sprintf("INSERT INTO turno(NitEmpresa,nombreTurno,Desde,Hasta,Descanso,H_Descanso,Periodo_Pago,H_MJornada) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$nombreTurno),
			mysqli_real_escape_string($cnx,$Desde),
			mysqli_real_escape_string($cnx,$Hasta),
			mysqli_real_escape_string($cnx,$Descanso),
			mysqli_real_escape_string($cnx,$H_Descanso),
			mysqli_real_escape_string($cnx,$Periodo_Pago),
			mysqli_real_escape_string($cnx,$H_MJornada)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;

	}

	function AgregarDepartamento($NombreDepartamento,$CuentaContable,$idSalario_Minimo,$NitEmpresa,$idCod_Municipio){
		$cnx = cnx();
		$query = sprintf("INSERT INTO departamento(NitEmpresa,NombreDepartamento,idSalario_Minimo,CuentaContable,idCod_Municipio) VALUES ('%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$NombreDepartamento),
			mysqli_real_escape_string($cnx,$idSalario_Minimo),
			mysqli_real_escape_string($cnx,$CuentaContable),
			mysqli_real_escape_string($cnx,$idCod_Municipio)
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

	function actualizarTurno($idTurno,$nombreTurno,$Desde,$Hasta,$Descanso,$H_Descanso,$Periodo_Pagos,$H_MJornada){
		$cnx = cnx();
		$query = sprintf("UPDATE turno SET nombreTurno = '%s', Desde ='%s', Hasta = '%s', Descanso = '%s', H_Descanso = '%s', Periodo_Pago = '%s', H_MJornada= '%s' WHERE idTurno = '%s'",
			mysqli_real_escape_string($cnx, $nombreTurno),
			mysqli_real_escape_string($cnx, $Desde),
			mysqli_real_escape_string($cnx, $Hasta),
			mysqli_real_escape_string($cnx, $Descanso),
			mysqli_real_escape_string($cnx, $H_Descanso),
		 	mysqli_real_escape_string($cnx, $Periodo_Pagos),
			mysqli_real_escape_string($cnx, $H_MJornada),
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
//ReporteHorasExtras TipoReporte
	function printTipoReporte($year,$month){

	  $days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
		echo "<option value='10'>Mensual</option>";
			//Los value 20 catorcenal
		for($i=0;$i<ceil($days/14);$i++){
			$j=$i+1;
			echo "<option value='2".$j."'>".$j." Catorcena</option>";
		}
			//Los value 30 quincenal
		echo "<option value='31'>1 Quincena</option>";
		echo "<option value='32'>2 Quincena</option>";

		//Los value 40 semanal
		for($i=0;$i<ceil($days/7);$i++){
			$j=$i+1;
			echo "<option value='4".$j."'>".$j." Semana</option>";
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
	function obtPaisDepa($idMunicipio){
		$cnx = cnx();
		$query=sprintf("SELECT cod_pais.idCod_Pais FROM cod_municipio INNER JOIN cod_departamento INNER JOIN cod_pais WHERE cod_municipio.idCod_Municipio='%s' AND cod_municipio.idCod_Departamento=cod_departamento.idCod_Departamento AND cod_departamento.idCod_Pais=cod_pais.idCod_Pais",mysqli_real_escape_string($cnx,$idMunicipio));
		$result=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($result);
		mysqli_close($cnx);
		return $row["idCod_Pais"];
	}

	function obtDepaDepa($idMunicipio){
		$cnx = cnx();
		$query=sprintf("SELECT cod_departamento.idCod_Departamento FROM cod_municipio INNER JOIN cod_departamento WHERE cod_municipio.idCod_Municipio='%s' AND cod_municipio.idCod_Departamento=cod_departamento.idCod_Departamento",mysqli_real_escape_string($cnx,$idMunicipio));
		$result=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($result);
		mysqli_close($cnx);
		return $row["idCod_Departamento"];
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
	function getAllBankAccount(){
		$cnx = cnx();
		$i=0;
		$pila= array();
		$pila2= array();
		$query=sprintf("SELECT * FROM banco");
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$pila[$i] = $row["idBanco"];
			$pila2[$row["idBanco"]] = $row["NombreBanco"];
			//"Jan"=> 1
			$i++;
		}
		mysqli_close($cnx);
		return [$pila,$pila2];

	}
	function getCuentaBanco($NumeroDocumento,$idBanco){
		$cnx = cnx();
		$query=sprintf("SELECT * FROM cuentasbanco  WHERE NumeroDocumento='%s' AND idBanco='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$idBanco));
		$result=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($result);
		if($row[0]!=""){
			$cuenta= encrypt_decrypt('decrypt', $row["NumeroCuenta"]);
			$idBanco=$row["idBanco"];
		}else {
			$cuenta=NULL;
			$idBanco=0;
			}
		mysqli_close($cnx);
		return [$cuenta,$idBanco];

	}
	function encrypt_decrypt($action, $string) {
	    $output = false;

	    $encrypt_method = "AES-256-CBC";
	    $secret_key = 'ASCAS';
	    $secret_iv = 'ASCASiv';

	    // hash
	    $key = hash('sha256', $secret_key);

	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    if( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    }
	    else if( $action == 'decrypt' ){
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }

	    return $output;
	}

?>

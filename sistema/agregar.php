<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';

	$opc=$_POST["opc"];
	switch ($opc) {
		case "1":
			//ya existe ese correo
			if(isUserExist($_POST["email"])){
				echo "0";
			}else{
				$empleado = new empleado_class();
				$empleado->setCorreo($_POST["email"]);
				$empleado->setNombreempleado($_POST["nombre"]);
				$empleado->setDui($_POST["dui"]);
				$empleado->setTelefono($_POST["telefono"]);
				$empleado->setActivo("activo");
				if(insertarEmpleado($empleado)){
					echo "2";
				}else{
					echo "1";
				}
			}
			break;
		case '2':
			# code...
			$flag =0;
			if($_POST["Desde"]>$_POST["Hasta"]){
					echo "3";
					$flag=1;
			}elseif (!(($_POST["descanso"]==0)||($_POST["descanso"]==1))) {
					echo "8";
					$flag=1;
			}

			if($flag==0){
					if(!isset($_POST["NumeroDocumento"])||!isset($_POST["FechaIngreso"])||!isset($_POST["PrimerNombre"])||!isset($_POST["PrimerApellido"])||!isset($_POST["Nit"])||!isset($_POST["NumeroIsss"])||!isset($_POST["SalarioNominal"])){
						echo "0";
					}elseif(!(isset($_POST["Desde"]) || !isset($_POST["Hasta"]))){
							echo "5";
					}elseif(!(verify_time_format($_POST["Desde"]) && verify_time_format($_POST["Hasta"]))){
						echo "4";
					}elseif(!(verify_time_format($_POST["H_Descanso"]))){
						echo "9";
					}else{
						if (!empty($_POST["nCuenta"])) {
							if (!ctype_digit($_POST["nCuenta"])){
								echo "6";//Solo numeros
							}
						}
						if($_POST["changePass"]==1){
							if(empty($_POST["Pass"])){
								echo "7";
							}else{

								$options = [
								  'cost' => 11
								];
								$EncrypPass=password_hash($_POST["Pass"], PASSWORD_BCRYPT, $options);
								$idBanco=$_POST["idBanco"];
								$NumeroCuenta=$_POST["nCuenta"];
								$htrabajo = new htrabajo_class();
								$empleado = new empleado_class();
								$empleado->setNumerodocumento($_POST["NumeroDocumento"]);
								$empleado->setTipodocumento($_POST["TipoDocumento"]);
								$empleado->setIdcargos($_POST["idCargos"]);
								$empleado->setPass($EncrypPass);
								$empleado->setActivo($_POST["Activo"]);
								$empleado->setNup($_POST["Nup"]);
								$empleado->setInstitucionprevisional($_POST["InstitucionPrevisional"]);
								$empleado->setPrimernombre($_POST["PrimerNombre"]);
								$empleado->setSegundonombre($_POST["SegundoNombre"]);
								$empleado->setPrimerapellido($_POST["PrimerApellido"]);
								$empleado->setSegundoapellido($_POST["SegundoApellido"]);
								$empleado->setApellidocasada($_POST["ApellidoCasada"]);
								$empleado->setConocidopor($_POST["ConocidoPor"]);
								$empleado->setNit($_POST["Nit"]);
								$empleado->setNumeroisss($_POST["NumeroIsss"]);
								$empleado->setNumeroinpep($_POST["NumeroInpep"]);
								$empleado->setGenero($_POST["Genero"]);
								$empleado->setNacionalidad($_POST["Nacionalidad"]);
								$empleado->setSalarionominal($_POST["SalarioNominal"]);
								$empleado->setFechanacimiento($_POST["FechaNacimiento"]);
								$empleado->setEstadocivil($_POST["EstadoCivil"]);
								$empleado->setDireccion($_POST["Direccion"]);
								$empleado->setDepartamento($_POST["Departamento"]);
								$empleado->setMunicipio($_POST["Municipio"]);
								$empleado->setNumerotelefonico($_POST["NumeroTelefonico"]);
								$empleado->setCorreoelectronico($_POST["CorreoElectronico"]);
								$empleado->setFechaingreso($_POST["FechaIngreso"]);
								$empleado->setFecharetiro($_POST["FechaRetiro"]);
								$empleado->setFechafallecimiento($_POST["FechaFallecimiento"]);
								$htrabajo->setDesde($_POST["Desde"]);
								$htrabajo->setHasta($_POST["Hasta"]);
								$htrabajo->setIdturno($_POST["idTurno"]);
								if(actualizarUsuario($empleado,$htrabajo,$idBanco,$NumeroCuenta,$_POST["H_Descanso"],$_POST["descanso"])){
									echo "2";
								}else{
									echo "1";
								}

							}
							//y si no quiero modificar la pass??
						}else{
							$idBanco=$_POST["idBanco"];
							$NumeroCuenta=$_POST["nCuenta"];
							$htrabajo = new htrabajo_class();
							$empleado = new empleado_class();
							$empleado->setNumerodocumento($_POST["NumeroDocumento"]);
							$empleado->setTipodocumento($_POST["TipoDocumento"]);
							$empleado->setIdcargos($_POST["idCargos"]);
							$empleado->setPass("");
							$empleado->setActivo($_POST["Activo"]);
							$empleado->setNup($_POST["Nup"]);
							$empleado->setInstitucionprevisional($_POST["InstitucionPrevisional"]);
							$empleado->setPrimernombre($_POST["PrimerNombre"]);
							$empleado->setSegundonombre($_POST["SegundoNombre"]);
							$empleado->setPrimerapellido($_POST["PrimerApellido"]);
							$empleado->setSegundoapellido($_POST["SegundoApellido"]);
							$empleado->setApellidocasada($_POST["ApellidoCasada"]);
							$empleado->setConocidopor($_POST["ConocidoPor"]);
							$empleado->setNit($_POST["Nit"]);
							$empleado->setNumeroisss($_POST["NumeroIsss"]);
							$empleado->setNumeroinpep($_POST["NumeroInpep"]);
							$empleado->setGenero($_POST["Genero"]);
							$empleado->setNacionalidad($_POST["Nacionalidad"]);
							$empleado->setSalarionominal($_POST["SalarioNominal"]);
							$empleado->setFechanacimiento($_POST["FechaNacimiento"]);
							$empleado->setEstadocivil($_POST["EstadoCivil"]);
							$empleado->setDireccion($_POST["Direccion"]);
							$empleado->setDepartamento($_POST["Departamento"]);
							$empleado->setMunicipio($_POST["Municipio"]);
							$empleado->setNumerotelefonico($_POST["NumeroTelefonico"]);
							$empleado->setCorreoelectronico($_POST["CorreoElectronico"]);
							$empleado->setFechaingreso($_POST["FechaIngreso"]);
							$empleado->setFecharetiro($_POST["FechaRetiro"]);
							$empleado->setFechafallecimiento($_POST["FechaFallecimiento"]);
							$htrabajo->setDesde($_POST["Desde"]);
							$htrabajo->setHasta($_POST["Hasta"]);
							$htrabajo->setIdturno($_POST["idTurno"]);
							if(actualizarUsuario($empleado,$htrabajo,$idBanco,$NumeroCuenta,$_POST["H_Descanso"],$_POST["descanso"])){
								echo "2";
							}else{
								echo "1";
							}


						}

					}
				};
			break;
		case '3':
			# code...
			if($_POST["idTurno"]==" "||$_POST["semana"]==" "||$_POST["annio"]==" "||$_POST["NitEmpresa"]==" "||$_POST["idSemanal"]==" "){
				echo "0";
			}else{
				$semana=$_POST["semana"]-1;
				$annio=$_POST["annio"];
				if($semana==0){
					$semana=52;
					$annio=$annio-1;
				}
				$row2=0;
		        $row2=obtToUpdateSemanal($_POST["NitEmpresa"],$semana,$annio,$_POST["idTurno"]);
		        if($row2[0]!=""){
		        	$estado=UpdateSemanal($_POST["idTurno"],$_POST["idSemanal"],$row2["Lunes"],$row2["Martes"],$row2["Miercoles"],$row2["Jueves"],$row2["Viernes"],$row2["Sabado"],$row2["Domingo"]);
		        	if($estado){
		        		echo "2";
		        	}echo "3";
		        }else echo "1";

			}

		break;
		case '4':
			# code...
			if($_POST["rev"]==0){
				//revisar
				$resultado=revisarSemanalConEmpleado($_POST["idTurno"],$_POST["SLunes"],$_POST["SMartes"],$_POST["SMiercoles"],$_POST["SJueves"],$_POST["SViernes"],$_POST["SSabado"],$_POST["SDomingo"]);
				echo $resultado;
			}elseif($_POST["rev"]==1){
						//no revisar
						if($_POST["SLunes"]==" "||$_POST["SMartes"]==" "||$_POST["SMiercoles"]==" "||$_POST["SJueves"]==" "||$_POST["SViernes"]==" "||$_POST["SSabado"]==" "||$_POST["SDomingo"]==" "||$_POST["idSemanal"]==" "){
							echo "0";
						}else{
									$estado=UpdateSemanal($_POST["idTurno"],$_POST["idSemanal"],$_POST["SLunes"],$_POST["SMartes"],$_POST["SMiercoles"],$_POST["SJueves"],$_POST["SViernes"],$_POST["SSabado"],$_POST["SDomingo"]);
									if($estado){
										echo "2";
									}echo "3";
							}
			}else {
				echo "ERROR";
			}

		break;
		case '5':
			if((empty($_POST["NumeroDocumento"]))||(empty($_POST["PrimerNombre"]))||(empty($_POST["PrimerApellido"]))||(empty($_POST["Pass"]))||(empty($_POST["SMensual"]))||(empty($_POST["Desde"]))||(empty($_POST["Hasta"]))){
				echo "0";
			}elseif((empty($_POST["FechaIngreso"]))||($_POST["idTurno"]==0)){
				echo "0";
			}elseif(isUserExist($_POST["NumeroDocumento"])){
				echo "7";
			}elseif($_POST["idCargos"]==0){
				echo "8";
			}elseif($_POST["idTurno"]==0){
				echo "6";
			}elseif (!(($_POST["descanso"]==0)||($_POST["descanso"]==1))) {
				echo "9";
			}elseif(!(isset($_POST["Desde"])) || !isset($_POST["Hasta"])){
					echo "5";
			}elseif(!((verify_time_format($_POST["Desde"]))&&(verify_time_format($_POST["Hasta"]))&&(verify_time_format($_POST["H_Descanso"])))){
				echo "5";
			}elseif($_POST["Desde"]>=$_POST["Hasta"]){
				echo "3";
			}else{
				if(AgregarEmpleado($_POST["Tdocumento"],$_POST["NumeroDocumento"],$_POST["PrimerNombre"],$_POST["PrimerApellido"],$_POST["Pass"],$_POST["SMensual"],$_POST["Desde"],$_POST["Hasta"],$_POST["FechaIngreso"],$_POST["idTurno"],$_POST["activo"],$_POST["idCargos"],$_POST["descanso"],$_POST["H_Descanso"])){
					echo "2";
				}else {
					echo "1";
				}


			}
		break;
		case '6':
			//Departamento
			if(empty($_POST["NombreDepartamento"])||empty($_POST["idSalario_Minimo"])){
				echo "0";
			}elseif(checkNombreDepartamento($_POST["NombreDepartamento"],$_POST["NitEmpresa"])){
				echo "1";
			}elseif(strcmp($_POST["idCod_Municipio"],"0")==0){
        echo "4";
      }else{
				$estado=AgregarDepartamento($_POST["NombreDepartamento"],$_POST["CuentaContable"],$_POST["idSalario_Minimo"],$_POST["NitEmpresa"],$_POST["idCod_Municipio"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		case '7':
			//Cargos
			if(empty($_POST["NombreCargo"])){
				echo "0";
			}elseif(checkNombreCargos($_POST["NombreCargo"],$_POST["idDepartamento"],0)){
				echo "1";
			}else{
				$estado=AgregarCargos($_POST["NombreCargo"],$_POST["Descripcion"],$_POST["idDepartamento"],$_POST["PEmpleado"],$_POST["PPlanilla"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		case '8':
			//Cargos
			if(empty($_POST["NitEmpresa"])||empty($_POST["NombreEmpresa"])){
				echo "0";
			}elseif(checkNombreEmpresa($_POST["NombreEmpresa"])){
				echo "1";
			}else{
				$estado=AgregarCargos($_POST["NombreCargo"],$_POST["Descripcion"],$_POST["idDepartamento"],$_POST["PEmpleado"],$_POST["PPlanilla"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		case '9':
			//Cargos
			if(empty($_POST["TipoIncapacidad"])||empty($_POST["NumeroDocumento"])||empty($_POST["DiaInicio"])||empty($_POST["DiaFin"])||empty($_POST["FechaExpedicion"])){
				echo "0, Ingrese todos los datos";
			}else {
				# code...
				$FechaInicio = str_replace('/', '-', $_POST["DiaInicio"]);
			  $FechaInicio  = date('Y-m-d', strtotime($FechaInicio));
				$FechaFin = str_replace('/', '-', $_POST["DiaFin"]);
			  $FechaFin  = date('Y-m-d', strtotime($FechaFin));
				$FechaExpedicion = str_replace('/', '-', $_POST["FechaExpedicion"]);
			  $FechaExpedicion  = date('Y-m-d', strtotime($FechaExpedicion));
				if(!isUserExist($_POST["NumeroDocumento"])){
					echo "0, El usuario no existe";
				}elseif(!((verify_date_format($FechaInicio))&&(verify_date_format($FechaFin))&&(verify_date_format($FechaExpedicion)))){
					echo "0, El Formato de las fechas es incorrecto";
				}elseif($FechaFin<$FechaInicio){
					echo "0, La Fecha de Inicio no puede ser mayor que la de fin";
				}else {
					$estado=AgregarIncapacidad($_POST["TipoIncapacidad"],$_SESSION["usuario_sesion"]->getNumeroDocumento(),$_POST["NumeroDocumento"],$_POST["NombreClinica"],$_POST["NumeroTelefonoClinica"],$_POST["Doctor"],$FechaInicio,$FechaFin,$FechaExpedicion,$_POST["EstadoComprobacion"]);
					if($estado){
						echo "1, ";
					}else echo "2, ";
				}
			}
		break;
		case '10':
				//Cargos
				if(empty($_POST["TipoAusencia"])||empty($_POST["FechaAusencia"])||empty($_POST["NumeroDocumento"])){
					echo "0, Ingrese todos los datos";
				}else {
					# code...
					$FechaAusencia = str_replace('/', '-', $_POST["FechaAusencia"]);
					$FechaAusencia  = date('Y-m-d', strtotime($FechaAusencia));
					if(!isUserExist($_POST["NumeroDocumento"])){
						echo "0, El usuario no existe";
					}elseif(!((verify_date_format($FechaAusencia)))){
						echo "0, El Formato de las fechas es incorrecto";
					}else {
						$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$_POST["NumeroDocumento"],$FechaAusencia,"00:00:00","00:00:00","2");//2 date,1 hour
						if($checkIsInSemanal==0){
                //No hay semanal
								echo "0, No hay Semanal de este usuario";
              }elseif ($checkIsInSemanal==1) {
                //Si esta todo bien
								$estado=AgregarAusencia($_POST["TipoAusencia"],$_SESSION["usuario_sesion"]->getNumeroDocumento(),$_POST["EstadoAusencia"],$FechaAusencia,$_POST["Observacion"],$_POST["NumeroDocumento"]);
								if($estado){
									echo "1, ";
								}else echo "2, ";
              }elseif ($checkIsInSemanal==2) {
                //No laboro ese dia
								echo "0, El usuario no laboro este dia";
              }else {
                //ERROR
								echo "0,Error verificando semanal";
              }
					}
				}
			break;
			case '11':
					//Cargos
					if(empty($_POST["TipoPermiso"])||empty($_POST["DiaInicio"])||empty($_POST["NumeroDocumento"])){
						echo "0, Ingrese todos los datos";
					}else {
						if ($_POST["TipoPermiso"]==1) {
							//Dias
							$DiaInicio = str_replace('/', '-', $_POST["DiaInicio"]);
							$DiaInicio  = date('Y-m-d', strtotime($DiaInicio));
							$DiaFin = str_replace('/', '-', $_POST["DiaFin"]);
							$DiaFin  = date('Y-m-d', strtotime($DiaFin));
							$HoraInicio = "00:00:00";
							$HoraFin = "00:00:00";
						}elseif ($_POST["TipoPermiso"]==2) {
							//Horas
							$DiaInicio = str_replace('/', '-', $_POST["DiaInicio"]);
							$DiaInicio  = date('Y-m-d', strtotime($DiaInicio));
							$DiaFin="1995-04-19";
							$HoraInicio = $_POST["HoraInicio"].":00";
							$HoraFin = $_POST["HoraFin"].":00";
						}else{
							echo "3,";
							die();
						}
						if(!isUserExist($_POST["NumeroDocumento"])){
							echo "0, El usuario no existe";
						}elseif(!((verify_date_format($DiaInicio))&&(verify_date_format($DiaFin)))){
							echo "0, El Formato de las fechas es incorrecto ejm: 01/01/2000";
						}elseif (!((verify_time_format($HoraInicio))&&(verify_time_format($HoraFin)))) {
							echo "0, El Formato de las Horas es incorrecto ejm: 21:00";
						}elseif (($_POST["TipoPermiso"]==1)&&($DiaInicio>$DiaFin)) {
							//Dias
							echo "0, La fecha de inicio no puede ser mayor";
						}elseif (($_POST["TipoPermiso"]==2)&&($HoraInicio>$HoraFin)) {
							//Horas
							echo "0, La Hora de inicio no puede ser mayor";
						}else {
							$estadoPermiso=0;
							$estado=AgregarPermiso($_POST["TipoPermiso"],$_SESSION["usuario_sesion"]->getNumeroDocumento(),$estadoPermiso,$DiaInicio,$DiaFin,$HoraInicio,$HoraFin,$_POST["Observacion"],$_POST["NumeroDocumento"]);
							if($estado){
								echo "1, ";
							}else echo "2, ";
						}
					}
				break;
		case '12':
					if(!(empty($_POST["Fecha"])||(empty($_POST["TipoSuspension"]))||(empty($_POST["NumeroDocumento"])))){
						if(isUserExist($_POST["NumeroDocumento"])){
							$fecha=$_POST["Fecha"];
							list($dd,$mm,$yyyy) = explode('/',$fecha);
							if (checkdate($mm,$dd,$yyyy)) {
								$fecha = str_replace('/', '-', $fecha);
								$fecha  = date('Y-m-d', strtotime($fecha));
								if(verify_date_format($fecha)){
									if($_POST["TipoSuspension"]!=1){
										echo "2, El tipo de suspension que intenta ingresar es incorrecto";
									}else{
										if(!isAlredySuspended($_POST["NumeroDocumento"],$fecha)){
											$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$_SESSION["usuario_sesion"]->getNumeroDocumento(),$fecha,"00:00:00","00:00:00","2");//2 date,1 hour
											if($checkIsInSemanal==0){
				                //No hay semanal
												echo "2, El usuario no tiene semanal en esta fecha";
				              }elseif ($checkIsInSemanal==1) {
				                //Si esta todo bien
												$estado=AgregarSuspensionEmpleado($_POST["NumeroDocumento"],$_SESSION["usuario_sesion"]->getNumeroDocumento(),$_POST["TipoSuspension"],$fecha,$_POST["Descripcion"]);
												if($estado){
													echo "1, ";
												}else echo "0, ";
				              }elseif ($checkIsInSemanal==2) {
				                //No laboro ese dia
												echo "2, El usuario no labora este dia";
				              }else {
				                //ERROR
												echo "2, Error intentando verificar el semanal";
				              }
											break;
										}else echo "2, El usuario ya se encuentra suspendido";
										break;
									}
									break;
								}echo "2, La fecha no tiene el format correcto";
							}else echo "2, La fecha no existe";
						}else echo "2, El usuario que intenta ingresar no existe";
					}else echo "2, Ingrese todos los datos";
			break;
			case '13':
			//agregar permiso seccional
					//Cargos
					if(empty($_POST["TipoPermiso"])||empty($_POST["DiaInicio"])||empty($_POST["NumeroDocumento"])){
						echo "0, Ingrese todos los datos";
					}else {
						if ($_POST["TipoPermiso"]==1) {
							//Dias
							$DiaInicio = str_replace('/', '-', $_POST["DiaInicio"]);
							$DiaInicio  = date('Y-m-d', strtotime($DiaInicio));
							$HoraInicio = "00:00:00";
							$HoraFin = "00:00:00";
							$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$_POST["NumeroDocumento"],$DiaInicio,$HoraInicio,$HoraFin,"2");//2 date,1 hour
						}elseif ($_POST["TipoPermiso"]==2) {
							//Horas
							$DiaInicio = str_replace('/', '-', $_POST["DiaInicio"]);
							$DiaInicio  = date('Y-m-d', strtotime($DiaInicio));
							$HoraInicio = $_POST["HoraInicio"].":00";
							$HoraFin = $_POST["HoraFin"].":00";
							$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$_POST["NumeroDocumento"],$DiaInicio,$HoraInicio,$HoraFin,"1");//2 date,1 hour
						}else{
							echo "3,";
							die();
						}
						if(!isUserExist($_POST["NumeroDocumento"])){
							echo "0, El usuario no existe";
						}elseif(!((verify_date_format($DiaInicio)))){
							echo "0, El Formato de las fechas es incorrecto ejm: 01/01/2000";
						}elseif (!((verify_time_format($HoraInicio))&&(verify_time_format($HoraFin)))) {
							echo "0, El Formato de las Horas es incorrecto ejm: 21:00";
						}elseif (($_POST["TipoPermiso"]==2)&&($HoraInicio>$HoraFin)) {
							//Horas
							echo "0, La Hora de inicio no puede ser mayor";
						}else {
							if($checkIsInSemanal==0){
								//No hay semanal
								echo "0, El usuario no tiene semanal en esta fecha";
							}elseif ($checkIsInSemanal==1) {
								//Si esta todo bien
								$estadoPermiso=0;
								$estado=AgregarPermisoSeccional($_POST["TipoPermiso"],$_SESSION["usuario_sesion"]->getNumeroDocumento(),$estadoPermiso,$DiaInicio,$HoraInicio,$HoraFin,$_POST["Observacion"],$_POST["NumeroDocumento"]);
								if($estado){
									echo "1, ";
								}else echo "2, ";
							}elseif ($checkIsInSemanal==2) {
								//No laboro ese dia
								echo "0, Es su dia de descanso no se puede agregar";
							}else {
								//ERROR
								echo "0, Error intentando verificar el semanal";
							}
						}
					}
				break;
		case '14':
					if((trim($_POST['FFechaInicio']) == "")||(trim($_POST['FFechaFin']) == "")||(trim($_POST['TTPago']) == "")||(trim($_POST['FFPago']) == "")||(trim($_POST['NDocumentoArray']) == "")){
						header('Location: Pagos_Horas_Extras.php');
						exit();
					}
					$cnx = cnx();
					$AreSomething=0;//Si vamos a mostrar la alerta de que alguien se paso
					$FechaInicio = $_POST["FFechaInicio"];
					$FechaFin = $_POST["FFechaFin"];
					$TPago = $_POST["TTPago"]."0";
					$FPago = $_POST["FFPago"];
					$NitEmpresa=$_SESSION["empresa"];
					$NombrePor = $_POST["nombrePor"];
					$NumeroDocumentoPor=$_POST["NumeroDocumentoPor"];
					date_default_timezone_set('America/El_Salvador');
					$dateTime = date("Y-m-d H:i:s");
					$NDocumentoArray = $_POST["NDocumentoArray"];
					$NDocumentoArray = json_decode("$NDocumentoArray", true);
					//nombrePor
					$str="";
					for($i=0;$i<count($NDocumentoArray);$i++){
						//el valor de los DUI's esta en $NDocumentoArray[$i]
						$empleado=getInfoEmpleado($NDocumentoArray[$i]);
						$data=getIfExtraTimePayMore($FechaInicio,$FechaFin,$empleado->getSalarionominal(),$NDocumentoArray[$i]);
						if($data[0]==1){
							$AreSomething=1;
							for($i=0;$i<count($data[1]);$i++){
								$str=$str.$data[1][$i]["NombreEmpleado"]." tiene un exeso de ".$data[1][$i]["TotaPagar"]." en la semana ".$data[1][$i]["Semana"]."<br>";
							}
						}
					}
					echo $AreSomething." %&$ ".$str;
				break;
		default:
			# code...
			echo "nada";
			break;
	}

?>

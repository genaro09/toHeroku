<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';

	$opc=$_POST["opc"];
	switch ($opc) {
		case "1":
      if(empty($_POST["NombreDepartamento"])||empty($_POST["CuentaContable"])||empty($_POST["idSalario_Minimo"])){
        echo "0";
      }elseif(checkNombreDepartamentoToModf($_POST["NombreDepartamento"],$_POST["NitEmpresa"],$_POST["idDepartamento"])){
        echo "1";
      }elseif(strcmp($_POST["idCod_Municipio"],"0")==0){
        echo "4";
      }else{
        $estado=UpdateDepartamento($_POST["NombreDepartamento"],$_POST["CuentaContable"],$_POST["idSalario_Minimo"],$_POST["idDepartamento"],$_POST["idCod_Municipio"]);
        if($estado){
          echo "2";
        }else echo "3";
      }
		break;
		case "2":
			if(empty($_POST["NombreCargo"])){
				echo "0";
			}elseif(checkNombreCargos($_POST["NombreCargo"],$_POST["idDepartamento"],$_POST["idCargos"])){
				echo "1";
			}else{
				$estado=UpdateCargos($_POST["NombreCargo"],$_POST["Descripcion"],$_POST["idDepartamento"],$_POST["PEmpleado"],$_POST["PPlanilla"],$_POST["idCargos"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		case "3":
			if(empty($_POST["NombreEmpresa"])||empty($_POST["Direccion"])||empty($_POST["Telefono"])||empty($_POST["RepresentanteLegal"])){
				echo "0";
			}elseif(checkNombreEmpresa($_POST["NombreEmpresa"])){
				echo "1";
			}else{
				$estado=UpdateEmpresa($_POST["NombreEmpresa"],$_POST["Direccion"],$_POST["Telefono"],$_POST["Telefono2"],$_POST["NRegistro"],$_POST["Giro"],$_POST["NPatronalSS"],$_POST["NPatronalAFP"],$_POST["RepresentanteLegal"],$_POST["NitEmpresa"],$_POST["TipeRequest"],$_POST["TipoEmpresa"]);
				if($estado){
					echo "2";
				}else echo "3";
			}
		break;
		case '4':
			if(empty($_POST["TipoIncapacidad"])||empty($_POST["idIncapacidad"])||empty($_POST["DiaInicio"])||empty($_POST["DiaFin"])||empty($_POST["FechaExpedicion"])){
				echo "0, Ingrese todos los datos";
			}else {
				# code...
				$FechaInicio = str_replace('/', '-', $_POST["DiaInicio"]);
				$FechaInicio  = date('Y-m-d', strtotime($FechaInicio));
				$FechaFin = str_replace('/', '-', $_POST["DiaFin"]);
				$FechaFin  = date('Y-m-d', strtotime($FechaFin));
				$FechaExpedicion = str_replace('/', '-', $_POST["FechaExpedicion"]);
				$FechaExpedicion  = date('Y-m-d', strtotime($FechaExpedicion));
				if(!isIncapExist($_POST["idIncapacidad"])){
					echo "3, ERROR";
				}elseif(!((verify_date_format($FechaInicio))&&(verify_date_format($FechaFin))&&(verify_date_format($FechaExpedicion)))){
					echo "0, El Formato de las fechas es incorrecto";
				}elseif($FechaFin<$FechaInicio){
					echo "0, La Fecha de Inicio no puede ser mayor que la de fin";
				}else {
					$estado=UpdateIncapacidad($_POST["TipoIncapacidad"],$_POST["idIncapacidad"],$_POST["NombreClinica"],$_POST["NumeroTelefonoClinica"],$_POST["Doctor"],$FechaInicio,$FechaFin,$FechaExpedicion,$_POST["EstadoComprobacion"]);
					if($estado){
						echo "1, ";
					}else echo "2, ";
				}
			}
			break;
			case '5':
				if(empty($_POST["TipoAusencia"])||empty($_POST["FechaAusencia"])||empty($_POST["idAusencia"])){
					echo "0, Ingrese todos los datos";
				}else {
					# code...
					$FechaAusencia = str_replace('/', '-', $_POST["FechaAusencia"]);
					$FechaAusencia  = date('Y-m-d', strtotime($FechaAusencia));
					if(!isAusenExist($_POST["idAusencia"])){
						echo "3, ERROR Ausencia no existe recargue la pagina";
					}elseif(!((verify_date_format($FechaAusencia)))){
						echo "0, El Formato de las fechas es incorrecto";
					}else {
						$AusenciaData=getAusencia($_POST["idAusencia"]);
						$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$AusenciaData["NumeroDocumento"],$FechaAusencia,"00:00:00","00:00:00","2");//2 date,1 hour
						if($checkIsInSemanal==0){
                //No hay semanal
								echo "0, No existe semanal en esta fecha";
              }elseif ($checkIsInSemanal==1) {
                //Si esta todo bien
								$estado=UpdateAusencia($_POST["idAusencia"],$_POST["TipoAusencia"],$_POST["EstadoAusencia"],$FechaAusencia,$_POST["Observacion"]);
								if($estado){
									echo "1, ";
								}else echo "2, ";
              }elseif ($checkIsInSemanal==2) {
                //No laboro ese dia
								echo "0, El empleado no labora este dia";
              }else {
                //ERROR
								echo "0, Error revisando el semanal";
              }
					}
				}
				break;
				case '6':
						if(empty($_POST["TipoPermiso"])||empty($_POST["DiaInicio"])||empty($_POST["idPermiso"])){
							echo "0, Ingrese todos los datos";
						}else if (isPermisoExist($_POST["idPermiso"])){
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
							if(!((verify_date_format($DiaInicio))&&(verify_date_format($DiaFin)))){
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
								$estadoPermiso=1;
								$estado=UpdatePermiso($_POST["TipoPermiso"],$_POST["idPermiso"],$estadoPermiso,$DiaInicio,$DiaFin,$HoraInicio,$HoraFin,$_POST["Observacion"]);
								if($estado){
									echo "1, ";
								}else echo "0, No fue posible conectar con la base de datos ";
							}
						}
					break;
		case '7':
				if (!empty($_POST["idPermiso"])) {
					if(isPermisoExist($_POST["idPermiso"])){
						$estado=ConfirmarPermiso($_POST["idPermiso"]);
						if($estado){
							echo "1, ";
						}else echo "2, ";
					}else{
						echo "0, No existe el permiso";
					}
				}else{
					echo "0,ERROR el Permiso esta vacio";
				}

			break;
			case '8':
				//Confirmar Suspension
				if(!empty($_POST["id"])){
					if(isSuspensionExist($_POST["id"])){
						$estado=ConfirmarSuspension($_POST["id"]);
						if($estado){
							echo "1, ";
						}else echo "0, ";
					}else echo "2";
				}else{
					echo "2";
				}
				break;
			case '9':
						if(empty($_POST["TipoPermisoSeccional"])||empty($_POST["Fecha"])||empty($_POST["idPermisoSeccional"])){
							echo "0, Ingrese todos los datos";
						}else if (isPermisoSeccionalExist($_POST["idPermisoSeccional"])){
							$PermisoSeccionData=getPermisoSeccional($_POST["idPermisoSeccional"]);
							if ($_POST["TipoPermisoSeccional"]==1) {
								//Dias
								$DiaInicio = str_replace('/', '-', $_POST["Fecha"]);
								$DiaInicio  = date('Y-m-d', strtotime($DiaInicio));
								$HoraInicio = "00:00:00";
								$HoraFin = "00:00:00";
								$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$PermisoSeccionData["NumeroDocumento"],$DiaInicio,$HoraInicio,$HoraFin,"2");//2 date,1 hour
							}elseif ($_POST["TipoPermisoSeccional"]==2) {
								//Horas
								$DiaInicio = str_replace('/', '-', $_POST["Fecha"]);
								$DiaInicio  = date('Y-m-d', strtotime($DiaInicio));
								$HoraInicio = $_POST["HoraInicio"].":00";
								$HoraFin = $_POST["HoraFin"].":00";
								$checkIsInSemanal=checkIsInSemanal($_SESSION["empresa"],$PermisoSeccionData["NumeroDocumento"],$DiaInicio,$HoraInicio,$HoraFin,"1");//2 date,1 hour
							}else{
								echo "3,";
								die();
							}
							if(!((verify_date_format($DiaInicio)))){
								echo "0, El Formato de las fechas es incorrecto ejm: 01/01/2000";
							}elseif (!((verify_time_format($HoraInicio))&&(verify_time_format($HoraFin)))) {
								echo "0, El Formato de las Horas es incorrecto ejm: 21:00";
							}elseif (($_POST["TipoPermisoSeccional"]==2)&&($HoraInicio>$HoraFin)) {
								//Horas
								echo "0, La Hora de inicio no puede ser mayor";
							}else {
								if($checkIsInSemanal==0){
									//No hay semanal
									echo "0, No hay semanal en esta fecha";
								}elseif ($checkIsInSemanal==1) {
									//Si esta todo bien
									$estado=UpdatePermisoSeccional($_POST["idPermisoSeccional"],$_POST["TipoPermisoSeccional"],$DiaInicio,$HoraInicio,$HoraFin,$_POST["Observacion"]);
									if($estado){
										echo "1, ";
									}else echo "0, No fue posible conectar con la base de datos ";
								}elseif ($checkIsInSemanal==2) {
									//No laboro ese dia
									echo "0, Este dia no labora el empleado";
								}else {
									//ERROR
									echo "0, Error intentando revisar semanal";
								}
								// orden $idPermisoSeccional,$TipoPermisoSeccional,$Dia,$HoraInicio,$HoraFin,$Observacion)
							}
						}else{
							echo "0, Permiso seccional no existe, recargue la pagina";
						}
		break;
		default:
			# code...
			echo "nada";
	  break;
	}

?>

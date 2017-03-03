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
			$flag=0;
			if($_POST["Desde"]>$_POST["Hasta"]){
				if($_POST["Desde"]<"16:00:00"){
					echo "3";
					$flag=1;
				}
			}
			if($flag==0){
					if(!isset($_POST["NumeroDocumento"])||!isset($_POST["FechaIngreso"])||!isset($_POST["Pass"])||!isset($_POST["PrimerNombre"])||!isset($_POST["PrimerApellido"])||!isset($_POST["Nit"])||!isset($_POST["NumeroIsss"])||!isset($_POST["SalarioNominal"])){
						echo "0";
					}elseif(!(isset($_POST["Desde"]) || !isset($_POST["Hasta"]))){
							echo "5";
					}elseif(!(verify_time_format($_POST["Desde"]) && verify_time_format($_POST["Hasta"]))){
						echo "4";
					}else{
						$htrabajo = new htrabajo_class();
						$empleado = new empleado_class();
						$empleado->setNumerodocumento($_POST["NumeroDocumento"]);
						$empleado->setTipodocumento($_POST["TipoDocumento"]);
						$empleado->setIdcargos($_POST["idCargos"]);
						$empleado->setPass($_POST["Pass"]);
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
						if(actualizarUsuario($empleado,$htrabajo)){
							echo "2";
						}else{
							echo "1";
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
		        	$estado=UpdateSemanal($_POST["idSemanal"],$row2["Lunes"],$row2["Martes"],$row2["Miercoles"],$row2["Jueves"],$row2["Viernes"],$row2["Sabado"],$row2["Domingo"]);
		        	if($estado){
		        		echo "2";
		        	}echo "3";
		        }else echo "1";

			}

		break;
		case '4':
			# code...
			if($_POST["SLunes"]==" "||$_POST["SMartes"]==" "||$_POST["SMiercoles"]==" "||$_POST["SJueves"]==" "||$_POST["idSemanal"]==" "){
				echo "0";
			}else{
		        $estado=UpdateSemanal($_POST["idSemanal"],$_POST["SLunes"],$_POST["SMartes"],$_POST["SMiercoles"],$_POST["SJueves"],$_POST["SViernes"],$_POST["SSabado"],$_POST["SDomingo"]);
		        if($estado){
		        	echo "2";
		        }echo "3";
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
			}elseif(!(isset($_POST["Desde"])) || !isset($_POST["Hasta"])){
					echo "5";
			}elseif($_POST["Desde"]>=$_POST["Hasta"]){
				echo "3";
			}else{
				if(AgregarEmpleado($_POST["Tdocumento"],$_POST["NumeroDocumento"],$_POST["PrimerNombre"],$_POST["PrimerApellido"],$_POST["Pass"],$_POST["SMensual"],$_POST["Desde"],$_POST["Hasta"],$_POST["FechaIngreso"],$_POST["idTurno"],$_POST["activo"],$_POST["idCargos"])){
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
			}else{
				$estado=AgregarDepartamento($_POST["NombreDepartamento"],$_POST["CuentaContable"],$_POST["idSalario_Minimo"],$_POST["NitEmpresa"]);
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
		default:
			# code...
			echo "nada";
			break;
	}

?>

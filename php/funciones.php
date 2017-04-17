<?php
	include_once 'cn.php';
	include_once 'include_classes.php';
	function estadoCnx(){
		return pruebaCnx();
	}
	function checkIsInSemanal($NitEmpresa,$NumeroDocumento,$Fecha,$HoraIni,$HoraFin,$HoD){
		//The Hours Format 00:00:00
		//The dates format 1995-04-19
		$date = new DateTime($Fecha);
	  $week = $date->format("W");
		$year = $date->format("Y");
		$day = (string)date("D",strtotime($Fecha));//Sun,Mon,Tue,Wed,Thu,Fri,Sat, with strcmp
		$DaysOfWeek=["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
		$val=-1;
		for ($i=0; $i <sizeof($DaysOfWeek) ; $i++) {
			if (strcmp($day,$DaysOfWeek[$i])==0) {
				$val=$i;
			}
		}
		if ($val<0) {
			$flag=3;//ERROR
		}else{
			$flag=5;//Just Default value
		}
		if($flag!=3){
			$DiasDeLaSemana=["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
			$cnx=cnx();
			$queryAux=sprintf("SELECT semanal.*, col_semanal.*, htrabajo.Desde, htrabajo.Hasta FROM semanal inner JOIN col_semanal INNER JOIN htrabajo WHERE semanal.NitEmpresa='%s' AND semanal.nSemana='%s' AND semanal.anno='%s' AND semanal.idSemanal=col_semanal.idSemanal AND col_semanal.NumeroDocumento='%s' AND htrabajo.NumeroDocumento='%s'",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$week),
			mysqli_real_escape_string($cnx,$year),
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$NumeroDocumento));
			$resulAux=mysqli_query($cnx,$queryAux);
			$row=mysqli_fetch_array($resulAux);
			if($row[0]=="") $flag=0;//No hay semanal
			if ($flag!=0) {
				if($HoD==1){
					//check Horas
					if ($row[$DiasDeLaSemana[$val]]==3) {
						//su dia de descanso
						$flag=2;
					}else{
						//Ese dia trabaja hay que ver a que horas
						if (($row["Desde"]<=$HoraIni)&&($row["Hasta"]>=$HoraFin)) {
							$flag=1;
						}else {
							$flag=2;
						}
						$flag=1;
					}
				}elseif ($HoD==2) {
					//check only Date
					if ($row[$DiasDeLaSemana[$val]]==3) {
						//su dia de descanso
						$flag=2;
					}else{
						//Ese dia trabaja
						$flag=1;
					}
				}else{
					$flag=3;
				}
			}
			mysqli_close($cnx);
		}
		return $flag;//0 No hay semanal, 1 la hora o fecha si esta en el semanal, 2 no labora, 3 ERROR
	}
	function checkPagoHorasExtras($FechaIni,$FechaFin,$tipoPago,$formaPago,$NitEmpresa){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM pagos_horas_extras where FechaIni='%s' AND FechaFin='%s'AND tipoPago='%s'AND formaPago='%s' AND NitEmpresa='%s'",mysqli_real_escape_string($cnx,$FechaIni),mysqli_real_escape_string($cnx,$FechaFin),mysqli_real_escape_string($cnx,$tipoPago),mysqli_real_escape_string($cnx,$formaPago),mysqli_real_escape_string($cnx,$NitEmpresa));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function ckeckCierreHorasExtras($mes,$annio,$NitEmpresa,$tipoPago){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM cierre_horas_extras where Mes='%s' AND  tipoPago='%s' AND NitEmpresa	='%s'",mysqli_real_escape_string($cnx,$FechaIni),mysqli_real_escape_string($cnx,$FechaFin),mysqli_real_escape_string($cnx,$tipoPago),mysqli_real_escape_string($cnx,$formaPago),mysqli_real_escape_string($cnx,$NitEmpresa));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function getPagosHorasExtras($FechaIni,$FechaFin,$tipoPago,$formaPago,$NitEmpresa){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM pagos_horas_extras where FechaIni='%s' AND FechaFin='%s'AND tipoPago='%s'AND formaPago='%s' AND NitEmpresa='%s'",mysqli_real_escape_string($cnx,$FechaIni),mysqli_real_escape_string($cnx,$FechaFin),mysqli_real_escape_string($cnx,$tipoPago),mysqli_real_escape_string($cnx,$formaPago),mysqli_real_escape_string($cnx,$NitEmpresa));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		$PagoHorasExtras = array('idPagos_Horas_Extras' => $row["idPagos_Horas_Extras"],'NumeroDocumentoPor' => $row["NumeroDocumentoPor"],'FechaCreacion' => $row["FechaCreacion"],'NombrePor' => $row["NombrePor"]);
		mysqli_close($cnx);
		return $PagoHorasExtras;
	}
	function isLlegadasTardeExist($idLlegadasTarde){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM llegadas_tarde where idLlegadasTarde='%s'",mysqli_real_escape_string($cnx,$idLlegadasTarde));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;

	}
	function workTime($NumeroDocumento){
			$cnx=cnx();
			$query=sprintf("SELECT htrabajo.Desde,htrabajo.Hasta,htrabajo.H_Descanso FROM htrabajo WHERE htrabajo.NumeroDocumento ='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento));
			$resul=mysqli_query($cnx,$query);
			$row=mysqli_fetch_array($resul);
			mysqli_close($cnx);
			return [$row["Desde"],$row["Hasta"],$row["H_Descanso"]];
	}

	function HalfTime($time){
		$time_array = explode(':',$time);
		$hours = (int)$time_array[0];
		$minutes = (int)$time_array[1];
		$seconds = (int)$time_array[2];
		$total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
		$average = floor($total_seconds/2);
		$hours = floor($average / 3600);
		$mins = floor($average / 60 % 60);
		$secs = floor($average % 60);
		$timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
		return $timeFormat;
	}

	function DiscountsTimeEmploy($Desde,$Hasta,$NumeroDocumento){
		$workTime=workTime($NumeroDocumento);
		$TiempoCompleto=gmdate("H:i:s", (int)subsTwoTimes(gmdate("H:i:s", (int)subsTwoTimes($workTime[1],$workTime[0])),$workTime[2]));
		$MedioTiempo=HalfTime($TiempoCompleto);
		$Fin= new DateTime($Hasta);
		$Fin =$Fin->modify( '+1 day' );
		$daterange = new DatePeriod(
     new DateTime($Desde),
     new DateInterval('P1D'),
     $Fin
	 	);
		 //AddArrTime($time);  <-Array
		 $str="";
		 $body="";
		 $cnx=cnx();
		 $TotTimeToSubstrack="00:00:00";//el total entre fechas
		 foreach($daterange as $date){
			$AusenciaTotTime="00:00:00";
			$LlegadasTardeTotTime="00:00:00";
			$IncapacidadTotTime="00:00:00";
			$Permiso="00:00:00";
			$PermisoSeccional="00:00:00";
			$Suspension="00:00:00";
			$str="";
			//vamos fecha por fecha
			$Fecha=$date->format("Y-m-d");
		 	$date = new DateTime($Fecha);
		 	$week = $date->format("W");
		 	$year = $date->format("Y");
			$semanal=getSemanal($week,$year,$NumeroDocumento);
		  $day = (string)date("D",strtotime($Fecha));//Sun,Mon,Tue,Wed,Thu,Fri,Sat, with strcmp
			$DaysOfWeek=["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
			$val=-1;
		 	for ($i=0; $i <sizeof($DaysOfWeek) ; $i++) {
				if (strcmp($day,$DaysOfWeek[$i])==0) {
		 			$val=$i;
		 		}
		 	}
		 	$DiasDeLaSemana=["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo"];
			if($val<0){
				//Hubo un error
			}else{
				//Si existe ese semanal puede que encontremos algo
				if($semanal["exist"]==1){
					$TheDayisGone=0;//if substract all the day
					$DayTime="00:00:00";//How many substract of the day
					if($semanal[$DiasDeLaSemana[$val]]==1){
						$MaxThisDayTime=$TiempoCompleto;
					}elseif ($semanal[$DiasDeLaSemana[$val]]==2) {
						$MaxThisDayTime=$MedioTiempo;
					}else{
						$MaxThisDayTime="00:00:00";
					}

	 				//Ausencia es de todo un dia
				  $query=sprintf("SELECT * FROM ausencia WHERE FechaAusencia='%s' AND EstadoAusencia=1 AND NumeroDocumento='%s'",
					mysqli_real_escape_string($cnx,$Fecha),
					mysqli_real_escape_string($cnx,$NumeroDocumento));
			 	  $result=mysqli_query($cnx,$query);
			 	  while ($row=mysqli_fetch_array($result)) {
						$TheDayisGone=1;//if substract all the day
						$DayTime=$MaxThisDayTime;//How many substract of the day
						$str="Ausencia <br>".$str;
				  }

					//Llegadas Tarde
					if($TheDayisGone==0){
						$query=sprintf("SELECT * FROM col_llegadas_tarde INNER JOIN llegadas_tarde WHERE col_llegadas_tarde.NumeroDocumento='%s' AND col_llegadas_tarde.idLlegadasTarde=llegadas_tarde.idLlegadasTarde and llegadas_tarde.Fecha='%s'",
						mysqli_real_escape_string($cnx,$NumeroDocumento),
						mysqli_real_escape_string($cnx,$Fecha));
				 	  $result=mysqli_query($cnx,$query);
				 	  while ($row=mysqli_fetch_array($result)) {
							$LlegadasTardeTotTime=AddArrTime([$row["Tiempo"],$LlegadasTardeTotTime]);
							$str="Llegada Tarde <br>".$str;
					  }
					}
	 			 	//Incapacidad
					if($TheDayisGone==0){
						$query=sprintf("SELECT * FROM incapacidad WHERE NumeroDocumento='%s' AND '%s'>=DiaInicio AND '%s'<=DiaFin",
						mysqli_real_escape_string($cnx,$NumeroDocumento),
						mysqli_real_escape_string($cnx,$Fecha),
						mysqli_real_escape_string($cnx,$Fecha));
				 	  $result=mysqli_query($cnx,$query);
				 	  while ($row=mysqli_fetch_array($result)) {
							$TheDayisGone=1;//if substract all the day
							$DayTime=$MaxThisDayTime;//How many substract of the day
							$str= "Incapacidad <br>".$str;
					  }
					}
	 			 	//Permiso
					if($TheDayisGone==0){
						//Si es todo el dia
							$query=sprintf("SELECT * FROM `permiso` WHERE TipoPermiso=1 AND NumeroDocumento='%s' AND'%s'>=DiaInicio AND '%s'<=DiaFin",
							mysqli_real_escape_string($cnx,$NumeroDocumento),
							mysqli_real_escape_string($cnx,$Fecha),
							mysqli_real_escape_string($cnx,$Fecha));
					 	  $result=mysqli_query($cnx,$query);
					 	  while ($row=mysqli_fetch_array($result)) {
								$TheDayisGone=1;//if substract all the day
								$DayTime=$MaxThisDayTime;//How many substract of the day
								$str="PERMISO <br>".$str;
						  }
						//Si es solo un Tiempo
							$query=sprintf("SELECT * FROM `permiso` WHERE TipoPermiso=2 AND NumeroDocumento='%s' AND DiaInicio='%s'",
							mysqli_real_escape_string($cnx,$NumeroDocumento),
							mysqli_real_escape_string($cnx,$Fecha));
							$result=mysqli_query($cnx,$query);
							while ($row=mysqli_fetch_array($result)) {
								$HoraIni=$row["HoraInicio"];
								$HoraIni=explode(":",$HoraIni);
								$HoraIni=$HoraIni[0].":".$HoraIni[1];
								$HoraFin=$row["HoraFin"];
								$HoraFin=explode(":",$HoraFin);
								$HoraFin=$HoraFin[0].":".$HoraFin[1];
								$Permiso=AddArrTime([gmdate("H:i:s", (int)subsTwoTimes($HoraIni,$HoraFin)),$Permiso]);
								$str= "PERMISO tiempo <br>".$str;
							}
					}

	 			 	//Permiso seccional
						if($TheDayisGone==0){
							//Si es todo el dia
								$query=sprintf("SELECT * FROM `permiso_seccional` WHERE TipoPermisoSeccional=1 AND NumeroDocumento='%s' AND Dia='%s'",
								mysqli_real_escape_string($cnx,$NumeroDocumento),
								mysqli_real_escape_string($cnx,$Fecha));
								$result=mysqli_query($cnx,$query);
								while ($row=mysqli_fetch_array($result)) {
									$TheDayisGone=1;//if substract all the day
									$DayTime=$MaxThisDayTime;//How many substract of the day
									$str= "PERMISO Seccional <br>".$str;
								}
							//Si es solo un Tiempo
								$query=sprintf("SELECT * FROM `permiso_seccional` WHERE TipoPermisoSeccional=2 AND NumeroDocumento='%s' AND Dia='%s'",
								mysqli_real_escape_string($cnx,$NumeroDocumento),
								mysqli_real_escape_string($cnx,$Fecha));
								$result=mysqli_query($cnx,$query);
								while ($row=mysqli_fetch_array($result)) {
									$HoraIni=$row["HoraInicio"];
									$HoraIni=explode(":",$HoraIni);
									$HoraIni=$HoraIni[0].":".$HoraIni[1];
									$HoraFin=$row["HoraFin"];
									$HoraFin=explode(":",$HoraFin);
									$HoraFin=$HoraFin[0].":".$HoraFin[1];
									$PermisoSeccional=AddArrTime([gmdate("H:i:s", (int)subsTwoTimes($HoraIni,$HoraFin)),$PermisoSeccional]);
									$str= "PERMISO Seccional Tiempo <br>".$str;
								}
						}

	 			 	//Suspension
					if($TheDayisGone==0){
						$query=sprintf("SELECT * FROM `suspension` WHERE NumeroDocumento='%s' AND Fecha='%s'",
						mysqli_real_escape_string($cnx,$NumeroDocumento),
						mysqli_real_escape_string($cnx,$Fecha));
						$result=mysqli_query($cnx,$query);
						while ($row=mysqli_fetch_array($result)) {
							$TheDayisGone=1;//if substract all the day
							$DayTime=$MaxThisDayTime;//How many substract of the day
							$str= "Suspension <br>".$str;
						}
					}
					$AusenciaTotTime=AddArrTime([$LlegadasTardeTotTime,$IncapacidadTotTime,$Permiso,$PermisoSeccional,$Suspension]);
					if($AusenciaTotTime>=$MaxThisDayTime){
						$TheDayisGone=1;
					}
					if($TheDayisGone==1){
						$TotTimeToSubstrack=AddArrTime([$MaxThisDayTime,$TotTimeToSubstrack]);
					}else{
						$TotTimeToSubstrack=AddArrTime([$AusenciaTotTime,$TotTimeToSubstrack]);
					}
					$body= $body."El dia ".$DiasDeLaSemana[$val]." ".$Fecha." Trabaja? ".$semanal[$DiasDeLaSemana[$val]]." se tienen los descuentos de:<br>".$str."con un total de ".$TotTimeToSubstrack."<br>";
				}
			}
		}

		//echo $body;
		//echo "Total:".$TotTimeToSubstrack;
		mysqli_close($cnx);
		return $TotTimeToSubstrack;
	}

	function getReporteSuspensionEmpleado($NitEmpresa){
		$cnx=cnx();
		$query=sprintf("SELECT empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado INNER JOIN cargos INNER JOIN departamento INNER JOIN empresa WHERE empresa.NitEmpresa=departamento.NitEmpresa AND departamento.idDepartamento= cargos.idDepartamento AND cargos.idCargos=empleado.idCargos and empresa.NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$NombreCompleto="".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
				echo "<tr>
					 <td>".$row["NumeroDocumento"]."</td>
					 <td>".$NombreCompleto."</td>
					 <td class='text-right'>
						 <div class='col-md-12'>
							 <form method='post' action='Reporte_Suspension_Empleados.php'>
								 <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
								 <input type='submit' style='background: url(../img/icons/assignment.png);border: 0;' value='   '>
							 </form>
						 </div>
					 </td>
				 </tr>";

		}
		mysqli_close($cnx);
	}
	function getReporteLlegadasTardeEmpleado($NitEmpresa){
		$cnx=cnx();
		$query=sprintf("SELECT empleado.NumeroDocumento, empleado.PrimerNombre, empleado.SegundoNombre, empleado.PrimerApellido, empleado.SegundoApellido FROM empleado INNER JOIN cargos INNER JOIN departamento INNER JOIN empresa WHERE empresa.NitEmpresa=departamento.NitEmpresa AND departamento.idDepartamento= cargos.idDepartamento AND cargos.idCargos=empleado.idCargos and empresa.NitEmpresa='%s'",mysqli_real_escape_string($cnx,$NitEmpresa));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$NombreCompleto="".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
				echo "<tr>
					 <td>".$row["NumeroDocumento"]."</td>
					 <td>".$NombreCompleto."</td>
					 <td class='text-right'>
						 <div class='col-md-12'>
							 <form method='post' action='Reporte_Llegadas_Tarde_Empleados.php'>
								 <input type='hidden' name='numDoc' value='".$row["NumeroDocumento"]."'>
								 <input type='submit' style='background: url(../img/icons/assignment.png);border: 0;' value='   '>
							 </form>
						 </div>
					 </td>
				 </tr>";

		}
		mysqli_close($cnx);
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
	function GuardarColPagosHorasExtras($idPago_HorasExtras,$NIT,$NumeroDocumento,$Nombre,$MontoLiquido,$ISS,$AFP,$Renta,$CuentaBanco){
		$cnx=cnx();
		$query=sprintf("INSERT INTO col_pago_horas_extras(idPago_HorasExtras, NIT, NumeroDocumento,Nombre,MontoLiquido,ISS,AFP,Renta,CuentaBanco) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
		mysqli_real_escape_string($cnx,$idPago_HorasExtras),
		mysqli_real_escape_string($cnx,$NIT),
		mysqli_real_escape_string($cnx,$NumeroDocumento),
		mysqli_real_escape_string($cnx,$Nombre),
		mysqli_real_escape_string($cnx,$MontoLiquido),
		mysqli_real_escape_string($cnx,$ISS),
		mysqli_real_escape_string($cnx,$AFP),
		mysqli_real_escape_string($cnx,$Renta),
		mysqli_real_escape_string($cnx,$CuentaBanco)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function GuardarPagosHorasExtras($idPagos_Horas_Extras,$NitEmpresa, $NumeroDocumentoPor,$NombrePor,$FechaCreacion,$Descripcion,$tipoPago,$formaPago,$idBanco,$estadoPago,$FechaIni,$FechaFin){
		$cnx=cnx();
		$query=sprintf("INSERT INTO pagos_horas_extras( idPagos_Horas_Extras, NitEmpresa, NumeroDocumentoPor,NombrePor,FechaCreacion,Descripcion,tipoPago,formaPago,idBanco,estadoPago,FechaIni,FechaFin) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
		mysqli_real_escape_string($cnx,$idPagos_Horas_Extras),
		mysqli_real_escape_string($cnx,$NitEmpresa),
		mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
		mysqli_real_escape_string($cnx,$NombrePor),
		mysqli_real_escape_string($cnx,$FechaCreacion),
		mysqli_real_escape_string($cnx,$Descripcion),
		mysqli_real_escape_string($cnx,$tipoPago),
		mysqli_real_escape_string($cnx,$formaPago),
		mysqli_real_escape_string($cnx,$idBanco),
		mysqli_real_escape_string($cnx,$estadoPago),
		mysqli_real_escape_string($cnx,$FechaIni),
		mysqli_real_escape_string($cnx,$FechaFin)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}

	function getFileHorasExtras($idHorasExtras){
		$cnx=cnx();
		$query=sprintf("SELECT *  FROM horas_extras_documentos where idHorasExtras='%s' ",mysqli_real_escape_string($cnx,$idHorasExtras));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		mysqli_close($cnx);
		return [$row["tipoDocumento"],$row["rutaDocumento"]];
	}
	function getFileAusencias($idAusencia){
		$cnx=cnx();
		$query=sprintf("SELECT *  FROM ausencia_documentos where idAusencia='%s' ",mysqli_real_escape_string($cnx,$idAusencia));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		mysqli_close($cnx);
		return [$row["tipoDocumento"],$row["rutaDocumento"]];
	}
	function getFileIncapacidades($idIncapacidad){
		$cnx=cnx();
		$query=sprintf("SELECT *  FROM incapacidad_documentos where idIncapacidad='%s' ",mysqli_real_escape_string($cnx,$idIncapacidad));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		mysqli_close($cnx);
		return [$row["tipoDocumento"],$row["rutaDocumento"]];
	}
	function getFilePermisoSeccional($idPermisoSeccional){
		$cnx=cnx();
		$query=sprintf("SELECT *  FROM permiso_seccional_documentos where idPermisoSeccional='%s' ",mysqli_real_escape_string($cnx,$idPermisoSeccional));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		mysqli_close($cnx);
		return [$row["tipoDocumento"],$row["rutaDocumento"]];
	}
	function getSemanal($week,$year,$NumeroDocumento){
		$cnx=cnx();
		$data = array();
		$data['exist']="0";
		$query=sprintf("SELECT col_semanal.* FROM col_semanal INNER JOIN semanal WHERE col_semanal.NumeroDocumento='%s' AND col_semanal.idSemanal=semanal.idSemanal AND semanal.nSemana='%s' AND semanal.anno='%s'",
		mysqli_real_escape_string($cnx,$NumeroDocumento),
		mysqli_real_escape_string($cnx,$week),
		mysqli_real_escape_string($cnx,$year));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$data['exist']="1";
			$data['Lunes']=$row["Lunes"];
			$data['Martes']=$row["Martes"];
			$data['Miercoles']=$row["Miercoles"];
			$data['Jueves']=$row["Jueves"];
			$data['Viernes']=$row["Viernes"];
			$data['Sabado']=$row["Sabado"];
			$data['Domingo']=$row["Domingo"];
		}
		mysqli_close($cnx);
		return $data;
	}
	function getReporteLlegadasTarde($idLlegadasTarde){
		$cnx=cnx();
		$data = array();
		$data['exist']="0";
		$query=sprintf("SELECT * FROM llegadas_tarde  where idLlegadasTarde='%s'",mysqli_real_escape_string($cnx,$idLlegadasTarde));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$data['exist']="1";
			$data['NitEmpresa']=$row["NitEmpresa"];
			$data['Fecha']=$row["Fecha"];
			$data['EstadoLlegadasTarde']=$row["EstadoLlegadasTarde"];
		}
		mysqli_close($cnx);
		return $data;
	}
	function isSemanalHaveSomething($semana,$annio,$NitEmpresa,$idTurno){
		$cnx=cnx();
		$week_array = getStartAndEndDate($semana,$annio);
		$HaveExtraHours=0;
		$strExtraHours="";
		$HaveAbsence=0;
		$strAbsence="";
		$HaveSuspension=0;
		$strSuspension="";
		$HaveSeccionAbsence=0;
		$strSeccionAbsence="";
		foreach($week_array as $key => $value){
			//$value tiene la fecha u $key tiene el dia(Lunes, Martes, etc)
			//Horas extras

			$query=sprintf("SELECT horas_extras.idHorasExtras,horas_extras.Fecha,col_horas_extras.IdColHorasExtras ,col_horas_extras.NHorasDiurnas,col_horas_extras.NHorasNocturnas,empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido FROM htrabajo INNER JOIN col_horas_extras INNER JOIN horas_extras INNER JOIN empleado WHERE htrabajo.idTurno='%s' AND col_horas_extras.NumeroDocumentoPara=htrabajo.NumeroDocumento AND col_horas_extras.idHorasExtras=horas_extras.idHorasExtras AND horas_extras.Fecha='%s' AND htrabajo.NumeroDocumento=empleado.NumeroDocumento",
			mysqli_real_escape_string($cnx,(string)$idTurno)
			,mysqli_real_escape_string($cnx,(string)$value));
			$result=mysqli_query($cnx,$query);
			while ($row=mysqli_fetch_array($result)) {
				$HaveExtraHours=1;
				$strExtraHours=$strExtraHours."<a>".$key." ".$value." ".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]." Diurnas:".$row["NHorasDiurnas"]." Nocturnas:".$row["NHorasNocturnas"]." </a><br>";
			}

			//Ausencias
			$query=sprintf("SELECT ausencia.*,empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido FROM htrabajo INNER JOIN ausencia INNER JOIN empleado WHERE htrabajo.idTurno='%s' AND ausencia.NumeroDocumento=htrabajo.NumeroDocumento AND ausencia.FechaAusencia='%s' AND htrabajo.NumeroDocumento=empleado.NumeroDocumento",
			mysqli_real_escape_string($cnx,(string)$idTurno)
			,mysqli_real_escape_string($cnx,(string)$value));
			$result=mysqli_query($cnx,$query);
			while ($row=mysqli_fetch_array($result)) {
				$HaveAbsence=1;
				$strAbsence=$strAbsence."<a>".$key." ".$value." ".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]."</a><br>";
			}

			//suspension
			$query=sprintf("SELECT suspension.*,empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido FROM htrabajo INNER JOIN suspension INNER JOIN empleado WHERE htrabajo.idTurno='%s' AND suspension.NumeroDocumento=htrabajo.NumeroDocumento AND suspension.Fecha='%s' AND htrabajo.NumeroDocumento=empleado.NumeroDocumento",
			mysqli_real_escape_string($cnx,(string)$idTurno)
			,mysqli_real_escape_string($cnx,(string)$value));
			$result=mysqli_query($cnx,$query);
			while ($row=mysqli_fetch_array($result)) {
				$HaveSuspension=1;
				$strSuspension=$strSuspension."<a>".$key." ".$value." ".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]."</a><br>";
			}

			//permiso Seccional
			$query=sprintf("SELECT permiso_seccional.*,empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido FROM htrabajo INNER JOIN permiso_seccional INNER JOIN empleado WHERE htrabajo.idTurno='%s' AND permiso_seccional.NumeroDocumento=htrabajo.NumeroDocumento AND permiso_seccional.Dia='%s' AND htrabajo.NumeroDocumento=empleado.NumeroDocumento",
			mysqli_real_escape_string($cnx,(string)$idTurno)
			,mysqli_real_escape_string($cnx,(string)$value));
			$result=mysqli_query($cnx,$query);
			while ($row=mysqli_fetch_array($result)) {
				$HaveSeccionAbsence=1;
				$strSeccionAbsence=$strSeccionAbsence."<a>".$key." ".$value." ".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]."</a><br>";
			}

		}

		$body='
			<div class="card-content">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<h4 class="panel-title">
									Vacaciones
									<i class="material-icons">keyboard_arrow_down</i>
								</h4>
							</a>
						</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
							'.$strExtraHours.'
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
				  	<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
				    	<h4 class="panel-title">
				      	Ausencia
				        <i class="material-icons">keyboard_arrow_down</i>
				      </h4>
				   </a>
				  </div>
				  <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
				  	<div class="panel-body">
							'.$strAbsence.'
						</div>
				  </div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							<h4 class="panel-title">
								Suspención
								<i class="material-icons">keyboard_arrow_down</i>
							</h4>
						</a>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="panel-body">
							'.$strSuspension.'
						</div>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingFour">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
							<h4 class="panel-title">
								Permiso Seccional
								<i class="material-icons">keyboard_arrow_down</i>
							</h4>
						</a>
					</div>
					<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
						<div class="panel-body">
							'.$strSeccionAbsence.'
						</div>
					</div>
				</div>

			</div>
		</div>

		';
		if ($HaveExtraHours==1||$HaveAbsence==1||$HaveSuspension==1||$HaveSeccionAbsence==1) {
			$flag=1;
		}else{
			$flag=0;
		}
		mysqli_close($cnx);
		return [$flag,$body];
	}

	function getStartAndEndDate($week, $year) {
	  $dto = new DateTime();
	  $dto->setISODate($year, $week,1);
	  $ret['Lunes'] = $dto->format('Y-m-d');
	  $dto->modify('+1 days');
	  $ret['Martes'] = $dto->format('Y-m-d');
	  $dto->modify('+1 days');
	  $ret['Miercoles'] = $dto->format('Y-m-d');
	  $dto->modify('+1 days');
	  $ret['Jueves'] = $dto->format('Y-m-d');
	  $dto->modify('+1 days');
	  $ret['Viernes'] = $dto->format('Y-m-d');
	  $dto->modify('+1 days');
	  $ret['Sabado'] = $dto->format('Y-m-d');
	  $dto->modify('+1 days');
	  $ret['Domingo'] = $dto->format('Y-m-d');

	  return $ret;
	}
	function getAusencia($idAusencia){
		$cnx=cnx();
		$data = array();
		$data['exist']="0";
		$query=sprintf("SELECT * FROM ausencia  where idAusencia='%s'",mysqli_real_escape_string($cnx,$idAusencia));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$data['exist']="1";
			$data['FechaCreacion']=$row["FechaCreacion"];
			$data['NumeroDocumentoPor']=$row["NumeroDocumentoPor"];
			$data['NumeroDocumento']=$row["NumeroDocumento"];
			$data['TipoAusencia']=$row["TipoAusencia"];
			$data['FechaAusencia']=$row["FechaAusencia"];
			$data['EstadoAusencia']=$row["EstadoAusencia"];
			$data['Observacion']=$row["Observacion"];
		}
		mysqli_close($cnx);
		return $data;
	}
	function getIncapacidad($idIncapacidad){
		$cnx=cnx();
		$data = array();
		$data['exist']="0";
		$query=sprintf("SELECT * FROM incapacidad where idIncapacidad='%s'",mysqli_real_escape_string($cnx,$idIncapacidad));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$data['exist']="1";
			$data['EstadoComprobacion']=$row["EstadoComprobacion"];
			$data['TipoIncapacidad']=$row["TipoIncapacidad"];
			$data['FechaCreacion']=$row["FechaCreacion"];
			$data['NumeroDocumentoPor']=$row["NumeroDocumentoPor"];
			$data['NumeroDocumento']=$row["NumeroDocumento"];
			$data['NombreClinica']=$row["NombreClinica"];
			$data['NumeroTelefonoClinica']=$row["NumeroTelefonoClinica"];
			$data['Doctor']=$row["Doctor"];
			$data['DiaInicio']=$row["DiaInicio"];
			$data['DiaFin']=$row["DiaFin"];
			$data['FechaExpedicion']=$row["FechaExpedicion"];
		}

		mysqli_close($cnx);
		return $data;

	}
	function getPermiso($idPermiso){
		$cnx=cnx();
		$data = array();
		$data['exist']="0";
		$query=sprintf("SELECT * FROM permiso  where idPermiso='%s'",mysqli_real_escape_string($cnx,$idPermiso));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$data['exist']="1";
			$data['NumeroDocumento']=$row["NumeroDocumento"];
			$data['NumeroDocumentoPor']=$row["NumeroDocumentoPor"];
			$data['TipoPermiso']=$row["TipoPermiso"];
			$data['DiaInicio']=$row["DiaInicio"];
			$data['DiaFin']=$row["DiaFin"];
			$data['HoraInicio']=$row["HoraInicio"];
			$data['HoraFin']=$row["HoraFin"];
			$data['EstadoPermiso']=$row["EstadoPermiso"];
			$data['Observacion']=$row["Observacion"];
		}
		mysqli_close($cnx);
		return $data;
	}
	function getPermisoSeccional($idPermisoSeccional){
		$cnx=cnx();
		$data = array();
		$data['exist']="0";
		$query=sprintf("SELECT * FROM permiso_seccional  where idPermisoSeccional='%s'",mysqli_real_escape_string($cnx,$idPermisoSeccional));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!=""){
			$data['exist']="1";
			$data['FechaCreacion']=$row["FechaCreacion"];
			$data['NumeroDocumento']=$row["NumeroDocumento"];
			$data['NumeroDocumentoPor']=$row["NumeroDocumentoPor"];
			$data['TipoPermisoSeccional']=$row["TipoPermisoSeccional"];
			$data['Dia']=$row["Dia"];
			$data['HoraInicio']=$row["HoraInicio"];
			$data['HoraFin']=$row["HoraFin"];
			$data['EstadoPermisoSeccional']=$row["EstadoPermisoSeccional"];
			$data['Observacion']=$row["Observacion"];
		}
		mysqli_close($cnx);
		return $data;
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
	function isAlredySuspended($NumeroDocumento,$Fecha){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM suspension where NumeroDocumento='%s' AND Fecha='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$Fecha));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;

	}
	function isSuspensionExist($idSuspension){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM suspension where idSuspension='%s'",mysqli_real_escape_string($cnx,$idSuspension));
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
			$htrabajo->setDescanso($row["Descanso"]);
			$htrabajo->setH_Descanso($row["H_Descanso"]);
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
	function revisarUpdateSemanal($idTurno,$idSemana,$Lunes,$Martes,$Miercoles,$Jueves,$Viernes,$Sabado,$Domingo){
		$cnx=cnx();
		$query=sprintf("SELECT empleado.NumeroDocumento from empleado INNER JOIN turno INNER JOIN htrabajo WHERE turno.idTurno='%s' and turno.idTurno=htrabajo.idTurno and htrabajo.NumeroDocumento=empleado.NumeroDocumento",mysqli_real_escape_string($cnx,$idTurno));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)){
			$queryUpd=sprintf("SELECT col_semanal.idCol_Semanal from col_semanal where col_semanal.idSemanal='%s' and col_semanal.NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$idSemana),mysqli_real_escape_string($cnx,$row["NumeroDocumento"]));
			$resultUpd=mysqli_query($cnx,$queryUpd);
			$rowUpd=mysqli_fetch_array($resultUpd);
			if($rowUpd[0]==""){
				$query2 = sprintf("INSERT INTO col_semanal(idSemanal,NumeroDocumento,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado,Domingo) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')",
				mysqli_real_escape_string($cnx,$idSemana),
				mysqli_real_escape_string($cnx,$row["NumeroDocumento"]),
				mysqli_real_escape_string($cnx,$Lunes),
				mysqli_real_escape_string($cnx,$Martes),
				mysqli_real_escape_string($cnx,$Miercoles),
				mysqli_real_escape_string($cnx,$Jueves),
				mysqli_real_escape_string($cnx,$Viernes),
				mysqli_real_escape_string($cnx,$Sabado),
				mysqli_real_escape_string($cnx,$Domingo)
				);
				$estado2 = mysqli_query($cnx,$query2);
			};
		}
		mysqli_close($cnx);
	}
	function UpdateSemanal($idTurno,$idSemana,$Lunes,$Martes,$Miercoles,$Jueves,$Viernes,$Sabado,$Domingo){
		$cnx=cnx();
				revisarUpdateSemanal($idTurno,$idSemana,$Lunes,$Martes,$Miercoles,$Jueves,$Viernes,$Sabado,$Domingo);
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
	function AddArrTime($times) {

    // loop throught all the times
		$total_seconds=0;
    foreach ($times as $time) {
        list($hour, $minute, $second) = explode(':', $time);
        $total_seconds = $total_seconds + ($hour * 3600) + ($minute * 60) + $second;
    }

		$hours = floor($total_seconds / 3600);
		$mins = floor($total_seconds / 60 % 60);
	 $secs = floor($total_seconds % 60);

    // returns the time already formatted
    return sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
	}
	function RevisarTiempo($valor,$HIni,$HFin,$Des){
	  $HFin=new DateTime($HFin);
	  $HIni=new DateTime($HIni);
	  $Des=new DateTime($Des);
	  $interval = $HFin->diff($HIni);
	  $nvalor=$interval->format('%H:%I:%S');
	  $NDate= new DateTime($nvalor);
	  $intervalf = $NDate->diff($Des);
	  $workduration = $intervalf->format('%H:%I:%S');
	  $time_array = explode(':',$workduration);
	  $hours = (int)$time_array[0];
	  $minutes = (int)$time_array[1];
	  $seconds = (int)$time_array[2];
	  $total_seconds = ($hours * 3600) + ($minutes * 60) + $seconds;
	  $average = floor($total_seconds/2);
	  $hours = floor($average / 3600);
	  $mins = floor($average / 60 % 60);
	  $secs = floor($average % 60);
	  $timeFormat = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
	  if($valor==1){
	    $valorN=(String)($workduration);
	  }else if($valor==2){
	    $valorN=(String)($timeFormat);
	  }else{
	    $valorN="D";
	  }

	return $valorN;

	}
	function giveSemanalTimeAndIfDiurnOrNoctu($NumeroDocumento,$Semana,$annio){
		$cnx=cnx();
		$flag=0;//0 el empleado no se pasa
		$str="";
		$query = sprintf("SELECT htrabajo.*,col_semanal.* FROM htrabajo INNER JOIN semanal INNER JOIN col_semanal WHERE htrabajo.NumeroDocumento='%s' AND htrabajo.NumeroDocumento=col_semanal.NumeroDocumento AND col_semanal.idSemanal=semanal.idSemanal AND semanal.nSemana='%s' AND semanal.anno='%s'"
		,mysqli_real_escape_string($cnx,$NumeroDocumento)
		,mysqli_real_escape_string($cnx,$Semana)
		,mysqli_real_escape_string($cnx,$annio));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$tot=0;
			$HoraInicio=$row["Desde"];
			$HoraInicio=explode(":",$HoraInicio);
			$HoraInicio=$HoraInicio[0].":".$HoraInicio[1];
			$HoraFin=$row["Hasta"];
			$HoraFin=explode(":",$HoraFin);
			$HoraFin=$HoraFin[0].":".$HoraFin[1];
			$HoraDescanso=$row["H_Descanso"];
			$HoraDescanso=explode(":",$HoraDescanso);
			$HoraDescanso=$HoraDescanso[0].":".$HoraDescanso[1];
			//Cuantos dias trabaja horario completo o mysqlnd_ms_get_last_used_connection
			$totHorasLaborales=  array();
			$LunesT=RevisarTiempo($row["Lunes"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$LunesT)!=0){
				$totHorasLaborales[]=$LunesT;
			}
			$MartesT=RevisarTiempo($row["Martes"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$MartesT)!=0){
				$totHorasLaborales[]=$MartesT;
			}
			$MiercolesT=RevisarTiempo($row["Miercoles"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$MiercolesT)!=0){
				$totHorasLaborales[]=$MiercolesT;
			}
			$JuevesT=RevisarTiempo($row["Jueves"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$JuevesT)!=0){
				$totHorasLaborales[]=$JuevesT;
			}
			$ViernesT=RevisarTiempo($row["Viernes"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$ViernesT)!=0){
				$totHorasLaborales[]=$ViernesT;
			}
			$SabadoT=RevisarTiempo($row["Sabado"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$SabadoT)!=0){
				$totHorasLaborales[]=$SabadoT;
			}
			$DomingoT=RevisarTiempo($row["Domingo"],$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$DomingoT)!=0){
				$totHorasLaborales[]=$DomingoT;
			}
			//diurna 6-19
			//tot horas ->
			$totHorasLaborales=AddArrTime($totHorasLaborales);
			$totHorasLaborales=explode(":",$totHorasLaborales);
			$totHorasLaborales=$totHorasLaborales[0].":".$totHorasLaborales[1];
			//is hornada is D or N
			if (strcmp("D",isBetwenNightTime($HoraInicio,$HoraFin))==0) {
				$MaxHoursWeek=44;//Max diurno
				$tipoSemanaL="Diurna";
			}else {
				$MaxHoursWeek=39;//MAX nocturna
				$tipoSemanaL="Nocturna";
			}
			if(HourToNum($totHorasLaborales)>$MaxHoursWeek){
				//Si se pasa el total de horas semanales al permitido
				$flag=1;
				//Se pasa por
				$str="".gmdate("H:i:s", (int)subsTwoTimes($totHorasLaborales.":00",$MaxHoursWeek.":00"))."";
			}

		}
		mysqli_close($cnx);

		return $flag.",".$str;
	}
	function revisarSemanalConEmpleado($idTurno,$lunes,$martes,$miercoles,$jueves,$viernes,$sabado,$domingo){
		$cnx=cnx();
		$flag=0;//0 es que no hay empleados que se pasen
		$str="";
		$query = sprintf("SELECT empleado.PrimerNombre,empleado.SegundoNombre,empleado.PrimerApellido,empleado.SegundoApellido,htrabajo.Desde,htrabajo.Hasta,htrabajo.H_Descanso from turno INNER JOIN htrabajo INNER JOIN empleado WHERE turno.idTurno='%s' and turno.idTurno=htrabajo.idTurno and htrabajo.NumeroDocumento=empleado.NumeroDocumento",mysqli_real_escape_string($cnx,$idTurno));
		$result=mysqli_query($cnx,$query);
		while ($row=mysqli_fetch_array($result)) {
			$tot=0;
			$HoraInicio=$row["Desde"];
			$HoraInicio=explode(":",$HoraInicio);
			$HoraInicio=$HoraInicio[0].":".$HoraInicio[1];
			$HoraFin=$row["Hasta"];
			$HoraFin=explode(":",$HoraFin);
			$HoraFin=$HoraFin[0].":".$HoraFin[1];
			$HoraDescanso=$row["H_Descanso"];
			$HoraDescanso=explode(":",$HoraDescanso);
			$HoraDescanso=$HoraDescanso[0].":".$HoraDescanso[1];
			//Cuantos dias trabaja horario completo o mysqlnd_ms_get_last_used_connection
			$totHorasLaborales=  array();
			$LunesT=RevisarTiempo($lunes,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$LunesT)!=0){
				$totHorasLaborales[]=$LunesT;
			}
			$MartesT=RevisarTiempo($martes,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$MartesT)!=0){
				$totHorasLaborales[]=$MartesT;
			}
			$MiercolesT=RevisarTiempo($miercoles,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$MiercolesT)!=0){
				$totHorasLaborales[]=$MiercolesT;
			}
			$JuevesT=RevisarTiempo($jueves,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$JuevesT)!=0){
				$totHorasLaborales[]=$JuevesT;
			}
			$ViernesT=RevisarTiempo($viernes,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$ViernesT)!=0){
				$totHorasLaborales[]=$ViernesT;
			}
			$SabadoT=RevisarTiempo($sabado,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$SabadoT)!=0){
				$totHorasLaborales[]=$SabadoT;
			}
			$DomingoT=RevisarTiempo($domingo,$row["Desde"],$row["Hasta"],$row["H_Descanso"]);
			if(strcmp("D",(string)$DomingoT)!=0){
				$totHorasLaborales[]=$DomingoT;
			}
			//diurna 6-19
			//tot horas ->
			$totHorasLaborales=AddArrTime($totHorasLaborales);
			$totHorasLaborales=explode(":",$totHorasLaborales);
			$totHorasLaborales=$totHorasLaborales[0].":".$totHorasLaborales[1];
			//is hornada is D or N
			if (strcmp("D",isBetwenNightTime($HoraInicio,$HoraFin))==0) {
				$MaxHoursWeek=44;//Max diurno
				$tipoSemanaL="Diurna";
			}else {
				$MaxHoursWeek=39;//MAX nocturna
				$tipoSemanaL="Nocturna";
			}
			if(HourToNum($totHorasLaborales)>$MaxHoursWeek){
				//Si se pasa el total de horas semanales al permitido
				$flag=1;
				$str=$str."<p style='font-size:15px'>".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]." tipo de semana laboral ".$tipoSemanaL." Exede en:".gmdate("H:i:s", (int)subsTwoTimes($totHorasLaborales.":00",$MaxHoursWeek.":00"))."</p>";
			}

		}
		mysqli_close($cnx);

		return $flag.",".$str;
	}
	function isBetwenNightTime($HoraInicio,$HoraFin){
		//recibe tipo "00:00"
		$DoN="D";
		$HaCoprobar=0;
		//Horas totales laborales
			if(HourToNum($HoraInicio)<=HourToNum($HoraFin)){
				$totHorasLaborales=subsTwoTimes($HoraFin,$HoraInicio);
				$totHorasLaborales=gmdate("H:i:s", (int)$totHorasLaborales);
				$totHorasLaborales=abs(HourToNum($totHorasLaborales));
			}else{
				$totHorasLaborales=subsTwoTimes($HoraInicio,$HoraFin);
				$totHorasLaborales=gmdate("H:i:s", (int)$totHorasLaborales);
				$totHorasLaborales=abs(HourToNum($totHorasLaborales));
			}
		if((HourToNum($HoraInicio)>=19 )||(HourToNum($HoraFin)<=6)){
			//caso basico
			$DoN="N";
		}elseif ((HourToNum($HoraInicio)<6)) {
			# code...
			if(((6-HourToNum($HoraInicio))<=$totHorasLaborales)&&(6-HourToNum($HoraInicio))>0){
				$HaCoprobar=subsTwoTimes($HoraInicio,"06:00");
				if(HourToNum($HoraFin)>19){
					//$HaCoprobar=subsTwoTimes();
					//$NHorasDiurnas=gmdate("H:i:s", (int)$Tot);
					$HaCoprobar=$HaCoprobar+subsTwoTimes("19:00",$HoraFin);
				}
				$HaCoprobar=gmdate("H:i:s", (int)$HaCoprobar);
				if ($HaCoprobar>="04:00:00") {
					$DoN="N";
				}
			}
		}elseif ((HourToNum($HoraFin)>19)) {
			if(((HourToNum($HoraFin)-19)<=$totHorasLaborales)&&(HourToNum($HoraFin)-19)>0){
				$HaCoprobar=subsTwoTimes("19:00",$HoraFin);
			}
			$HaCoprobar=gmdate("H:i:s", (int)$HaCoprobar);
			if ($HaCoprobar>="04:00:00") {
				$DoN="N";
			}
		}
		return $DoN;
	}
	function subsTwoTimes($First,$End){
	  $str_time = (string)$First.":00";
	  sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	  $FirstTimeSeconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	  $str_time = (string)$End.":00";
	  sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	  $EndTimeSeconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
	  return abs($EndTimeSeconds-$FirstTimeSeconds);
	}

	function HourToNum($Hour){
	  $Hour=(string)$Hour;
	  $Hour= explode(":",$Hour);
	  $Hour=$Hour[0].".".$Hour[1];
	  return (float)$Hour;
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
	function UpdatePermiso($TipoPermiso,$idPermiso,$estadoPermiso,$DiaInicio,$DiaFin,$HoraInicio,$HoraFin,$Observacion){
		$cnx=cnx();
		$query = sprintf("UPDATE permiso SET  TipoPermiso = '%s',DiaInicio = '%s',DiaFin = '%s',HoraInicio = '%s',HoraFin = '%s',Observacion = '%s' WHERE idPermiso = '%s'",
		mysqli_real_escape_string($cnx,$TipoPermiso),
		mysqli_real_escape_string($cnx,$DiaInicio),
		mysqli_real_escape_string($cnx,$DiaFin),
		mysqli_real_escape_string($cnx,$HoraInicio),
		mysqli_real_escape_string($cnx,$HoraFin),
		mysqli_real_escape_string($cnx,$Observacion),
		mysqli_real_escape_string($cnx,$idPermiso)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function UpdatePermisoSeccional($idPermisoSeccional,$TipoPermisoSeccional,$Dia,$HoraInicio,$HoraFin,$Observacion){
		$cnx=cnx();
		$query = sprintf("UPDATE permiso_seccional SET  TipoPermisoSeccional = '%s',Dia	 = '%s',HoraInicio = '%s',HoraFin = '%s',Observacion = '%s' WHERE idPermisoSeccional = '%s'",
		mysqli_real_escape_string($cnx,$TipoPermisoSeccional),
		mysqli_real_escape_string($cnx,$Dia),
		mysqli_real_escape_string($cnx,$HoraInicio),
		mysqli_real_escape_string($cnx,$HoraFin),
		mysqli_real_escape_string($cnx,$Observacion),
		mysqli_real_escape_string($cnx,$idPermisoSeccional)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function ConfirmarSuspension($idSuspension){
		$cnx=cnx();
		$query = sprintf("UPDATE suspension SET  EstadoSuspension = '%s' WHERE idSuspension = '%s'",
		mysqli_real_escape_string($cnx,1),
		mysqli_real_escape_string($cnx,$idSuspension)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function ConfirmarPermiso($idPermiso){
		$cnx=cnx();
		$query = sprintf("UPDATE permiso SET  EstadoPermiso = '%s' WHERE idPermiso = '%s'",
		mysqli_real_escape_string($cnx,1),
		mysqli_real_escape_string($cnx,$idPermiso)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function UpdateIncapacidad($TipoIncapacidad,$idIncapacidad,$NombreClinica,$NumeroTelefonoClinica,$Doctor,$FechaInicio,$FechaFin,$FechaExpedicion,$EstadoComprobacion){
		$cnx=cnx();
		$query = sprintf("UPDATE incapacidad SET  TipoIncapacidad = '%s',NombreClinica = '%s',NumeroTelefonoClinica = '%s',Doctor = '%s',DiaInicio = '%s',DiaFin = '%s',FechaExpedicion = '%s' WHERE idIncapacidad = '%s'",
		mysqli_real_escape_string($cnx,$TipoIncapacidad),
		mysqli_real_escape_string($cnx,$NombreClinica),
		mysqli_real_escape_string($cnx,$NumeroTelefonoClinica),
		mysqli_real_escape_string($cnx,$Doctor),
		mysqli_real_escape_string($cnx,$FechaInicio),
		mysqli_real_escape_string($cnx,$FechaFin),
		mysqli_real_escape_string($cnx,$FechaExpedicion),
		mysqli_real_escape_string($cnx,$idIncapacidad)
		);
		$estado = mysqli_query($cnx,$query);
		mysqli_close($cnx);
		return $estado;
	}
	function UpdateAusencia($idAusencia,$TipoAusencia,$EstadoAusencia,$FechaAusencia,$Observacion){
		$cnx=cnx();
		$query = sprintf("UPDATE ausencia SET  TipoAusencia = '%s',FechaAusencia = '%s',EstadoAusencia = '%s',Observacion = '%s' WHERE idAusencia = '%s'",
		mysqli_real_escape_string($cnx,$TipoAusencia),
		mysqli_real_escape_string($cnx,$FechaAusencia),
		mysqli_real_escape_string($cnx,$EstadoAusencia),
		mysqli_real_escape_string($cnx,$Observacion),
		mysqli_real_escape_string($cnx,$idAusencia)
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
//eliminarPermisos
function eliminarPermisos($idPermiso){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM permiso WHERE idPermiso='%s'",mysqli_real_escape_string($cnx,$idPermiso));
		$estado = mysqli_query($cnx, $query);

	mysqli_close($cnx);
	return $estado;
}
//eliminarPermisosSeccional
function eliminarPermisosSeccional($idPermisoSeccional){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM permiso_seccional WHERE idPermisoSeccional='%s'",mysqli_real_escape_string($cnx,$idPermisoSeccional));
		$estado = mysqli_query($cnx, $query);

	mysqli_close($cnx);
	return $estado;
}
//eliminarAusencia
function eliminarAusencia($idAusencia){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM ausencia WHERE idAusencia='%s'",mysqli_real_escape_string($cnx,$idAusencia));
		$estado = mysqli_query($cnx, $query);

	mysqli_close($cnx);
	return $estado;
}
//eliminarIncapacidad
function eliminarIncapacidad($idIncapacidad){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM incapacidad WHERE idIncapacidad='%s'",mysqli_real_escape_string($cnx,$idIncapacidad));
		$estado = mysqli_query($cnx, $query);

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
//eliminarSuspension
function eliminarSuspension($idSuspension){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM suspension WHERE idSuspension='%s'",mysqli_real_escape_string($cnx,$idSuspension));
		$estado = mysqli_query($cnx, $query);

	mysqli_close($cnx);
	return $estado;
}
//eliminarLlegadasTarde
function eliminarLlegadasTarde($idColLlegadas_Tarde){
		$cnx=cnx();
		$estado=1;
		$query=sprintf("DELETE FROM col_llegadas_tarde WHERE idColLlegadas_Tarde='%s'",mysqli_real_escape_string($cnx,$idColLlegadas_Tarde));
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
	function actualizarUsuario($empleado,$htrabajo,$idBanco,$NumeroCuenta,$H_Descanso,$descanso){
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

			$query2 = sprintf("UPDATE htrabajo SET Desde = '%s', Hasta ='%s', idTurno = '%s', Descanso = '%s', H_Descanso = '%s' WHERE NumeroDocumento = '%s'",
			mysqli_real_escape_string($cnx, $htrabajo->getDesde()),
			mysqli_real_escape_string($cnx, $htrabajo->getHasta()),
			mysqli_real_escape_string($cnx, $htrabajo->getIdturno()),
			mysqli_real_escape_string($cnx, $descanso),
			mysqli_real_escape_string($cnx, $H_Descanso),
			mysqli_real_escape_string($cnx, $empleado->getNumerodocumento())

			);
		$estado = mysqli_query($cnx, $query);
		$estado2 = mysqli_query($cnx, $query2);
		$estadoT=$estado+$estado2+$estado3;
		mysqli_close($cnx);
		return $estadoT;

	}

	function insertarDocumentoAusencia($idAusencia,$name,$extension){
		$cnx=cnx();
		$query = sprintf("INSERT INTO ausencia_documentos(idAusencia,rutaDocumento,tipoDocumento) VALUES ('%s','%s','%s')",
			mysqli_real_escape_string($cnx,$idAusencia),
			mysqli_real_escape_string($cnx,$name),
			mysqli_real_escape_string($cnx,$extension)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
	}
	function insertarDocumentoPermisoSeccionado($idPermisoSeccional,$name,$extension){
		$cnx=cnx();
		$query = sprintf("INSERT INTO permiso_seccional_documentos(idPermisoSeccional,rutaDocumento,tipoDocumento) VALUES ('%s','%s','%s')",
			mysqli_real_escape_string($cnx,$idPermisoSeccional),
			mysqli_real_escape_string($cnx,$name),
			mysqli_real_escape_string($cnx,$extension)
		);
		$estado = mysqli_query($cnx, $query);
		if($estado==1){
			$query = sprintf("UPDATE permiso_seccional SET  EstadoPermisoSeccional = '%s' WHERE idPermisoSeccional = '%s'",
			mysqli_real_escape_string($cnx,"1"),
			mysqli_real_escape_string($cnx,$idPermisoSeccional)
			);
			$estado = mysqli_query($cnx,$query);
		}
		mysqli_close($cnx);
	}
	function GuardarArchivoHorasExtrasPDF($idHorasExtras,$name,$extension){
		$cnx=cnx();
		$query=sprintf("INSERT INTO horas_extras_documentos(idHorasExtras, rutaDocumento, tipoDocumento) VALUES ('%s','%s','%s')",
		mysqli_real_escape_string($cnx,$idHorasExtras),
		mysqli_real_escape_string($cnx,$name),
		mysqli_real_escape_string($cnx,$extension)
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
	function insertarDocumentoIncapacidades($idIncapacidad,$name,$extension){
		$cnx=cnx();
		$query = sprintf("INSERT INTO incapacidad_documentos(idIncapacidad,rutaDocumento,tipoDocumento) VALUES ('%s','%s','%s')",
			mysqli_real_escape_string($cnx,$idIncapacidad),
			mysqli_real_escape_string($cnx,$name),
			mysqli_real_escape_string($cnx,$extension)
		);
		$estado = mysqli_query($cnx, $query);
		$query = sprintf("UPDATE incapacidad SET EstadoComprobacion = '%s' WHERE idIncapacidad = '%s'",
			mysqli_real_escape_string($cnx, 1),
			mysqli_real_escape_string($cnx, $idIncapacidad)
			);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
	}

	function isIncapExist($idIncapacidad){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM incapacidad where idIncapacidad='%s'",mysqli_real_escape_string($cnx,$idIncapacidad));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;

	}
	function isPermisoExist($idPermiso){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM permiso where idPermiso='%s'",mysqli_real_escape_string($cnx,$idPermiso));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;

	}
	function isPermisoSeccionalExist($idPermisoSeccional){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM permiso_seccional where idPermisoSeccional='%s'",mysqli_real_escape_string($cnx,$idPermisoSeccional));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;

	}
	function isAusenExist($idAusencia){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM ausencia where idAusencia='%s'",mysqli_real_escape_string($cnx,$idAusencia));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function isAusenDocExist($idAusencia){
		$cnx=cnx();
		$flag=FALSE;
		$query=sprintf("SELECT * FROM ausencia_documentos where idAusencia='%s'",mysqli_real_escape_string($cnx,$idAusencia));
		$resul=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($resul);
		if($row[0]!="")
			$flag=TRUE;
		mysqli_close($cnx);
		return $flag;
	}
	function AgregarPermiso($TipoPermiso,$NumeroDocumentoPor,$estadoPermiso,$DiaInicio,$DiaFin,$HoraInicio,$HoraFin,$Observacion,$NumeroDocumento){
		date_default_timezone_set('America/El_Salvador');
		$dateTime = date("Y-m-d H:i:s");
		$cnx = cnx();
		$query = sprintf("INSERT INTO permiso(FechaCreacion	,NumeroDocumentoPor,NumeroDocumento,TipoPermiso,DiaInicio,DiaFin,HoraInicio,HoraFin,EstadoPermiso,Observacion) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$dateTime),
			mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$TipoPermiso),
			mysqli_real_escape_string($cnx,$DiaInicio),
			mysqli_real_escape_string($cnx,$DiaFin),
			mysqli_real_escape_string($cnx,$HoraInicio),
			mysqli_real_escape_string($cnx,$HoraFin),
			mysqli_real_escape_string($cnx,$estadoPermiso),
			mysqli_real_escape_string($cnx,$Observacion)

		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;
	}

	function AgregarPermisoSeccional($TipoPermiso,$NumeroDocumentoPor,$estadoPermiso,$DiaInicio,$HoraInicio,$HoraFin,$Observacion,$NumeroDocumento){
		$cnx = cnx();
		$query = sprintf("INSERT INTO permiso_seccional(NumeroDocumentoPor,NumeroDocumento,TipoPermisoSeccional,Dia,HoraInicio,HoraFin,EstadoPermisoSeccional,Observacion) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$TipoPermiso),
			mysqli_real_escape_string($cnx,$DiaInicio),
			mysqli_real_escape_string($cnx,$HoraInicio),
			mysqli_real_escape_string($cnx,$HoraFin),
			mysqli_real_escape_string($cnx,$estadoPermiso),
			mysqli_real_escape_string($cnx,$Observacion)

		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;
	}

	function AgregarSuspensionEmpleado($NumeroDocumento,$NumeroDocumentoPor,$tipoSuspension,$Fecha,$Descripcion){
		$cnx = cnx();
		$query=sprintf("INSERT INTO suspension(NumeroDocumento,NumeroDocumentoPor,Fecha,TipoSuspension,EstadoSuspension,Descripcion) VALUES ('%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
			mysqli_real_escape_string($cnx,$Fecha),
			mysqli_real_escape_string($cnx,$tipoSuspension),
			mysqli_real_escape_string($cnx,0),
			mysqli_real_escape_string($cnx,$Descripcion)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;
	}
	function AgregarAusencia($TipoAusencia,$NumeroDocumentoPor,$EstadoAusencia,$FechaAusencia,$Observacion,$NumeroDocumento){
		date_default_timezone_set('America/El_Salvador');
		$dateTime = date("Y-m-d H:i:s");
		$cnx = cnx();
		$query = sprintf("INSERT INTO ausencia(FechaCreacion,NumeroDocumentoPor,NumeroDocumento,TipoAusencia,FechaAusencia,EstadoAusencia,Observacion) VALUES ('%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$dateTime),
			mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$TipoAusencia),
			mysqli_real_escape_string($cnx,$FechaAusencia),
			mysqli_real_escape_string($cnx,$EstadoAusencia),
			mysqli_real_escape_string($cnx,$Observacion)
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;
	}
	function AgregarIncapacidad($TipoIncapacidad,$NumeroDocumentoPor,$NumeroDocumento,$NombreClinica,$NumeroTelefonoClinica,$Doctor,$DiaInicio,$DiaFin,$FechaExpedicion,$EstadoComprobacion)
	{
		date_default_timezone_set('America/El_Salvador');
    $dateTime = date("Y-m-d H:i:s");
		$cnx = cnx();
		$query = sprintf("INSERT INTO incapacidad(TipoIncapacidad,FechaCreacion,NumeroDocumentoPor,NumeroDocumento,NombreClinica,NumeroTelefonoClinica,Doctor,DiaInicio,DiaFin,FechaExpedicion,EstadoComprobacion) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$TipoIncapacidad),
			mysqli_real_escape_string($cnx,$dateTime),
			mysqli_real_escape_string($cnx,$NumeroDocumentoPor),
			mysqli_real_escape_string($cnx,$NumeroDocumento),
			mysqli_real_escape_string($cnx,$NombreClinica),
			mysqli_real_escape_string($cnx,$NumeroTelefonoClinica),
			mysqli_real_escape_string($cnx,$Doctor),
			mysqli_real_escape_string($cnx,$DiaInicio),
			mysqli_real_escape_string($cnx,$DiaFin),
			mysqli_real_escape_string($cnx,$FechaExpedicion),
			mysqli_real_escape_string($cnx,"0")
		);
		$estado = mysqli_query($cnx, $query);
		mysqli_close($cnx);
		return $estado;
	}
	function agregarTurno($NitEmpresa,$nombreTurno,$Desde,$Hasta,$Periodo_Pago,$H_MJornada){
		$cnx = cnx();
		$query = sprintf("INSERT INTO turno(NitEmpresa,nombreTurno,Desde,Hasta,Periodo_Pago,H_MJornada) VALUES ('%s','%s','%s','%s','%s','%s')",
			mysqli_real_escape_string($cnx,$NitEmpresa),
			mysqli_real_escape_string($cnx,$nombreTurno),
			mysqli_real_escape_string($cnx,$Desde),
			mysqli_real_escape_string($cnx,$Hasta),
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
	function AgregarEmpleado($TipoDocumento,$NumeroDocumento,$PrimerNombre,$PrimerApellido,$Pass,$SalarioNominal,$Desde,$Hasta,$FechaIngreso,$idTurno,$Activo,$idCargos,$Descanso,$H_Descanso){
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
			$query = sprintf("INSERT INTO htrabajo(NumeroDocumento,Desde,Hasta,idTurno,Descanso,H_Descanso) VALUES ('%s','%s','%s','%s','%s','%s')",
				mysqli_real_escape_string($cnx,$NumeroDocumento),
				mysqli_real_escape_string($cnx,$Desde),
				mysqli_real_escape_string($cnx,$Hasta),
				mysqli_real_escape_string($cnx,$idTurno),
				mysqli_real_escape_string($cnx,$Descanso),
				mysqli_real_escape_string($cnx,$H_Descanso)
			);
			$estado = mysqli_query($cnx, $query);
		}
		mysqli_close($cnx);
		return $estado;
	}

	function actualizarTurno($idTurno,$nombreTurno,$Desde,$Hasta,$Periodo_Pagos,$H_MJornada){
		$cnx = cnx();
		$query = sprintf("UPDATE turno SET nombreTurno = '%s', Desde ='%s', Hasta = '%s',  Periodo_Pago = '%s', H_MJornada= '%s' WHERE idTurno = '%s'",
			mysqli_real_escape_string($cnx, $nombreTurno),
			mysqli_real_escape_string($cnx, $Desde),
			mysqli_real_escape_string($cnx, $Hasta),
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

	function verify_date_format($date) {
		//format YY-MM-DD
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
    {
        return true;
    }else{
        return false;
    }
  }
	function verify_date_old_format($date) {
		//format DD/MM/YY
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
    {
        return true;
    }else{
        return false;
    }
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
	function TimeToMinut($Time){
	  $Time=(string)$Time;
	  $Time= explode(":",$Time);
	  $Second=((float)$Time[0]*60)+((float)$Time[1])+(round((float)$Time[2]/60));
	  return floor((float)$Second);
	}
	function calculoDeRentaHE($TG,$TRAMO1,$TRAMO2,$TRAMO3,$TRAMO4){
	  //$TRAMO1=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
	  if(((float)$TG>(float)$TRAMO1["Desde"])&&((float)$TG<(float)$TRAMO1["Hasta"])){
	    $RENTA=(($TG-$TRAMO1["sobre_exceso"])*$TRAMO1["porcentaje_aplicar"])+$TRAMO1["Cuota_fija"];
	  }elseif(((float)$TG>(float)$TRAMO2["Desde"])&&((float)$TG<(float)$TRAMO2["Hasta"])) {
	    # code...
	    $RENTA=(($TG-$TRAMO2["sobre_exceso"])*$TRAMO2["porcentaje_aplicar"])+$TRAMO2["Cuota_fija"];
	  }elseif(((float)$TG>(float)$TRAMO3["Desde"])&&((float)$TG<(float)$TRAMO3["Hasta"])) {
	    # code...
	    $RENTA=(($TG-$TRAMO3["sobre_exceso"])*$TRAMO3["porcentaje_aplicar"])+$TRAMO3["Cuota_fija"];
	  }else{
	    $RENTA=(($TG-$TRAMO4["sobre_exceso"])*$TRAMO4["porcentaje_aplicar"])+$TRAMO4["Cuota_fija"];
	  }
	  return number_format($RENTA, 2, '.', '');
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
	function ifEmployHaveAccount($NumeroDocumento){
		$cnx = cnx();
		$flag=0;
		$query=sprintf("SELECT * FROM cuentasbanco  WHERE NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento));
		$result=mysqli_query($cnx,$query);
		$row=mysqli_fetch_array($result);
		if($row[0]!="") $flag=1;
		mysqli_close($cnx);
		return $flag;
	}
function checkIsTheyPayExtraHours($NumeroDocumento,$NitEmpresa,$FechaIni,$FechaFin){
	$cnx= cnx();
	$flag=0;//0 No existe
	$query=sprintf("SELECT * FROM pagos_horas_extras INNER JOIN col_pago_horas_extras where pagos_horas_extras.idPagos_Horas_Extras=col_pago_horas_extras.idPago_HorasExtras AND col_pago_horas_extras.NumeroDocumento='%s' AND pagos_horas_extras.NitEmpresa='%s' AND pagos_horas_extras.FechaIni='%s' AND pagos_horas_extras.FechaFin='%s'",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$FechaIni),mysqli_real_escape_string($cnx,$FechaFin));
	$result=mysqli_query($cnx,$query);
	$row=mysqli_fetch_array($result);
	if($row[0]!="") $flag=1;
	mysqli_close($cnx);
	return $flag;

}

	function getRowColPagoHorasExtras($idPago_HorasExtras){
		$cnx = cnx();
		$query=sprintf("SELECT * FROM col_pago_horas_extras  WHERE idPago_HorasExtras='%s'",mysqli_real_escape_string($cnx,$idPago_HorasExtras));
		$result=mysqli_query($cnx,$query);
		$totAPagar=0.00;
		while ($row=mysqli_fetch_array($result)) {
			$totAPagar=$totAPagar+$row["MontoLiquido"];
			$empleado= getInfoEmpleado($row["NumeroDocumento"]);
			$Cargo= getInfoCargos($empleado->getIdcargos());
			$Departamento = getInfoDepartamentos($Cargo->getIddepartamento());
			echo "
				<tr style='width:100%;'>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["Nombre"]."</span></td>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["NIT"]."</span></td>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["NumeroDocumento"]."</span></td>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["ISS"]."</span></td>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["AFP"]."</span></td>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["Renta"]."</span></td>
				 <td style='width:16%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$row["MontoLiquido"]."</span></td>
				 <td style='width:12%;white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'><span style='white-space: nowrap;overflow:hidden;text-overflow: ellipsis;display: inline-block;'>".$Departamento->getNombredepartamento()."/".$Cargo->getNombrecargo()."</span></td>
				</tr>

			";
		}
		mysqli_close($cnx);
		return number_format((float)$totAPagar, 2, '.', '');

	}
	function getIfExtraTimePayMore($FechaIni,$FechaFin,$SalarioNominal,$NumeroDocumento){
		$NombreEmpleado=getNombreEmpleado($NumeroDocumento);
		$flagIsGonnaPaySomething=0;//se le pagara algo si o no
		$strData=array();//Informacion que vamos a enviar para presentarla en pantalla
		$countData=0;
		$startTime = strtotime($FechaIni);
		$endTime = strtotime($FechaFin);
		$lastWeek = new DateTime($FechaFin);
		$lastWeek = $lastWeek->format("W");
		do {
			$weeks[] = date('W', $startTime);
			$startTime += strtotime('+1 week', 0);
		} while (date('W', $startTime) <= $lastWeek);
		//Tenemos todas las semanas que toca el lapso de tiempo dado
		$PassIniFecha=0;
		$PassFinFecha=0;
		$ValorMinuto=number_format(((float)$SalarioNominal)/30/8/60, 4, '.', '');
		foreach($weeks as $key => $value){
		  $ValorMD=0;
			$year = DateTime::createFromFormat("Y-m-d", $FechaIni);
			$year=$year->format("Y");
			//hay que ver
			if($value==52 &&  1==date("m",strtotime($FechaIni))){
				$year=$year-1;
			}
		  $daysOfTheWeek=getStartAndEndDate($value,$year);
		  //echo  "Semana:".$value."<br>";
		  $ExistSemanal=getSemanal($value,$year,$NumeroDocumento);
		  if($ExistSemanal["exist"]==1){
				$TotTimeToDiscount="00:00:00";
		    //tiene semanal
		    $cod1=giveSemanalTimeAndIfDiurnOrNoctu($NumeroDocumento,$value,$year);
		    $cod1=explode(",",$cod1);
		    if($cod1[0]==1){
		      //Si hay tiempo extra en el semanal
		      $TotTimeToDiscount=DiscountsTimeEmploy($daysOfTheWeek["Lunes"],$daysOfTheWeek["Domingo"],$NumeroDocumento);
		    }
		    if ($cod1[1]>$TotTimeToDiscount) {
		      //Si hay mas en el exedente que en los descuentos
		      $TimResul=gmdate("H:i:s", (int)subsTwoTimes($TotTimeToDiscount,$cod1[1]));
		      $MD=TimeToMinut($TimResul);
		      $ValorMD=number_format($ValorMinuto*2*$MD, 2, '.', '');
					$flagIsGonnaPaySomething=1;
		    }
		    $CountdaysOfTheWeek=0;
		    foreach($daysOfTheWeek as $keyDOW => $valueDOW){
		      if(strtotime($valueDOW)==strtotime($FechaIni)){
		        $PassIniFecha=1;
		      }
		      if((strtotime($valueDOW)>=strtotime($FechaIni)) && (strtotime($valueDOW)<=strtotime($FechaFin))){
		        //Tenemos los dias validos, la fecha en $valueDow y el numero de la semana en $value
		          $CountdaysOfTheWeek++;
		      }
		      if(strtotime($valueDOW)==strtotime($FechaFin)) {
		        $PassFinFecha=1;
		      }
		    }
		    //Cuanto Extra se le pagara
		    //echo "Del Tot semanal a pagar:".$ValorMD." por  ".$CountdaysOfTheWeek."  dias  solo se le dara:".number_format((double)$ValorMD*($CountdaysOfTheWeek/7), 2, '.', '')."<br>";
				if (number_format((double)$ValorMD*($CountdaysOfTheWeek/7), 2, '.', '')>0) {
					$strData[$countData]= array('NombreEmpleado' => $NombreEmpleado,'TotaPagar' => number_format((double)$ValorMD*($CountdaysOfTheWeek/7), 2, '.', ''), 'NumeroDocumento' => $NumeroDocumento, "Semana" =>$value, "annio" => $year );
					$countData++;
				}
			}
		}

		return [$flagIsGonnaPaySomething,$strData];
	}
	function getNombreEmpleado($NumeroDocumento){
		$empleado=getInfoUser($NumeroDocumento);
		$NombreCompleto="".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
		return $NombreCompleto;
	}
	function getRowPagoHorasExtrasN($NitEmpresa,$FechaInicio,$FechaFin,$PeriodoPago,$FormaPago){
		$cnx = cnx();
		//Sacar datos de la RENTA
			$TipoPago=str_split($PeriodoPago);
		  //Tipo de Pago para tomar en consideracion para la RENTA
		  if($TipoPago[0]==1){//mensual
		    $tipoRenta=1;
		  }elseif(($TipoPago[0]==2) || ($TipoPago[0]==3)){
		    //Quincena y Catorcena
		    $tipoRenta=2;
		  }elseif(($TipoPago[0]==4)){
		    //Semanal
		    $tipoRenta=3;
		  }
		  $TRAMO1= array();
		  $TRAMO2= array();
		  $TRAMO3= array();
		  $TRAMO4= array();
			$query=sprintf("SELECT * FROM renta WHERE tipo_pago='%s' ",mysqli_real_escape_string($cnx,$tipoRenta));
		  $result=mysqli_query($cnx,$query);
		  while($row=mysqli_fetch_array($result)) {
		    if(strcmp($row["nombre_tramo"],"I Tramo")==0){
		      $TRAMO1=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
		    }
		    elseif(strcmp($row["nombre_tramo"],"II Tramo")==0){
		      $TRAMO2=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
		    }
		    elseif(strcmp($row["nombre_tramo"],"III Tramo")==0){
		      $TRAMO3=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
		    }
		    elseif(strcmp($row["nombre_tramo"],"IV Tramo")==0){
		      $TRAMO4=array("Desde" => $row["Desde"],"Hasta" => $row["Hasta"],"porcentaje_aplicar" => $row["porcentaje_aplicar"],"sobre_exceso" => $row["sobre_exceso"],"Cuota_fija" => $row["Cuota_fija"]);
		    }else{
		      $RENTA=99999999;
		    }
		  }
			$TipoPago=$TipoPago[0]."0";
		//FIN
		$query=sprintf("SELECT col_horas_extras.NumeroDocumentoPara, empleado.SalarioNominal FROM horas_extras INNER JOIN col_horas_extras INNER JOIN empleado INNER JOIN htrabajo INNER JOIN turno WHERE col_horas_extras.NumeroDocumentoPara=htrabajo.NumeroDocumento AND htrabajo.idTurno=turno.idTurno AND turno.Periodo_Pago='%s' AND horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND horas_extras.EstadoHorasExternas=1 AND horas_extras.NitEmpresa='%s' AND empleado.NumeroDocumento=col_horas_extras.NumeroDocumentoPara AND horas_extras.Fecha BETWEEN '%s' AND '%s' GROUP BY col_horas_extras.NumeroDocumentoPara",mysqli_real_escape_string($cnx,$PeriodoPago),mysqli_real_escape_string($cnx,$NitEmpresa),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
	  $result=mysqli_query($cnx,$query);
		$totAPagar=0.00;
	  while($row=mysqli_fetch_array($result)) {
			//Revisar el tipo de Banco o forma de pago
			$isFPagoCorrecto=checkCuentaBanco($row["NumeroDocumentoPara"],$FormaPago);
			if((($isFPagoCorrecto)||($FormaPago==0))&&(checkIsTheyPayExtraHours($row["NumeroDocumentoPara"],$NitEmpresa,$FechaInicio,$FechaFin)==0)){
				$isFPagoCorrecto=getCuentaBanco($row["NumeroDocumentoPara"],$FormaPago);
				if((($isFPagoCorrecto[0]!="")&&($FormaPago!=0)) || (($FormaPago==0)&&($isFPagoCorrecto[0]==""))){
					//ahora que tenemos todos los numero de documento vamos a ver los totales de horas trabajadas
					$SalarioNominal=$row["SalarioNominal"];
					$NumeroDocumento=$row["NumeroDocumentoPara"];
					$queryTotCalSinVaca=sprintf("SELECT col_horas_extras.NumeroDocumentoPara ,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasDiurnas))) AS SHD,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasNocturnas)))AS SHN FROM col_horas_extras INNER JOIN horas_extras WHERE col_horas_extras.NumeroDocumentoPara='%s' AND horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND  col_horas_extras.DiaVacacion='0' AND horas_extras.Fecha BETWEEN '%s' AND '%s' GROUP BY col_horas_extras.NumeroDocumentoPara",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
					$resultTotCalSinVaca=mysqli_query($cnx,$queryTotCalSinVaca);
					$rowTotCalSinVaca=mysqli_fetch_array($resultTotCalSinVaca);
					if($rowTotCalSinVaca[0]!=""){
						$TotSinVacaD=$rowTotCalSinVaca["SHD"];
						$TotSinVacaN=$rowTotCalSinVaca["SHN"];
					}else {
						$TotSinVacaD="00:00:00";
						$TotSinVacaN="00:00:00";
					}
					$queryTotCalSinVaca=sprintf("SELECT col_horas_extras.NumeroDocumentoPara ,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasDiurnas))) AS SHD,SEC_TO_TIME(SUM(TIME_TO_SEC(col_horas_extras.NHorasNocturnas)))AS SHN FROM col_horas_extras INNER JOIN horas_extras INNER JOIN htrabajo INNER JOIN turno WHERE col_horas_extras.NumeroDocumentoPara='%s' AND horas_extras.idHorasExtras=col_horas_extras.idHorasExtras AND col_horas_extras.NumeroDocumentoPara=htrabajo.NumeroDocumento AND htrabajo.idTurno=turno.idTurno AND turno.Periodo_Pago='%s' AND col_horas_extras.DiaVacacion='1' AND horas_extras.Fecha BETWEEN '%s' AND '%s' GROUP BY col_horas_extras.NumeroDocumentoPara",mysqli_real_escape_string($cnx,$NumeroDocumento),mysqli_real_escape_string($cnx,$PeriodoPago),mysqli_real_escape_string($cnx,$FechaInicio),mysqli_real_escape_string($cnx,$FechaFin));
					$resultTotCalSinVaca=mysqli_query($cnx,$queryTotCalSinVaca);
					$rowTotCalSinVaca=mysqli_fetch_array($resultTotCalSinVaca);
					if($rowTotCalSinVaca[0]!=""){
						$TotConVacaD=$rowTotCalSinVaca["SHD"];
						$TotConVacaN=$rowTotCalSinVaca["SHN"];
					}else {
						$TotConVacaD="00:00:00";
						$TotConVacaN="00:00:00";
					}
					//Ya tenemos las horas del empleado a CALCULAR
						$TMD=0;
						$TMN=0;
						$TVMD=0;
						$TVMN=0;
						$VTMD=0.00;
						$VTMN=0.00;
						$VTVMD=0.00;
						$VTVMN=0.00;
						$VTG=0.00;
						$TISS=0.00;
						$TAFP=0.00;
						$TTDD=0.00;
						$TLRC=0.00;
						$iAUX=0;
						$MD=TimeToMinut($TotSinVacaD);
						$MN=TimeToMinut($TotSinVacaN);
						$MVD=TimeToMinut($TotConVacaD);
						$MVN=TimeToMinut($TotConVacaN);
						$SalarioN=number_format((float)$SalarioNominal, 2, '.', '');
						$ValorMinuto=number_format(((float)$SalarioNominal)/30/8/60, 4, '.', '');
						$ValorMD=number_format($ValorMinuto*2*$MD, 2, '.', '');
						$ValorMN=number_format($ValorMinuto*2.25*$MN, 2, '.', '');
						$ValorMVD=number_format($ValorMinuto*4*$MVD, 2, '.', '');
						$ValorMVN=number_format($ValorMinuto*4.5*$MVN, 2, '.', '');
						$TG=$ValorMD+$ValorMN+$ValorMVD+$ValorMVN;
						$ISS=number_format($TG*0.03, 2, '.', '');
						$AFP=number_format($TG*0.0625, 2, '.', '');
						$RENTA=calculoDeRentaHE($TG,$TRAMO1,$TRAMO2,$TRAMO3,$TRAMO4);
						$TOTD=$ISS+$AFP+$RENTA;
						$LR=$TG-$TOTD;
						$totAPagar=$totAPagar+$LR;
						$empleado=getInfoUser($NumeroDocumento);
						$NombreCompleto="".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
						$Cargo= getInfoCargos($empleado->getIdcargos());
						$Departamento = getInfoDepartamentos($Cargo->getIddepartamento());
					//FIN CALCULAR
					//IMPRIMAMOS
						echo "
							<tr>
							 <td>".$empleado->getNit()."</td>
							 <td>".$empleado->getNumeroDocumento()."</td>
							 <td>".$NombreCompleto."</td>
							 <td class='rowDataSd'>".$LR."</td>
							 <td>".$Departamento->getNombredepartamento()."/".$Cargo->getNombrecargo()."</td>
							 <td class='text-right'>
								 <a href='#' class='btn btn-simple btn-danger btn-icon remove'><i class='material-icons'>close</i></a>
						 </td>
							</tr>


						";
					//FIN IMPRIMIR
				}
			}



		}
		mysqli_close($cnx);
		return $totAPagar;
	}

?>


<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
	if(trim($_POST['numDoc']) == ""){
		header('Location: Prestaciones_Laborales.php');
		exit();
	}
	 	?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	<link rel="icon" type="image/png" href="../img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ASCAS, S.A. DE C.V.</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!--  Material Dashboard CSS  -->
    <link href="../css/material-dashboard.css" rel="stylesheet"/>

    <!--custom css-->
    <link rel="stylesheet"  href="../css/customMainCSS.css">
		<!-- Date -->
		<link rel="stylesheet" href="../css/jquery.datepicker.css">
		<!-- for alert -->
		<script src="../dist/sweetalert.js"></script>
    <link rel="stylesheet" href="../dist/sweetalert.css">
</head>

<body>
	<div class="wrapper">
		<!-- Navigation -->
			<?php include 'barra.php'; ?>

	    <!-- Page Content -->
		<div class="main-panel">
			<!-- Header -->
			<?php include 'header.php'; ?>
	        <div class="content">
	            <div class="container-fluid">
	              <?php
                  $NumeroDocumento=$_POST["numDoc"];
                  $empleado=new empleado_class();
                  $empleado=getInfoEmpleado($NumeroDocumento);
									$cargoNE=getInfoCargos($empleado->getIdcargos());
									echo "<div>";
									echo "<div>";
									echo "<div class='NOT_CHANGE'>";
									echo "<input type='hidden' id='salario_minimo_mensual' value=".getSalarioMinimo($empleado->getIdcargos()).">";
									echo "<input type='hidden' id='fecha_contratacion' value=".$empleado->getFechaingreso().">";
									echo "<input type='hidden' id='renta_total' value='0.00'>";
									echo "<input type='hidden' id='aux_total_renta_salario' value='0.00'>";
									echo "<input type='hidden' id='aux_total_renta_vacacion' value='0.00'>";
									echo "</div>";
									echo "</div>";
									echo "</div>";
                 ?>
                 <div class="row">
                    <div class="col-md-8">
 	            			      <div class="card" style="padding:10px;">
                            <div class="header">
            									<h4 class="title">INFORMACION DEL EMPLEADO</h4>
            								</div>
            								<div class="content">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Nombre</label>
                                    <input disabled id="nombre" type="text" class="form-control"  value="<?php echo $empleado->getPrimernombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido(); ?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Cargo</label>
                                    <input disabled id="cargo" type="text" class="form-control"  value="<?php echo $cargoNE->getNombrecargo(); ?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>DUI</label>
                                    <input disabled id="dui" type="text" class="form-control"  value="<?php echo $empleado->getNumerodocumento(); ?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>NIT</label>
                                    <input disabled id="nit" type="text" class="form-control" placeholder="Se necesita actualizar" value="<?php echo $empleado->getNit(); ?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Fecha Ingreso</label>
                                    <input disabled id="fechaI" type="text" class="form-control"  value="<?php echo $empleado->getFechaingreso(); ?>">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Salario Mensual</label>
                                    <input disabled id="SMensual" type="number" class="form-control" placeholder="Por Ejemplo: $ 251.70" value="<?php echo number_format((double)$empleado->getSalarionominal(), 2, '.', ''); ?>">
                                  </div>
                                </div>
																<div class="col-md-12">
											            <div class="card">
											                <div class="card-content">
																<h4 class="card-title">Calcular</h4>

																<div class="table-responsive">
																	<table class="table">
												                        <thead class="text-primary">
												                            <th>PRESTACION</th>
												                            <th>ACTIVAR CALCULO	</th>
												                            <th>DESDE</th>
												                            <th>HASTA</th>
																										<th>CALCULAR</th>
																										<th>MONTO</th>
												                        </thead>
												                        <tbody>
												                            <tr>
												                                <td>Vacacion</td>
												                                <td>
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" name="optionsCheckboxes" id="checkbox_vacaciones">
																														</label>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input disabled type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateVI" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateVF" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
																												<td>
																													<button type="button" id="btnV" disabled class="btn btn-fill btn-rose" onclick="Funcion_verificar_calculo_vacaciones()">Calcular</button>
																												</td>
																												<td class="text-primary">
																													$<input disabled id="MontoV" type="number" style="width:85%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
																												</td>
												                            </tr>
																										<tr>
												                                <td>Indemnizacion</td>
												                                <td>
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" name="optionsCheckboxes" id="checkbox_liquidacion">
																														</label>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateLI" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateLF" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
																												<td>
																													<button type="button" id="btnL" disabled class="btn btn-fill btn-rose" onclick="Funcion_verificar_calculo_Liquidacion()">Calcular</button>
																												</td>
																												<td class="text-primary">
																													$<input disabled id="MontoL" type="number" style="width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
																												</td>
												                            </tr>
																										<tr>
												                                <td>Aguinaldo</td>
												                                <td>
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" name="optionsCheckboxes" id="checkbox_Aguinaldo">
																														</label>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateAI" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateAF" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
																												<td>
																													<button type="button" id="btnA" disabled class="btn btn-fill btn-rose" onclick="Funcion_verificar_calculo_Aguinaldo()">Calcular</button>
																												</td>
																												<td class="text-primary">
																													$<input disabled id="MontoA" type="number" style="width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
																												</td>
												                            </tr>
																										<tr>
												                                <td>Salario</td>
												                                <td>
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" name="optionsCheckboxes" id="checkbox_Salario">
																														</label>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateSI" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateSF" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
																												<td>
																													<button type="button" id="btnS" disabled class="btn btn-fill btn-rose" onclick="Funcion_verificar_calculo_Salario()">Calcular</button>
																												</td>
																												<td class="text-primary">
																													$<input disabled id="MontoS" type="number" style="width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
																												</td>
												                            </tr>
																										<tr>
												                                <td>Retiro Voluntario	</td>
												                                <td>
																													<div class="checkbox">
																														<label>
																															<input type="checkbox" name="optionsCheckboxes"  id="checkbox_Retiro_Voluntario">
																														</label>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateRVI" data-select="datepicker"/>
																														</div>
																													</div>
																												</td>
												                                <td>
																													<div class="form-group">
																														<div class='input-group date' id='datetimepicker1'>
																															<input type='text' class="form-control" placeholder="<?php echo date("d")."/".date("m")."/".date("Y"); ?>" name="date" id="dateRVF" data-select="datepicker"/>
																						                </div>
																													</div>

																												</td>
																												<td>
																													<button type="button" id="btnRV" disabled class="btn btn-fill btn-rose" onclick="Funcion_verificar_calculo_Retiro_Voluntario()">Calcular</button>
																												</td>
																												<td class="text-primary">
																													$<input disabled id="MontoRV" type="number" style="width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
																												</td>
												                            </tr>
												                        </tbody>
												                    </table>
																					</div>
																					<div class="row">
																						<button type="button" id="btnImp"disabled class="btn btn-fill btn-rose" onclick="imprimir()">Imprimir</button>
																					</div>
											                </div>
											            </div>
																	<div>
																		<div>
																			<div>
																				<div>
																						<form method="POST" action="Recibo_Prestaciones_Laborales.php" id="PDFUserForm">
																							<input type="hidden" id="NumeroDeDocumento" name="NumeroDeDocumento" value="0.00" />
																							<input type="hidden" id="FEV" name="FEV" />
																							<input type="hidden" id="FSV" name="FSV" />
																							<input type="hidden" id="FES" name="FES" />
																							<input type="hidden" id="FSS" name="FSS" />
																							<input type="hidden" id="FEA" name="FEA" />
																							<input type="hidden" id="FSA" name="FSA" />
																							<input type="hidden" id="FEL" name="FEL" />
																							<input type="hidden" id="FSL" name="FSL" />
																							<input type="hidden" id="FERV" name="FERV"/>
																							<input type="hidden" id="FSRV" name="FSRV"/>
																							<input type="hidden" id="SMin" name="SMin"/>
																							<input type="hidden" id="FCONT" name="FCONT"/>
																							<input type="hidden" id="CODACCESS" name="CODACCESS"/>
																							<div class="text-center" id="respuestaAlert"></div>
																						</form>
																				</div>
																			</div>
																		</div>
																	</div>
											        </div>
                            </div>
                          </div>
                    </div>
                 </div>

								 <!-- Recibo de la parte de la derecha -->
					<div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <!--<img src="Herramientas/Imagenes/tiempo.png" alt="..."/>-->
              </div>
              <div class="content">
                <div class="author" style="margin: 0 auto;">
									<div class="card-header card-header-text" data-background-color="rose">
										<h4 class="card-title">RECIBO RESUMIDO</h4>
									</div>
								</div>
								<br>
								<br>
                <div class="content table-responsive">
                  <div class="container-fluid">
                    <table style="margin: 0 auto;" >
                      <tbody>
                        <tr>
                          <th scope="col" >CONCEPTO</th>
                          <th scope="col" class="text-center">VALOR</th>
                        </tr>
                        <tr>
                          <td><em>SALARIO </em></td>
                          <td><div>
														<input disabled id="MontoTSalario" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td><em>VACACIÓN</em></td>
                          <td><div >
														<input disabled id="MontoTVacacion" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td><em>INDEMNIZACION</em></td>
                          <td><div >
														<input disabled id="MontoTLiquidacion" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td><em>AGUINALDO</em></td>
                          <td><div >
														<input disabled id="MontoTAguinaldo" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
												<tr>
                          <td><em>RETIRO VOLUNTARIO</em></td>
                          <td><div >
														<input disabled id="MontoTRetiroVoluntario" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
												<tr>

												</tr>
                        <tr>
                          <td><strong>SUB TOTAL</strong></td>
                          <td><div> <strong>
														<input disabled id="SubTotal" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                              </strong> </div></td>
                        </tr>
                        <tr>
                          <td>I.S.S.S</td>
                          <td><div>
														<input disabled id="MontoTISS" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td>A.F.P.</td>
                          <td><div>
														<input disabled id="MontoTAFP" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td>RENTA</td>
                          <td><div>
														<input disabled id="MontoTRenta" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td>TOTAL DESCUENTOS</td>
                          <td><div>
														<input disabled id="MontoTDescuentos" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
                            </div></td>
                        </tr>
                        <tr>
                          <td><strong>TOTAL A RECIBIR</strong></td>
                          <td><div><strong>
														<input disabled id="MontoTARecibir" type="number" style="text-align: right;width:80%;background-color:#FFF;outline:none;border:0px solid;" placeholder="0.00" value="0.00" required>
													</strong></div></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <hr>
              <div class="text-center">
              </div>
            </div>
          </div>




	            </div>
	        </div>
	    </div>
	</div>

        <!--   Core JS Files   -->
    <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../js/material.min.js" type="text/javascript"></script>
    <script src="../js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <!-- Forms Validations Plugin -->
    <script src="../js/jquery.validate.min.js"></script>
    <!-- Material Dashboard javascript methods -->
    <script src="../js/material-dashboard.js"></script>
    <!-- Main js -->
    <script src="../js/main.js"></script>
		<!--  DateTime -->
		<script type="text/javascript" src="../js/jquery.datepicker.js"></script>
		<!-- script -->
		<script type="text/javascript" language="javascript">
		var codPL = {
			"V": 0,
			"L": 0,
			"A": 0,
			"S": 0,
			"RV": 0,
			"N": 0
		};

		//funcion para llenar el recibo resumido
		function imprimir(){

			swal({
			  title: "¿Desea confirmar esta acción?",
			  text: "Las fechas y valores no podrán ser modificadas luego de ser almacenadas!",
			  type: "info",
			  showCancelButton: true,
			  closeOnConfirm: false,
			  showLoaderOnConfirm: true
			}, function () {
			  setTimeout(function () {
			    swal("Guardando!", "El recibo se mostrará en unos instantes", "success");
					document.getElementById("NumeroDeDocumento").value="<?php echo $NumeroDocumento; ?>";
					//alert(codPL["V"]);
					document.getElementById("CODACCESS").value=JSON.stringify(codPL);
					//enviando las fechas de vacacion
					if(codPL["V"]==1){
						document.getElementById("FEV").value= new Date(stringToDate($("#dateVI").val()));
						document.getElementById("FSV").value= new Date(stringToDate($("#dateVF").val()));
					}
					//enviando las fechas de salario
					if(codPL["S"]==1){
						document.getElementById("FES").value= new Date(stringToDate($("#dateSI").val()));
						document.getElementById("FSS").value= new Date(stringToDate($("#dateSF").val()));
					}
					//enviando las fechas de Aguinaldo
					if(codPL["A"]==1){
						document.getElementById("FCONT").value= new Date(stringToDate($("#fecha_contratacion").val()));
						document.getElementById("FEA").value= new Date(stringToDate($("#dateAI").val()));
						document.getElementById("FSA").value= new Date(stringToDate($("#dateAF").val()));
					}
					//enviando las fechas de Liquidacion
					if(codPL["L"]==1){
						document.getElementById("SMin").value= parseFloat($("#salario_minimo_mensual").val());
						document.getElementById("FEL").value= new Date(stringToDate($("#dateLI").val()));
						document.getElementById("FSL").value= new Date(stringToDate($("#dateLF").val()));
					}
					//enviando las fechas de	Retiro Voluntario
					if(codPL["RV"]==1){
						document.getElementById("SMin").value= parseFloat($("#salario_minimo_mensual").val());
						document.getElementById("FERV").value= new Date(stringToDate($("#dateRVI").val()));
						document.getElementById("FSRV").value= new Date(stringToDate($("#dateRVF").val()));
					}
					//viajar a Recibo
					document.getElementById("PDFUserForm").submit();


			  }, 2000);
			});

		}
		function reciboResumido(){
			var salarioRR=0.00;
			var vacacionRR=0.00;
			var liquidacionRR=0.00;
			var aguinaldoRR=0.00;
			var SubTotalRR=0.00;
			var retiroVoluntarioRR=0.00;
			var issRR=0.00;
			var afpRR=0.00;
			var rentaRR=0.00;
			var totalRR=0.00;
			var descuentoR=0.00;
			var vacacion = 0.00;
			var salarioAux=0.00;
			var vacacion_salario=0.00;
			var issAux=0.00;
			var afpAux=0.00;
			if(document.getElementById("checkbox_vacaciones").checked){
				vacacion = parseFloat(document.getElementById('MontoV').value);
				vacacion_salario=vacacion/1.3;
				salarioRR=parseFloat(salarioRR)+parseFloat(vacacion_salario);
				vacacionRR=parseFloat(vacacion-salarioRR)+vacacionRR;
				issAux=vacacion*0.03;
				issRR=parseFloat(issAux)+issRR;
				issAux=0.00;
				afpAux=vacacion*0.0625;
				afpRR=parseFloat(afpAux)+afpRR;
				afpAux=0.00;
			}
			if(document.getElementById("checkbox_liquidacion").checked){
				salarioAux = parseFloat(document.getElementById('MontoL').value);
				liquidacionRR=parseFloat(liquidacionRR)+salarioAux;
			}
			if(document.getElementById("checkbox_Aguinaldo").checked){
				salarioAux = parseFloat(document.getElementById('MontoA').value);
				aguinaldoRR=parseFloat(aguinaldoRR)+salarioAux;
			}
			if(document.getElementById("checkbox_Salario").checked){
				salarioAux = parseFloat(document.getElementById('MontoS').value);
				salarioRR=parseFloat(salarioRR)+salarioAux;
				issAux=salarioAux*0.03;
				issRR=parseFloat(issAux)+issRR;
				issAux=0.00;
				afpAux=salarioAux*0.0625;
				afpRR=parseFloat(afpAux)+afpRR;
				afpAux=0.00;
			}
			if(document.getElementById("checkbox_Retiro_Voluntario").checked){
				salarioAux = parseFloat(document.getElementById('MontoRV').value);
				retiroVoluntarioRR=parseFloat(retiroVoluntarioRR)+salarioAux;
			}
			aux_total_renta_salario = parseFloat(document.getElementById('aux_total_renta_salario').value);
			aux_total_renta_vacacion = parseFloat(document.getElementById('aux_total_renta_vacacion').value);
			renta_total = aux_total_renta_vacacion+ aux_total_renta_salario;
			rentaRR=renta_total;
			descuentoR=issRR+afpRR+rentaRR;
			totalRR=salarioRR+vacacionRR+liquidacionRR+aguinaldoRR+retiroVoluntarioRR-issRR-afpRR-rentaRR;
			SubTotalRR=salarioRR+vacacionRR+liquidacionRR+aguinaldoRR+retiroVoluntarioRR;
			document.getElementById("MontoTSalario").value=salarioRR.toFixed(2);
			document.getElementById("MontoTLiquidacion").value=liquidacionRR.toFixed(2);
			document.getElementById("MontoTAguinaldo").value=aguinaldoRR.toFixed(2);
			document.getElementById("MontoTVacacion").value=vacacionRR.toFixed(2);
			document.getElementById("MontoTRetiroVoluntario").value=retiroVoluntarioRR.toFixed(2);
			document.getElementById("SubTotal").value=SubTotalRR.toFixed(2);
			document.getElementById("MontoTISS").value=issRR.toFixed(2);
			document.getElementById("MontoTAFP").value=afpRR.toFixed(2);
			document.getElementById("MontoTDescuentos").value=descuentoR.toFixed(2);
			document.getElementById("MontoTARecibir").value=totalRR.toFixed(2);
			document.getElementById("MontoTRenta").value=renta_total.toFixed(2);
			document.getElementById("renta_total").value=renta_total.toFixed(2);

		}


		function des_btn_imprimir(){
			if((document.getElementById("checkbox_Retiro_Voluntario").checked == false)&&
				 (document.getElementById("checkbox_Salario").checked == false)&&
				 (document.getElementById("checkbox_Aguinaldo").checked == false)&&
				 (document.getElementById("checkbox_liquidacion").checked == false)&&
				 (document.getElementById("checkbox_vacaciones").checked == false)
			){
				$("#btnImp").attr("disabled", true);
			}
		}
		function habilitar_btn_imprimir(){
				$("#btnImp").removeAttr("disabled");
		}


			function stringToDate(str){
			    var date = str.split("/"),
			        d = date[0],
							m = date[1],
			        y = date[2];
			    return ((y + "/" + m + "/" + d));
			}



			function formatDate(date) {
				var monthNames = {
			    "Jan": 1, "Feb": 2, "Mar": 3,
			    "Apr": 4, "May": 5, "Jun": 6, "Jul": 7,
			    "Aug": 8, "Sep": 9, "Oct": 10,
			    "Nov": 11, "Dec": 12
			  };
			  var str = date.split(' ');

			  return str[3]+"/"+monthNames[str[1]]+"/"+str[2];
			}

//Liquidacion
		$(function() {
		  habilitar_Liquidacion();
		  $("#checkbox_liquidacion").click(habilitar_Liquidacion);
		});
		function habilitar_Liquidacion() {
			if (this.checked) {
			document.getElementById("checkbox_Retiro_Voluntario").checked = false;
			habilitar_Retiro_Voluntario();
			$("#dateLI").removeAttr("disabled");
			$("#dateLF").removeAttr("disabled");
			$("#btnL").removeAttr("disabled");
			} else {
				document.getElementById("MontoL").value=0.00;
				codPL['L']=0;
				reciboResumido();
				des_btn_imprimir()
				$("#dateLI").attr("disabled", true);
				$("#dateLF").attr("disabled", true);
				$("#btnL").attr("disabled", true);
			}
		}

		//Liquidacion / ahora Indemnizacion
		function Funcion_verificar_calculo_Liquidacion(){
			var d1 = new Date(stringToDate($("#dateLI").val()));
			var d2 = new Date(stringToDate($("#dateLF").val()));
				if($("#SMensual").val()<=0){
						swal("El salario mensual no puede ser igual o menor a cero");
					}else if($("#dateLI").val()==""){
						swal("Por favor verifica que hayas detallado la fecha inicial del calculo para las Liquidacion");
					}else if($("#dateLF").val()==""){
						swal("Por favor verifica que hayas detallado la fecha final del calculo para las Liquidacion");
					}else if(d1>d2){
						swal("La fecha de inicial no puede ser mayor a la final en Liquidacion");
					}else{
						//AJAX
						var d1A = stringToDate($("#dateLI").val());
						var d2A = stringToDate($("#dateLF").val());
						var NumeroDocumento = <?php echo json_encode($NumeroDocumento); ?>;
						$.ajax({
							url:'../php/verificar_fechas.php',
							type:'POST',
							dataType: 'json',
							cache: false,
							data:{
								Tp:2,
								d1:d1A,
								d2:d2A,
								NumeroDocumento:NumeroDocumento
							},
							beforeSend: function(){
							},
							success:  function (response) {
										 flag=parseInt(response[0]);
										 d_mala=response[1];
										 d_rango1=response[2];
										 d_rango2=response[3];
										 if(flag==1){
										 	var salario_minimo_mensual = parseFloat($("#salario_minimo_mensual").val());
											var salario_mensual = parseFloat($("#SMensual").val());
											//Esto es para PHP
											//esto se enviara al PHP
											var parametros = {
																	"opc" : 3,
																	"d1"	:	d1,
																	"d2"	:	d2,
																	"salario_mensual" : salario_mensual,
																	"salario_minimo_mensual" : salario_minimo_mensual
																};
																$.ajax({
																			 data:  parametros,
																			 url:   'Calculos_Prestaciones_Laborales.php',
																			 type:  'post',
																			 dataType: 'json',
																			 cache: false,
																			 beforeSend: function () {
																							 $("#resultado").html("Procesando, espere por favor...");
																			 },
																			 success:  function (response) {
																							$("#MontoL").val(parseFloat(response[0]));
																							codPL['L']=1;
																							reciboResumido();
																							habilitar_btn_imprimir();
																			 }
															 });

															//Se termino lo de PHP
															//alert(d1+" "+d2+" Tot: "+diff);
															//document.getElementById("MontoL").value=Tot_a_pagar.toFixed(2);
															//habilitar_btn_imprimir();
										 }else{
										 	swal("La fecha "+d_mala+" Ya se encuentra en el calculo de "+d_rango1+" - "+d_rango2);
										 }

							}
							});
						//FIN AJAX


					};

		}

		//Vacacion
		// habilitar fecha de las vacacion
				$(function() {
				  habilitar_vaca();
				  $("#checkbox_vacaciones").click(habilitar_vaca);
				});

		function habilitar_vaca() {
		  if (this.checked) {
			$("#dateVI").removeAttr("disabled");
			$("#dateVF").removeAttr("disabled");
			$("#btnV").removeAttr("disabled");
		  } else {
				//Eliminar renta anterior de salario
				var renta_total=parseFloat($("#renta_total").val());
				var aux_total_renta_vacacion=parseFloat($("#aux_total_renta_vacacion").val());
				var N_tot_renta=renta_total-aux_total_renta_vacacion;
				document.getElementById("renta_total").value=N_tot_renta.toFixed(2);
				document.getElementById("MontoTRenta").value=N_tot_renta.toFixed(2);
				//fin
			document.getElementById("MontoV").value=0.00;
			document.getElementById("aux_total_renta_vacacion").value=0.00;
			codPL['V']=0;
			reciboResumido();
			des_btn_imprimir()
			$("#dateVI").attr("disabled", true);
			$("#dateVF").attr("disabled", true);
			$("#btnV").attr("disabled", true);
		  }
		}
		function Funcion_verificar_calculo_vacaciones() {
			var d1 = new Date(stringToDate($("#dateVI").val()));
			var d2 = new Date(stringToDate($("#dateVF").val()));
			var flag=0;
				if($("#SMensual").val()<=0){
						swal("El salario mensual no puede ser igual o menor a cero");
					}else if($("#dateVI").val()==""){
						swal("Por favor verifica que hayas detallado la fecha inicial del calculo para las vacaciones");
					}else if($("#dateVF").val()==""){
						swal("Por favor verifica que hayas detallado la fecha final del calculo para las vacaciones");
					}else if(d1>d2){
						swal("La fecha de inicial no puede ser mayor a la final");
					}else{

									//AJAX
									var d1A = stringToDate($("#dateVI").val());
									var d2A = stringToDate($("#dateVF").val());
									var NumeroDocumento = <?php echo json_encode($NumeroDocumento); ?>;
									$.ajax({
										url:'../php/verificar_fechas.php',
										type:'POST',
										dataType: 'json',
										cache: false,
										data:{
											Tp:1,
											d1:d1A,
											d2:d2A,
											NumeroDocumento:NumeroDocumento
										},
										beforeSend: function(){
										},
										success:  function (response) {
													 flag=parseInt(response[0]);
													 d_mala=response[1];
													 d_rango1=response[2];
													 d_rango2=response[3];
													 if(flag==1){
													 	var salario_mensual = parseFloat($("#SMensual").val());
													 	//Eliminar renta anterior de salario
													 	var renta_total=parseFloat($("#renta_total").val());
													 	var aux_total_renta_vacacion=parseFloat($("#aux_total_renta_vacacion").val());
													 	var N_tot_renta=renta_total-aux_total_renta_vacacion;
													 	document.getElementById("renta_total").value=N_tot_renta.toFixed(2);
													 	document.getElementById("MontoTRenta").value=N_tot_renta.toFixed(2);
													 	//Esto es para PHP
													 		//esto se enviara al PHP
													 		var parametros = {
													 			"opc" : 1,
													 			"d1"	:	d1,
													 			"d2"	:	d2,
													 			"salario_mensual" : salario_mensual
													 		};
													 		$.ajax({
													 					 data:  parametros,
													 					 url:   'Calculos_Prestaciones_Laborales.php',
													 					 type:  'post',
													 					 dataType: 'json',
													 					 cache: false,
													 					 beforeSend: function () {
													 									 $("#resultado").html("Procesando, espere por favor...");
													 					 },
													 					 success:  function (response) {
													 									$("#MontoV").val(parseFloat(response[0]));
													 									$("#aux_total_renta_vacacion").val(response[1]);
													 									codPL['V']=1;
													 									reciboResumido();
													 									habilitar_btn_imprimir();
													 					 }
													 	 });
													 	 //Se termino lo de PHP
													 	//document.getElementById("MontoV").value=Tot_a_pagar.toFixed(2);
													 }else{
													 	swal("La fecha "+d_mala+" Ya se encuentra en el calculo de "+d_rango1+" - "+d_rango2);
													 }

										}
										});
									//FIN AJAX

					};
				};


				//Aguinaldo
						$(function() {
						  habilitar_Aguinaldo();
						  $("#checkbox_Aguinaldo").click(habilitar_Aguinaldo);
						});
						function habilitar_Aguinaldo() {
							if (this.checked) {
							$("#dateAI").removeAttr("disabled");
							$("#dateAF").removeAttr("disabled");
							$("#btnA").removeAttr("disabled");
							} else {
								des_btn_imprimir()
								document.getElementById("MontoA").value=0.00;
								codPL['A']=0;
								reciboResumido();
								$("#dateAI").attr("disabled", true);
								$("#dateAF").attr("disabled", true);
								$("#btnA").attr("disabled", true);
							}
						}


						function Funcion_verificar_calculo_Aguinaldo(){
							var d1 = new Date(stringToDate($("#dateAI").val()));
							var d2 = new Date(stringToDate($("#dateAF").val()));
							var fecha_contratacion = new Date(stringToDate($("#fecha_contratacion").val()));
								if($("#SMensual").val()<=0){
										swal("El salario mensual no puede ser igual o menor a cero");
									}else if($("#dateAI").val()==""){
										swal("Por favor verifica que hayas detallado la fecha inicial del calculo en Aguinaldo");
									}else if($("#dateAF").val()==""){
										swal("Por favor verifica que hayas detallado la fecha final del calculo en Aguinaldo");
									}else if(d1>d2){
										swal("La fecha de inicial no puede ser mayor a la final en Aguinaldo");
									}else if($("#fecha_contratacion").val()==""){
										swal("Por favor verifica que el usuario tenga una fecha de contratacion");
									}else if(fecha_contratacion>d1){
										swal("La fecha de inicial no puede ser mayor a la fecha de contratacion en Aguinaldo");
									}else{

										//AJAX
										var d1A = stringToDate($("#dateAI").val());
										var d2A = stringToDate($("#dateAF").val());
										var NumeroDocumento = <?php echo json_encode($NumeroDocumento); ?>;
										$.ajax({
											url:'../php/verificar_fechas.php',
											type:'POST',
											dataType: 'json',
											cache: false,
											data:{
												Tp:3,
												d1:d1A,
												d2:d2A,
												NumeroDocumento:NumeroDocumento
											},
											beforeSend: function(){
											},
											success:  function (response) {
														 flag=parseInt(response[0]);
														 d_mala=response[1];
														 d_rango1=response[2];
														 d_rango2=response[3];
														 if(flag==1){
														 	var salario_mensual = parseFloat($("#SMensual").val());
														 	//Esto es para PHP
														 		//esto se enviara al PHP
														 		var parametros = {
														 			"opc" : 4,
														 			"d1"	:	d1,
														 			"d2"	:	d2,
														 			"salario_mensual" : salario_mensual,
														 			"fecha_contratacion"	:	fecha_contratacion
														 		};
														 		$.ajax({
														 					 data:  parametros,
														 					 url:   'Calculos_Prestaciones_Laborales.php',
														 					 type:  'post',
														 					 dataType: 'json',
														 					 cache: false,
														 					 beforeSend: function () {
														 									 $("#resultado").html("Procesando, espere por favor...");
														 					 },
														 					 success:  function (response) {
														 									$("#MontoA").val(parseFloat(response[0]));
														 									reciboResumido();
														 									codPL['A']=1;
														 									habilitar_btn_imprimir();
														 					 }
														 	 });
														 }else{
														 	swal("La fecha "+d_mala+" Ya se encuentra en el calculo de "+d_rango1+" - "+d_rango2);
														 }
											}
											});
										//FIN AJAX

									}
						}

						//Salario
								$(function() {
									habilitar_Salario();
									$("#checkbox_Salario").click(habilitar_Salario);
								});
								function habilitar_Salario() {
									if (this.checked) {
									$("#dateSI").removeAttr("disabled");
									$("#dateSF").removeAttr("disabled");
									$("#btnS").removeAttr("disabled");
									} else {
										des_btn_imprimir();
										document.getElementById("MontoS").value=0.00;
										document.getElementById("aux_total_renta_salario").value=0.00;
										codPL['S']=0;
										reciboResumido();
									$("#dateSI").attr("disabled", true);
									$("#dateSF").attr("disabled", true);
									$("#btnS").attr("disabled", true);
									}
								}


								function Funcion_verificar_calculo_Salario(){
									var d1 = new Date(stringToDate($("#dateSI").val()));
									var d2 = new Date(stringToDate($("#dateSF").val()));
									var fecha_contratacion = new Date(stringToDate($("#fecha_contratacion").val()));
										if($("#SMensual").val()<=0){
												swal("El salario mensual no puede ser igual o menor a cero");
											}else if($("#dateSI").val()==""){
												swal("Por favor verifica que hayas detallado la fecha inicial del calculo de Salario");
											}else if($("#dateSF").val()==""){
												swal("Por favor verifica que hayas detallado la fecha final del calculo de Salario");
											}else if(d1>d2){
												swal("La fecha de inicial no puede ser mayor a la final en Salario");
											}else if($("#fecha_contratacion").val()==""){
												swal("Por favor verifica que el usuario tenga una fecha de contratacion");
											}else if(fecha_contratacion>d1){
												swal("No se le puede pagar Salario por meses en el que no pertenecia a la empresa, el usuario ingreso:"+formatDate(fecha_contratacion.toString()));
											}else{
												//AJAX
												var d1A = stringToDate($("#dateSI").val());
												var d2A = stringToDate($("#dateSF").val());
												var NumeroDocumento = <?php echo json_encode($NumeroDocumento); ?>;
												$.ajax({
													url:'../php/verificar_fechas.php',
													type:'POST',
													dataType: 'json',
													cache: false,
													data:{
														Tp:4,
														d1:d1A,
														d2:d2A,
														NumeroDocumento:NumeroDocumento
													},
													beforeSend: function(){

													},
													success:  function (response) {
																 flag=parseInt(response[0]);
																 d_mala=response[1];
																 d_rango1=response[2];
																 d_rango2=response[3];
																 if(flag==1){
																 	var salario_mensual = parseFloat($("#SMensual").val());
																 	//Eliminar renta anterior de salario
																 	var renta_total=parseFloat($("#renta_total").val());
																 	var aux_total_renta_salario=parseFloat($("#aux_total_renta_salario").val());
																 	var N_tot_renta=renta_total-aux_total_renta_salario;
																 	document.getElementById("renta_total").value=N_tot_renta.toFixed(2);
																 	document.getElementById("MontoTRenta").value=N_tot_renta.toFixed(2);

																 									//Esto es para PHP
																 										//esto se enviara al PHP
																 										var parametros = {
																 											"opc" : 2,
																 											"d1"	:	d1,
																 											"d2"	:	d2,
																 											"salario_mensual" : salario_mensual
																 										};
																 										$.ajax({
																 													 data:  parametros,
																 													 url:   'Calculos_Prestaciones_Laborales.php',
																 													 type:  'post',
																 													 dataType: 'json',
																             	 						cache: false,
																 													 beforeSend: function () {
																 																	 $("#resultado").html("Procesando, espere por favor...");
																 													 },
																 													 success:  function (response) {
																 																	$("#MontoS").val(parseFloat(response[0]));
																 																	$("#aux_total_renta_salario").val(response[1]);
																 																	reciboResumido();
																 																	codPL['S']=1;
																 																	habilitar_btn_imprimir();

																 													 }
																 									 });
																 									//Se termino lo de PHP

																 									//alert(d1+" "+d2+" Tot: "+diff);
																 									//document.getElementById("MontoS").value=Tot_a_pagar.toFixed(2);
																 }else{
																 	swal("La fecha "+d_mala+" Ya se encuentra en el calculo de "+d_rango1+" - "+d_rango2);
																 }

													}
													});
												//FIN AJAX

											};
								}

								//Retiro Voluntario
										$(function() {
											habilitar_Retiro_Voluntario();
											$("#checkbox_Retiro_Voluntario").click(habilitar_Retiro_Voluntario);
										});
										function habilitar_Retiro_Voluntario() {
											if (this.checked) {
											document.getElementById("checkbox_liquidacion").checked = false;
											habilitar_Liquidacion();
											$("#dateRVI").removeAttr("disabled");
											$("#dateRVF").removeAttr("disabled");
											$("#btnRV").removeAttr("disabled");
											} else {
												document.getElementById("MontoRV").value=0.00;
												codPL['RV']=0;
												reciboResumido();
												des_btn_imprimir()
											$("#dateRVI").attr("disabled", true);
											$("#dateRVF").attr("disabled", true);
											$("#btnRV").attr("disabled", true);
											}
										}


										function Funcion_verificar_calculo_Retiro_Voluntario(){
											var d1 = new Date(stringToDate($("#dateRVI").val()));
											var d2 = new Date(stringToDate($("#dateRVF").val()));
											var fecha_contratacion = new Date(stringToDate($("#fecha_contratacion").val()));
												if($("#SMensual").val()<=0){
														swal("El salario mensual no puede ser igual o menor a cero");
													}else if($("#dateRVI").val()==""){
														swal("Por favor verifica que hayas detallado la fecha inicial del calculo de Retiro Voluntario");
													}else if($("#dateRVF").val()==""){
														swal("Por favor verifica que hayas detallado la fecha final del calculo de Retiro Voluntario");
													}else if(d1>d2){
														swal("La fecha de inicial no puede ser mayor a la final en Retiro Voluntario");
													}else if($("#fecha_contratacion").val()==""){
														swal("Por favor verifica que el usuario tenga una fecha de contratacion");
													}else if(fecha_contratacion>d1){
														swal("No se le puede pagar Retiro Voluntario por meses en el que no pertenecia a la empresa, el usuario ingreso:"+formatDate(fecha_contratacion.toString()));
													}else{
														//AJAX
														var d1A = stringToDate($("#dateRVI").val());
														var d2A = stringToDate($("#dateRVF").val());
														var NumeroDocumento = <?php echo json_encode($NumeroDocumento); ?>;
														$.ajax({
															url:'../php/verificar_fechas.php',
															type:'POST',
															dataType: 'json',
															cache: false,
															data:{
																Tp:5,
																d1:d1A,
																d2:d2A,
																NumeroDocumento:NumeroDocumento
															},
															beforeSend: function(){
															},
															success:  function (response) {
																		 flag=parseInt(response[0]);
																		 d_mala=response[1];
																		 d_rango1=response[2];
																		 d_rango2=response[3];
																		 if(flag==1){
																		 	var salario_minimo_mensual = parseFloat($("#salario_minimo_mensual").val());
																			var salario_mensual = parseFloat($("#SMensual").val());
																			//Esto es para PHP
																			//esto se enviara al PHP
																			var parametros = {
																														"opc" : 5,
																														"d1"	:	d1,
																														"d2"	:	d2,
																														"salario_mensual" : salario_mensual,
																														"salario_minimo_mensual"	:	salario_minimo_mensual
																													};
																													$.ajax({
																																 data:  parametros,
																																 url:   'Calculos_Prestaciones_Laborales.php',
																																 type:  'post',
																																 dataType: 'json',
																																 cache: false,
																																 beforeSend: function () {
																																				 $("#resultado").html("Procesando, espere por favor...");
																																 },
																																 success:  function (response) {
																																				$("#MontoRV").val(parseFloat(response[0]));
																																				codPL['RV']=1;
																																				reciboResumido();
																																				habilitar_btn_imprimir();
																																 }
																												 });

																												//Se termino lo de PHP
																															//alert(d1+" "+d2+" Tot: "+diff);
																															//document.getElementById("MontoRV").value=Tot_a_pagar.toFixed(2);
																		 }else{
																		 	swal("La fecha "+d_mala+" Ya se encuentra en el calculo de "+d_rango1+" - "+d_rango2);
																		 }

															}
															});
														//FIN AJAX


													};
										}
		</script>
		</body>
</html>

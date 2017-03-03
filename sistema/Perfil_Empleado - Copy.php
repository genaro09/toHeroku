<?php 
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
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

	<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!--  Material Dashboard CSS  -->
    <link href="../css/material-dashboard.css" rel="stylesheet"/>
    <!--custom css-->
    <link rel="stylesheet"  href="../css/customMainCSS.css">
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
						<div class="row">
							<div class="col-md-12">
								<div class="card" style="padding:10px;">
									<div class="header">
										<h4 class="title">Editar Perfil</h4>
									</div>
									<div class="content">
										<form>

											<div class="nav-container">
												<div class="row nav nav-icons" role="tablist">
													<div class="col-sm-6 col-lg-3 active">
														<a href="#description-logo" role="tab" data-toggle="tab">
															<i class="pe-7s-users"></i><br>
															Datos Personales
														</a>
													</div>
													<div class="col-sm-6 col-lg-3"> <a href="#map-logo" role="tab" data-toggle="tab"> 
                                                    <i class="pe-7s-id"></i><br>
													  Datos Laborales </a> 
													</div>
													<div class="col-sm-6 col-lg-3">
														<a href="#legal-logo" role="tab" data-toggle="tab">
															<i class="pe-7s-note2"></i><br>
															Historial
														</a>
													</div>
													<div class="col-sm-6 col-lg-3">
														<a href="#help-logo" role="tab" data-toggle="tab">
															<i class="pe-7s-piggy"></i><br>
															Descuentos Programados
														</a>
													</div>
												</div>
											</div>

											<div class="tab-content">
												<?php
													$idEmpleado=$_POST["iduser"];
													$empleado=new empleado_class();
													$empleado=getInfoEmpleado($idEmpleado);

												?>
												<div class="tab-pane active" id="description-logo">
													<div class="card" style="padding:15px;">
														<div class="header">
															<h4 class="title">Datos Personales</h4>
														</div>

														<div class="content">
															<form>
																<div class="row">
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>CODIGO DE EMPLEADO</label>
																			<input type="text" class="form-control" disabled placeholder="cod_empleado" value="<?php echo $_POST["iduser"]; ?>">
																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label for="exampleInputEmail1">Correo Electronico<star>*</star></label>
																			<input type="email" class="form-control" placeholder="Email" value="<?php echo $empleado->getCorreoelectronico(); ?>" required>
																		</div>        
																	</div>
																</div>

																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Primer Nombre<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Oscar" value="<?php echo $empleado->getPrimernombre(); ?>" required>
																		</div>        
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Segundo Nombre</label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Arnulfo" value="<?php echo $empleado->getSegundonombre(); ?>">
																		</div>        
																	</div>

																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Primer Apellido<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Romero" value="<?php echo $empleado->getPrimerapellido(); ?>" required>
																		</div>        
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Segundo Apellido</label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Galdamez" value="<?php echo $empleado->getSegundoapellido(); ?>">
																		</div>        
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Apellido de Casada</label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: de Alvarenga" value="<?php echo $empleado->getApellidocasada(); ?>">
																		</div>        
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Conocido Por</label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Hijo" value="<?php echo $empleado->getConocidopor(); ?>">
																		</div>        
																	</div>

																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Estado Civil<star>*</star></label>
																			<select name="cities" class="selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
																				<?php
																					if($empleado->getEstadocivil()=='S'){
																						echo "
																							<option selected value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='C'){
																						echo "
																							<option  value='S'>Soltero</option>
																							<option selected value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='V'){
																						echo "
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option selected value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='D'){
																						echo "
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option selected value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='U'){
																						echo "
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option selected value='U'>Union Libre</option>
																						";
																					}else{
																						echo "
																							<option selected value='N'>Ninguna	</option>
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}
 


																				?>
																				

																			</select>

																		</div>        
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Fecha de Nacimiento<star>*</star></label>
																			<input type="text" class="form-control datetimepicker" placeholder="Ejemplo: 01/01/2016"/>
																		</div>        
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Tipo de Documento<star>*</star></label>
																			<select name="cities" class="selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
																				<?php 
																					if($empleado->getTipodocumento()=='CAR'){
																						echo "
																						<option selected value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else if($empleado->getTipodocumento()=='PAS'){
																						echo "
																						<option value='CAR'>Carnet de Residente</option>
																						<option selected value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else if($empleado->getTipodocumento()=='CMI'){
																						echo "
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option selected value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else if($empleado->getTipodocumento()=='DUI'){
																						echo "
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option selected value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else{
																						echo "
																						<option value='NULL'>Seleccione uno</option>
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}

																				?>


																			</select>
																		</div>        
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Numero de Documento<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: 042341492" value="<?php echo $empleado->getNumerodocumento();  ?>" required patterm="^[0-9]{9}$">
																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Telefono<star>*</star></label>
																			<input type="tel" class="form-control" placeholder="Por Ejemplo: 2555-5555" value="<?php echo (int)$empleado->getNumerotelefonico(); ?>" required>
																		</div>        
																	</div>                                                                                                                             
																</div>
															</form>
														</div>
													</div>
												</div>


												<div class="tab-pane" id="map-logo">
													<div class="card">
														<div class="header">
															<h4 class="title">Datos Laborales</h4>
														</div>

														<div class="content">
															<form>
																<div class="row">
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Numero de NIT<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: 0614-240290-105-5" value="" required>
																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Numero de I.S.S.S.<star>*</star></label>
																			<input type="number" class="form-control" placeholder="Por Ejemplo: 198953837" value="">
																		</div>        
																	</div>                            
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Numero del IMPEP</label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: 04234149-2" value="">
																		</div>        
																	</div>                                       

																	<div class="col-md-4 col-md-offset-1">
																		<div class="form-group">
																			<label>Nombre de AFP<star>*</star></label>
																			<select name="T_AFP" class="selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																				<option value="00">Confia</option>
																				<option value="01">Crecer</option>
																				<option value="02">IPFA</option>
																				<option value="03">UPISSS</option>

																			</select>
																		</div>       
																	</div>  
																	<div class="col-md-4 col-md-offset-1">
																		<div class="form-group">
																			<label>Numero de NUP<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: 04234149-2" value="">
																		</div>        
																	</div>  



																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Salario Mensual<star>*</star></label>
																			<input type="number" class="form-control" placeholder="Por Ejemplo: $ 251.70" value="" required>
																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Cargo<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Motorista" value="" required>
																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Area de Trabajo<star>*</star></label>
																			<input type="text" class="form-control" placeholder="Por Ejemplo: Contabilidad" value="" required>
																		</div>        
																	</div> 

																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Fecha de Ingreso<star>*</star></label>
																			<input type="text" class="form-control datetimepicker" placeholder="Ejemplo: 01/01/2016" required/>
																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Fecha de Retiro</label>
																			<input type="text" class="form-control datetimepicker" placeholder="Ejemplo: 01/01/2016"/>

																		</div>        
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Fecha de Fellecimiento</label>
																			<input type="text" class="form-control datetimepicker" placeholder="Ejemplo: 01/01/2016"/>
																		</div>        
																	</div>
                                                                    <div class="col-sm-4">
																		<div class="form-group">
																			<label>Horario de Entrada</label>
																			<input type="text" class="form-control timepicker" placeholder="Hora de Entrada"/>
																		</div>        
																	</div>
                                                                    <div class="col-sm-4">
																		<div class="form-group">
																			<label>Horario de Salida</label>
																			<input type="text" class="form-control timepicker" placeholder="Hora de Salida"/>
																		</div>        
																	</div>
                                                                    <div class="col-sm-4">
																		<div class="form-group">
																			<label>4 Horas de Descanso</label>
																			<input type="text" class="form-control timepicker" placeholder="Inicio H. Descanso"/>
																		</div>        
																	</div>
   																	<div class="col-md-4 col-md-offset-1">
																		<div class="form-group">
																			<label>Banco</label>
																			<select name="T_AFP" class="selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																				<option value="00">Cuscatlan</option>
																				<option value="01">America Cental</option>
																				<option value="02">Promerica</option>
																				<option value="03">Hipotecario</option>
																				<option value="03">Agricola</option>
																				<option value="03">HSBC</option>
																				<option value="03">Banco Azul</option>                                                                               
																			</select>
																		</div>       
																	</div>
                                                                    <div class="col-md-4 col-md-offset-1">
																		<div class="form-group">
																			<label>Cuenta Bancaria</label>
																			<input type="number" class="form-control" value="">
																		</div>        
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>


												<div class="tab-pane" id="legal-logo">
													<div class="card">
														<div class="header">
															<h4 class="title">Expediente Permanente</h4>
															<p class="category">More information here</p>
														</div>

														<div class="content">
															<p>The first...</p>
														</div>
													</div>
												</div>

												<div class="tab-pane" id="help-logo">
													<div class="card">
														<div class="header">
															<h4 class="title">Descuentos Programados</h4>
															<p class="category">More information here</p>
														</div>

														<div class="content">
															<p>From the seamless...</p>
														</div>
													</div>
												</div>
											</div>

											<button type="submit" class="btn btn-info btn-fill pull-right">Guardar Cambios</button>
											<div class="clearfix"></div>
										</form>
									</div>
								</div>
							</div>
						</div>                    
					</div>
				</div>
			</div>
	</div>
</body>
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

	<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
	<script src="../js/moment.min.js"></script>

	<!--  Charts Plugin -->
	<script src="../js/chartist.min.js"></script>

	<!--  Plugin for the Wizard -->
	<script src="../js/jquery.bootstrap-wizard.js"></script>

	<!--  Notifications Plugin    -->
	<script src="../js/bootstrap-notify.js"></script>

	<!-- DateTimePicker Plugin -->
	<script src="../js/bootstrap-datetimepicker.js"></script>

	<!-- Vector Map plugin -->
	<script src="../js/jquery-jvectormap.js"></script>

	<!-- Sliders Plugin -->
	<script src="../js/nouislider.min.js"></script>

	<!-- Select Plugin -->
	<script src="../js/jquery.dropdown.js"></script>

	<!--  DataTables.net Plugin    -->
	<script src="../js/jquery.datatables.js"></script>

	<!-- Sweet Alert 2 plugin -->
	<script src="../js/sweetalert2.js"></script>

	<!--  Full Calendar Plugin    -->
	<script src="../js/fullcalendar.min.js"></script>

	<!-- TagsInput Plugin -->
	<script src="../js/jquery.tagsinput.js"></script>

	<!-- Material Dashboard DEMO methods, don't include it in your project! -->
	<script src="../js/demo.js"></script>




    <!-- Main js -->
    <script src="../js/main.js"></script>

 <script type="text/javascript">
        $().ready(function(){

            // Init Sliders
            demo.initFormExtendedSliders();

            // Init DatetimePicker
            demo.initFormExtendedDatetimepickers();
			moment().format("ddd, hA"); 
        });
    </script>

</html>
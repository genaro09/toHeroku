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
    <link rel="stylesheet" type="text/css" href="../css/icons.css" />
		<link href="../css/font-awesome.min.css" rel="stylesheet">

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
				            <div class="card">
				                <div class="card-header card-header-icon" data-background-color="purple">
				                    <i class="material-icons">contacts</i>
				                </div>

				                <div class="card-content">
				                    <h4 class="card-title">NUEVO EMPLEADO</h4>
				                    <div class="material-datatables">
																<form id="form_agregarUser">
																<div class="form-group col-md-6">
																			<label>Tipo de Documento</label>
																				<br>
																				<select id="Tdocumento" name="cities" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option selected value='DUI'>Documento Unico de Identidad</option>
																				</select>
																</div>
																<div class="form-group col-md-6">
																	<label>Numero de Documento</label>
																		<label class="control-label"></label>
																		<input id="NumeroDocumento" name="NumeroDocumento"placeholder="12345678-9" type="text" class="form-control"  required="true">
																		<span class="help-block">El numero de documento NO PODRA SER MODIFICADO</span>
																</div>
																<div class="form-group col-md-6">
																				<label>Primer Nombre</label>
																				<input type="text" id="PrimerNombre" name="PrimerNombre" autofocus class="form-control" placeholder="Primer Nombre" required="true">
																</div>
																<div class="form-group col-md-6">
																				<label>Primer Apellido</label>
																				<input type="text" id="PrimerApellido" name="PrimerApellido" autofocus class="form-control" placeholder="Primer Apellido" required="true">
																</div>
																<div class="form-group col-md-6">
																				<label>Contraseña</label>
																				<input id="Pass" name="Pass" autofocus class="form-control" placeholder="123456" type="password" required="true">
																</div>
																 <div class="form-group col-md-6">
																				<label>Salario Nominal</label>
																				<input id="SMensual" type="text" name="number" number="true" aria-invalid="true" class="form-control" placeholder="Por Ejemplo: $ 251.70" required="true">
																</div>
																<div class="form-group col-md-6">
																			 <label>Horario Desde:</label>
																			 <input type="text" id="Desde" class="form-control timepicker" placeholder="06:00:00" required="true" />
															 </div>
															 <div class="form-group col-md-6">
																			<label>Horario Hasta:</label>
																			<input type="text" id="Hasta" class="form-control timepicker" placeholder="14:00:00" required="true" />
															</div>
															<div class="form-group col-md-6">
																		 <label>Fecha Ingreso</label>
																		 <div class='input-group date' id='datetimepicker1'>
																				<?php echo"<input style='width:100%;' type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='FechaIngreso' data-select='datepicker'/>";
																				?>
																		 </div>
														 </div>
														 <div class="form-group col-md-6">
																		<label>Turno</label>
																		<br>
																		<select id="idTurno" name="idTurno" class="form-control selectpicker">
																			<?php
																				$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
																				include "get_SelectTurno.php";
																				get_SelectAllTurnos($NitEmpresa);

																			?>
																		</select>
														</div>
														<div class="form-group col-md-6">
																	 <label>Departamento</label>
																	 <br>
																	 <select id='AreaTrabajo' name="AreaTrabajo" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																				<?php
																				 include 'get_Departamentos.php';
																				 echo "<option selected disabled value=0>Seleccione un departamento</option>";
																				 get_ALLDepartamentos(getNitEmpresa($_SESSION['usuario_sesion']));
																				?>
																	 </select>
													 </div>
													 <div class="form-group col-md-6">
																	<label>Cargo</label>
																	<br>
																	<select id='cargo' name="cargo" class="form-control selectpicker Cargo" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																		<?php
																				echo "<option selected value=0>Seleccione un departamento</option>";
																		?>
																	</select>
													</div>
																<div class="form-group col-md-6">
																				<label>Activo en la Empresa</label>
																				<select class="select form-control" id="activo">
																						<option value="1">Activo</option>
																						<option value="0">Inactivo</option>
																				</select>
																</div>
																 <div class="form-group col-md-6">
																				 <a href="#" id="btnAgregarUsuario" class="btn btn-rose btn-fill">Registrar</a>
																</div>

																<div class="form-group col-md-12">
																				<div class="text-center" id="respuestaAlert"></div>
																			 <div class="clearfix"></div>
															 </div>
															</form>
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
    <!-- Main js -->
    <script src="../js/main.js"></script>
		<!--  DateTime -->
		<script type="text/javascript" src="../js/jquery.datepicker.js"></script>
		<!-- Date -->
		<link rel="stylesheet" href="../css/jquery.datepicker.css">
		<script>
			$(document).ready(function(){
		    $("#AreaTrabajo").change(function(){
				  var id=$(this).val();
				  var dataString = 'id='+ id;
				  $.ajax({
				   type: "POST",
				   url: "../php/getALLCargos.php",
				   data: dataString,
				   cache: false,
				   success: function(html){
				      $("#cargo").html(html);
				   }
				   });

		    });
			});
		</script>
</html>

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
        <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script>
	$(document).ready(function(){
	    $("#annio").change(function(){
			  var id=$(this).val();
			  var dataString = 'id='+ id;
			  $.ajax({
			   type: "POST",
			   url: "get_Semana.php",
			   data: dataString,
			   cache: false,
			   success: function(html)
			   {
			      $("#semana").html(html);
			   }
			   });

	    });
	});
	$(document).ready(function(){
	    $("#idTurno").change(function(){
			  var id=$(this).val();
			  var anio=$("#annio").val();
			  var semana=$("#semana").val();
			  var dataString = 'id='+ id +';'+'annio='+anio;
			  $.ajax({
			   type: "POST",
			   url: "get_Fechas.php",
			   data:{
				id:id,
				anio:anio,
				semana:semana,
				dataString:dataString
				},
			   cache: false,
			   success: function(html)
			   {
			      $("#fechas").html(html);
			   }
			   });

	    });
	});
	</script>


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
									<h4 class="title">Agregar Semanal</h4>
								</div>
								<div class="content">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Año</label>
													<br>
														<select id="annio" name="annio" class="selectpicker">
															<?php
																$year=date("Y");
																for($i = 30; $i >= 1; $i--) {
																	$valor=$year-$i;
																    echo "<option id='".$valor."'>".$valor."</option>";
																}
																echo "<option selected id='".$year."'>".$year."</option>";
																for($i = 1; $i <= 30; $i++) {
																	$valor=$year+$i;
																    echo "<option id='".$valor."'>".$valor."</option>";
																}
															?>
														</select>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Semana</label>
													<br>
														<select id="semana" name="semana" class="selectpicker">
															<?php
																imprimirSemana($year);
															?>
														</select>
													</div>
											</div>
										</div>
	            				</div>
	            			</div>
	            			<div class="card" style="padding:10px;">
								<div class="header">
									<h4 class="title">Modificar Semanal</h4>
								</div>
								<div class="content">
										<div class="row">
											<form  id="form_actualizarSemanal" role="form">
												<div class="col-md-4">
													<div class="form-group">
														<label for="exampleInputEmail1">Turno</label>
														<br>
														<select id="idTurno" name="idTurno">
															<option>Ninguna</option>
														<?php
															$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
															include "get_SelectTurno.php";
															get_SelectTurnoP($NitEmpresa);
														?>
														</select>
													</div>
												</div>
												<div class="col-md-8">
													<div class="form-group">
														<label for="exampleInputEmail1">Semanal</label>
														<br>
														<div id="fechas" name="fechas">
														</div>
													</div>
												</div>
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





</html>

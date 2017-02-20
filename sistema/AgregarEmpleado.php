<?php 
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
 ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets//img/apple-icon.png" />
	<link rel="icon" type="image/png" href="assets//img/favicon.png" />
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
	               	<h3>Nuevo Empleado</h3>
	               	<form id="form_agregarUser">
	               		<div class="form-group col-md-6">
                                <label>Correo</label>
                        		<input type="email" id="email" name="email" autofocus class="form-control" placeholder="Correo" required>	
                        </div>
                        <div class="form-group col-md-6">
                                <label>Nombre</label>
                        		<input type="nombre" id="nombre" name="nombre" autofocus class="form-control" placeholder="Nombre" required>	
                        </div>
                        <div class="form-group col-md-6">
                                <label>DUI</label>
                        		<input type="dui" id="dui" name="dui" autofocus class="form-control" placeholder="DUI" required>	
                        </div>
                        <div class="form-group col-md-6">
                                <label>Contraseña</label>
                        		<input type="pass" id="pass" name="pass" autofocus class="form-control" placeholder="Contraseña" required>	
                        </div>
                         <div class="form-group col-md-6">
                                <label>Telefono</label>
                        		<input type="telefono" id="telefono" name="telefono" autofocus class="form-control" placeholder="Telefono" required>	
                        </div>
                        <div class="form-group col-md-6">
                                <label>Activo</label>
                                <select class="select form-control" id="activo">
                                	<option value="1">Activo</option>
                                	<option value="0">Inactivo</option>
                                </select>
                        </div>
                         <div class="form-group col-md-6">
                                 <a href="#" id="btnAgregarUsuario" class="btn btn-rose btn-fill">Registrar</a>
                        </div>
	               	</form>
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
</html>
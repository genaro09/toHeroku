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
	                <?php
	                	echo "<h3>".$_SESSION['usuario_sesion']->getPrimernombre()." ".$_SESSION['usuario_sesion']->getPrimerapellido()."</h3>";
	                ?>
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
<!--  DateTime -->
<script type="text/javascript" src="../js/jquery.datepicker.js"></script>

<!-- Main js -->
<script src="../js/main.js"></script>
</html>

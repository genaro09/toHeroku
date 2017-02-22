<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
	 ?>
   <?php
     $NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
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
    <link rel="stylesheet" type="text/css" href="../css/icons.css" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>

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
	        	<?php
					$idDepartamento=$_POST["idDepartamento"];
					$departamento=new departamento_class();
					$departamento=getInfoDepartamentos($idDepartamento);

				?>
	            <div class="container-fluid">
	            	<div class="row">
	            		<div class="col-md-12">
	            			<div class="card" style="padding:10px;">
								<div class="header">
									<h4 class="title">ModificarTurno</h4>
								</div>
								<div class="content">
									<form id="form_actualizarUser" role="form">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Nombre Departamento<star>*</star></label>
														<input id="NombreDepartamento" type="text" class="form-control" placeholder="Nombre Departamento" value="<?php echo $departamento->getNombredepartamento(); ?>" required>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Cuenta Contable<star>*</star></label>
														<input id="CContable" type="text" class="form-control timepicker" placeholder="" value="<?php echo $departamento->getCuentacontable(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
                          <label for="exampleInputEmail1">Tipo de Rubro<star>*</star></label>
                          <br>
                          <select id="idSalario_Minimo" name="idSalario_Minimo" class="form-control selectpicker">
                              <?php getSalariosM($idDepartamento); ?>
                          </select>
												</div>
											</div>

											<div class="col-md-4">
												<div class="text-center">
													<br>
	                        <a href="#" id="btnMDepartamento" class="btn btn-fill btn-primary btn-wd">Modificar</a>
													<a href="#" id="btnEliminarDepartamento" class="btn btn-danger">Eliminar</a>
	                      </div>
											</div>
											<input type='hidden' id='idDepartamento' value="<?php echo $idDepartamento; ?>">
                      <input type='hidden' id='nitEmpresa' value='<?php echo $NitEmpresa  ?>'>
											<div class="col-md-12">
	                    	<div class="text-center" id="respuestaAlert"></div>
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





    <!-- Main js -->
    <script src="../js/main.js"></script>


</html>

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
					$idCargos=$_POST["idCargos"];
					$cargo=new cargos_class();
					$cargo=getInfoCargos($idCargos);

				?>
	            <div class="container-fluid">
	            	<div class="row">
	            		<div class="col-md-12">
	            			<div class="card" style="padding:10px;">
								<div class="header">
									<h4 class="title">Modificar Cargo</h4>
								</div>
								<div class="content">
									<form id="form_actualizarUser" role="form">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Nombre Cargo<star>*</star></label>
														<input id="NombreCargo" type="text" class="form-control" placeholder="Nombre Cargo" value="<?php echo $cargo->getNombrecargo(); ?>" required>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Descripcion<star>*</star></label>
														<input id="Descripcion" type="text" class="form-control " placeholder="Descripcion" value="<?php echo $cargo->getDescripcion(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
                          <label for="exampleInputEmail1">Departamento<star>*</star></label>
                          <br>
                          <select id="idDepartamento" name="idDepartamento" class="form-control selectpicker">
                              <?php displayDepartamentos($NitEmpresa,$cargo->getIddepartamento()); ?>
                          </select>
												</div>
											</div>

                      <div class="col-md-6">
                        <div class="form-group">
                          <div class="row">
                            <label class="col-sm-2 label-on-left">Permisos</label>
                            <div class="col-sm-10">
                                      <div class="checkbox checkbox-inline">
                                        <label>
                                          <?php
                                            if($cargo->getPplanilla()==1){
                                              echo "<input id='PEmpleado' class='Permisos' type='checkbox'  name='optionsCheckboxes' checked>Agregar Empleados";
                                            }else echo "<input id='PEmpleado' class='Permisos' type='checkbox'  name='optionsCheckboxes'>Agregar Empleados";
                                           ?>
                                        </label>
                                      </div>
                                      <br>
                                      <div class="checkbox checkbox-inline">
                                        <label>
                                          <?php
                                            if($cargo->getPempleado()==1){
                                              echo "<input id='PPlanilla' class='Permisos' type='checkbox'  name='optionsCheckboxes' checked>Manipular Planillas";
                                            }else echo "<input id='PPlanilla' class='Permisos' type='checkbox'  name='optionsCheckboxes'>Manipular Planillas";
                                           ?>
                                        </label>
                                      </div>
                            </div>
                          </div>
                          </div>
                      </div>

											<div class="col-md-4">
												<div class="text-center">
													<br>
	                        <a href="#" id="btnMCargos" class="btn btn-fill btn-primary btn-wd">Modificar</a>
													<a href="#" id="btnEliminarCargos" class="btn btn-danger">Eliminar</a>
	                      </div>
											</div>
											<input type='hidden' id='idCargos' value="<?php echo $idCargos; ?>">
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

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
					$NitEmpresa=$_POST["NitEmpresa"];

					$empresa=getInfoEmpresa($NitEmpresa);
          if($_POST["TipeRequest"]!=0 && $_POST["TipeRequest"]!=1){
            header("Location: ENCLOSURE-EMPRESAS.php");
            die();
          }

				?>
	            <div class="container-fluid">
	            	<div class="row">
	            		<div class="col-md-12">
	            			<div class="card" style="padding:10px;">
								<div class="header">
									<h4 class="title">Modificar Empresa</h4>
								</div>
								<div class="content">
									<form id="form_actualizarEmpresa" role="form">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label>Nombre Empresa<star>*</star></label>
														<input id="NombreEmpresa" type="text" class="form-control" placeholder="Nombre Empresa" value="<?php echo $empresa->getNombreempresa(); ?>" required>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Direccion<star>*</star></label>
														<input id="Direccion" type="text" class="form-control" placeholder="Direccion" value="<?php echo $empresa->getDireccion(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Telefono<star>*</star></label>
														<input id="Telefono" type="text" class="form-control" placeholder="Telefono" value="<?php echo $empresa->getTelefono(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Telefono 2<star>*</star></label>
														<input id="Telefono2" type="text" class="form-control" placeholder="Telefono 2" value="<?php echo $empresa->getTelefono2(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Numero Registro<star>*</star></label>
														<input id="NRegistro" type="text" class="form-control" placeholder="Numero Registro" value="<?php echo $empresa->getNregistro(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Giro<star>*</star></label>
														<input id="Giro" type="text" class="form-control" placeholder="Giro" value="<?php echo $empresa->getGiro(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Numero Patronal ISS<star>*</star></label>
														<input id="NPatronalSS" type="text" class="form-control" placeholder="Numero Patronal ISS" value="<?php echo $empresa->getNpatronalss(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Numero Patronal AFP<star>*</star></label>
														<input id="NPatronalAFP" type="text" class="form-control" placeholder="Numero Patronal AFP" value="<?php echo $empresa->getNpatronalafp(); ?>"  required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Representante Legal<star>*</star></label>
														<input id="RepresentanteLegal" type="text" class="form-control" placeholder="Representante Legal" value="<?php echo $empresa->getRepresentantelegal(); ?>"  required/>
													</div>
											</div>
											<?php
											  $TipeRequest=$_POST["TipeRequest"];
												if($_POST["TipeRequest"]==1){
													switch ($empresa->getTipoempresa()){
											      case 0:
											        $case0= "selected";
															$case2="";
											        break;
											      case 2:
															$case0= "";
															$case2="selected";
											        break;
											    }
													echo"
													<div class='col-md-4'>
														<div class='form-group'>
															<label for='exampleInputEmail1'>Estado Empresa<star>*</star></label>
															<br>
															<select id='TipoEmpresa' name='TipoEmpresa' class='form-control selectpicker'>
																	<option value='0' ".$case0.">ACTIVA</option>
																	<option value='2' ".$case2.">BLOQUEADA</option>
															</select>
														</div>
													</div>
													";
												}


											 ?>
											 <input type='hidden' id='NitEmpresa' value='<?php echo $NitEmpresa  ?>'>
 											<input type='hidden' id='TipeRequest' value='<?php echo $TipeRequest  ?>'>
											<div class="col-md-4">
												<div class="text-center">
													<br>
	                        <a href="#" id="btnMEmpresa" class="btn btn-fill btn-primary btn-wd">Modificar</a>
	                      </div>
											</div>


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

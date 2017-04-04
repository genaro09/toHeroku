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

	<link rel="icon" type="image/png" href="../img/favicon.png" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>ASCAS, S.A. DE C.V.</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	<!-- PDFOBJECT -->
	<script type="text/javascript" src="../js/PDFObject/pdfobject.js"></script>
	<!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!--  Material Dashboard CSS  -->
    <link href="../css/material-dashboard.css" rel="stylesheet"/>
    <!--custom css-->
    <link rel="stylesheet"  href="../css/customMainCSS.css">
    <link rel="stylesheet" type="text/css" href="../css/icons.css" />
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
		<script src="../dist/sweetalert.js"></script>
		<link rel="stylesheet" href="../dist/sweetalert.css">
    <!-- Date -->
    <link rel="stylesheet" href="../css/jquery.datepicker.css">


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
                  <div class="col-md-12">
                        <!--      Wizard container        -->
                        <div class="wizard-container">
                            <div class="card wizard-card" data-color="purple" id="wizardProfile">
                            <!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                                    <div class="wizard-header">
                                        <h3 class="wizard-title">
                                           <i class="material-icons">healing</i>
                                           Agregar Descuentos
                                        </h3>
                                        <h5>Agrega, confirma y observa incapacidades, ausencias y permisos</h5>
                                    </div>
                                    <!-- html -->
                                    <div id="contenidoCambiante" class="tab-content" style="margin-top:0px;">
                                      <div class="material-datatables">
        					                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
        					                            <thead>
        					                                <tr>
        					                                    <th>DUI</th>
        					                                    <th>Nombre</th>
        					                                    <th>Ingreso</th>
        					                                    <th class="disabled-sorting text-right">Acciones</th>
        					                                </tr>
        					                            </thead>
        					                            <tfoot>
        					                                <tr>
        					                                    <th>DUI</th>
        					                                    <th>Nombre</th>
        					                                    <th>Ingreso</th>
        					                                    <th class="text-right">Acciones</th>
        					                                </tr>
        					                            </tfoot>

        					                            <tbody>
        					                            <!-- Desde aqui include Empleados_grid_table.php-->
        					                                <?php
                                                  include '../php/get_Rows.php';
                                                  get_Row_Empleados_incapacidad();
                                                  ?>
        					                            </tbody>
        					                        </table>
        					                    </div>
                                    </div><!-- cambiante -->
                                    <br>
                                    <!-- FIN -->

                                    <div class="form-group col-md-12">
    																				<div class="text-center" id="respuestaAlert"></div>
    																			 <div class="clearfix"></div>
    															 </div>

                                    <div class="wizard-footer">
                                        <div class="pull-right">

                                        </div>

                                        <div class="pull-left">
                                          <input type='button' class='btn btn-previous btn-fill btn-primary btn-wd' id='previous'name='previous' value='Inicio' />
                                        </div>
																				<?php
																					if(isset($_POST['isUpload'])){
																						//Si viene
																						echo '<input type="hidden" id="isUpload" value="'.$_POST["isUpload"].'">';
																					}else{
																						echo '<input type="hidden" id="isUpload" value="5">';
																					}
																				 ?>

                                        <div class="clearfix"></div>
                                    </div>
                            </div>
                        </div> <!-- wizard container -->
                    </div>
                </div>
              </div>

					<?php include 'footer.php'; ?>

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

		<!-- Ajax Descuentos js -->
		<script src="../js/ajax_Descuentos.js"></script>
		<script>
				if(document.getElementById("isUpload").value==0){
					swal("No se pudo subir su archivo, solo se permiten JPG, PNG y PDF");
				}else if (document.getElementById("isUpload").value==1) {
					swal("Su archivo se subio correctamente");
				}

		</script>

</html>

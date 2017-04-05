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
    <!-- Date -->
		<link rel="stylesheet" href="../css/jquery.datepicker.css">
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

                        <div class="row">
                          <div class="header text-center">
                             <h3 class="title">Suspension</h3>
                         </div>
                       </div>

                  </div>
                </div>
								<div class="row">
									<div class="col-md-12">
										<div class="card">
											<div class="card-content">
												<div class="row">
													<div class="col-md-1">
														<button id="btnIrARSuspension" class="btn btn-just-icon  btn-primary" style="float: right;">
						                        <i class="material-icons">description</i>
						                    <div class="ripple-container"></div>
														</button>
													</div>
													<div class="col-md-8">
														<h4 style="padding-top:8px;">Reporte Suspension</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
                <div class="row">
                  <form>
                    <div class="col-md-6">
                          <div class="card">
                              <div class="card-header card-header-icon" data-background-color="purple">
                                  <i class="material-icons">card_travel</i>
                              </div>
                              <div class="card-content">
                                  <h4 class="card-title">Empleados</h4>
                                  <div class="toolbar">
                                      <!--        Here you can write extra buttons/actions for the toolbar              -->
                                  </div>
                                  <div class="material-datatables">
                                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                          <thead>
                                              <tr>
                                                  <th>DUI</th>
                                                  <th>Nombre</th>
                                                  <th class="disabled-sorting text-right">Agregar</th>
                                              </tr>
                                          </thead>
                                          <tfoot>
                                              <tr>
                                                <th>DUI</th>
                                                <th>Nombre</th>
                                                  <th class="text-right">Agregar</th>
                                              </tr>
                                          </tfoot>

                                          <tbody>
                                          <!-- Desde aqui include Empleados_grid_table.php-->
                                              <?php include '../php/get_Empleado_grid_table_HExtas.php'; ?>
                                          </tbody>
                                      </table>
                                  </div>
                              </div><!-- end content-->
                          </div><!--  end card  -->
                    </div><!--  col 6  -->
                      <div class="col-md-6">
                          <div class="card">
                            <div class="card-header card-header-icon" data-background-color="purple">
                                <i class="material-icons">assignment</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Suspender</h4>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
      															<div class="form-group">
      																<label for="exampleInputEmail1">Nombre Empleado<star>*</star></label>
      																	<input disabled id="NEmpleado" type="text" class="form-control" placeholder="Nombre Empleado"  required>
                                        <input type="hidden" id="NDocumento" value="">
      																</div>
      														</div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Fecha a suspender</label>
                                      <div class='input-group date' id='datetimepicker1'>
                                        <?php
                                          echo "<input  disabled type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='Fecha' data-select='datepicker'/>";
                                        ?>
                                    	</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label >Tipo de Suspension<star>*</star></label>
                                    <br>
                                    <select disabled id="TipoSuspension" name="TipoSuspension" class="form-control selectpicker" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
                                      <option selected value=1>Descontar 1 dia</option>
                                    </select>
                                </div>
                                </div>
                                <div class="form-group col-md-12">
                                  <label>Observación</label>
                                  <textarea disabled id="Observacion" name="Observacion" class="form-control" required="true" rows="3"></textarea>
                                  <span class="material-input"></span>
                                </div>
                                <br>
                                <div class="col-md-4">
    															<div class="text-center">
    																<br>
    				                        <a href="#" disabled id="btnAgregarSuspension" class="btn btn-fill btn-primary btn-wd">Agregar</a>
    				                      </div>
    														</div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="text-center" id="respuestaAlert"></div>
                                  </div>
                                </div>
                            </div>

                        </div>
                      </div>
                    </div>
                  </form>
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
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../js/demo.js"></script>
  <!--  DateTime -->
  <script type="text/javascript" src="../js/jquery.datepicker.js"></script>

    <!-- Main js -->
    <script src="../js/main.js"></script>

		<script type="text/javascript">
		    document.getElementById("btnIrARSuspension").onclick = function () {
		        location.href = "Reporte_Suspension.php";
		    };
		</script>



    <script type="text/javascript">
    //Para Agregar Columnas
      var scntDiv = $('#CuerpoTabla');
      var i = $('#CuerpoTabla tr').length +1;

      $(".addScnt").click(function() {
        var nombreEmpleado = this.attributes["name"].value;
        var NumeroDocumento = this.attributes["id"].value;
        $('#NEmpleado').val(nombreEmpleado);
        $('#NDocumento').val(NumeroDocumento);
        $("#TipoSuspension").attr("disabled", false);
        $("#Observacion").attr("disabled", false);
        $("#Fecha").attr("disabled", false);
        $("#btnAgregarSuspension").attr("disabled", false);
          i++;
          return false;
      });

      //Remove button
      $(document).on('click', '#remScnt', function() {
          if (i > 2) {
              $(this).closest('tr').remove();
              i--;
          }
          return false;
      });
    //FIN

    $(document).ready(function() {
      $('#datatables').DataTable({
        "pagingType": "full_numbers",
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        responsive: true,
        language: {
        search: "_INPUT_",
        searchPlaceholder: "Search records",
        }

      });


      var table = $('#datatables').DataTable();


      $('.card .material-datatables label').addClass('form-group');
      });

  </script>
</html>

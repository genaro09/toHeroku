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
                <?php
                  $Nombre= $_SESSION['usuario_sesion']->getPrimernombre()." ".$_SESSION['usuario_sesion']->getPrimerapellido();
                 ?>
								 <div class="row">
									 <div class="col-md-12">

												 <div class="row">
														<div class="header text-center">
															<h3 class="title">Horas Extras</h3>
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
                              <div class="col-sm-6">
                                  <div class="form-group">
                                    <label>Fecha</label>
                                    <div class='input-group date' id='datetimepicker1'>
                                      <?php
                                        echo "<input  type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='Fecha' data-select='datepicker'/>";
                                      ?>
                                  </div>
                                  </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                      <label>Realizado Por</label>
                                      <input disabled id="PorNombre" type="text" class="form-control" placeholder="Por Ejemplo: Oscar" value="<?php echo $Nombre; ?>" required>
                                    </div>
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
					        </div> <!-- end col-md-12 -->

                  <!--  Otra tabla  -->
                    <div class="col-md-6">
  				            <div class="card">
  				                <div class="card-header card-header-icon" data-background-color="rose">
  				                    <i class="material-icons">assignment</i>
  				                </div>
  				                <div class="card-content">
				  									<h4 class="card-title">Horas Extras</h4>

				  									<div class="table-responsive">

				  										            <table class="table" id="TablaHorasEx">
				  					                        <thead class="text-primary">
				  					                            <th>Nombre</th>
				  					                            <th>Desde</th>
				  					                            <th>Hasta</th>
				                                        <th>Eliminar</th>
				  					                        </thead>
				    					                        <tbody id="CuerpoTabla">

				    					                        </tbody>
				  					                    </table>
				                                <a href="#" id="btnHorasExtras" class="btn btn-fill btn-primary btn-wd">Guardar</a>
																				</form>
																				<button class="btn btn-danger" onClick="window.location.href=window.location.href">Cancelar</button>
				  									</div>
  				                </div>
													<div class="col-md-12">
														<div class="text-center" id="respuestaAlert"></div>
													</div>
  				            </div>
  				        </div>

                  <!-- FIN -->
    				</div> <!-- end row -->
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
    //Para Agregar Columnas
      var scntDiv = $('#CuerpoTabla');
      var i = $('#CuerpoTabla tr').length +1;

      $(".addScnt").click(function() {
        var nombreEmpleado = this.attributes["name"].value;
        var NumeroDocumento = this.attributes["id"].value;
          scntDiv.append('<tr><td class="text-primary">'+nombreEmpleado+'  <input type="hidden" value="'+NumeroDocumento+'"></td><td><input type="text" id="hEntrada" class="form-control" maxlength="5" size="5" placeholder="06:00"/></td><td><input type="text" id="hSalida" class="form-control" maxlength="5" size="5" placeholder="15:30:"/></td><td><a href="#" id="remScnt">Eliminar</a></td></tr>');
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

			// Edit record
			table.on( 'click', '.edit', function () {
				$tr = $(this).closest('tr');

				var data = table.row($tr).data();
				//alert( 'You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.' );
			} );

			// Delete a record
			table.on( 'click', '.remove', function (e) {
				$tr = $(this).closest('tr');
				table.row($tr).remove().draw();
				e.preventDefault();
			} );

			//Like record
			table.on( 'click', '.like', function () {
				alert('You clicked on Like button');
			});

			$('.card .material-datatables label').addClass('form-group');
		  });

	</script>
</html>

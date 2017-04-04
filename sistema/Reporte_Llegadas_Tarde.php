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
								 <!--  cabe   -->
								 <div class="row">
									 <div class="col-md-12">

												 <div class="row">
                           <div class="header text-center">
              				        <h3 class="title">Llegadas Tarde</h3>
              				    </div>
												</div>

									 </div>
								 </div>



								 <!--  Cuadros   -->
	            	<div class="row">
					        <div class="col-md-6">
					            <div class="card">
					                <div class="card-header card-header-icon" data-background-color="purple">
					                    <i class="material-icons">contacts</i>
					                </div>
					                <div class="card-content">
					                    <h4 class="card-title">Reporte por Empleados</h4>
					                    <div class="toolbar">
					                        <!--        Here you can write extra buttons/actions for the toolbar              -->
					                    </div>
					                    <div class="material-datatables">
					                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
					                            <thead>
					                                <tr>
					                                    <th>DUI</th>
					                                    <th>Nombre</th>
					                                    <th class="disabled-sorting text-right">Ir</th>
					                                </tr>
					                            </thead>
					                            <tfoot>
					                                <tr>
                                            <th>DUI</th>
                                            <th>Nombre</th>
					                                    <th class="text-right">Ir</th>
					                                </tr>
					                            </tfoot>

					                            <tbody>
					                            <!-- Desde aqui include Empleados_grid_table.php-->
					                                <?php getReporteLlegadasTardeEmpleado(getNitEmpresa($_SESSION['usuario_sesion'])) ?>
					                            </tbody>
					                        </table>
					                    </div>
					                </div><!-- end content-->
					            </div><!--  end card  -->
					        </div> <!-- end col-md-12 -->

                  <!--  Otra tabla  -->
                    <div class="col-md-6">
											<div class="card">
					                <div class="card-header card-header-icon" data-background-color="purple">
					                    <i class="material-icons">card_travel</i>
					                </div>
					                <div class="card-content">
					                    <h4 class="card-title">Reporte Diario</h4>
					                    <div class="toolbar">
					                        <!--        Here you can write extra buttons/actions for the toolbar              -->
					                    </div>
					                    <div class="material-datatables">
					                        <table id="datatables2" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
					                            <thead>
					                                <tr>
					                                    <th>FECHA</th>
																							<th>ESTADO</th>
					                                    <th class="disabled-sorting text-right">PDF</th>
					                                </tr>
					                            </thead>
					                            <tfoot>
					                                <tr>
                                            <th>FECHA</th>
																						<th>ESTADO</th>
					                                  <th class="text-right">PDF</th>
					                                </tr>
					                            </tfoot>

					                            <tbody>
					                            <!-- Desde aqui include Empleados_grid_table.php-->
					                                <?php include '../php/get_Rows.php';
																					 get_Row_Fecha_Reporte_Semana_Llegadas_Tarde($_SESSION['empresa']);
																					?>
					                            </tbody>
					                        </table>
					                    </div>
					                </div><!-- end content-->
					            </div><!--  end card  -->
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



		$(document).ready(function(){
		    $("#FInicio").change(function(){
				  var id=$("#FInicio").val();
				  var dataString = 'id='+ id;
				  $.ajax({
				   type: "POST",
				   url: "../php/get_TipoReporte.php",
				   data: dataString,
				   cache: false,
				   success: function(html)
				   {
				      $("#TipoReporte").html(html);
				   }
				   });

		    });
		});

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
			//otra table
			$(document).ready(function() {
				$('#datatables2').DataTable({
					"pagingType": "full_numbers",
					"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
					responsive: true,
					language: {
					search: "_INPUT_",
					searchPlaceholder: "Search records",
					}

				});


				var table = $('#datatables2').DataTable();


				$('.card .material-datatables label').addClass('form-group');
				});

	</script>
</html>

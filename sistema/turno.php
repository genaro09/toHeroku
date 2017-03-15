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
    $(function() {
        $('#descanso').change(function(){
            $('.opcion').hide();
            if($(this).val()==1){
            	$('#' + $(this).val()).show();
            }
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
									<h4 class="title">Agregar Turno</h4>
								</div>
								<div class="content">
									<form id="form_actualizarUser" role="form">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Nombre Turno<star>*</star></label>
														<input id="Njornada" type="text" class="form-control" placeholder="Nombre Jornada" required>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Desde<star>*</star></label>
														<input id="desde" type="text" class="form-control timepicker" value="14:00" required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Hasta<star>*</star></label>
														<input id="hasta" type="text" class="form-control timepicker" value="14:00" required/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Descanso<star>*</star></label>
													<br>
														<select id="descanso" class="selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
															<option value="1" >SI</option>
															<option value="0" selected>NO</option>
														</select>
													</div>
											</div>
											<div class="col-md-4 opcion" id="1" style="display:none">
												<div class="form-group">
													<label for="exampleInputEmail1">Tiempo de Descanso<star>*</star></label>
													<input id="H_Descanso" type="text" class="form-control timepicker" value="14:00" required/>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Periodo de Pago<star>*</star></label>
													<br>
														<select id="PPago" name="PPago" class="form-control selectpicker" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
															<option value="10">Mensual</option>
															<option value="30">Quincenal</option>
															<option value="20">Catorcenal</option>
															<option value="40">Semanal</option>
														</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="text-center">
													<br>
	                        <a href="#" id="btnATruno" class="btn btn-fill btn-primary btn-wd">Agregar</a>
	                     </div>
											</div>
											<?php
												$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
											?>
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

	            	<div class="row">
				        <div class="col-md-12">
				            <div class="card">
				                <div class="card-header card-header-icon" data-background-color="purple">
				                    <i class="material-icons">assignment</i>
				                </div>

				                <div class="card-content">
				                    <h4 class="card-title">Turnos de la empresa</h4>
				                    <div class="toolbar">
				                        <!--        Here you can write extra buttons/actions for the toolbar              -->
				                    </div>
				                    <div class="material-datatables">
				                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
				                            <thead>
				                                <tr>
				                                    <th>Nombre del Turno</th>
				                                    <th>Desde</th>
				                                    <th>Hasta</th>
				                                    <th>Descanso(Si/No)</th>
				                                    <th>Tiempo de Descanso</th>
				                                    <th class="disabled-sorting text-right">Acciones</th>
				                                </tr>
				                            </thead>
				                            <tfoot>
				                                <tr>
				                                    <th>Nombre del Turno</th>
				                                    <th>Desde</th>
				                                    <th>Hasta</th>
				                                    <th>Descanso(Si/No)</th>
				                                    <th>Tiempo de Descanso</th>
				                                    <th class="text-right">Acciones</th>
				                                </tr>
				                            </tfoot>

				                            <tbody>
				                            <!-- Desde aqui include Empleados_grid_table.php-->
				                               <?php include 'get_Turnos.php'; ?>
				                            </tbody>
				                        </table>
				                    </div>
				                </div><!-- end content-->
				            </div><!--  end card  -->
				        </div> <!-- end col-md-12 -->
    				</div> <!-- end row -->




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





    <script type="text/javascript">

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

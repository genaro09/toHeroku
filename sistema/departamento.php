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
	            <div class="container-fluid">
	            	<div class="row">
	            		<div class="col-md-12">
	            			<div class="card" style="padding:10px;">
								<div class="header">
									<h4 class="title">Agregar Departamento</h4>
								</div>
								<div class="content">
									<form id="form_actualizarUser" role="form">
										<div class="row">
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Nombre del Departamento<star>*</star></label>
														<input id="NDepartamento" type="text" class="form-control" placeholder="Nombre del Departamento" required>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label for="exampleInputEmail1">Cuenta Contable<star>*</star></label>
														<input id="CContable" type="text" class="form-control timepicker"  required="true"/>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
                          <label for="exampleInputEmail1">Tipo de Rubro<star>*</star></label>
                          <br>
                          <select id="idSalario_Minimo" name="idSalario_Minimo" class="form-control selectpicker">
                              <?php include '../php/get_Salarios_Minimos.php'; ?>
                          </select>
													</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Pais<star>*</star></label>
													<br>
													<select id="pais" name="pais" class="form-control selectpicker" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
														<option value='0'>NINGUNO</option>
														<?php
															$pilaPT=obtCodPaises();
															$pilaP1=$pilaPT[0];
															$pilaP2=$pilaPT[1];
															$pais=0;
															$year=date("Y");
															for($i = 0; $i < sizeof($pilaP1);$i++){
																	$codPais=$pilaP1[$i];
																	$nombrePais=$pilaP2[$codPais];
																	if($pais==$codPais){
																		echo "<option selected value='".$codPais."'>".$nombrePais."</option>";
																	}else echo "<option value='".$codPais."'>".$nombrePais."</option>";
															}
														?>
													</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Departamento<star>*</star></label>
													<br>
														<select id="C_departamento" name="C_departamento" class="form-control selectpicker" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
															<?php
																include_once "get_Cod_D_M.php";
																get_Cod_D(0);
															 ?>
														</select>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group">
													<label>Municipio<star>*</star></label>
													<br>
														<select id="C_municipio" name="C_municipio" class="form-control selectpicker" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
															<?php
																include_once "get_cod_M.php";
																get_Cod_M(0);
															 ?>
														</select>
												</div>
											</div>
                      <input type='hidden' id='nitEmpresa' value='<?php echo $NitEmpresa  ?>'>
											<div class="col-md-4">
												<div class="text-center">
													<br>
	                         <a href="#" id="btnADepartamento" class="btn btn-fill btn-primary btn-wd">Agregar</a>
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

	            	<div class="row">
				        <div class="col-md-12">
				            <div class="card">
				                <div class="card-header card-header-icon" data-background-color="purple">
				                    <i class="material-icons">assignment</i>
				                </div>

				                <div class="card-content">
				                    <h4 class="card-title">Departamentos de la empresa</h4>
				                    <div class="toolbar">
				                        <!--        Here you can write extra buttons/actions for the toolbar              -->
				                    </div>
				                    <div class="material-datatables">
				                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
				                            <thead>
				                                <tr>
				                                    <th>Nombre del Departamento</th>
				                                    <th>Cuenta Contable</th>
				                                    <th>Tipo Rubro</th>
				                                    <th class="disabled-sorting text-right">Acciones</th>
				                                </tr>
				                            </thead>
				                            <tfoot>
				                                <tr>
                                          <th>Nombre del Departamento</th>
                                          <th>Cuenta Contable</th>
                                          <th>Tipo Rubro</th>
				                                    <th class="text-right">Acciones</th>
				                                </tr>
				                            </tfoot>

				                            <tbody>
				                            <!-- Desde aqui include Empleados_grid_table.php-->
				                               <?php include '../php/get_Departamentos_Tabla.php'; ?>
				                            </tbody>
				                        </table>
				                    </div>
				                </div><!-- end content-->
				            </div><!--  end card  -->
				        </div> <!-- end col-md-12 -->
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
	<script>
	$(document).ready(function(){
			//Pais a Depa
			$("#pais").change(function(){
			 var id=$(this).val();
			 var dataString = 'id='+ id;
			 $.ajax({
				type: "POST",
				url: "get_Cod_D_M.php",
				data: dataString,
				cache: false,
				success: function(html){
					 $("#C_departamento").html(html);
				}
				});
				revisarDepa();
		 });

		 //Dapa a Muni
		 $("#C_departamento").change(function(){
			var id=$(this).val();
			var dataString = 'id='+ id;
			$.ajax({
			 type: "POST",
			 url: "get_cod_M.php",
			 data: dataString,
			 cache: false,
			 success: function(html){
					$("#C_municipio").html(html);
			 }
			 });

		});
	});
	function revisarDepa(){
		var id = 0;
		var dataString = 'id='+ id;
		$.ajax({
		 type: "POST",
		 url: "get_cod_M.php",
		 data: dataString,
		 cache: false,
		 success: function(html){
				$("#C_municipio").html(html);
		 }
		 });
	}
	</script>
</html>

<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
	if(trim($_POST['idDepartamento']) == ""){
		header('Location: departamento.php');
		exit();
	}
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
	        	<?php
					$idDepartamento=$_POST["idDepartamento"];
					$departamento=new departamento_class();
					$departamento=getInfoDepartamentos($idDepartamento);

				?>
	      <div class="container-fluid">
	      	<div class="row">
	        	<div class="col-md-12">
	          	<div class="card">
								<div class="card-header card-header-icon" data-background-color="purple">
										<i class="material-icons">gavel</i>
								</div>
								<div class="card-content">
										<h4 class="card-title">Modificar Departamento</h4>
										<div class="toolbar">
												<!--        Here you can write extra buttons/actions for the toolbar              -->
										</div>
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
												<div class="form-group">
													<label>Pais<star>*</star></label>
													<br>
													<select id="pais" name="pais" class="form-control selectpicker" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
														<option value='0'>NINGUNO</option>
														<?php
															$pilaPT=obtCodPaises();
															$pilaP1=$pilaPT[0];
															$pilaP2=$pilaPT[1];
															$pais=obtPaisDepa($departamento->getIdCod_Municipio());
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
																$Col_Departamento=obtDepaDepa($departamento->getIdCod_Municipio());
																get_Cod_D($Col_Departamento);
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
																get_Cod_M($departamento->getIdCod_Municipio());
															 ?>
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
								<!-- New Row -->
								<div class="row">
									<div class="col-md-12">
										<div class="card">
												<div class="card-header card-header-icon" data-background-color="purple">
														<i class="material-icons">card_travel</i>
												</div>
												<div class="card-content">
														<h4 class="card-title">Cargos en el departamento</h4>
														<div class="toolbar">
																<!--        Here you can write extra buttons/actions for the toolbar              -->
														</div>
														<div class="material-datatables">
																<table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
																		<thead>
																				<tr>
																						<th>Nombre Cargos</th>
																				</tr>
																		</thead>
																		<tfoot>
																				<tr>
																					<th>Nombre Cargos</th>
																				</tr>
																		</tfoot>

																		<tbody>
																		<!-- Desde aqui include Empleados_grid_table.php-->
																				<?php
																				include '../php/get_Rows.php';
																				get_Row_Perfil_Departamento($idDepartamento)
																				?>
																		</tbody>
																</table>
														</div>
												</div><!-- end content-->
										</div><!--  end card  -->
									</div>
								</div>
								<!-- End New Row -->
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

<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
		 if(trim($_POST['numDoc']) == ""){
		   header('Location: verEmpleados.php');
		   exit();
		 }
		 $NumeroDocumento=$_POST["numDoc"];
		 $empleado=new empleado_class();
		 $empleado=getInfoEmpleado($NumeroDocumento);
		 $htrabajo=new htrabajo_class();
		 $htrabajo=getInfoHTrabajo($NumeroDocumento);
		 $Bancos=getAllBankAccount();

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
		<!-- Date -->
		<link rel="stylesheet" href="../css/jquery.datepicker.css">
		<!-- otro -->
    <script src="../js/jquery-3.1.1.min.js" type="text/javascript"></script>
	<script>
	$(document).ready(function(){

			//change pass
			$("#changePass").change(function() {
				if($(this).is(":checked")) {
            $("#pass").attr("disabled", false);
        }else{
					$("#pass").attr("disabled", true);
				}
			});
			//Numero De Cuenta
			$("#Banco").change(function(){
				var id=$(this).val();
				var NumeroDocumento = <?php echo json_encode($NumeroDocumento); ?>;
				$.ajax({
				 type: "POST",
				 url: "../php/get_CuentaBanco.php",
				 data: {
						 id: id,
						 NumeroDocumento: NumeroDocumento
				 },
				 success: function(html){
						$("#divCount").html(html);
				 }
				 });

			});

	    $("#AreaTrabajo").change(function(){
			  var id=$(this).val();
			  var dataString = 'id='+ id;
			  $.ajax({
			   type: "POST",
			   url: "get_Cargo.php",
			   data: dataString,
			   cache: false,
			   success: function(html){
			      $("#cargo").html(html);
			   }
			   });

	    });
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
										<h4 class="title">Editar Perfil</h4>
									</div>
									<div class="content">
										<form id="form_actualizarUser">

											<div class="nav-container">
												<div class="row nav nav-icons" role="tablist">
													<div class="col-sm-6 col-lg-3 active">
														<a href="#description-logo" role="tab" data-toggle="tab">
															<i class="pe-7s-users"></i><br>
															Datos Personales
														</a>
													</div>
													<div class="col-sm-6 col-lg-3"> <a href="#map-logo" role="tab" data-toggle="tab">
                                                    <i class="pe-7s-id"></i><br>
													  Datos Laborales </a>
													</div>
													<div class="col-sm-6 col-lg-3">
														<a href="#legal-logo" role="tab" data-toggle="tab">
															<i class="pe-7s-note2"></i><br>
															Historial
														</a>
													</div>
													<div class="col-sm-6 col-lg-3">
														<a href="#help-logo" role="tab" data-toggle="tab">
															<i class="pe-7s-piggy"></i><br>
															Descuentos Programados
														</a>
													</div>
												</div>
											</div>

											<div class="tab-content">
												<div class="tab-pane active" id="description-logo">
													<div class="card" style="padding:15px;">
														<div class="header">
															<h4 class="title">Datos Personales</h4>
															<input type="hidden" id="NumeroDocumento" value="<?php echo $NumeroDocumento; ?>">
														</div>

														<div class="content">
															<form>
																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label for="exampleInputEmail1">Correo Electronico<star>*</star></label>
																			<input id="correo" type="email" class="form-control" placeholder="Email" value="<?php echo $empleado->getCorreoelectronico() ?>" required>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="row">
																			<div class="col-md-3">
																				<br>
																				<label>
																					<input type="checkbox" id="changePass"name="optionsCheckboxes"><span class="checkbox-material"><span class="check"></span></span>
																					Cambiar Contraseña
																				</label>
																			</div>
																			<div class="col-md-9">
																				<div class="form-group">
																					<label for="exampleInputEmail1"> Contraseña<star>*</star></label>
																					<input disabled="TRUE" id="pass" type="password" class="form-control" placeholder="contraseña">
																				</div>
																			</div>
																		</div>
																</div>
															</div>
																<div class="row">
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Primer Nombre<star>*</star></label>
																			<input id="Pnombre" type="text" class="form-control" placeholder="Por Ejemplo: Oscar" value="<?php echo $empleado->getPrimernombre(); ?>" required>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Segundo Nombre</label>
																			<input id="Snombre"type="text" class="form-control" placeholder="Por Ejemplo: Arnulfo" value="<?php echo $empleado->getSegundonombre(); ?>">
																		</div>
																	</div>

																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Primer Apellido<star>*</star></label>
																			<input id="Papellido" type="text" class="form-control" placeholder="Por Ejemplo: Romero" value="<?php echo $empleado->getPrimerapellido(); ?>" required>
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Segundo Apellido</label>
																			<input id="Sapellido" type="text" class="form-control" placeholder="Por Ejemplo: Galdamez" value="<?php echo $empleado->getSegundoapellido(); ?>">
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Apellido de Casada</label>
																			<input id="Acasada"type="text" class="form-control" placeholder="Por Ejemplo: de Alvarenga" value="<?php echo $empleado->getApellidocasada(); ?>">
																		</div>
																	</div>
																	<div class="col-md-6">
																		<div class="form-group">
																			<label>Conocido Por</label>
																			<input id="Cpor" type="text" class="form-control" placeholder="Por Ejemplo: Hijo" value="<?php echo $empleado->getConocidopor(); ?>">
																		</div>
																	</div>

																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Estado Civil<star>*</star></label>
																			<br>
																			<select id="Ecivil" name="Ecivil" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
																				<?php
																					if($empleado->getEstadocivil()=='S'){
																						echo "
																							<option selected value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='C'){
																						echo "
																							<option  value='S'>Soltero</option>
																							<option selected value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='V'){
																						echo "
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option selected value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='D'){
																						echo "
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option selected value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}else if($empleado->getEstadocivil()=='U'){
																						echo "
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option selected value='U'>Union Libre</option>
																						";
																					}else{
																						echo "
																							<option selected value='N'>Ninguna	</option>
																							<option value='S'>Soltero</option>
																							<option value='C'>Casado</option>
																							<option value='V'>Viudo</option>
																							<option value='D'>Divorciado</option>
																							<option value='U'>Union Libre</option>
																						";
																					}



																				?>


																			</select>

																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Fecha de Nacimiento<star>*</star></label>
																			<?php
																					if($empleado->getFechanacimiento()){
																						echo "<input  type='text' class='form-control' value=".$empleado->getFechanacimiento()." name='date' id='Fnacimiento' data-select='datepicker'/>";
																					}else{
																						echo "<input  type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='Fnacimiento' data-select='datepicker'/>";
																					}
																			 ?>
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Tipo de Documento<star>*</star></label>
																			<select disabled id="Tdocumento" name="cities" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
																				<?php
																					if($empleado->getTipodocumento()=='CAR'){
																						echo "
																						<option selected value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else if($empleado->getTipodocumento()=='PAS'){
																						echo "
																						<option value='CAR'>Carnet de Residente</option>
																						<option selected value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else if($empleado->getTipodocumento()=='CMI'){
																						echo "
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option selected value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else if($empleado->getTipodocumento()=='DUI'){
																						echo "
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option selected value='DUI'>Documento Unico de Identidad</option>
																						";
																					}else{
																						echo "
																						<option value='NULL'>Seleccione uno</option>
																						<option value='CAR'>Carnet de Residente</option>
																						<option value='PAS'>Pasaporte</option>
																						<option value='CMI'>Carnet de Minoridad</option>
																						<option value='DUI'>Documento Unico de Identidad</option>
																						";
																					}

																				?>


																			</select>
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Numero de Documento<star>*</star></label>
																			<input disabled id="Ndocumento"  type="text" class="form-control" placeholder="Por Ejemplo: 042341492" value="<?php echo (String)$empleado->getNumerodocumento();  ?>">
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Pais<star>*</star></label>
																			<br>
																			<select id="pais" name="pais" class="form-control selectpicker">
																				<option value='0'>NINGUNO</option>
																				<?php
																					$pilaPT=obtCodPaises();
																					$pilaP1=$pilaPT[0];
																					$pilaP2=$pilaPT[1];
																					$year=date("Y");
																					for($i = 0; $i < sizeof($pilaP1);$i++){
																							$codPais=$pilaP1[$i];
																							$nombrePais=$pilaP2[$codPais];
																							if($empleado->getNacionalidad()==$codPais){
																								echo "<option selected value='".$codPais."'>".$nombrePais."</option>";
																							}else echo "<option value='".$codPais."'>".$nombrePais."</option>";
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Departamento<star>*</star></label>
																			<br>
																				<select id="C_departamento" name="C_departamento" class="form-control selectpicker">
																					<?php
																						include_once "get_Cod_D_M.php";
																						get_Cod_D($empleado->getDepartamento());
																					 ?>
																				</select>
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Municipio<star>*</star></label>
																			<br>
																				<select id="C_municipio" name="C_municipio" class="form-control selectpicker">
																					<?php
																						include_once "get_cod_M.php";
																						get_Cod_M($empleado->getMunicipio());
																					 ?>
																				</select>
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Telefono<star>*</star></label>
																			<input id="Telefono"type="tel" class="form-control" placeholder="Por Ejemplo: 2555-5555" value="<?php echo (int)$empleado->getNumerotelefonico(); ?>" required>
																		</div>
																	</div>
																	<div class="col-sm-6 col-lg-3">
																		<div class="form-group">
																			<label>Genero<star>*</star></label>
																			<br>
																			<select id='Genero' class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
																				<?php
																				if($empleado->getGenero()=='M'||$empleado->getGenero()=='F'){
																					if($empleado->getGenero()=='M'){
																						echo "
																						<option selected value='M'>Masculino</option>
																						<option value='F'>Femenino</option>
																						";
																					}else if($empleado->getGenero()=='F'){
																						echo "
																						<option value='M'>Masculino</option>
																						<option selected value='F'>Femenino</option>
																						";
																					}

																				}else
																				echo "
																				<option value='0'>Ecoja uno</option>
																				<option value='M'>Masculino</option>
																				<option value='F'>Femenino</option>
																				";

																				?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-6">
																		<div class="form-group">
																			<label>Direccion<star>*</star></label>
																			<input id="Direccion" type="text" class="form-control" placeholder="Por Ejemplo: San Salvador" value="<?php echo $empleado->getDireccion(); ?>">
																		</div>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>


												<div class="tab-pane" id="map-logo">
													<div class="card">
														<div class="header">
															<h4 class="title">Datos Laborales</h4>
														</div>

														<div class="content">
															<form>
																<div class="row">
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Numero de NIT<star>*</star></label>
																			<input id="NNIT" type="text" class="form-control" placeholder="Por Ejemplo: 0614-240290-105-5" value="<?php echo (String)$empleado->getNit(); ?>" required>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Numero de I.S.S.S.<star>*</star></label>
																			<input id="NISSS" type="text" class="form-control" placeholder="Por Ejemplo: 198953837" value="<?php echo $empleado->getNumeroisss(); ?>">
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Numero del IMPEP</label>
																			<input id="NIMPEP"type="text" class="form-control" placeholder="Por Ejemplo: 04234149-2" value="<?php echo $empleado->getNumeroinpep(); ?>">
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Activo:</label>
																			<br>
																			<select id="activo" name="T_Activo" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																			<?php
																				if($empleado->getActivo()==1){
																					echo "
																					<option selected value='1'>Activo</option>;
																					<option value='0'>Inactivo</option>;
																					";
																				}else if ($empleado->getActivo()==0){
																					echo "
																					<option value='1'>Activo</option>;
																					<option selected value='0'>Inactivo</option>;
																					";
																				}
																			?>
																			</select>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label>Nombre de AFP<star>*</star></label>
																			<br>
																			<select id="NAFP" name="T_AFP" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																				<?php
																					if($empleado->getInstitucionprevisional()=='MAX'){
																						echo "<option selected value='MAX'>AFP CRECER</option>";
																					}else echo "<option value='MAX'>AFP CRECER</option>";
																					if($empleado->getInstitucionprevisional()=='COF'){
																						echo "<option selected value='COF'>AFP CONFIA</option>";
																					}else echo "<option value='COF'>AFP CONFIA</option>";
																					if($empleado->getInstitucionprevisional()=='ISS'){
																						echo "<option selected value='ISS'>UPISSS</option>";
																					}else echo "<option value='ISS'>UPISSS</option>";
																					if($empleado->getInstitucionprevisional()=='INP'){
																						echo "<option selected value='INP'>INPEP</option>";
																					}else echo "<option value='INP'>INPEP</option>";
																					if($empleado->getInstitucionprevisional()==''){
																						echo "<option selected value=''>Seleccione una</option>";
																					}
																				?>

																			</select>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<div class="form-group">
																			<label>Numero de NUP<star>*</star></label>
																			<br>
																			<input id="NNUP" type="text" class="form-control" placeholder="Por Ejemplo: 04234149-2" value="<?php echo (double)$empleado->getNup(); ?>">
																		</div>
																	</div>


																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Salario Mensual<star>*</star></label>
																			<input id="SMensual" type="number" class="form-control" placeholder="Por Ejemplo: $ 251.70" value="<?php echo number_format((double)$empleado->getSalarionominal(), 2, '.', ''); ?>" required>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Departamento<star>*</star></label>
																			<br>
																			<select id='AreaTrabajo' name="AreaTrabajo" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																					 <?php
																					 	include 'get_Departamentos.php';
																					 	get_Departamentos($empleado->getIdcargos());
																					 ?>
																			</select>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Cargo<star>*</star></label>
																			<br>
																			<select id='cargo' name="cargo" class="form-control selectpicker Cargo" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																				<?php
																					get_Cargos($empleado->getIdcargos());
																				?>

																			</select>
																		</div>
																	</div>

																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Fecha de Ingreso<star>*</star></label>
																			<div class='input-group date' id='datetimepicker1'>
																				<?php
																						if($empleado->getFechaingreso()){
																							echo "<input  type='text' class='form-control' value=".$empleado->getFechaingreso()." name='date' id='FechaIngreso' data-select='datepicker'/>";
																						}else{
																							echo "<input  type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='FechaIngreso' data-select='datepicker'/>";
																						}
																				 ?>
																			</div>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Fecha de Retiro</label>
																			<div class='input-group date' id='datetimepicker1'>
																				<?php
																						if($empleado->getFecharetiro()){
																							echo "<input  type='text' class='form-control' value=".$empleado->getFecharetiro()." name='date' id='FechaRetiro' data-select='datepicker'/>";
																						}else{
																							echo "<input  type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='FechaRetiro' data-select='datepicker'/>";
																						}
																				 ?>
																			</div>
																		</div>
																	</div>
																	<div class="col-sm-4">
																		<div class="form-group">
																			<label>Fecha de Fellecimiento</label>
																			<div class='input-group date' id='datetimepicker1'>
																				<?php
																						if($empleado->getFechafallecimiento()){
																							echo "<input  type='text' class='form-control' value=".$empleado->getFechafallecimiento()." name='date' id='FechaFallecimiento' data-select='datepicker'/>";
																						}else{
																							echo "<input  type='text' class='form-control' placeholder=".date("d")."/".date("m")."/".date("Y")." name='date' id='FechaFallecimiento' data-select='datepicker'/>";
																						}
																				 ?>
																			</div>
																		</div>
																	</div>
                                <div class="col-sm-4">
																		<div class="form-group">
																			<label>Horario de Entrada</label>
																			<input type="text" id="hEntrada" class="form-control timepicker" placeholder="06:00:00" value="<?php echo $htrabajo->getDesde(); ?>"/>
																		</div>
																	</div>
                                <div class="col-sm-4">
																		<div class="form-group">
																			<label>Horario de Salida</label>
																			<input type="text" id="hSalida" class="form-control timepicker" placeholder="14:30:00" value="<?php echo $htrabajo->getHasta(); ?>"/>
																		</div>
																	</div>
                                <div class="col-sm-4">
																		<div class="form-group">
																			<label>Turno</label>
																			<br>
																			<select id="idTurno" name="idTurno" class="form-control selectpicker">
																				<?php
																					$NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
																					include "get_SelectTurno.php";
																					get_SelectTurno($NitEmpresa,$htrabajo->getIdturno());

																				?>
																			</select>
																		</div>
																	</div>
   																	<div class="col-md-4">
																		<div class="form-group">
																			<label>Banco</label>
																			<br>
																			<select id="Banco" name="Banco" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
																				<?php
																					/*
																					$Bancos=getAllBankAccount();
																					$cuentasBanco=getCuentaBanco($NumeroDocumento);
																					*/
																					$BancosID=$Bancos[0];//los id
																					$BancosNombre=$Bancos[1];//Los nombres
																					echo "<option value='0'>SELECCIONE UNO</option>";
																					for($i = 0; $i < sizeof($BancosID);$i++){
																							$idBanco=$BancosID[$i];
																							$nombreBancos=$BancosNombre[$idBanco];
 																							echo "<option value='".$idBanco."'>".$nombreBancos."</option>";
																					}
																				?>
																			</select>
																		</div>
																	</div>
                                  <div class="col-md-4 ">
																		<div class="form-group">
																			<label>Cuenta Bancaria</label>
																			<div id="divCount">
																				<?php
																					echo '<input disabled  type="number" id="CuentaBanco" class="form-control" placeholder="SELECCIONE PARA VER SI TIENE CUENTA">';
																				 ?>
																			</div>
																		</div>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>


												<div class="tab-pane" id="legal-logo">
													<div class="card">
														<div class="header">
															<h4 class="title">Expediente Permanente</h4>
															<p class="category">More information here</p>
														</div>

														<div class="content">
															<p>The first...</p>
														</div>
													</div>
												</div>

												<div class="tab-pane" id="help-logo">
													<div class="card">
														<div class="header">
															<h4 class="title">Descuentos Programados</h4>
															<p class="category">More information here</p>
														</div>

														<div class="content">
															<p>From the seamless...</p>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<a href="#" id="btnActualizarUsuario" class="btn btn-info btn-fill pull-right">Guardar Cambios</a>
											</div>
											<div class="row">
												<div class="col-md-12">
													<div class="text-center" id="respuestaAlert"></div>
												</div>
											</div>
											<div class="clearfix"></div>
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
        $().ready(function(){

            // Init Sliders
            demo.initFormExtendedSliders();

            // Init DatetimePicker
            demo.initFormExtendedDatetimepickers();
			moment().format("ddd, hA");
        });
 </script>

</html>

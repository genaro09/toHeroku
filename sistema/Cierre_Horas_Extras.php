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
                                           <i class="material-icons">description</i>
                                           Cierre Horas Extras
                                        </h3>
                                        <h5>Cerrar y ver cierre de Horas Extras</h5>
                                    </div>
                                    <!-- html -->
                                    <div id="ExtraTimeChangeContent" class="tab-content" style="margin-top:0px;">
                                      <br>
                                      <div class="row">
                                        <form>
                                          <div class="col-md-4">
       																		 <label>Mes</label>
       																		 <br>
       																		 <select id='FInicio' name="FInicio" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
       																		 <?php
       																		 $now = new \DateTime('now');
       																		 $month = $now->format('m');
       																		 $year = $now->format('Y');
       																		 $Meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
       																		 for($j=2000;$j<$year;$j++){
       																			 for($i=1;$i<13;$i++){
       																				 	if($i<10){
       																						$k="0".$i;
       																					}else $k=$i;
       																				  echo "<option value='".$i."/".$j."'>".$Meses[$i-1]."/".$j."</option>";
       																			 }
       																		 }
       																		 //current year
       																		 	$j=$year;
       																			 for($i=1;$i<$month;$i++){
       																				 	if($i<10){
       																						$k="0".$i;
       																					}else $k=$i;
       																				  echo "<option value='".$i."/".$j."'>".$Meses[$i-1]."/".$j."</option>";
       																			 }
       																		 echo "<option selected value='".$month."/".$year."'>".$Meses[$month-1]."/".$year."</option>";
       																		 $j=$year;
       																			for($i=$month+1;$i<13;$i++){
       																				 if($i<10){
       																					 $k="0".$i;
       																				 }else $k=$i;
       																				 echo "<option value='".$i."/".$j."'>".$Meses[$i-1]."/".$j."</option>";
       																			}
       																		  ?>
       																		</select>
       																	</div>
       																 <div class="col-md-4">
       																	 <label>Tipo Pago:</label>
       																	 <br>
       																	 <select id='TipoReporte' name="TipoReporte" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
       																				<?php
       																					printTipoReporte($year,$month)
       																				?>
       																	 </select>
       																</div>
                                      <div class="col-md-4">
                                        <br>
                                        <a href="#" id="btnVerCierreHorasExtras" class="btn btn-primary btn-fill btn-wd" style="margin-left:25%">Ver Cierre</a>
                                      </div>
                                    </form>
                                    <div class="col-md-12">
                                      <div class="text-center" id="respuestaAlert"></div>
                                    </div>
                                  </div>
                                  <br>
                                  <div class="row">
                                    <div id="ChangeTimePago" class="col-md-12">
                                    </div>
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


</html>

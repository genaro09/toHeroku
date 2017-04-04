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
								 <!--  cabe   -->
								 <div class="row">
									 <div class="col-md-12">
										 <div class="card">
												 <div class="row">
													 <div class="card-header card-header-icon" data-background-color="purple">
 					                    <i class="material-icons">today</i>
 					                </div>
 					                <div class="card-content">
 					                    <h4 class="card-title">Seleccione Fecha</h4>
 					                    <div class="material-datatables">
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


																	<div class="clearfix"></div>
															</form>
															<form method="POST" target="_blank" action="PDF_Reporte_Horas_Extras.php" id="PDFUserForm">
																<input type="hidden" id="FechaInicio" name="FechaInicio" />
																<input type="hidden" id="Departamento" name="Departamento" />
																<input type="hidden" id="TPago" name="TPago" />
																<input type="hidden" id="opc" name="opc" />
															</form>
														</div>
													</div>
												</div>

										 </div>
									 </div>
								 </div>



								 <!--  Cuadros   -->
	            	<div class="row">
					        <div class="col-md-12">
					            <div class="card">
					                <div class="card-header card-header-icon" data-background-color="purple">
					                    <i class="material-icons">timeline</i>
					                </div>
					                <div class="card-content">
					                    <h4 class="card-title">Reporte De Pago</h4>
					                    <div class="toolbar">
					                        <!--        Here you can write extra buttons/actions for the toolbar              -->
					                    </div>
                              <div class="row">
                                <div class="col-md-4">
                                  <label>Forma de pago</label>
                                  <br>
                                  <select id="Banco" name="Banco" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue">
                                  <?php
                                        $Bancos=getAllBankAccount();
                                        $BancosID=$Bancos[0];//los id
                                        $BancosNombre=$Bancos[1];//Los nombres
                                        echo "<option value='ninguno'>SELECCIONE UNO</option>";
                                        echo "<option value='0'>Efectivo</option>";
                                        for($i = 0; $i < sizeof($BancosID);$i++){
                                            $idBanco=$BancosID[$i];
                                            $nombreBancos=$BancosNombre[$idBanco];
                                            echo "<option value='".$idBanco."'>".$nombreBancos."</option>";
                                        }
                                      ?>
                                  </select>
                                </div>
                              </div><!--Fin Row FPAGO -->
														<form>
	                            <div id="RPago">
	                            </div>
														</form>
					                </div><!-- end content-->
					            </div><!--  end card  -->
					        </div> <!-- end col-md-12 -->


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
		    $("#Banco").change(function(){
				  var fecha=$("#FInicio").val();
          var TipoReporte=$("#TipoReporte").val();
          var Banco=$("#Banco").val();
					$("#RPago").html("<h5>Cargando...</h5>");
				  $.ajax({
				   type: "POST",
				   url: "../php/Insert_Ajax.php",
           data: {
               opcAjax: 1,
               fecha: fecha,
               TipoReporte: TipoReporte,
               Banco: Banco
           },
				   cache: false,
				   success: function(html)
				   {
				      $("#RPago").html(html);
				   }
				   });

		    });

        //Si cambiamos el tipo de pago
        $("#TipoReporte").change(function(){
          document.getElementById("Banco").options[0].selected=true;
          var fecha=$("#FInicio").val();
          var TipoReporte=$("#TipoReporte").val();
          var Banco=$("#Banco").val();
					$("#RPago").html("<h5>Cargando...</h5>");
          $.ajax({
           type: "POST",
           url: "../php/Insert_Ajax.php",
           data: {
               opcAjax: 1,
               fecha: fecha,
               TipoReporte: TipoReporte,
               Banco: Banco
           },
           cache: false,
           success: function(html)
           {
              $("#RPago").html(html);
           }
           });

        });
        //Mes
        $("#FInicio").change(function(){
          document.getElementById("Banco").options[0].selected=true;
          var fecha=$("#FInicio").val();
          var TipoReporte=$("#TipoReporte").val();
          var Banco=$("#Banco").val();
					$("#RPago").html("<h5>Cargando...</h5>");
          $.ajax({
           type: "POST",
           url: "../php/Insert_Ajax.php",
           data: {
               opcAjax: 1,
               fecha: fecha,
               TipoReporte: TipoReporte,
               Banco: Banco
           },
           cache: false,
           success: function(html)
           {
              $("#RPago").html(html);
           }
           });

        });

		});



	</script>
</html>

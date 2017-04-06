<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
  if(trim($_POST['numDoc']) == ""){
    header('Location: Reporte_Suspension.php');
    exit();
  }
  $NumeroDocumento=$_POST['numDoc'];
  $user= new empleado_class();
  $user = getInfoEmpleado($NumeroDocumento);
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
                    <div class="text-center" id="respuestaAlert"></div>
                  </div>
                </div>
	            	<div class="row">
					        <div class="col-md-12">
					            <div class="card">
					                <div class="card-header card-header-icon" data-background-color="purple">
					                    <i class="material-icons">contacts</i>
					                </div>
					                <div class="card-content">
					                    <h4 class="card-title">Reporte de <?php echo $user->getPrimernombre()." ".$user->getPrimerapellido()." ".$user->getSegundoapellido(); ?></h4>
					                    <div class="toolbar">
					                        <!--        Here you can write extra buttons/actions for the toolbar              -->
					                    </div>
					                    <div class="material-datatables">
					                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
					                            <thead>
					                                <tr>
					                                    <th>Por</th>
					                                    <th>Fecha</th>
                                              <th>TipoSuspension</th>
                                              <th>Descripcion</th>
					                                    <th class="disabled-sorting text-right">Confirmar</th>
					                                    <th class="disabled-sorting text-right">Eliminar</th>
					                                </tr>
					                            </thead>
					                            <tfoot>
					                                <tr>
                                            <th>Por</th>
                                            <th>Fecha</th>
                                            <th>TipoSuspension</th>
                                            <th>Descripcion</th>
                                            <th class="disabled-sorting text-right">Confirmar</th>
                                            <th class="disabled-sorting text-right">Eliminar</th>
					                                </tr>
					                            </tfoot>

					                            <tbody>
					                            <!-- Desde aqui include Empleados_grid_table.php-->
                                      <?php include '../php/get_Rows.php';
                                       get_Row_Empleado_Suspension($NumeroDocumento);
                                      ?>
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
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="../js/demo.js"></script>
  <!--  DateTime -->
  <script type="text/javascript" src="../js/jquery.datepicker.js"></script>

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


			$('.card .material-datatables label').addClass('form-group');
		  });

	</script>
  <script>
    function imprimirHE(id){
      swal({
        title: 'Seguro que deseas eliminar?',
        text: "Al eliminar ya no se podra recuperar",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
          $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc:9,
                id:id
            },
            beforeSend: function() {
                respAlert("info", "Eliminando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en BD");
                        break;
                    case "1":
                        respAlert("success", "Eliminado...");
                        setTimeout(function() {
                            redireccionar("Reporte_Suspension.php");
                        }, 2000);
                    break;
                }
                //respAlert("success",data[0]);
                /*setTimeout(function(){
                  redireccionar("sistema/home.php");
                },1000);*/
            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
           });
         }, function (dismiss) {
           // dismiss can be 'cancel', 'overlay',
           // 'close', and 'timer'
           if (dismiss === 'cancel') {
             swal(
               'Cancelled',
               'No se ha Eliminado',
               'error'
             )
           }
         })

    };

    function confirmarHE(id){
      swal({
        title: 'Seguro que deseas confirmar?',
        text: "Al confirmar se hara valida la suspension y ya no se podra modificar",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, confirmar!',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $.ajax({
          url: '../php/Modificar.php',
          type: 'POST',
          data: {
              opc:8,
              id:id
          },
          beforeSend: function() {
              respAlert("info", "Confirmando datos...");
          },
          success: function(data) {
              switch (data[0]) {
                  case "0":
                      respAlert("warning", "Error en BD");
                      break;
                  case "1":
                      respAlert("success", "Confirmado...");
                      setTimeout(function() {
                          redireccionar("Reporte_Suspension.php");
                      }, 2000);
                  break;
                  case "2":
                      respAlert("warning", "Esta suspension ya no se encuentra, volviendo...");
                      setTimeout(function() {
                          redireccionar("Reporte_Suspension.php");
                      }, 3000);
                  break;
                  default:
                    respAlert("danger", "ERROR...");
                  break;
              }
              //respAlert("success",data[0]);
              /*setTimeout(function(){
                redireccionar("sistema/home.php");
              },1000);*/
          },
          error: function(data) {
              console.log(data);
              respAlert("danger", "Error...");
          }
         });
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelado',
            'No se ha confirmado',
            'error'
          )
        }
      })
    };
  </script>
</html>

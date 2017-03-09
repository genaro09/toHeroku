<?php
	include '../php/funciones.php';
	include '../php/verificar_sesion.php';
	if(trim($_POST["idHorasExtras"]) == ""){
		header('Location: Reporte_Horas_Extras.php');
		exit();
	}
	$idHorasExtras=$_POST["idHorasExtras"];
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
    <!-- Date -->
		<link rel="stylesheet" href="../css/jquery.datepicker.css">
    <!--custom css-->
    <link rel="stylesheet"  href="../css/customMainCSS.css">
    <link rel="stylesheet" type="text/css" href="../css/icons.css" />
    <link href="../css/font-awesome.min.css" rel="stylesheet">
		<!-- for alert -->
		<script src="../dist/sweetalert.js"></script>
    <link rel="stylesheet" href="../dist/sweetalert.css">
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

		<style>
		.btn-file {
		    position: relative;
		    overflow: hidden;
		}
		.btn-file input[type=file] {
		    position: absolute;
		    top: 0;
		    right: 0;
		    min-width: 100%;
		    min-height: 100%;
		    font-size: 100px;
		    text-align: right;
		    filter: alpha(opacity=0);
		    opacity: 0;
		    outline: none;
		    background: white;
		    cursor: inherit;
		    display: block;
		}
				</style>
				<style>
					.pdfobject-container { height: 500px;}
					.pdfobject { border: 1px solid #666; }
					</style>
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
					        <div class="col-md-6">
					            <div class="card">
					                <div class="card-header card-header-icon" data-background-color="purple">
					                    <i class="material-icons">contacts</i>
					                </div>
					                <div class="card-content">
					                    <h4 class="card-title">PDF</h4>
					                    <div class="toolbar">
					                        <!--        Here you can write extra buttons/actions for the toolbar              -->
					                    </div>
					                    <div class="row">
																<form enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']?>" method="post">
																<?php
																	$data=DatosHorasExtras($idHorasExtras);
																	if($data["exist"]==1){
																		if($data["EstadoHorasExternas"]==0){
																			echo '
																					<p>
																						<input type="hidden" id="idHorasExtras" name="idHorasExtras" value="'.$idHorasExtras.'">
																						<input type="hidden" name="MAX_FILE_SIZE" value="200000" />
																						<div class="col-md-6">
																							<label class="btn btn-block btn-primary">
																							Cargar Archivo&hellip; <input id="uploadPDF" name="pdfFile" type="file" style="display: none;">
																							</label>
																						</div>
																						<div class="col-md-6">
																							<label style="display:none;" id="labelBtnCargar" class="btn btn-block btn-primary">
																								Subir<input disabled id="btnCargar" type="submit" style="display: none;" />
																							</label>
																					</div>
																					</p>
																					<script>
																						window.onload = function() {
																							flagInput=document.getElementById("flaginput").value;
																							if(flagInput==1){
																								swal("Archivo correctamente guardado");
																							}else if(flagInput==2) {
																								swal("Se subio el PDF, pero no se establecio la ruta, contacte a su proveedor");
																							}else{
																								swal("Solo puede subir archivos formato PDF");
																							}
																						};
																					</script>
																			';
																		}else if($data["EstadoHorasExternas"]==1){
																			$Documento="../upload/Horas_Extras/".getFileHorasExtras($idHorasExtras);
																			// url: "str"+'.$Documento.',
																			echo "
																			<object data='".$Documento."#search=location'
																						type='application/pdf'
																						width='100%'
																						height='600'>

																			<p>It appears your Web browser is not configured to display PDF files.
																			No worries, just <a href='".$Documento."'>click here to download the PDF file.</a></p>

																			</object>
																			";
																		}
																	}
																?>
															   </form>

					                    </div>
                              <div class="row">
																<div id="example1"></div>
                                <div id="CuadroPDF" style="display: none;" style="clear:both">
                                   <iframe id="viewer" frameborder="0" scrolling="no" width="100%" height="600"></iframe>
                                </div>
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
                            <h4 class="card-title">Reporte por Empleados</h4>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="material-datatables">
                                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="font-size:16px;">Nombre</th>
                                            <th style="font-size:14px;">Horas Diurnas</th>
                                            <th style="font-size:14px;">Horas Nocturnas</th>
                                            <th style="font-size:16px;">Desde</th>
                                            <th style="font-size:16px;">Hasta</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <th>Nombre</th>
                                          <th>Horas Diurnas</th>
                                          <th>Horas Nocturnas</th>
                                          <th>Desde</th>
                                          <th>Hasta</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                    <!-- Desde aqui include Empleados_grid_table.php-->
                                    <?php include '../php/get_Rows.php';
                                    get_Row_Comprobacion_Horas_Extras($idHorasExtras);
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
	    </div>
	</div>
</body>

    <script type="text/javascript">
    function PreviewImage() {
        pdffile=document.getElementById("uploadPDF").files[0];
        if (!(typeof pdffile !== "undefined" && pdffile.value == '')) {
            pdffile_url=URL.createObjectURL(pdffile);
            $("#CuadroPDF").show();
            $('#viewer').attr('src',pdffile_url);
        }else{
            alert("No ha seleccionado un archivo");
        }
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
	$(function() {

	  // We can attach the `fileselect` event to all file inputs on the page
	  $(document).on('change', ':file', function() {
	    var input = $(this),
	        numFiles = input.get(0).files ? input.get(0).files.length : 1,
	        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	    input.trigger('fileselect', [numFiles, label]);
	  });

	  // We can watch for our custom `fileselect` event like this
	  $(document).ready( function() {
	      $(':file').on('fileselect', function(event, numFiles, label) {

	          var input = $(this).parents('.input-group').find(':text'),
	              log = numFiles > 1 ? numFiles + ' files selected' : label;

	          if( input.length ) {
	              input.val(log);
	          } else {
	              if( log ){
									document.getElementById('btnCargar').disabled = false;
									document.getElementById("labelBtnCargar").style.display = 'block';
									PreviewImage();
								}
	          }

	      });
	  });

	});
	</script>
	<?php
	if ( isset( $_FILES['pdfFile'] ) ) {
		if ($_FILES['pdfFile']['type'] == "application/pdf") {
			$source_file = $_FILES['pdfFile']['tmp_name'];
			$nombreAux=$data["Fecha"]."-".$_SESSION['empresa'];
			$filename  = basename($_FILES['pdfFile']['name']);
			$extension = pathinfo($filename, PATHINFO_EXTENSION);
			$new       = $nombreAux.'.'.$extension;

			$dest_file = "../upload/Horas_Extras/".$new;

			if (file_exists($dest_file)) {
				print "The file name already exists!!";
			}
			else {
				move_uploaded_file( $source_file, $dest_file )
				or die ("Error!!");
				if($_FILES['pdfFile']['error'] == 0) {
					$sePudo=GuardarArchivoHorasExtrasPDF($idHorasExtras,$new);
					if($sePudo==1){
						echo '<input type="hidden" id="flaginput" name="flaginput" value="1" />';
					}else {
						echo '<input type="hidden" id="flaginput" name="flaginput" value="2" />';
					}

					//print "Pdf file uploaded successfully!";
					//print "<b><u>Details : </u></b><br/>";
					//print "File Name : ".$_FILES['pdfFile']['name']."<br.>"."<br/>";
					//print "File Size : ".$_FILES['pdfFile']['size']." bytes"."<br/>";
					//print "File location : upload/".$_FILES['pdfFile']['name']."<br/>";
				}
			}
		}
		else {
			if ( $_FILES['pdfFile']['type'] != "application/pdf") {
				echo '<input type="hidden" id="flaginput" name="flaginput" value="0" />';
				//print "Error occured while uploading file : ".$_FILES['pdfFile']['name']."<br/>";
				//print "Invalid  file extension, should be pdf !!"."<br/>";
				//print "Error Code : ".$_FILES['pdfFile']['error']."<br/>";
			}
		}
	}
	?>

</html>

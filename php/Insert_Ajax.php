<?php
if(trim($_POST['opcAjax']) == ""){
  header('Location: ../sistema/menu.php');
  exit();
}
include '../php/funciones.php';
include '../php/verificar_sesion.php';


$opc=$_POST["opcAjax"];
switch ($opc){
  case '1':
        $flag=1;
        $NombrePor=$_SESSION['usuario_sesion']->getPrimernombre()." ".$_SESSION['usuario_sesion']->getSegundonombre()." ".$_SESSION['usuario_sesion']->getPrimerapellido();
        $NumeroDocumentoPor=$_SESSION['usuario_sesion']->getNumerodocumento();
        # code...
        if(empty($_POST["fecha"])||empty($_POST["TipoReporte"])){
              $flag=0;
        }else{
            $formaPago=$_POST["Banco"];
            if($formaPago=="ninguno"){
              $flag=0;
            }
            $Fecha = $_POST['fecha'];
            $Fecha=explode("/",$Fecha);
            $days=cal_days_in_month(CAL_GREGORIAN,$Fecha[0],$Fecha[1]);
            $TipoReporteVal = $_POST['TipoReporte'];
            $TipoReporte = str_split($TipoReporteVal);
            if($TipoReporte[0]==1){
              $FechaInicio=$Fecha[1]."-".$Fecha[0]."-"."1";//Y-M-D
              $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$days;//Y-M-D
            }elseif ($TipoReporte[0]==2) {
              //Catorcenal
              $dayI=($TipoReporte[1]-1)*14;
              $dayF=($TipoReporte[1])*14;
              if($dayI==0){
                $dayI=1;
              }else $dayI=$dayI+1;
              if($dayF>$days){
                $dayF=$days;
              }
              $FechaInicio=$Fecha[1]."-".$Fecha[0]."-".$dayI;//Y-M-D
              $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$dayF;//Y-M-D
            }elseif ($TipoReporte[0]==3) {
                //quincenal
                $dayI=($TipoReporte[1]-1)*15;
                $dayF=($TipoReporte[1])*15;
                if($dayI==0){
                  $dayI=1;
                }else $dayI=$dayI+1;
                if($dayF>16){
                  $dayF=$days;
                }
                $FechaInicio=$Fecha[1]."-".$Fecha[0]."-".$dayI;//Y-M-D
                $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$dayF;//Y-M-D
            }elseif ($TipoReporte[0]==4) {
                //Semanal
                $dayI=($TipoReporte[1]-1)*7;
                $dayF=($TipoReporte[1])*7;
                if($dayI==0){
                  $dayI=1;
                }else $dayI=$dayI+1;
                if($dayF>$days){
                  $dayF=$days;
                }
                $FechaInicio=$Fecha[1]."-".$Fecha[0]."-".$dayI;//Y-M-D
                $FechaFin=$Fecha[1]."-".$Fecha[0]."-".$dayF;//Y-M-D
              }else{
                echo "ERROR";
                $flag=0;
              }
              $generarTabla=0;
              if($flag==1){
                $checkPagoHorasExtras=checkPagoHorasExtras($FechaInicio,$FechaFin,$TipoReporteVal,$formaPago,$_SESSION["empresa"]);
                if ($checkPagoHorasExtras[0]) {
                  if($checkPagoHorasExtras[1]==0){
                    //Si aun no se ha insertado el cierre de las horas extras
                  }elseif ($checkPagoHorasExtras[1]==1) {
                    //si ya se dio el cieere de las horas extras ya se puede pagar 
                  }
                  $PagosHorasExtras=getPagosHorasExtras($FechaInicio,$FechaFin,$TipoReporteVal,$formaPago,$_SESSION["empresa"]);
                  $idPagos_Horas_Extras=$PagosHorasExtras["idPagos_Horas_Extras"];
                  echo '
                    <div class="row" style="padding-left:5%;">
                      <div class="col-md-4">
                      <h4>Generada Por: </h4><h6>'.$PagosHorasExtras["NombrePor"].'</h6>
                      </div>
                      <div class="col-md-4">
                      <h4>Fecha: </h4><h6>'.$PagosHorasExtras["FechaCreacion"].'</h6>
                      </div>
                      <div class="col-md-4">
                        <form method="POST" action="../php/bancos/recibo.php">
                          <input type="hidden" name="idPagos_Horas_Extras" value="'.$idPagos_Horas_Extras.'">
                          <input class="btn btn-primary"type="submit" value="Ver Recibo">
                        </form>
                      </div>
                    </div>
                  ';
                  $generarTabla=1;
                }else{
                  echo '
                  <p class="text-danger">
                    El pago solo se puede realizar 1 vez, revise la informacion que se presenta en la tabla antes de continuar
                    <br> Revise el Reporte de horas extras, recordando que solo las horas confirmadas seran efectuadas. Le recomendamos pagar las tarjetas de credito primero.
                  </p>
                  ';
                  //$NombrePor
                  echo '
                  <div class="row">
                      <div class="row">
                        <div class="row">
                          <input type="hidden" id="FFechaInicio" name="FFechaInicio" value="'.$FechaInicio.'" />
                          <input type="hidden" id="FFechaFin" name="FFechaFin" value="'.$FechaFin.'" />
                          <input type="hidden" id="TTPago" name="TTPago" value="'.$TipoReporte[0].'" />
                          <input type="hidden" id="FFPago" name="FFPago" value="'.$formaPago.'" />
                          <input type="hidden" id="nombrePor" name="nombrePor" value="'.$NombrePor.'" />
                          <input type="hidden" id="NumeroDocumentoPor" name="NumeroDocumentoPor" value="'.$NumeroDocumentoPor.'" />
                        </div>
                      </div>
                      <div class="col-md-12">
                        <a href="#" id="btnAgregarPagoHorasExtras" class="btn btn-primary btn-fill btn-wd pull-right">Generar Pago</a>
                      </div>
                      <div class="col-md-12">
                        <div class="text-center" id="respuestaAlert"></div>
                      </div>
                  </div>
                  ';
                }

              }
              $totAPagar=00.00;
              if($generarTabla==0){
              //Imprimir la tabla
              //Si existe $generarTabla
                echo '
                  <br>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr class="nameColumn">
                                    <th>NIT</th>
                                    <th>DUI</th>
                                    <th>Nombre</th>
                                    <th>Monto</th>
                                    <th>Departamento/Cargo</th>
                                    <th class="disabled-sorting text-right">Eliminar</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="nameColumn">
                                  <th>NIT</th>
                                  <th>DUI</th>
                                  <th>Nombre</th>
                                  <th>Monto</th>
                                  <th>Departamento/Cargo</th>
                                  <th class="text-right">Eliminar</th>
                                </tr>
                            </tfoot>

                            <tbody>
                            ';
                  //Mostras los que pueden ser
                  $totAPagar=getRowPagoHorasExtrasN($_SESSION["empresa"],$FechaInicio,$FechaFin,$TipoReporteVal,$formaPago);
                echo '
                            </tbody>
                        </table>

                        <br>
                ';
                echo '
                  <div class="row">
                    <div class="tim-typo" id="TotaPagar" style="padding-left:10px;">
                      <h5>Total a Total Liquido a Pagar: '.$totAPagar.'</h5>
                      <br>
                    </div>
                  </div>
                ';
            }elseif ($generarTabla==1) {
              # code...
              echo '
                <br>
                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                          <thead>
                              <tr class="nameColumn">
                                  <th>Nombre</th>
                                  <th>NIT</th>
                                  <th>DUI</th>
                                  <th>ISS</th>
                                  <th>AFP</th>
                                  <th>Renta</th>
                                  <th>Monto Liquido</th>
                                  <th>Departamento/Cargo</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr class="nameColumn">
                                <th>Nombre</th>
                                <th>NIT</th>
                                <th>DUI</th>
                                <th>ISS</th>
                                <th>AFP</th>
                                <th>Renta</th>
                                <th>Monto Liquido</th>
                                <th>Departamento/Cargo</th>
                              </tr>
                          </tfoot>

                          <tbody>
                          ';
                //Mostras los que pueden ser
                $totAPagar=getRowColPagoHorasExtras($idPagos_Horas_Extras);
              echo '
                          </tbody>
                      </table>

                      <br>
              ';
              echo '
                <div class="row">
                  <div class="tim-typo" id="TotaPagar" style="padding-left:10px;">
                    <h5>Total Liquido a Pagar: '.$totAPagar.'</h5>
                    <br>
                  </div>
                </div>
              ';
            }

        }
        ?>
              <script type="text/javascript">

              $(document).ready(function() {
                $(document).on ("click", "#btnAgregarPagoHorasExtras", function () {
                  var table = $("#datatables tbody");
                  FFechaInicio = document.getElementById("FFechaInicio").value;
                  var FFechaFin = document.getElementById("FFechaFin").value;
                  var TTPago = document.getElementById("TTPago").value;
                  var FFPago = document.getElementById("FFPago").value;
                  var nombrePor = document.getElementById("nombrePor").value;
                  var NumeroDocumentoPor = document.getElementById("NumeroDocumentoPor").value;
                  var NDocumentoArray = {};
                  var i=0;
                  table.find('tr').each(function() {
                      var $tds = $(this).find('td'),
                          NDocumento = $tds.eq(1).text();
                          NDocumentoArray[i] = NDocumento;
                          i++;
                  });

                  swal({
                    title: 'Desea Continuar?',
                    text: "Esta accion solo se puede realizar 1 vez, compruebe que los datos esten correctos",
                    type: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, continuar!'
                  }).then(function () {
                    //revisemos si alguien se pasa de sus horas semanales
                    $.ajax({
                      type: 'POST',
                      url: '../sistema/Agregar.php',
                      data: {
                          opc:14,
                          FFechaInicio: FFechaInicio,
                          FFechaFin: FFechaFin,
                          TTPago: TTPago,
                          FFPago: FFPago,
                          nombrePor: nombrePor,
                          NumeroDocumentoPor: NumeroDocumentoPor,
                          NDocumentoArray:NDocumentoArray
                      },
                      beforeSend: function() {
                        respAlert("info", "Verificando datos...");
                      },
                      success: function(response) {
                          var response = "" + response;
                          var response = response.split("%&$");
                          if (response[0] == 1) {
                            //Si hay algo de preguntar
                                swal({
                                  title: 'Desea Continuar?',
                                  text: "<div class='row'><div class='col-md-12'>A estas personas se les agregaran horas extras por sobrepasar Hora maxima de trabajo semanal :</div>"+response[1]+"</div> ",
                                  type: 'warning',
                                  showCancelButton: true,
                                  allowOutsideClick: false,
                                  confirmButtonColor: '#3085d6',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Si, continuar!',
                                  cancelButtonText: 'No, cancelar!'
                                }).then(function () {
                                  $.ajax({
                                    type: 'POST',
                                    url: '../php/AgregarPagoHorasExtras.php',
                                    data: {
                                        FFechaInicio: FFechaInicio,
                                        FFechaFin: FFechaFin,
                                        TTPago: TTPago,
                                        FFPago: FFPago,
                                        nombrePor: nombrePor,
                                        NumeroDocumentoPor: NumeroDocumentoPor,
                                        NDocumentoArray: JSON.stringify(NDocumentoArray)
                                    },
                                    beforeSend: function() {
                                      respAlert("info", "Verificando datos...");
                                    },
                                    success: function(response) {
                                        var response = "" + response;
                                        var response = response.split(",");
                                        if (response[0] == 0) {
                                            respAlert("warning", response[1]);
                                        }else {
                                          setTimeout(function() {
                                              respAlert("success", response[1]);
                                              redireccionar("Pagos_Horas_Extras.php");
                                          }, 3000);
                                        }
                                    }
                                  });//Fin Ajax
                                }, function (dismiss) {
                                  // dismiss can be 'cancel', 'overlay',
                                  // 'close', and 'timer'
                                  if (dismiss === 'cancel') {
                                    respAlert("info", "Cancelado");
                                    swal(
                                      'Cancelado',
                                      'No se ha realizado el  pago',
                                      'error'
                                    )
                                  }
                              }).catch(swal.noop);
                          }else {

                          }
                      }

                    })

                  }).catch(swal.noop);

                });

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


                  //class="nameColumn"
                  var totals=0;
                  var $dataRows=$("#datatables tr:not('.nameColumn')");
                  $dataRows.each(function() {
                      $(this).find('.rowDataSd').each(function(){
                          totals+=parseFloat($(this).html());
                      });
                  });
                  html="<h5>Total Liquido a Pagar: "+totals.toFixed(2)+"</h5><br>";
                  $("#TotaPagar").html(html);
                } );

                //Like record
                table.on( 'click', '.like', function () {
                  alert('You clicked on Like button');
                });

                $('.card .material-datatables label').addClass('form-group');
              });


              	</script>
        <?php

    break;
    case '2':
      if(!empty($_POST["firstCell"])){
        if(isUserExist($_POST["firstCell"])){
          //ya sabemos que entro bien
          $empleado=getInfoUser($_POST["firstCell"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $str="";
          $str='
            <div class="row">
              <div class="col-md-12">
                <h5 style="padding-left:10px;">Empleado:</h5>
                <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
                <br>
                <form>
                  <div class="form-group col-md-4">
                    <label>Tipo de Incapacidad</label>
                    <br>
                    <select id="TIncapacidad" name="TIncapacidad" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                      <option value="1">ISSS</option>
                      <option value="2">Clinica Particular</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4" style="display: none;" id="NomDIV">
                    <label>Nombre Clinica</label>
                    <input type="text" id="nombreClinica" name="nombreClinica"  class="form-control" placeholder="Escriba el nombre completo de la clinica" required="true">
                  </div>
                  <div class="form-group col-md-4" style="display: none;" id="NumDIV">
                    <label>Numero de Telefono Clinica</label>
                    <input type="text" id="numTClinica" name="numTClinica"  class="form-control" placeholder="24567854" required="true">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Nombre del Doctor</label>
                    <input type="text" id="NDoctor" name="NDoctor"  class="form-control" placeholder="Nombre del doctor" required="true">
                  </div>
                  <div class="form-group col-md-4">
                    <label>Fecha Inicio</label>
                    <div class="input-group date" id="datetimepicker1">
                       <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaInicio" data-select="datepicker"/>
                    </div>
                  </div>

                  <div class="form-group col-md-4">
                    <label>Fecha Fin</label>
                    <div class="input-group date" id="datetimepicker1">
                       <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaFin" data-select="datepicker"/>
                    </div>
                  </div>

                  <div class="form-group col-md-4">
                    <label>Fecha Expedicion</label>
                    <div class="input-group date" id="datetimepicker1">
                       <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaExpedicion" data-select="datepicker"/>
                    </div>
                  </div>

                  <div class="form-group col-md-4">
                    <input type="hidden" id="numDoc" name="numDoc" value="'.$_POST["firstCell"].'">
                    <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnAgregarIncap" name="btnAgregarIncap" value="Agregar" />
                  </div>
                </form>
              </div>
            </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
    break;
    case '3':
      if(!empty($_POST["firstCell"])){
        if(isUserExist($_POST["firstCell"])){
          //ya sabemos que entro bien
          $empleado=getInfoUser($_POST["firstCell"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $NitEmpresa=$_SESSION['empresa'];//Empresa
          $str='
          <h5 style="padding-left:10px;">Empleado:</h5>
          <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
          <br>
          <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Emisor</th>
                          <th>Desde</th>
                          <th>Hasta</th>
                          <th class="disabled-sorting text-right">Acciones</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Emisor</th>
                          <th>Desde</th>
                          <th>Hasta</th>
                          <th class="text-right">Acciones</th>
                      </tr>
                  </tfoot>

                  <tbody>
                  <!-- Desde aqui include Empleados_grid_table.php-->
          ';
          $cnx=cnx();
          $query=sprintf("SELECT incapacidad.*,EMP.PrimerNombre AS EMPN,EMP.SegundoNombre AS EMSN,EMP.PrimerApellido AS EMPA, EMP.SegundoApellido AS EMSP,EMPor.PrimerNombre,EMPor.SegundoNombre,EMPor.PrimerApellido,EMPor.SegundoApellido from incapacidad INNER JOIN empleado AS EMP INNER JOIN empleado AS EMPor WHERE incapacidad.NumeroDocumento='%s' AND incapacidad.NumeroDocumento=EMP.NumeroDocumento AND incapacidad.NumeroDocumentoPor=EMPor.NumeroDocumento",mysqli_real_escape_string($cnx,$_POST["firstCell"]));
          $result=mysqli_query($cnx,$query);
          while ($row=mysqli_fetch_array($result)) {
            $tipo="ERROR";
            if($row["TipoIncapacidad"]==1){
              $tipo="ISSS";
            }elseif ($row["TipoIncapacidad"]==2) {
              $tipo=$row["NombreClinica"];
            }
            //si ya esta revisado
            if($row["EstadoComprobacion"]==0){
              $comp='<i class="material-icons">warning</i>';
              $setting='
              <button name="modificarIncapacidad" id="modificarIncapacidad"  style="background: transparent;border: none;">
               <div class="icon">
                    <i class="material-icons">build</i>
               </div>
              </button>
              ';
            }elseif ($row["EstadoComprobacion"]==1) {
              # code...
              $comp='<i class="material-icons">check_circle</i>';
              $setting="";
            }else{
              $comp='<i class="material-icons">ERROR</i>';
              $setting='ERROR';
            }
            //<td>'.$row["EMPN"].' '.$row["EMSN"].' '.$row["EMPA"].' '.$row["EMSP"].'</td>
            $str=$str.'
              <tr data-id="'.$row["idIncapacidad"].'">
                 <td>'.$row["FechaCreacion"].'</td>
                 <td>'.$row["PrimerNombre"].' '.$row["SegundoNombre"].' '.$row["PrimerApellido"].' '.$row["SegundoApellido"].'</td>
                 <td>'.$tipo.'</td>
                 <td>'.$row["DiaInicio"].'</td>
                 <td>'.$row["DiaFin"].'</td>
                 <td class="text-right">
                   <div class="row">
                     <div class="col-md-12">
                      <input type="hidden" class="idIncapacidad" id="idIncapacidad" name="idIncapacidad" value="'.$row["idIncapacidad"].'">
                      <div class="col-md-6">
                        <button name="verificarIncapacidad" id="verificarIncapacidad"  style="background: transparent;border: none;">
                         <div class="icon">
                              '.$comp.'
                         </div>
                       </button>
                      </div>
                      <div class="col-md-6">
                        '.$setting.'
                     </div>
                    </div>
                   </div>
                 </td>
              </tr>
            ';

          }
          mysqli_close($cnx);
          $str=$str.'
                    </tbody>
                </table>
            </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
    break;
  case '4':
      $str='
        <div class="material-datatables">
            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                <thead>
                    <tr>
                        <th>DUI</th>
                        <th>Nombre</th>
                        <th>Ingreso</th>
                        <th class="disabled-sorting text-right">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>DUI</th>
                        <th>Nombre</th>
                        <th>Ingreso</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </tfoot>

                <tbody>
                <!-- Desde aqui include Empleados_grid_table.php-->


      ';
      $NitEmpresa=getNitEmpresa($_SESSION['usuario_sesion']);
      $cnx=cnx();
      $query=sprintf("SELECT empleado.* from empleado INNER JOIN cargos INNER JOIN departamento inner JOIN empresa WHERE empresa.NitEmpresa='%s' AND departamento.NitEmpresa=empresa.NitEmpresa and cargos.idDepartamento=departamento.idDepartamento and empleado.idCargos=cargos.idCargos and empleado.Activo='1'",mysqli_real_escape_string($cnx,$NitEmpresa));
      $result=mysqli_query($cnx,$query);
      while ($row=mysqli_fetch_array($result)) {
              $str=$str."
              <tr data-id='".$row['NumeroDocumento']."'>
                <td>".$row["NumeroDocumento"]."</td>
                <td>".$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"]."</td>
                <td>".number_format((float)$row["SalarioNominal"], 2, '.', '')."</td>
                <td class='text-right'>
                  <div class='row'>
                    <div class='col-md-12' style='margin-top:5px;'>
                      <div class='col-md-4'>
                          <input type='hidden' class='NumeroDocumento' id='numDoc' name='numDoc' value='".$row["NumeroDocumento"]."'>
                          <input type='button' class='btn btn-primary btn-sm' id='btnIncapacidad' name='btnIncapacidad' value='Incapacidad' style='width:100%;overflow:hidden;font-size: 75%;margin-top:0px;height:100%;'/>
                      </div>
                      <div class='col-md-4'>
                          <input type='button' class='btn btn-info btn-sm' id='btnAusencia' name='btnAusencia' value='Ausencia' style='width:100%;overflow:hidden;font-size: 75%;margin-top:0px;height:100%;'/>
                      </div>
                      <div class='col-md-4'>
                          <input type='button' class='btn btn-warning btn-sm' id='btnPermiso' name='btnPermiso' value='Permisos' style='width:100%;overflow:hidden;font-size: 75%;margin-top:0px;height:100%;'/>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>";
      }
      mysqli_close($cnx);
      $str=$str.'
            </tbody>
        </table>
        </div>
      ';
    echo "0,".$str;//el html que vamos a enviar sin comas
  break;
  case '5':
    # code...
    if(!empty($_POST["firstCell"])){
      if(isUserExist($_POST["firstCell"])){
        //ya sabemos que entro bien
        $empleado=getInfoUser($_POST["firstCell"]);
        $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
        $str='
          <div class="row">
           <h5 style="padding-left:10px;">Empleado:</h5>
           <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
           <br>
        	 <div class="col-lg-10 col-lg-offset-1">
           <input type="hidden" name="NumeroDocumento" id="NumeroDocumento" value="'.$_POST["firstCell"].'">
             <div class="col-sm-1">
             </div>
        	  <div class="col-sm-4">
        		  <div class="choice" data-toggle="wizard-checkbox">
        			   <button name="agregarIncapacidad" id="agregarIncapacidad"  style="background: transparent;border: none;">
          				 <div class="icon">
                       <i class="material-icons">add</i>
          				 </div>
        				 <h6>Agregar</h6>
                </button>
        			</div>
        		</div>
            <div class="col-sm-2">
            </div>
        		<div class="col-sm-4">
        		  <div class="choice" data-toggle="wizard-checkbox">
        			   <button id="verIncapacidad" name="verIncapacidad" style="background: transparent;border: none;">
          				 <div class="icon">
                       <i class="material-icons">playlist_add_check</i>
          				 </div>
                 </button>
        			   <h6>Ver</h6>
        			</div>
        	 </div>
           <div class="col-sm-1">
           </div>
         </div>
       </div>
        ';
        echo "0,".$str;//el html que vamos a enviar sin comas
      }else{
        echo "1,Envio un valor errado";
      }
    }else {
      echo "1,Envio un valor vacio";
    }
    break;
  case '6':
    //modificar incapacidad
    if(!empty($_POST["idIncapacidad"])){
      if(isIncapExist($_POST["idIncapacidad"])){
        //ya sabemos que entro bien
        $cnx=cnx();
        $query=sprintf("SELECT * FROM incapacidad where idIncapacidad='%s'",mysqli_real_escape_string($cnx,$_POST["idIncapacidad"]));
    		$resul=mysqli_query($cnx,$query);
    		$row=mysqli_fetch_array($resul);
        mysqli_close($cnx);
        $empleado=getInfoUser($row["NumeroDocumento"]);
        $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
        if($row["TipoIncapacidad"]==1){
          //ISSS
          $tipoInca='
          <select id="TIncapacidad" name="TIncapacidad" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
            <option value="1" selected>ISSS</option>
            <option value="2">Clinica Particular</option>
          </select>
          ';
          $ocultos='
            <div class="form-group col-md-4" style="display: none;" id="NomDIV">
              <label>Nombre Clinica</label>
              <input type="text" id="nombreClinica" name="nombreClinica"  class="form-control" placeholder="Escriba el nombre completo de la clinica" required="true">
            </div>
            <div class="form-group col-md-4" style="display: none;" id="NumDIV">
              <label>Numero de Telefono Clinica</label>
              <input type="text" id="numTClinica" name="numTClinica"  class="form-control" placeholder="24567854" required="true">
            </div>
          ';
        }elseif ($row["TipoIncapacidad"]==2) {
          //Clinica
          $tipoInca='
          <select id="TIncapacidad" name="TIncapacidad" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
            <option value="1">ISSS</option>
            <option value="2" selected>Clinica Particular</option>
          </select>
          ';
          $ocultos='
            <div class="form-group col-md-4" id="NomDIV">
              <label>Nombre Clinica</label>
              <input type="text" id="nombreClinica" name="nombreClinica"  class="form-control" placeholder="Escriba el nombre completo de la clinica" value="'.$row["NombreClinica"].'" required="true">
            </div>
            <div class="form-group col-md-4"  id="NumDIV">
              <label>Numero de Telefono Clinica</label>
              <input type="text" id="numTClinica" name="numTClinica"  class="form-control" placeholder="24567854" value="'.$row["NumeroTelefonoClinica"].'" required="true">
            </div>
          ';
        }else{
          echo "1, ERROR!!";
        }
        $str="";
        $DiaInicio = new DateTime($row["DiaInicio"]);
        $DiaFin = new DateTime($row["DiaFin"]);
        $FechaExpedicion = new DateTime($row["FechaExpedicion"]);
        $str='
          <div class="row">
            <div class="col-md-12">
              <h5 style="padding-left:10px;">Modificar Incapacitacion</h5>
              <br>
              <h5 style="padding-left:10px;">Empleado:</h5>
              <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
              <br>
              <form>
                <div class="form-group col-md-4">
                  <label>Tipo de Incapacidad</label>
                  <br>
                  '.$tipoInca.'
                </div>
                '.$ocultos.'
                <div class="form-group col-md-4">
                  <label>Nombre del Doctor</label>
                  <input type="text" id="NDoctor" name="NDoctor"  class="form-control" placeholder="Nombre del doctor" value="'.$row["Doctor"].'" required="true">
                </div>
                <div class="form-group col-md-4">
                  <label>Fecha Inicio</label>
                  <div class="input-group date" id="datetimepicker1">
                     <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' value="'.$DiaInicio->format('d/m/Y').'" name="date" id="FechaInicio" data-select="datepicker"/>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha Fin</label>
                  <div class="input-group date" id="datetimepicker1">
                     <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' value="'.$DiaFin->format('d/m/Y').'" name="date" id="FechaFin" data-select="datepicker"/>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Fecha Expedicion</label>
                  <div class="input-group date" id="datetimepicker1">
                     <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' value="'.$FechaExpedicion->format('d/m/Y').'" name="date" id="FechaExpedicion" data-select="datepicker"/>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <input type="hidden" id="idIncapacidad" name="idIncapacidad" value="'.$_POST["idIncapacidad"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnModificarIncap" name="btnModificarIncap" value="Modificar" />
                </div>
                <div class="form-group col-md-4">
                  <input type="hidden" id="idIncapacidad" name="idIncapacidad" value="'.$_POST["idIncapacidad"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-danger btn-wd" id="btnEliminarIncap" name="btnEliminarIncap" value="Eliminar" />
                </div>
              </form>
            </div>
          </div>
        ';
        echo "0,".$str;//el html que vamos a enviar sin comas
      }else{
        echo "1,Envio un valor errado";
      }
    }else {
      echo "1,Envio un valor vacio";
    }
  break;
  case '7':
    if(!empty($_POST["idIncapacidad"])){
      if(isIncapExist($_POST["idIncapacidad"])){
        //ya sabemos que entro bien
        $infoIncapacidad=getIncapacidad($_POST["idIncapacidad"]);
        $str='
        <div class="row">
          <div class="col-md-6">
              <div class="card">
                  <div class="card-header card-header-icon" data-background-color="purple">
                      <i class="material-icons">contacts</i>
                  </div>
                  <div class="card-content">
                      <h4 class="card-title">Unicamente Imagen o PDF</h4>
                      <div class="toolbar">
                          <!--        Here you can write extra buttons/actions for the toolbar              -->
                      </div>
                      <div class="row">


        ';
        if($infoIncapacidad["EstadoComprobacion"]==0){
          $str=$str.'
            <form action="upload.php" method="post" enctype="multipart/form-data">
              <p>
                <input type="hidden" id="idupload" name="idupload" value="1%'.$_POST["idIncapacidad"].'">
                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                <div class="col-md-6">
                  <label class="btn btn-block btn-primary">
                  Cargar Archivo&hellip; <input id="uploadPDF" name="myFile" type="file" style="display: none;">
                  </label>
                </div>
                <div class="col-md-6">
                  <label style="display:none;" id="labelBtnCargar" class="btn btn-block btn-primary">
                    Subir<input disabled id="btnCargar" value="Upload" type="submit" style="display: none;" />
                  </label>
                </div>
              </p>
            </form>
          ';
        }elseif ($infoIncapacidad["EstadoComprobacion"]==1) {
          # code...
          $getFile=getFileIncapacidades($_POST["idIncapacidad"]);
          $Documento="../upload/Incapacidades/".$getFile[1];
          if($getFile[0]=="pdf"){
            $str=$str."
            <iframe src='".$Documento."' style='width:100%;height:600px;' frameborder='0'></iframe>
            ";
          }else{
            $str=$str.'
            <img src="'.$Documento.'"  style="width="100%";height:600;">';
          }
        };
        if($infoIncapacidad["TipoIncapacidad"]==1){
          //ISS
          $tipoIN='
          <h4>Emisor</h4>
          <p style="padding-left:15px">ISS</p>
          ';
        }elseif ($infoIncapacidad["TipoIncapacidad"]==2) {
          //CLINICA
          $tipoIN='
          <h4>Emisor</h4>
          <p style="padding-left:15px">'.$infoIncapacidad["NombreClinica"].'</p>
          <h4>Numero Telefonico</h4>
          <p style="padding-left:15px">'.$infoIncapacidad["NumeroTelefonoClinica"].'</p>
          ';
        }else{
          $tipoIN='ERROR recargue la pagina';
        }
          $str=$str.'
                   </div>

                  </div><!-- end content-->
               </div><!--  end card  -->
            </div> <!-- end col-md-6 -->

            <div class="col-md-6">
              <div class="card">
                  <div class="card-header card-header-icon" data-background-color="purple">
                      <i class="material-icons">card_travel</i>
                  </div>
                  <div class="card-content">
                    <h3 class="card-title">Reporte Incapacidad</h3>
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <h4>Fecha de Creacion</h4>
                    <p style="padding-left:15px"> '.$infoIncapacidad["FechaCreacion"].'</p>
                    '.$tipoIN.'
                    <h4>Doctor</h4>
                    <p style="padding-left:15px"> '.$infoIncapacidad["Doctor"].'</p>
                    <h4>Periodo de Incapacidad</h4>
                    <p style="padding-left:15px"> Desde: '.$infoIncapacidad["DiaInicio"].' Hasta: '.$infoIncapacidad["DiaFin"].'</p>
                    <h4>Fecha de Expedición</h4>
                    <p style="padding-left:15px"> '.$infoIncapacidad["FechaExpedicion"].'</p>
                    </div><!-- end content-->
                </div><!--  end card  -->
            </div>

            <!-- FIN -->
      </div> <!-- end row -->
          ';
        echo "0,".$str;//el html que vamos a enviar sin comas
      }else{
        echo "1,Envio un valor errado";
      }
    }else {
      echo "1,Envio un valor vacio";
    }
    break;
    case '8':
      # code...
        if(!empty($_POST["firstCell"])){
          if(isUserExist($_POST["firstCell"])){
            //ya sabemos que entro bien
            $empleado=getInfoUser($_POST["firstCell"]);
            $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
            $str='
              <div class="row">
               <h5 style="padding-left:10px;">Ausencia-Empleado:</h5>
               <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
               <br>
               <div class="col-lg-10 col-lg-offset-1">
               <input type="hidden" name="NumeroDocumento" id="NumeroDocumento" value="'.$_POST["firstCell"].'">
                 <div class="col-sm-1">
                 </div>
                <div class="col-sm-4">
                  <div class="choice" data-toggle="wizard-checkbox">
                     <button name="agregarAusencia" id="agregarAusencia"  style="background: transparent;border: none;">
                       <div class="icon">
                           <i class="material-icons">add</i>
                       </div>
                     <h6>Agregar</h6>
                    </button>
                  </div>
                </div>
                <div class="col-sm-2">
                </div>
                <div class="col-sm-4">
                  <div class="choice" data-toggle="wizard-checkbox">
                     <button id="verAusencia" name="verAusencia" style="background: transparent;border: none;">
                       <div class="icon">
                           <i class="material-icons">playlist_add_check</i>
                       </div>
                     </button>
                     <h6>Ver</h6>
                  </div>
               </div>
               <div class="col-sm-1">
               </div>
             </div>
           </div>
            ';
            echo "0,".$str;//el html que vamos a enviar sin comas
          }else{
            echo "1,Envio un valor errado";
          }
        }else {
          echo "1,Envio un valor vacio";
        }
      break;
  case '9':
    # code...
    if(!empty($_POST["firstCell"])){
      if(isUserExist($_POST["firstCell"])){
        //ya sabemos que entro bien
        $empleado=getInfoUser($_POST["firstCell"]);
        $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
        $str="";
        $str='
          <div class="row">
            <div class="col-md-12">
              <h5 style="padding-left:10px;">Ausencia-Empleado:</h5>
              <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
              <br>
              <form>
                <div class="form-group col-md-4">
                  <label>Tipo de Ausencia</label>
                  <br>
                  <select id="TAusencia" name="TAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                    <option value="1">SIN JUSTIFICACION</option>
                    <option value="2">CON JUSTIFICACION</option>
                  </select>
                </div>
                <div class="form-group col-md-4" id="EDAusencia">
                  <label>Estado/Descuento de Ausencia</label>
                  <br>
                  <select id="EstadoAusencia" name="EstadoAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                    <option value="1">DIA Y SEPTIMO</option>
                    <option value="2">PENDIENTE</option>
                  </select>
                </div>


                <div class="form-group col-md-4">
                  <label>Fecha</label>
                  <div class="input-group date" id="datetimepicker1">
                     <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaAusencia" data-select="datepicker"/>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Observación</label>
                  <textarea id="Observacion" name="Observacion" class="form-control" required="true" rows="3"></textarea>
                  <span class="material-input"></span>
                </div>

                <div class="form-group col-md-4">
                  <input type="hidden" id="numDoc" name="numDoc" value="'.$_POST["firstCell"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnAgregarAusencia" name="btnAgregarAusencia" value="Agregar" />
                </div>
              </form>
            </div>
          </div>
        ';
        echo "0,".$str;//el html que vamos a enviar sin comas
      }else{
        echo "1,Envio un valor errado";
      }
    }else {
      echo "1,Envio un valor vacio";
    }
    break;
  case '10':
      # code...
      if(!empty($_POST["firstCell"])){
        if(isUserExist($_POST["firstCell"])){
          //ya sabemos que entro bien
          $empleado=getInfoUser($_POST["firstCell"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $NitEmpresa=$_SESSION['empresa'];//Empresa
          $str='
          <h5 style="padding-left:10px;">Ausencia-Empleado:</h5>
          <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
          <br>
          <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Justificacion</th>
                          <th>Descuento/Estado</th>
                          <th>Fecha Ausencia</th>
                          <th class="disabled-sorting text-right">Acciones</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Justificacion</th>
                          <th>Descuento/Estado</th>
                          <th>Fecha Ausencia</th>
                          <th class="text-right">Acciones</th>
                      </tr>
                  </tfoot>

                  <tbody>
                  <!-- Desde aqui include Empleados_grid_table.php-->
          ';
          $cnx=cnx();
          $query=sprintf("SELECT ausencia.*,EMP.PrimerNombre AS EMPN,EMP.SegundoNombre AS EMSN,EMP.PrimerApellido AS EMPA, EMP.SegundoApellido AS EMSP,EMPor.PrimerNombre,EMPor.SegundoNombre,EMPor.PrimerApellido,EMPor.SegundoApellido from ausencia INNER JOIN empleado AS EMP INNER JOIN empleado AS EMPor WHERE ausencia.NumeroDocumento='%s' AND ausencia.NumeroDocumento=EMP.NumeroDocumento AND ausencia.NumeroDocumentoPor=EMPor.NumeroDocumento",mysqli_real_escape_string($cnx,$_POST["firstCell"]));
          $result=mysqli_query($cnx,$query);
          while ($row=mysqli_fetch_array($result)) {
            $tipo="ERROR";
            $NombrePor=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
            if($row["TipoAusencia"]==1){
              $tipo="SIN JUSTIFICACION";
            }elseif ($row["TipoAusencia"]==2) {
              $tipo="CON JUSTIFICACION";
            }
            //si ya esta revisado
            if($row["EstadoAusencia"]==2){
              $justificacion="Pendiente";
              $comp='<i class="material-icons">warning</i>';
              $setting='
              <button name="modificarAusencia" id="modificarAusencia"  style="background: transparent;border: none;">
               <div class="icon">
                    <i class="material-icons">build</i>
               </div>
              </button>
              ';
            }elseif ($row["EstadoAusencia"]==1 || $row["EstadoAusencia"]==0) {
              # code...
              if($row["EstadoAusencia"]==1){
                $justificacion="DIA Y SEPTIMO";
              }else {
                $justificacion="";
              }
              $comp='<i class="material-icons">check_circle</i>';
              if(isAusenDocExist($row["idAusencia"])){
                $setting='';
              }else {
                $setting='
                <button name="modificarAusencia" id="modificarAusencia"  style="background: transparent;border: none;">
                 <div class="icon">
                      <i class="material-icons">build</i>
                 </div>
                </button>
                ';
              }

            }else{
              $comp='<i class="material-icons">ERROR</i>';
              $setting='ERROR';
              $justificacion="ERROR";
            }
            $str=$str.'
              <tr data-id="'.$row["idAusencia"].'">
                 <td>'.$row["FechaCreacion"].'</td>
                 <td>'.$NombrePor.'</td>
                 <td>'.$tipo.'</td>
                 <td>'.$justificacion.'</td>
                 <td>'.$row["FechaAusencia"].'</td>
                 <td class="text-right">
                   <div class="row">
                     <div class="col-md-12">
                      <input type="hidden" class="idAusencia" id="idAusencia" name="idAusencia" value="'.$row["idAusencia"].'">
                      <div class="col-md-6">
                        <button name="verificarAusencia" id="verificarAusencia"  style="background: transparent;border: none;">
                         <div class="icon">
                              '.$comp.'
                         </div>
                       </button>
                      </div>
                      <div class="col-md-6">
                        '.$setting.'
                     </div>
                    </div>
                   </div>
                 </td>
              </tr>
            ';

          }
          mysqli_close($cnx);
          $str=$str.'
                    </tbody>
                </table>
            </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
  break;
  case '11':
  //modificar Ausencias
      if(!empty($_POST["idAusencia"])){
        if(isAusenExist($_POST["idAusencia"])){
          //ya sabemos que entro bien
          $cnx=cnx();
          $query=sprintf("SELECT * FROM ausencia  where idAusencia='%s'",mysqli_real_escape_string($cnx,$_POST["idAusencia"]));
          $resul=mysqli_query($cnx,$query);
          $row=mysqli_fetch_array($resul);
          mysqli_close($cnx);
          $empleado=getInfoUser($row["NumeroDocumento"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $tipoEstado='';
          $str="";
          $DiaInicio = new DateTime($row["FechaAusencia"]);
          if($row["TipoAusencia"]==1){
            //SIN JUSTIFICACION
            $tipoEstado='
              <div class="form-group col-md-4">
                <label>Tipo de Ausencia</label>
                <br>
                <select id="TAusencia" name="TAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                  <option selected value="1">SIN JUSTIFICACION</option>
                  <option value="2">CON JUSTIFICACION</option>
                </select>
              </div>
            ';
              if($row["EstadoAusencia"]==1){
                //Dia y Septimo
                $tipoEstado=$tipoEstado.'
                  <div class="form-group col-md-4"  id="EDAusencia">
                    <label>Estado/Descuento de Ausencia</label>
                    <br>
                    <select id="EstadoAusencia" name="EstadoAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                      <option selected value="1">DIA Y SEPTIMO</option>
                      <option value="2">PENDIENTE</option>
                    </select>
                  </div>
                ';
              }elseif ($row["EstadoAusencia"]==2) {
                ///PENDIENTE
                $tipoEstado=$tipoEstado.'
                  <div class="form-group col-md-4"  id="EDAusencia">
                    <label>Estado/Descuento de Ausencia</label>
                    <br>
                    <select id="EstadoAusencia" name="EstadoAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                      <option value="1">DIA Y SEPTIMO</option>
                      <option selected value="2">PENDIENTE</option>
                    </select>
                  </div>
                ';
              }
          }elseif ($row["TipoAusencia"]==2) {
            //CON JUSTIFICACION
            $tipoEstado='
            <div class="form-group col-md-4">
              <label>Tipo de Ausencia</label>
              <br>
              <select id="TAusencia" name="TAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                <option value="1">SIN JUSTIFICACION</option>
                <option selected value="2">CON JUSTIFICACION</option>
              </select>
            </div>
            <div class="form-group col-md-4" style="display: none;" id="EDAusencia">
              <label>Estado/Descuento de Ausencia</label>
              <br>
              <select id="EstadoAusencia" name="EstadoAusencia" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                <option value="1">DIA Y SEPTIMO</option>
                <option value="2">PENDIENTE</option>
              </select>
            </div>
            ';
          }

          $str='
          <div class="row">
            <div class="col-md-12">
              <h5 style="padding-left:10px;">Ausencia-Empleado:</h5>
              <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
              <br>
              <form>
              '.$tipoEstado.'
                <div class="form-group col-md-4">
                  <label>Fecha</label>
                  <div class="input-group date" id="datetimepicker1">
                    <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' value="'.$DiaInicio->format('d/m/Y').'" name="date" id="FechaAusencia" data-select="datepicker"/>
                  </div>
                </div>

                <div class="form-group col-md-4">
                  <label>Observación</label>
                  <textarea id="Observacion" name="Observacion" class="form-control" required="true" rows="3">'.$row["Observacion"].'</textarea>
                  <span class="material-input"></span>
                </div>

                <div class="form-group col-md-4">
                  <input type="hidden" id="idAusencia" name="idAusencia" value="'.$_POST["idAusencia"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnModificarAusencia" name="btnModificarAusencia" value="Modificar" />
                </div>
                <div class="form-group col-md-4">
                  <input type="hidden" id="idAusencia" name="idAusencia" value="'.$_POST["idAusencia"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-danger btn-wd" id="btnEliminarAusencia" name="btnEliminarAusencia" value="Eliminar" />
                </div>
              </form>
            </div>
          </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
    break;
    case '12':
      # code..
      if(!empty($_POST["idAusencia"])){
        if(isAusenExist($_POST["idAusencia"])){
          //ya sabemos que entro bien
          $infoAusencia=getAusencia($_POST["idAusencia"]);
          if ($infoAusencia["TipoAusencia"]==2) {
            //Si tiene justificacion necesita un Comprobante
              $str='
              <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="purple">
                            <i class="material-icons">contacts</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">Comprobante</h4>
                            <h6>Unicamente Imagen o PDF</h6>
                            <div class="toolbar">
                                <!--        Here you can write extra buttons/actions for the toolbar              -->
                            </div>
                            <div class="row">


              ';
              if(!isAusenDocExist($_POST["idAusencia"])){
                //no tiene un archivo
                $str=$str.'
                  <form action="upload.php" method="post" enctype="multipart/form-data">
                    <p>
                      <input type="hidden" id="idupload" name="idupload" value="2%'.$_POST["idAusencia"].'">
                      <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                      <div class="col-md-6">
                        <label class="btn btn-block btn-primary">
                        Cargar Archivo&hellip; <input id="uploadPDF" name="myFile" type="file" style="display: none;">
                        </label>
                      </div>
                      <div class="col-md-6">
                        <label style="display:none;" id="labelBtnCargar" class="btn btn-block btn-primary">
                          Subir<input disabled id="btnCargar" value="Upload" type="submit" style="display: none;" />
                        </label>
                      </div>
                    </p>
                  </form>
                ';
              }elseif (isAusenDocExist($_POST["idAusencia"])) {
                # code...
                $getFile=getFileAusencias($_POST["idAusencia"]);
                $Documento="../upload/Ausencias/".$getFile[1];
                if($getFile[0]=="pdf"){
                  $str=$str."
                  <iframe src='".$Documento."' style='width:100%;height:600px;' frameborder='0'></iframe>
                  ";
                }else{
                  $str=$str.'
                  <img src="'.$Documento.'"  style="width="100%";height:600;">';
                }
              };
          }else {
            $str="";
          }

          if($infoAusencia["TipoAusencia"]==1){
            //Sin justificacion
            if($infoAusencia["EstadoAusencia"]==1){
              $tipAusencia='
              <h4>Justificación</h4>
              <p style="padding-left:15px">SIN JUSTIFICACION</p>
              <h4>Descuento</h4>
              <p style="padding-left:15px">DIA Y SEPTIMO</p>
              ';
            }elseif ($infoAusencia["EstadoAusencia"]==2) {
              $tipAusencia='
              <h4>Justificación</h4>
              <p style="padding-left:15px">SIN JUSTIFICACION</p>
              <h4>Estado</h4>
              <p style="padding-left:15px">PENDIENTE</p>
              ';
            }else {
              $tipAusencia='ERROR';
            }
          }elseif ($infoAusencia["TipoAusencia"]==2) {
            //con justificacion
            $tipAusencia='
            <h4>Justificación</h4>
            <p style="padding-left:15px">CON JUSTIFICACION</p>
            ';
          }else{
            $tipoIN='ERROR recargue la pagina';
          }
            $str=$str.'
                     </div>

                    </div><!-- end content-->
                 </div><!--  end card  -->
              </div> <!-- end col-md-6 -->

              <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">card_travel</i>
                    </div>
                    <div class="card-content">
                      <h3 class="card-title">Reporte Incapacidad</h3>
                      <div class="toolbar">
                          <!--        Here you can write extra buttons/actions for the toolbar              -->
                      </div>
                      <h4>Fecha de Creacion</h4>
                      <p style="padding-left:15px"> '.$infoAusencia["FechaCreacion"].'</p>
                      '.$tipAusencia.'
                      <h4>Fecha de ausencia</h4>
                      <p style="padding-left:15px"> '.$infoAusencia["FechaAusencia"].'</p>
                      <h4>Observacion</h4>
                      <p style="padding-left:15px"> '.$infoAusencia["Observacion"].'</p>
                      </div><!-- end content-->
                  </div><!--  end card  -->
              </div>

              <!-- FIN -->
        </div> <!-- end row -->
            ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
      break;
   case '13':
     //agregar o ver Permisos
     if(!empty($_POST["firstCell"])){
       if(isUserExist($_POST["firstCell"])){
         //ya sabemos que entro bien
         $empleado=getInfoUser($_POST["firstCell"]);
         $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
         $str='
           <div class="row">
            <h5 style="padding-left:10px;">Permisos-Empleado:</h5>
            <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
            <br>
           <div class="col-lg-10 col-lg-offset-1">
            <input type="hidden" name="NumeroDocumento" id="NumeroDocumento" value="'.$_POST["firstCell"].'">
              <div class="col-sm-1">
              </div>
            <div class="col-sm-4">
              <div class="choice" data-toggle="wizard-checkbox">
                 <button name="agregarPermiso" id="agregarPermiso"  style="background: transparent;border: none;">
                   <div class="icon">
                        <i class="material-icons">add</i>
                   </div>
                 <h6>Agregar</h6>
                 </button>
              </div>
            </div>
             <div class="col-sm-2">
             </div>
            <div class="col-sm-4">
              <div class="choice" data-toggle="wizard-checkbox">
                 <button id="verPermiso" name="verPermiso" style="background: transparent;border: none;">
                   <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                   </div>
                  </button>
                 <h6>Ver</h6>
              </div>
           </div>
            <div class="col-sm-1">
            </div>
          </div>
        </div>
         ';
         echo "0,".$str;//el html que vamos a enviar sin comas
       }else{
         echo "1,Envio un valor errado";
       }
     }else {
       echo "1,Envio un valor vacio";
     }
     break;
    case '14':
       # code...
       if(!empty($_POST["firstCell"])){
         if(isUserExist($_POST["firstCell"])){
           //ya sabemos que entro bien
           $empleado=getInfoUser($_POST["firstCell"]);
           $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
           $str="";
           $str='
             <div class="row">
               <div class="col-md-12">
                 <h5 style="padding-left:10px;">Permiso-Empleado:</h5>
                 <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
                 <br>
                 <form>
                   <div class="form-group col-md-4">
                     <label>Permiso por</label>
                     <br>
                     <select id="TPermiso" name="TPermiso" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                       <option selected value="1">Dia</option>
                       <option value="2">Hora</option>
                     </select>
                   </div>
                   <div class="form-group col-md-4" id="DfehaIni">
                     <label>Fecha Inicio</label>
                     <div class="input-group date" id="datetimepicker1">
                        <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaInicio" data-select="datepicker"/>
                     </div>
                   </div>
                   <div class="form-group col-md-4" id="DfechaFin">
                     <label>Fecha Fin</label>
                     <div class="input-group date" id="datetimepicker1">
                        <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaFin" data-select="datepicker"/>
                     </div>
                   </div>
                   <div class="form-group col-md-4" style="display: none;" id="Dfecha">
                     <label>Fecha</label>
                     <div class="input-group date" id="datetimepicker1">
                        <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="Fecha" data-select="datepicker"/>
                     </div>
                   </div>
                   <div class="form-group col-md-4" style="display: none;" id="DhoraIni">
                     <label>Hora Inicio</label>
                     <input type="text" id="hInicio" class="form-control" maxlength="5" size="5" placeholder="06:00">
                   </div>
                   <div class="form-group col-md-4" style="display: none;" id="DhoraFin">
                     <label>Hora Fin</label>
                     <input type="text" id="hFin" class="form-control" maxlength="5" size="5" placeholder="08:00">
                   </div>
                   <div class="form-group col-md-4">
                     <label>Observación</label>
                     <textarea id="Observacion" name="Observacion" class="form-control" required="true" rows="3"></textarea>
                     <span class="material-input"></span>
                   </div>

                   <div class="form-group col-md-4">
                     <input type="hidden" id="numDoc" name="numDoc" value="'.$_POST["firstCell"].'">
                     <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnAgregarPermiso" name="btnAgregarPermiso" value="Agregar" />
                   </div>
                 </form>
               </div>
             </div>
           ';
           echo "0,".$str;//el html que vamos a enviar sin comas
         }else{
           echo "1,Envio un valor errado";
         }
       }else {
         echo "1,Envio un valor vacio";
       }
       break;
  case '15':
  //verpermiso
      if(!empty($_POST["firstCell"])){
        if(isUserExist($_POST["firstCell"])){
          //ya sabemos que entro bien
          $empleado=getInfoUser($_POST["firstCell"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $NitEmpresa=$_SESSION['empresa'];//Empresa
          $str='
          <h5 style="padding-left:10px;">Permiso-Empleado:</h5>
          <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
          <br>
          <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Dias/Horas Inicio</th>
                          <th class="disabled-sorting text-right">Acciones</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Dias/Horas</th>
                          <th class="text-right">Acciones</th>
                      </tr>
                  </tfoot>

                  <tbody>
                  <!-- Desde aqui include Empleados_grid_table.php-->
          ';
          $cnx=cnx();
          $query=sprintf("SELECT permiso.*,EMP.PrimerNombre AS EMPN,EMP.SegundoNombre AS EMSN,EMP.PrimerApellido AS EMPA, EMP.SegundoApellido AS EMSP,EMPor.PrimerNombre,EMPor.SegundoNombre,EMPor.PrimerApellido,EMPor.SegundoApellido from permiso INNER JOIN empleado AS EMP INNER JOIN empleado AS EMPor WHERE permiso.NumeroDocumento='%s' AND permiso.NumeroDocumento=EMP.NumeroDocumento AND permiso.NumeroDocumentoPor=EMPor.NumeroDocumento",mysqli_real_escape_string($cnx,$_POST["firstCell"]));
          $result=mysqli_query($cnx,$query);
          while ($row=mysqli_fetch_array($result)) {
            $NombrePor=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
            if($row["TipoPermiso"]==1){
              //Dias
              $dates=$row["DiaInicio"]." ".$row["DiaFin"];
            }elseif($row["TipoPermiso"]==2) {
              //Horas
              $dates=$row["DiaInicio"].": ".$row["HoraInicio"]." ".$row["HoraFin"];
            }else{
              $dates="error";
            }
            //si ya esta revisado
            if($row["EstadoPermiso"]==0){
              $comp='<i class="material-icons">warning</i>';
              $setting='
              <button name="modificarPermiso" id="modificarPermiso"  style="background: transparent;border: none;">
               <div class="icon">
                    <i class="material-icons">build</i>
               </div>
              </button>
              ';
            }elseif ($row["EstadoPermiso"]==1) {
              $comp='<i class="material-icons">check_circle</i>';
              $setting='
                ';

            }else{
              $comp='<i class="material-icons">ERROR</i>';
              $setting='ERROR';
              $justificacion="ERROR";
            }


            $str=$str.'
              <tr data-id="'.$row["idPermiso"].'">
                 <td>'.$row["FechaCreacion"].'</td>
                 <td>'.$NombrePor.'</td>
                 <td>'.$dates.'</td>
                 <td class="text-right">
                   <div class="row">
                     <div class="col-md-12">
                      <input type="hidden" class="idPermiso" id="idPermiso" name="idPermiso" value="'.$row["idPermiso"].'">
                      <div class="col-md-6">
                        <button name="verificarPermiso" id="verificarPermiso"  style="background: transparent;border: none;">
                         <div class="icon">
                              '.$comp.'
                         </div>
                       </button>
                      </div>
                      <div class="col-md-6">
                        '.$setting.'
                     </div>
                    </div>
                   </div>
                 </td>
              </tr>
            ';

          }
          mysqli_close($cnx);
          $str=$str.'
                    </tbody>
                </table>
            </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
    break;
    case '16':
    if(!empty($_POST["idPermiso"])){
      if(isPermisoExist($_POST["idPermiso"])){
        //ya sabemos que entro bien
        $permiso=getPermiso($_POST["idPermiso"]);
        if($permiso["exist"]==1){
          $empleado=getInfoUser($permiso["NumeroDocumento"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $str="";
          $TipoPermiso="ERROR";
          if($permiso["TipoPermiso"]==1){
            $DiaInicio = new DateTime($permiso["DiaInicio"]); //$DiaInicio->format('d/m/Y')
            $DiaFin = new DateTime($permiso["DiaFin"]); //$DiaFin->format('d/m/Y')
            $TipoPermiso='
              <div class="form-group col-md-4">
                <label>Permiso por</label>
                <br>
                <select id="TPermiso" name="TPermiso" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                  <option selected value="1">Dia</option>
                  <option value="2">Hora</option>
                </select>
              </div>
              <div class="form-group col-md-4" id="DfehaIni">
                <label>Fecha Inicio</label>
                <div class="input-group date" id="datetimepicker1">
                   <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaInicio" value="'.$DiaInicio->format('d/m/Y').'" data-select="datepicker"/>
                </div>
              </div>
              <div class="form-group col-md-4" id="DfechaFin">
                <label>Fecha Fin</label>
                <div class="input-group date" id="datetimepicker1">
                   <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaFin" value="'.$DiaFin->format('d/m/Y').'" data-select="datepicker"/>
                </div>
              </div>
              <div class="form-group col-md-4" style="display: none;" id="Dfecha">
                <label>Fecha</label>
                <div class="input-group date" id="datetimepicker1">
                   <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="Fecha" data-select="datepicker"/>
                </div>
              </div>
              <div class="form-group col-md-4" style="display: none;" id="DhoraIni">
                <label>Hora Inicio</label>
                <input type="text" id="hInicio" class="form-control" maxlength="5" size="5" placeholder="06:00">
              </div>
              <div class="form-group col-md-4" style="display: none;" id="DhoraFin">
                <label>Hora Fin</label>
                <input type="text" id="hFin" class="form-control" maxlength="5" size="5" placeholder="08:00">
              </div>
            ';
          }elseif ($permiso["TipoPermiso"]==2) {
            $DiaInicio = new DateTime($permiso["DiaInicio"]); //$DiaInicio->format('d/m/Y')

            $HoraIni=$permiso["HoraInicio"];
            $HoraIni=explode(":",$HoraIni);
            $HoraIni=$HoraIni[0].":".$HoraIni[1];

            $HoraFin=$permiso["HoraFin"];
            $HoraFin=explode(":",$HoraFin);
            $HoraFin=$HoraFin[0].":".$HoraFin[1];
            $TipoPermiso='
              <div class="form-group col-md-4">
                <label>Permiso por</label>
                <br>
                <select id="TPermiso" name="TPermiso" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                  <option value="1">Dia</option>
                  <option selected value="2">Hora</option>
                </select>
              </div>
              <div class="form-group col-md-4" style="display: none;" id="DfehaIni">
                <label>Fecha Inicio</label>
                <div class="input-group date" id="datetimepicker1">
                   <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaInicio" data-select="datepicker"/>
                </div>
              </div>
              <div class="form-group col-md-4" style="display: none;" id="DfechaFin">
                <label>Fecha Fin</label>
                <div class="input-group date" id="datetimepicker1">
                   <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaFin" data-select="datepicker"/>
                </div>
              </div>
              <div class="form-group col-md-4"  id="Dfecha">
                <label>Fecha</label>
                <div class="input-group date" id="datetimepicker1">
                   <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="Fecha" value="'.$DiaInicio->format('d/m/Y').'" data-select="datepicker"/>
                </div>
              </div>
              <div class="form-group col-md-4"  id="DhoraIni">
                <label>Hora Inicio</label>
                <input type="text" id="hInicio" class="form-control" maxlength="5" size="5" value="'.$HoraIni.'" placeholder="06:00">
              </div>
              <div class="form-group col-md-4"  id="DhoraFin">
                <label>Hora Fin</label>
                <input type="text" id="hFin" class="form-control" maxlength="5" size="5" value="'.$HoraFin.'" placeholder="08:00">
              </div>
            ';

          }
          $botones="";
          if (strcmp($TipoPermiso,"ERROR")!=0){
              $botones='
              <div class="form-group col-md-4">
                <label>Observación</label>
                <textarea id="Observacion" name="Observacion" class="form-control" required="true" rows="3">'.$permiso["Observacion"].'</textarea>
                <span class="material-input"></span>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-md-2">
                  <input type="hidden" id="idPermiso" name="idPermiso" value="'.$_POST["idPermiso"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnModificarPermiso" name="btnModificarPermiso" value="Modificar" />
                </div>
                <div class="form-group col-md-2">
                  <input type="hidden" id="idPermiso" name="idPermiso" value="'.$_POST["idPermiso"].'">
                  <input type="button"  class="btn btn-previous btn-fill btn-danger btn-wd" id="btnEliminarPermiso" name="btnEliminarPermiso" value="Eliminar" />
                </div>
              </div>
            ';
          }
          $str='
            <div class="row">
              <div class="col-md-12">
                <h5 style="padding-left:10px;">Permiso-Empleado:</h5>
                <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
                <br>
                <form>
                  '.$TipoPermiso.'
                  '.$botones.'
                </form>
              </div>
            </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else {
          echo "1,No se encontro permiso recargue la pagina";
        }

      }else{
        echo "1,Envio un valor errado";
      }
    }else {
      echo "1,Envio un valor vacio";
    }
    break;
  case '17':
      if(!empty($_POST["idPermiso"])){
        $str="";
        if(isPermisoExist($_POST["idPermiso"])){
          //ya sabemos que entro bien
          $infoPermiso=getPermiso($_POST["idPermiso"]);
          if ($infoPermiso["EstadoPermiso"]==0) {
            $buttonConfi='
            <div class="form-group col-md-4">
              <input type="hidden" id="idPermiso" name="idPermiso" value="'.$_POST["idPermiso"].'">
              <input type="button"  class="btn btn-previous btn-fill btn-danger btn-wd" id="btnConfirmarPermiso" name="btnConfirmarPermiso" value="Confirmar" />
            </div>
            ';
          }elseif ($infoPermiso["EstadoPermiso"]==1) {
            $buttonConfi="";
          }else{
            $buttonConfi="Error";
          }

          if($infoPermiso["TipoPermiso"]==1){
            //Solo fechas
            $tipPermiso='
              <h4>Fecha de Inicio</h4>
              <p style="padding-left:15px"> '.$infoPermiso["DiaInicio"].'</p>
              <h4>Fecha de Fin</h4>
              <p style="padding-left:15px"> '.$infoPermiso["DiaFin"].'</p>
            ';
          }elseif ($infoPermiso["TipoPermiso"]==2) {
            //horas
            $tipPermiso='
              <h4>Fecha</h4>
              <p style="padding-left:15px"> '.$infoPermiso["DiaInicio"].'</p>
              <h4>Hora de Inicio</h4>
              <p style="padding-left:15px"> '.$infoPermiso["HoraInicio"].'</p>
              <h4>Hora de Fin</h4>
              <p style="padding-left:15px"> '.$infoPermiso["HoraFin"].'</p>
            ';
          }else{
            $tipoIN='ERROR recargue la pagina';
          }
            $empleado=getInfoUser($infoPermiso["NumeroDocumento"]);
            $empleadoPor=getInfoUser($infoPermiso["NumeroDocumentoPor"]);
            $str=$str.'
              <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">card_travel</i>
                    </div>
                    <div class="card-content">
                      <h3 class="card-title">Reporte Permiso</h3>
                      <div class="toolbar">
                      </div>
                      '.$tipPermiso.'
                      <h4>Observacion</h4>
                      <p style="padding-left:15px"> '.$infoPermiso["Observacion"].'</p>
                      '.$buttonConfi.'
                      </div><!-- end content-->
                  </div><!--  end card  -->
              </div>
              <div class="col-md-6">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="purple">
                        <i class="material-icons">card_travel</i>
                    </div>
                    <div class="card-content">
                      <h3 class="card-title">Reporte </h3>
                      <div class="toolbar">
                      </div>
                      <h4>Empleado: </h4>
                      <p style="padding-left:15px"> '.$empleado->getPrimernombre().' '.$empleado->getSegundonombre().' '.$empleado->getPrimerapellido().' '.$empleado->getSegundoapellido().'</p>
                      <h4>Realizado por:</h4>
                      <p style="padding-left:15px"> '.$empleadoPor->getPrimernombre().' '.$empleadoPor->getSegundonombre().' '.$empleadoPor->getPrimerapellido().' '.$empleadoPor->getSegundoapellido().'</p>
                      </div><!-- end content-->
                  </div><!--  end card  -->
              </div>

              <!-- FIN -->
        </div> <!-- end row -->
            ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
      break;
  case '18':
      if(!empty($_POST["NumeroDocumento"])){
        if(isUserExist($_POST["NumeroDocumento"])){
          $cnx=cnx();
          $query=sprintf("SELECT * FROM htrabajo where NumeroDocumento='%s'",mysqli_real_escape_string($cnx,$_POST["NumeroDocumento"]));
      		$resul=mysqli_query($cnx,$query);
      		$row=mysqli_fetch_array($resul);
          $Desde=$row["Desde"];
          $Desde=explode(":",$Desde);
          $Desde=$Desde[0].":".$Desde[1];
          echo "1,".$Desde;
          mysqli_close($cnx);
        }else {
          echo "0,";
        }
      }else {
        echo "0,";
      }
    break;
  case '19':
      if(!empty($_POST["NumeroDocumento"])){
        if(isLlegadasTardeExist($_POST["idReporteLlegadasTarde"])){
          $cnx=cnx();
          $query = sprintf("UPDATE llegadas_tarde SET  EstadoLlegadasTarde = '%s' WHERE idLlegadasTarde = '%s'",
    			mysqli_real_escape_string($cnx,"1"),
    			mysqli_real_escape_string($cnx,$_POST["idReporteLlegadasTarde"])
    			);
    			$estado = mysqli_query($cnx,$query);
          if($estado){
            echo "1,";
          }else {
            echo "0,";
          }
          mysqli_close($cnx);
        }
      }
      break;
      case '20':
        # code...
        if(!empty($_POST["firstCell"])){
          if(isUserExist($_POST["firstCell"])){
            //ya sabemos que entro bien
            $empleado=getInfoUser($_POST["firstCell"]);
            $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
            $str='
              <div class="row">
               <h5 style="padding-left:10px;">Empleado:</h5>
               <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
               <br>
            	 <div class="col-lg-10 col-lg-offset-1">
               <input type="hidden" name="NumeroDocumento" id="NumeroDocumento" value="'.$_POST["firstCell"].'">
                 <div class="col-sm-1">
                 </div>
            	  <div class="col-sm-4">
            		  <div class="choice" data-toggle="wizard-checkbox">
            			   <button name="agregarPermisoSeccional" id="agregarPermisoSeccional"  style="background: transparent;border: none;">
              				 <div class="icon">
                           <i class="material-icons">add</i>
              				 </div>
            				 <h6>Agregar</h6>
                    </button>
            			</div>
            		</div>
                <div class="col-sm-2">
                </div>
            		<div class="col-sm-4">
            		  <div class="choice" data-toggle="wizard-checkbox">
            			   <button id="verPermisoSeccional" name="verPermisoSeccional" style="background: transparent;border: none;">
              				 <div class="icon">
                           <i class="material-icons">playlist_add_check</i>
              				 </div>
                     </button>
            			   <h6>Ver</h6>
            			</div>
            	 </div>
               <div class="col-sm-1">
               </div>
             </div>
           </div>
            ';
            echo "0,".$str;//el html que vamos a enviar sin comas
          }else{
            echo "1,Envio un valor errado";
          }
        }else {
          echo "1,Envio un valor vacio";
        }
        break;
        case '21':
           # code...
           if(!empty($_POST["firstCell"])){
             if(isUserExist($_POST["firstCell"])){
               //ya sabemos que entro bien
               $empleado=getInfoUser($_POST["firstCell"]);
               $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
               $str="";
               $str='
                 <div class="row">
                   <div class="col-md-12">
                     <h5 style="padding-left:10px;">Permiso-Seccional-Empleado:</h5>
                     <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
                     <br>
                     <form>
                       <div class="form-group col-md-4">
                         <label>Permiso Seccional</label>
                         <br>
                         <select id="TPermiso" name="TPermiso" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                           <option selected value="1">Dia completo</option>
                           <option value="2">Parcial</option>
                         </select>
                       </div>
                       <div class="form-group col-md-3" id="DfehaIni">
                         <label>Fecha</label>
                         <div class="input-group date" id="datetimepicker1">
                            <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaInicio" data-select="datepicker"/>
                         </div>
                       </div>
                       <div class="form-group col-md-4" style="display: none;" id="Dfecha">
                         <label>Fecha</label>
                         <div class="input-group date" id="datetimepicker1">
                            <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="Fecha" data-select="datepicker"/>
                         </div>
                       </div>
                       <div class="form-group col-md-4" style="display: none;" id="DhoraIni">
                         <label>Hora Inicio</label>
                         <input type="text" id="hInicio" class="form-control" maxlength="5" size="5" placeholder="06:00">
                       </div>
                       <div class="form-group col-md-4" style="display: none;" id="DhoraFin">
                         <label>Hora Fin</label>
                         <input type="text" id="hFin" class="form-control" maxlength="5" size="5" placeholder="08:00">
                       </div>
                       <div class="form-group col-md-4">
                         <label>Observación</label>
                         <textarea id="Observacion" name="Observacion" class="form-control" required="true" rows="3"></textarea>
                         <span class="material-input"></span>
                       </div>
                       <div class="form-group col-md-4">
                         <input type="hidden" id="numDoc" name="numDoc" value="'.$_POST["firstCell"].'">
                         <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnAgregarPermisoSeccional" name="btnAgregarPermisoSeccional" value="Agregar" />
                       </div>
                     </form>
                   </div>
                 </div>
               ';
               /*
               <div class="form-group col-md-4">
                 <input type="hidden" id="numDoc" name="numDoc" value="'.$_POST["firstCell"].'">
                 <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnAgregarPermiso" name="btnAgregarPermiso" value="Agregar" />
               </div>
               */
               echo "0,".$str;//el html que vamos a enviar sin comas
             }else{
               echo "1,Envio un valor errado";
             }
           }else {
             echo "1,Envio un valor vacio";
           }
           break;
  case '22':
  //ver Permiso Seccional
      if(!empty($_POST["firstCell"])){
        if(isUserExist($_POST["firstCell"])){
          //ya sabemos que entro bien
          $empleado=getInfoUser($_POST["firstCell"]);
          $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
          $NitEmpresa=$_SESSION['empresa'];//Empresa
          $str='
          <h5 style="padding-left:10px;">Permiso-Seccional-Empleado:</h5>
          <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
          <br>
          <div class="material-datatables">
              <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Dias/Horas Inicio</th>
                          <th class="disabled-sorting text-right">Acciones</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Fecha Elaborado</th>
                          <th>Elaborado Por</th>
                          <th>Dias/Horas</th>
                          <th class="text-right">Acciones</th>
                      </tr>
                  </tfoot>

                  <tbody>
                  <!-- Desde aqui include Empleados_grid_table.php-->
          ';
          $cnx=cnx();
          $query=sprintf("SELECT permiso_seccional.*,EMPor.PrimerNombre,EMPor.SegundoNombre,EMPor.PrimerApellido,EMPor.SegundoApellido from permiso_seccional INNER JOIN empleado AS EMPor WHERE permiso_seccional.NumeroDocumento='%s' AND permiso_seccional.NumeroDocumentoPor=EMPor.NumeroDocumento ORDER BY permiso_seccional.FechaCreacion DESC ",mysqli_real_escape_string($cnx,$_POST["firstCell"]));
          $result=mysqli_query($cnx,$query);
          while ($row=mysqli_fetch_array($result)) {
            $NombrePor=$row["PrimerNombre"]." ".$row["SegundoNombre"]." ".$row["PrimerApellido"]." ".$row["SegundoApellido"];
            if($row["TipoPermisoSeccional"]==1){
              //Dias completo
              $dates=$row["Dia"];
            }elseif($row["TipoPermisoSeccional"]==2) {
              //Horas
              $dates=$row["Dia"].": ".$row["HoraInicio"]." ".$row["HoraFin"];
            }else{
              $dates="error";
            }
            //si ya esta revisado
            if($row["EstadoPermisoSeccional"]==0){
              $comp='<i class="material-icons">warning</i>';
              $setting='
              <button name="modificarPermisoSeccional" id="modificarPermisoSeccional"  style="background: transparent;border: none;">
               <div class="icon">
                    <i class="material-icons">build</i>
               </div>
              </button>
              ';
            }elseif ($row["EstadoPermisoSeccional"]==1) {
              $comp='<i class="material-icons">check_circle</i>';
              $setting='
                ';

            }else{
              $comp='<i class="material-icons">ERROR</i>';
              $setting='ERROR';
              $justificacion="ERROR";
            }


            $str=$str.'
              <tr data-id="'.$row["idPermisoSeccional"].'">
                 <td>'.$row["FechaCreacion"].'</td>
                 <td>'.$NombrePor.'</td>
                 <td>'.$dates.'</td>
                 <td class="text-right">
                   <div class="row">
                     <div class="col-md-12">
                      <input type="hidden" class="idPermisoSeccional" id="idPermisoSeccional" name="idPermisoSeccional" value="'.$row["idPermisoSeccional"].'">
                      <div class="col-md-6">
                        <button name="verificarPermisoSeccional" id="verificarPermisoSeccional"  style="background: transparent;border: none;">
                         <div class="icon">
                              '.$comp.'
                         </div>
                       </button>
                      </div>
                      <div class="col-md-6">
                        '.$setting.'
                     </div>
                    </div>
                   </div>
                 </td>
              </tr>
            ';

          }
          mysqli_close($cnx);
          $str=$str.'
                    </tbody>
                </table>
            </div>
          ';
          echo "0,".$str;//el html que vamos a enviar sin comas
        }else{
          echo "1,Envio un valor errado";
        }
      }else {
        echo "1,Envio un valor vacio";
      }
    break;
    case '23':
        if(!empty($_POST["idPermisoSeccional"])){
          if(isPermisoSeccionalExist($_POST["idPermisoSeccional"])){
            //ya sabemos que entro bien
            $permiso=getPermisoSeccional($_POST["idPermisoSeccional"]);
            if($permiso["exist"]==1){
              $empleado=getInfoUser($permiso["NumeroDocumento"]);
              $NombreEmpleado=" ".$empleado->getPrimernombre()." ".$empleado->getSegundonombre()." ".$empleado->getPrimerapellido()." ".$empleado->getSegundoapellido();
              $str="";
              $TipoPermiso="ERROR";
              if($permiso["TipoPermisoSeccional"]==1){
                $DiaInicio = new DateTime($permiso["Dia"]); //$DiaInicio->format('d/m/Y')
                $TipoPermiso='
                  <div class="form-group col-md-4">
                    <label>Permiso Seccional </label>
                    <br>
                    <select id="TPermiso" name="TPermiso" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                           <option selected value="1">Dia completo</option>
                           <option value="2">Parcial</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3" id="DfehaIni">
                         <label>Fecha</label>
                         <div class="input-group date" id="datetimepicker1">
                            <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' value="'.$DiaInicio->format('d/m/Y').'" name="date" id="FechaInicio" data-select="datepicker"/>
                         </div>
                  </div>
                  <div class="form-group col-md-4" style="display: none;" id="Dfecha">
                         <label>Fecha</label>
                         <div class="input-group date" id="datetimepicker1">
                            <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="Fecha" data-select="datepicker"/>
                         </div>
                  </div>
                  <div class="form-group col-md-4" style="display: none;" id="DhoraIni">
                         <label>Hora Inicio</label>
                         <input type="text" id="hInicio" class="form-control" maxlength="5" size="5" placeholder="06:00">
                  </div>
                  <div class="form-group col-md-4" style="display: none;" id="DhoraFin">
                         <label>Hora Fin</label>
                         <input type="text" id="hFin" class="form-control" maxlength="5" size="5" placeholder="08:00">
                  </div>
                ';
              }elseif ($permiso["TipoPermisoSeccional"]==2) {
                $DiaInicio = new DateTime($permiso["Dia"]); //$DiaInicio->format('d/m/Y')

                $HoraIni=$permiso["HoraInicio"];
                $HoraIni=explode(":",$HoraIni);
                $HoraIni=$HoraIni[0].":".$HoraIni[1];

                $HoraFin=$permiso["HoraFin"];
                $HoraFin=explode(":",$HoraFin);
                $HoraFin=$HoraFin[0].":".$HoraFin[1];
                $TipoPermiso='
                <div class="form-group col-md-4">
                  <label>Permiso Seccional </label>
                  <br>
                  <select id="TPermiso" name="TPermiso" class="form-control selectpicker" data-title="Seleccione una Opcion" data-style="btn-default btn-block" data-menu-style="dropdown-blue" required>
                         <option value="1">Dia completo</option>
                         <option selected value="2">Parcial</option>
                  </select>
                </div>
                <div class="form-group col-md-3" style="display: none;" style="display: none;" id="DfehaIni">
                       <label>Fecha</label>
                       <div class="input-group date" id="datetimepicker1">
                          <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="FechaInicio" data-select="datepicker"/>
                       </div>
                </div>
                <div class="form-group col-md-4"  id="Dfecha">
                       <label>Fecha</label>
                       <div class="input-group date" id="datetimepicker1">
                          <input style="width:100%;" type="text" class="form-control" placeholder='.date('d').'/'.date('m').'/'.date('Y').' name="date" id="Fecha" value="'.$DiaInicio->format('d/m/Y').'" data-select="datepicker"/>
                       </div>
                </div>
                <div class="form-group col-md-4"  id="DhoraIni">
                       <label>Hora Inicio</label>
                       <input type="text" id="hInicio" class="form-control" maxlength="5" value="'.$HoraIni.'" size="5" placeholder="06:00">
                </div>
                <div class="form-group col-md-4"  id="DhoraFin">
                       <label>Hora Fin</label>
                       <input type="text" id="hFin" class="form-control" maxlength="5" value="'.$HoraFin.'" size="5" placeholder="08:00">
                </div>
                ';

              }
              $botones="";
              if (strcmp($TipoPermiso,"ERROR")!=0){
                  $botones='
                  <div class="form-group col-md-4">
                    <label>Observación</label>
                    <textarea id="Observacion" name="Observacion" class="form-control" required="true" rows="3">'.$permiso["Observacion"].'</textarea>
                    <span class="material-input"></span>
                  </div>
                  <br>
                  <div class="row">
                    <div class="form-group col-md-2">
                      <input type="hidden" id="idPermisoSeccional" name="idPermisoSeccional" value="'.$_POST["idPermisoSeccional"].'">
                      <input type="button"  class="btn btn-previous btn-fill btn-primary btn-wd" id="btnModificarPermisoSeccional" name="btnModificarPermisoSeccional" value="Modificar" />
                    </div>
                    <div class="form-group col-md-2">
                      <input type="hidden" id="idPermisoSeccional" name="idPermisoSeccional" value="'.$_POST["idPermisoSeccional"].'">
                      <input type="button"  class="btn btn-previous btn-fill btn-danger btn-wd" id="btnEliminarPermisoSeccional" name="btnEliminarPermisoSeccional" value="Eliminar" />
                    </div>
                  </div>
                ';
              }
              $str='
                <div class="row">
                  <div class="col-md-12">
                    <h5 style="padding-left:10px;">Permiso-Seccional-Empleado:</h5>
                    <h6 style="padding-left:15px;">'.$NombreEmpleado.'</h6>
                    <br>
                    <form>
                      '.$TipoPermiso.'
                      '.$botones.'
                    </form>
                  </div>
                </div>
              ';
              echo "0,".$str;//el html que vamos a enviar sin comas
            }else {
              echo "1,No se encontro el permiso seccional recargue la pagina";
            }

          }else{
            echo "1,Envio un valor errado";
          }
        }else {
          echo "1,Envio un valor vacio";
        }
  break;

  case '24':
    if(!empty($_POST["idPermisoSeccional"])){
      if(isPermisoSeccionalExist($_POST["idPermisoSeccional"])){
        //ya sabemos que entro bien
        $infoPermisoSeccional=getPermisoSeccional($_POST["idPermisoSeccional"]);
        $str='
        <div class="row">
          <div class="col-md-6">
              <div class="card">
                  <div class="card-header card-header-icon" data-background-color="purple">
                      <i class="material-icons">contacts</i>
                  </div>
                  <div class="card-content">
                      <h4 class="card-title">Unicamente Imagen o PDF</h4>
                      <div class="toolbar">
                          <!--        Here you can write extra buttons/actions for the toolbar              -->
                      </div>
                      <div class="row">


        ';
        if($infoPermisoSeccional["EstadoPermisoSeccional"]==0){
          $str=$str.'
            <form action="upload.php" method="post" enctype="multipart/form-data">
              <p>
                <input type="hidden" id="idupload" name="idupload" value="4%'.$_POST["idPermisoSeccional"].'">
                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                <div class="col-md-6">
                  <label class="btn btn-block btn-primary">
                  Cargar Archivo&hellip; <input id="uploadPDF" name="myFile" type="file" style="display: none;">
                  </label>
                </div>
                <div class="col-md-6">
                  <label style="display:none;" id="labelBtnCargar" class="btn btn-block btn-primary">
                    Subir<input disabled id="btnCargar" value="Upload" type="submit" style="display: none;" />
                  </label>
                </div>
              </p>
            </form>
          ';
        }elseif ($infoPermisoSeccional["EstadoPermisoSeccional"]==1) {
          # code...
          $getFile=getFilePermisoSeccional($_POST["idPermisoSeccional"]);
          $Documento="../upload/Permiso_Seccional/".$getFile[1];
          if($getFile[0]=="pdf"){
            $str=$str."
            <iframe src='".$Documento."' style='width:100%;height:600px;' frameborder='0'></iframe>
            ";
          }else{
            $str=$str.'
            <img src="'.$Documento.'"  style="width="100%";height:600;">';
          }
        };
        if($infoPermisoSeccional["TipoPermisoSeccional"]==1){
          //ISS
          $tipoIN='
          <h4>Dia</h4>
          <p style="padding-left:15px">'.$infoPermisoSeccional["Dia"].'</p>
          ';
        }elseif ($infoPermisoSeccional["TipoPermisoSeccional"]==2) {
          //CLINICA
          $tipoIN='
          <h4>Dia</h4>
          <p style="padding-left:15px">'.$infoPermisoSeccional["Dia"].'</p>
          <h4>Horas</h4>
          <p style="padding-left:15px">Desde:'.$infoPermisoSeccional["HoraInicio"].' Hasta:'.$infoPermisoSeccional["HoraFin"].'</p>
          ';
        }else{
          $tipoIN='ERROR recargue la pagina';
        }
          $str=$str.'
                   </div>

                  </div><!-- end content-->
               </div><!--  end card  -->
            </div> <!-- end col-md-6 -->

            <div class="col-md-6">
              <div class="card">
                  <div class="card-header card-header-icon" data-background-color="purple">
                      <i class="material-icons">card_travel</i>
                  </div>
                  <div class="card-content">
                    <h3 class="card-title">Reporte Permiso Seccional</h3>
                    <div class="toolbar">
                    </div>
                    <h4>Fecha de Creacion</h4>
                    <p style="padding-left:15px"> '.$infoPermisoSeccional["FechaCreacion"].'</p>
                    '.$tipoIN.'
                    <h4>Observacion</h4>
                    <p style="padding-left:15px"> '.$infoPermisoSeccional["Observacion"].'</p>
                    </div><!-- end content-->
                </div><!--  end card  -->
            </div>

            <!-- FIN -->
      </div> <!-- end row -->
          ';
        echo "0,".$str;//el html que vamos a enviar sin comas
      }else{
        echo "1,Envio un valor errado";
      }
    }else {
      echo "1,Envio un valor vacio";
    }
    break;

  default:

    break;
}
 ?>

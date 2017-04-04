$(document).ready(function() {

    //Agregar una suspension

    //confirmar Reporte llegadas tarde
    $("#btnConfirmarReporteLlegadasTarde").click(function(){
      var idReporteLlegadasTarde = document.getElementById("idLlegadasTarde").value;
      swal({
        title: 'Desea Confirmar',
        text: "Ya no se podra editar!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, confirmar',
        cancelButtonText: 'No, cancelar!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $.ajax({
          url: '../php/Insert_Ajax.php',
          type: 'POST',
          data: {
            opcAjax:19,
            idReporteLlegadasTarde:idReporteLlegadasTarde
          },
          beforeSend: function(){
            respAlert("info","Comprobando..")
          },
          success: function(data){
            data = data.split(",");
            switch (data[0]) {
              case '0':
                respAlert("danger","No se pudo conectar con la base de datos");
                break;
              case '1':
                setTimeout(function() {
                    respAlert("success", "Comprobado correctamente, redireccionando..");
                    redireccionar("Reporte_Llegadas_Tarde.php");
                }, 2000);
                break;
              default:

            }
          }

        });
      }, function (dismiss) {
        // dismiss can be 'cancel', 'overlay',
        // 'close', and 'timer'
        if (dismiss === 'cancel') {
          swal(
            'Cancelado',
            '',
            'error'
          )
        }
      })


    });
    //Modifinr turno
    $("#btnMTruno").click(function() {
        var idTurno = document.getElementById("idTurno").value;
        var nombreTurno = document.getElementById("Njornada").value;
        var Desde = document.getElementById("desde").value;
        var Hasta = document.getElementById("hasta").value;
        var Periodo_Pago = $("#PPago").val();
        var MJornada= $("#MJornada").val();
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/verificar_TurnoM.php',
            type: 'POST',
            data: {
                idTurno: idTurno,
                nombreTurno: nombreTurno,
                Desde: Desde,
                Hasta: Hasta,
                Periodo_Pago: Periodo_Pago,
                MJornada: MJornada
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                switch (data[0]) {
                    case "0":
                        setTimeout(function() {
                            respAlert("warning", "Error en ID: " + idTurno);
                            redireccionar("../index.php");
                        }, 1000);
                        break;
                    case "1":
                        respAlert("warning", "Llene todo los campos y revice que el tiempo Desde sea menor que el Hasta");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("turno.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
                        break;
                    case "4":
                            respAlert("warning", "El formato de tiempo es 00:00 a 23:59");
                            break;
                    case "5":
                        respAlert("warning", "Coloque un Periodo de Pago valido");
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
    });
    //Modificar Empresa btnMEmpresa
    $("#btnMEmpresa").click(function() {
        var NombreEmpresa = document.getElementById("NombreEmpresa").value;
        var Direccion = document.getElementById("Direccion").value;
        var Telefono = document.getElementById("Telefono").value;
        var Telefono2 = document.getElementById("Telefono2").value;
        var NRegistro = document.getElementById("NRegistro").value;
        var Giro = document.getElementById("Giro").value;
        var NPatronalSS = document.getElementById("NPatronalSS").value;
        var NPatronalAFP = document.getElementById("NPatronalAFP").value;
        var RepresentanteLegal = document.getElementById("RepresentanteLegal").value;
        var NitEmpresa = document.getElementById("NitEmpresa").value;
        var TipeRequest = document.getElementById("TipeRequest").value;
        if (TipeRequest == 1) {
            var TipoEmpresa = $("#TipoEmpresa").val();
        } else var TipoEmpresa = 1;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Modificar.php',
            type: 'POST',
            data: {
                opc: 3,
                NombreEmpresa: NombreEmpresa,
                Direccion: Direccion,
                Telefono: Telefono,
                Telefono2: Telefono2,
                NRegistro: NRegistro,
                Giro: Giro,
                NPatronalSS: NPatronalSS,
                NPatronalAFP: NPatronalAFP,
                RepresentanteLegal: RepresentanteLegal,
                NitEmpresa: NitEmpresa,
                TipeRequest: TipeRequest,
                TipoEmpresa: TipoEmpresa
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Llene todo los campos");
                        break;
                    case "1":
                        respAlert("warning", "Ya Existe una Empresa con el mismo nombre");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("menu.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
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
    });
    //Modificar Departamento btnMDepartamento
    $("#btnMDepartamento").click(function() {
        var NombreDepartamento = document.getElementById("NombreDepartamento").value;
        var CuentaContable = document.getElementById("CContable").value;
        var idSalario_Minimo = $("#idSalario_Minimo").val();
        var NitEmpresa = document.getElementById("nitEmpresa").value;
        var idDepartamento = document.getElementById("idDepartamento").value;
        var idCod_Municipio = document.getElementById("C_municipio").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Modificar.php',
            type: 'POST',
            data: {
                opc: 1,
                NombreDepartamento: NombreDepartamento,
                CuentaContable: CuentaContable,
                idSalario_Minimo: idSalario_Minimo,
                NitEmpresa: NitEmpresa,
                idCod_Municipio: idCod_Municipio,
                idDepartamento: idDepartamento
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Llene todo los campos");
                        break;
                    case "1":
                        respAlert("warning", "Ya Existe un Departamento con el mismo nombre");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("departamento.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
                        break;
                    case "4":
                        respAlert("warning", "Coloque un Municipio");
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
    });
    //Eliminar Departamento btnEliminarDepartamento
    $("#btnEliminarDepartamento").click(function() {
        var idDepartamento = document.getElementById("idDepartamento").value;
        var NitEmpresa = document.getElementById("nitEmpresa").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc: 2,
                idDepartamento: idDepartamento,
                NitEmpresa: NitEmpresa
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en base de datos");
                        break;
                    case "1":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("departamento.php");
                        }, 1000);
                        break;
                    case "2":
                        respAlert("warning", "Existe un Cargo en este Departamento, imposible eliminar");
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
    });
    //Agregar Empresa btnAEmpresa
    $("#btnAEmpresa").click(function() {
        var NitEmpresa = document.getElementById("NitEmpresa").value;
        var NombreEmpresa = document.getElementById("NombreEmpresa").value;
        var ActivaBloqueada = $("#ActivaBloqueada").val();
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../sistema/agregar.php',
            type: 'POST',
            data: {
                opc: 8,
                NitEmpresa: NitEmpresa,
                NombreEmpresa: NombreEmpresa,
                ActivaBloqueada: ActivaBloqueada
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Llene todo los campos");
                        break;
                    case "1":
                        respAlert("warning", "Ya Existe un Departamento con el mismo nombre");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("departamento.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
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
    });

    //Agregar Departamento btnADepartamento
    $("#btnADepartamento").click(function() {
        var NombreDepartamento = document.getElementById("NDepartamento").value;
        var CuentaContable = document.getElementById("CContable").value;
        var idSalario_Minimo = $("#idSalario_Minimo").val();
        var idCod_Municipio	 = $("#C_municipio").val();
        var NitEmpresa = document.getElementById("nitEmpresa").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../sistema/agregar.php',
            type: 'POST',
            data: {
                opc: 6,
                NombreDepartamento: NombreDepartamento,
                CuentaContable: CuentaContable,
                idSalario_Minimo: idSalario_Minimo,
                idCod_Municipio: idCod_Municipio,
                NitEmpresa: NitEmpresa
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Llene todo los campos");
                        break;
                    case "1":
                        respAlert("warning", "Ya Existe un Departamento con el mismo nombre");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("departamento.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
                        break;
                    case "4":
                        respAlert("warning", "Seleccione un Municipio valido");
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
    });

    //Agregar Cargo
    $("#btnACargo").click(function() {
        var NombreCargo = document.getElementById("NombreCargo").value;
        var Descripcion = document.getElementById("Descripcion").value;
        var idDepartamento = $("#idDepartamento").val();
        var PEmpleado = document.getElementById("PEmpleado").checked;
        var PPlanilla = document.getElementById("PPlanilla").checked;
        if (PPlanilla) {
            PPlanilla = 1;
        } else PPlanilla = 0;
        if (PEmpleado) {
            PEmpleado = 1;
        } else PEmpleado = 0; //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../sistema/agregar.php',
            type: 'POST',
            data: {
                opc: 7,
                NombreCargo: NombreCargo,
                Descripcion: Descripcion,
                idDepartamento: idDepartamento,
                PEmpleado: PEmpleado,
                PPlanilla: PPlanilla
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Llene el campo Nombre");
                        break;
                    case "1":
                        respAlert("warning", "Ya Existe un Cargo en el departamento con el mismo nombre");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("cargos.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
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
    });

    //Modificar Permiso btnModificarPermiso
    $("#btnModificarPermiso").click(function() {
      var idPermiso = document.getElementById("idPermiso").value;
      var TipoPermiso = $("#TPermiso").val();
      if(TipoPermiso==1){
        var DiaInicio =document.getElementById("FechaInicio").value;
        var DiaFin = document.getElementById("FechaFin").value;
        var HoraInicio = "00:00";
        var HoraFin = "00:00";
      }else if (TipoPermiso==2) {
        var DiaInicio = document.getElementById("Fecha").value;
        var DiaFin = "2017-04-19";
        var HoraInicio = document.getElementById("hInicio").value;
        var HoraFin = document.getElementById("hFin").value;
      }
      var Observacion= document.getElementById("Observacion").value;
      var opc=6;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Modificar.php',
            type: 'POST',
            data: {
              opc: 6,
              idPermiso: idPermiso,
              TipoPermiso: TipoPermiso,
              DiaInicio: DiaInicio,
              DiaFin: DiaFin,
              HoraInicio: HoraInicio,
              HoraFin: HoraFin,
              Observacion: Observacion
          },
          beforeSend: function() {
              respAlert("info", "Verificando datos...");
          },
          success: function(data) {
              console.log(data);
              var stringL = data.split(",");
              data=stringL[0];
              str=stringL[1];
              switch (data[0]) {
                  case "0":
                      respAlert("warning", str);
                      break;
                  case "1":
                      respAlert("success", "Moficacion correctamente, redireccionando..");
                      setTimeout(function(){
                        redireccionar("../sistema/Descuentos.php");
                      },1000);
                      break;
                  case "2":
                      respAlert("warning", "Error en la base de datos, contacte a soporte");
                      break;
                  case "3":
                      respAlert("warning", "ERROR!!!, redireccionando..");
                      setTimeout(function(){
                        redireccionar("../sistema/Descuentos.php");
                      },1000);
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
    });

    //Modificar Ausencia btnModificarAusencia
    $("#btnModificarAusencia").click(function() {
      var idAusencia = document.getElementById("idAusencia").value;
      var TipoAusencia = $("#TAusencia").val();
      if(TipoAusencia==1){
        var EstadoAusencia = $("#EstadoAusencia").val();
      }else {
        var EstadoAusencia = "0";
      }
      var FechaAusencia = document.getElementById("FechaAusencia").value;
      var Observacion= $("#Observacion").val();
      var opc=5;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Modificar.php',
            type: 'POST',
            data: {
              opc: 5,
              idAusencia: idAusencia,
              TipoAusencia: TipoAusencia,
              EstadoAusencia: EstadoAusencia,
              FechaAusencia: FechaAusencia,
              Observacion: Observacion
          },
          beforeSend: function() {
              respAlert("info", "Verificando datos...");
          },
          success: function(data) {
              console.log(data);
              var stringL = data.split(",");
              data=stringL[0];
              str=stringL[1];
              switch (data[0]) {
                  case "0":
                      respAlert("warning", str);
                      break;
                  case "1":
                      respAlert("success", "Agregado correctamente, redireccionando..");
                      setTimeout(function(){
                        redireccionar("../sistema/Descuentos.php");
                      },1000);
                      break;
                  case "2":
                      respAlert("warning", "Error en la base de datos, contacte a soporte");
                      break;
                  case "3":
                      respAlert("warning", "ERROR!!!, redireccionando..");
                      setTimeout(function(){
                        redireccionar("../sistema/Descuentos.php");
                      },1000);
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
    });

    //Modificar Incapacidad btnModificarIncap
    $("#btnModificarIncap").click(function() {
        var idIncapacidad = document.getElementById("idIncapacidad").value;
        var TipoIncapacidad = $("#TIncapacidad").val();
        if(TipoIncapacidad==2){
          var NombreClinica = document.getElementById("nombreClinica").value;
          var NumeroTelefonoClinica = document.getElementById("numTClinica").value;
        }else {
          var NombreClinica = "";
          var NumeroTelefonoClinica = "";
        }
        var Doctor = document.getElementById("NDoctor").value;
        var DiaInicio = document.getElementById("FechaInicio").value;
        var DiaFin = document.getElementById("FechaFin").value;
        var FechaExpedicion = document.getElementById("FechaExpedicion").value;
        var EstadoComprobacion =0;
        var opc=0;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Modificar.php',
            type: 'POST',
            data: {
              opc: 4,
              TipoIncapacidad: TipoIncapacidad,
              idIncapacidad: idIncapacidad,
              NombreClinica: NombreClinica,
              NumeroTelefonoClinica: NumeroTelefonoClinica,
              Doctor: Doctor,
              DiaInicio: DiaInicio,
              DiaFin: DiaFin,
              FechaExpedicion: FechaExpedicion,
              EstadoComprobacion: EstadoComprobacion
          },
          beforeSend: function() {
              respAlert("info", "Verificando datos...");
          },
          success: function(data) {
              console.log(data);
              var stringL = data.split(",");
              data=stringL[0];
              str=stringL[1];
              switch (data[0]) {
                  case "0":
                      respAlert("warning", str);
                      break;
                  case "1":
                      respAlert("success", "Agregado correctamente, redireccionando..");
                      setTimeout(function(){
                        redireccionar("../sistema/Descuentos.php");
                      },1000);
                      break;
                  case "2":
                      respAlert("warning", "Error en la base de datos, contacte a soporte");
                      break;
                  case "3":
                      respAlert("warning", "ERROR!!!, redireccionando..");
                      setTimeout(function(){
                        redireccionar("../sistema/Descuentos.php");
                      },1000);
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
    });
    //Modificar Cargo btnMCargos
    $("#btnMCargos").click(function() {
        var NombreCargo = document.getElementById("NombreCargo").value;
        var Descripcion = document.getElementById("Descripcion").value;
        var idDepartamento = $("#idDepartamento").val();
        var NitEmpresa = document.getElementById("nitEmpresa").value;
        var PEmpleado = document.getElementById("PEmpleado").checked;
        var PPlanilla = document.getElementById("PPlanilla").checked;
        var idCargos = document.getElementById("idCargos").value;
        if (PPlanilla) {
            PPlanilla = 1;
        } else PPlanilla = 0;
        if (PEmpleado) {
            PEmpleado = 1;
        } else PEmpleado = 0;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Modificar.php',
            type: 'POST',
            data: {
                opc: 2,
                NombreCargo: NombreCargo,
                Descripcion: Descripcion,
                idDepartamento: idDepartamento,
                NitEmpresa: NitEmpresa,
                PEmpleado: PEmpleado,
                PPlanilla: PPlanilla,
                idCargos: idCargos
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Llene el nombre");
                        break;
                    case "1":
                        respAlert("warning", "Ya Existe un Cargo con el mismo nombre en el mismo departamento");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("cargos.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
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
    });
    //Eliminar incapacidad btnEliminarIncap
    $("#btnEliminarIncap").click(function() {
          var idIncapacidad = document.getElementById("idIncapacidad").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc: 5,
                idIncapacidad: idIncapacidad
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en base de datos");
                        break;
                    case "1":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("Descuentos.php");
                        }, 1000);
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("danger", "ERROR!!!!!");
                            redireccionar("Descuentos.php");
                        }, 1000);
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
    });
    //Eliminar Permisos btnEliminarPermiso
    $("#btnEliminarPermiso").click(function() {
          var idPermiso = document.getElementById("idPermiso").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc: 7,
                idPermiso: idPermiso
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en base de datos");
                        break;
                    case "1":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("Descuentos.php");
                        }, 1000);
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("danger", "ERROR!!!!!");
                            redireccionar("Descuentos.php");
                        }, 1000);
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
    });
    //Eliminar incapacidad btnEliminarIncap
    $("#btnEliminarAusencia").click(function() {
          var idAusencia = document.getElementById("idAusencia").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc: 6,
                idAusencia: idAusencia
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en base de datos");
                        break;
                    case "1":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("Descuentos.php");
                        }, 1000);
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("danger", "ERROR!!!!!");
                            redireccionar("Descuentos.php");
                        }, 1000);
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
    });
    //Eliminar cargo btnEliminarCargos
    $("#btnEliminarCargos").click(function() {
        var idCargos = document.getElementById("idCargos").value;
        var NitEmpresa = document.getElementById("nitEmpresa").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc: 3,
                idCargos: idCargos,
                NitEmpresa: NitEmpresa
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en base de datos");
                        break;
                    case "1":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("cargos.php");
                        }, 1000);
                        break;
                    case "2":
                        respAlert("warning", "Existe un Empleado en este Cargo, imposible eliminar");
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
    });
    //Agregar Turno
    $("#btnATruno").click(function() {
        var NitEmpresa = document.getElementById("nitEmpresa").value;
        var nombreTurno = document.getElementById("Njornada").value;
        var Desde = document.getElementById("desde").value;
        var Hasta = document.getElementById("hasta").value;
        var Periodo_Pago = $("#PPago").val();
        var MJornada=$("#MJornada").val();
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/verificar_Turno.php',
            type: 'POST',
            data: {
                NitEmpresa: NitEmpresa,
                nombreTurno: nombreTurno,
                Desde: Desde,
                Hasta: Hasta,
                Periodo_Pago: Periodo_Pago,
                MJornada:MJornada
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en empresa " + NitEmpresa);
                        break;
                    case "1":
                        respAlert("warning", "Llene todo los campos y revice que el tiempo Desde sea menor que el Hasta");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("turno.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "Error en base ");
                        break;
                    case "4":
                        respAlert("warning", "El formato de tiempo es 00:00 a 23:59");
                        break;
                    case "5":
                        respAlert("warning", "El Periodo de Pago es Incorrecto");
                        break;
                    case "6":
                        respAlert("warning", "El Inicio de la media jornada es Incorrecto");
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
    });

    //Eliminar turno
    $("#btnEliminarTruno").click(function() {
        var idTurno = document.getElementById("idTurno").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/Eliminar.php',
            type: 'POST',
            data: {
                opc: 1,
                idTurno: idTurno
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Existen empleados en este turno, No es posible eliminar");
                        break;
                    case "1":
                        respAlert("warning", "Error en BD contacte para mas informacion");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("../sistema/turno.php");
                        }, 1000);
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
    });


    $("#btnLogin").click(function() {
        var user = document.getElementById("DUI").value;
        var password = document.getElementById("password").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: 'php/verificar_login.php',
            type: 'POST',
            data: {
                user: user,
                password: password
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "No existe: " + user);
                        break;
                    case "1":
                        respAlert("warning", "Credenciales incorrectas");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                            redireccionar("sistema/menu.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "La empresa ha sido bloqueada, contacte su servicio");
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
    });


    //
    $("#btnAnteriorSemana").click(function() {
        var idTurno = document.getElementById("idTurno").value;
        var semana = document.getElementById("semana").value;
        var annio = document.getElementById("annio").value;
        var NitEmpresa = document.getElementById("NitEmpresa").value;
        var idSemanal = document.getElementById("idSemanal").value;
        //alert("Aqui voy");
        $.ajax({
            url: 'agregar.php',
            type: 'POST',
            data: {
                opc: 3,
                idTurno: idTurno,
                semana: semana,
                annio: annio,
                NitEmpresa: NitEmpresa,
                idSemanal: idSemanal
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en envio de datos");
                        break;
                    case "1":
                        respAlert("warning", "No se encontro semanal anterior");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...");
                        }, 2000);
                        redireccionar("semanal.php");
                        break;
                    case "3":
                        respAlert("warning", "Error en conexion a base de datos");
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
    });
    //Agregar Ausencia btnAgregarAusencia
    $("#btnAgregarAusencia").click(function() {
        var TipoAusencia = $("#TAusencia").val();
        if(TipoAusencia==1){
          var EstadoAusencia = $("#EstadoAusencia").val();
        }else {
          var EstadoAusencia = "0";
        }
        var FechaAusencia = document.getElementById("FechaAusencia").value;
        var Observacion= $("#Observacion").val();
        var NumeroDocumento = document.getElementById("numDoc").value;
        var opc=10;
        //alert("Aqui voy");
        $.ajax({
            url: '../sistema/agregar.php',
            type: 'POST',
            data: {
                opc: 10,
                TipoAusencia: TipoAusencia,
                EstadoAusencia: EstadoAusencia,
                FechaAusencia: FechaAusencia,
                Observacion: Observacion,
                NumeroDocumento: NumeroDocumento
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                var stringL = data.split(",");
                data=stringL[0];
                str=stringL[1];
                switch (data[0]) {
                    case "0":
                        respAlert("warning", str);
                        break;
                    case "1":
                        respAlert("success", "Agregado correctamente, redireccionando..");
                        setTimeout(function(){
                          redireccionar("../sistema/Descuentos.php");
                        },1000);
                        break;
                    case "2":
                        respAlert("warning", "Error en la base de datos, contacte a soporte");
                        break;
                  }
                //respAlert("success",data[0]);
                /*
                confirmButtonText: 'Si, guardar!'
              }).then(function () {

                setTimeout(function(){
                  redireccionar("sistema/home.php");
                },1000);*/
            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
        });//Fin Ajax
    });

    //Agregar Permiso btnAgregarPermiso
    $("#btnAgregarPermiso").click(function() {
        var TipoPermiso = $("#TPermiso").val();
        if(TipoPermiso==1){
          //Dias
          var DiaInicio = document.getElementById("FechaInicio").value;
          var DiaFin = document.getElementById("FechaFin").value;
          var HoraInicio = "00:00:00";
          var HoraFin = "00:00:00";

        }else {
          //Horas
          var DiaInicio = document.getElementById("Fecha").value;
          var DiaFin = "1995-04-19";//Random date
          var HoraInicio = document.getElementById("hInicio").value;
          var HoraFin = document.getElementById("hFin").value;
        }
        var Observacion= $("#Observacion").val();

        //NumeroDocumento
        var NumeroDocumento = document.getElementById("numDoc").value;
        var opc=10;
        //alert("Aqui voy");
        $.ajax({
            url: '../sistema/agregar.php',
            type: 'POST',
            data: {
                opc: 11,
                TipoPermiso: TipoPermiso,
                DiaInicio: DiaInicio,
                DiaFin: DiaFin,
                HoraInicio: HoraInicio,
                HoraFin: HoraFin,
                Observacion: Observacion,
                NumeroDocumento:NumeroDocumento
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                var stringL = data.split(",");
                data=stringL[0];
                str=stringL[1];
                switch (data[0]) {
                    case "0":
                        respAlert("warning", str);
                        break;
                    case "1":
                        respAlert("success", "Agregado correctamente, redireccionando..");
                        setTimeout(function(){
                          redireccionar("../sistema/Descuentos.php");
                        },1000);
                        break;
                    case "2":
                        respAlert("warning", "Error en la base de datos, contacte a soporte");
                        break;
                    case "3":
                        respAlert("warning", "ERROR INTENTO DE INGRESO DE DATO INCORRECTO, redireccionando..");
                        setTimeout(function(){
                        redireccionar("../sistema/menu.php");
                        },1000);
                        break;
                  }
                //respAlert("success",data[0]);
                /*
                confirmButtonText: 'Si, guardar!'
              }).then(function () {

                setTimeout(function(){
                  redireccionar("sistema/home.php");
                },1000);*/
            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
        });//Fin Ajax
    });
    //Agregar Incapacidad btnAgregarIncap
    $("#btnAgregarIncap").click(function() {
        var TipoIncapacidad = $("#TIncapacidad").val();
        var NumeroDocumento = document.getElementById("numDoc").value;
        if(TipoIncapacidad==2){
          var NombreClinica = document.getElementById("nombreClinica").value;
          var NumeroTelefonoClinica = document.getElementById("numTClinica").value;
        }else {
          var NombreClinica = "";
          var NumeroTelefonoClinica = "";
        }
        var Doctor = document.getElementById("NDoctor").value;
        var DiaInicio = document.getElementById("FechaInicio").value;
        var DiaFin = document.getElementById("FechaFin").value;
        var FechaExpedicion = document.getElementById("FechaExpedicion").value;
        var EstadoComprobacion =0;
        var opc=0;
        //alert("Aqui voy");
        $.ajax({
            url: '../sistema/agregar.php',
            type: 'POST',
            data: {
                opc: 9,
                TipoIncapacidad: TipoIncapacidad,
                NumeroDocumento: NumeroDocumento,
                NombreClinica: NombreClinica,
                NumeroTelefonoClinica: NumeroTelefonoClinica,
                Doctor: Doctor,
                DiaInicio: DiaInicio,
                DiaFin: DiaFin,
                FechaExpedicion: FechaExpedicion,
                EstadoComprobacion: EstadoComprobacion
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                var stringL = data.split(",");
                data=stringL[0];
                str=stringL[1];
                switch (data[0]) {
                    case "0":
                        respAlert("warning", str);
                        break;
                    case "1":
                        respAlert("success", "Agregado correctamente, redireccionando..");
                        setTimeout(function(){
                          redireccionar("../sistema/Descuentos.php");
                        },1000);
                        break;
                    case "2":
                        respAlert("warning", "Error en la base de datos, contacte a soporte");
                        break;
                  }
                //respAlert("success",data[0]);
                /*
                confirmButtonText: 'Si, guardar!'
              }).then(function () {

                setTimeout(function(){
                  redireccionar("sistema/home.php");
                },1000);*/
            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
        });//Fin Ajax
    });
    //Generar Reporte Horas Extras
    $("#btnReporteHorasExtrasGeneral").click(function() {
        var FechaInicio = $("#FInicio").val();
        var Departamento = $("#AreaTrabajo").val();
        var TipoReporte = $("#TipoReporte").val();
        var opc=0;
        //alert("Aqui voy");
        $.ajax({
            url: 'PDF_Reporte_Horas_Extras.php',
            type: 'POST',
            data: {
                opc: 0,
                FechaInicio: FechaInicio,
                Departamento: Departamento,
                TipoReporte: TipoReporte
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                var stringL = data.split(",");
                data=stringL[0];
                str=stringL[1];
                FechaInicio=stringL[2];
                FechaFin=stringL[3];
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Ingrese Fechas");
                        break;
                    case "1":
                        respAlert("warning", "Las fechas tienen que estar en formato Dia/Mes/Años");
                        break;
                    case "2":
                        respAlert("warning", "El Valor de Tipo de pago que quiere acceder es invalido");
                        break;
                    case "3":
                      document.getElementById('Fechas').value = str;
                      document.getElementById('opc').value = 1;
                      document.getElementById('FechaInicio').value = FechaInicio;
                      document.getElementById('FechaFin').value = FechaFin;
                      document.getElementById('Departamento').value = Departamento;
                      document.getElementById('TPago').value = TipoReporte;
                      swal({
                        title: "Desea Continuar",
                        text: "Solo se generara de las fechas confirmadas:",
                        html: "Solo se generara del tipo de pago seleccionado y de las fechas confirmadas:<div class='row'>"+$('#Fechas').val()+"</div><div class='row'><br></div>",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "OK",
                        allowOutsideClick: false,
                        showLoaderOnConfirm: true,
                        }).then(function() {
                          document.getElementById("PDFUserForm").submit();
                          setTimeout(function () {
                            respAlert("success", "Generado Exitosamente");
                          }, 2000);
                        }, function (dismiss) {
                          if (dismiss === 'cancel') {
                            respAlert("success", "Cancelado");
                          }
                        }).catch(swal.noop);


                      //).catch(swal.noop);
                    break;
                  }
                //respAlert("success",data[0]);
                /*
                confirmButtonText: 'Si, guardar!'
              }).then(function () {

                setTimeout(function(){
                  redireccionar("sistema/home.php");
                },1000);*/
            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
        });//Fin Ajax
    });

    //FIN


    //guardarSemana
    $("#btnAgregarUsuario").click(function() {
        var Tdocumento = $("#Tdocumento").val();
        var NumeroDocumento = document.getElementById("NumeroDocumento").value;
        var PrimerNombre = document.getElementById("PrimerNombre").value;
        var PrimerApellido = document.getElementById("PrimerApellido").value;
        var Pass = document.getElementById("Pass").value;
        var SMensual = document.getElementById("SMensual").value;
        var Desde = document.getElementById("Desde").value;
        var Hasta = document.getElementById("Hasta").value;
        var FechaIngreso = document.getElementById("FechaIngreso").value;
        var idTurno = $("#idTurno").val();
        var activo = $("#activo").val();
        var idCargos = $("#cargo").val();
        var descanso = $("#descanso").val();
        if(descanso==1){
          var H_Descanso = document.getElementById("H_Descanso").value;
          H_Descanso=H_Descanso+":00";
        }else{
          var H_Descanso="00:00:00";
        }
        $.ajax({
            url: 'agregar.php',
            type: 'POST',
            data: {
                opc: 5,
                Tdocumento: Tdocumento,
                NumeroDocumento: NumeroDocumento,
                PrimerNombre: PrimerNombre,
                PrimerApellido: PrimerApellido,
                Pass: Pass,
                SMensual: SMensual,
                Desde: Desde,
                Hasta: Hasta,
                FechaIngreso: FechaIngreso,
                idTurno: idTurno,
                activo: activo,
                idCargos: idCargos,
                descanso: descanso,
                H_Descanso: H_Descanso
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "LLene completamente los datos");
                        break;
                    case "1":
                        respAlert("warning", "No se ha podido insertar a la BD");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Guardado Exitoso");
                            redireccionar("AgregarEmpleado.php");
                        }, 2000);
                        break;
                    case "3":
                        respAlert("warning", "El horario de Entrada tiene que ser menor al de salida");
                        break;
                    case "4":
                        respAlert("warning", "Ingrese un turno primero");
                        break;
                    case "5":
                        respAlert("warning", "El Tiempo tien que ser en formato de 24hrs ej:13:00:00 o 07:00:00");
                        break;
                    case "6":
                        respAlert("warning", "Ingrese Horario de Entrada y Horario de Salida");
                        break;
                    case "7":
                        respAlert("warning", "Ya existe un usuario con el mismo numero de Documento");
                        break;
                    case "8":
                        respAlert("warning", "Seleccione un Cargo valido");
                        break;
                    case "9":
                      setTimeout(function() {
                          respAlert("danger", "Intento de ingreso invalido");
                          redireccionar("menu.php");
                      }, 2000);
                        break;
                }

            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
        });
    });

    //Nuevo Usuario
    $("#btnGuardarSemana").click(function() {
        var idSemanal = document.getElementById("idSemanal").value;
        var idTurno = document.getElementById("idTurno").value;
        var SLunes = $("#SLunes").val();
        var SMartes = $("#SMartes").val();
        var SMiercoles = $("#SMiercoles").val();
        var SJueves = $("#SJueves").val();
        var SViernes = $("#SViernes").val();
        var SSabado = $("#SSabado").val();
        var SDomingo = $("#SDomingo").val();
        var rev = 0;
        $.ajax({
            url: 'agregar.php',
            type: 'POST',
            data: {
                opc: 4,
                rev: 0,
                idSemanal: idSemanal,
                idTurno: idTurno,
                SLunes: SLunes,
                SMartes: SMartes,
                SMiercoles: SMiercoles,
                SJueves: SJueves,
                SViernes: SViernes,
                SSabado: SSabado,
                SDomingo: SDomingo
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
                resultadoR=data.split(",");
                if(resultadoR[0]==1){
                  //si se tiene que revisar
                  swal({
                    title: 'Desea Continuar?',
                    text: "<div class='row'><div class='col-md-12'>Bajo el Art.161 del codigo de trabajo, las siguientes personas sobrepasan el maximo de tiempo en su jornada:</div>"+resultadoR[1]+"<div class='col-md-12'>Este exedente se tomara en cuenta en las horas extras, desea continuar?</div></div> ",
                    type: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, continuar!',
                    cancelButtonText: 'No, cancelar!'
                  }).then(function () {
                    $.ajax({
                        url: 'agregar.php',
                        type: 'POST',
                        data: {
                            opc: 4,
                            rev: 1,
                            idSemanal: idSemanal,
                            idTurno: idTurno,
                            SLunes: SLunes,
                            SMartes: SMartes,
                            SMiercoles: SMiercoles,
                            SJueves: SJueves,
                            SViernes: SViernes,
                            SSabado: SSabado,
                            SDomingo: SDomingo
                        },
                        beforeSend: function() {
                            respAlert("info", "Verificando datos...");
                        },
                        success: function(data) {
                          switch (data[0]) {
                              case "0":
                                  respAlert("warning", "Error en envio de datos");
                                  break;
                              case "1":
                                  respAlert("warning", "No se encontro semanal anterior");
                                  break;
                              case "2":
                                  setTimeout(function() {
                                      respAlert("success", "Guardado Exitoso");
                                  }, 2000);
                                  break;
                              case "3":
                                  respAlert("warning", "Error en conexion a base de datos");
                                  break;
                          }

                        },
                        error: function(data) {
                            console.log(data);
                            respAlert("danger", "Error...");
                        }
                    });//fin ajax
                  }, function (dismiss) {
                    // dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                    if (dismiss === 'cancel') {
                      respAlert("info", "Cancelado");
                      swal(
                        'Cancelado',
                        'El semanal no se ha modificado, para conocer de esta alerta contacte a soporte',
                        'error'
                      )
                    }
                }).catch(swal.noop);
                }else{
                  //Si no se tiene que revisar
                  $.ajax({
                      url: 'agregar.php',
                      type: 'POST',
                      data: {
                          opc: 4,
                          rev: 1,
                          idSemanal: idSemanal,
                          idTurno: idTurno,
                          SLunes: SLunes,
                          SMartes: SMartes,
                          SMiercoles: SMiercoles,
                          SJueves: SJueves,
                          SViernes: SViernes,
                          SSabado: SSabado,
                          SDomingo: SDomingo
                      },
                      beforeSend: function() {
                          respAlert("info", "Verificando datos...");
                      },
                      success: function(data) {
                        switch (data[0]) {
                            case "0":
                                respAlert("warning", "Error en envio de datos");
                                break;
                            case "1":
                                respAlert("warning", "No se encontro semanal anterior");
                                break;
                            case "2":
                                setTimeout(function() {
                                    respAlert("success", "Guardado Exitoso");
                                }, 2000);
                                break;
                            case "3":
                                respAlert("warning", "Error en conexion a base de datos");
                                break;
                        }

                      },
                      error: function(data) {
                          console.log(data);
                          respAlert("danger", "Error...");
                      }
                  });

                //fin else
                }

                /*
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "Error en envio de datos");
                        break;
                    case "1":
                        respAlert("warning", "No se encontro semanal anterior");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Guardado Exitoso");
                        }, 2000);
                        break;
                    case "3":
                        respAlert("warning", "Error en conexion a base de datos");
                        break;
                }
                */
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
    });
    //btnConfirmarPermiso
    $("#btnConfirmarPermiso").click(function() {
       var idPermiso = document.getElementById("idPermiso").value; //idPermiso
       //contenidoCambiante
         swal({
           title: 'Desea Continuar?',
           text: "Al continuar este Permiso ya no sera modificable",
           type: 'warning',
           showCancelButton: true,
           allowOutsideClick: false,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Si, continuar!',
           cancelButtonText: 'No, cancelar!'
         }).then(function () {
           $.ajax({
               url: '../php/Modificar.php',
               type: 'POST',
               data: {
                   opc: 7,
                   idPermiso: idPermiso
               },
               beforeSend: function() {
                   respAlert("info", "Verificando datos...");
               },
               success: function(data) {
                 data=data.split(",");
                 switch (data[0]) {
                     case "0":
                         respAlert("warning", data[1]);
                         break;
                     case "1":
                         setTimeout(function() {
                             respAlert("success", "Confirmado Exitoso");
                             redireccionar("Descuentos.php");
                         }, 2000);
                         break;
                 }

               },
               error: function(data) {
                   console.log(data);
                   respAlert("danger", "Error...");
               }
           });//fin ajax
         }, function (dismiss) {
           // dismiss can be 'cancel', 'overlay',
           // 'close', and 'timer'
           if (dismiss === 'cancel') {
             respAlert("info", "Cancelado");
             swal(
               'Cancelado',
               'Se ha cancelado la confirmacion',
               'error'
             )
           }
       }).catch(swal.noop);
    });

    //Obtener valores de horas Extras
    $("#btnHorasExtras").click(function() {
        var table = $("#TablaHorasEx tbody");
        var Fecha = document.getElementById("Fecha").value;
        var IdArray = {};
        var NombresArray = {};
        var HoraEntradaArray = {};
        var HoraSalidaArray = {};
        table.find('tr').each(function(i) {
            var $tds = $(this).find('td'),
                Id = $tds.eq(0).find('input').val(),
                Nombre = $tds.eq(0).text(),
                HoraEntrada = $tds.eq(1).find('input').val(),
                HoraSalida = $tds.eq(2).find('input').val();
            // do something with productId, product, Quantity
            IdArray[i] = Id;
            NombresArray[i] = Nombre;
            HoraEntradaArray[i] = HoraEntrada;
            HoraSalidaArray[i] = HoraSalida;
        });
        $.ajax({
            type: 'POST',
            url: '../php/verificar_HorasExtras.php',
            data: {
                Fecha: Fecha,
                IdArray: JSON.stringify(IdArray),
                NombresArray: JSON.stringify(NombresArray),
                HoraEntradaArray: JSON.stringify(HoraEntradaArray),
                HoraSalidaArray: JSON.stringify(HoraSalidaArray)
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(response) {
                var response = "" + response;
                var response = response.split(",");
                if (response[0] == 1) {
                    respAlert("warning", response[1]);
                }else if (response[0] == 2) {
                  var response = response[1].split("-");
                  swal({
                    title: 'Desea Continuar?',
                    text: response[0]+" tiene el mismo horario "+response[1]+"-"+response[1]+" el dia anterior",
                    type: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, guardar!'
                  }).then(function () {
                      $.ajax({
                        type: 'POST',
                        url: '../php/almacenar_HorasExtras.php',
                        data: {
                            Fecha: Fecha,
                            IdArray: JSON.stringify(IdArray),
                            NombresArray: JSON.stringify(NombresArray),
                            HoraEntradaArray: JSON.stringify(HoraEntradaArray),
                            HoraSalidaArray: JSON.stringify(HoraSalidaArray)
                        },
                        beforeSend: function() {
                          respAlert("info", "Verificando datos...");
                        },
                        success: function(response) {
                            var response = "" + response;
                            var response = response.split(",");
                            if (response[0] == 1) {
                                respAlert("warning", response[1]);
                            } else {
                              setTimeout(function() {
                                  respAlert("success", response[1]);
                                  redireccionar("Horas_Extras.php");
                              }, 3000);
                            }
                        }
                      });//Fin Ajax
                  }).catch(swal.noop);
                  respAlert("info", "Cancelado");
                } else {
                  setTimeout(function() {
                      respAlert("success", response[1]);
                      redireccionar("Horas_Extras.php");
                  }, 3000);
                }
            }
        });//Fin Ajax
    });
    //Fin

    //Obtener valores de horas Extras
    $("#btnCrearLlegadasTarde").click(function() {
        var table = $("#TablaHorasEx tbody");
        var Fecha = document.getElementById("Fecha").value;
        var IdArray = {};
        var NombresArray = {};
        var HoraEntradaArray = {};
        var HoraSalidaArray = {};
        table.find('tr').each(function(i) {
            var $tds = $(this).find('td'),
                Id = $tds.eq(0).find('input').val(),
                Nombre = $tds.eq(0).text(),
                HoraEntrada = $tds.eq(1).find('input').val(),
                HoraSalida = $tds.eq(2).find('input').val();
            // do something with productId, product, Quantity
            IdArray[i] = Id;
            NombresArray[i] = Nombre;
            HoraEntradaArray[i] = HoraEntrada;
            HoraSalidaArray[i] = HoraSalida;
        });
        $.ajax({
            type: 'POST',
            url: '../php/verificar_Llegadas_Tarde.php',
            data: {
                Fecha: Fecha,
                IdArray: JSON.stringify(IdArray),
                NombresArray: JSON.stringify(NombresArray),
                HoraEntradaArray: JSON.stringify(HoraEntradaArray),
                HoraSalidaArray: JSON.stringify(HoraSalidaArray)
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(response) {
                var response = "" + response;
                var response = response.split(",");
                if (response[0] == 1) {
                    respAlert("warning", response[1]);
                }else if (response[0] == 2) {
                  var response = response[1].split("-");
                  swal({
                    title: 'Desea Continuar?',
                    text: response[0]+" tiene el mismo horario "+response[1]+"-"+response[1]+" el dia anterior",
                    type: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, guardar!'
                  }).then(function () {
                      $.ajax({
                        type: 'POST',
                        url: '../php/almacenar_HorasExtras.php',
                        data: {
                            Fecha: Fecha,
                            IdArray: JSON.stringify(IdArray),
                            NombresArray: JSON.stringify(NombresArray),
                            HoraEntradaArray: JSON.stringify(HoraEntradaArray),
                            HoraSalidaArray: JSON.stringify(HoraSalidaArray)
                        },
                        beforeSend: function() {
                          respAlert("info", "Verificando datos...");
                        },
                        success: function(response) {
                            var response = "" + response;
                            var response = response.split(",");
                            if (response[0] == 1) {
                                respAlert("warning", response[1]);
                            } else {
                              setTimeout(function() {
                                  respAlert("success", response[1]);
                                  redireccionar("Llegadas_Tarde.php");
                              }, 3000);
                            }
                        }
                      });//Fin Ajax
                  }).catch(swal.noop);
                  respAlert("info", "Cancelado");
                } else {
                  setTimeout(function() {
                      respAlert("success", response[1]);
                      redireccionar("Llegadas_Tarde.php");
                  }, 3000);
                }
            }
        });//Fin Ajax
    });
    //Fin



    //Actualizar Usuario
    $("#btnActualizarUsuario").click(function() {
        var NumeroDocumento = document.getElementById("Ndocumento").value;
        var TipoDocumento = $("#Tdocumento").val();
        var idCargos = $("#cargo").val();
        var changePass=document.getElementById('changePass');
        var Pass = document.getElementById("pass").value;
        var Activo = $("#activo").val();
        var Nup = document.getElementById("NNUP").value;
        var InstitucionPrevisional = $("#NAFP").val();
        var PrimerNombre = document.getElementById("Pnombre").value;
        var SegundoNombre = document.getElementById("Snombre").value;
        var PrimerApellido = document.getElementById("Papellido").value;
        var SegundoApellido = document.getElementById("Sapellido").value;
        var ApellidoCasada = document.getElementById("Acasada").value;
        var ConocidoPor = document.getElementById("Cpor").value;
        var Nit = document.getElementById("NNIT").value;
        var NumeroIsss = document.getElementById("NISSS").value;
        var NumeroInpep = document.getElementById("NIMPEP").value;
        var Genero = document.getElementById("Genero").value;
        var Nacionalidad = $("#pais").val();
        var SalarioNominal = document.getElementById("SMensual").value;
        var FechaNacimiento = document.getElementById("Fnacimiento").value;
        var EstadoCivil = $("#Ecivil").val();
        var Direccion = document.getElementById("Direccion").value;
        var Departamento = $("#C_departamento").val();
        var Municipio = $("#C_municipio").val();
        var NumeroTelefonico = document.getElementById("Telefono").value;
        var CorreoElectronico = document.getElementById("correo").value;
        var FechaIngreso = document.getElementById("FechaIngreso").value;
        var FechaRetiro = document.getElementById("FechaRetiro").value;
        var FechaFallecimiento = document.getElementById("FechaFallecimiento").value;
        //Horarios de Trabajo
        var Desde = document.getElementById("hEntrada").value;
        var Hasta = document.getElementById("hSalida").value;
        var idTurno = $("#idTurno").val();
        var descanso = $("#descanso").val();

        //BANCOS
        var idBanco = $("#Banco").val();
        var nCuenta = document.getElementById("CuentaBanco").value;
        //PARA el checkbox
        if (changePass.checked) {
          changePass=1;
        } else {
          changePass=0;
        }
        if(descanso==1) {
          var H_Descanso = document.getElementById("H_Descanso").value+":00";
        }else {
          var H_Descanso="00:00:00";
        }
        console.log(NumeroDocumento);
        $.ajax({
            url: 'agregar.php',
            type: "POST",
            data: {
                opc: 2,
                NumeroDocumento: NumeroDocumento,
                TipoDocumento: TipoDocumento,
                idCargos: idCargos,
                Pass: Pass,
                changePass: changePass,
                Activo: Activo,
                Nup: Nup,
                InstitucionPrevisional: InstitucionPrevisional,
                PrimerNombre: PrimerNombre,
                SegundoNombre: SegundoNombre,
                PrimerApellido: PrimerApellido,
                SegundoApellido: SegundoApellido,
                ApellidoCasada: ApellidoCasada,
                ConocidoPor: ConocidoPor,
                Nit: Nit,
                NumeroIsss: NumeroIsss,
                NumeroInpep: NumeroInpep,
                Genero: Genero,
                Nacionalidad: Nacionalidad,
                SalarioNominal: SalarioNominal,
                FechaNacimiento: FechaNacimiento,
                EstadoCivil: EstadoCivil,
                Direccion: Direccion,
                Departamento: Departamento,
                Municipio: Municipio,
                NumeroTelefonico: NumeroTelefonico,
                CorreoElectronico: CorreoElectronico,
                FechaIngreso: FechaIngreso,
                FechaRetiro: FechaRetiro,
                FechaFallecimiento: FechaFallecimiento,
                Desde: Desde,
                Hasta: Hasta,
                descanso: descanso,
                H_Descanso: H_Descanso,
                idTurno: idTurno,
                idBanco: idBanco,
                nCuenta: nCuenta
            },
            beforeSend: function() {
                console.log("NumeroDocumento: " + NumeroDocumento);
                respAlert("info", "Actualizando Usuario...");
            },
            success: function(data) {
                console.log(data);
                switch (data[0]) {
                    case "0":
                        respAlert("warning", "LLene completamente los datos con asterisco *: ");
                        break;
                    case "1":
                        respAlert("warning", "No se ha podido insertar a la BD");
                        break;
                    case "2":
                        setTimeout(function() {
                            respAlert("success", "Correcto...redireccionando al inicio");
                            redireccionar("verEmpleados.php");
                        }, 1000);
                        break;
                    case "3":
                        respAlert("warning", "El horario de Entrada tiene que ser menor al de salida");
                        break;
                    case "4":
                        respAlert("warning", "El Tiempo tiene que ser en formato de 24hrs ej:13:00:00 o 07:00:00");
                        break;
                    case "5":
                        respAlert("warning", "Ingrese Horario de Entrada y Horario de Salida");
                        break;
                    case "6":
                        respAlert("warning", "El numero de cuenta unicamente pueden ser digitos Numericos");
                        break;
                    case "7":
                        respAlert("warning", "La contraseña no puede ir vacia");
                        break;
                    case "8":
                        respAlert("danger", "Intento de ingreso de dato invalido");
                        break;
                    case "9":
                        respAlert("warning", "El Tiempo de descanso que ser en formato de 24hrs ej:13:00:00 o 07:00:00");
                        break;
                }
            },
            error: function(data) {
                console.log(data);
                respAlert("danger", "Error...");
            }
        });
        event.preventDefault();
    });

});

function prueba() {
    alert("Click");
}


function respAlert(tipoAlert, mensaje) {
    var resp = document.getElementById("respuestaAlert");
    resp.innerHTML = "<div class='alert alert-" + tipoAlert + " alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>" + mensaje + "</strong></div>";
}

function redireccionar(pagina) {
    location.href = pagina;
}

function recargarPagina(pagina) {
    window.location.reload(pagina);
}

function rmvAttr(idOb, atributo) {
    $(idOb).removeAttr(atributo);
}

function addAttr(idOb, atributo, valor) {
    $(idOb).attr(atributo, valor);
}

function addClassAtrb(idOb, clase) {
    $(idOb).addClass(clase);
}

function removeClassAtrb(idOb, clase) {
    $(idOb).removeClass(clase);
}

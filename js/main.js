$(document).ready(function() {
    //Si le dio submit al recibo
    //Modifinr turno
    $("#btnMTruno").click(function() {
        var idTurno = document.getElementById("idTurno").value;
        var nombreTurno = document.getElementById("Njornada").value;
        var Desde = document.getElementById("desde").value;
        var Hasta = document.getElementById("hasta").value;
        var Descanso = $("#descanso").val();
        var H_Descanso = document.getElementById("H_Descanso").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/verificar_TurnoM.php',
            type: 'POST',
            data: {
                idTurno: idTurno,
                nombreTurno: nombreTurno,
                Desde: Desde,
                Hasta: Hasta,
                Descanso: Descanso,
                H_Descanso: H_Descanso
            },
            beforeSend: function() {
                respAlert("info", "Verificando datos...");
            },
            success: function(data) {
                console.log(data);
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
                            redireccionar("turno.php");
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
        var Descanso = $("#descanso").val();
        var H_Descanso = document.getElementById("H_Descanso").value;
        //alert("user: "+user+" - pass: "+contra);
        $.ajax({
            url: '../php/verificar_Turno.php',
            type: 'POST',
            data: {
                NitEmpresa: NitEmpresa,
                nombreTurno: nombreTurno,
                Desde: Desde,
                Hasta: Hasta,
                Descanso: Descanso,
                H_Descanso: H_Descanso
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
                idCargos: idCargos
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
        var SLunes = $("#SLunes").val();
        var SMartes = $("#SMartes").val();
        var SMiercoles = $("#SMiercoles").val();
        var SJueves = $("#SJueves").val();
        var SViernes = $("#SViernes").val();
        var SSabado = $("#SSabado").val();
        var SDomingo = $("#SDomingo").val();
        $.ajax({
            url: 'agregar.php',
            type: 'POST',
            data: {
                opc: 4,
                idSemanal: idSemanal,
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
                } else {
                  setTimeout(function() {
                      respAlert("success", response[1]);
                      redireccionar("Horas_Extras.php");
                  }, 3000);
                }
            }
        });
    });
    //Fin

    //Actualizar Usuario
    $("#btnActualizarUsuario").click(function() {
        var NumeroDocumento = document.getElementById("Ndocumento").value;
        var TipoDocumento = $("#Tdocumento").val();
        var idCargos = $("#cargo").val();
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
                idTurno: idTurno
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
                        respAlert("warning", "El horario de Entrada tiene que ser menor al de salida o el de Entrada mayor o igual a las 16:00:00");
                        break;
                    case "4":
                        respAlert("warning", "El Tiempo tien que ser en formato de 24hrs ej:13:00:00 o 07:00:00");
                        break;
                    case "5":
                        respAlert("warning", "Ingrese Horario de Entrada y Horario de Salida");
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

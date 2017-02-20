$(document).ready(function(){
	//Si le dio submit al recibo
	//Modifinr turno
	$("#btnMTruno").click(function(){
		var idTurno=document.getElementById("idTurno").value;
		var nombreTurno=document.getElementById("Njornada").value;
		var Desde=document.getElementById("desde").value;
		var Hasta=document.getElementById("hasta").value;
		var Descanso=$("#descanso").val();
		var H_Descanso=document.getElementById("H_Descanso").value;
		//alert("user: "+user+" - pass: "+contra);
		$.ajax({
			url:'../php/verificar_TurnoM.php',
			type:'POST',
			data:{
				idTurno:idTurno,
				nombreTurno:nombreTurno,
				Desde:Desde,
				Hasta:Hasta,
				Descanso:Descanso,
				H_Descanso:H_Descanso
			},
			beforeSend: function(){
				respAlert("info","Verificando datos...");
			},
			success:function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						setTimeout(function(){
							respAlert("warning","Error en ID: "+idTurno);
							redireccionar("../index.php");
						},1000);
					break;
					case "1":
						respAlert("warning","Llene todo los campos y revice que el tiempo Desde sea menor que el Hasta");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Correcto...");
							redireccionar("turno.php");
						},1000);
					break;
					case "3":
						respAlert("warning","Error en base ");
					break;
				}
				//respAlert("success",data[0]);
				/*setTimeout(function(){
					redireccionar("sistema/home.php");
				},1000);*/
			},
			error:function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
	});

	//Agregar Turno
	$("#btnATruno").click(function(){
		var NitEmpresa=document.getElementById("nitEmpresa").value;
		var nombreTurno=document.getElementById("Njornada").value;
		var Desde=document.getElementById("desde").value;
		var Hasta=document.getElementById("hasta").value;
		var Descanso=$("#descanso").val();
		var H_Descanso=document.getElementById("H_Descanso").value;
		//alert("user: "+user+" - pass: "+contra);
		$.ajax({
			url:'../php/verificar_Turno.php',
			type:'POST',
			data:{
				NitEmpresa:NitEmpresa,
				nombreTurno:nombreTurno,
				Desde:Desde,
				Hasta:Hasta,
				Descanso:Descanso,
				H_Descanso:H_Descanso
			},
			beforeSend: function(){
				respAlert("info","Verificando datos...");
			},
			success:function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						respAlert("warning","Error en empresa "+NitEmpresa);
					break;
					case "1":
						respAlert("warning","Llene todo los campos y revice que el tiempo Desde sea menor que el Hasta");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Correcto...");
							redireccionar("turno.php");
						},1000);
					break;
					case "3":
						respAlert("warning","Error en base ");
					break;
				}
				//respAlert("success",data[0]);
				/*setTimeout(function(){
					redireccionar("sistema/home.php");
				},1000);*/
			},
			error:function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
	});




	$("#btnLogin").click(function(){
		var user=document.getElementById("DUI").value;
		var password=document.getElementById("password").value;
		//alert("user: "+user+" - pass: "+contra);
		$.ajax({
			url:'php/verificar_login.php',
			type:'POST',
			data:{
				user:user,
				password:password
			},
			beforeSend: function(){
				respAlert("info","Verificando datos...");
			},
			success:function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						respAlert("warning","No existe: "+user);
					break;
					case "1":
						respAlert("warning","Credenciales incorrectas");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Correcto...");
							redireccionar("sistema/menu.php");
						},1000);
					break;
				}
				//respAlert("success",data[0]);
				/*setTimeout(function(){
					redireccionar("sistema/home.php");
				},1000);*/
			},
			error:function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
	});


//
	$("#btnAnteriorSemana").click(function(){
		var idTurno=document.getElementById("idTurno").value;
		var semana=document.getElementById("semana").value;
		var annio=document.getElementById("annio").value;
		var NitEmpresa=document.getElementById("NitEmpresa").value;
		var idSemanal=document.getElementById("idSemanal").value;
		//alert("Aqui voy");
		$.ajax({
			url: 'agregar.php',
			type:'POST',
			data:{
				opc:3,
				idTurno:idTurno,
				semana:semana,
				annio:annio,
				NitEmpresa:NitEmpresa,
				idSemanal:idSemanal
			},
			beforeSend: function(){
				respAlert("info","Verificando datos...");
			},
			success:function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						respAlert("warning","Error en envio de datos");
					break;
					case "1":
						respAlert("warning","No se encontro semanal anterior");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Correcto...");
						},2000);
						redireccionar("semanal.php");
					break;
					case "3":
						respAlert("warning","Error en conexion a base de datos");
					break;
				}
				//respAlert("success",data[0]);
				/*setTimeout(function(){
					redireccionar("sistema/home.php");
				},1000);*/
			},
			error:function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
	});



//guardarSemana
$("#btnGuardarSemana").click(function(){
		var idSemanal=document.getElementById("idSemanal").value;
		var SLunes=$("#SLunes").val();
		var SMartes=$("#SMartes").val();
		var SMiercoles=$("#SMiercoles").val();
		var SJueves=$("#SJueves").val();
		var SViernes=$("#SViernes").val();
		var SSabado=$("#SSabado").val();
		var SDomingo=$("#SDomingo").val();
		$.ajax({
			url: 'agregar.php',
			type:'POST',
			data:{
				opc:4,
				idSemanal:idSemanal,
				SLunes:SLunes,
				SMartes:SMartes,
				SMiercoles:SMiercoles,
				SJueves:SJueves,
				SViernes:SViernes,
				SSabado:SSabado,
				SDomingo:SDomingo
			},
			beforeSend: function(){
				respAlert("info","Verificando datos...");
			},
			success:function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						respAlert("warning","Error en envio de datos");
					break;
					case "1":
						respAlert("warning","No se encontro semanal anterior");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Guardado Exitoso");
						},2000);
					break;
					case "3":
						respAlert("warning","Error en conexion a base de datos");
					break;
				}
				//respAlert("success",data[0]);
				/*setTimeout(function(){
					redireccionar("sistema/home.php");
				},1000);*/
			},
			error:function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
	});





$("#btnAgregarUsuario").click(function(){
		var email=document.getElementById("email").value;
		var nombre=document.getElementById("nombre").value;
		var dui=document.getElementById("dui").value;
		var telefono=document.getElementById("telefono").value;
		var activo=$("#activo").val();
		$.ajax({
			url:'php/agregar_empleado.php',
			type:'POST',
			data:{
				opc: 1,
				email:email,
				nombre:nombre,
				dui:dui,
				telefono:telefono,
				activo:activo
			},
			beforeSend: function(){
				respAlert("info","Verificando datos...");
			},
			success:function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						respAlert("warning","Ya existe el usuario: "+email);
					break;
					case "1":
						respAlert("warning","No se ha podido insertar a la BD");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Correcto...redireccionando al inicio");
							redireccionar("AgregarEmpleado.php");
						},1000);
					break;
				}
				//respAlert("success",data[0]);
				/*setTimeout(function(){
					redireccionar("sistema/home.php");
				},1000);*/
			},
			error:function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
	});

	$("#btnActualizarUsuario").click(function(){
		var NumeroDocumento = document.getElementById("Ndocumento").value;
		var TipoDocumento = $("#Tdocumento").val();
		var idCargos= $("#cargo").val();
		var Pass = document.getElementById("pass").value;
		var Activo = $("#activo").val();
		var Nup = document.getElementById("NNUP").value;
		var InstitucionPrevisional= $("#NAFP").val();
		var PrimerNombre = document.getElementById("Pnombre").value;
		var SegundoNombre = document.getElementById("Snombre").value;
		var PrimerApellido = document.getElementById("Papellido").value;
		var SegundoApellido =document.getElementById("Sapellido").value;
		var ApellidoCasada = document.getElementById("Acasada").value;
		var ConocidoPor = document.getElementById("Cpor").value;
		var Nit = document.getElementById("NNIT").value;
		var NumeroIsss = document.getElementById("NISSS").value;
		var NumeroInpep = document.getElementById("NIMPEP").value;
		var Genero=document.getElementById("Genero").value;
		var Nacionalidad=$("#pais").val();
		var SalarioNominal = document.getElementById("SMensual").value;
		var FechaNacimiento = document.getElementById("Fnacimiento").value;
		var EstadoCivil = $("#Ecivil").val();
		var Direccion = document.getElementById("Direccion").value;
		var Departamento= $("#C_departamento").val();
		var Municipio = $("#C_municipio").val();
		var NumeroTelefonico = document.getElementById("Telefono").value;
		var CorreoElectronico = document.getElementById("correo").value;
		var FechaIngreso = document.getElementById("FechaIngreso").value;
		var FechaRetiro = document.getElementById("FechaRetiro").value;
		var FechaFallecimiento = document.getElementById("FechaFallecimiento").value;
		//Horarios de Trabajo
		var Desde =document.getElementById("hEntrada").value;
		var Hasta =document.getElementById("hSalida").value;
		var idTurno = $("#idTurno").val();

		console.log(NumeroDocumento);
		$.ajax({
			url: 'agregar.php',
			type: "POST",
			data:{
				opc:2,
				NumeroDocumento:NumeroDocumento,
				TipoDocumento:TipoDocumento,
				idCargos:idCargos,
				Pass:Pass,
				Activo:Activo,
				Nup:Nup,
				InstitucionPrevisional:InstitucionPrevisional,
				PrimerNombre:PrimerNombre,
				SegundoNombre:SegundoNombre,
				PrimerApellido:PrimerApellido,
				SegundoApellido:SegundoApellido,
				ApellidoCasada:ApellidoCasada,
				ConocidoPor:ConocidoPor,
				Nit:Nit,
				NumeroIsss:NumeroIsss,
				NumeroInpep:NumeroInpep,
				Genero:Genero,
				Nacionalidad:Nacionalidad,
				SalarioNominal:SalarioNominal,
				FechaNacimiento:FechaNacimiento,
				EstadoCivil:EstadoCivil,
				Direccion:Direccion,
				Departamento:Departamento,
				Municipio:Municipio,
				NumeroTelefonico:NumeroTelefonico,
				CorreoElectronico:CorreoElectronico,
				FechaIngreso:FechaIngreso,
				FechaRetiro:FechaRetiro,
				FechaFallecimiento:FechaFallecimiento,
				Desde:Desde,
				Hasta:Hasta,
				idTurno:idTurno
			},
			beforeSend:function(){
				console.log("NumeroDocumento: "+NumeroDocumento);
				respAlert("info","Actualizando Usuario...");
			},
			success: function(data){
				console.log(data);
				switch(data[0]){
					case "0":
						respAlert("warning","LLene completamente los datos con asterisco *: ");
					break;
					case "1":
						respAlert("warning","No se ha podido insertar a la BD");
					break;
					case "2":
						setTimeout(function(){
							respAlert("success","Correcto...redireccionando al inicio");
							redireccionar("verEmpleados.php");
						},1000);
					break;
					case "3":
						respAlert("warning","El horario de Entrada tiene que ser menor al de salida");
					break;
					case "4":
						respAlert("warning","El Tiempo tien que ser en formato de 24hrs ej:13:00:00 o 07:00:00");
					break;
					case "4":
						respAlert("warning","Ingrese Horario de Entrada y Horario de Salida");
					break;
				}
			},
			error: function(data){
				console.log(data);
				respAlert("danger","Error...");
			}
		});
		event.preventDefault();
	});


});

function prueba() {
	alert("Click");
}


function respAlert(tipoAlert, mensaje){
	var resp=document.getElementById("respuestaAlert");
	resp.innerHTML="<div class='alert alert-"+tipoAlert+" alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>"+mensaje+"</strong></div>";
}
function redireccionar(pagina){
	location.href=pagina;
}

function recargarPagina(pagina){
	window.location.reload(pagina);
}

function rmvAttr(idOb,atributo){
	$(idOb).removeAttr(atributo);
}

function addAttr(idOb,atributo, valor) {
	$(idOb).attr(atributo,valor);
}

function addClassAtrb(idOb,clase){
    $(idOb).addClass(clase);
}

function removeClassAtrb(idOb,clase) {
    $(idOb).removeClass(clase);
}

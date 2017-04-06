function load_js()
{
   var head= document.getElementsByTagName('head')[0];
   var script= document.createElement('script');
   script.type= 'text/javascript';
   script.src= '../js/main.js';
   head.appendChild(script);
}
function load_js_ajax(){
  var head= document.getElementsByTagName('head')[0];
  var script= document.createElement('script');
  script.type= 'text/javascript';
  script.src= '../js/ajax_Descuentos.js';
  head.appendChild(script);

}
//verificarPermiso
$("#datatables").on('click','#verificarPermiso',function(){
    // get the current row id
    var row = $(this).closest('tr');
    var idPermiso= row.find('.idPermiso').val();
        alert("INGRESO: id:"+idPermiso);
   //contenidoCambiante
   $.ajax({
       url: '../php/Insert_Ajax.php',
       type: 'POST',
       data: {
           opcAjax: 17,//12
           idPermiso: idPermiso
       },
       success: function(data) {
           var stringL = data.split(",");
           data=stringL[0];
           str=stringL[1];
           switch (data[0]) {
               case "0":
                   setTimeout(function() {
                     $("#contenidoCambiante").html(str);
                     $.getScript("../js/jquery.datepicker.js", function(){
                         load_js();
                         $("#labelBtnCargar" ).click(function() {
                           swal({
                             title: 'Su documento se ha comenzado a subir',
                             text: 'Espere unos segundos',
                             timer: 8000
                            }).then(
                              function () {},
                              // handling the promise rejection
                              function (dismiss) {
                                if (dismiss === 'timer') {
                                  console.log('I was closed by the timer')
                                }
                              }
                            );
                          });
                         window.onload = function() {
                           flagInput=0;
                           flagInput=document.getElementById("flaginput").value;
                         };


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


                      });
                    //respAlert("warning", "Error en ID: " + idTurno);
                  }, 200);
              break;
              case "1":
                  respAlert("warning", str);
                  setTimeout(function() {
                    redireccionar("../sistema/Descuentos.php");
                   //respAlert("warning", "Error en ID: " + idTurno);
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
//verificarAusencia
$("#datatables").on('click','#verificarAusencia',function(){
    // get the current row id
    var row = $(this).closest('tr');
    var idAusencia= row.find('.idAusencia').val();
   //contenidoCambiante
   $.ajax({
       url: '../php/Insert_Ajax.php',
       type: 'POST',
       data: {
           opcAjax: 12,
           idAusencia: idAusencia
       },
       success: function(data) {
           var stringL = data.split(",");
           data=stringL[0];
           str=stringL[1];
           switch (data[0]) {
               case "0":
                   setTimeout(function() {
                     $("#contenidoCambiante").html(str);
                     $.getScript("../js/jquery.datepicker.js", function(){
                         load_js();
                         $("#labelBtnCargar" ).click(function() {
                           swal({
                             title: 'Su documento se ha comenzado a subir',
                             text: 'Espere unos segundos',
                             timer: 8000
                            }).then(
                              function () {},
                              // handling the promise rejection
                              function (dismiss) {
                                if (dismiss === 'timer') {
                                  console.log('I was closed by the timer')
                                }
                              }
                            );
                          });
                         window.onload = function() {
                           flagInput=0;
                           flagInput=document.getElementById("flaginput").value;
                           if(flagInput==1){
                             swal({
                               title: "Documento Cargado",
                               text: "Su documento ha sido cargado correctamente",
                               type: "success",
                               confirmButtonClass: "btn-success",
                               confirmButtonText: "OK",
                               allowOutsideClick: false,
                               showLoaderOnConfirm: true,
                               preConfirm: function() {
                                 window.setTimeout(function(){ window.location = "Reporte_Horas_Extras.php"; },500);
                               }
                             })
                           }else if(flagInput==2) {
                             swal("Se subio el PDF, pero no se establecio la ruta, contacte a su proveedor");
                           }else{
                             swal("Solo puede subir archivos formato PDF");
                           }
                         };
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


                      });
                    //respAlert("warning", "Error en ID: " + idTurno);
                  }, 200);
              break;
              case "1":
                  respAlert("warning", str);
                  setTimeout(function() {
                    redireccionar("../sistema/Descuentos.php");
                   //respAlert("warning", "Error en ID: " + idTurno);
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

//verificarPermisoSeccional
$("#datatables").on('click','#verificarPermisoSeccional',function(){
    // get the current row id
    var row = $(this).closest('tr');
    var idPermisoSeccional= row.find('.idPermisoSeccional').val();
   //contenidoCambiante
   $.ajax({
       url: '../php/Insert_Ajax.php',
       type: 'POST',
       data: {
           opcAjax: 24,
           idPermisoSeccional: idPermisoSeccional
       },
       success: function(data) {
           var stringL = data.split(",");
           data=stringL[0];
           str=stringL[1];
           switch (data[0]) {
               case "0":
                   setTimeout(function() {
                     $("#contenidoCambiante").html(str);
                     $.getScript("../js/jquery.datepicker.js", function(){
                         load_js();
                         $("#labelBtnCargar" ).click(function() {
                           swal({
                             title: 'Su documento se ha comenzado a subir',
                             text: 'Espere unos segundos',
                             timer: 8000
                            }).then(
                              function () {},
                              // handling the promise rejection
                              function (dismiss) {
                                if (dismiss === 'timer') {
                                  console.log('I was closed by the timer')
                                }
                              }
                            );
                          });
                         window.onload = function() {
                           flagInput=0;
                           flagInput=document.getElementById("flaginput").value;
                           if(flagInput==1){
                             swal({
                               title: "Documento Cargado",
                               text: "Su documento ha sido cargado correctamente",
                               type: "success",
                               confirmButtonClass: "btn-success",
                               confirmButtonText: "OK",
                               allowOutsideClick: false,
                               showLoaderOnConfirm: true,
                               preConfirm: function() {
                                 window.setTimeout(function(){ window.location = "Permiso_seccional.php"; },500);
                               }
                             })
                           }else if(flagInput==2) {
                             swal("Se subio el PDF, pero no se establecio la ruta, contacte a su proveedor");
                           }else{
                             swal("Solo puede subir archivos formato PDF");
                           }
                         };
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


                      });
                    //respAlert("warning", "Error en ID: " + idTurno);
                  }, 200);
              break;
              case "1":
                  respAlert("warning", str);
                  setTimeout(function() {
                    redireccionar("../sistema/Descuentos.php");
                   //respAlert("warning", "Error en ID: " + idTurno);
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

        //verificarIncapacidad
        $("#datatables").on('click','#verificarIncapacidad',function(){
            // get the current row id
            var row = $(this).closest('tr');
            var idIncapacidad= row.find('.idIncapacidad').val();
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 7,
                   idIncapacidad: idIncapacidad
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#labelBtnCargar" ).click(function() {
                                   swal({
                                     title: 'Su documento se ha comenzado a subir',
                                     text: 'Espere unos segundos',
                                     timer: 8000
                                    }).then(
                                      function () {},
                                      // handling the promise rejection
                                      function (dismiss) {
                                        if (dismiss === 'timer') {
                                          console.log('I was closed by the timer')
                                        }
                                      }
                                    );
                                  });
                                 window.onload = function() {
                                   flagInput=0;
                                   flagInput=document.getElementById("flaginput").value;
                                   if(flagInput==1){
                                     swal({
                                       title: "Documento Cargado",
                                       text: "Su documento ha sido cargado correctamente",
                                       type: "success",
                                       confirmButtonClass: "btn-success",
                                       confirmButtonText: "OK",
                                       allowOutsideClick: false,
                                       showLoaderOnConfirm: true,
                                       preConfirm: function() {
                                         window.setTimeout(function(){ window.location = "Reporte_Horas_Extras.php"; },500);
                                       }
                                     })
                                   }else if(flagInput==2) {
                                     swal("Se subio el PDF, pero no se establecio la ruta, contacte a su proveedor");
                                   }else{
                                     swal("Solo puede subir archivos formato PDF");
                                   }
                                 };
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


                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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
        //modificarIncapacidad
        $("#datatables").on('click','#modificarIncapacidad',function(){
            // get the current row id
            var row = $(this).closest('tr');
            var idIncapacidad= row.find('.idIncapacidad').val();
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 6,
                   idIncapacidad: idIncapacidad
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TIncapacidad").on('change', function() {
                                   if(this.value==1){
                                     //es del isss
                                     document.getElementById( 'NomDIV' ).style.display = 'none';
                                     document.getElementById( 'NumDIV' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Clinica Particular
                                     document.getElementById( 'NomDIV' ).style.display = 'block';
                                     document.getElementById( 'NumDIV' ).style.display = 'block';
                                   }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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
        //modificarAusencia
        $("#datatables").on('click','#modificarAusencia',function(){
            // get the current row id
            var row = $(this).closest('tr');
            var idAusencia= row.find('.idAusencia').val();
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 11,
                   idAusencia: idAusencia
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TIncapacidad").on('change', function() {
                                   if(this.value==1){
                                     //es del isss
                                     document.getElementById( 'NomDIV' ).style.display = 'none';
                                     document.getElementById( 'NumDIV' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Clinica Particular
                                     document.getElementById( 'NomDIV' ).style.display = 'block';
                                     document.getElementById( 'NumDIV' ).style.display = 'block';
                                   }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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
        //modificarPermisoSeccional
        $("#datatables").on('click','#modificarPermisoSeccional',function(){
            // get the current row id
            var row = $(this).closest('tr');
            var idPermisoSeccional= row.find('.idPermisoSeccional').val();
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 23,
                   idPermisoSeccional: idPermisoSeccional
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TPermiso").on('change', function() {
                                   if(this.value==1){
                                     //Dia
                                     document.getElementById( 'DfehaIni' ).style.display = 'block';
                                     document.getElementById( 'Dfecha' ).style.display = 'none';
                                     document.getElementById( 'DhoraIni' ).style.display = 'none';
                                     document.getElementById( 'DhoraFin' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Horas
                                     document.getElementById( 'DfehaIni' ).style.display = 'none';
                                     document.getElementById( 'Dfecha' ).style.display = 'block';
                                     document.getElementById( 'DhoraIni' ).style.display = 'block';
                                     document.getElementById( 'DhoraFin' ).style.display = 'block';
                                    }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Permiso_seccional.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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

        //modificarPermiso
        $("#datatables").on('click','#modificarPermiso',function(){
            // get the current row id
            var row = $(this).closest('tr');
            var idPermiso= row.find('.idPermiso').val();
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 16,
                   idPermiso: idPermiso
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TPermiso").on('change', function() {
                                   if(this.value==1){
                                     //Dia
                                     document.getElementById( 'DfehaIni' ).style.display = 'block';
                                     document.getElementById( 'DfechaFin' ).style.display = 'block';
                                     document.getElementById( 'Dfecha' ).style.display = 'none';
                                     document.getElementById( 'DhoraIni' ).style.display = 'none';
                                     document.getElementById( 'DhoraFin' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Horas
                                     document.getElementById( 'DfehaIni' ).style.display = 'none';
                                     document.getElementById( 'DfechaFin' ).style.display = 'none';
                                     document.getElementById( 'Dfecha' ).style.display = 'block';
                                     document.getElementById( 'DhoraIni' ).style.display = 'block';
                                     document.getElementById( 'DhoraFin' ).style.display = 'block';
                                    }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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

        //agregar Ausencia
        $("#agregarAusencia").click(function() {
           // get the current row
           var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 9,
                   firstCell: firstCell
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TAusencia").on('change', function() {
                                   if(this.value==1){
                                     //sin justificacion
                                     document.getElementById( 'EDAusencia' ).style.display = 'block';
                                   }else if(this.value==2) {
                                     //Con justificacion
                                     document.getElementById( 'EDAusencia' ).style.display = 'none';
                                   }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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
        //agregarPermisoSeccional
        $("#agregarPermisoSeccional").click(function() {
           // get the current row
           var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 21,
                   firstCell: firstCell
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TPermiso").on('change', function() {
                                   if(this.value==1){
                                     //Dia
                                     document.getElementById( 'DfehaIni' ).style.display = 'block';
                                     document.getElementById( 'Dfecha' ).style.display = 'none';
                                     document.getElementById( 'DhoraIni' ).style.display = 'none';
                                     document.getElementById( 'DhoraFin' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Horas
                                     document.getElementById( 'DfehaIni' ).style.display = 'none';
                                     document.getElementById( 'Dfecha' ).style.display = 'block';
                                     document.getElementById( 'DhoraIni' ).style.display = 'block';
                                     document.getElementById( 'DhoraFin' ).style.display = 'block';
                                    }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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
        //agregar Permiso
        $("#agregarPermiso").click(function() {
           // get the current row
           var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 14,
                   firstCell: firstCell
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TPermiso").on('change', function() {
                                   if(this.value==1){
                                     //Dia
                                     document.getElementById( 'DfehaIni' ).style.display = 'block';
                                     document.getElementById( 'DfechaFin' ).style.display = 'block';
                                     document.getElementById( 'Dfecha' ).style.display = 'none';
                                     document.getElementById( 'DhoraIni' ).style.display = 'none';
                                     document.getElementById( 'DhoraFin' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Horas
                                     document.getElementById( 'DfehaIni' ).style.display = 'none';
                                     document.getElementById( 'DfechaFin' ).style.display = 'none';
                                     document.getElementById( 'Dfecha' ).style.display = 'block';
                                     document.getElementById( 'DhoraIni' ).style.display = 'block';
                                     document.getElementById( 'DhoraFin' ).style.display = 'block';
                                    }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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


				//agregar Incapacidad
        $("#agregarIncapacidad").click(function() {
           // get the current row
           var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
           //contenidoCambiante
           $.ajax({
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 2,
                   firstCell: firstCell
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 $("#TIncapacidad").on('change', function() {
                                   if(this.value==1){
                                     //es del isss
                                     document.getElementById( 'NomDIV' ).style.display = 'none';
                                     document.getElementById( 'NumDIV' ).style.display = 'none';
                                   }else if(this.value==2) {
                                     //Clinica Particular
                                     document.getElementById( 'NomDIV' ).style.display = 'block';
                                     document.getElementById( 'NumDIV' ).style.display = 'block';
                                   }else {
                                     respAlert("warning", "ERROR Refescando la pagina");
                                     setTimeout(function() {
                                       redireccionar("../sistema/Descuentos.php");
                                      //respAlert("warning", "Error en ID: " + idTurno);
                                     }, 1000);
                                   }
                                 });
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("../sistema/Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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



				//previous
				$("#previous").on('click',function(){
           // get the current row
           //contenidoCambiante
           window.location.replace("Descuentos.php");
				 });
         //previousPermisoS
         $("#previousPermisoS").on('click',function(){
            // get the current row
            //contenidoCambiante
            window.location.replace("Permiso_seccional.php");
 				 });

         //btnAusencia
         $("#datatables").on('click','#btnAusencia',function(){
             // get the current row id
            var row = $(this).closest('tr');
            var firstCell= row.find('.NumeroDocumento').val();
             //contenidoCambiante
             $.ajax({
                 cache: false,
                 url: '../php/Insert_Ajax.php',
                 type: 'POST',
                 data: {
                     opcAjax: 8,
                     firstCell: firstCell
                 },
                 success: function(data) {
                     var stringL = data.split(",");
                     data=stringL[0];
                     str=stringL[1];
                     switch (data[0]) {
                         case "0":
                             setTimeout(function() {
                               $("#contenidoCambiante").html(str);
                               $.getScript("../js/jquery.datepicker.js", function(){
                                   load_js();
                                   load_js_ajax();
                                });
                              //respAlert("warning", "Error en ID: " + idTurno);
                            }, 200);
                        break;
                        case "1":
                            respAlert("warning", str);
                            setTimeout(function() {
                              redireccionar("Descuentos.php");
                             //respAlert("warning", "Error en ID: " + idTurno);
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

          //btnPermisoSeccional
          $("#datatables").on('click','#btnPermisoSeccional',function(){
              // get the current row id
             var row = $(this).closest('tr');
             var firstCell= row.find('.NumeroDocumento').val();
              //contenidoCambiante
              $.ajax({
                  cache: false,
                  url: '../php/Insert_Ajax.php',
                  type: 'POST',
                  data: {
                      opcAjax: 20,
                      firstCell: firstCell
                  },
                  success: function(data) {
                      var stringL = data.split(",");
                      data=stringL[0];
                      str=stringL[1];
                      switch (data[0]) {
                          case "0":
                              setTimeout(function() {
                                $("#contenidoCambiante").html(str);
                                $.getScript("../js/jquery.datepicker.js", function(){
                                    load_js();
                                    load_js_ajax();
                                 });
                               //respAlert("warning", "Error en ID: " + idTurno);
                             }, 200);
                         break;
                         case "1":
                             respAlert("warning", str);
                             setTimeout(function() {
                               redireccionar("Permiso_seccional.php");
                              //respAlert("warning", "Error en ID: " + idTurno);
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

         //btnIncapacidad
         $("#datatables").on('click','#btnIncapacidad',function(){
             // get the current row id
            var row = $(this).closest('tr');
            var firstCell= row.find('.NumeroDocumento').val();
             //contenidoCambiante
             $.ajax({
                 cache: false,
                 url: '../php/Insert_Ajax.php',
                 type: 'POST',
                 data: {
                     opcAjax: 5,
                     firstCell: firstCell
                 },
                 success: function(data) {
                     var stringL = data.split(",");
                     data=stringL[0];
                     str=stringL[1];
                     switch (data[0]) {
                         case "0":
                             setTimeout(function() {
                               $("#contenidoCambiante").html(str);
                               $.getScript("../js/jquery.datepicker.js", function(){
                                   load_js();
                                   load_js_ajax();
                                });
                              //respAlert("warning", "Error en ID: " + idTurno);
                            }, 200);
                        break;
                        case "1":
                            respAlert("warning", str);
                            setTimeout(function() {
                              redireccionar("Descuentos.php");
                             //respAlert("warning", "Error en ID: " + idTurno);
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

          //btnPermiso
          $("#datatables").on('click','#btnPermiso',function(){
              // get the current row id
             var row = $(this).closest('tr');
             var firstCell= row.find('.NumeroDocumento').val();
              //contenidoCambiante
              $.ajax({
                  cache: false,
                  url: '../php/Insert_Ajax.php',
                  type: 'POST',
                  data: {
                      opcAjax: 13,
                      firstCell: firstCell
                  },
                  success: function(data) {
                      var stringL = data.split(",");
                      data=stringL[0];
                      str=stringL[1];
                      switch (data[0]) {
                          case "0":
                              setTimeout(function() {
                                $("#contenidoCambiante").html(str);
                                $.getScript("../js/jquery.datepicker.js", function(){
                                    load_js();
                                    load_js_ajax();
                                 });
                               //respAlert("warning", "Error en ID: " + idTurno);
                             }, 200);
                         break;
                         case "1":
                             respAlert("warning", str);
                             setTimeout(function() {
                               redireccionar("Descuentos.php");
                              //respAlert("warning", "Error en ID: " + idTurno);
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

          //Ver ausencia
          $("#verAusencia").click(function() {
             // get the current row
             var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
             //contenidoCambiante
             $.ajax({
                 cache: false,
                 url: '../php/Insert_Ajax.php',
                 type: 'POST',
                 data: {
                     opcAjax: 10,
                     firstCell: firstCell
                 },
                 success: function(data) {
                     var stringL = data.split(",");
                     data=stringL[0];
                     str=stringL[1];
                     switch (data[0]) {
                         case "0":
                             setTimeout(function() {
                               $("#contenidoCambiante").html(str);
                               $.getScript("../js/jquery.datepicker.js", function(){
                                   load_js();
                                   load_js_ajax();
                                });
                              //respAlert("warning", "Error en ID: " + idTurno);
                            }, 200);
                        break;
                        case "1":
                            respAlert("warning", str);
                            setTimeout(function() {
                              redireccionar("Descuentos.php");
                             //respAlert("warning", "Error en ID: " + idTurno);
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
          //Ver Permiso Seccional
          $("#verPermisoSeccional").click(function() {
             // get the current row
             var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
             //contenidoCambiante
             $.ajax({
                 cache: false,
                 url: '../php/Insert_Ajax.php',
                 type: 'POST',
                 data: {
                     opcAjax: 22,
                     firstCell: firstCell
                 },
                 success: function(data) {
                     var stringL = data.split(",");
                     data=stringL[0];
                     str=stringL[1];
                     switch (data[0]) {
                         case "0":
                             setTimeout(function() {
                               $("#contenidoCambiante").html(str);
                               $.getScript("../js/jquery.datepicker.js", function(){
                                   load_js();
                                   load_js_ajax();
                                });
                              //respAlert("warning", "Error en ID: " + idTurno);
                            }, 200);
                        break;
                        case "1":
                            respAlert("warning", str);
                            setTimeout(function() {
                              redireccionar("Descuentos.php");
                             //respAlert("warning", "Error en ID: " + idTurno);
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
          //Ver Permiso
          $("#verPermiso").click(function() {
             // get the current row
             var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
             //contenidoCambiante
             $.ajax({
                 cache: false,
                 url: '../php/Insert_Ajax.php',
                 type: 'POST',
                 data: {
                     opcAjax: 15,
                     firstCell: firstCell
                 },
                 success: function(data) {
                     var stringL = data.split(",");
                     data=stringL[0];
                     str=stringL[1];
                     switch (data[0]) {
                         case "0":
                             setTimeout(function() {
                               $("#contenidoCambiante").html(str);
                               $.getScript("../js/jquery.datepicker.js", function(){
                                   load_js();
                                   load_js_ajax();
                                });
                              //respAlert("warning", "Error en ID: " + idTurno);
                            }, 200);
                        break;
                        case "1":
                            respAlert("warning", str);
                            setTimeout(function() {
                              redireccionar("Descuentos.php");
                             //respAlert("warning", "Error en ID: " + idTurno);
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

				//Ver incapacidad
        $("#verIncapacidad").click(function() {
           // get the current row
           var firstCell = document.getElementById("NumeroDocumento").value; //NumeroDocumento
           //contenidoCambiante
           $.ajax({
               cache: false,
               url: '../php/Insert_Ajax.php',
               type: 'POST',
               data: {
                   opcAjax: 3,
                   firstCell: firstCell
               },
               success: function(data) {
                   var stringL = data.split(",");
                   data=stringL[0];
                   str=stringL[1];
                   switch (data[0]) {
                       case "0":
                           setTimeout(function() {
                             $("#contenidoCambiante").html(str);
                             $.getScript("../js/jquery.datepicker.js", function(){
                                 load_js();
                                 load_js_ajax();
                              });
                            //respAlert("warning", "Error en ID: " + idTurno);
                          }, 200);
                      break;
                      case "1":
                          respAlert("warning", str);
                          setTimeout(function() {
                            redireccionar("Descuentos.php");
                           //respAlert("warning", "Error en ID: " + idTurno);
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


//TABLA
        $(document).ready(function() {
          var table = $('#datatables').DataTable();

          $('.card .material-datatables label').addClass('form-group');

          $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            responsive: true,
            language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            },
            destroy: true
          });


        });
